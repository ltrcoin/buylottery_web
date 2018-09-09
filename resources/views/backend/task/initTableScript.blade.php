
{{--bỏ comment thẻ script ở ĐẦU file khi code để nhận diện js code cho dễ, nhớ comment khi hoàn thành code hay khi chạy thử--}}
{{--<script>--}}
    var listTable = $('.datatable_core').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": true, // muốn giữ trạng thái sắp xếp/tìm kiếm khi vào trang con rồi quay lại trang list thì để true
        "autoWidth": false,
        "bSortCellsTop": true,
        initComplete: function () {
            $("div.dataTables_filter").prepend(customTableButton);
        },
        "ajax": "/admin/{{ $module_name }}/indexData",
        language: {
            url: '{{ \App\Helpers\DataTables::getTranslateUrl() }}'
        },
        columnDefs: [
                @if(!empty($unorderable))
            {
                targets: [{{ implode(',', $unorderable) }}],
                'orderable': false
            },
                @endif
            @if(!empty($columnClasses))
                @foreach($columnClasses as $col)
                    {
                    className: '{{ $col['className'] }}', targets: [{{ $col['targets'] }}]
                    },
                @endforeach
            @endif
            {
                targets: 0,
                "orderable": false,
                render: function (data, type, row, meta) {
                    if (type === 'display') {
                        data = '<input type="checkbox" class="checkItem" name="ids[]" value="' + data + '">';
                    }

                    return data;
                }
            },
            {
                targets: -1,
                "orderable": false,
                render: function (data, type, row, meta) {
                    data = '<a href="javascript:void(0)"' +
                        '   class="viewItem" data-id="' + row[0] + '" title="{{__('label.detail')}}"><i' +
                        '            class="fa fw fa-eye"></i></a>\n' +
                        '<a href="/admin/{{ $module_name }}/edit/' + row[0] + '"' +
                        '   class="editItem" id="" title="{{__('label.edit')}}"><i\n' +
                        '            class="fa fa-fw fa-edit"></i></a>\n' +
                        '<a href="javascript: void(0);" class="deleteItem" id="' + row[0] + '"' +
                        '   title="{{__('label.delete')}}"><i class="fa fa-fw fa-remove"></i></a>';
                    return data;
                }
            },
            {
                targets: -2,
                "orderable": false,
                render: function (data, type, row, meta) {
                    if(type === 'display'){
                        @if(Auth::user()->hasAnyRole('backend.task.edit'))
                        data = '<a class="inline-edit" href="#" data-type="select" data-url="/admin/task/updateStatus" data-pk="' + row[0] + '">' + data + '</a>';
                        @endif
                    }
                    return data;
                }
            }
        ],
        "order": [[ {{ $defaultOrderBy }}, '{{ $defaultOrderDir }}']]
    });

    $(document).on('draw.dt', function() {
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editable.defaults.ajaxOptions = {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'put'
        };
        $('.inline-edit').each(function() {
            $(this).editable({
                source: '/admin/task/statusSource/' + $(this).data('pk'),
                success: function(response, newValue) {
                    // show error when record not found
                    if(response.status == 'false') {
                        return response.msg;
                    }
                },
                error: function(err) {
                    return err.responseJSON.value[0]
                }
            });
        });
    });