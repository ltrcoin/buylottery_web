@extends('backend.layouts.main')
@section('title', __('label.actions.edit_title'))
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
	  {{ __('label.actions.edit_title') }}
    <small>{{ __('label.actions.lbl_control_panel') }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i>{{ __('label.actions.lbl_home') }}</a></li>
    <li><a href="{{route('backend.actions.index')}}">{{ __('label.actions.list_title') }}</a></li>
    <li class="active">{{ __('label.actions.edit_title') }}</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<form action="{{route('backend.actions.pEdit',['id'=>$model->id])}}" method="POST" enctype="multipart/form-data">
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
									<input type="text" class="form-control" name="action" id="action" placeholder="{{ __('label.actions.lbl_action_name') }}" value="{{$model->name}}" maxlength="255">
									<span class="help-block">{{$errors->first("action")}}</span>
								</div>
								<!-- /.form-organization -->
								<div class="form-group {{$errors->has('organization') ? 'has-error' : ''}}">
									<label class="required">{{ __('label.actions.lbl_organization') }}</label>
									<select class="form-control" name="organization" style="width: 50%;">
										<option value="">{{ __('label.actions.lbl_choose_organization') }}</option>
										@if(isset($listOrganization))
											@foreach($listOrganization as $key=>$organization)
												<option value="{{$key}}" {{$model->organization_id == $key ? 'selected' : ''}}>{{$organization}}</option>
											@endforeach
										@endif
									</select>
									<span class="help-block">{{$errors->first("organization")}}</span>
								</div>
								<!-- /.form-group -->
								<div class="form-group {{$errors->has('group_id') ? 'has-error' : ''}}">
									<label class="required">{{ __('label.actions.lbl_choose_groups') }}</label>
									<select class="form-control" name="group_id[]" id="groups" multiple="multiple" style="width: 50%">
										@if(isset($listGroup))
											@foreach($listGroup as $key=>$group)
												@if(in_array($key,$mgroups))
													<option value="{{$key}}" selected="true" >{{$group}}</option>
												@else
													<option value="{{$key}}">{{$group}}</option>
												@endif
											@endforeach
										@endif
									</select>
									&emsp;
									<input type="checkbox" name="all_group" value="1" {{$model->for_all_group == 1 ? 'checked' : ''}}>
									<label>{{ __('label.actions.lbl_choose_all') }}</label>
									<span class="help-block">{{$errors->first("group_id")}}</span>
								</div>
								<div class="form-group">
									<input type="checkbox" name="checkin" value="1" {{$model->can_checkin == 1 ? 'checked' : ''}}>
									<label>{{ __('label.actions.lbl_can_checkin') }}</label>
									&emsp;
									<input type="checkbox" name="checkout" value="1" {{$model->can_checkout == 1 ? 'checked' : ''}}>
									<label>{{ __('label.actions.lbl_can_checkout') }}</label>
								</div>
								<!-- /.form-group -->
								<div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
									<label class="required" for="chucvu">{{ __('label.actions.lbl_description') }}</label>
									<textarea  class="form-control" name="description" id="description" placeholder="{{ __('label.actions.msg_description') }}" value="">{{$model->description}}</textarea>
									<span class="help-block">{{$errors->first("description")}}</span>
								</div>
								<div class="form-group col-md-12">
									<p><label>{{ __('label.actions.lbl_form_field') }}</label></p>
									<p><a href="#" id="addScnt" class="btn btn-primary">{{ __('label.actions.lbl_field_add') }}</a></p>
									<div id="p_scents">
										@if(!$formField->isEmpty())
											@foreach($formField as $key=>$value)
												<p><input class="form_field" style="width:200px;height: 34px;" type="text" id="form_field" name="form_field[{{$key+1}}][name]" value="{{$value->field_name}}" placeholder="{{ __('label.actions.lbl_field_name') }}" /> <select class="form_field" style="width:150px;height: 34px;" name="form_field[{{$key+1}}][type]">
														<option value="">{{ __('label.actions.lbl_data_type') }}</option>
														@foreach($listType as $k=>$v)
															@if($value->field_type == $k)
																<option value="{{$k}}" selected="true">{{$v}}</option>
															@else
																<option value="{{$k}}">{{$v}}</option>
															@endif
														@endforeach
													</select> <a href="#" style="margin-bottom:5px;line-height:1;" class="btn btn-danger glyphicon glyphicon-remove" id="remScnt"></a></p>
											@endforeach
										@endif
									</div>
								</div>
								<!-- /.form-group -->
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
<script type="text/javascript">
	$(function() {
		//Convert signed string to unsigned string
		/*$('#name').blur(function(){
			var name = $(this).val();
			$('#alias').val(createAlias(name));
		});*/
	});
</script>
@stop