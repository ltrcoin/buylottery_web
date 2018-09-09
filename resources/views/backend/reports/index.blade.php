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
		<li class="active"><a href="{{route('backend.reports.index')}}">{{__('label.reports.list')}}</a></li>
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
				  	</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
						<div class="row">
							<div class="col-sm-12">
								<a href="{{route('backend.reports.startup_count')}}">+{{ __('label.reports.lbl_startup_count') }}</a><br>
								<a href="#">+{{ __('label.reports.lbl_startup_address') }}</a><br>
								<a href="#">+{{ __('label.reports.lbl_support_organization_count') }}</a><br>
								<a href="#">+{{ __('label.reports.lbl_investors_count') }}</a><br>
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