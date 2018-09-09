@extends('backend.layouts.main')
@section('title', __('label.users.add'))
@section('content')
<style>
.select2-selection__choice{
	color: blue !important;
}
</style>
<section class="content-header">
	<h1>
		{{__('label.users.add')}}
		<small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{route('backend.user.index')}}">{{__('label.users.list')}}</a></li>
		<li class="active">{{__('label.users.add')}}</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<!-- /.col -->
		<div class="col-md-10 col-md-offset-1">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#addAccount" data-toggle="tab">{{__('label.users.add')}}</a></li>
				</ul>
				<div class="tab-content">
					<div class="active tab-pane" id="addAccount">
						<form class="form-horizontal" action="{{route('backend.user.pAdd')}}" method="POST">
							<p style="color: #f00">
						      {{$errors->first()}}
						    </p> 
							<div class="form-group {{$errors->has('fullname') ? 'has-error' : ''}}">
								<label for="inputName" class="col-sm-3 control-label required">{{__('label.users.name')}}</label>
								<div class="col-sm-9">
									<input type="text" name="fullname" class="form-control" id="inputName"  placeholder="{{__('label.users.name')}}">
									<span class="help-block">{{$errors->first("fullname")}}</span>
								</div>
							</div>
							<div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
								<label for="inputEmail" class="col-sm-3 control-label required">{{__('label.users.email')}}</label>
								<div class="col-sm-9">
									<input type="email" name="email" class="form-control" id="inputEmail"  placeholder="{{__('label.users.email')}}">
									<span class="help-block">{{$errors->first("email")}}</span>
								</div>
							</div>
							<div class="form-group">
								<label for="tel" class="col-sm-3 control-label">{{__('label.users.tel')}}</label>
								<div class="col-sm-9">
									<input type="text" name="tel" class="form-control" id="tel" placeholder="{{__('label.users.tel')}}">
								</div>
							</div>
							<div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
									<label for="password" class="col-sm-3 control-label">{{__('label.users.password')}}</label>
									<div class="col-sm-9">
										<input type="password" name="password" class="form-control" id="password"  placeholder="{{__('label.users.password')}}">
										<span class="help-block">{{$errors->first("password")}}</span>
									</div>
								</div>
								<div class="form-group {{$errors->has('repassword') ? 'has-error' : ''}}">
									<label for="repassword" class="col-sm-3 control-label">{{__('label.users.confirm_pass')}}</label>
									<div class="col-sm-9">
										<input type="password" name="repassword" class="form-control" id="repassword"  placeholder="{{__('label.users.confirm_pass')}}">
										<span class="help-block">{{$errors->first("repassword")}}</span>
									</div>
								</div>
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-9">
									<button type="submit" class="btn btn-primary">Save</button>
								</div>
							</div>
						</form>   
					</div>
					<!-- /.tab-pane -->
				</div>
				<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->

</section>
<!-- /.content -->
@stop