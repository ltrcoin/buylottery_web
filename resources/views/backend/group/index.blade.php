@extends('backend.layouts.main')
@section('title', __('label.group.list'))
@section('content')
<link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap.css')}}">
@if (Session::has('msg_group'))
   	<script type="text/javascript">
   	$(function() {
   		jAlert('{{Session::get("msg_group")}}', 'Thông báo');
   	});
   	</script>
@endif
<section class="content-header">
	<ul class="nav nav-tabs">
      	<li class=""><a href="{{route('organize.index')}}">{{__('label.organize.organize_list')}}</a></li>
      	<li class="active"><a href="#">{{__('label.group.list')}}</a></li>
      	<li class=""><a href="{{route('backend.user.index')}}">{{__('label.users.list')}}</a></li>
    </ul>
  	<ol class="breadcrumb">
	    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
	    <li class="active">{{__('label.group.list')}}</li>
  	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<div class="row">
						
				  	</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
						<div class="row">
							<div class="col-sm-3 col-md-3 col-xs-3">
								<button type="button" class="btn btn-danger deleteAll">{{__('label.delete')}}</button>
								<input type="hidden" id="delUrl" value="{{url('admin/group/delete')}}">
								<a class="btn btn-primary" href="{{route('backend.group.vAdd')}}">{{__('label.group.add')}}</a>
							</div>
							<div class="col-sm-4 col-md-4 col-xs-4">
							<form class="search-form" action="{{route('backend.group.index')}}" method="GET">
						        <div class="input-group input-group-sm">
						        	<input type="hidden" name="pageSize" id="sPageSize" value="{{$pageSize}}">
						          	<input type="text" name="name" id="sName" class="form-control" placeholder="{{__('label.search')}}..." value="{{isset($filter['name']) ? $filter['name'] : ''}}">
					              	<span class="input-group-btn">
					                	<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
					              	</span>
						        </div>
					      	</form>
							{{-- <button class="btn btn-primary" data-toggle="modal" data-target="#search">{{__('label.search')}}</button> --}}
						</div>
							<div class="col-sm-5 col-md-5 col-xs-5">
								<div class="dataTables_length pull-right">
									<label>
										Show <select class="form-control input-sm showPage">
											<option value="10" {{$pageSize == 10 ? 'selected' : ''}}>10</option>
											<option value="25" {{$pageSize == 25 ? 'selected' : ''}}>25</option>
											<option value="50" {{$pageSize == 50 ? 'selected' : ''}}>50</option>
											<option value="100" {{$pageSize == 100 ? 'selected' : ''}}>100</option>
										</select> entries
									</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
							        <thead>
							        	<tr>
							        		<th width="1%">
						                      	<input type="checkbox" id="checkAll">
						                 	</th>
							        		<th width="10%">{{__('label.group.code')}}</th>
							        		<th width="15%">{{__('label.group.name')}}</th>
							        		<th width="15%">{{__('label.group.organization')}}</th>
							        		<th width="5%">{{__('label.group.checkin')}}</th>
							        		<th width="5%">{{__('label.group.confirm')}}</th>
							        		<th width="5%">{{__('label.group.checkout')}}</th>
							        		<th width="5%">{{__('label.group.reject')}}</th>
							        		<th width="7%">Action</th>
						        		</tr>
				        			</thead>
				        			<tbody>
				        				@forelse ($listGroup as $key => $item)
				              			<tr class="{{$key%2 == 0 ? 'even' : 'odd'}}">
				              				<td>
				              					<input type="checkbox" class="checkItem" value="{{$item->id}}">
			              					</td>
							          		<td>{{$item->code}}</td>
								          	<td>{{$item->name}}</td>
								          	<td>{{$item->organization->name}}</td>
								          	<td class="text-center">
								          		@if(Auth::user()->hasAnyRole(['backend.group.reverseCheckin']))
								          		<a href="javascript: void(0);" class="reverseItem" data-id="{{$item->id}}" id="checkin{{$item->id}}" data-href="{{route('backend.group.reverseCheckin')}}"><i class="fa fa-fw {{$item->checkin == 1 ? 'fa-check-circle' : 'fa-question'}}"></i></a>
								          		@else
								          		<span><i class="fa fa-fw {{$item->checkin == 1 ? 'fa-check-circle' : 'fa-question'}}"></i></span>
								          		@endif
								          	</td>
								          	<td class="text-center">
								          		@if(Auth::user()->hasAnyRole(['backend.group.reverseConfirm']))
								          		<a href="javascript: void(0);" class="reverseItem" data-id="{{$item->id}}" id="confirm{{$item->id}}" data-href="{{route('backend.group.reverseConfirm')}}"><i class="fa fa-fw {{$item->confirm == 1 ? 'fa-check-circle' : 'fa-question'}}"></i></a>
								          		@else
								          		<span><i class="fa fa-fw {{$item->confirm == 1 ? 'fa-check-circle' : 'fa-question'}}"></i></span>
								          		@endif
								          	</td>
								          	<td class="text-center">
								          		@if(Auth::user()->hasAnyRole(['backend.group.reverseCheckout']))
								          		<a href="javascript: void(0);" class="reverseItem" data-id="{{$item->id}}" id="checkout{{$item->id}}" data-href="{{route('backend.group.reverseCheckout')}}"><i class="fa fa-fw {{$item->checkout == 1 ? 'fa-check-circle' : 'fa-question'}}"></i></a>
								          		@else
								          		<span><i class="fa fa-fw {{$item->checkout == 1 ? 'fa-check-circle' : 'fa-question'}}"></i></span>
								          		@endif
								          	</td>
								          	<td class="text-center">
								          		@if(Auth::user()->hasAnyRole(['backend.group.reverseReject']))
								          		<a href="javascript: void(0);" class="reverseItem" data-id="{{$item->id}}" id="reject{{$item->id}}" data-href="{{route('backend.group.reverseReject')}}"><i class="fa fa-fw {{$item->reject == 1 ? 'fa-check-circle' : 'fa-question'}}"></i></a>
								          		@else
								          		<span><i class="fa fa-fw {{$item->reject == 1 ? 'fa-check-circle' : 'fa-question'}}"></i></span>
								          		@endif
								          	</td>
								          	
								          	<td class="text-center">
								          		@if(Auth::user()->hasAnyRole(['backend.group.detail']))
								          		<a data-href="{{url('admin/group/detail')}}" class="viewItem" data-id="{{$item->id}}" title="{{__('label.detail')}}"><i class="fa fa-fw fa-eye"></i></a>
								          		@endif
								          		@if(Auth::user()->hasAnyRole(['backend.group.edit']))
								          		<a href="{{route('backend.group.vEdit',['id'=>$item->id])}}" class="editItem" id="" title="{{__('label.edit')}}"><i class="fa fa-fw fa-edit"></i></a>
								          		@endif
								          		@if(Auth::user()->hasAnyRole(['backend.group.delete']))
								          		<a href="javascript: void(0);" class="deleteItem" id="{{$item->id}}" title="{{__('label.delete')}}"><i class="fa fa-fw fa-remove"></i></a>
								          		@endif
								          	</td>
								        </tr>
								        @empty
								    	<tr class="even">
								    		<td colspan="11" style="font-style: italic;">{{__('label.no_data')}}</td>
								    	</tr>
									    @endforelse
							       	</tbody>
				      			</table>
			      			</div>
		      			</div>
		      			<div class="row">
		      				<div class="col-sm-5">
		      					<!-- <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 50 entries</div> -->
	      					</div>
	      					<div class="col-sm-7">
	      						<div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
	      							{{ $listGroup->appends($filter)->links() }}
	      						</div>
	      					</div>
	      				</div>
      				</div>    
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>
<script type="text/javascript">
	$('#sName').autocomplete({
	    source: function (query, result) {
            $.ajax({
                type: "GET",
                url: '{{url('admin/group/autocomplete')}}' + '/' + $('#sName').val(),            
                dataType: "json",
                success: function (data) {
					result($.map(data, function (item) {
						return item;
                    }));
                }
            });
        },
	    select: function (event, ui) {
	        $("#sName").val(ui.item.label); // display the selected text
	        //$("#organization_id").val(ui.item.id); // save selected id to hidden input
	    }
	});
</script>
@stop