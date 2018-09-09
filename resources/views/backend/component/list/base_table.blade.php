<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                @if(!empty($buttons))
                <div class="box-header">
                    @include('backend.component.button_bar')
                </div>
                @endif
                <div class="box-body table-responsive">
                    <table id="resizeable" class=" table table-striped table-bordered table-hover datatable_core"
                           style="min-width: 100%">
                        <thead>
                        <tr class="colHeaders">
                            <th style="width: 2%">
                                <input type="checkbox" id="checkAll">
                            </th>
                            @foreach($fields as $f)
                                @php
                                $columnWidth = empty($f['width']) ? null : $f['width'];
                                @endphp
                                @if($f['title'] != '#')
                                    <th id="column-header-{{$loop->index}}" style="@if($f['name'] == '_' && empty($columnWidth)) width: 2% @elseif(!empty($columnWidth)) width: {{ $columnWidth }} @endif" ><span>{{ trans($f['title']) }}</span>
                                        <div id="column-header-{{$loop->index}}-sizer"></div>
                                    </th>
                                @endif
                            @endforeach
                        </tr>
                        @include('backend.component.list.table_filter')
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
