<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Laravel') }}</title>
<meta name="keywords" content=" ">
<meta name="description" content=" ">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
<link href='//fonts.googleapis.com/css?family=Roboto:100,200,300,400,500,600,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link href="//cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet" type="text/css" />

<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/css/bootstrapvalidator.min.css" rel="stylesheet">

<link href="{{ asset('css/nav.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"> </script>

<!-- jquery validation -->
<script src="//cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>

<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/select-table.js') }}"></script>

@stack('head-scripts')
@stack('head-css')
</head>
<body>
<div class="primary-nav">
<button href="#" class="hamburger open-panel nav-toggle">
<span class="screen-reader-text">Menu</span>
</button>
<div role="navigation" class="menu">
		<a href="#" class="logotype"><img src="{{asset('images/logo.png')}}" alt="logo"></a>
		@include('partials.leftmenu')
  </nav>
		</div><!--overflow-container-->
	</div>
</div><!--primary-nav-->

<div class="new-wrapper">

	<div class="container-fluid top">
		<div class="col-lg-5 user-log">
			<ul>	
				<li>Company: @if(Session::get('company_name')) {{Session::get('company_name')}} @endif</li>
				<li>,</li>
				<li>Branch Group: @if(Session::get('branch_group')) {{Session::get('branch_group')}} @endif</li>
				<li>,</li>
				<li>Branch:  @if(Session::get('branch_name')) {{Session::get('branch_name')}} @endif</li>
			</ul>
		</div><!--user-log-->
		
		<div class="col-lg-2 center-logo text-center">
			<img src="{{asset('images/center-logo.jpg')}}">
		</div>
		<div class="col-lg-5">
		<div class="row">
			<div class="col-sm-5 text-left">
		<p>	Welcome : {{ Auth::user()->DESCRIPTIONS }} </p>
</div>

<div class="col-sm-6  text-left">
		<p>	Login Date : @if(Session::get('login_date')) {{Session::get('login_date')}} @endif
			<span style="margin-left:10px">Time : @if(Session::get('login_time')) {{Session::get('login_time')}} @endif</span>
		</p>	

</div>
<div class="col-sm-1  text-right">
	<p>
			<span style="margin-left:10px;">
			<a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
			<i class="fa fa-sign-out" aria-hidden="true" style="color:#FFF;font-size:16px;" title="Logout"  ></i>
			</a>


			<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
				@csrf
			</form>
			</span>
</p>
</div>
					
			</div>
			
		</div><!--user-log-->
	</div><!--top-->	

	@yield('content')
	
</div> <!-- new-wrapper -->

<!-- Alert -->
	@yield('alert')
<!-- Alert end-->


	@stack('bottom-scripts')
	@stack('bottom-css')

</body>
</html>

