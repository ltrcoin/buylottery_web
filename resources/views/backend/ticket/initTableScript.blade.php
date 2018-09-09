
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
            // DO NOT DELETE default setting
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
        ],
        "order": [[ {{ $defaultOrderBy }}, '{{ $defaultOrderDir }}']]
    });