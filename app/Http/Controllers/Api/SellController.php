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
                     ->update(['seller_id' =>'']);

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
                   ->select('transfer_users.id as user_id','users.name','users.image','users.active_status')
                   ->paginate(20);
     return response()->json($users);
   }
   public function remove_transfer_user(Request $request){
  $transfer_id=$request->input('transfer_id');
   DB::table('transfer_users')
                  ->where('id',$transfer_id)
                  ->delete();
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
                   'sells.id as sell_id',
                   'users.name',
                   'sells.game_id',
                   'sells.status',
                   'products.id as product_id',
                   'products.product_name',
                   'products.quantity',
                   'products.price',
                   'products.point')
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

      return $data;
  }
  public function sell_approve(Request $request){
    $app_id=$request->input('app_id');
    $sell_id=$request->input('sell_id');
       DB::table('sells')
                  ->where('app_id',$app_id)
                  ->where('id',$sell_id)
                  ->update(['status' => 'Approved']);

       $data['message'] = "Request approved successfully!";

      return $data;
  }
}
