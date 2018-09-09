@php
    $unread = \App\Http\Models\Backend\User::find(\Illuminate\Support\Facades\Auth::user()->id)->unreadNotifications();
@endphp
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-bell-o"></i>
    @if(count($unread))
    <span class="label label-warning">{{ count($unread) }}</span>
    @endif
</a>
<ul class="dropdown-menu">
    <li class="header">{{ __('label.notification.unread', ['count' => count($unread)]) }}</li>
    <li>
        <!-- inner menu: contains the actual data -->
        <ul class="menu">
            @foreach($unread as $item)
            <li>
                @php
                    $replace = empty(json_decode($item->replace, true)) ? [] : json_decode($item->replace, true);
                @endphp
                <a href="{{ route('backend.notification.index') }}" title="{{ __($item->content, $replace) }}">
                    <i class="fa fa-comment-o text-aqua"></i> {{ __($item->content, $replace) }}
                </a>
            </li>
            @endforeach
        </ul>
    </li>
    <li class="footer"><a href="{{ route('backend.notification.index') }}">{{ __('label.notification.view_all') }}</a></li>
</ul>