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
}
