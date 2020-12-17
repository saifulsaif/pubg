<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use\DB;
use\Hash;
use App\User;

class SellController extends Controller
{
  public function sell(Request $request){
    $app_id=$request->input('app_id');
     $user_id=$request->input('user_id');
     $product_id=$request->input('product_id');
     $game_id=$request->input('game_id');
     $product = DB::table('products')
                   ->where('app_id', $app_id)
                   ->where('id', $product_id)
                   ->first();
     $points = DB::table('partials')
                   ->where('user_id', $user_id)
                   ->first();

      if($points->point>=$product->point){
        $current_point=$points->point-$product->point;
        DB::table('sells')
                   ->insert([
                    'app_id' => $app_id,
                   'product_id' => $product_id,
                   'game_id' => $game_id,
                   'user_id' => $user_id,
                   'created_at' => date('Y-m-d h:i:s')]);
       DB::table('partials')
                  ->where('user_id', $user_id)
                  ->update(['point' => $current_point]);
        $data['success'] = 1;
        $data['message'] = "Your request send successfully!";
      }else{
        $data['success'] = 0;
        $data['message'] = "You don't insufficient point.Please contact with seller";
      }
       return $data;
  }
    public function seller_list(Request $request){
     $app_id=$request->input('app_id');
      $sell = DB::table('users')
                    ->where('app_id',$app_id)
                    ->where('role','seller')
                    ->select('id','name','image')
                    ->get();

      return response()->json($sell);
   }
   public function seller_transfer(Request $request){
     $app_id=$request->input('app_id');
     $seller_id=$request->input('seller_id');
     $user_id=$request->input('user_id');
     $waiting_list = DB::table('waiting_lists')
                    ->where('user_id',$user_id)
                    ->first();
        if($waiting_list){
          DB::table('waiting_lists')
                     ->where('user_id', $user_id)
                     ->update(['seller_id' =>$seller_id]);

           DB::table ('transfer_users')
                      ->insert([
                      'seller_id' => $seller_id,
                      'user_id' => $user_id]);
           $data['success'] = 1;
           $data['message'] = "Seller transfer successfully!";
        }else{
          $data['success'] = 0;
          $data['message'] = "You can't transfer!";
        }
      return $data;
   }
   public function transfer_list(Request $request){
    $seller_id=$request->input('seller_id');
    $users = DB::table('transfer_users')
                    ->join('users','users.id','transfer_users.user_id')
                   ->where('transfer_users.seller_id',$seller_id)
                   ->select('users.id as user_id','users.name','users.image','users.active_status')
                   ->paginate(20);
     return response()->json($users);
   }
   public function remove_transfer_user(Request $request){
   $user_id=$request->input('user_id');
    DB::table('transfer_users')
                   ->where('user_id',$user_id)
                   ->delete();
    $data['message'] = "User Removed successfully!";

      return $data;
   }
  public function get_seller_sells(Request $request){
     $app_id=$request->input('app_id');
     $type=$request->input('type');
     $sell = DB::table('sells')
                 ->join('users','sells.user_id','=','users.id')
                 ->join('products','sells.product_id','=','products.id')
                   ->where('sells.app_id',$app_id)
                   ->where('sells.status',$type)
                   ->select('users.id as user_id',
                   'users.name',
                   'sells.game_id',
                   'sells.id as sell_id',
                   'sells.status',
                   'products.id as product_id',
                   'products.product_name',
                   'products.quantity',
                   'products.price',
                   'products.point')
                   ->orderby('sells.id','desc')
                   ->paginate(20);

     return response()->json($sell);
  }
  public function get_user_sells(Request $request){
     $app_id=$request->input('app_id');
     $user_id=$request->input('user_id');
     $sell = DB::table('sells')
                 ->join('users','sells.user_id','=','users.id')
                 ->join('products','sells.product_id','=','products.id')
                   ->where('sells.app_id',$app_id)
                   ->where('sells.user_id',$user_id)
                   ->select('users.id as user_id',
                   'users.name',
                   'sells.game_id',
                   'sells.id as sell_id',
                   'sells.status',
                   'products.id as product_id',
                   'products.product_name',
                   'products.quantity',
                   'products.price',
                   'products.point')
                   ->orderby('sells.id','desc')
                   ->paginate(20);

     return response()->json($sell);
  }
  public function sell_cancel(Request $request){
     $app_id=$request->input('app_id');
      $sell_id=$request->input('sell_id');
       $sell_point=DB::table('sells')
                  ->join('products','products.id','=','sells.product_id')
                  ->where('sells.app_id',$app_id)
                  ->where('sells.id',$sell_id)
                  ->select('products.point','sells.user_id')
                  ->first();
       DB::table('sells')
                  ->where('app_id',$app_id)
                  ->where('id',$sell_id)
                  ->update(['status' => 'Cancelled']);
      DB::table('partials')
                 ->where('user_id', $sell_point->user_id)
                 ->Increment('point',$sell_point->point);
       $data['message'] = "Request cancelled successfully!";
       $this->cancel_message($sell_id,$app_id);
      return $data;
  }
  public function sell_approve(Request $request){
    $app_id=$request->input('app_id');
    $sell_id=$request->input('sell_id');
    $seller_id=$request->input('seller_id');
    $get_user_id=DB::table('sells')
                  ->where('app_id',$app_id)
                  ->where('id',$sell_id)
                  ->select('user_id')
                  ->first();
   $get_seller_id=DB::table('waiting_lists')
                  ->where('user_id',$get_user_id->user_id)
                  ->select('seller_id')
                  ->first();
        if(empty($get_seller_id)){

        DB::table('sells')
                  ->where('app_id',$app_id)
                  ->where('id',$sell_id)
                  ->update(['status' => 'Approved']);
                // send message
                $this->approve_message($seller_id,$sell_id,$app_id);

       $data['success'] = 1;
       $data['message'] = "Request approved succssfully!";
        }else{
            if(!empty($get_seller_id->seller_id)){
                if($get_seller_id->seller_id==$seller_id){
                 DB::table('sells')
                  ->where('app_id',$app_id)
                  ->where('id',$sell_id)
                  ->update(['status' => 'Approved']);
                // send message
                $this->approve_message($seller_id,$sell_id,$app_id);
                $data['success'] = 1;
       $data['message'] = "Request approved succssfully!";
                }else{
                $data['success'] = 0;
                $data['message'] = "Sorry! You can't approve this request.";
                }
            }else{
              DB::table('sells')
                  ->where('app_id',$app_id)
                  ->where('id',$sell_id)
                  ->update(['status' => 'Approved']);
                // send message
                $this->approve_message($seller_id,$sell_id,$app_id);

       $data['success'] = 1;
       $data['message'] = "Request approved succssfully!";
            }
        }
      return $data;
  }
  private function approve_message($seller_id,$sell_id,$app_id){
       $sell_info = DB::table('sells')
               ->join('products','sells.product_id','products.id')
               ->where('sells.id',$sell_id)
               ->first();
       date_default_timezone_set('Asia/Dhaka');
      $datatime  = date( 'h:i A d-m-Y', time () );
       $agent = DB::table('users')
               ->where('app_id',$app_id)
               ->where('role','agent')
               ->first();
     $message=" Your Purchase request has been approved!
              Game Id : $sell_info->game_id
              product Name : $sell_info->product_name
              Quantity : $sell_info->quantity
              Price : $sell_info->price
              Point : $sell_info->point";
       DB::table('messages')
                  ->insert([
                  'sender_id' => $agent->id,
                  'reciver_id' => $sell_info->user_id,
                   'seller_id' =>$seller_id,
                  'message' => $message,
                  'type' => 'text',
                  'seen' => '1',
                  'created_at' => $datatime,
                  'app_id' => $app_id]);

        $last_message_id = DB::getPdo()->lastInsertId();

        $device_token= DB::table('users')
                    ->where('id', $sell_info->user_id)
                    ->select('device_token')
                    ->first();

        $message_body = array('notification_type' =>'message',
                     'sender_id' => $agent->id,
                     'sender_name' => ' ',
                     'reciver_id' => $sell_info->user_id,
                     'message' => $message,
                     'type' => 'text',
                     'seen' => '1',
                     'created_at' => $datatime,
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
 private function cancel_message($sell_id,$app_id){
    $sell_info = DB::table('sells')
             ->join('products','sells.product_id','products.id')
             ->where('sells.id',$sell_id)
             ->first();
     date_default_timezone_set('Asia/Dhaka');
      $datatime = $currentTime = date( 'h:i A d-m-Y', time () );
     $agent = DB::table('users')
             ->where('app_id',$app_id)
             ->where('role','agent')
             ->first();
   $message=" Your  request has been Cancelled!";
     DB::table('messages')
                ->insert([
                'sender_id' => $agent->id,
                'reciver_id' => $sell_info->user_id,
                'message' => $message,
                'type' => 'text',
                'seen' => '1',
                'created_at' => $datatime,
                'app_id' => $app_id]);

      $last_message_id = DB::getPdo()->lastInsertId();

      $device_token= DB::table('users')
                  ->where('id', $sell_info->user_id)
                  ->select('device_token')
                  ->first();

      $message_body = array('notification_type' =>'message',
                   'sender_id' => $agent->id,
                   'sender_name' => ' ',
                   'reciver_id' => $sell_info->user_id,
                   'message' => $message,
                   'type' => 'text',
                   'seen' => '1',
                   'created_at' => $datatime,
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
