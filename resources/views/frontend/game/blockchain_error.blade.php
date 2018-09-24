@extends('frontend.layouts.layout')
@section('title', 'Buy more ETH')
@section('content')
    <section class="game-checkout">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-container text-left sm">
                        <div class="title-wrap">
                            <h4 class="title">{{ __('label.game.checkout') }}</h4>
                            <span class="separator line-separator"></span>
                        </div>
                    </div>
                    <div class="alert alert-warning" role="alert">
                        <p>Ooops, We are sorry. There is some errors with the ETH, LTR Blockchain API. Try again later. Contact admin for support.</p>
                        <p> {{$error}} </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection