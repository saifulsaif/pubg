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
        DB::table('sells')
                   ->insert([
                    'app_id' => $app_id,
                   'product_id' => $product_id,
                   'game_id' => $game_id,
                   'user_id' => $user_id,
                   'created_at' => date('Y-m-d h:i:s')]);
        $data['success'] = 1;
        $data['message'] = "Your request send successfully!";
      }else{
        $data['success'] = 0;
        $data['message'] = "You don't insufficient point.Please contact with seller";
      }
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
                   'sells.status',
                   'products.id as product_id',
                   'products.product_name',
                   'products.quantity',
                   'products.price',
                   'products.point')
                   ->paginate(20);

     return response()->json($sell);
  }
}
