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
		<li class=""><a href="{{route('backend.actions.index')}}">{{__('label.actions.list_title')}}</a></li>
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
						<div class="col-sm-9">
							<h2>{{ __('label.reports.lbl_startup_count') }}</h2>
						</div>
				  	</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
						<div class="row">
							<div class="col-sm-12">
								<table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
							        <thead>
							        	<tr>
											<th width="8%">No.</th>
											<th width="15%">{{ __('label.reports.lbl_city') }}</th>
							        		<th width="30%">{{ __('label.reports.lbl_area') }}</th>
											<th width="15%">{{ __('label.reports.lbl_count') }}</th>
						        		</tr>
				        			</thead>
				        			<tbody>
										@forelse ($startup_count as $key => $item)
				              			<tr class="">
							          		<td>{{$key+1}}</td>
								          	<td>{{$item['city']}}</td>
								          	<td>{{$item['name']}}</td>
								          	<td>{{$item['count']}}</td>
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
      				</div>    
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>
@stop