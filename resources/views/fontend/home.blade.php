@extends('fontend.index')
@section('content')
<div class="responive-header">
  <div class="logo"><a href="{{ route('home') }}" title=""><img src="{{asset($settings->logo)}}	" alt="" /></a></div>
  <span class="open-responsive-btn"><i class="la la-bars"></i><i class="la la-close"></i></span>
  <div class="resp-btn-sec">
      @guest
    <div class="acount-header-btn">
      <span class="register-btn">Register</span>/
      <span class="login-btn">LogIn</span>
    </div>
    @else
    @php
    $user_id=Auth::user()->id;
    $profile = App\Profile::where('user_id',$user_id)->first();
    @endphp
    <div class="acount-header-btn">
      <a href="{{route('profile')}}"><img style="border-radius: 50%;height: 55px;width: 55px;margin-top: 16px;margin-left: 10px" src="{{$profile->photo}}" alt=""></a>
      <span style="margin: 0px 0px 0 13px;color: #ffffff;font-family: Roboto;font-size: 16px;">{{ Auth::user()->name }}</span>
      <a href="{{ route('logout') }}" title="Logout"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
     <img style="border-radius: 50%;height: 40px;width: 40px;margin-top: 24px;margin-left: 10px"  src="{{asset('/images/logo/logout.png')}}">
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>

    </div>
    @endguest
    <div class="search-header">
      <span class="open-search"><i class="la la-search"></i><i class="la la-close"></i></span>
      <form>
        <input type="text" placeholder="Search">
      </form>
    </div>
  </div>
  <div class="responisve-menu">
    <span class="close-reposive"><i class="la la-close"></i></span>
    <div class="logo"><a href="{{ route('home') }}" title=""><img src="{{asset($settings->logo)}}"  alt="" /></a></div>
    <ul>

    </ul>
  </div>
</div><!-- Responsive-header -->
<header class="on-top">
  <div class="logo"><a href="{{ route('home') }}" title=""><img src="{{asset($settings->logo)}}" alt="" /></a></div>
  <div class="menu-sec">


      @guest
    <div class="acount-header-btn">
      <ul class="navbar-nav ml-auto">
          <!-- Authentication Links -->
      <span class="login-btn">LogIn</span>
      <span class="register-btn">Register</span>
    </div>
    @endguest
   @guest
       @else
   <div class="search-header">
        <div class="review-avatar">
          <a href="{{ route('logout') }}"  title="Logout"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
         <img style="border-radius: 50%;height: 40px;width: 40px;margin-top: 24px;margin-left: 10px"  src="{{asset('/images/logo/logout.png')}}">
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
     </div>
  </div>
   <div class="search-header">
     <h3 style="margin: 37px 0px 0 13px;color: #ffffff;font-family: Roboto;font-size: 16px;">{{ Auth::user()->name }}</h3>
  </div>
   <div class="search-header">
   <div class="review-avatar"> <a href="{{route('profile')}}"><img style="border-radius: 50%;height: 55px;width: 55px;margin-top: 16px;margin-left: 10px" src="{{$profile->photo}}" alt=""></a> </div>
  </div>
   <a href="{{ route('logout') }}"  onclick="event.preventDefault();	 document.getElementById('logout-form').submit();" title="" class="add-listing-btn"> </a>
@endguest

    <nav class="header-menu">
      <ul>

      </ul>
    </nav>
  </div>
</header>

<section>
  <div class="block no-padding">
    <div class="row">
      <div class="col-md-12">
        <div class="main-featured-sec">
          <ul class="featured-bg-slide">
            @foreach($sliders as $slider)
            <li><img src="{{ asset($slider->slider) }}" alt="" /></li>
            @endforeach
          </ul>
          <div class="mian-featured-area">
            <div class="main-featured-text">
              <h1>{{$settings->header1}}</h1>
              <span>{{$settings->header2}}</span>
            </div>

            <div class="cat-lists">
              <!-- <ul>
                <li><a href="#" title=""><i class="la la-car"></i><span>Cars</span></a></li>
                <li><a href="#" title=""><i class="la la-spoon"></i><span>Food & Drinks</span></a></li>
                <li><a href="#" title=""><i class="la la-plane"></i><span>Travels</span></a></li>
                <li><a href="#" title=""><i class="la la-briefcase"></i><span>Business</span></a></li>
                <li><a href="#" title=""><i class="la la-shopping-cart"></i><span>Shoppings</span></a></li>
              </ul> -->
            </div>
            <a class="arrow-down floating" href="#scroll-here" title=""><i class="la la-angle-down"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
