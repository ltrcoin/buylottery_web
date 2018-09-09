@extends('dev.layouts.main')
@section('title', 'Thêm tham số')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('backend/summernote/summernote.css')}}">
<script type="text/javascript" src="{{asset('backend/summernote/summernote.js')}}"></script>
<section class="content-header">
  <h1>
    Thêm tham số
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('dev.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('dev.setting.index')}}">Danh sách tham số</a></li>
    <li class="active">Thêm tham số</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<form action="{{route('dev.setting.pAdd')}}" method="POST">
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
					              	<label class="required" for="name">Tên tham số</label>
					              	<input type="text" class="form-control" name="name" id="name" placeholder="Nhập tên tham số">
					              	<span class="help-block">{{$errors->first("name")}}</span>
					            </div>
					            <div class="form-group {{$errors->has('content') ? 'has-error' : ''}}">
					              	<label class="required" for="content">Giá trị tham số</label>
					              	<input type="text" class="form-control" name="content" id="content" placeholder="Nhập giá trị tham số">
					              	<span class="help-block">{{$errors->first("content")}}</span>
					            </div>
					          	<!-- /.form-group -->
					          	<div class="form-group">
						            <label>Loại tham số</label>
						            <select class="form-control select2" name="type" style="width: 50%;">
						            	@if(isset($listType) && is_array($listType))
							              	@foreach($listType as $key=>$type)
							              	<option value="{{$key}}">{{$type}}</option>
							              	@endforeach
						              	@endif
						            </select>
					          	</div>
					          	<!-- /.form-group -->
					          	<div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
				                  	<label for="description">Mô tả tham số</label>
				                  	<textarea name="description" id="description" class="form-control" rows="3" placeholder="Nhập ..."></textarea>
				                  	<span class="help-block">{{$errors->first("description")}}</span>
				                </div>
					        </div>
					        <!-- /.col -->
					        <div class="col-md-6"></div>
					        <!-- /.col -->
					  	</div>
				  	<!-- /.row -->
					</div>
				    <!-- /.box-body -->
				    <div class="box-footer text-center">
			        	<button type="submit" class="btn btn-primary mrg-10">Save</button>
			        	<button type="reset" class="btn btn-default mrg-10">Cancel</button>
			      	</div>
				  </div>
			</form>
		</div>
	</div>
</section>
@stop