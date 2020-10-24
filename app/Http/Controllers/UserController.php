<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use\setting;
use App\Slider;
use App\Photo;
use App\Tag;
use App\Profile;
use App\Follower;
use\DB;
class UserController extends Controller
{
  public function updateProfile(){
    $user_id=Auth::user()->id;
    $settings = DB::table('settings')->find('1');
    $photos = DB::table('photos')->where('user_id',$user_id)->get();
    $profile = Profile::where('user_id',$user_id)->first();
    return view('fontend.update_profile',compact('settings','photos','profile'));
  }
  public function updateProfileInfo(Request $request)  {

    $user_id=Auth::user()->id;
    $image=$request->file('photo');
    if ($image) {
      $image_name = $image->getClientOriginalName();
      $upload_path = 'images/photo/';
      $image->move($upload_path, $image_name);
      $image_url = $upload_path.$image_name;
      $data['photo'] = $image_url;
      $data['first_name'] = $request->first_name;
      $data['last_name'] = $request->last_name;
      $data['facebook'] = $request->facebook;
      $data['twitter'] = $request->twitter;
      $data['youtube'] = $request->youtube;
      $data['linkin'] = $request->linkin;
      $data['email'] = $request->email;
      $data['number'] = $request->number;
      $data['description'] = $request->description;
      Profile::where('user_id',$user_id)->update($data);
    }else{
      $data['first_name'] = $request->first_name;
      $data['last_name'] = $request->last_name;
      $data['facebook'] = $request->facebook;
      $data['twitter'] = $request->twitter;
      $data['youtube'] = $request->youtube;
      $data['linkin'] = $request->linkin;
      $data['email'] = $request->email;
      $data['number'] = $request->number;
      $data['description'] = $request->description;
      Profile::where('user_id',$user_id)->update($data);
    }
    session()->flash('success','Profile Update Successfully!');
    return back();
  }
   public function savePhoto(Request $request)  {
    // return $request->all();
    $user_id=Auth::user()->id;
    $image=$request->file('photo');
    if ($image) {
      $image_name = $image->getClientOriginalName();
      $upload_path = 'images/photo/';
      $image->move($upload_path, $image_name);
      $image_url = $upload_path.$image_name;
      $photo = new Photo;
      $photo->photo=$image_url;
      $photo->title=$request->title;
      $photo->category_id=$request->category_id;
      $photo->user_id=$user_id;
      $photo->save();
      $tag=$request->tag;
       foreach ($tag as $key => $n) {
        
        DB::table('tags')->insert(
            ['tag' => $n, 'photo_id' =>$photo->id]
        );
       }
    }
    DB::table('Points')
    ->where('user_id', Auth::user()->id)
    ->increment('point',50);
     session()->flash('success','Photo Save Successfully!');
    return back();
  }
  public function deletePhoto($id){
    $photo = Photo::find($id);
    if(file_exists($photo->photo)){
      @unlink($photo->photo);
      }
     if(!is_null($photo)){
       $photo->delete();
     }
     session()->flash('danger','Photo Delete Successfully!');
     return back();
  }
  public function userProfile($user_id){
    $settings = DB::table('settings')->find('1');
    $photos = DB::table('photos')->where('user_id',$user_id)->get();
     $profile = Profile::where('user_id',$user_id)->first();
    return view('fontend.profile',compact('settings','photos','profile'));
  }
}
