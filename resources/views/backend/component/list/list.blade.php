@extends('backend.layouts.main')
@section('title', __($listTitle))
@section('content')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/bootstrap3-editable-1.5.1/bootstrap3-editable/css/bootstrap-editable.css')}}">
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
        table.dataTable tbody tr td:nth-child(2) {
            cursor: pointer;
        }
    </style>
    @if (Session::has($messageName))
        <script type="text/javascript">
            $(function () {
                jAlert('{{Session::get($messageName)}}', '{{__('messages.alert')}}');
            });
        </script>
    @endif
    

    @include('backend.component.list.base_table')
    @include('backend.component.list.detail_modal')

    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('backend/plugins/bootstrap3-editable-1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>

    @include('backend.component.list.script.base_table_script')

    @if(!empty($customScript))
        @foreach($customScript as $c_script)
            @include($c_script)
        @endforeach
    @endif
@endsection

