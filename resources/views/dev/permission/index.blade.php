@extends('dev.layouts.main')
@section('title', 'Permission')
@section('content')

<link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap.css')}}">
@if (Session::has('msg_permissionPermission'))
   	<script type="text/javascript">
   	$(function() {
   		jAlert('{{Session::get("msg_permission")}}', 'Thông báo');
   	});
   	</script>
@endif
<section class="content-header">
  <h1>
    List Permission
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('dev.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">List Permission</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<div class="row">
				  		<div class="col-sm-2">
							<a class="btn btn-primary" href="{{route('dev.permission.vAdd')}}">Add New Permission</a>
						</div>
						<div class="col-sm-3">
							<button class="btn btn-primary" data-toggle="modal" data-target="#search">Search</button>
						</div>
				  	</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
						<div class="row">
							<div class="col-sm-1">
								<button type="button" class="btn btn-danger deleteAll">Delete</button>
								<input type="hidden" id="delUrl" value="{{url('dev/permission/delete')}}">
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
								<table id="example1" class="table table-bordered table-striped dataTable" permission="grid" aria-describedby="example1_info">
							        <thead>
							        	<tr>
							        		<th width="1%">
						                      	<input type="checkbox" id="checkAll">
						                 	</th>
							        		<th width="30%">Name</th>
							        		<th width="30%">Description</th>
							        		<th width="10%">Action</th>
						        		</tr>
				        			</thead>
				        			<tbody>
				        				@forelse ($listPermission as $key => $item) 
				              			<tr class="{{$key%2 == 0 ? 'even' : 'odd'}}">
				              				<td>
				              					<input type="checkbox" class="checkItem" value="{{$item->permission_id}}">
			              					</td>
							          		<td>{{$item->permission_id}}</td>
							          		<td>{{$item->description}}</td>
								          	<td class="text-center">
								          		<a href="{{route('dev.permission.vEdit',['id'=>$item->permission_id])}}" class="edit" id="" title="Sửa"><i class="fa fa-fw fa-edit"></i></a>
								          		<a href="javascript: void(0);" class="delete" id="{{$item->permission_id}}" title="Xóa"><i class="fa fa-fw fa-remove"></i></a>
								          	</td>
								        </tr>
								        @empty
								    	<tr class="even">
								    		<td colspan="9" style="font-style: italic;">Không có dữ liệu</td>
								    	</tr>
									    @endforelse
							       	</tbody>
				      			</table>
			      			</div>
		      			</div>
		      			<div class="row">
		      				<div class="col-sm-5">
		      					<!-- <div class="dataTables_info" id="example1_info" permission="status" aria-live="polite">Showing 1 to 10 of 50 entries</div> -->
	      					</div>
	      					<div class="col-sm-7">
	      						<div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
	      							{{ $listPermission->appends($filter)->links() }}
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
<!-- begin modal -->
<div class="modal fade" id="search" tabindex="-1" permission="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" permission="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="exampleModalLabel">Tìm kiếm</h4>
      		</div>
  			<div class="form-group">
      			<form id="searchForm" action="{{route('dev.permission.index')}}">
	      			<div class="modal-body">
	      				<div class="form-group">
		        			<label for="recipient-name" class="control-label">Tên permission item:</label>
		        			<input type="text" class="form-control" id="sName" name="name" value="{{isset($filter['name']) ? $filter['name'] : ''}}">
		        			<input type="hidden" name="pageSize" id="sPageSize" value="{{$pageSize}}">
	        			</div>
	      			</div>
      			</form>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		<button type="button" id="searchBtn" class="btn btn-primary">Tìm kiếm</button>
      		</div>
    	</div>
  	</div>
</div>
<!-- /modal -->
@stop