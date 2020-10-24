<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="creativelayers">
<!-- Global site tag (gtag.js) - Google Analytics -->

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-163803980-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-163803980-1');
</script>

<title>{{$settings->title}}</title>

<!-- Styles -->
<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" type="text/css" /><!-- Bootstrap -->
<link rel="stylesheet" href="{{asset('css/line-awesome.min.css')}}" type="text/css" /><!-- Icons -->

<link rel="stylesheet" href="{{asset('css/style.css')}}" type="text/css" /><!-- Style -->
<link rel="stylesheet" href="{{asset('css/responsive.css')}}" type="text/css" /><!-- Responsive -->
<link rel="stylesheet" href="{{asset('css/colors/colors.css')}}" type="text/css" /><!-- color -->

<link rel="shortcut icon" type="image/png" href="{{asset($settings->favicon)}}"/>
<style media="screen">
	.view-all-blog{
		background-color: #d90429;
	}
	.view-all-blog:hover{
		background-color: #80879d;
	}
	.single-product-info-a a{
		float:right;
		background-color:#05a081;
		border-radius: 3px;
    color: #ffffff;
    float: left;
    font-family: Roboto;
    font-size: 18px;
    font-weight: 500;
    margin-left: 30px;
    padding: 12px 30px;
    float: right;
	}
	.single-product-info-a a:hover{
		background-color:#05a081bd
	}
	.single-product-info-follow a{
		float:right;
		background: linear-gradient(0deg,#f0f0f0 0%,#d9042999 100%);
border-color: rgba(111, 111, 111, 0.98);
color: #1a1a1a;
		border-radius: 3px;
    color: #4a3232d1;
    float: left;
    font-family: Roboto;
    font-size: 18px;
    font-weight: 500;
    margin-left: 30px;
    padding: 8px 30px;
    float: right;
	}
	.single-product-info-follow a:hover{
		background-color:#05a081bd;
		color:white;
	}
	.follow{
		float:right;
		background: linear-gradient(0deg,#f0f0f0 0%,#d9042999 100%);
		border-color: rgba(111, 111, 111, 0.98);
		color: #1a1a1a;
		border: none;
		border-radius: 3px;
		color: #4a3232d1;
		float: left;
		font-family: Roboto;
		font-size: 18px;
		font-weight: 500;
		margin-left: 30px;
		padding: 8px 30px;
		float: right;
	}
	.follow:hover{
		background-color:#05a081bd;
		color:white;
	}
	.page-link{
		border-radius: 50%;
		background-color: #d90429;
    border-color: #d90429;
	}
	.page-team{
		background-color: #d90429;
    border-color: #d90429;
	}
</style>
</head>
<body>
<div class="page-loading">
	<div class="loadery"></div>
</div>
<div class="theme-layout">


	  @yield('content')
  @include('fontend.footer')

	<div class="account-popup-sec">
		<div class="acount-popup login-popup">
			<span class="close-popup"><i class="la la-close"></i></span>
			<h3>LOGIN</h3>
			<form method="POST" action="{{ route('login') }}">
        @csrf
				<div class="field-form">
					<input class="effect-16" type="text" placeholder="" name="email" value="{{ old('email') }}">
		            <label>Username or email address</label>
		            <span class="focus-border"></span>
				</div>
				<div class="field-form">
					<input class="effect-16" type="password" placeholder="" name="password">
		            <label>Password</label>
		            <span class="focus-border"></span>
				</div>
				<p>
					<input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1">
    				<label for="styled-checkbox-1">Remember me</label>
				</p>
				<a href="#" title="">Lost your password</a>
				<button type="submit">LOGIN</button>
				<div class="extra-login">
					<span>Or</span>
					<!-- <ul>
						<li class="connect-fb"><a href="#" title=""><i class="la la-facebook"></i> Facebook Connect</a></li>
						<li class="connect-twitter"><a href="#" title=""><i class="la la-twitter"></i> Twitter Connect</a></li>
					</ul> -->
				</div>
			</form>
		</div>
		<div class="acount-popup register-popup">
			<span class="close-popup"><i class="la la-close"></i></span>
			<h3>REGISTER</h3>
			<form method="POST" action="{{ route('register') }}">
					@csrf
				<div class="field-form">

					<input id="name" type="text" class="effect-16 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
		            <label>First Name</label>
		            <span class="focus-border"></span>
				</div>
				<div class="field-form">
					<input id="name" type="text" class="effect-16 @error('name') is-invalid @enderror" name="lname" value="{{ old('name') }}" required autocomplete="name" autofocus>
		            <label>Last Name</label>
		            <span class="focus-border"></span>
				</div>
				<div class="field-form">
					<input id="email" type="email" class="effect-16 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

					@error('email')
							<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
							</span>
					@enderror
		            <label>Email</label>
		            <span class="focus-border"></span>
				</div>
				<div class="field-form">
					<input id="password" type="password" class="effect-16 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
		            <label>Password</label>
		            <span class="focus-border"></span>
				</div>
				<div class="field-form">
					<input id="password-confirm" type="password" class="effect-16" name="password_confirmation" required autocomplete="new-password">
		            <label>Confirm Password</label>
		            <span class="focus-border"></span>
				</div>
				<input type="hidden" name="role" value="user">
				<button type="submit">REGISTER NOW</button>
				<p>By clicking on “Register Now” button you are accepting the <a href="#" title="">Terms & Conditions</a> </p>
			</form>
		</div>
	</div>

</div>

<!-- Script -->
<script type="text/javascript" src="{{asset('js/modernizr.js')}}"></script><!-- Modernizer -->
<script type="text/javascript" src="{{asset('js/jquery-2.1.1.js')}}"></script><!-- Jquery -->
<script type="text/javascript" src="{{asset('js/script.js')}}"></script><!-- Script -->
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script><!-- Bootstrap -->
<script type="text/javascript" src="{{asset('js/scrolltopcontrol.js')}}"></script><!-- ScrollTopControl -->
<script type="text/javascript" src="{{asset('js/slick.min.js')}}"></script><!-- Slick -->
<script type="text/javascript" src="{{asset('js/scrolly.js')}}"></script><!-- Slick -->
<script type="text/javascript" src="{{asset('js/sumoselect.js')}}"></script><!-- Nice Select -->
<script type="text/javascript" src="{{asset('js/choosen.min.js')}}"></script><!-- Nice Select -->
<script type="text/javascript" src="{{asset('js/rangeslider.js')}}"></script><!-- Nice Select -->
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCYc537bQom7ajFpWE5sQaVyz1SQa9_tuY&sensor=true&libraries=places"></script>
<script type="text/javascript" src="{{asset('js/maps3.js')}}"></script><!-- Nice Select -->
<script type="text/javascript" src="{{asset('js/jquery.jigowatt.js')}}"></script><!-- Form -->
<script type="text/javascript" src="{{asset('js/poptrox.js')}}"></script><!-- Nice Select -->

</body>
</html>
