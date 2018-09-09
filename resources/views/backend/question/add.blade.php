@extends('backend.layouts.main')
@section('title', 'Thêm câu hỏi')
@section('content')
<section class="content-header">
  <h1>
    Thêm câu hỏi
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('backend.question.index')}}">Danh sách câu hỏi</a></li>
    <li class="active">Thêm câu hỏi</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<form action="{{route('backend.question.pAdd')}}" method="POST">
				{{csrf_field()}}
				<div class="box box-primary">
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
					        	<div class="form-group {{$errors->has('type') ? 'has-error' : ''}}">
						            <label class="required">Chọn loại</label>
						            <select class="form-control select2" name="type" style="width: 100%;">
						              	<option value="">--Chọn loại--</option>
						              	@if(isset($listType) && count($listType) > 0)
							              	@foreach($listType as $id=>$item)
							              	<option value="{{$id}}">{{$item}}</option>
							              	@endforeach
							            @endif
						            </select>
						            <span class="help-block">{{$errors->first("type")}}</span>
					          	</div>
					          	<!-- /.form-group -->
					          	<div class="form-group {{$errors->has('object') ? 'has-error' : ''}}">
						            <label class="required">Chọn đối tượng</label>
						            <select class="form-control select2" name="object" style="width: 100%;">
						              	<option value="">--Chọn đối tượng--</option>
						              	@if(isset($listObj) && count($listObj) > 0)
							              	@foreach($listObj as $id=>$item)
							              	<option value="{{$id}}">{{$item}}</option>
							              	@endforeach
							            @endif
						            </select>
						            <span class="help-block">{{$errors->first("object")}}</span>
					          	</div>
					          	<!-- /.form-group -->
					        	<div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
					              	<label class="required" for="name">Nội dung câu hỏi</label>
					              	<textarea class="form-control" name="name" id="name" placeholder="Nhập nội dung câu hỏi" rows="5"></textarea>
					              	<span class="help-block">{{$errors->first("name")}}</span>
					            </div>
					            <!-- /.form-group -->
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