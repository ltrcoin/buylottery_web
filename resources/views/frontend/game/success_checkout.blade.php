@extends('frontend.layouts.layout')
@section('title', 'Success')
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
                    <div class="alert alert-success" role="alert">
                        <p>{{ __('label.checkout.success') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection