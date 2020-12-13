<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use\DB;
use\Hash;
use App\User;

class ProductController extends Controller
{
  public function product_list(Request $request){
     $app_id=$request->input('app_id');
     $product_list = DB::table('products')
                   ->where('app_id', $app_id)
                   ->paginate(20);
       return response()->json($product_list);
  }
  public function category(Request $request){
     $app_id=$request->input('app_id');
     $category = DB::table('category')
                   ->where('app_id', $app_id)
                   ->get();
       return response()->json($category);
  }
  public function package_product(Request $request){
     $category_id=$request->input('category_id');
     if($category_id=='0'){
       $product_list = DB::table('package_products')
                     ->paginate(20);
         return response()->json($product_list);
     }else{
       $product_list = DB::table('package_products')
                     ->where('category_id', $category_id)
                     ->paginate(20);
         return response()->json($product_list);
     }

  }
}
