@extends('frontend.layouts.default')
@section('title', 'Login')
@section('content')
	<!-- Row -->
	<div class="row">
		<div class="col-md-offset-4 col-md-4 parent-has-overlay">
			<ul class="template-box box-login text-center">
				<!-- Page Template Logo -->
				<li class="logo-wrap">
					<a href="{{route('frontend.site.index')}}" class="logo">
						<img width="211" height="40" alt="Agenchy - Modern Multipurpose HTML5 Template" class="img-responsive" src="{{asset('frontend/images/default/logo.png')}}">
						<p class="slogan">Login to your Account</p>
					</a>
				</li><!-- Page Template Logo -->
				<!-- Page Template Content -->
				<li class="template-content">
					<div class="contact-form">
						<p style="color: #f00">
				      		{{$errors->first()}}
					    </p> 
						<!-- Form Begins -->
						<form name="bootstrap-form" action="{{route('frontend.site.pLogin')}}" method="POST">
							{{csrf_field()}}
							<!-- Field 1 -->
							<div class="input-text form-group">
								<input type="text" name="email" class="input-name form-control" placeholder="Email" value="{{old('email')}}" />
							</div>
							<!-- Field 2 -->
							<div class="input-email form-group text-left">
								<!-- <a class="pull-right" href="#">(Lost Password?)</a> -->
								<label>Password</label>
								<input type="password" name="password" value="" class="form-control" placeholder="Password" />
							</div>
							<!-- Button -->
							<button class="btn" type="submit">Login</button>
							<a href="{{route('frontend.site.vRegister')}}" class="btn">Sign up Now</a>
						</form><!-- Form Ends -->
					</div>	
				</li><!-- Page Template Content -->
			</ul>
		</div><!-- Column -->
	</div><!-- Row -->
	<style type="text/css">
		.page-default {
	        padding-top: 10%;
    		padding-bottom: 19.8%;
		}
	</style>
@stop
		