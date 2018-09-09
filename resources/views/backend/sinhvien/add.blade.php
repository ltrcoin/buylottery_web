@extends('backend.layouts.main')
@section('title', 'Thêm sinh viên')
@section('content')
<section class="content-header">
  <h1>
    Thêm sinh viên
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('backend.sinhvien.index')}}">Danh sách sinh viên</a></li>
    <li class="active">Thêm sinh viên</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<form action="{{route('backend.sinhvien.pAdd')}}" method="POST">
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
					        	<div class="form-group {{$errors->has('idmsv') ? 'has-error' : ''}}">
					              	<label class="required" for="idmsv">Mã sinh viên</label>
					              	<input type="text" class="form-control" name="idmsv" id="idmsv" value="" placeholder="Nhập mã sinh viên">
					              	<span class="help-block">{{$errors->first("idmsv")}}</span>
					            </div>
					            <div class="form-group {{$errors->has('hoten') ? 'has-error' : ''}}">
					              	<label class="required" for="hoten">Họ tên</label>
					              	<input type="text" class="form-control" name="hoten" id="hoten" placeholder="Nhập họ tên" value="">
					              	<span class="help-block">{{$errors->first("hoten")}}</span>
					            </div>
					          	<div class="form-group {{$errors->has('gioitinh') ? 'has-error' : ''}}">
						            <label class="required">Giới tính</label>
						            <select class="form-control select2" name="gioitinh" style="width: 50%;">
						            	@if(isset($listGioitinh) && is_array($listGioitinh))
							              	@foreach($listGioitinh as $key=>$gioitinh)
							              	<option value="{{$key}}">{{$gioitinh}}</option>
							              	@endforeach
						              	@endif
						            </select>
						            <span class="help-block">{{$errors->first("gioitinh")}}</span>
					          	</div>
					          	<!-- /.form-group -->
					          	<div class="form-group">
					              	<label class="" for="ngaysinh">Ngày sinh</label>
					              	<input type="text" class="form-control" name="ngaysinh" id="ngaysinh" placeholder="Nhập ngày sinh" value="">
					            </div>
					          	<div class="form-group {{$errors->has('khoa') ? 'has-error' : ''}}">
						            <label class="required">Khoa</label>
						            <select class="form-control select2" name="khoa" style="width: 50%;">
						            	@if(isset($listKhoa) && is_array($listKhoa))
							              	@foreach($listKhoa as $key=>$khoa)
							              	<option value="{{$key}}">{{$khoa}}</option>
							              	@endforeach
						              	@endif
						            </select>
						            <span class="help-block">{{$errors->first("khoa")}}</span>
					          	</div>
					          	<!-- /.form-group -->
					          	<div class="form-group {{$errors->has('nganh') ? 'has-error' : ''}}">
					              	<label class="required" for="nganh">Tên Ngành</label>
					              	<input type="text" class="form-control" name="nganh" id="nganh" placeholder="Nhập tên ngành" value="">
					              	<span class="help-block">{{$errors->first("nganh")}}</span>
					            </div>
					          	<div class="form-group">
						            <label>Trạng thái</label>
						            <select class="form-control select2" name="status" style="width: 50%;">
						            	@if(isset($listStatus) && is_array($listStatus))
							              	@foreach($listStatus as $key=>$status)
							              	<option value="{{$key}}">{{$status}}</option>
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
				    <div class="box-footer text-center">
			        	<button type="submit" class="btn btn-primary mrg-10">Save</button>
			        	<button type="reset" class="btn btn-default mrg-10">Cancel</button>
			      	</div>
				  </div>
			</form>
		</div>
	</div>
</section>
<!-- begin modal -->
<div class="modal fade" id="suggestNews" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="control-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>
<!-- /modal -->
<script type="text/javascript">
	$(function() {
		$('#ngaysinh').datepicker({format: 'dd/mm/yyyy'});
	});
</script>
@stop