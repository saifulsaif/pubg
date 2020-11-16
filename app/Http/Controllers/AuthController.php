<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Hash;

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
     $app_id = request('app_id');
     $seller_id = DB::table('users')
                    ->where('role','seller')
                    ->where('app_id',$app_id)
                    ->first();
     if ($token = JWTAuth::attempt($credentials)) {
     $data['success'] = 1;
     $data['message'] = "You have Signed in Successfully!";
     $data['loginInfo'] = [array("api_token" => $token,"token_type" => 'Bearer',"seller_id" =>  $seller_id->id,"user_id"=>auth()->user()->id,"type"=>auth()->user()->role)];
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
   $user_id=$request->get('user_id');
    $profile_info = DB::table('users')
                ->join('partials','partials.user_id','=','users.id')
                ->where('users.id',$user_id)
                ->select('users.id',
                'users.name',
                'users.email as phone',
                'users.image',
                'users.role',
                'partials.purchase',
                'partials.favorite',
                'partials.ref',
                'partials.point')
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
            ->update(['name' => $name,'email' => $phone,'phone' => $email]);
  $data['success'] = 1;
  $data['message'] = "Profile Update Successfully!";
  return $data;
}
public function image_upload(Request $request){
  $user_id=$request->get('user_id');
   $status=$request->file('file');
   $target_dir = "images/user/";
    $target_file_name = $target_dir .basename($_FILES["file"]["name"]);
    $response = array();

    // Check if image file is an actual image or fake image
    if (isset($_FILES["file"]))
    {
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file_name))
      {
        $success = '1';
        $message = "Successfully Uploaded";
      }
      else
      {
         $success = '0';
         $message = "Error while uploading";
      }
    }
    else
    {
         $success = '0';
         $message = "Required Field Missing";
    }
    $image_link=asset($target_file_name);
    $response["success"] = $success;
    $response["message"] = $message;
                  DB::table('users')
                  ->where('id',$user_id)
                  ->update(['image' => $image_link]);

    return response()->json($response);
}
public function seller_contact(Request $request)
{
   $info=auth()->user();
   $app_id=$request->input('app_id');
   $seller_info = DB::table('profiles')
                  ->where('app_id',$app_id)
                  ->select('number','email','facebook')
                  ->first();
    return response()->json($seller_info);
}
public function updateDeviceID(Request $request){
 $user_id=$request->get('user_id');
 $reg_id=$request->get('reg_id');

 DB::table('users')
            ->where('device_token', $reg_id)
            ->update(['device_token' =>'']);
 DB::table('users')
            ->where('id', $user_id)
            ->update(['device_token' => $reg_id]);
  $data['success'] = 1;
  $data['message'] = "Device Token Update Successfully!";
  return $data;
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
public function online_status(Request $request){
   $user_id=$request->input('user_id');
   $status=$request->input('status');
                  DB::table('users')
                  ->where('id',$user_id)
                  ->update(['active_status' => $status]);
}
public function chatList(Request $request){
   $seller_id=$request->input('seller_id');
   $app_id=$request->input('app_id');
   $chatList = DB::table('chat_lists')
                 ->join('users', 'users.id', '=', 'chat_lists.user_id')
                 ->join('messages', 'messages.id', '=', 'chat_lists.last_message')
                 ->where('chat_lists.app_id', $app_id)
                 ->where('chat_lists.seller_id', $seller_id)
                 ->orderBy('chat_lists.id','DESC')
                 ->select('chat_lists.user_id',
                 'messages.sender_id',
                 'users.name',
                 'users.image',
                 'users.active_status',
                 'messages.message as last_message',
                 'messages.seen',
                 'messages.created_at')
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
public function user_inbox(Request $request){
  $user_id=$request->input('user_id');
  $seller_id=$request->input('seller_id');
  $app_id=$request->input('app_id');
                 $count=DB::table('messages')
                 ->where('reciver_id',$user_id)
                 ->where('sender_id',$seller_id)
                 ->where('app_id',$app_id)
                 ->where('seen','1')
                 ->count('id');
    if($count<1){
    $user_position['unseen_message'] = 0;
  }else{
    $user_position['unseen_message'] = $count;
  }
    return $user_position;
}
public function getMessage(Request $request){
 $sender_id=$request->input('sender_id');
  $receiver_id=$request->input('receiver_id');
  $app_id=$request->input('app_id');
   $message = DB::table('messages')
                  ->where('app_id',$app_id)
                  ->where('sender_id',$sender_id)
                  ->where('reciver_id',$receiver_id)
                  ->orwhere('sender_id',$receiver_id)
                  ->where('reciver_id',$sender_id)
                  ->select('reciver_id','sender_id','message','app_id','seen','created_at','type')
                  ->orderby('id','desc')
                  ->paginate(35);
    return response()->json($message);
}

public function sendMessage(Request $request){
  $type=$request->input('type');
  $message;
  if($type=='image'){
    $status=$request->file('file');
    $target_dir = "images/message/";
     $target_file_name = $target_dir .basename($_FILES["file"]["name"]);
     $response = array();

     // Check if image file is an actual image or fake image
     if (isset($_FILES["file"]))
     {
       if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file_name))
       {
         $message = "Successfully Uploaded";
       }
     }
     else
     {
          $message = "Required Field Missing";
     }
     $message=asset($target_file_name);
  }else{
   $message=$request->input('message');
  }
  $sender_id=$request->input('sender_id');
  $reciver_id=$request->input('reciver_id');
  $app_id=$request->input('app_id');
  $first_message = DB::table('messages')
                 ->where('sender_id',$sender_id)
                 ->where('reciver_id',$reciver_id)
                 ->orwhere('reciver_id',$sender_id)
                 ->where('sender_id',$reciver_id)
                 ->first();
    if($first_message){
      DB::table('messages')
                 ->insert([
                  'sender_id' => $sender_id,
                 'reciver_id' => $reciver_id,
                 'message' => $message,
                 'type' => $type,
                 'seen' => '1',
                 'created_at' => date('Y-m-d h:i:s'),
                 'app_id' => $app_id]);

       $last_message_id = DB::getPdo()->lastInsertId();
        $check_user = DB::table('chat_lists')
                    ->where('user_id',$reciver_id)
                    ->first();
        $check_role = DB::table('users')
                    ->where('id',$reciver_id)
                    ->first();
        if($check_user){
           if($check_role->role=='user'){
             DB::table('chat_lists')->where('user_id', $reciver_id)->delete();
             DB::table('chat_lists')
                      ->insert(['last_message' => $last_message_id,
                      'user_id' => $reciver_id,
                      'seller_id' => $sender_id,
                      'created_at' => date('Y-m-d h:i:s'),
                      'app_id' => $app_id]);
           }else{
             DB::table('chat_lists')->where('user_id', $sender_id)->delete();
             DB::table('chat_lists')
                        ->insert(['last_message' => $last_message_id,
                        'user_id' => $sender_id,
                        'seller_id' => $reciver_id,
                        'created_at' => date('Y-m-d h:i:s'),
                        'app_id' => $app_id]);
           }
        }else{
          if($check_role->role=='user'){
          DB::table('chat_lists')->where('user_id',$reciver_id)->delete();
          DB::table('chat_lists')
                     ->insert(['last_message' => $last_message_id,
                     'user_id' => $reciver_id,
                     'seller_id' => $sender_id,
                     'created_at' => date('Y-m-d h:i:s'),
                     'app_id' => $app_id]);
          }else{
            DB::table('chat_lists')->where('user_id', $sender_id)->delete();
            DB::table('chat_lists')
                       ->insert(['last_message' => $last_message_id,
                       'user_id' => $sender_id,
                       'seller_id' => $reciver_id,
                       'created_at' => date('Y-m-d h:i:s'),
                       'app_id' => $app_id]);
          }
        }

    }else{
      DB::table('messages')
                 ->insert(['sender_id' => $sender_id,
                 'reciver_id' => $reciver_id,
                 'message' => $message,
                 'type' => $type,
                 'seen' => '1',
                 'created_at' => date('Y-m-d h:i:s'),
                 'app_id' => $app_id]);
                 $last_message_id = DB::getPdo()->lastInsertId();
                 $check_user = DB::table('chat_lists')
                             ->where('user_id',$reciver_id)
                             ->first();
                 $check_role = DB::table('users')
                             ->where('id',$reciver_id)
                             ->first();
                 if($check_role){
                    DB::table('chat_lists')->where('user_id', $reciver_id)->delete();
                    if($check_user->role=='user'){
                    DB::table('chat_lists')
                               ->insert(['last_message' => $last_message_id,
                               'user_id' => $reciver_id,
                               'seller_id' => $sender_id,
                               'created_at' => date('Y-m-d h:i:s'),
                               'app_id' => $app_id]);
                    }else{
                      DB::table('chat_lists')->where('user_id', $sender_id)->delete();
                      DB::table('chat_lists')
                                 ->insert(['last_message' => $last_message_id,
                                 'user_id' => $sender_id,
                                 'seller_id' => $reciver_id,
                                 'created_at' => date('Y-m-d h:i:s'),
                                 'app_id' => $app_id]);
                    }
                 }else{
                   if($check_role->role=='user'){
                   DB::table('chat_lists')->where('user_id', $reciver_id)->delete();
                   DB::table('chat_lists')
                              ->insert(['last_message' => $last_message_id,
                              'user_id' => $reciver_id,
                              'seller_id' => $sender_id,
                              'created_at' => date('Y-m-d h:i:s'),
                              'app_id' => $app_id]);
                   }else{
                     DB::table('chat_lists')->where('user_id', $sender_id)->delete();
                     DB::table('chat_lists')
                                ->insert(['last_message' => $last_message_id,
                                'user_id' => $sender_id,
                                'seller_id' => $reciver_id,
                                'created_at' => date('Y-m-d h:i:s'),
                                'app_id' => $app_id]);
                   }
                 }
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
    $message_body= $message_body = array('sender_id' => $sender_id,
                  'sender_id' => $reciver_id,
                  'reciver_id' => $sender_id,
                  'message' => '',
                  'type' => $type,
                  'seen' => '1',
                  'created_at' => date('Y-m-d h:i:s'),
                  'app_id' => $app_id);
    $body=$sender_name->name;
    $message=$message;
   $fields = array(
          'to' => $device_token->device_token,
        //   'priority'=>'high',
          'notification' => array('title' => $body, 'body' => $message),
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

       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

       $result = curl_exec($ch);
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }

       //Now close the connection
       curl_close($ch);

       //and return the result
       return $result;
   }

   public function purchase(Request $request){
 $user_id=$request->get('user_id');
 $info=DB::table('partials')
            ->where('user_id', $user_id)
            ->first();
 $point=$info->point+1;
 $purchase=$info->purchase+1;
 DB::table('partials')
            ->where('user_id', $user_id)
            ->update(['point' =>$point,'purchase'=>$purchase]);
  $data['success'] = 1;
  $data['message'] = "Purchase Update Successfully!";
  return $data;
}
public function point(Request $request){
 $user_id=$request->get('user_id');
 $point=$request->get('point');
 $info=DB::table('partials')
            ->where('user_id', $user_id)
            ->first();
 $point=$info->point+$point;
 DB::table('partials')
            ->where('user_id', $user_id)
            ->update(['point' =>$point]);
  $data['success'] = 1;
  $data['message'] = "Point Update Successfully!";
  return $data;
}
public function note(Request $request){
 $user_id=$request->get('user_id');
 $note=$request->get('note');
 DB::table('partials')
            ->where('user_id', $user_id)
            ->update(['note' =>$note]);
  $data['success'] = 1;
  $data['message'] = "Note Update Successfully!";
  return $data;
}
public function favorite(Request $request){
 $user_id=$request->get('user_id');
 $favorite=$request->get('favorite');
 DB::table('partials')
            ->where('user_id', $user_id)
            ->update(['favorite' =>$favorite]);
  $data['success'] = 1;
  $data['message'] = "Favorite Update Successfully!";
  return $data;
}
public function partialInfo(Request $request){
  $user_id=$request->get('user_id');
 $info=DB::table('partials')
            ->where('user_id', $user_id)
            ->first();
  return response()->json($info);
}
public function referral(Request $request){
 $user_id=$request->get('user_id');
 $referral_id=$request->get('referral_id');
 $info=DB::table('partials')
            ->where('user_id', $user_id)
            ->first();
 $point=$info->point+5;
 DB::table('partials')
            ->where('user_id', $user_id)
            ->update(['point' =>$point,'ref'=>$referral_id]);
  $data['success'] = 1;
  $data['message'] = "Point Update Successfully!";
  return $data;
}
public function password_change(Request $request){
 $user_id=$request->get('user_id');
 $old_password=Hash::make($request->get('old_password'));
 $new_password=Hash::make($request->get('new_password'));
 $user_data=DB::table('users')
            ->where('id', $user_id)
            ->where('password', $old_password)
            ->first();
 if($user_data){
  $data['success'] = 1;
  $data['message'] = "Password Change Successfully!";
 }else{
  $data['success'] = 0;
  $data['message'] = "Incorrect  Password";
 }
  return $data;
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
