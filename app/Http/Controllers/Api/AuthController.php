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
      $app_id = request('app_id');
      $seller_id = DB::table('users')
                     ->where('role','seller')
                     ->where('app_id',$app_id)
                     ->first();
      if ( $token = auth()->guard()->attempt($credentials)) {
      $data['success'] = 1;
      $data['message'] = "You have Signed in Successfully!";
      $data['loginInfo'] = [array("api_token" => $token,"token_type" => 'Bearer',"sellser_id" =>  $seller_id->id,"user_id"=>auth()->user()->id,"type"=>auth()->user()->role)];
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
public function seller_contact(Request $request)
{
   $info=auth()->user();
   $app_id=$request->input('app_id');
   $seller_info = DB::table('profiles')
                  ->where('app_id',$app_id)
                  ->get();
    return response()->json($seller_info);
}
public function online_status(Request $request){
   $user_id=$request->input('user_id');
   $status=$request->input('status');
                  DB::table('users')
                  ->where('id',$user_id)
                  ->update(['active_status' => $status]);
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
public function chatList(Request $request){
  $user_id=$request->input('user_id');
   $reciver_id=$request->input('reciver_id');
   $app_id=$request->input('app_id');
   $chatList = DB::table('messages')
                 ->join('users', 'users.id', '=', 'messages.reciver_id')
                 ->select('users.name','users.image','messages.reciver_id as user_id','users.active_status', DB::raw('count(*) as total_message'))
                 ->groupBy('messages.reciver_id')
                 ->groupBy('users.name')
                 ->groupBy('users.image')
                 ->groupBy('users.active_status')
                 ->where('messages.app_id', $app_id)
                 ->where('messages.sender_id', $user_id)
                 ->paginate(20);
     return response()->json($chatList);
}
public function unseen(Request $request){
  $user_id=$request->input('user_id');
  $sender_id=$request->input('sender_id');
  $app_id=$request->input('app_id');
                 DB::table('messages')
                 ->where('sender_id',$sender_id)
                 ->where('reciver_id',$user_id)
                 ->where('seen','1')
                 ->where('app_id',$app_id)
                 ->update(['seen' => '0']);
     return response()->json('unseen successfully');
}
public function watting_position(Request $request){
  $user_id=$request->input('user_id');
  $seller_id=$request->input('seller_id');
  $app_id=$request->input('app_id');
                 $data=DB::table('messages')
                 ->where('reciver_id',$seller_id)
                 ->where('app_id',$app_id)
                 ->where('seen','1')
                 ->get();
      $i=0;
      $position=0;
      foreach ($data as $key) {
        if($key->sender_id==$user_id){
          $position=$i;
        }
        $i++;
            }
    if($position==0){
    $user_position['position'] = 1 ;
  }else{
    $user_position['position'] = $position ;
  }
    return $user_position;
}
public function sendMessage(Request $request){
  $sender_id=$request->input('sender_id');
  $reciver_id=$request->input('reciver_id');
  $message=$request->input('message');
  $type=$request->input('type');
  $app_id=$request->input('app_id');
  $first_message = DB::table('messages')
                 ->where('sender_id',$sender_id)
                 ->where('reciver_id',$reciver_id)
                 ->orwhere('reciver_id',$sender_id)
                 ->where('sender_id',$reciver_id)
                 ->first();
    if($first_message){
      DB::table('messages')
                 ->insert(['sender_id' => $sender_id,
                 'sender_id' => $sender_id,
                 'reciver_id' => $reciver_id,
                 'message' => $message,
                 'type' => $type,
                 'seen' => '1',
                 'created_at' => date('Y-m-d h:i:s'),
                 'app_id' => $app_id]);
    }else{
      DB::table('messages')
                 ->insert(['sender_id' => $sender_id,
                 'sender_id' => $sender_id,
                 'reciver_id' => $reciver_id,
                 'message' => $message,
                 'type' => $type,
                 'seen' => '1',
                 'created_at' => date('Y-m-d h:i:s'),
                 'app_id' => $app_id]);
       DB::table('messages')
                  ->insert(['sender_id' => $sender_id,
                  'sender_id' => $reciver_id,
                  'reciver_id' => $sender_id,
                  'message' => '',
                  'type' => $type,
                  'seen' => '1',
                  'created_at' => date('Y-m-d h:i:s'),
                  'app_id' => $app_id]);
       }
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
