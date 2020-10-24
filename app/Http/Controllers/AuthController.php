<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class AuthController extends Controller
{
  /**
 * Create a new AuthController instance.
 *
 * @return void
 */
public function __construct()
{
    $this->middleware('auth:api', ['except' => ['login']]);
}

/**
 * Get a JWT via given credentials.
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function login()
{
    $credentials = request(['email', 'password']);

    if ( $token = auth()->guard()->attempt($credentials)) {
    $data['success'] = 1;
    $data['message'] = "You have Signed in Successfully!";
    $data['loginInfo'] = [array("api_token" => $token,"token_type" => 'Bearer',"user_id"=>auth()->user()->id,"type"=>auth()->user()->role)];
    }else{
      $data['success'] = 0;
      $data['message'] = "Invalid Login Credentials";
      $data['data'] = [ ];
    }
  return $data;
}

/**
 * Get the authenticated User.
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function me()
{
    return response()->json(auth()->user());
}
public function profile(Request $request)
{
   $info=auth()->user();
   $user_id=$request->input('user_id');
   $profile_info = DB::table('profiles')
                  ->where('user_id',$user_id)
                  ->get();
    return response()->json($profile_info);
}
public function contact(Request $request)
{
   $user_id=$request->input('type');
  if($user_id=='user'){
     $contact_info = DB::table('users')
                  ->where('role','admin')
                  ->paginate(10);
    return response()->json($contact_info);
  }else{
     $contact_info = DB::table('users')
                  ->where('role','user')
                  ->paginate(10);
    return response()->json($contact_info);
  }
}

/**
 * Log the user out (Invalidate the token).
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function logout()
{
    auth()->guard('api')->logout();

    return response()->json(['message' => 'Successfully logged out']);
}

/**
 * Refresh a token.
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function refresh()
{
    return $this->respondWithToken(auth()->refresh());
}

/**
 * Get the token array structure.
 *
 * @param  string $token
 *
 * @return \Illuminate\Http\JsonResponse
 */
protected function respondWithToken($token)
{
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60
    ]);
}
}
