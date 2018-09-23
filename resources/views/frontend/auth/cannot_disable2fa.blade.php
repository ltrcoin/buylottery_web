@extends('frontend.layouts.layout')
@section('title', 'Disable 2FA')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Two Factor Authentication</strong></div>
                       <div class="panel-body">
                           <p>Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.</p>
                           <br/>
                           <p>To Enable Two Factor Authentication on your Account, you need to do following steps</p>
                           <strong>
                           <ol>
                               <li>Click on Generate Secret Button , To Generate a Unique secret QR code for your profile</li>
                               <li>Verify the OTP from Google Authenticator Mobile App</li>
                           </ol>
                           </strong>
                           <br/>
 
                       @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                       <div class="alert alert-success">
                           2FA is Currently <strong>Empty</strong> for your account. You can not Disable an Empty 2FA. 
                       </div>
                       
                       <form class="form-horizontal" method="GET" action="{{ route('frontend.site.index') }}">
                       
                           <button type="submit" class="btn btn-primary ">I Understand ! Back Home Page</button>
                      
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection