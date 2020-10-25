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
     $user->password=$hashed = Hash::make($request->input('password'));
     $user->save();
      return response()->json($data = array('message' =>'Your Registratin Successfully'));
  }
}
