@extends('dev.layouts.main')
@section('title', 'Update Group Role')
@section('content')
<section class="content-header">
  <h1>
    Update Group Role
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('dev.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('dev.role.indexGroup')}}">List Group Role</a></li>
    <li class="active">Update Group Role</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<form action="{{route('dev.role.pEditGroup',['id'=>$model->id])}}" method="POST">
				{{csrf_field()}}
				<div class="box box-default">
				    <div class="box-header with-border">
				      <h3 class="help">Lưu ý: những trường có (<span style="color: #f00">*</span>) là bắt buộc.</h3>

				      <div class="box-tools pull-right">
				        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				      </div>
				    </div>
				    <!-- /.box-header -->
				    <div class="box-body">
				      	<div class="row">
					        <div class="col-md-6">
					        	<div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
					              	<label class="required" for="name">Name</label>
					              	<input type="text" class="form-control" name="name" id="name" placeholder="Enter" value="{{$model->name}}">
					              	<span class="help-block">{{$errors->first("name")}}</span>
					            </div>
					            <!-- /.form-group -->
					     
					          	<div class="form-group">
					              	<label>Role Item</label>
					              	<select style="height: 350px" name="role[]" multiple class="form-control">
						                @if($roleItem)
						                @foreach($roleItem as $item)
						                <option value="{{$item->id}}" {{in_array($item->id, $roles) ? 'selected' : ''}} >{{$item->name}}</option>
						                @endforeach
						                @endif
					              	</select>
					            </div>
					        </div>
					        <!-- /.col -->
					        <div class="col-md-6">
					        </div>
					        <!-- /.col -->
					  	</div>
				  	<!-- /.row -->
					</div>
				    <!-- /.box-body -->
				    <div class="box-footer text-ccenter">
			        	<button type="submit" class="btn btn-primary mrg-10">Save</button>
			        	<button type="reset" class="btn btn-default mrg-10">Cancel</button>
			      	</div>
				  </div>
			</form>
		</div>
	</div>
</section>
@stop