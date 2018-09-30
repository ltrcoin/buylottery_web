@extends('frontend.layouts.layout')
@section('title', 'Success Buy LTR')
@section('content')
    <section class="game-checkout">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-container text-left sm">
                        <div class="title-wrap">
                            <h4 class="title">Success buy LTR from Lottery.org</h4>
                            <span class="separator line-separator"></span>
                        </div>
                    </div>
                    <div class="alert alert-success" role="alert">
                        <p>Thank you for buying LTR</p>
                        <p> Save Transaction Hash and check it on EtherScanIO</p>
                         
                            <p>You have just bought: {{$ltrtobuy }} LTR on this transaction:
                            <a href="https://etherscan.io/tx/{{$receipt['TxHash']}}" target="_blank">{{$receipt['TxHash']}} </a>                         

                            </p>      
                       
                        
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection