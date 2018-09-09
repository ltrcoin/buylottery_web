<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">{{ __('label.tasks.name') }}</label>
            <span>{{$item->name}}</span>
        </div>

        <div class="form-group">
            <label for="organization_id"
            >{{ __('label.tasks.org_owner') }}</label>
            <span>{{$item->organization->get()[0]->name}}</span>
        </div>

        <div class="form-group">
            <label for="type">{{ __('label.tasks.type') }}</label>
            <span>{{ __('label.tasks.' . \App\Http\Models\Backend\Task::$TYPE[$item->type]) }}</span>
        </div>
        <div class="form-group">
            <label for="receiver"
            >{{ __('label.tasks.receiver') }}</label>
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
            <span>{{$receiver}}</span>
        </div>
    </div>
    <!-- /.col -->
    <div class="col-md-6">
        <div class="form-group">
            <label for="type">{{ __('label.tasks.status') }}</label>
            <span>{{__('label.tasks.' . \App\Http\Models\Backend\Task::$STATUS[$item->status])}}</span>
        </div>

        <div class="form-group">
            <label for="actions">{{ __('label.actions.list_title') }}</label>
            <span>{{ implode(', ', $item->actions->pluck('name')->all()) }}</span>
        </div>

        <div class="form-group">
            <label for="">{{ __('label.tasks.start_date') }}</label>
            <span>{{ $item->start_date }}</span>
        </div>

        <div class="form-group">
            <label for="">{{ __('label.tasks.end_date') }}</label>
            <span>{{ $item->end_date }}</span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="description">{{ __('label.description') }}</label>
            <span>{{$item->description}}</span>
        </div>
    </div>


    @if(!$form_field->isEmpty())
        <div class="col-md-12">
            <div class="form-group">
                <label>{{ __('label.actions.lbl_form_field') }} </label>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th width="8%">No.</th>
                        <th width="250px">{{ __('label.actions.lbl_field_name') }}</th>
                        <th width="250px">{{ __('label.actions.lbl_field_type') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($form_field as $key=>$value)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{ $value->field_name }}</td>
                            <td>{{ $value->field_type }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <br>
                <p><a href="{{route('backend.task.downloadForm',['id'=>$item->id])}}" id="download"
                      class="btn btn-primary">{{ __('label.actions.lbl_download') }}</a></p>
            </div>
        </div>
    @endif

</div>
<!-- /.row -->