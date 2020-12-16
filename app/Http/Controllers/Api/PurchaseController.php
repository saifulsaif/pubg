<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use\DB;
use\Hash;
use App\User;

class PurchaseController extends Controller
{
  public function seller_purchase_count(Request $request){
   $seller_id=$request->get('seller_id');
    $seller_purchase_count = DB::table('purchase')
                  ->where('seller_id', $seller_id)
                  ->count('id');
      $data['seller_purchase_count'] = $seller_purchase_count;
      return $data;
  }
  public function referral_point_list(Request $request){
   $user_id=$request->get('user_id');
   $info=DB::table('purchase')
               ->join('users', 'users.id', '=', 'purchase.user_id')
              ->where('purchase.referral_id', $user_id)
              ->select('users.name','purchase.point','purchase.created_at')
              ->get();
    $data['success'] = 1;
    $data['message'] =$info;
    return $data;
  }
  public function referral_point_sum(Request $request){
   $user_id=$request->get('user_id');
  $orders = DB::table('purchase')
               ->join('users', 'users.id', '=', 'purchase.user_id')
               ->select('users.id','users.name','users.image', DB::raw('SUM(purchase.point) as total_point'))
               ->where('purchase.referral_id',$user_id)
               ->groupBy('users.id')
               ->groupBy('users.name')
               ->groupBy('users.image')
               ->get();
    return $orders;
  }
  public function purchase(Request $request){
   $user_id=$request->get('user_id');
   $seller_id=$request->get('seller_id');
   $info=DB::table('partials')
              ->where('user_id', $user_id)
              ->first();
   $referral_id=$info->ref;
   $set_point=$info->set_point;
   // first puchse function
   $first_puchase=DB::table('purchase')
              ->where('user_id', $user_id)
              ->first();
    if(empty($first_puchase)){
    DB::table('partials')
               ->where('user_id', $referral_id)
               ->increment('point',5);
    DB::table('partials')
               ->where('user_id', $referral_id)
               ->increment('referral_point',5);
    DB::table('partials')
               ->where('user_id', $referral_id)
               ->decrement('pending_point',5);
    }

   DB::table('partials')
              ->where('user_id', $user_id)
              ->increment('purchase',1);
   DB::table('partials')
              ->where('user_id', $referral_id)
              ->increment('point',$set_point);
    DB::table('partials')
               ->where('user_id', $referral_id)
               ->increment('referral_point',$set_point );
    DB::table('purchase')
               ->insert(['seller_id' =>$seller_id,
               'referral_id'=>$referral_id,
               'Point'=>$set_point,
               'user_id'=>$user_id]);
    // send messages to  user

      date_default_timezone_set('Asia/Dhaka');
      $datatime = $currentTime = date( 'h:i A d-m-Y', time () );
      $type='text';
      $message='Congratulations! You purchase was successful. ';
      $sender_name= DB::table('users')
                  ->where('id', $seller_id)
                  ->select('name','app_id')
                  ->first();
      $app_id=$sender_name->app_id;
      DB::table('messages')
                     ->insert(['sender_id' => $seller_id,
                     'reciver_id' => $user_id,
                     'message' => $message,
                     'type' => $type,
                     'seen' => '1',
                     'seller_id' => $seller_id,
                     'created_at' => $datatime,
                     'app_id' => $app_id]);
          $last_message_id = DB::getPdo()->lastInsertId();
          $device_token= DB::table('users')
                      ->where('id', $user_id)
                      ->select('device_token')
                      ->first();


            $message_body = array('notification_type' =>'message',
                         'sender_id' => $seller_id,
                         'sender_name' => $sender_name->name,
                         'reciver_id' => $user_id,
                         'message' =>$message,
                         'type' => $type,
                         'seen' => '1',
                         'created_at' => $datatime,
                         'app_id' => $app_id);
            if($device_token){
              $field = array(
                  'to' => $device_token->device_token,
                  'priority'=>'high',
                //   'notification' => array('title' => $body, 'body' => $message),
                  'data' => $message_body,
              );
              $this->sendPushNotification($field);
          }




    // send messages to  raferral user
    if($referral_id){
      $user_name= DB::table('users')
                  ->where('id', $user_id)
                  ->select('name')
                  ->first();

      $type='text';
      $message='Congratulations! You got '.$set_point.' point from '.$user_name->name.'';
      DB::table('messages')
                     ->insert(['sender_id' => $seller_id,
                     'reciver_id' => $referral_id,
                     'message' => $message,
                     'type' => $type,
                     'seen' => '1',
                     'seller_id' => $seller_id,
                     'created_at' => $datatime,
                     'app_id' => $app_id]);
          $last_message_id = DB::getPdo()->lastInsertId();
          $device_token= DB::table('users')
                      ->where('id', $referral_id)
                      ->select('device_token')
                      ->first();


            $message_body = array('notification_type' =>'message',
                         'sender_id' => $seller_id,
                         'sender_name' => $sender_name->name,
                         'reciver_id' => $referral_id,
                         'message' =>$message,
                         'type' => $type,
                         'seen' => '1',
                         'created_at' => $datatime,
                         'app_id' => $app_id);
            if($device_token){
              $field = array(
                  'to' => $device_token->device_token,
                  'priority'=>'high',
                //   'notification' => array('title' => $body, 'body' => $message),
                  'data' => $message_body,
              );
              $this->sendPushNotification($field);
          }
    }
    // disconnect user from seller
    DB::table('waiting_lists')
              ->where('user_id',$user_id)
               ->delete();
    $data['success'] = 1;
    $data['message'] = "Purchase Done Successfully!";
    return $data;
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
