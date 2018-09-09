@extends('frontend.layouts.layout')
@section('title', __( 'label.game.buy_ticket' ))
@section('content')
    <section class="game-play">
        <div class="container">
            <form method="post" action="">
                {{ csrf_field() }}
                <h3> Play now </h3>
                <input type="hidden" name="game_id" value="{{ $game->id }}">
                <div class="panel panel-warning">
                    <div class="panel-heading game-header">
                        <img class="img img-responsive" src="{{ asset('upload/'. $game->image) }}" alt="{{ $game->name }}">
                        <h4>{{ $game->name }}</h4>
                        <div class="draw-time">
                            <span>{{ __('label.game.draw_close_in') }}</span>
                            <span class="count-down-draw" data-final-date="{{ $game->getNextDraw() }}">{{ $game->getNextDraw() }}</span>
                        </div>
                    </div>
                    <div class="panel-body" id="ticket-pick-area"></div>
                </div>
                <input type="submit" value="Play game now">
            </form>
            <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal" style="display: none;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{ __('label.login_to_continue') }}</h4>
                        </div><!-- Model Header -->
                        <!-- Model Body -->
                        <div class="modal-body">
                            <div class="contact-model">
                                <form>
                                    <!-- Button -->
                                    <button class="btn" type="button">{{ __('label.login.btn_login') }}</button>
                                </form>
                            </div><!-- Contact Info -->
                        </div><!-- Model Body -->
                    </div><!-- Model Content -->
                </div><!-- Model Dialog -->
            </div>
        </div>
    </section>

@endsection

@section('js')
    <input type="hidden" name="game_info" value='{{ $gameInfo }}'>
    <script src="{{ asset('frontend/js/lib/moment.min.js') }}"></script>
    <script src="{{ asset('frontend/js/lib/moment-timezone-with-data.min.js') }}"></script>
    <script src="{{ asset('frontend/js/lib/jquery.countdown.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ractive/1.0.0-build-99/ractive.min.js"></script>
    <script src="{{ asset('frontend/js/play.js') }}"></script>
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