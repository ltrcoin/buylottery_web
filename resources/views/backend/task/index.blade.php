@extends('backend.layouts.main')
@section('title', __('label.tasks.title'))
@section('content')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/bootstrap3-editable-1.5.1/bootstrap3-editable/css/bootstrap-editable.css')}}">
    <style>
        #detailModal label {
            display: block;
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
        <ul class="nav nav-tabs">
            <li class="active"><a href="javascript:void(0)">{{__('label.tasks.list')}}</a></li>
            <li class=""><a href="{{route('backend.actions.index')}}">{{__('label.actions.list_title')}}</a></li>
            <li class=""><a href="{{route('backend.reports.index')}}">{{__('label.reports.list')}}</a></li>
        </ul>
        <ol class="breadcrumb">
            <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">{{ __('label.tasks.list') }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-sm-2">
                                <a class="btn btn-primary"
                                   href="{{route('backend.task.vAdd')}}">{{ __('label.add_new') .' '. __('label.tasks.title') }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-danger deleteAll">{{__('label.delete')}}</button>
                                    <input type="hidden" id="delUrl" value="{{url('admin/task/delete')}}">
                                </div>
                                <div class="col-sm-11">
                                    <div class="dataTables_length pull-right">
                                        <label>
                                            Show <select class="form-control input-sm showPage">
                                                <option value="10" {{$pageSize == 10 ? 'selected' : ''}}>10</option>
                                                <option value="25" {{$pageSize == 25 ? 'selected' : ''}}>25</option>
                                                <option value="50" {{$pageSize == 50 ? 'selected' : ''}}>50</option>
                                                <option value="100" {{$pageSize == 100 ? 'selected' : ''}}>100</option>
                                            </select> entries
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="task-table" class="table table-bordered table-striped dataTable"
                                           role="grid" aria-describedby="example1_info">
                                        <thead>
                                        <tr>
                                            <th width="1%">
                                                <input type="checkbox" id="checkAll">
                                            </th>
                                            <th width="15%">{{ __('label.tasks.name') }}</th>
                                            <th width="15%">{{ __('label.tasks.org_owner') }}</th>
                                            <th width="15%">{{ __('label.actions.list_title') }}</th>
                                            <th width="15%">{{ __('label.tasks.receiver') }}</th>
                                            <th width="10%">{{ __('label.tasks.start_date') }}</th>
                                            <th width="10%">{{ __('label.tasks.end_date') }}</th>
                                            <th width="10%">{{ __('label.tasks.status') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($listTask as $key => $item)
                                            @php
                                                $type = $item->type;
                                                if(empty($item->assign_all)) {$receiver = '';
                                                    switch ($type) {
                                                        case \App\Http\Models\Backend\Task::TYPE_ORG:
                                                            $receiver = implode(', ', $item->organizations->pluck('name')->all());
                                                            break;
                                                        case \App\Http\Models\Backend\Task::TYPE_GROUP:
                                                            $receiver = implode(', ', $item->groups->pluck('name')->all());
                                                            break;
                                                        case \App\Http\Models\Backend\Task::TYPE_USER:
                                                            $receiver = implode(', ', $item->users->pluck('name')->all());
                                                            break;
                                                    }
                                                } else {
                                                    $receiver = __('label.all') . ' ' . __('label.tasks.' . \App\Http\Models\Backend\Task::$TYPE[$item->type]);
                                                }
                                            @endphp
                                            
                                            <tr class="{{$key%2 == 0 ? 'even' : 'odd'}}">
                                                <td>
                                                    <input title="checkbox" type="checkbox" class="checkItem" value="{{$item->id}}">
                                                </td>
                                                <td class="sorting_1">{{ $item->name }}</td>
                                                <td>{{ $item->organization()->get()[0]->name }}</td>
                                                <td>{{ implode(', ', $item->actions->pluck('name')->all()) }}</td>
                                                <td>{{ $receiver }}</td>
                                                <td>{{ $item->start_date }}</td>
                                                <td>{{ $item->end_date }}</td>
                                                <td class="text-center">
                                                    @if(Auth::user()->hasAnyRole('backend.task.edit'))
                                                    <a class="inline-edit" href="#" data-type="select" data-url="/admin/task/updateStatus" data-pk="{{ $item->id }}">{{ __('label.tasks.' . \App\Http\Models\Backend\Task::$STATUS[$item->status]) }}</a>
                                                    @else
                                                        {{ __('label.tasks.' . \App\Http\Models\Backend\Task::$STATUS[$item->status]) }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)"
                                                       class="viewItem" data-id="{{$item->id}}" title="{{__('label.detail')}}"><i
                                                                class="fa fw fa-eye"></i></a>
                                                    <a href="{{route('backend.task.vEdit',['id'=>$item->id])}}"
                                                       class="editItem" id="" title="{__('label.edit')}}"><i
                                                                class="fa fa-fw fa-edit"></i></a>
                                                    <a href="javascript: void(0);" class="deleteItem" id="{{$item->id}}"
                                                       title="{{__('label.delete')}}"><i class="fa fa-fw fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="even">
                                                <td colspan="7" style="font-style: italic;">{{__('label.no_data')}}</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <!-- <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 50 entries</div> -->
                                </div>
                                <div class="col-sm-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                                        {{ $listTask->appends($filter)->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- begin modal -->
    <div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Tìm kiếm</h4>
                </div>
                <div class="form-group">
                    <form id="searchForm" action="{{route('backend.task.index')}}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="message-text" class="control-label">Khoa:</label>
                                <select class="form-control" id="sType" name="type" style="width: 50%;">
                                    <option value="0">--Chọn Khoa--</option>
                                    @if(isset($arrKhoa) && is_array($arrKhoa))
                                        @foreach($arrKhoa as $key=>$khoa)
                                            <option value="{{$key}}" {{(isset($filter['khoa']) && $filter['khoa'] == $key) ? 'selected' : ''}}>{{$khoa}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Tên giảng viên:</label>
                                <input type="text" class="form-control" id="sName" name="name"
                                       value="{{isset($filter['name']) ? $filter['name'] : ''}}">
                                <input type="hidden" name="pageSize" id="sPageSize" value="{{$pageSize}}">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="searchBtn" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal -->
    <!--  detail modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="detailModalLabel">{{__('label.tasks.detail')}}</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{__('label.close')}}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /detail modal -->
    <script src="{{ asset('backend/plugins/bootstrap3-editable-1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
    <script>
        $(function(){
            $.fn.editable.defaults.mode = 'inline';
            $.fn.editable.defaults.ajaxOptions = {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'put'
            };
            $('.inline-edit').editable({
                source: [
                    @foreach(\App\Http\Models\Backend\Task::$STATUS as $key => $val)
                    {value: {{ $key }}, text: '{{ __('label.tasks.' . $val) }}'},
                    @endforeach
                ],
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
            var detailModal = $('#detailModal');
            $(document).on('click', '.viewItem', function () {
                var itemId = $(this).data('id');
                // AJAX request
                $.ajax({
                    url: '/admin/task/detail/' + itemId,
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
            })
        });
    </script>
@stop