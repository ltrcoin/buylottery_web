<div class="row">
    <div class="col-md-12 form-group">
        <label>{{ __('label.actions.lbl_action_name') }}: </label>
        <span id="action_name">{{ $item->name }}</span>
    </div>
    <div class="col-md-12 form-group">
        <label>{{ __('label.actions.lbl_organization') }}: </label>
        <span id="organization_name">{{ $item->organization->name }}</span>
    </div>
    <div class="col-md-12 form-group">
        <label>{{ __('label.actions.lbl_groups') }}: </label>
        @php
            $forAll = $item->for_all_group;
                if ( !$forAll ) {
                    $groups = implode( ', ', $item->groups->pluck( 'name' )->all() );
                } else {
                    $groups = __( 'label.all' ) . ' ' . __( 'label.group.title');
                }
        @endphp
        <span id="group_name">{{ $groups }}</span>
    </div>
    <div class="col-md-6 form-group">
        <label>{{ __('label.actions.lbl_can_checkin') }}: </label>
        <input type="checkbox" @if($item->can_checkin) checked @endif id="action_checkin" disabled ="disabled">
    </div>
    <div class="col-md-6 form-group">
        <label>{{ __('label.actions.lbl_can_checkout') }}: </label>
        <input type="checkbox" @if($item->can_checkout) checked @endif id="action_checkout" disabled ="disabled">
    </div>
    <div class="col-md-12 form-group">
        <label>{{ __('label.actions.lbl_description') }}: </label>
        <span id="description">{{ $item->description }}</span>
    </div>
    <div class="col-md-12 form-group">
        @if(!$form_field->isEmpty())
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
            <p><a href="{{route('backend.actions.downloadForm',['id'=>$item->id])}}" id="download" class="btn btn-primary">{{ __('label.actions.lbl_download') }}</a></p>
        @endif
    </div>
    <!-- /.col -->
</div>