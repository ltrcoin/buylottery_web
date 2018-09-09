@extends('backend.layouts.main')
@section('title', 'tin tức')
@section('content')

<link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap.css')}}">
@if (Session::has('msg_news'))
   	<script type="text/javascript">
   	$(function() {
   		jAlert('{{Session::get("msg_news")}}', 'Thông báo');
   	});
   	</script>
@endif
<section class="content-header">
  <h1>
    Danh sách tin tức
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Danh sách tin tức</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<div class="row">
				  		<div class="col-sm-2">
							<a class="btn btn-primary" href="{{route('backend.news.vAdd')}}">Thêm mới tin tức</a>
						</div>
						<div class="col-sm-3">
							<button class="btn btn-primary" data-toggle="modal" data-target="#search">Tìm kiếm</button>
						</div>
				  	</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
						<div class="row">
							<div class="col-sm-1">
								<button type="button" class="btn btn-danger deleteAll">Delete</button>
								<input type="hidden" id="delUrl" value="{{url('admin/news/delete')}}">
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
							        		<th width="10%">Intro Image</th>
							        		<th width="30%">Name</th>
							        		<th width="2%">Status</th>
							        		<th width="10%">Action</th>
						        		</tr>
				        			</thead>
				        			<tbody>
				        				@forelse ($listNews as $key => $item) 
				              			<tr class="{{$key%2 == 0 ? 'even' : 'odd'}}">
				              				<td>
				              					<input type="checkbox" class="checkItem" value="{{$item->id}}">
			              					</td>
							          		<td class="text-center">
							          			@if($item->introimage != "")
							          			<img width="80%" src="{{asset($item->introimage)}}">
							          			@else 
							          			<img width="80%" src="{{asset('backend/libout/images/noimage.png')}}">
							          			@endif
							          		</td>
							          		<td>{{$item->name}}</td>
								          	
								          	<td class="text-center">
								          		@if($item->status == 0)
								          		<a href="javascript: void(0);" class="reverseItem" data-id="{{$item->id}}" id="status{{$item->id}}" data-href="{{route('backend.news.reverseStatus')}}" title="Ẩn"><i class="fa fa-fw fa-question"></i></a>
								          		@else
								          		<a href="javascript: void(0);" class="reverseItem" data-id="{{$item->id}}" id="status{{$item->id}}" data-href="{{route('backend.news.reverseStatus')}}" title="Hiện"><i class="fa fa-fw fa-check-circle"></i></a>
								          		@endif
								          	</td>
								          	<td class="text-center">
								          		<a href="{{route('backend.news.vEdit',['id'=>$item->id])}}" class="editItem" id="" title="Sửa"><i class="fa fa-fw fa-edit"></i></a>
								          		<a href="javascript: void(0);" class="deleteItem" id="{{$item->id}}" title="Xóa"><i class="fa fa-fw fa-remove"></i></a>
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
		      					<!-- <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 50 entries</div> -->
	      					</div>
	      					<div class="col-sm-7">
	      						<div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
	      							{{ $listNews->appends($filter)->links() }}
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
      			<form id="searchForm" action="{{route('backend.news.index')}}">
	      			<div class="modal-body">
	      				<div class="form-group">
	      					<span style="text-decoration: underline;color: #f00;">Chú ý:</span>
	      					<span>Để tối ưu kết quả tìm kiếm, hệ thống phân biệt <b style="color: #f00;">CÓ DẤU và KHÔNG DẤU</b>. (Ví dụ: "Anh" khác với "Ánh")</span>
	      				</div>
	      				
	      				<div class="form-group">
		        			<label for="recipient-name" class="control-label">Tên bài viết:</label>
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