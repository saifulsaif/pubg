<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use\DB;
use\Hash;
use App\User;

class HomeController extends Controller
{
  public function getPartners(){
    $partners = DB::table('partners')->get();
    return response()->json($partners);
  }
  public function banner(){
    $app_id = request('app_id');
    $banner = DB::table('partners')
               ->where('app_id',$app_id)
               ->get();
    return response()->json($banner);
  }
  public function clear_waiting_list(){
     DB::table('waiting_lists')->delete();
    return response()->json(array('message' =>'data clear successfully!'));
  }
  public function getSliders(){
    $sliders = DB::table('sliders')->get();
    return response()->json($sliders);
  }
  public function registration(Request $request)
  {
    $img=asset('/images/user/user.jpg');
     $user = new User;
     $user->name=$request->input('user_name');
     $user->email=$request->input('phone');
     $user->phone=$request->input('email');
     $user->image=$img;
     $user->app_id=$request->input('app_id');
     $user->role='user';
     $user->active_status='0';
     $user->password=$hashed = Hash::make($request->input('password'));
      $user->save();
      DB::table('partials')
                 ->insert([
                  'user_id' => $user->id,
                  'purchase' => '0',
                 'point' => '0',
                 'favorite' => '0']);
     $data['success'] = 1;
     $data['message'] = "You have Registration Successfully!";
     return $data;
  }
}
