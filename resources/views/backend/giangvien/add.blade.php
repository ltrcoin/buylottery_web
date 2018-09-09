@extends('backend.layouts.main')
@section('title', 'Thêm giảng viên')
@section('content')
<section class="content-header">
  <h1>
    Thêm giảng viên
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('backend.giangvien.index')}}">Danh sách giảng viên</a></li>
    <li class="active">Thêm giảng viên</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<form action="{{route('backend.giangvien.pAdd')}}" method="POST" enctype="multipart/form-data">
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
					        	<div class="form-group {{$errors->has('khoa') ? 'has-error' : ''}}">
						            <label class="required">Chọn Khoa</label>
						            <select class="form-control" name="khoa" style="width: 50%;">
						              	<option>--Chọn khoa--</option>
						              	@if(isset($arrKhoa) && is_array($arrKhoa))
							              	@foreach($arrKhoa as $key=>$khoa)
							              	<option value="{{$key}}">{{$khoa}}</option>
							              	@endforeach
							            @endif
						            </select>
						            <span class="help-block">{{$errors->first("khoa")}}</span>
					          	</div>
					          	<!-- /.form-group -->
					        	<div class="form-group {{$errors->has('hoten') ? 'has-error' : ''}}">
					              	<label class="required" for="hoten">Tên giảng viên</label>
					              	<input type="text" class="form-control" name="hoten" id="hoten" placeholder="Enter tên giảng viên" value="">
					              	<span class="help-block">{{$errors->first("hoten")}}</span>
					            </div>
					            <div class="form-group">
					              	<label class="" for="alias">Khối ngành</label>
					              	<input type="text" class="form-control" name="khoinganh" id="khoinganh" placeholder="Enter khoinganh" value="">
					            </div>
					          	<div class="form-group {{$errors->has('trinhdo') ? 'has-error' : ''}}">
						            <label class="required">Trình độ</label>
						            <select class="form-control" id="trinhdo" name="trinhdo" style="width: 50%;">
						            	@if(isset($listTrinhdo))
							              	<option value="0">--Chọn trình độ--</option>
							              	@foreach($listTrinhdo as $name)
							              	<option value="{{$name}}">{{$name}}</option>
							              	@endforeach
							            @endif
						            </select>
						            <span class="help-block">{{$errors->first("trinhdo")}}</span>
					          	</div>
					          	<!-- /.form-group -->
					          	<div class="form-group {{$errors->has('introimage') ? 'has-error' : ''}}">
				                  	<label class="required">Ảnh đại diện</label>
				                  	<input class="hidden" type="file" id="introimage" name="introimage" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
				                  	<button type="button" style="display: block;" class="btn btn-info" onclick="document.getElementById('introimage').click();">Chọn ảnh</button>
				                  	<p>
				                  		<img src="" id="blah" alt="" style="max-width: 50%;margin-top: 10px;">
				                  	</p>
				                  	<span class="help-block">{{$errors->first("introimage")}}</span>
				                </div>
				                <!-- /.form-group -->
					          	<div class="form-group {{$errors->has('status') ? 'has-error' : ''}}">
						            <label class="required">Trạng thái</label>
						            <select class="form-control" name="status" style="width: 50%;">
						            	@if(isset($listStatus) && is_array($listStatus))
							              	@foreach($listStatus as $key=>$status)
							              	<option value="{{$key}}">{{$status}}</option>
							              	@endforeach
							            @endif
						            </select>
						            <span class="help-block">{{$errors->first("status")}}</span>
					          	</div>
					        </div>
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