@extends('backend.layouts.main')
@section('title', 'Cập nhật tin tức')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('backend/summernote/summernote.css')}}">
<script type="text/javascript" src="{{asset('backend/summernote/summernote.js')}}"></script>
<section class="content-header">
  <h1>
    Cập nhật tin tức
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('backend.news.index')}}">Danh sách tin tức</a></li>
    <li class="active">Cập nhật tin tức</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<form action="{{route('backend.news.pEdit', ['id'=>$model->id])}}" method="POST" enctype="multipart/form-data">
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
					        	<div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
					              	<label class="required" for="name">Tên bài viết</label>
					              	<input type="text" class="form-control" name="name" id="name" value="{{$model->name}}" placeholder="Nhập tên bài viết" maxlength="255">
					              	<span class="help-block">{{$errors->first("name")}}</span>
					            </div>
				              	<input type="hidden" class="form-control" name="alias" id="alias" placeholder="Enter alias" value="{{$model->alias}}">
					          	<!-- /.form-group -->
					          	<div class="form-group {{$errors->has('introtext') ? 'has-error' : ''}}">
					              	<label class="required" for="introtext">Mô tả ngắn</label>
					              	<textarea class="form-control" name="introtext" id="introtext" rows="4" placeholder="Nhập tên bài viết" maxlength="350">{{$model->introtext}}</textarea>
					              	<span class="help-block">{{$errors->first("introtext")}}</span>
					            </div>
					          	<!-- /.form-group -->
					          	<div class="form-group {{$errors->has('introimage') ? 'has-error' : ''}}">
				                  	<label class="required">Ảnh đại diện</label>
				                  	<input class="hidden" type="file" id="introimage" name="introimage" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
				                  	<button type="button" style="display: block;" class="btn btn-info" onclick="document.getElementById('introimage').click();">Chọn ảnh</button>
				                  	<p>
				                  		@if($model->introimage != "")
				                  			<img src="{{asset($model->introimage)}}" id="blah" alt="" style="max-width: 50%;margin-top: 10px;">
				                  		@else
				                  			<img src="{{asset('backend/libout/images/noimage.png')}}" id="blah" alt="" style="max-width: 50%;margin-top: 10px;">
				                  		@endif
				                  	</p>
				                  	<span class="help-block">{{$errors->first("introimage")}}</span>
				                </div>
				                <div class="form-group {{$errors->has('attactfile') ? 'has-error' : ''}}">
				                  	<label>Đính kèm file:</label>
				                  	<input class="hidden" type="file" id="attactfile" name="attactfile" onchange="attactFile(this.files[0])">
				                  	<button type="button" style="display: block;" class="btn btn-info" onclick="document.getElementById('attactfile').click();">Chọn file</button>
				                  	<p>
				                  		@if(!empty($model->attactfile))
				                  		<i id="icon-attact" class="fa fa-fw fa-file-word-o"></i> 
				                  		<span id="attact_file_name" style="margin-top: 10px;">{{substr($model->attactfile,strrpos($model->attactfile, "/")+1)}}</span>
				                  		@else
				                  			<i id="icon-attact" style="display: none;" class="fa fa-fw fa-file-word-o"></i> 
				                  			<span id="attact_file_name" style="margin-top: 10px;"></span>
				                  		@endif
				                  	</p>
				                  	<span class="help-block">{{$errors->first("attactfile")}}</span>
				                </div>
				                <!-- /.form-group -->
					          	<div class="form-group">
						            <label>Trạng thái</label>
						            <select class="form-control select2" name="status" style="width: 50%;">
						            	@if(isset($listStatus) && is_array($listStatus))
							              	@foreach($listStatus as $key=>$status)
							              	<option value="{{$key}}" {{$model->status == $key ? 'selected' : ''}}>{{$status}}</option>
							              	@endforeach
						              	@endif
						            </select>
					          	</div>
					          	<!-- /.form-group -->
					        </div>
					        <!-- /.col -->
					  	</div>
				  	<!-- /.row -->
					</div>
				    <!-- /.box-body -->
				    <div class="box-body">
				      	<div class="row">
				      		<div class="col-md-12">
					      		<div class="form-group {{$errors->has('content') ? 'has-error' : ''}}">
				                  	<label class="required" for="content">Content</label>
				                  	<textarea name="content" id="content" class="form-control" rows="10" placeholder="Nhập ...">{{$model->content}}</textarea>
				                  	<span class="help-block">{{$errors->first("content")}}</span>
				                </div>
			                </div>
				      	</div>
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
<script type="text/javascript">
	$(function() {
		//Convert signed string to unsigned string
		$('#name').blur(function(){
			var name = $(this).val();
			$('#alias').val(createAlias(name));
		});

		$('#content').summernote({
	  		height: 300,                 // set editor height
		  	minHeight: null,             // set minimum height of editor
		  	maxHeight: null,             // set maximum height of editor
		  	focus: false                  // set focus to editable area after initializing summernote
		});

	});
</script>
@stop