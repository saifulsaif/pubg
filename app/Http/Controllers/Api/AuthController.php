<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Message;
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

    if (! $token = auth()->guard()->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    return $this->respondWithToken($token);
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
public function activeUsers(Request $request){
   $app_id=$request->input('app_id');
   $active_users = DB::table('users')
                  ->where('app_id',$app_id)
                  ->where('role','user')
                  ->orderBy('active_status','DESC')
                  ->select('id as user_id','name','image','active_status')
                  ->paginate(20);
    return response()->json($active_users);
}
public function getMessage(Request $request){
  $sender_id=$request->input('sender_id');
  $reciver_id=$request->input('reciver_id');
  $app_id=$request->input('app_id');
   $message = DB::table('messages')
                  ->where('app_id',$app_id)
                  ->where('sender_id',$sender_id)
                  ->where('reciver_id',$reciver_id)
                  ->orwhere('sender_id',$reciver_id)
                  ->where('reciver_id',$sender_id)
                  ->get();
    return response()->json($message);
}
public function sendMessage(Request $request){
  $sender_id=$request->input('sender_id');
  $reciver_id=$request->input('reciver_id');
  $message=$request->input('message');
  $type=$request->input('type');
  $app_id=$request->input('app_id');
  DB::table('messages')
             ->insert(['sender_id' => $sender_id,
             'sender_id' => $sender_id,
             'reciver_id' => $reciver_id,
             'message' => $message,
             'type' => $type,
             'seen' => '1',
             'created_at' => date('Y-m-d h:i:s'),
             'app_id' => $app_id]);
  $device_token= DB::table('users')
              ->where('id', $reciver_id)
              ->select('device_token')
              ->first();

  $sender_name= DB::table('users')
              ->where('id', $sender_id)
              ->select('name')
              ->first();
    $message_body=$sender_name->name;
   $fields = array(
          'to' => $device_token->device_token,
          'data' => $data = array('message' => $message_body ),
      );

      return $this->sendPushNotification($fields);
}
private function sendPushNotification($fields) {

       //firebase server url to send the curl request
       $url = 'https://fcm.googleapis.com/fcm/send';

       //building headers for the request
       $headers = array(
           'Authorization: key=AAAAtrMq4LU:APA91bH4KDlSeQ_pcT7PWE4HTWKiLkaDWVlOjm_ukZ0yDUsY1YJAtCsILZRbd-Acev1-ecznOgiBzMVIcG5HN1Qg0XadFtHJziiQHQDF5i6cmPHCAxNoF4o8JXw5DwaLW-5eI-SmnBSg',
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
public function messageList(Request $request){
  $user_id=$request->input('user_id');
  $sub = Message::orderBy('created_at','asc');
  $chats = DB::table(DB::raw("({$sub->toSql()}) as sub"))
      ->where('sender_id',$user_id)
      ->orwhere('reciver_id',$user_id)
      ->groupBy('reciver_id')
      ->orderBy('id','DESC')
      ->select('reciver_id as user_id','message','seen','app_id','created_at')
      ->get();
      $data = array();
      foreach ($chats as $key) {
        $data['user_id'][] = $key->user_id;
        $data['seen'][] = $key->seen;
      }
  return response()->json($data);
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
