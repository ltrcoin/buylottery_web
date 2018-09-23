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
                        <p>Your account does not have enough ETH. Buy more ETH and try again. Tkks for buying Lottery with us.</p>
                        <p>You need to buy at least {{$eth_more}} ETH more </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection