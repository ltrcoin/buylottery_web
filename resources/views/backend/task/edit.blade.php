@extends('backend.layouts.main')
@section('title', __('label.edit') . ' ' . __('label.tasks.title'))
@section('content')
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/iCheck/minimal/blue.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/datepicker/datepicker3.css')}}">
    <style>
        .input-daterange input {
            text-align: left;
        }
    </style>
    @if (Session::has('msg_task'))
        <script type="text/javascript">
          $(function () {
            jAlert('{{Session::get("msg_task")}}', '{{__('messages.alert')}}');
          });
        </script>
    @endif
    <section class="content-header">
        <h1>
            {{ __('label.edit') .' ' . __('label.tasks.title') }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> {{__('label.home')}}</a></li>
            <li><a href="{{route('backend.task.index')}}">{{ __('label.tasks.list') }}</a></li>
            <li class="active">{{ __('label.edit') .' '. __('label.tasks.title') }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('backend.task.pEdit',['id'=>$model->id])}}" method="POST">
                    {{csrf_field()}}
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            @if(!empty($buttons))
                                @include('backend.component.button_bar')
                            @endif
                            <h3 class="help">{!! __('label.note_required') !!}</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                                        <label class="required" for="name">{{ __('label.tasks.name') }}</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                               placeholder="{{ __('label.placeholder_enter') . __('label.tasks.name') }}"
                                               value="{{ $model->name }}" maxlength="255">
                                        <span class="help-block">{{$errors->first("name")}}</span>
                                    </div>

                                    <div class="form-group {{$errors->has('organization_id') ? 'has-error' : ''}}">
                                        <label for="organization_id"
                                               class="required">{{ __('label.tasks.org_owner') }}</label>
                                        <select class="form-control ajax-data-organization" name="organization_id"
                                                id="organization_id">
                                            <option value="{{ $model->organization_id }}">{{ $model->organization->name }}</option>
                                        </select>
                                        <span class="help-block">{{$errors->first("organization_id")}}</span>
                                    </div>

                                    <div class="form-group {{$errors->has('type') ? 'has-error' : ''}}">
                                        <label for="type" class="required">{{ __('label.tasks.type') }}</label>
                                        <select class="form-control" name="type" id="type">
                                            <option value="">{{ __('label.placeholder_select') . __('label.tasks.type') }}</option>
                                            @foreach($type as $val => $text)
                                                <option value="{{$val}}" @if($model->type == $val){{'selected'}}@endif>{{__('label.tasks.' . $text)}}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">{{$errors->first("type")}}</span>
                                    </div>
                                    <div class="form-group {{$errors->has('receiver') ? 'has-error' : ''}}">
                                        <label for="receiver"
                                               class="required">{{ __('label.tasks.receiver') }}</label>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <select class="form-control ajax-data-receiver" name="receiver[]"
                                                        id="receiver" multiple>
                                                    @php
                                                        switch ($model->type) {
                                                            case \App\Http\Models\Backend\Task::TYPE_ORG :
                                                                $associate = 'organizations';
                                                                break;
                                                            case \App\Http\Models\Backend\Task::TYPE_GROUP :
                                                                $associate = 'groups';
                                                                break;
                                                            case \App\Http\Models\Backend\Task::TYPE_USER :
                                                                $associate = 'users';
                                                                break;
                                                        }
                                                    @endphp
                                                    @foreach($model->{$associate} as $a)
                                                        @if($associate == 'users')
                                                        <option value="{{$a->id}}" selected>{{$a->fullname}}</option>
                                                        @else
                                                        <option value="{{$a->id}}" selected>{{$a->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <span class="help-block">{{$errors->first("receiver")}}</span>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="checkbox" class="icheck" id="assign_all" name="assign_all"
                                                       value="1" @if(!empty($model->assign_all)){{ 'checked' }}@endif>
                                                <label for="assign_all">{{__('label.tasks.assign_all')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
                                        <label for="description" class="required">{{ __('label.description') }}</label>
                                        <textarea class="form-control" name="description" id="description" cols="30"
                                                  rows="5">{{$model->description}}</textarea>
                                        <span class="help-block">{{$errors->first("description")}}</span>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group {{$errors->has('status') ? 'has-error' : ''}}">
                                        <label for="type" class="required">{{ __('label.tasks.status') }}</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="">{{ __('label.placeholder_select') . __('label.tasks.status') }}</option>
                                            @foreach($status as $val => $text)
                                                <option value="{{$val}}" @if($model->status == $val){{'selected'}}@endif>{{__('label.tasks.' . $text)}}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">{{$errors->first("status")}}</span>
                                    </div>

                                    <div class="form-group {{$errors->has('actions') ? 'has-error' : ''}}">
                                        <label for="actions"
                                               class="required">{{ __('label.actions.title') }}</label>
                                        <select class="form-control" name="actions[]"
                                                id="actions" multiple>
                                            @foreach($model->actions as $action)
                                                <option value="{{$action->id}}" selected>{{$action->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">{{$errors->first("actions")}}</span>
                                    </div>

                                    <div class="input-daterange">
                                        <div class="form-group {{$errors->has('start_date') ? 'has-error' : ''}}">
                                            <label for="start_date"
                                                   class="required">{{ __('label.tasks.start_date') }}</label>
                                            <input autocomplete="off" type="text" class="form-control date-picker" name="start_date"
                                                   id="start_date" value="{{$model->start_date}}">
                                            <span class="help-block">{{$errors->first("start_date")}}</span>
                                        </div>

                                        <div class="form-group {{$errors->has('end_date') ? 'has-error' : ''}}">
                                            <label for="end_date"
                                                   class="required">{{ __('label.tasks.end_date') }}</label>
                                            <input autocomplete="off" type="text" class="form-control date-picker" name="end_date"
                                                   id="end_date" value="{{$model->end_date}}">
                                            <span class="help-block">{{$errors->first("end_date")}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <p><label>{{ __('label.actions.lbl_form_field') }}</label></p>
                                    <p><a href="#" id="addScnt" class="btn btn-primary">{{ __('label.actions.lbl_field_add') }}</a></p>
                                    <div id="p_scents">
                                        @if(!$formField->isEmpty())
                                            @foreach($formField as $key=>$value)
                                                <p><input class="form_field" style="width:200px;height: 34px;" type="text" id="form_field" name="form_field[{{$key+1}}][name]" value="{{$value->field_name}}" placeholder="{{ __('label.actions.lbl_field_name') }}" /> <select class="form_field" style="width:150px;height: 34px;" name="form_field[{{$key+1}}][type]">
                                                        <option value="">{{ __('label.actions.lbl_data_type') }}</option>
                                                        @foreach($listType as $k=>$v)
                                                            @if($value->field_type == $k)
                                                                <option value="{{$k}}" selected>{{$v}}</option>
                                                            @else
                                                                <option value="{{$k}}">{{$v}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select> <a href="#" style="margin-bottom:5px;line-height:1;" class="btn btn-danger glyphicon glyphicon-remove" id="remScnt"></a></p>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('backend/plugins/iCheck/icheck.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    {{--<script src="{{asset('backend/plugins/datepicker/locales/bootstrap-datepicker.vi.js')}}"></script>--}}
    <script type="text/javascript">
        $(function () {
            $.fn.select2.defaults.set( "theme", "bootstrap" );
            var receiver = $('#receiver');
                    @php
                        $date = \Carbon\Carbon::parse($model->start_date);
                    @endphp
            var date = new Date({{ $date->year }}, {{ $date->month - 1 }}, {{ $date->day }});  // months are indexed from 0 in js.

            $('.input-daterange').datepicker({
                // language: "vi",
                startDate: date,
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true
            });
            $('.ajax-data-organization').select2({
                ajax: {
                    url: '/admin/task/data-select',
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            term: params.term,
                            type: {{ \App\Http\Models\Backend\Task::TYPE_ORG }}
                        };

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function (data) {
                        // Tranforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data.items
                        };
                    }
                }
            });

            var actions = $('#actions');

            actions.select2({
                ajax: {
                    url: '/admin/task/data-select',
                    dataType: 'json',
                    multiple: true,
                    allowClear: true,
                    data: function (params) {
                        var query = {
                            term: params.term,
                            type: 'action'
                        };

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function (data) {
                        // Tranforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data.items
                        };
                    }
                }
            });

            var statusElem = $('#status');
            $(document).on('change', '#actions', function () {
               var ids = $(this).val();
               $.ajax({
                   url: '{{route('backend.task.checkActionPermission')}}',
                   type: 'POST',
                   data: {
                       ids: ids
                   },
                   success: function (data) {
                       if(data.checkIn) {
                           statusElem.find('option[value={{ \App\Http\Models\Backend\Task::STATUS_CHECK_IN }}]').prop('disabled', false);
                       } else {
                           statusElem.find('option[value={{ \App\Http\Models\Backend\Task::STATUS_CHECK_IN }}]').prop('disabled', true);
                       }
                       if(data.checkOut) {
                           statusElem.find('option[value={{ \App\Http\Models\Backend\Task::STATUS_CHECK_OUT }}]').prop('disabled', false);
                       } else {
                           statusElem.find('option[value={{ \App\Http\Models\Backend\Task::STATUS_CHECK_OUT }}]').prop('disabled', true);
                       }
                   }
               })
            });

            /**
             * trigger change event to check permission for checkin/checkout status
             */
            var actionsVal = actions.val();
            actions.val(actionsVal).trigger('change');

            receiver.select2({
                multiple: true,
                allowClear: true,
                ajax: {
                    url: '/admin/task/data-select',
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            term: params.term,
                            type: $('#type').val()
                        };

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function (data) {
                        // Tranforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data.items
                        };
                    }
                }
            });

            var icheck = $('.icheck');

            icheck.iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal',
                increaseArea: '20%' // optional
            });

            if(icheck.is(':checked')) {
                receiver.prop("disabled", true);
            }

            icheck.on('ifChecked', function () {
                // disable receiver select box
                receiver.prop("disabled", true);
            }).on('ifUnchecked', function () {
                // enable receiver select box
                receiver.prop("disabled", false);
            });

            $(document).on('change', '#type', function () {
                var type = $(this).val();
                receiver.val(null).trigger('change');
                receiver.select2({
                    multiple: true,
                    allowClear: true,
                    ajax: {
                        url: '/admin/task/data-select',
                        dataType: 'json',
                        data: function (params) {
                            var query = {
                                term: params.term,
                                type: type
                            };

                            // Query parameters will be ?search=[term]&type=public
                            return query;
                        },
                        processResults: function (data) {
                            // Tranforms the top-level key of the response object from 'items' to 'results'
                            return {
                                results: data.items
                            };
                        }
                    }
                });
            })
        });
    </script>
@stop