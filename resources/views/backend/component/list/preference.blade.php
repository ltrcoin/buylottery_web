@extends('layouts.layout')
@section('cssExtends')
    {{ Html::style('assets/admin/plugins/datatables/datatables.min.css') }}
    {{ Html::style('assets/admin/plugins/datatables/dataTables.bootstrap.min.css') }}
    {{ Html::style('https://cdn.datatables.net/colreorder/1.3.2/css/colReorder.dataTables.min.css') }}
    {{ Html::style('assets/admin/plugins/datatables/buttons.dataTables.min.css') }}
    <style>
        .field-head {
            cursor: move;
        }
        div.dt-button-collection {
            width: auto !important;
        }
    </style>
@endsection
@section('content')
    @include('core.form.form_header')
    @include('core.form.box_header', ['boxTitle' => 'Preference'])
    @if(\Illuminate\Support\Facades\Session::get('rscAuth')['user_is_admin'])
        <div class="form-group">
            @if($isDefault == 0)
                <a class="btn btn-success"
                   href="/{{ $module_name }}/preference/default">{{ tran('Edit default layout') }}</a>
            @else
                <a class="btn btn-success" href="/{{ $module_name }}/preference">{{ tran('Edit your own layout') }}</a>
            @endif
        </div>
    @endif
    <div class="help-block">{{ tran('Drag and drop column header to reorder the columns. All changes will be auto saved.') }}</div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover datatable_core preference-table" style="width: 100%">
            <thead>
            <tr>
                @foreach($fields as $f)
                    @if($loop->index == 0)
                        <th width="1%">
                            <input type="checkbox" class="check-all"/>
                        </th>
                    @else
                        <th class="field-head @if($f->attr_table_attr_name == 'user_role_id'){{"hidden"}}@endif"
                            data-field-name="{{ $f->app_table_attr_name }}">{{ dbtran($f->app_table_attr_label) }}
                            <label for="{{ $f->attr_table_attr_name }}" class="sr-only"></label>
                            <input class="hidden" checked id="{{ $f->attr_table_attr_name }}" type="checkbox"
                                   name="{{ $f->app_table_attr_id }}">
                        </th>
                    @endif
                @endforeach
            </tr>
            </thead>
            <tbody>
            <tr>
                @foreach($fields as $f)
                    @if($loop->index == 0)
                        <td><input type="checkbox" class="check-element"/></td>
                    @else
                        <td>...</td>
                    @endif
                @endforeach

            </tr>
            <tr>
                @foreach($fields as $f)
                    @if($loop->index == 0)
                        <td><input type="checkbox" class="check-element"/></td>
                    @else
                        <td>...</td>
                    @endif
                @endforeach

            </tr>
            </tbody>
        </table>
    </div>
    @include('core.form.box_footer')
    @include('core.form.form_footer')
@endsection
@section('datatable_script')
    {{ Html::script('assets/admin/plugins/datatables/datatables.min.js') }}
    {{ Html::script('assets/admin/plugins/datatables/dataTables.bootstrap.min.js') }}
    {{ Html::script('assets/admin/plugins/datatables/dataTables.buttons.min.js') }}
    {{ Html::script('assets/admin/plugins/datatables/buttons.colVis.min.js') }}
    {{ Html::script('assets/admin/plugins/datatables/dataTables.colReorder.min.js') }}
@endsection
@section('jsExtends')
    <script>
        $(document).ready(function () {
            var dt = $('.datatable_core').DataTable({
                colReorder: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'colvis',
                        columns: ':not(:first-child)'
                    }
                ],
                "stateSave": true,
                "ordering": false,
                "stateSaveCallback": function (settings, data) {
                    // Send an Ajax request to the server with the state object
                    $.ajax({
                        "url": "{{ route('table.state.save') }}",
                        "data": {
                            "module_id": "{{ $moduleId }}",
                            "state": data,
                            "is_default": '{{ $isDefault }}'
                        },//you can use the id of the datatable as key if it's unique
                        "dataType": "json",
                        "type": "POST",
                        "success": function () {
                            // submit edit form
                            var data = $('#edit-form').serializeArray();
                            var fieldList = [];
                            $.each(data, function (index, val) {
                                if (index > 0) {
                                    fieldList.push(val.name)
                                }
                            });
                            $.ajax({
                                'url': '{{route('table.preference.save')}}',
                                'type': 'POST',
                                'data': {
                                    field_list: fieldList,
                                    module_id: '{{ $moduleId }}',
                                    is_default: '{{ $isDefault }}'
                                }
                            });
                        }
                    });
                },
                "stateLoadCallback": function (settings) {
                    var o;
                    // Send an Ajax request to the server to get the data. Note that
                    // this is a synchronous request since the data is expected back from the
                    // function
                    $.ajax({
                        "url": "{{ route('table.state.load') }}",
                        "data": {
                            "module_id": "{{ $moduleId }}",
                            "is_default": '{{ $isDefault }}'
                        },
                        "async": false,
                        "dataType": "json",
                        "type": "POST",
                        "success": function (json) {
                            $.each(json.columns, function (index, value) {
                                json.columns[index].visible = (json.columns[index].visible == "true");
                            });
                            o = json;
                        }
                    });
                    return o;
                }
            });

            /**
             * Restrict to at least one visible column
             */
            dt.on('column-visibility', function (e, settings, column, state) {
                if (dt.columns(':visible').count() === 1) {
                    dt.column(column).visible(true);
                }
            });
        });
    </script>
@endsection