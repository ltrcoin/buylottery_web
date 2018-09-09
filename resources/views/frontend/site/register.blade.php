<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic -->
		<meta charset="utf-8">
		<title>The Lotter - Register</title>
		<meta name="keywords" content="The Lotter" />
		<meta name="title" content="Lottery Services Global">
		<meta name="description" content="Lottery Services Global">
		<meta name="author" content="">
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('frontend/images/default/logo.png') }}">
		<!-- Web Fonts  -->
		<link href='https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700|Playfair+Display:400,900italic,900,700italic,700,400italic' rel='stylesheet' type='text/css'>

		<!-- Lib CSS -->
		<link rel="stylesheet" href="{{asset('frontend/css/lib/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('frontend/css/lib/animate.min.css')}}">
		<link rel="stylesheet" href="{{asset('frontend/css/lib/font-awesome.min.css')}}">
		<link rel="stylesheet" href="{{asset('frontend/css/lib/gloryicon.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/css/lib/gap-icons.css')}}">
		<link rel="stylesheet" href="{{asset('frontend/css/lib/owl.carousel.css')}}">
		<link rel="stylesheet" href="{{asset('frontend/css/lib/prettyPhoto.css')}}">
		<link rel="stylesheet" href="{{asset('frontend/css/lib/menu.css')}}">
		<link rel="stylesheet" href="{{asset('frontend/css/lib/timeline.css')}}">
		
		<!-- Revolution CSS -->
		<link rel="stylesheet" href="revolution/css/settings.css')}}">
		<link rel="stylesheet" href="revolution/css/layers.css')}}">
		<link rel="stylesheet" href="revolution/css/navigation.css')}}"> 
		
		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{asset('frontend/css/theme.css')}}">
		<link rel="stylesheet" href="{{asset('frontend/css/theme-responsive.css')}}">
		
		<!--[if IE]>
			<link rel="stylesheet" href="{{asset('frontend/css/ie.css')}}">
		<![endif]-->
		
		<!-- Head Libs -->
		<script src="{{asset('frontend/js/lib/modernizr.js')}}"></script>
		
		<!-- Skins CSS -->
		<link rel="stylesheet" href="{{asset('frontend/css/skins/default.css')}}">
		
		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{asset('frontend/css/custom.css')}}">
	</head>
<body>

<!-- Page Loader -->
<div id="pageloader">
	<div class="loader-inner">
		<img src="{{asset('frontend/images/default/preloader.gif')}}" alt="Pre Loader" height="100" width="100">
	</div>
</div><!-- Page Loader -->

<!-- Back to top -->
<a href="#0" class="cd-top">Top</a>

		
<!-- Page Main -->
<div class="main relative bg-img bg-cover overlay bg-color heavy" data-background="/images/banner/bg-04.jpg"  data-stellar-background-ratio="0.5">
	<!-- Section -->
	<div class="page-default typo-dark">
		<!-- Container -->
		<div class="container">
			<!-- Row -->
			<div class="row">
				<div class="col-md-offset-3 col-md-6 parent-has-overlay">
					<ul class="template-box box-login">
						<!-- Page Template Logo -->
						<li class="logo-wrap logo">
							<a href="{{route('frontend.site.index')}}">
								<img width="211" height="40" alt="Agenchy - Modern Multipurpose HTML5 Template" class="img-responsive" src="{{asset('frontend/images/default/logo.png')}}" style="margin: auto;">
							</a>
							<p class="slogan">Create Account (Or <a href="{{route('frontend.site.vLogin')}}">Sign In</a>)</p>
							
						</li><!-- Page Template Logo -->
						<!-- Page Template Content -->
						<li class="template-content text-left">
							<div class="contact-form">
								<!-- Form Begins -->
								<form id="register-form" action="{{route('frontend.site.pRegister')}}" method="POST" enctype="multipart/form-data">
									{{csrf_field()}}
									<!-- Field 1 -->
									<div class="input-text form-group {{$errors->has('fullname') ? 'has-error' : ''}}">
										{{-- <label class="required">Full Name</label> --}}
										<input type="text" name="fullname" class="input-name form-control" placeholder="Full Name" required maxlength="255" value="{{old('fullname')}}" />
										<span class="help-block">{{$errors->first('fullname')}}</span>
									</div>
									<!-- Field 1 -->
									<div class="input-text form-group {{$errors->has('email') ? 'has-error' : ''}}">
										{{-- <label class="required">Email</label> --}}
										<input type="email" name="email" class="input-name form-control" placeholder="Email" required maxlength="255" value="{{old('email')}}" />
										<span class="help-block">{{$errors->first('email')}}</span>
									</div>
									<!-- Field 1 -->
									<div class="input-text form-group {{$errors->has('tel') ? 'has-error' : ''}}">
										{{-- <label class="required">Phone</label> --}}
										<input type="tel" name="tel" class="input-name form-control" placeholder="Phone" required maxlength="50" value="{{old('tel')}}" />
										<span class="help-block">{{$errors->first('tel')}}</span>
									</div>
									<!-- Field 1 -->
									

									<div class="input-text form-group {{$errors->has('wallet_btc') ? 'has-error' : ''}}">
										{{-- <label class="required">Phone</label> --}}
										<input type="text" name="wallet_btc" class="input-name form-control" placeholder="Wallet BTC" required maxlength="150" value="{{old('wallet_btc')}}" />
										<span class="help-block">{{$errors->first('wallet_btc')}}</span>
									</div>
								
									


									<!-- Field 1 -->
									<div class="input-text form-group {{$errors->has('dob') ? 'has-error' : ''}}">
										{{-- <label class="required">Date of birth</label> --}}
										<input type="text" name="dob" class="input-name form-control" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Date of birth" required value="{{old('dob')}}" />
										<span class="help-block">{{$errors->first('dob')}}</span>
									</div>
									<div class="{{$errors->has('sex') ? 'has-error' : ''}}">
										<select name="sex" class="form-group form-control">
											<option value="">--Select gender--</option>
											@if(isset($listGender))
											@foreach($listGender as $key => $gender)
											<option value="{{$key}}" {{$key == old('sex') ? 'selected' : ''}}>{{$gender}}</option>
											@endforeach
											@endif
										</select>
										<span class="help-block">{{$errors->first('sex')}}</span>
									</div>
									<!-- Field 1 -->
									<div class="{{$errors->has('country') ? 'has-error' : ''}}">
										<select name="country" class="form-group form-control">
											<option value="">--Select country--</option>
											@if(isset($listCountry))
											@foreach($listCountry as $key => $country)
											<option value="{{$key}}" {{$key == old('country') ? 'selected' : ''}}>{{$country}}</option>
											@endforeach
											@endif
										</select>
										<span class="help-block">{{$errors->first('country')}}</span>
									</div>
									<!-- Field 1 -->
									<div class="input-text form-group {{$errors->has('address') ? 'has-error' : ''}}">
										{{-- <label class="required">Address</label> --}}
										<input type="text" name="address" class="form-control" placeholder="Address" maxlength="255" value="{{old('address')}}" />
										<span class="help-block">{{$errors->first('address')}}</span>
									</div>
									<!-- Field 2 -->
									<div class="{{$errors->has('portraitimage') || $errors->has('passportimage') ? 'has-error' : ''}}">
					                  	<input class="hidden" type="file" id="portraitimage" name="portraitimage" onchange="detectFace(this, 'blah', 'blah-passport')">
					                  	<button type="button" class="btn" onclick="document.getElementById('portraitimage').click();">Image portrait</button>
					                  	<input class="hidden" type="file" id="passportimage" name="passportimage" onchange="detectFace(this, 'blah-passport', 'blah')">
					                  	<button type="button" class="btn" onclick="document.getElementById('passportimage').click();">Image passport</button>
					                  	<p>
					                  		<img src="" id="blah" alt="" style="max-width: 45%;margin-top: 10px;margin-right: 5%;float: left;">
					                  		<img src="" id="blah-passport" alt="" style="max-width: 45%;margin-top: 10px;margin-left: 5%">
					                  	</p>
					                  	<span class="help-block">{{$errors->first("portraitimage")}}</span>
					                  	<span class="help-block">{{$errors->first("passportimage")}}</span>
					                </div>
									<!-- Field 2 -->
									<div class="input-text form-group {{$errors->has('password') ? 'has-error' : ''}}">
										{{-- <label class="required">Password</label> --}}
										<input type="password" name="password" class="form-control" placeholder="Password" required maxlength="255" />
										<span class="help-block">{{$errors->first('password')}}</span>
									</div>
									<!-- Field 2 -->
									<div class="input-email form-group {{$errors->has('re_password') ? 'has-error' : ''}}">
										{{-- <label class="required">Re-enter Password</label> --}}
										<input type="password" name="re_password" class="form-control" placeholder="Re-enter Password" required maxlength="255" />
										<span class="help-block">{{$errors->first('re_password')}}</span>
									</div>
									<!-- Button -->
									<button class="btn btn-block" id="submit-form" type="submit">Create my Account</button>
								</form><!-- Form Ends -->
							</div>	
						</li><!-- Page Template Content -->
					</ul>
				</div><!-- Column -->
			</div><!-- Row -->
		</div><!-- Container -->	
	</div><!-- Page Default -->
</div><!-- Page Main -->

<!-- library -->
<script src="{{asset('frontend/js/lib/jquery.js')}}"></script>
<script src="{{asset('frontend/js/lib/bootstrap.min.js')}}"></script>
<script src="{{asset('frontend/js/lib/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('frontend/js/lib/jquery.appear.min.js')}}"></script>
<script src="{{asset('frontend/js/lib/jquery.easing.min.js')}}"></script>
<script src="{{asset('frontend/js/lib/owl.carousel.min.js')}}"></script>
<script src="{{asset('frontend/js/lib/countdown.js')}}"></script>
<script src="{{asset('frontend/js/lib/counter.js')}}"></script>
<script src="{{asset('frontend/js/lib/charts.js')}}"></script>
<script src="{{asset('frontend/js/lib/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('frontend/js/lib/jquery.easypiechart.min.js')}}"></script>
<script src="{{asset('frontend/js/lib/jquery.mb.YTPlayer.min.js')}}"></script>
<script src="{{asset('frontend/js/lib/jquery.prettyPhoto.js')}}"></script>
<script src="{{asset('frontend/js/lib/jquery.stellar.min.js')}}"></script>
<script src="{{asset('frontend/js/lib/menu.js')}}"></script>
<script src="{{asset('frontend/js/lib/theme-panel.js')}}"></script>

<script src="{{asset('frontend/js/lib/modernizr.js')}}"></script>
<!-- Theme Base, Components and Settings -->
<script src="{{asset('frontend/js/theme.js')}}"></script>

<!-- Theme Custom -->
<script src="{{asset('frontend/js/custom.js')}}"></script>
<script type="text/javascript">
	function detectFace(el, id1, id2) {
		let faceId1 = window.URL.createObjectURL(el.files[0]);
		let faceId2 = $('#'+id2).attr('src');
		document.getElementById(id1).src = faceId1;
		/*if(faceId1 != '' && faceId2 != '') {
			var params = {

	        };
	      
	        $.ajax({
	            url: "https://westus.api.cognitive.microsoft.com/face/v1.0/verify?" + $.param(params),
	            beforeSend: function(xhrObj){
	                // Request headers
	                //xhrObj.setRequestHeader("Content-Type","application/json");
	                xhrObj.setRequestHeader("Content-Type","application/octet-stream");
	                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key","f8cdef31-a31e-4b4a-93e4-5f571e91255a");
	            },
	            type: "POST",
	            // Request body
	            data: {faceId1: faceId1, faceId2: faceId2},
	            success: function(res) {
	            	console.log(res);
	            }
	        })
	        .done(function(data) {
	            alert("success");
	        })
	        .fail(function() {
	            alert("error");
	        });	      
		}*/
	}

	$('#register-form input').change(function(e) {
		e.preventDefault();
		validateRegisForm($(this));
	});

	$('#submit-form').click(function(e) {
		e.preventDefault();
		validateRegisForm();
	});

	function validateRegisForm(_this) {
		$.ajax({
			type: 'POST',
			url: "{{route('frontend.site.validateRegister')}}",
			data: $('#register-form').serialize(),
			success: function(rsp) {
				if(_this != undefined) {
					let _name = $(_this).attr('name');
					if(rsp.error && rsp.data[_name] != undefined) {
						$(_this).closest('div').addClass('has-error');
						$(_this).closest('div').find('span.help-block').text(rsp.data[_name]);
					} else {
						$(_this).closest('div').removeClass('has-error');
						$(_this).closest('div').find('span.help-block').text('');
					}
					return false;
				} else {
					if(rsp.error) {
						$('#register-form .has-error').removeClass('has-error');
						$('#register-form .help-block').text('');
						$.each(rsp.data, function(index, val) {
							let el = $('#register-form input[name="' + index + '"], select[name="' + index + '"]');
							$(el).closest('div').addClass('has-error');
							$(el).closest('div').find('span.help-block').text(val);
						});
						return false;
					} else {
						$('#register-form').submit();
					}
				}
			}
		});
	}

</script>
</body>
</html>