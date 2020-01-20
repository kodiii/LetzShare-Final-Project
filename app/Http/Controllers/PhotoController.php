<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auth;
use App\Location;
use App\Category;
use App\Photo;
use App\User;
use App\Like;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Show only photos that users already have,
            else it will not show the user */
        $users = DB::table('users')
            ->join('photos', 'photos.user_id', '=', 'users.user_id')
            ->select('users.*')
            ->distinct()
            ->get();

        /* Show only photos that have locations assigned */
        $locations = DB::table('locations')
            ->join('photos', 'photos.locality_id', '=', 'locations.locality_id')
            ->select('locations.*')
            ->distinct()
            ->get();

        /* Show only photos that have categories assigned */
        $categories = DB::table('categories')
            ->join('photos', 'photos.category_id', '=', 'categories.category_id')
            ->select('categories.*')
            ->distinct()
            ->get();

        /* Show all photos by descente date order */
        $photos = DB::table('photos')
            ->join('users', 'users.user_id', '=', 'photos.user_id')
            ->join('locations', 'locations.locality_id', '=', 'photos.locality_id')
            ->join('categories', 'categories.category_id', '=', 'photos.category_id')
            ->select('photos.*', 'users.name', 'users.user_photo', 'locations.locality_name', 'categories.category_icon', 'categories.category_name')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('gallery', [
            'photos' => $photos,
            'users' => $users,
            'locations' => $locations,
            'categories' => $categories
        ]);
    }

    public function filters(Request $request)
    {
        /* Show only photos that users already have,
            else it will not show the user */
        $users = DB::table('users')
            ->join('photos', 'photos.user_id', '=', 'users.user_id')
            ->select('users.*')
            ->distinct()
            ->get();

        /* Show only photos that have locations assigned */
        $locations = DB::table('locations')
            ->join('photos', 'photos.locality_id', '=', 'locations.locality_id')
            ->select('locations.*')
            ->distinct()
            ->get();
        /* Show only photos that have categories assigned */
        $categories = DB::table('categories')
            ->join('photos', 'photos.category_id', '=', 'categories.category_id')
            ->select('categories.*')
            ->distinct()
            ->get();

        // Show the filter query
        $photos = DB::table('photos')
            ->join('users', 'users.user_id', '=', 'photos.user_id')
            ->join('locations', 'locations.locality_id', '=', 'photos.locality_id')
            ->join('categories', 'categories.category_id', '=', 'photos.category_id')
            ->select('photos.*', 'users.name', 'users.user_photo', 'locations.locality_name', 'categories.category_icon', 'categories.category_name')
            ->orWhere('photos.user_id', $request->users)
            ->orWhere('photos.locality_id', $request->locations)
            ->orWhere('photos.category_id', $request->categories)
            ->orWhereBetween('photos.created_at', [$request->firstdate, $request->lastdate])
            ->get();

        return view('gallery', [
            'photos' => $photos,
            'users' => $users,
            'locations' => $locations,
            'categories' => $categories
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create() //upload photo -> display
    {
        $categories = Category::all();
        $locations = Location::all();

        return view('uploadphoto', ['categories' => $categories, 'locations' => $locations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //save photo
    {
        $validatedData = \Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|min:4|max:30',
            'description' => 'required|min:5|max:250',
            'locality' => 'required',
            'category' => 'required'
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()]);
        } else {
            $userId = Auth::user()->user_id;
            $imageName = $userId . '_0.' . request()->image->getClientOriginalExtension();

            //create a folder if doesn't exists
            if (!file_exists("uploads/$userId")) {
                mkdir("uploads/$userId", 0755, true);
            }

            //change name file while name file already exists
            if (file_exists("uploads/$userId/$imageName")) {
                $i = 0;
                do {
                    $imageName = $userId . "_" . $i . '.' . request()->image->getClientOriginalExtension();
                    $i++;
                } while (file_exists("uploads/$userId/$imageName"));
            }
            //save image in the folder
            request()->image->move(public_path("uploads/$userId"), $imageName);

            //save data in database
            $photo = new Photo();
            $photo->image_title = $request->title;
            $photo->image_URL = "uploads/$userId/$imageName";
            $photo->image_description = $request->description;
            $photo->category_id = Input::get('category');
            $photo->locality_id = Input::get('locality');
            $photo->user_id = $userId;
            $photo->likes_sum = 0;
            $photo->save();

            return response()->json(['success' => 'Congratulations, your photo was uploaded successfully!', 'url' => $photo->image_URL]);
        }
    }

    public function photoLikePhoto(Request $request)
    {
        // collect data from POST
        $photo_id = $request['photoId'];
        $is_like = $request['isLiked'] === 'true';
        $update = false;
        $photo = Photo::find($photo_id);
        // check if photo exists
        if (!$photo) {
            return null;
        }
        // check if user has already liked photo
        $user = Auth::user();
        $like = $user->likes()->where('photo_id', $photo_id)->first();
        // if yes, remove the like from the table
        if ($like) {
            $already_like = $like->islike;
            $update = true;
            // if current like status in table
            if ($already_like == $is_like) {
                $like->delete();
                $count = count($photo->likes);
                $photo->likes_sum = $count;
                $photo->update();
                echo $count;
                return;
            }
            // if not already liked, create a new like
        } else {
            $like = new Like();
        }
        // make $like parameters equal to the values retrieved from POST
        $like->islike = $is_like;
        $like->user_id = $user->user_id;
        $like->photo_id = $photo_id;
        // if like already exists, update, if not create new
        if ($update) {
            $like->update();
        } else {
            $like->save();
        }
        $count = count($photo->likes);
        $photo->likes_sum = $count;
        $photo->update();
        echo $count;
        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
