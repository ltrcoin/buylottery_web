@extends('frontend.layouts.layout')
@section('title', 'Profile')
@section('page_header')
<!-- Page Header -->
<div class="page-header bg-dark text-center">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<!-- Page Header Wrapper -->
				<div class="page-header-wrapper">
					<!-- Title & Sub Title -->
					<h3 class="title">Profile</h3>
					<h6 class="sub-title"></h6>
				</div><!-- Page Header Wrapper -->
			</div><!-- Coloumn -->
		</div><!-- Row -->
	</div><!-- Container -->
</div>
<!-- /Page Header -->
@stop
@section('content')
<section class="bg-grey">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-3 col-md-6">
				<div class="title-container text-left sm">
					<div class="title-wrap">
						<h4 class="title">Update Profile</h4>
						<span class="separator line-separator"></span>
					</div>							
				</div><!-- Name -->
				<!-- Form Begins -->
				<form action="{{route('frontend.account.pProfile')}}" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}
					<!-- Field 1 -->
					<div class="input-text form-group {{$errors->has('email') ? 'has-error' : ''}}">
						<label class="required">Email</label>
						<input type="email" name="email" class="input-name form-control" placeholder="Email" required maxlength="255" value="{{Auth::guard('web')->user()->email}}" disabled />
						<span class="help-block">{{$errors->first('email')}}</span>
					</div>
					<!-- Field 1 -->
					<div class="input-text form-group {{$errors->has('fullname') ? 'has-error' : ''}}">
						<label class="required">Full Name</label>
						<input type="text" name="fullname" class="input-name form-control" placeholder="Full Name" required maxlength="255" value="{{Auth::guard('web')->user()->fullname}}" />
						<span class="help-block">{{$errors->first('fullname')}}</span>
					</div>
					<!-- Field 1 -->
					<div class="input-text form-group {{$errors->has('tel') ? 'has-error' : ''}}">
						<label class="required">Phone</label>
						<input type="tel" name="tel" class="input-name form-control" placeholder="Phone" required maxlength="50" value="{{Auth::guard('web')->user()->tel}}" />
						<span class="help-block">{{$errors->first('tel')}}</span>
					</div>
					<!-- Field 1 -->
					<div class="input-text form-group {{$errors->has('wallet_btc') ? 'has-error' : ''}}">
						<label class="required">BTC Wallet Address</label>
						<input type="text" name="wallet_btc" class="input-name form-control" placeholder="Wallet BTC" required maxlength="150" value="{{Auth::guard('web')->user()->wallet_btc}}" />
						<span class="help-block">{{$errors->first('wallet_btc')}}</span>
					</div>
					<!-- Field 1 -->
					<div class="input-text form-group {{$errors->has('wallet_ltr') ? 'has-error' : ''}}">
						<label class="required">LTR Wallet Address</label>
						<input type="text" name="wallet_ltr" class="input-name form-control" placeholder="Wallet LTR" required maxlength="150" value="{{Auth::guard('web')->user()->wallet_ltr}}" disabled/>
						<span class="help-block">{{$errors->first('wallet_ltr')}}</span>
					</div>

					<!-- Field 1 -->
					<div class="input-text form-group {{$errors->has('dob') ? 'has-error' : ''}}">
						<label class="required">Date of birth</label>
						<input type="text" name="dob" class="input-name form-control" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Date of birth" required value="{{Auth::guard('web')->user()->dob}}" />
						<span class="help-block">{{$errors->first('dob')}}</span>
					</div>
					<div class="{{$errors->has('sex') ? 'has-error' : ''}}">
						<label class="">Gender</label>
						<select name="sex" class="form-group form-control">
							<option value="">--Select gender--</option>
							@if(isset($listGender))
							@foreach($listGender as $key => $gender)
							<option value="{{$key}}" {{$key == Auth::guard('web')->user()->sex ? 'selected' : ''}}>{{$gender}}</option>
							@endforeach
							@endif
						</select>
						<span class="help-block">{{$errors->first('sex')}}</span>
					</div>
					<!-- Field 1 -->
					<div class="{{$errors->has('country') ? 'has-error' : ''}}">
						<label class="">Country</label>
						<select name="country" class="form-group form-control">
							<option value="">--Select country--</option>
							@if(isset($listCountry))
							@foreach($listCountry as $key => $country)
							<option value="{{$key}}" {{$key == Auth::guard('web')->user()->country ? 'selected' : ''}}>{{$country}}</option>
							@endforeach
							@endif
						</select>
						<span class="help-block">{{$errors->first('country')}}</span>
					</div>
					<!-- Field 1 -->
					<div class="input-text form-group {{$errors->has('address') ? 'has-error' : ''}}">
						<label class="required">Address</label>
						<input type="text" name="address" class="form-control" placeholder="Address" maxlength="255" value="{{Auth::guard('web')->user()->address}}" />
						<span class="help-block">{{$errors->first('address')}}</span>
					</div>
					<!-- Field 2 -->
					<div class="{{$errors->has('portraitimage') || $errors->has('passportimage') ? 'has-error' : ''}}">
	                  	<input class="hidden" type="file" id="portraitimage" name="portraitimage" onchange="detectFace(this, 'blah', 'blah-passport')">
	                  	<button type="button" class="btn" onclick="document.getElementById('portraitimage').click();">Image portrait</button>
	                  	<input class="hidden" type="file" id="passportimage" name="passportimage" onchange="detectFace(this, 'blah-passport', 'blah')">
	                  	<button type="button" class="btn" onclick="document.getElementById('passportimage').click();">Image passport</button>
	                  	<p>
	                  		@if(Auth::guard('web')->user()->portraitimage != '')
	                  		<img src="" id="blah" alt="" src="{{asset(Auth::guard('web')->user()->portraitimage)}}" style="max-width: 45%;margin-top: 10px;margin-right: 5%;float: left;">
	                  		@else
	                  		<img src="" id="blah" alt="" style="max-width: 45%;margin-top: 10px;margin-right: 5%;float: left;">
	                  		@endif
							@if(Auth::guard('web')->user()->passportimage != '')
	                  		<img src="" id="blah-passport" alt="" src="{{asset(Auth::guard('web')->user()->passportimage)}}" style="max-width: 45%;margin-top: 10px;margin-left: 5%">
	                  		@else
	                  		<img src="" id="blah-passport" alt="" style="max-width: 45%;margin-top: 10px;margin-left: 5%">
	                  		@endif
	                  	</p>
	                  	<span class="help-block">{{$errors->first("portraitimage")}}</span>
	                  	<span class="help-block">{{$errors->first("passportimage")}}</span>
	                </div>
					<!-- Button -->
					<button class="btn btn-block" type="submit">Update</button>
				</form>
			</div><!-- Column -->
		</div><!-- Row -->
	</div><!-- Container -->
</section>
@stop