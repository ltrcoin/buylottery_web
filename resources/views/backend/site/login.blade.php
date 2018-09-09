<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{asset('backend/bootstrap/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('backend/libout/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('backend/libout/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('backend/dist/css/AdminLTE.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('backend/plugins/iCheck/square/blue.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
    input[name="remember_token"]{
      position: absolute;
      top: -20%;
      left: -20%;
      display: block;
      width: 140%;
      height: 140%;
      margin: 0px;
      padding: 0px;
      background: rgb(255, 255, 255);
      border: 0px;
      opacity: 0;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo"><img src="{{asset('frontend/images/default/logo.png')}}" alt=""></a></div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">{{__('label.login.warn')}}</p>
    <p style="color: #f00">
      {{$errors->first()}}
    </p> 
    <form action="{{route('backend.site.pLogin')}}" method="post">
      <div class="form-group has-feedback {{$errors->has('email') ? 'has-error' : ''}}">
        <input type="text" name="email" class="form-control" placeholder="Email" value="{{old('email')}}">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <span class="help-block">{{$errors->first('email')}}</span>
      </div>
      <div class="form-group has-feedback {{$errors->has('passwords') ? 'has-error' : ''}}">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <span class="help-block">{{$errors->first('password')}}</span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <div class="icheckbox_square-blue">
                <input type="checkbox" name="remember_token">
                <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
              </div>
              {{__('label.login.remember_me')}}
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">{{__('label.login.btn_login')}}</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!-- <div class="social-auth-links text-center">
      <p>{{__('label.login.or')}}</p>
      <a href="{{route('backend.site.socicalRedirect',['social' => 'facebook'])}}" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> {{__('label.login.using_fb')}}Sign in using
        Facebook</a>
      <a href="{{route('backend.site.socicalRedirect',['social' => 'google'])}}" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> {{__('label.login.using_gg')}}</a>
    </div> -->
    <!-- /.social-auth-links -->

    <!-- <a href="{{route("backend.site.pResetPass")}}">{{__('label.login.forgot_pass')}}</a><br>
    <a href="register.html" class="text-center">Register a new membership</a> -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="{{asset('backend/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{asset('backend/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('backend/plugins/iCheck/icheck.min.js')}}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
