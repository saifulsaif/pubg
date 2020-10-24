<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use\setting;
use App\Slider;
use App\Photo;
use App\Profile;
use App\Follower;
use\DB;
use\Storage;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
  {



    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        if( Auth::user()){
           if(Auth::user()->role=='admin'){
             return redirect()->route('admin');
           }
        }
      $sliders = DB::table('sliders')->get();
      $settings = DB::table('settings')->find('1');
      return view('fontend.home',compact('settings','sliders'));
    }
  


}
