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
 {  $credentials = request(['email', 'password']);

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
public function me(){
    return response()->json(auth()->user());
}
public function profile(Request $request){
  $info=auth()->user();
 $user_id=$request->get('user_id');
 $profile_info = DB::table('users')
                ->where('id',$user_id)
                ->select('id','name','email as phone','phone as email','image','role','app_id')
                ->first();
  return response()->json($profile_info);
}
public function messageList(Request $request){
  $info=auth()->user();
 $user_id=$request->get('user_id');
 $profile_info = DB::table('users')
                ->where('id',$user_id)
                ->select('id','name','email as phone','phone as email','image','role','app_id')
                ->first();
  return response()->json($profile_info);
}
public function profileUpdate(Request $request){
 $user_id=$request->get('user_id');
 $name=$request->get('name');
 $email=$request->get('email');
 $phone=$request->get('phone');
 DB::table('users')
            ->where('id', $user_id)
            ->update(['name' => $name,'email' => $email,'phone' => $phone]);
  $data['success'] = 1;
  $data['message'] = "Profile Update Successfully!";
  return $data;
}

public function updateDeviceID(Request $request){
 $user_id=$request->get('user_id');
 $reg_id=$request->get('reg_id');
 DB::table('users')
            ->where('id', $user_id)
            ->update(['device_token' => $reg_id]);
  $data['success'] = 1;
  $data['message'] = "Device Token Update Successfully!";
  return $data;
}
public function contact(Request $request){
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
public function senderMessage(Request $request){
   $user_id=$request->input('user_id');
     $sender_message = DB::table('messages')
                  ->where('sender_id',$user_id)
                  ->get();
    return response()->json($user_id);
}

public function send(Request $request){
  $message="it's work";
  $fields = array(
           'to' => $request->get('reg_id'),
           'data' => $data = array('message' => 'hello' ),
       );

       return $this->sendPushNotification($fields);
}
private function sendPushNotification($fields) {

       //firebase server url to send the curl request
       $url = 'https://fcm.googleapis.com/fcm/send';

       //building headers for the request
       $headers = array(
           'Authorization: key=AAAAq-0EXCU:APA91bEOrpi96-MqymxVqfxgB-AcVa-WN1JumGgV2SzC-vMfUW3u8AP1QR2bW1T0nWXhh7A7KCCOg_-OcInIaXDIA1318aK_qN_9TTSfUl6UgQOTmsRNFUhOvKV5JDERTgi4a6saqy_8',
           'Content-Type: application/json'
       );

       //Initializing curl to open a connection
       $ch = curl_init();

       //Setting the curl url
       curl_setopt($ch, CURLOPT_URL, $url);

       //setting the method as post
       curl_setopt($ch, CURLOPT_POST, true);

       //adding headers
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

       //disabling ssl support
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

       //adding the fields in json format
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

       //finally executing the curl request
       $result = curl_exec($ch);
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }

       //Now close the connection
       curl_close($ch);

       //and return the result
       return $result;
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
