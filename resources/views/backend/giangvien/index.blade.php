@extends('backend.layouts.main')
@section('title', 'Giảng viên')
@section('content')
<link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap.css')}}">
@if (Session::has('msg_giangvien'))
   	<script type="text/javascript">
   	$(function() {
   		jAlert('{{Session::get("msg_giangvien")}}', 'Thông báo');
   	});
   	</script>
@endif
<section class="content-header">
  <h1>
    Giảng viên
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Danh sách giảng viên</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<div class="row">
				  		<div class="col-sm-2">
							<a class="btn btn-primary" href="{{route('backend.giangvien.vAdd')}}">Thêm mới giảng viên</a>
						</div>
						<div class="col-sm-3">
							<button class="btn btn-primary" data-toggle="modal" data-target="#search">Tìm kiếm</button>
						</div>
				  	</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div id="table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
						<div class="row">
							<div class="col-sm-1">
								<button type="button" class="btn btn-danger deleteAll">Delete</button>
								<input type="hidden" id="delUrl" value="{{url('admin/giangvien/delete')}}">
							</div>
							<div class="col-sm-11">
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
							        		<th width="20%">Họ tên</th>
							        		<th width="20%">Trình độ</th>
							        		<th width="10%">Khối ngành</th>
							        		<th width="20%">Khoa</th>
							        		<th width="5%">Trạng thái</th>
							        		<th width="13%">Tùy chọn</th>
						        		</tr>
				        			</thead>
				        			<tbody>
				        				@forelse ($listGiangvien as $key => $item) 
				              			<tr class="{{$key%2 == 0 ? 'even' : 'odd'}}">
				              				<td>
				              					<input type="checkbox" class="checkItem" value="{{$item->id}}">
			              					</td>
							          		<td class="sorting_1">{{$item->hoten}}</td>
							          		<td>{{$item->trinhdo}}</td>
							          		<td>{{$item->khoinganh}}</td>
							          		<td>{{$arrKhoa[$item->khoa]}}</td>
								          	<td class="text-center">
								          		@if($item->status == 0)
								          		<a href="javascript: void(0);" class="reverseItem" data-id="{{$item->id}}" id="status{{$item->id}}" data-href="{{route('backend.giangvien.reverseStatus')}}" title="Ẩn"><i class="fa fa-fw fa-question"></i></a>
								          		@else
								          		<a href="javascript: void(0);" class="reverseItem" data-id="{{$item->id}}" id="status{{$item->id}}" data-href="{{route('backend.giangvien.reverseStatus')}}" title="Hiện"><i class="fa fa-fw fa-check-circle"></i></a>
								          		@endif
								          	</td>
								          	<td class="text-center">
								          		<a href="{{route('backend.giangvien.vEdit',['id'=>$item->id])}}" class="editItem" id="" title="Sửa"><i class="fa fa-fw fa-edit"></i></a>
								          		<a href="javascript: void(0);" class="deleteItem" id="{{$item->id}}" title="Xóa"><i class="fa fa-fw fa-remove"></i></a>
								          	</td>
								        </tr>
									    @empty
								    	<tr class="even">
								    		<td colspan="7" style="font-style: italic;">Không có dữ liệu</td>
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
	      							{{ $listGiangvien->appends($filter)->links() }}
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
<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="exampleModalLabel">Tìm kiếm</h4>
      		</div>
  			<div class="form-group">
      			<form id="searchForm" action="{{route('backend.giangvien.index')}}">
	      			<div class="modal-body">
	        			<div class="form-group">
		        			<label for="message-text" class="control-label">Khoa:</label>
		        			<select class="form-control" id="sType" name="type" style="width: 50%;">
		          				<option value="0">--Chọn Khoa--</option>
		          				@if(isset($arrKhoa) && is_array($arrKhoa))
			          				@foreach($arrKhoa as $key=>$khoa)
			          				<option value="{{$key}}" {{(isset($filter['khoa']) && $filter['khoa'] == $key) ? 'selected' : ''}}>{{$khoa}}</option>
			          				@endforeach
			          			@endif
		        			</select>
		      			</div>
		      			<div class="form-group">
		        			<label for="recipient-name" class="control-label">Tên giảng viên:</label>
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