<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
			    <!-- /.box-header -->
			    <div class="box-body">
			      	<div class="row">
				        <div class="col-md-6">
				        	<div class="form-group">
				              	<label class="required" for="organization">{{__('label.group.organization')}}</label>
				              	<span class="form-control">{{$model->organization->name}}</span>
				            </div>
				          	<!-- /.form-group -->
				          	<div class="form-group">
				              	<label class="required" for="code">{{__('label.group.code')}}</label>
				              	<span class="form-control">{{$model->code}}</span>
				            </div>
				          	<!-- /.form-group -->
				          	<div class="form-group">
				              	<label class="required" for="name">{{__('label.group.name')}}</label>
				              	<span class="form-control">{{$model->name}}</span>
				            </div>
				            <!-- /.form-group -->
				          	<div class="form-group">
				              	<label class="required" for="description">{{__('label.group.description')}}</label>
				              	<span class="form-control">{{$model->description}}</span>
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
						                  <div class="icheckbox_flat-green {{$model->checkin == 1 ? 'checked' : ''}}" aria-checked="false" aria-disabled="false">
						                  	<ins class="iCheck-helper"></ins>
						                  </div>
						                  {{__('label.group.checkin')}}
						                </label>
						            </div>
						        </div>
					            <div class="col-md-6">
					            	<div class="form-group">
						              	<label for="confirm">
						                  <div class="icheckbox_flat-green {{$model->confirm == 1 ? 'checked' : ''}}" aria-checked="false" aria-disabled="false">
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
						                  <div class="icheckbox_flat-green {{$model->checkout == 1 ? 'checked' : ''}}" aria-checked="false" aria-disabled="false">
						                  	<ins class="iCheck-helper"></ins>
						                  </div>
						                  {{__('label.group.checkout')}}
						                </label>
						            </div>
						        </div>
					            <div class="col-md-6">
					            	<div class="form-group">
						              	<label for="reject">
						                  <div class="icheckbox_flat-green {{$model->reject == 1 ? 'checked' : ''}}" aria-checked="false" aria-disabled="false">
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
			  	<div class="form-group row" style="margin-left: 0;">{{__('label.group.permission_access_page')}} (modules)</div>
		        <div class="form-group row">
		        	<div class="col-md-offset-1 col-md-10">
			        	<table id="tbl-permission" class="table table-striped table-bordered" style="width:100%">
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
								                  <div class="icheckbox_flat-green {{\App\Http\Models\Backend\Group::getCheckAll(array_keys($permissions), $roles)}}" aria-checked="false" aria-disabled="false">
								                  	<ins class="iCheck-helper check_all_permission"></ins>
								                  </div>
								                </label>
								            </div>
							            </td>
				        				@foreach($permissions as $key => $name)
					        				@php
					        					$checked = '';
					        					if(in_array($key, $roles)) {
					        						$checked = 'checked';
					        					}
					        				@endphp
					        				<td class="text-center">
					        					<div class="form-group">
						        					<label for="per_{{$key}}">
									                  <div class="icheckbox_flat-green {{$checked}}" aria-checked="false" aria-disabled="false">
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
				</div>
			    <!-- /.box-body -->
			</div>
		</div>
	</div>
</section>