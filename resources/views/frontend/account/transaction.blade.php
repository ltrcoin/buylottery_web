@extends('frontend.layouts.layout')
@section('title', 'Transaction history')
@section('page_header')
<!-- Page Header -->
<div class="page-header bg-dark text-center">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<!-- Page Header Wrapper -->
				<div class="page-header-wrapper">
					<!-- Title & Sub Title -->
					<h3 class="title">Transaction history</h3>
					<h6 class="sub-title"></h6>
				</div><!-- Page Header Wrapper -->
			</div><!-- Coloumn -->
		</div><!-- Row -->
	</div><!-- Container -->
</div>
<!-- /Page Header -->
@stop
@section('content')
<div class="page-default bg-grey typo-dark">
	<!-- Container -->
	<div class="container">
		<div class="row shop-forms">
			<div class="col-sm-12">
				<div class="content-box shadow bg-lgrey">
					<table cellspacing="0" class="shop_table cart">
						<thead>
							<tr>
								<th class="product-thumbnail">&nbsp;</th>
								<th width="25%">Game</th>
								<th width="45%">Numbers</th>
								<th width="7%">Price</th>
								<th width="15%">Purchase date</th>
							</tr>
						</thead>
						<tbody>
							@forelse($list_data as $item)
							<tr class="cart_table_item">
								<td class="product-thumbnail">
									<a href="shop-product-sidebar.html">
										<img width="100" height="100" alt="" class="img-responsive" src="{{(isset($item->game) && $item->game->image != '') ? $item->game->image : asset('frontend/images/default/product-thumb-01.jpg')}}">
									</a>
								</td>
								<td>
									<a href="{{ route('frontend.game.play', ['alias' => $item->game->alias]) }}">{{isset($item->game) ? $item->game->name : ''}}</a>
								</td>
								<td>
									<div>
										@foreach(explode(',', $item->numbers) as $num)
					                    <span class="rs-number">{{$num}}</span>
					                    @endforeach
					                    @foreach(explode(',', $item->special_numbers) as $special)
					                    <span class="rs-number special">{{$special}}</span>
					                    @endforeach
				                  	</div>
								</td>
								<td>
									{{$item->price}} LTR
								</td>
								<td>
									{{$item->created_at}}
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="5">No data available.</td>
							</tr>
							@endforelse

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- Pagination -->
		<div class="row">
			<div class="col-sm-12">
				<nav class="text-center">
					{{$list_data->links() }}
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
	</div>
</div>
@stop