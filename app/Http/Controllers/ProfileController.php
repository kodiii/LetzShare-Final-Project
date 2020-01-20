<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\User;
use File;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Location;
use Illuminate\Support\Facades\Input;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $userPhotos = DB::table('users')
            ->leftjoin('photos', 'users.user_id', '=', 'photos.user_id')
            ->leftjoin('locations', 'locations.locality_id', '=', 'photos.locality_id')
            ->leftjoin('categories', 'categories.category_id', '=', 'photos.category_id')
            ->where('users.user_id', $id)
            ->select('photos.*', 'photos.created_at as photodate', 'users.*', 'locations.*', 'categories.*')
            ->orderby('photodate', 'desc')
            ->simplePaginate(12);
            $categories = Category::all();
            $locations = Location::all();


        return view('userprofile', ['userPhotos' => $userPhotos, 'categories' => $categories, 'locations' => $locations]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validatedData = \Validator::make($request->all(), [
            'name' => 'required|min:4|max:20|',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()]);
        } else {
            $user = User::find($id);
            $user->name = $request->name;
            $user->save();
            return response()->json(['success' => 'successiful entered', 'name' => $user->name]);
        }
    }

/*edit user description*/
    public function description(Request $request, $id)
    {
        $validatedData = \Validator::make($request->all(), [
            'description' => 'required|min:4|max:200|',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()]);
        } else {
            $user = User::find($id);
            $user->user_description = $request->description;
            $user->save();
            return response()->json(['success' => 'successiful entered', 'description' => $user->user_description]);
        }
    }

    /*change user photo*/
    public function changePhoto(Request $request, $id)
    {
        $validatedData = \Validator::make($request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validatedData->fails()){

            $errors = $validatedData->errors()->all();

            $string='';
            foreach ($errors as $value){
            $string .=  $value .' ';
            }
            return redirect('userprofile/' . $id)->with(['status' => $string,
            'class' => 'alert alert-danger alert-dismissible fade show']);

        }else{

            $user = User::find($id);
            $imageName ="uploads/users/". $id . '.' . request()->image->getClientOriginalExtension();

            $destinationPath = $user->user_photo;
            File::delete($destinationPath);
            request()->image->move(public_path("uploads/users"), $imageName);
            $user->user_photo = $imageName;
            $user->save();
            return redirect('userprofile/' . $id)->with([
                'status' => "SUCCESS: profile photo changed successfully.",
                'class' => 'alert alert-success alert-dismissible fade show',
            ]);;
        }
    }

    /*edit user location*/
    public function location(Request $request, $id)
    {
        $validatedData = \Validator::make($request->all(), [
            'location' => 'required|min:3|max:30|',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()]);
        } else {
            $user = User::find($id);
            $user->user_location = $request->location;
            $user->save();
            return response()->json(['success' => 'successiful entered', 'location' => $user->user_location]);
        }
    }

/*edit photo details*/
    public function photoDetails(Request $request, $id)
    {
        $userId = Auth::user()->user_id;

        $validatedData = \Validator::make($request->all(), [
            'title'=> 'required|min:3|max:30|',
            'image_description' => 'required|min:5|max:250|',
            'locality' => 'required',
            'category' =>'required'
        ]);
        if ($validatedData->fails()) {
            $errors = $validatedData->errors()->all();

            $string='';
            foreach ($errors as $value){
            $string .=  $value .' ';
            }
            return redirect('userprofile/' . $userId )->with(['status' => "$string",
            'class' => 'alert alert-danger alert-dismissible fade show']);
        } else {
            $photo = Photo::find($id);
            $photo->image_title = $request->title;
            $photo->image_description = $request->image_description;
            $photo->category_id = Input::get('category');
            $photo->locality_id = Input::get('locality');
            $photo->save();
            return redirect('userprofile/' . $userId )->with([
                'status' => "SUCCESS: $request->title edited successfully.",
                'class' => 'alert alert-success alert-dismissible fade show',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /*delete user photo */
    public function destroy($id)
    {

        $photo = Photo::find($id);
        $idUser = $photo["user_id"];
            if(File::exists($photo["image_URL"])){
                File::delete($photo["image_URL"]);
            }

            Photo::destroy($id);

            return redirect('userprofile/' . $idUser )->with([
                'status' => 'SUCCESS: Photo deleted successfully.',
                'class' => 'alert alert-success alert-dismissible fade show',
            ]);
    }

/*Delete user account by own user*/
public function deleteAccount($id)
    {
        $user = User::find($id);
        $userFolder = 'uploads/' . $id;
        $userPhoto = $user->user_photo;
        $userPhotoDefault = strstr($user->user_photo, 'default_user');

        $userDeleted = DB::table("users")->where("user_id", $id)->delete();


        if($userDeleted) {
            if(File::exists($userFolder))
                File::deleteDirectory($userFolder);

            if(File::exists($userPhoto) && $userPhotoDefault == false)
                File::delete($userPhoto);
        } else {
            return redirect('/userprofile/'.$id)->with([
                'status' => 'ERROR: User & related files.',
                'class' => 'alert alert-danger alert-dismissible fade show',
            ]);
        }

        return redirect('/')->with([
            'status' => 'SUCCESS: User & related files deleted successfully.',
            'class' => 'alert alert-success alert-dismissible fade show',
        ]);
    }
/*end of delete user account by own user*/

}
