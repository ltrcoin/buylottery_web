@extends('frontend.layouts.layout')
@section('title', 'Our Winners')
@section('page_header')
<!-- Page Header -->
<div class="page-header bg-dark text-center">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<!-- Page Header Wrapper -->
				<div class="page-header-wrapper">
					<!-- Title & Sub Title -->
					<h3 class="title">Our Winners</h3>
					<h6 class="sub-title"></h6>
				</div><!-- Page Header Wrapper -->
			</div><!-- Coloumn -->
		</div><!-- Row -->
	</div><!-- Container -->
</div>
<!-- /Page Header -->
@stop
@section('content')
<div class="page-default bg-grey typo-dark shop-sm-col">
	<!-- Container -->
	<div class="container">
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
			<!-- Item Begins -->
			<div class="col-sm-6 col-md-3">
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
		              <!--     <ul class="link-set">
		                    <li><a href="index.html"><i class="icon icon-WorldGlobe"></i>View Website</a></li>
		                    <li><a href="about-reviews"><i class="icon icon-Goto"></i>Read More</a></li>
		                  </ul> --><!-- Image Box Links -->
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
		
		<!-- Pagination -->
		<div class="row">
			<div class="col-sm-12">
				<nav class="text-center">
					{{$winners->links() }}
					<!--<ul class="pagination">
						<li><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
						<li><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
					</ul> -->
				</nav><!-- Pagination -->
			</div><!-- Column -->
		</div><!-- Row -->
	</div><!-- Container -->
</div>
@stop