<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use App\User;
use App\Photo;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        
        $reportedPhotos = DB::table('photos')->distinct()
            ->leftJoin('users', 'photos.user_id', '=', 'users.user_id')
            ->leftJoin('locations', 'photos.locality_id', '=', 'locations.locality_id')
            ->leftJoin('categories', 'photos.category_id', '=', 'categories.category_id')
            ->leftJoin('likes', 'photos.photo_id', '=', 'likes.photo_id')
            ->select('photos.photo_id as photo_id', 'users.user_id as user_id', 'users.name as user', 'photos.image_title', 'photos.image_URL as image_URL','likes.islike as islike', 'locations.locality_name as locality', 'categories.category_name as category')
            ->where('likes.islike', '=', 0)
            ->get();
        
        return view('admin', [
            'users' => $users,
            'reportedPhotos' => $reportedPhotos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $photos = Photo::where('user_id', '=', $user_id)->get();
        $user = User::find($user_id);

        return view('admin-deleteUser', [
            'photos' => $photos,
            'user' => $user
        ]);  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        /* $article = Article::find($id);
        $article->delete($id); */
        //* OR
        /* User::destroy($user_id);
        return view('admin', [
            'status', 'SUCCES: '
        ]); */
        $user = User::find($user_id);
        $userFolder = 'uploads/' . $user_id;
        $userPhoto = $user->user_photo;
        $userPhotoDefault = strstr($user->user_photo, 'default_user');

        $userDeleted = DB::table("users")->where("user_id", $user_id)->delete();


        if($userDeleted) {
            if(File::exists($userFolder)) 
                File::deleteDirectory($userFolder);
            
            if(File::exists($userPhoto) && $userPhotoDefault == false)   
                File::delete($userPhoto);
        } else {
            return redirect('admin')->with([
                'status' => 'ERROR: User & related files.',
                'class' => 'alert alert-danger alert-dismissible fade show',
            ]);
        }
        
        return redirect('admin')->with([
            'status' => 'SUCCESS: User & related files deleted successfully.',
            'class' => 'alert alert-success alert-dismissible fade show',
        ]);
    }

    public function deletePhoto(Request $request) {
                
        Photo::destroy($request->photo_id);

        if(File::exists($request->image_URL))   
                File::delete($request->image_URL);

        return redirect('admin')->with([
            'status' => 'SUCCESS: Reported photo deleted successfully.',
            'class' => 'alert alert-success alert-dismissible fade show',
        ]);
    }
}
