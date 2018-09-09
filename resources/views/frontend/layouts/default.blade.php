<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic -->
		<meta charset="utf-8">
		<title>BuyLottery - @yield('title')</title>
		<meta name="keywords" content="" />
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
		<link rel="stylesheet" href="{{ asset("frontend/css/lib/bootstrap.min.css") }}">
		<link rel="stylesheet" href="{{ asset("frontend/css/lib/font-awesome.min.css") }}">
		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{ asset("frontend/css/theme.css") }}">
		<link rel="stylesheet" href="{{ asset("frontend/css/theme-responsive.css") }}">
		
		<!--[if IE]>
			<link rel="stylesheet" href="css/ie.css">
		<![endif]-->
		<!-- Skins CSS -->
		<link rel="stylesheet" href="{{ asset("frontend/css/skins/default.css") }}">
		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{ asset("frontend/css/custom.css") }}">
	</head>
<body>		
<!-- Page Main -->
<div class="main relative full-screen bg-img bg-cover overlay bg-color heavy" data-background="images/banner/bg-04.jpg"  data-stellar-background-ratio="0.5">
	<!-- Section -->
	<div class="page-default typo-dark">
		<!-- Container -->
		<div class="container">
			@yield('content')
		</div><!-- Container -->	
	</div><!-- Page Default -->
</div><!-- Page Main -->
</body>
</html>