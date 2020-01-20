<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\User;
use Illuminate\Support\Facades\Mail;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $topPics = Photo::orderBy('likes_sum', 'desc')
            ->take(3)
            ->get();
        $recentPics = Photo::orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        $topUsers = DB::table('users')
            ->select('photos.user_id', DB::raw('count(*) as total_photos'))
            ->join('photos', 'users.user_id', '=', 'photos.user_id')
            ->groupBy('photos.user_id')
            ->orderBy('total_photos', 'desc')
            ->take(3)
            ->get();
        // dd($topUsers);
        return view(
            'home',
            ['topPics' => $topPics,
            'recentPics' => $recentPics,
            'topUsers' => $topUsers]
        );
    }
}
