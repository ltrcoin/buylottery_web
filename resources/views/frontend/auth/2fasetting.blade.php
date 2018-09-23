@extends('frontend.layouts.layout')
@section('title', 'Two factor authentication')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Two Factor Authentication Setting</strong></div>
                       <div class="panel-body">
                           <p>Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.</p>
                           <br/>
                            @if($status=='OFF')                              
                                     
                                      <a href="{{ route('frontend.ps.enable2fa') }}">
                                        <div class="col-md-2 col-md-offset-4">
                                            <button class="btn btn-primary">
                                               2FA is currently {{$status}}. Click To Turn ON
                                            </button>
                                        </div>
                                    </a>
                               
                            @endif
  
                      
 

                            @if($status=='ON')                              
                                     
                                      <a href="{{ route('frontend.ps.disable2fa') }}">
                                        <div class="col-md-2 col-md-offset-4">
                                            <button class="btn btn-primary">
                                               2FA is currently {{$status}}. Click To Turn OFF
                                            </button>
                                        </div>
                                    </a>
                               
                            @endif
                            
                             @if($status=='NULL')                              
                                     
                                      <a href="{{ route('frontend.ps.enable2fa') }}">
                                        <div class="col-md-2 col-md-offset-4">
                                            <button class="btn btn-primary">
                                               2FA is currently {{$status}}. Click To Generate 2FA Verification
                                            </button>
                                        </div>
                                    </a>
                               
                            @endif
                           
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection