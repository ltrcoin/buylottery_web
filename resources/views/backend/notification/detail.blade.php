<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            @php
            $locale = empty(\Session::get('locale')) ? 'vi' : \Session::get('locale');
            \Carbon\Carbon::setLocale($locale)
            @endphp
            <i class="fa fa-clock-o"></i> <span class="mailbox-read-time" data-toggle="tooltip" data-placement="right"
                                                title="{{\Carbon\Carbon::parse($item->created_at)->format(__('label.datetime_format', [], $locale))}}">
                {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
            </span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            @php
                $replace = empty( json_decode( $item->replace, true ) ) ? [] : json_decode( $item->replace, true );
                $content   = __( $item->content, $replace, $locale );
            @endphp
            {{ $content }}
        </div>
    </div>
    <!-- /.col -->
</div>