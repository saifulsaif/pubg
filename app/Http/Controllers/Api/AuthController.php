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
public function online_status(Request $request){
   $user_id=$request->input('user_id');
   $status=$request->input('status');
                  DB::table('users')
                  ->where('id',$user_id)
                  ->update(['active_status' => $status]);
}
public function image_upload(Request $request){
   $user_id=$request->file('user_id');
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
public function waiting_time(Request $request){
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
