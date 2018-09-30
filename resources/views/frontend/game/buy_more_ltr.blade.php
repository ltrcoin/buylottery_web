@extends('frontend.layouts.layout')
@section('title', 'By LTR')
@section('content')
    <section class="game-checkout">
        <div class="container">
            <form method="post" action="{{ route('frontend.game.buyltr') }}">
                {{ csrf_field() }}
                 
                <div class="panel panel-info">
                    
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4>By LTR Now</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="account_no">{{ __('label.checkout.account_no') }}</label>
                                <input id="account_no" class="form-control" type="text" name="account_no" value="{{Auth::guard('web')->user()->wallet_ltr}}" readonly>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="ltr_account_balance">LTR {{ __('label.checkout.account_balance') }}</label>
                                <input id="ltr_account_balance" class="form-control" type="text" name="ltr_account_balance" value="{{$ltr_balance}}" readonly>

                            </div><div class="form-group col-md-12">
                                <label for="eth_account_balance">ETH {{ __('label.checkout.account_balance') }}</label>
                                <input id="eth_account_balance" class="form-control" type="text" name="eth_account_balance" value="{{$eth_balance}}" readonly>
                            </div>

                            </div><div class="form-group col-md-12">
                                <label for="eth_account_balance">Enter the number of LTR to buy</label>
                                <input id="eth_account_balance" class="form-control" type="text" name="ltr_more" value="{{$ltr_more}}">
                            </div>

                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn pull-right" type="submit">Buy Now</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection

@section('js')
    <script src="{{ asset('frontend/js/lib/moment.min.js') }}"></script>
    <script src="{{ asset('frontend/js/lib/moment-timezone-with-data.min.js') }}"></script>
    <script src="{{ asset('frontend/js/lib/jquery.countdown.min.js') }}"></script>
    <script>
      $(document).ready(function () {
        var countDown = $('.count-down-draw');

        countDown.each(function () {
          var that = $(this);
          var finalDate = moment.tz(that.html(), 'UTC');

          that.countdown(finalDate.toDate(), function (event) {
            that.html(event.strftime('{{ __('label.count_down_format') }}'));
          }).on('finish.countdown', function (event) {
            that.html('Wait for the next draw');
          })
        })
      })
    </script>
@endsection