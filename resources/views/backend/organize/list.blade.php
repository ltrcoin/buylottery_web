@extends('backend.layouts.main')
@section('title', __($listTitle))
@section('content')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/bootstrap3-editable-1.5.1/bootstrap3-editable/css/bootstrap-editable.css')}}">
    <link rel="stylesheet" href="{{asset('backend/dist/css/jquery.fileupload.css')}}">

    <style>
        #resizeable_filter label {
            display: none;
        }
        #resizeable td:last-child {
            text-align: center;
        }
        #detailModal label {
            display: block;
        }
        #resizeable .form-control {
            width: 100% !important;
        }
        table.dataTable thead:first-child .sorting_desc:after {
            content: '' !important;
        }
    </style>
    @if (Session::has($messageName))
        <script type="text/javascript">
            $(function () {
                jAlert('{{Session::get($messageName)}}', '{{__('messages.alert')}}');
            });
        </script>
    @endif
    @if(!empty($toolbar))
        @include($toolbar)
    @endif

    @include('backend.component.list.base_table')
    @include('backend.component.list.detail_modal')

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
    </div>

    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('backend/plugins/bootstrap3-editable-1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
    <script src="{{asset('backend/dist/js/jquery.ui.widget.js')}}"></script>
    <script src="{{asset('backend/dist/js/jquery.iframe-transport.js')}}"></script>
    <script src="{{asset('backend/dist/js/jquery.fileupload.js')}}"></script>
    <script src="{{asset('backend/dist/js/jquery.fileupload-process.js')}}"></script>
    <script src="{{asset('backend/dist/js/jquery.fileupload-validate.js')}}"></script>

    @include('backend.component.list.script.base_table_script')

    @if(!empty($customScript))
        @foreach($customScript as $c_script)
            @include($c_script)
        @endforeach
    @endif
@endsection

