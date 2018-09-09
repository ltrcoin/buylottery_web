@if(!empty($buttons))
<div class="toolbar clearfix">
    <div>
        @if (!empty($buttons['backButton']))
            <a href="{{ $buttons['backButton'] }}" class="btn btn-default">
                <i class="fa fa-angle-left"></i> {{ __('label.back')  }}
            </a>
        @endif

        @if (!empty($buttons['createButton']))
            <a href="{{ $buttons['createButton'] }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ __('label.add_new') }}
            </a>
        @endif

        @if (!empty($buttons['saveButton']))
            <button type="submit" id="saveForm" class="btn btn-success">
                <i class="fa fa-save"></i> {{ __('label.save') }}
            </button>
        @endif

        @if (!empty($buttons['deleteButton']))
            <button type="button" class="btn btn-danger deleteAll pull-right"><i class="fa fa-trash"></i> {{ __('label.delete') }}</button>
            <input type="hidden" id="delUrl" value="{{ $buttons['deleteButton'] }}">
        @endif

        @if (!empty($buttons['customControls']) && count($buttons['customControls']) > 0)
            @foreach($buttons['customControls'] as $control)
                {!! $control !!}
            @endforeach
        @endif

    </div>
</div>
{{--@include('layouts.admin.delete_modal')--}}
@endif