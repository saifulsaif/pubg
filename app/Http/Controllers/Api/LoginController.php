<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use\DB;

class LoginController extends Controller
{
    public function index(){
      $users = DB::table('users')->get();
      return response()->json($users);
    }
}
