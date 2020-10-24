<?php

namespace App\Http\Controllers;
use\setting;
use App\Slider;
use App\Category;
use App\Photo;
use App\Profile;
use App\Promotion;
use App\Movie;
use App\User;
use\DB;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use  Illuminate\Pagination\Paginator;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
     {
         $this->middleware('auth');
     }
    public function index(){
      $settings = DB::table('settings')->find('1');
      return view('admin.dashboard',compact('settings'));
    }
    public function slider(){
      $sliders = DB::table('sliders')->get();
      $settings = DB::table('settings')->find('1');
      return view('admin.slider',compact('settings','sliders'));
    }
    public function sliderSave(Request $request){
      $image=$request->file('slider_image');
      if ($image) {
        $image_name = $image->getClientOriginalName();
        $upload_path = 'images/slider/';
        $image->move($upload_path, $image_name);
        $image_url = $upload_path.$image_name;
        $slider = new Slider;
        $slider->slider=$image_url;
        $slider->save();
      }
      return back();
    }
    public function sliderDelete($id){
      $slider = Slider::find($id);
      if(file_exists($slider->slider)){
        @unlink($slider->slider);
        }
       if(!is_null($slider)){
         $slider->delete();
       }
       session()->flash('success','Product Delete Successfully!');
       return back();
    }

      public function Users()  {
        $users = DB::table('profiles')
                    ->select('*')
                    ->join('users', 'users.id', '=', 'profiles.user_id')
                    ->where('users.role','user')
                    ->get();
        $settings = DB::table('settings')->find('1');
        return view('admin.users',compact('settings','users'));
      }
      public function Admins()  {
        $users = DB::table('profiles')
                    ->select('*')
                    ->join('users', 'users.id', '=', 'profiles.user_id')
                    ->where('users.role','admin')
                    ->get();
        $settings = DB::table('settings')->find('1');
        return view('admin.admins',compact('settings','users'));
      }
      public function saveAdmin(Request $request){
      $user=User::create([
            'name' => $request->name,
            'lname' => $request->lname,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $data['first_name'] = $request->name;
        $data['photo'] = 'images/user/user.jpg';
        $data['last_name'] = $request->lname;
        $data['email'] = $request->email;
        $data['facebook'] = '#';
        $data['twitter'] = '#';
        $data['youtube'] = '#';
        $data['linkin'] = '#';
        $data['user_id'] =$user->id;
        Profile::create($data);
        session()->flash('success','Admin Add Successfully!');
        return back();
      }
      public function adminDelete($id){
          $user = User::find($id);
          $profile = Profile::where('user_id',$id)->first();
          if(file_exists($profile->photo)){
            @unlink($profile->photo);
            }
           if(!is_null($profile)){
             $profile->delete();
             $user->delete();
             session()->flash('danger','Admin Delete Successfully!');
           }
           return back();
        }

    public function setting()  {
        $settings = DB::table('settings')->find('1');
      return view('admin.setting', ['settings' => $settings]);
    }

    public function settingUpdate(Request $request){
      $image=$request->file('logo');
      $favicon=$request->file('favicon');
      if ($image) {
        $image_name = $image->getClientOriginalName();
        $upload_path = 'images/logo/';
        $image->move($upload_path, $image_name);
        $image_url = $upload_path.$image_name;
        $data['logo'] = $image_url;
        $data['title'] = $request->title;
        $data['header1'] = $request->header1;
        $data['header2'] = $request->header2;
        $data['facebook'] = $request->facebook;
        $data['twitter'] = $request->twitter;
        $data['youtube'] = $request->youtube;
        $data['gmail'] = $request->gmail;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['description'] = $request->description;
        $data['footer'] = $request->footer;
        DB::table('settings')->where('id',$request->id)->update($data);
      }elseif($favicon){
        $image_name = $favicon->getClientOriginalName();
        $upload_path = 'images/logo/';
        $favicon->move($upload_path, $image_name);
        $image_url = $upload_path.$image_name;
        $data['favicon'] = $image_url;
        $data['title'] = $request->title;
        $data['header1'] = $request->header1;
        $data['header2'] = $request->header2;
        $data['facebook'] = $request->facebook;
        $data['twitter'] = $request->twitter;
        $data['youtube'] = $request->youtube;
        $data['gmail'] = $request->gmail;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['description'] = $request->description;
        $data['footer'] = $request->footer;
        DB::table('settings')->where('id',$request->id)->update($data);
      }else{
        $data['header1'] = $request->header1;
        $data['title'] = $request->title;
        $data['header2'] = $request->header2;
        $data['facebook'] = $request->facebook;
        $data['twitter'] = $request->twitter;
        $data['youtube'] = $request->youtube;
        $data['gmail'] = $request->gmail;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['description'] = $request->description;
        $data['footer'] = $request->footer;
        DB::table('settings')->where('id',$request->id)->update($data);
      }

      return back();
    }
  public function terms()  {
        $settings = DB::table('settings')->find('1');
          $terms = DB::table('terms')->orderBy('id','DESC')->first();
      return view('admin.terms', ['terms' => $terms], ['settings' => $settings]);
    }
    public function updateTerms(Request $request){
        $data['text'] = $request->text;
        DB::table('terms')->where('id',$request->id)->update($data);
        session()->flash('success','Terms And Condition Update Successfully!');
      return back();
    }

    public function policy()  {
        $settings = DB::table('settings')->find('1');
          $policy = DB::table('policy')->orderBy('id','DESC')->first();
      return view('admin.policy', ['policy' => $policy], ['settings' => $settings]);
    }
    public function updatePolicy(Request $request){
      $data['text'] = $request->text;
      DB::table('policy')->where('id',$request->id)->update($data);
      session()->flash('success','Privacy And Policy Update Successfully!');
    return back();

      return back();
    }

}
