<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use\DB;
use\Hash;
use App\User;

class MessageController extends Controller{
  public function waiting_list(Request $request){
     $app_id=$request->input('app_id');
     $chatList = DB::table('waiting_lists')
                   ->join('users', 'users.id', '=', 'waiting_lists.user_id')
                   ->where('waiting_lists.app_id', $app_id)
                   ->where('waiting_lists.seller_id', null)
                   ->select('waiting_lists.user_id',
                   'users.name',
                   'users.image',
                   'users.active_status')
                   ->get();
       return response()->json($chatList);
  }
  public function start_chat(Request $request){
    $app_id=$request->input('app_id');
    $sender_id=$request->input('agent_id');
    $reciver_id=$request->input('user_id');
    $seller_id=$request->input('seller_id');
    $type='text';
    $message='Welcome to Gaming world';
    DB::table('messages')
                   ->insert(['sender_id' => $sender_id,
                   'reciver_id' => $reciver_id,
                   'message' => $message,
                   'type' => $type,
                   'seen' => '1',
                   'seller_id' => $seller_id,
                   'created_at' => date('Y-m-d h:i:s'),
                   'app_id' => $app_id]);
        $last_message_id = DB::getPdo()->lastInsertId();
      // chat list
         DB::table('chat_lists')->where('user_id', $reciver_id)->delete();
         DB::table('chat_lists')
                  ->insert(['last_message' => $last_message_id,
                  'user_id' => $reciver_id,
                  'seller_id' => $seller_id,
                  'created_at' => date('Y-m-d h:i:s'),
                  'app_id' => $app_id]);
      // waiting list
      DB::table('waiting_lists')
              ->where('user_id',$reciver_id)
              ->where('app_id',$app_id)
               ->update(['seller_id' => $seller_id]);
   $device_token= DB::table('users')
               ->where('id', $reciver_id)
               ->select('device_token')
               ->first();

   $sender_name= DB::table('users')
               ->where('id', $sender_id)
               ->select('name')
               ->first();
     $message_body = array('notification_type' =>'message',
                  'sender_id' => $sender_id,
                  'sender_name' => $sender_name->name,
                  'reciver_id' => $reciver_id,
                  'message' =>$message,
                  'type' => $type,
                  'seen' => '1',
                  'created_at' => date('Y-m-d h:i:s'),
                  'app_id' => $app_id);
     if($device_token){
       $field = array(
           'to' => $device_token->device_token,
           'priority'=>'high',
         //   'notification' => array('title' => $body, 'body' => $message),
           'data' => $message_body,
       );
   }


      $message_null_body = array('notification_type' =>'update');
      $all_seller = DB::table('users')
                  ->where('app_id',$app_id)
                  ->where('role','seller')
                  ->where('device_token','!=','')
                  ->select('device_token')
                  ->get();
      foreach ($all_seller as $key) {
          $fields = array(
              'to' => $key->device_token,
              'priority'=>'high',
            //   'notification' => array('title' => $body, 'body' => $message),
              'data' => $message_null_body,
          );
       $this->sendPushNotification($fields);
      }
   return $this->sendPushNotification($field);
  }


  public function SendMessage(Request $request){


    $type=$request->input('type');
    $user_type=$request->input('user_type');
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


    // user type check
     if($user_type=='user'){
       // user message...........

       $seller_id=$this->check_waitinglist($sender_id,$app_id);
       DB::table('messages')
                  ->insert([
                  'sender_id' => $sender_id,
                  'reciver_id' => $reciver_id,
                   'seller_id' => $seller_id,
                  'message' => $message,
                  'type' => $type,
                  'seen' => '1',
                  'created_at' => date('Y-m-d h:i:s'),
                  'app_id' => $app_id]);

        $last_message_id = DB::getPdo()->lastInsertId();
      if(!empty($seller_id)){
         DB::table('chat_lists')
         ->where('user_id', $sender_id)
         ->where('seller_id', $seller_id)
         ->delete();
         DB::table('chat_lists')
                    ->insert(['last_message' => $last_message_id,
                    'user_id' => $sender_id,
                    'seller_id' => $seller_id,
                    'created_at' => date('Y-m-d h:i:s'),
                    'app_id' => $app_id]);
        }
        $device_token= DB::table('users')
                    ->where('id', $seller_id)
                    ->select('device_token')
                    ->first();
        $sender_name= DB::table('users')
                  ->where('id', $sender_id)
                  ->select('name')
                  ->first();
        $message_body = array('notification_type' =>'message',
                     'sender_id' => $sender_id,
                     'sender_name' => $sender_name->name,
                     'reciver_id' => $reciver_id,
                     'message' =>$message,
                     'type' => $type,
                     'seen' => '1',
                     'created_at' => date('Y-m-d h:i:s'),
                     'app_id' => $app_id);
        if($device_token){
          $fields = array(
              'to' => $device_token->device_token,
              'priority'=>'high',
            //   'notification' => array('title' => $body, 'body' => $message),
              'data' => $message_body,
          );
           return $this->sendPushNotification($fields);
        }
       $this->check_message($sender_id,$reciver_id,$app_id);
     }else{
       // agent message..............
       $agent = DB::table('users')
               ->where('app_id',$app_id)
               ->where('role','agent')
               ->first();
       DB::table('messages')
                  ->insert([
                  'sender_id' => $agent->id,
                  'reciver_id' => $reciver_id,
                   'seller_id' => $sender_id,
                  'message' => $message,
                  'type' => $type,
                  'seen' => '1',
                  'created_at' => date('Y-m-d h:i:s'),
                  'app_id' => $app_id]);

        $last_message_id = DB::getPdo()->lastInsertId();
       DB::table('chat_lists')->where('user_id', $reciver_id)->delete();
       DB::table('chat_lists')
                  ->insert(['last_message' => $last_message_id,
                  'user_id' => $reciver_id,
                  'seller_id' => $sender_id,
                  'created_at' => date('Y-m-d h:i:s'),
                  'app_id' => $app_id]);
        $device_token= DB::table('users')
                    ->where('id', $reciver_id)
                    ->select('device_token')
                    ->first();

        $message_body = array('notification_type' =>'message',
                     'sender_id' => $agent->id,
                     'sender_name' => $agent->name,
                     'reciver_id' => $reciver_id,
                     'message' =>$message,
                     'type' => $type,
                     'seen' => '1',
                     'created_at' => date('Y-m-d h:i:s'),
                     'app_id' => $app_id);
        if($device_token){$fields = array(
              'to' => $device_token->device_token,
              'priority'=>'high',
            //   'notification' => array('title' => $body, 'body' => $message),
              'data' => $message_body,
          );
           return $this->sendPushNotification($fields);
        }
     }
// notification start
  }

       private function check_waitinglist($sender_id,$app_id) {
         $waiting_check = DB::table('waiting_lists')
                 ->where('user_id',$sender_id)
                 ->first();
            $seller_id='';
            if($waiting_check){
               $seller_id=$waiting_check->seller_id;
            }else{
              DB::table('waiting_lists')
                 ->insert(['user_id' => $sender_id,
                 'created_at' => date('Y-m-d h:i:s'),
                 'app_id' => $app_id]);
                $seller_id=0;
            }
          return $seller_id;
       }
       private function check_message($sender_id,$reciver_id,$app_id){
         $message_count = DB::table('messages')
                 ->where('sender_id',$sender_id)
                 ->count('id');
          if($message_count=='1'){
            // first message...
            $defult_message=DB::table('defult_message')
                                ->where('app_id',$app_id)
                                ->where('type','=','first')
                                ->first();
            DB::table('messages')
                       ->insert([
                       'sender_id' => $reciver_id,
                       'reciver_id' => $sender_id,
                       'message' => $defult_message->message,
                       'type' => 'text',
                       'seen' => '1',
                       'created_at' => date('Y-m-d h:i:s'),
                       'app_id' => $app_id]);
             $device_token= DB::table('users')
                         ->where('id', $sender_id)
                         ->select('device_token')
                         ->first();
             $sender_name= DB::table('users')
                       ->where('id', $reciver_id)
                       ->select('name')
                       ->first();
             $message_body = array('notification_type' =>'message',
                          'sender_name' => $sender_name->name,
                          'sender_id' => $reciver_id,
                          'reciver_id' => $sender_id,
                          'message' => $defult_message->message,
                          'type' => 'text',
                          'seen' => '1',
                          'created_at' => date('Y-m-d h:i:s'),
                          'app_id' => $app_id);
             if($device_token){
               $fields = array(
                   'to' => $device_token->device_token,
                   'priority'=>'high',
                 //   'notification' => array('title' => $body, 'body' => $message),
                   'data' => $message_body,
               );
                return $this->sendPushNotification($fields);
             }
          }else{
            date_default_timezone_set('Asia/Dhaka');
            $currentTime = date( 'h', time () );
            if($currentTime>=1&&23>=$currentTime){
              $defult_message=DB::table('defult_message')
                                  ->where('app_id',$app_id)
                                  ->where('type','=','offline')
                                  ->first();
              DB::table('messages')
                         ->insert([
                         'sender_id' => $reciver_id,
                         'reciver_id' => $sender_id,
                         'message' => $defult_message->message,
                         'type' => 'text',
                         'seen' => '1',
                         'created_at' => date('Y-m-d h:i:s'),
                         'app_id' => $app_id]);
               $device_token= DB::table('users')
                           ->where('id', $sender_id)
                           ->select('device_token')
                           ->first();
               $sender_name= DB::table('users')
                         ->where('id', $reciver_id)
                         ->select('name')
                         ->first();
               $message_body = array('notification_type' =>'message',
                            'sender_name' => $sender_name->name,
                            'sender_id' => $reciver_id,
                            'reciver_id' => $sender_id,
                            'message' => $defult_message->message,
                            'type' => 'text',
                            'seen' => '1',
                            'created_at' => date('Y-m-d h:i:s'),
                            'app_id' => $app_id);
               if($device_token){
                 $fields = array(
                     'to' => $device_token->device_token,
                     'priority'=>'high',
                   //   'notification' => array('title' => $body, 'body' => $message),
                     'data' => $message_body,
                 );
                  return $this->sendPushNotification($fields);
               }
              }
          }


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
}
