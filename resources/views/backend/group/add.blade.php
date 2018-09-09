@extends('backend.layouts.main')
@section('title', __('label.group.add'))
@section('content')
<style type="text/css">
	.select2-container{display: block;}
	.select2-container .select2-selection--single {
	    box-sizing: border-box;
	    cursor: pointer;
	    display: block;
	    width: 100%;
	    height: 34px;
	    padding: 6px 12px;
	    font-size: 14px;
	    line-height: 1.42857143;
	    color: #555;
	    background-image: none;
	    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
	    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	}
</style>
<section class="content-header">
  	<ul class="nav nav-tabs">
      	<li class=""><a href="{{route('organize.index')}}">{{__('label.organize.organize_list')}}</a></li>
      	<li class="active"><a href="{{route('backend.group.index')}}">{{__('label.group.list')}}</a></li>
      	<li class=""><a href="{{route('backend.user.index')}}">{{__('label.users.list')}}</a></li>
    </ul>
  <ol class="breadcrumb">
    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('backend.group.index')}}">{{__('label.group.list')}}</a></li>
    <li class="active">{{__('label.group.add')}}</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<form action="{{route('backend.group.pAdd')}}" method="POST">
				{{csrf_field()}}
				<div class="box box-primary">
				    <div class="box-header with-border">
						@if(!empty($buttons))
							@include('backend.component.button_bar')
						@endif
				      <h3 class="help">{!!__('label.note_required')!!}</h3>
				      <p style="color: #f00;">
				      	{{$errors->first()}}
				      </p>
				    </div>
				    <!-- /.box-header -->
				    <div class="box-body">
				      	<div class="row">
					        <div class="col-md-6">
					            <div class="form-group {{$errors->has('group_organization') ? 'has-error' : ''}}">
					              	<label class="required" for="organization">{{__('label.group.organization')}}</label>
					              	<select class="form-control" id="group_organization" name="group_organization" style="width: 50%;">
						              	@foreach($listOrganization as $item)
						              	<option value="{{$item->id}}">{{$item->name}}</option>
						              	@endforeach
						            </select>
					              	<span class="help-block">{{$errors->first("group_organization")}}</span>
					            </div>
					          	<!-- /.form-group -->
					          	<div class="form-group {{$errors->has('group_code') ? 'has-error' : ''}}">
					              	<label class="required" for="code">{{__('label.group.code')}}</label>
					              	<input type="text" class="form-control" name="group_code" id="code" value="" maxlength="150" placeholder="{{__('label.group.code')}}">
					              	<span class="help-block">{{$errors->first("group_code")}}</span>
					            </div>
					          	<!-- /.form-group -->
					          	<div class="form-group {{$errors->has('group_name') ? 'has-error' : ''}}">
					              	<label class="required" for="name">{{__('label.group.name')}}</label>
					              	<input type="text" class="form-control" name="group_name" id="name" maxlength="255" placeholder="{{__('label.group.name')}}" value="">
					              	<span class="help-block">{{$errors->first("group_name")}}</span>
					            </div>
					            <!-- /.form-group -->
					          	<div class="form-group {{$errors->has('group_description') ? 'has-error' : ''}}">
					              	<label class="required" for="description">{{__('label.group.description')}}</label>
					              	<textarea class="form-control" name="group_description" id="description" placeholder="{{__('label.group.description')}}" rows="3"></textarea>
					              	<span class="help-block">{{$errors->first("group_description")}}</span>
					            </div>
					            <!-- /.form-group -->
					        </div>
					        <!-- /.col -->
					        <div class="col-md-offset-1 col-md-4" style="margin-top: 130px;">
					        	<div class="form-group row">{{__('label.group.permission_delegation')}}</div>
					            <div class="row">
						            <div class="col-md-6">
						            	<div class="form-group">
						            		<label for="checkin">
							                  <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false">
							                  	<input type="checkbox" class="flat-red" name="checkin" id="checkin">
							                  	<ins class="iCheck-helper"></ins>
							                  </div>
							                  {{__('label.group.checkin')}}
							                </label>
							            </div>
							        </div>
						            <div class="col-md-6">
						            	<div class="form-group">
							              	<label for="confirm">
							                  <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false">
							                  	<input type="checkbox" class="flat-red" name="confirm" id="confirm">
							                  	<ins class="iCheck-helper"></ins>
							                  </div>
							                  {{__('label.group.confirm')}}
							                </label>
							            </div>
						            </div>
						        </div>
						        <div class="row">
						            <div class="col-md-6">
						            	<div class="form-group">
							              	<label for="checkout">
							                  <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false">
							                  	<input type="checkbox" class="flat-red" name="checkout" id="checkout">
							                  	<ins class="iCheck-helper"></ins>
							                  </div>
							                  {{__('label.group.checkout')}}
							                </label>
							            </div>
							        </div>
						            <div class="col-md-6">
						            	<div class="form-group">
							              	<label for="reject">
							                  <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false">
							                  	<input type="checkbox" class="flat-red" name="reject" id="reject">
							                  	<ins class="iCheck-helper"></ins>
							                  </div>
							                  {{__('label.group.reject')}}
							                </label>
							            </div>
						            </div>
						        </div>
					        </div>
					  	</div>
				  	<!-- /.row -->
				  	@if(Auth::user()->is_admin == 1)
				  	<div class="form-group row" style="margin-left: 0;">{{__('label.group.permission_access_page')}} (modules)
				  	</div>
			        <div class="form-group row">
			        	<div class="col-md-offset-1 col-md-10">
				        	<table id="example" class="table table-striped table-bordered" style="width:100%">
						        <thead>
						            <tr>
						                <th class="text-center">#</th>
						                <th class="text-center">Module</th>
						                <th class="text-center">{{__('label.group.full_controls')}}</th>
						                <th class="text-center">{{__('label.view_list')}}</th>
						                <th class="text-center">{{__('label.add_new')}}</th>
						                <th class="text-center">{{__('label.edit')}}</th>
						                <th class="text-center">{{__('label.delete')}}</th>
						                <th class="text-center">{{__('label.detail')}}</th>
						            </tr>
						        </thead>
				        		<tbody>
				        			@php 
				        				$i = 0;
				        			@endphp
				        			@foreach($listPermission as $module => $permissions)
				        			@php 
				        				$i++;
				        			@endphp
				        			<tr>
				        				<td class="text-center">{{$i}}</td>
				        				<td>{{$module}}</td>
				        				<td class="text-center">
				        					<div class="form-group">
					        					<label for="{{$i}}">
								                  <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false">
								                  	<input type="checkbox" class="flat-red" id="{{$i}}">
								                  	<ins class="iCheck-helper check_all_permission"></ins>
								                  </div>
								                </label>
								            </div>
							            </td>
				        				@foreach($permissions as $key => $name)
				        				<td class="text-center">
				        					<div class="form-group">
					        					<label for="per_{{$key}}">
								                  <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false">
								                  	<input type="checkbox" class="flat-red" name="permission[]" id="per_{{$key}}" value="{{$key}}">
								                  	<ins class="iCheck-helper"></ins>
								                  </div>
								                </label>
								            </div>
				        				</td>
				        				@endforeach
				        			</tr>
				        			@endforeach
				        		</tbody>
				        	</table>
				        </div>
			        </div>
		            <!-- /.form-group -->
		            @endif
					</div>
				    <!-- /.box-body -->
				  </div>
			</form>
		</div>
	</div>
</section>
<script type="text/javascript">
	$('#group_organization').select2();
</script>
@stop