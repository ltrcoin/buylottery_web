@extends('frontend.layouts.layout')
@section('title', 'Home')
@section('content')
    <div class="row">
      <div role="alert" class="alert alert-danger text-center"> 
        <strong>LTR Alpha Test Version, First Lottery Services Global Base On BlockChain</strong>
      </div>
    </div>
    <!-- Section -->
  <section class="bg-grey">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <div class="owl-carousel dots-inline"
                       data-animatein=""
                       data-animateout=""
                       data-items="1"
                       data-loop="true"
                       data-merge="true"
                       data-nav="true"
                       data-dots="false"
                       data-stagepadding=""
                       data-margin="30"
                       data-mobile="1"
                       data-tablet="3"
                       data-desktopsmall="3"
                       data-desktop="4"
                       data-autoplay="false"
                       data-delay="3000"
                       data-navigation="true">
                      @foreach($games as $item)
                      <div class="item game-item-owl">
                        <div class="img">
                          <img class="img-responsive" src="{{ asset('upload/'.$item['game']->image) }}" alt="{{ $item['game']->name }}">
                        </div>
                        @if($item['prize'])
                        <span style="font-size: 27px;font-weight: 450;">{{ number_format($item['prize']->prize) }}</span>&nbsp;
                        <span style="font-size: 15px;">{{$item['prize']->unit}}</span>
                        @else
                        <h4>{{ $item['game']->name }}</h4>
                        @endif
                        <a class="btn" href="{{ route('frontend.game.play', ['alias' => $item['game']->alias]) }}">{{ __('label.play') }}</a>
                        <span class="count-down-draw" data-final-date="{{ $item['game']->getNextDraw() }}">{{ $item['game']->getNextDraw() }}</span>
                      </div>
                      @endforeach
                  </div><!-- carousel -->
              </div><!-- Column -->
          </div><!-- Row -->
      </div><!-- Container -->
  </section><!-- Section -->

  <section class="typo-dark img-box-sm-col rs-section bg-lgrey lottery-results">
    <div class="container">
      <div class="row">
        <!-- Title -->
        <div class="col-md-12">
          <div class="title-container text-left sm">
            <div class="title-wrap">
              <h3 class="title">Lottery Results</h3>
              <span class="separator line-separator"></span>
            </div>              
          </div>
        </div><!-- Title -->
      </div>
      <div class="row shop-forms">
        <div class="col-sm-12">
          <div class="content-box shadow bg-lgrey">
            <table cellspacing="0" class="shop_table cart">
              <!-- <thead>
                <tr>
                  <th class="product-thumbnail">&nbsp;</th>
                  <th width="40%">Game</th>
                  <th width="50%">Numbers</th>
                </tr>
              </thead> -->
              <tbody>
                @forelse($winnings as $key => $item)
                @foreach($item as $key => $winning)
                <tr class="cart_table_item">
                  <td class="product-thumbnail">
                    <img width="100" height="100" alt="" class="img-responsive" src="{{($winning->image != '') ? asset('upload/'.$winning->image) : asset('frontend/images/default/product-thumb-01.jpg')}}">
                  </td>
                  <td width="30%"><a href="{{ route('frontend.game.play', ['alias' => $winning->alias]) }}">{{$winning->name}}</a> &nbsp; (<b>{{$winning->draw_date}}</b>)</td>
                  <td width="50%">
                    <div>
                      @foreach(explode(',', $winning->numbers) as $num)
                      <span class="rs-number">{{$num}}</span>
                      @endforeach
                      @foreach(explode(',', $winning->special_numbers) as $special)
                      <span class="rs-number special">{{$special}}</span>
                      @endforeach
                    </div>
                  </td>
                  
                </tr>
                @endforeach
                @empty
                <tr>
                  <td colspan="3">No data available.</td>
                </tr>
                @endforelse
              </tbody>
              </table>
              @if(count($winnings) > 0)
              <div class="pull-right"><a href="{{route('frontend.winning.index')}}" title="View all">View all</a></div>
              @endif
            </div>
          </div>
        </div><!-- Row -->
    </div><!-- Container -->
  </section>

  <section class="typo-dark img-box-sm-col bg-grey">
  <div class="container">
    <div class="row">
      <!-- Title -->
      <div class="col-md-12">
        <div class="title-container text-left sm">
          <div class="title-wrap">
            <h3 class="title">Our winners!</h3>
            <span class="separator line-separator"></span>
          </div>              
        </div>
      </div><!-- Title -->
    </div>

    <div class="row">
      @if(!isset($demo))
      @php
        $customers = [
          ['G.A.', '10000', 'BTC', 'Euro Jackpot'],
          ['G.', '20000', 'BTC', 'Euro Jackpot'],
          ['M.A', '30000', 'BTC', 'Euro Jackpot'],
          ['G.T', '40000', 'BTC', 'Euro Jackpot'],
          ['J.S', '50000', 'BTC', 'Euro Jackpot'],
          ['N.H', '60000', 'BTC', 'Euro Jackpot'],
          ['N.B', '70000', 'BTC', 'Euro Jackpot'],
          ['Nataliia’s', '80000', 'BTC', 'Euro Jackpot'],
        ];
      @endphp
      @foreach($customers as $i => $item)
      <!-- Column -->
      <div class="col-md-3 col-sm-6 mrg-t-10">
        <!-- Content Box -->
        <div class="img-box-wrap">
          <div class="img-box-banner">
            <div class="img-box">
              <img width="417" height="320" alt="" class="img-responsive" src="{{asset('icon/demo/win'.$i.'.jpg')}}">
            </div>
            <!-- Image Box Links -->
            <ul class="link-set">
              <li><a href="{{route('frontend.winner.index')}}"><i class="icon icon-WorldGlobe"></i>View all</a></li>
              <li><a href="javascript: void(0);" onclick="viewWinnerDetail({{$i}})"><i class="icon icon-Goto"></i>Read More</a></li>
            </ul><!-- Image Box Links -->
          </div><!-- Image Box Banner -->
          <div class="img-box-details text-center">
            <p>{{$item[0]}}</p>
            <h4 class="title color-red">{{number_format($item[1])}} {{strtoupper($item[2])}}</h4>
            <p>{{$item[3]}}</p>
          </div><!-- Image Box Details -->
        </div><!-- Content Box -->
      </div><!-- Column -->
      @endforeach


      @else
      @forelse($winners as $winner)
      <!-- Column -->
      <div class="col-md-3 col-sm-6">
        <!-- Content Box -->
        <div class="img-box-wrap">
          <div class="img-box-banner">
            <div class="img-box">
              @php
                $src = '';
                if($winner->introimage != '') {
                  $src = $winner->introimage;
                } elseif(isset($winner->customer) && $winner->customer->portraitimage != '' ) {
                  $src = $winner->customer->portraitimage;
                } else {
                  $src = 'frontend/images/gallery/grid/4.jpg';
                }
              @endphp
              <img width="417" height="320" alt="{{$winner->customer->fullname}}" class="img-responsive" src="{{asset($src)}}">
            </div>
            <!-- Image Box Links -->
            <ul class="link-set">
              <li><a href="{{route('frontend.winner.index')}}"><i class="icon icon-WorldGlobe"></i>View all</a></li>
              <li><a href="about-reviews"><i class="icon icon-Goto"></i>Read More</a></li>
            </ul><!-- Image Box Links -->
          </div><!-- Image Box Banner -->
          <div class="img-box-details text-center">
            <p>{{$winner->customer->fullname}}</p>
            <h4 class="title color-red">{{number_format($winner->prize->value)}} {{strtoupper($winner->prize->unit)}}</h4>
            <p>{{$winner->game->name}}}</p>
          </div><!-- Image Box Details -->
        </div><!-- Content Box -->
      </div><!-- Column -->
      @empty
      No data available.
      @endforelse
      @endif
    </div><!-- Row -->
  </div><!-- Container -->
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