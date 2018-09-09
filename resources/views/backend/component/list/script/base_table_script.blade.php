<script>
    $(document).ready(function () {
        var date_range_filter = $('.column_filter[data-filter-type="date-range"]');

        var customTableButton = '<button class="btn btn-default pull-right" type="button" id="datatable_clear_state"><i class="fa fa-eraser"></i> {{ trans('label.clear_filter') }}</button>';

        /**
         * tách ra như thế này để khi customize ở các trang list không cần phải copy lại cả file to này,
         * cũng dễ cho sau này cập nhật các filter sử dụng chung (đoạn code bên dưới) không cần phải cập nhật lại các trang customize
         */
        @include($initTableScript)

        //        table.columns.adjust().draw();
        /**
         * restore search values to search boxes
         */
        $(document).on('init.dt', function (e, settings) {
            var api = new $.fn.dataTable.Api(settings);
            var state = api.state.loaded();
            var columnNums = $('.datatable_core').find('thead tr:first th');
            if (state) {
                $.each(columnNums, function (index, column) {
                    var searchObj = state.columns[index].search;
                    var searchText = searchObj.search;
                    if (searchText != '') {
                        var filterColumn = $('#column' + index + '_filter');
                        var filterType = filterColumn.data('filter-type');
                        switch (filterType) {
                            case 'text':
                                filterColumn.val(searchText);
                                break;
                            case 'select':
                                filterColumn.val(searchText).trigger('change');
                                break;
                            case 'date-range':
                                filterColumn.val(searchText);
                                break;
                        }
                    }
                });
            }
        });

        $(document).on('draw.dt', function () {
            date_range_filter.daterangepicker({
                showDropdowns: true,
                autoUpdateInput: false,
                locale: {
                    "format": 'YYYY-MM-DD',
                    "separator": " - ",
                    "applyLabel": "{{__('label.dateRange.applyLabel')}}",
                    "cancelLabel": "{{__('label.dateRange.cancelLabel')}}",
                    "fromLabel": "{{__('label.dateRange.fromLabel')}}",
                    "toLabel": "{{__('label.dateRange.toLabel')}}",
                    "customRangeLabel": "Custom",
                    "weekLabel": "{{__('label.dateRange.weekLabel')}}",
                    "daysOfWeek": [
                        "{{ __('label.dateRange.daysOfWeek.Su') }}",
                        "{{ __('label.dateRange.daysOfWeek.Mo') }}",
                        "{{ __('label.dateRange.daysOfWeek.Tu') }}",
                        "{{ __('label.dateRange.daysOfWeek.We') }}",
                        "{{ __('label.dateRange.daysOfWeek.Th') }}",
                        "{{ __('label.dateRange.daysOfWeek.Fr') }}",
                        "{{ __('label.dateRange.daysOfWeek.Sa') }}"
                    ],
                    "monthNames": [
                        "{{ __('label.dateRange.monthNames.1') }}",
                        "{{ __('label.dateRange.monthNames.2') }}",
                        "{{ __('label.dateRange.monthNames.3') }}",
                        "{{ __('label.dateRange.monthNames.4') }}",
                        "{{ __('label.dateRange.monthNames.5') }}",
                        "{{ __('label.dateRange.monthNames.6') }}",
                        "{{ __('label.dateRange.monthNames.7') }}",
                        "{{ __('label.dateRange.monthNames.8') }}",
                        "{{ __('label.dateRange.monthNames.9') }}",
                        "{{ __('label.dateRange.monthNames.10') }}",
                        "{{ __('label.dateRange.monthNames.11') }}",
                        "{{ __('label.dateRange.monthNames.12') }}"
                    ],
                    "firstDay": {{__('label.dateRange.firstDay')}}
                }
            });

            date_range_filter.on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                searchTable($(this));
            });
            date_range_filter.on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                searchTable($(this));
            });

        });

        function searchTable(elem) {
            listTable.column($(elem).attr('data-column')).search(
                $(elem).val()
            ).draw();
        }

        $('input.column_filter').on('keyup', function () {
            searchTable(this);
        });

        $('select.column_filter').on('change', function () {
            searchTable(this);
        });

        $(document).on('click', '#datatable_clear_state', function () {
            $('.daterangepicker .cancelBtn').click();
            $('input.column_filter[type=text]').val(null);
            $('select.column_filter').val(null).trigger('change');
            listTable.state.clear();
            location.reload();
        });

        var detailModal = $('#detailModal');
        $(document).on('click', '.viewItem', function () {
            var itemId = $(this).data('id');
            // AJAX request
            $.ajax({
                url: '/admin/{{ $module_name }}/detail/' + itemId,
                type: 'get',
                dataType: 'html',
                success: function (response) {
                    // Add response in Modal body
                    detailModal.find('.modal-body').html(response);

                    // Display Modal
                    detailModal.modal('show');
                }
            });
        });
        detailModal.on('hidden.bs.modal', function () {
            detailModal.find('.modal-body').empty();
        });
        $(document).on('click', '#resizeable tbody tr td:nth-child(2)', function() {
            var viewDetailButton = $(this).closest('tr').find('.viewItem');
            if( viewDetailButton ) {
                viewDetailButton.click();
            }
        })
    })
    ;
</script>