@extends('backend.layouts.main')
@section('title', 'User')
@section('content')
<link href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('backend/dist/css/jquery.fileupload.css')}}">
<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="{{asset('backend/dist/js/jquery.ui.widget.js')}}"></script>
<script src="{{asset('backend/dist/js/jquery.iframe-transport.js')}}"></script>
<script src="{{asset('backend/dist/js/jquery.fileupload.js')}}"></script>
<script src="{{asset('backend/dist/js/jquery.fileupload-process.js')}}"></script>
<script src="{{asset('backend/dist/js/jquery.fileupload-validate.js')}}"></script>
<style>
	a {
		cursor: pointer;
	}
</style>
@if (Session::has('msg_organization'))
<script type="text/javascript">
	$(function() {
		jAlert('{{Session::get("msg_organization")}}', 'Thông báo');
	});
</script>
@endif
<section class="content-header">
		<ul class="nav nav-tabs">
				<li class="active"><a href="#">{{__('label.organize.organize_list')}}</a></li>
				<li class=""><a href="{{route('backend.group.index')}}">{{__('label.group.list')}}</a></li>
				<li class=""><a href="{{route('backend.user.index')}}">{{__('label.users.list')}}</a></li>
		  </ul>
	<ol class="breadcrumb">
		<li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">{{ __('label.organize.organize_list') }}</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<div class="row">
						<div class="col-sm-10">
							<a href="{{route('organize.create')}}" class="btn btn-primary">{{ __('label.organize.add_organize') }}</a>
						</div>
						<div class="col-sm-2">
							<a style="float: right;" data-toggle="modal" data-target="#myModal" class="btn btn-primary">{{ __('label.organize.import_organize') }}</a>
						</div>
					</div>
				</div>
				<!-- /.box-header -->
				
				<div class="box-body">
					<table class="table table-bordered" id="users-table">
						
					</table>  
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
	
		<!-- Modal content-->
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">{{ __('label.organize.import_organize') }}</h4>
		</div>
		<div class="modal-body">
			<span class="btn btn-success fileinput-button">
				<i class="glyphicon glyphicon-plus"></i>
				<span>Select files...</span>
				<!-- The file input field used as target for the file upload widget -->
				<input id="fileupload" type="file" name="files">
			</span>
			<span class="error-upload">

			</span>

			<span class="btn btn-success fileinput-button" onclick="downloadExcel()">
				<i class="glyphicon glyphicon-download"></i>
				<span>{{ __('label.organize.download_template_file') }}</span>
			</span>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>
<script>
	var urlExcel = "{{ route('backend.downloadExcel.organize') }}";
	function downloadExcel(){
		window.open(urlExcel);
	}
	$(function () {
		'use strict';
		// Change this to the location of your server-side upload handler:
		var url = "{{ route('backend.import.organize') }}";
		$('#fileupload').fileupload({
			url: url,
			acceptFileTypes: /(\.|\/)(xls|xlsx|xlsm)$/i,
			dataType: 'json',
			messages: {
				acceptFileTypes: "{{ __('validation.organize.input_excel') }}" ,   
				maxFileSize:  'yourText',
				minFileSize:  'yourText'
			},
			always: function(e , data){
				if(data.result.status == "success"){
					jAlert("{{ __('label.organize.import_success') }}", 'Thông báo');
				}else{
					jAlert("{{ __('label.organize.import_fail') }}", 'Thông báo');
				}
			},
			progressall: function (e, data) {
				var progress = parseInt(data.loaded / data.total * 100, 10);
				$('#progress .progress-bar').css(
					'width',
					progress + '%'
				);
			}
		})
		.on('fileuploadprocessalways', function (e, data) {
			var index = data.index,
				file = data.files[index],
				node = $("#myModal .modal-body .error-upload");
			node.empty();
			if (file.error) {
				node
					.append('<br>')
					.append($('<span class="text-danger"/>').text(file.error));
			}
			
		})
		.prop('disabled', !$.support.fileInput)
			.parent().addClass($.support.fileInput ? undefined : 'disabled');
	});

	var aURL = "{{ route('backend.organize.ajaxIndex') }}";
	$('#users-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: aURL,
		columns: [
			{data: 'id', name: 'a.id' , title: '#'},
			{data: 'name', name: 'a.name' , title: '{{ __('label.organize.name_organize') }}'},
			{data: 'level', name: 'a.level' , title: '{{ __('label.organize.level') }}'},
			{data: 'type', name: 'a.type' , title: '{{ __('label.organize.type') }}'},
			{data: 'nameParent', name: 'b.name' , title: '{{ __('label.organize.parent') }}'},
			{data: 'action' , name: 'action' , title: ''}
		]
	});

	function deleteOrganize(id){
		var aURL = "{{ route('backend.organize.delete' , ['id' =>'']) }}/" + id;
		jConfirm('Bạn chắc chắn muốn xóa?', 'Xác nhận', function (r) {
            if (r) {
                location.href = aURL;
            } else {
            	return false;
            }
        });
	}
</script>
@stop