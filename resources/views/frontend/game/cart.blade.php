@extends('frontend.layouts.layout')
@section('title', 'Cart')
@section('content')
    <section class="game-checkout">
        <div class="container">
            <form method="post" action="{{ route('frontend.game.checkout') }}">
                {{ csrf_field() }}
                @if(!empty($games))
                @foreach($games as $gameId => $ticketInfo)
                    <input type="hidden" name="game_id[{{$gameId}}]" value="{{ $gameId }}">
                    <div class="panel panel-warning">
                        <div class="panel-heading game-header">
                            <img class="img img-responsive" src="{{ asset('upload/' . $ticketInfo['game']->image) }}"
                                 alt="{{ $ticketInfo['game']->name }}">
                            <h4>{{ $ticketInfo['game']->name }}</h4>
                            <div class="draw-time">
                                <span>{{ __('label.game.draw_close_in') }}</span>
                                <span class="count-down-draw"
                                      data-final-date="{{ $ticketInfo['game']->getNextDraw() }}">{{ $ticketInfo['game']->getNextDraw() }}</span>
                            </div>
                        </div>
                        <div class="panel-body" id="ticket-pick-area">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="number_of_ticket">{{ __('label.game.number_of_ticket') }}</label>
                                    <input class="form-control" type="number" name="number_of_ticket"
                                           id="number_of_ticket"
                                           readonly value="{{ count($ticketInfo['tickets']) }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">{{ __('label.game.cost') }}</label>
                                    <input type="text" class="form-control" readonly
                                           value="{{ number_format($ticketInfo['cost']) }}">
                                </div>
                                @foreach($ticketInfo['tickets'] as $key => $ticket)
                                    <div class="form-group col-md-12">
                                        <h5>{{ __('label.game.ticket') . ' #' . ($key + 1) }}</h5>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>{{ __('label.game.picked_numbers') }}</label>
                                        <input type="text" class="form-control" readonly name="numbers[{{$key}}]"
                                               value="{{ $ticket['normal'] }}">
                                    </div>
                                    @if(!empty($ticket['special']))
                                        <div class="form-group col-md-6">
                                            <label>{{ __('label.game.picked_special') }}</label>
                                            <input type="text" class="form-control" readonly name="specials[{{$key}}]"
                                                   value="{{ $ticket['special'] }}">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <p>{{ __('label.game.total_cost') }}: {{ number_format($totalCost) }} LTR</p>
                        </div>
                    </div>
                @endforeach
                @else
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <p>{{ __('label.checkout.empty_cart') }}</p>
                    </div>
                </div>
                @endif
                <div class="form-group">
                    <button @if(empty($games)) disabled @endif type="submit" class="btn pull-right">{{ __('label.game.checkout') }}</button>
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