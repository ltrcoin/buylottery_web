@extends('backend.layouts.main')
@section('title', __('label.actions.list_title'))
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/bootstrap3-editable-1.5.1/bootstrap3-editable/css/bootstrap-editable.css')}}">
@if (Session::has('msg_actions'))
	<script type="text/javascript">
        $(function() {
            jAlert('{{Session::get("msg_actions")}}', 'Thông báo');
        });
	</script>
@endif
<section class="content-header">
	<ul class="nav nav-tabs">
		<li class=""><a href="{{route('backend.task.index')}}">{{__('label.tasks.list')}}</a></li>
		<li class="active"><a href="javascript:void(0)">{{__('label.actions.list_title')}}</a></li>
		<li class=""><a href="{{route('backend.reports.index')}}">{{__('label.reports.list')}}</a></li>
	</ul>
  <ol class="breadcrumb">
    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> {{ __('label.actions.lbl_home') }}</a></li>
    <li class="active">{{ __('label.actions.list_title') }}</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<div class="row">
						<div class="col-sm-2">
							<a class="btn btn-primary" href="{{route('backend.actions.vAdd')}}">{{ __('label.actions.button_add') }}</a>
						</div>
						<div class="col-sm-3">
							<button class="btn btn-primary" data-toggle="modal" data-target="#search">{{ __('label.actions.button_search') }}</button>
						</div>
				  	</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
						<div class="row">
							<div class="col-sm-1">
								<button type="button" class="btn btn-danger deleteAll">{{ __('label.actions.button_delete') }}</button>
								<input type="hidden" id="delUrl" value="{{url('admin/actions/delete')}}">
							</div>
							<div class="col-sm-11">
								<div class="dataTables_length pull-right">
									<label>
										{{ __('label.actions.lbl_show') }} <select class="form-control input-sm showPage">
											<option value="10" {{$pageSize == 10 ? 'selected' : ''}}>10</option>
											<option value="25" {{$pageSize == 25 ? 'selected' : ''}}>25</option>
											<option value="50" {{$pageSize == 50 ? 'selected' : ''}}>50</option>
											<option value="100" {{$pageSize == 100 ? 'selected' : ''}}>100</option>
										</select> {{ __('label.actions.lbl_entries') }}
									</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
							        <thead>
							        	<tr>
											<th width="2%">
												<input type="checkbox" id="checkAll">
											</th>
							        		<th width="8%">No.</th>
							        		<th width="30%">{{ __('label.actions.lbl_groups') }}</th>
							        		<th width="30%">{{ __('label.actions.lbl_organization') }}</th>
							        		<th width="15%">{{ __('label.actions.lbl_action_name') }}</th>
											<th width="15%">{{ __('label.actions.lbl_optional') }}</th>
						        		</tr>
				        			</thead>
				        			<tbody>
				        				@forelse ($listAction as $key => $item)
				              			<tr class="{{$key%2 == 0 ? 'even' : 'odd'}}">
											<td>
												<input type="checkbox" class="checkItem" value="{{$item->id}}">
											</td>
							          		<td>{{$key+1}}</td>
								          	<td>
												@if ($item->for_all_group == 1)
													{{ __('label.actions.all') }}
												@else
													@foreach  ($item->groups as $key => $group)
														{{$group->name}}<br>
													@endforeach
												@endif
											</td>
								          	<td>{{$item->organization['name']}}</td>
								          	<td>{{$item->name}}</td>
								          	<td class="text-center">
								          		<a href="{{route('backend.actions.vEdit',['id'=>$item->id])}}" class="editItem" id="" title="{{ __('label.actions.lbl_edit') }}"><i class="fa fa-fw fa-edit"></i></a>
												<a href="javascript: void(0);" data-id="{{$item->id}}" data-href="{{route('backend.actions.detail')}}" class="actionDetail" title="{{ __('label.actions.lbl_detail') }}"><i class="fa fa-fw fa-file-text"></i></a>
								          		<a href="javascript: void(0);" class="deleteItem" id="{{$item->id}}" title="{{ __('label.actions.lbl_delete') }}"><i class="fa fa-fw fa-remove"></i></a>
								          	</td>
								        </tr>
								        @empty
								    	<tr class="even">
								    		<td colspan="11" style="font-style: italic;">{{ __('label.actions.msg_no_data') }}</td>
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
	      							{{ $listAction->appends($filter)->links() }}
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
<!-- search modal -->
<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="exampleModalLabel">{{ __('label.actions.search_title') }}</h4>
      		</div>
  			<div class="form-group">
      			<form id="searchForm" action="{{route('backend.actions.index')}}">
	      			<div class="modal-body">
	      				<div class="form-group">
	      					<span style="text-decoration: underline;color: #f00;">{{ __('label.actions.lbl_note') }}:</span>
	      					<span>{!! html_entity_decode( __('label.actions.msg_search')) !!}</span>
	      				</div>
	        			<div class="form-group">
		        			<label for="sName" class="control-label">{{ __('label.actions.lbl_action_name') }}:</label>
		        			<input type="text" class="form-control" id="sName" name="action_name" value="{{isset($filter['name']) ? $filter['name'] : ''}}">
							<input type="hidden" name="pageSize" id="sPageSize" value="{{$pageSize}}">
	        			</div>
	      			</div>
      			</form>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">{{ __('label.actions.button_close') }}</button>
        		<button type="button" id="actionSearchBtn" class="btn btn-primary">{{ __('label.actions.button_search') }}</button>
      		</div>
    	</div>
  	</div>
</div>
<!-- /modal -->
<!-- search modal -->
<div class="modal fade" id="detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">{{ __('label.actions.detail_title') }}</h4>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<label>{{ __('label.actions.lbl_action_name') }}: </label>
						<span id="action_name"></span>
					</div>
					<div class="col-md-12">
						<label>{{ __('label.actions.lbl_organization') }}: </label>
						<span id="organization_name"></span>
					</div>
					<div class="col-md-12">
						<label>{{ __('label.actions.lbl_groups') }}: </label>
						<span id="group_name"></span>
					</div>
					<div class="col-md-6">
						<label>{{ __('label.actions.lbl_can_checkin') }}: </label>
						<input type="checkbox" id="action_checkin" disabled ="disabled">
					</div>
					<div class="col-md-6">
						<label>{{ __('label.actions.lbl_can_checkout') }}: </label>
						<input type="checkbox" id="action_checkout" disabled ="disabled">
					</div>
					<div class="col-md-12">
						<label>{{ __('label.actions.lbl_description') }}: </label>
						<span id="description"></span>
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ __('label.actions.button_close') }}</button>
			</div>
		</div>
	</div>
</div>
<!-- /modal -->
@stop