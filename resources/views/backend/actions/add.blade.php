@extends('backend.layouts.main')
@section('title', __('label.actions.add_title'))
@section('content')
@if (Session::has('msg_actions'))
	<script type="text/javascript">
		$(function() {
			jAlert('{{Session::get("msg_actions")}}', 'Thông báo');
		});
	</script>
@endif
<section class="content-header">
  <h1>
	  {{ __('label.actions.add_title') }}
    <small>{{ __('label.actions.lbl_control_panel') }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> {{ __('label.actions.lbl_home') }}</a></li>
    <li><a href="{{route('backend.actions.index')}}">{{ __('label.actions.list_title') }}</a></li>
    <li class="active">{{ __('label.actions.add_title') }}</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<form action="{{route('backend.actions.pAdd')}}" method="POST">
				{{csrf_field()}}
				<div class="box box-primary">
				    <div class="box-header with-border">
						@if(!empty($buttons))
							@include('backend.component.button_bar')
						@endif
				      <h3 class="help">{!! html_entity_decode( __('label.note_required')) !!}</h3>
				    </div>
				    <!-- /.box-header -->
				    <div class="box-body">
				      	<div class="row">
					        <div class="col-md-6">
					            <div class="form-group {{$errors->has('action') ? 'has-error' : ''}}">
					              	<label class="required" for="hoten">{{ __('label.actions.lbl_action_name') }}</label>
					              	<input type="text" class="form-control" name="action" id="action" placeholder="{{ __('label.actions.lbl_action_name') }}" value="" maxlength="255">
					              	<span class="help-block">{{$errors->first("action")}}</span>
					            </div>
					          	<!-- /.form-group -->
					          	<div class="form-group {{$errors->has('organization') ? 'has-error' : ''}}">
									<label class="required">{{ __('label.actions.lbl_organization') }}</label>
									<select class="form-control" name="organization" style="width: 50%;">
										<option>{{ __('label.actions.lbl_choose_organization') }}</option>
										@if(isset($listOrganization))
											@foreach($listOrganization as $key=>$organization)
												<option value="{{$key}}">{{$organization}}</option>
											@endforeach
										@endif
									</select>
					              	<span class="help-block">{{$errors->first("organization")}}</span>
					            </div>
					          	<!-- /.form-group -->
					          	<div class="form-group {{$errors->has('group') ? 'has-error' : ''}}">
									<label class="required">{{ __('label.actions.lbl_choose_groups') }}</label>
									<select class="form-control" name="group_id[]" id="groups" multiple="multiple" style="width: 50%">
										@if(isset($listGroup))
											@foreach($listGroup as $key=>$group)
												<option value="{{$key}}">{{$group}}</option>
											@endforeach
										@endif
									</select>
									&emsp;
									<input type="checkbox" name="all_group" value="1">
									<label>{{ __('label.actions.lbl_choose_all') }}</label>
					              	<span class="help-block">{{$errors->first("group")}}</span>
					            </div>
								<div class="form-group">
									<input type="checkbox" name="checkin" value="1">
									<label>{{ __('label.actions.lbl_can_checkin') }}</label>
									&emsp;
									<input type="checkbox" name="checkout" value="1">
									<label>{{ __('label.actions.lbl_can_checkout') }}</label>
								</div>
					            <!-- /.form-group -->
					          	<div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
					              	<label class="required" for="chucvu">{{ __('label.actions.lbl_description') }}</label>
									<textarea  class="form-control" name="description" id="description" placeholder="{{ __('label.actions.msg_description') }}" value=""></textarea>
					              	<span class="help-block">{{$errors->first("description")}}</span>
					            </div>
					          	<!-- /.form-group -->
					        </div>
							<div class="form-group col-md-12">
								<p><label>{{ __('label.actions.lbl_form_field') }}</label></p>
								<p><a href="#" id="addScnt" class="btn btn-primary">{{ __('label.actions.lbl_field_add') }}</a></p>
								<div id="p_scents">
								</div>
							</div>
					        <!-- /.col -->
					  	</div>
				  	<!-- /.row -->
					</div>
				    <!-- /.box-body -->
				  </div>
			</form>
		</div>
	</div>
</section>
@stop