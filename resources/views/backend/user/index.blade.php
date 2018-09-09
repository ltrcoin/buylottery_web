@extends('backend.layouts.main')
@section('title', 'User')
@section('content')
@inject('common', 'App\Http\Services\Common')

<link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap.css')}}">
@if (Session::has('msg_user'))
   	<script type="text/javascript">
   	$(function() {
   		jAlert('{{Session::get("msg_user")}}', 'Thông báo');
   	});
   	</script>
@endif
<section class="content-header">
		<ul class="nav nav-tabs">
				<li class=""><a href="{{route('organize.index')}}">{{__('label.organize.organize_list')}}</a></li>
				<li class=""><a href="{{route('backend.group.index')}}">{{__('label.group.list')}}</a></li>
				<li class="active"><a href="#">{{__('label.users.list')}}</a></li>
		  </ul>
  <ol class="breadcrumb">
    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('backend.site.logout')}}"><i class="fa fa-dashboard"></i> Logout</a></li>
    <li class="active">{{__('label.users.list')}}</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<div class="row">
				  		<div class="col-sm-2">
							<a class="btn btn-primary" href="{{route('backend.user.vAdd')}}">{{__('label.users.add')}}</a>
						</div>
						<div class="col-sm-3">
						</div>
				  	</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
						<div class="row">
							<div class="col-sm-1">
								<button type="button" class="btn btn-danger deleteAll">{{ __('label.delete') }}</button>
								<input type="hidden" id="delUrl" value="{{url('admin/user/delete')}}">
							</div>
							<div class="col-sm-11">
								<div class="dataTables_length pull-right" id="example1_length">
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
											<th width="15%">{{__('label.users.title')}}</th>
							        		<th width="20%">{{__('label.users.name')}}</th>
							        		<th width="20%">Email</th>
							        		<th width="35%">{{__('label.users.group')}}</th>
							        		<th width="10%">{{__('label.users.option')}}</th>
						        		</tr>
				        			</thead>
				        			<tbody>
				        				@forelse ($listUser as $key => $item) 
				              			<tr class="{{$key%2 == 0 ? 'even' : 'odd'}}">
				              				<td>
				              					<input type="checkbox" class="checkItem" value="{{$item->id}}">
											</td>
											<td>{{$item->username}}</td>
							          		<td>{{$item->fullname}}</td>
							          		<td>{{$item->email}}</td>
											<td>{{ $common->getGroupUser($item->id) }}</td>
								          	<td class="text-center">
								          		<a href="{{route('backend.user.vEdit',['id'=>$item->id])}}" class="editItem" id="" title="Sửa"><i class="fa fa-fw fa-edit"></i></a>
								          		<a href="javascript: void(0);" class="deleteItem" id="{{$item->id}}" title="Xóa"><i class="fa fa-fw fa-remove"></i></a>
								          	</td>
								        </tr>
								        @empty
								    	<tr class="even">
								    		<td colspan="9" style="font-style: italic;">{{__('label.no_data')}}</td>
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
	      							{{ $listUser->appends($filter)->links() }}
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
@stop