<ul id="menuweb" class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <li class="active treeview">
      <a href="{{route('backend.site.index')}}">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
    </li>
    <!-- game menu -->
    <li>
        <a href="{{route('backend.game.index')}}"><i class="fa fa-list"></i>{{ __('label.game.menu_title') }}</a>
    </li>

    <!-- menu ticket -->
    <li class="treeview">
        <a href="{{ route('backend.ticket.index') }}"><i class="fa fa-ticket"></i> {{ __('label.game.ticket_menu') }}</a>
    </li>

    <!-- menu ticket -->
    <li class="treeview">
        <a href="{{ route('backend.customer.index') }}"><i class="fa fa-user"></i> {{ __('label.customer.title') }}</a>
    </li>
   
    <li class="treeview">
      <a href="javascript: void(0);">
        <i class="fa fa-users"></i>
        <span>{{ __('label.users.menu') }}</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{route('backend.user.index')}}"><i class="fa fa-list"></i>{{ __('label.users.list') }}</a></li>
        <li><a href="{{route('backend.user.vAdd')}}"><i class="fa fa-edit"></i>{{ __('label.users.add') }}</a></li>
        <li><a href="{{route('backend.user.profile')}}"><i class="fa fa-user"></i>{{ __('label.users.profile') }}</a></li>
      </ul>
    </li>

    <li class="treeview">
      <a href="{{route('backend.user.index')}}" target="_blank">
        <i class="fa fa-book"></i>
        <span>{{ __('label.help') }}</span>
      </a>
    </li>

    <li class="treeview">
      <a href="{{route('backend.site.logout')}}" target="_blank">
        <i class="fa fa-sign-out"></i>
        <span>{{ __('label.sign_out') }}</span>
      </a>
    </li>

  </ul>