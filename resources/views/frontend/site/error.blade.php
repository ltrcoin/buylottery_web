@extends('frontend.layouts.default')
@section('title', 'Error')
@section('content')
	<!-- Row -->
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<ul class="template-box box-404 parent-has-overlay">
				<!-- Page Template Logo -->
				<li class="logo-wrap">
					<a href="{{route('frontend.site.index')}}" class="logo">
						<img width="211" height="40" alt="Lottery error" class="img-responsive" src="{{asset('frontend/images/default/logo.png')}}">
						<p class="slogan">404 - Page not found</p>
					</a>
				</li><!-- Page Template Logo -->
				<!-- Page Template Content -->
				<li class="template-content text-center">
					<h1>Oops,</h1>
					<p>We Can't find the page you're looking for. But Don't Worry. Here are a couple of helpful links</p>
					<a href="{{route('frontend.site.index')}}" class="btn">Back to home</a>
					<!--<a href="page-sitemap.html" class="btn">View Sitemap</a> -->
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