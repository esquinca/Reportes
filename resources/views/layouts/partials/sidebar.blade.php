<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      @if(Auth::check())
        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="img/avatars/{{ Auth::user()->avatar }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!--Privilegio-->
                    <a href="javascript:void(0);"><i class="fa fa-key text-danger"></i> {{ Auth::user()->Privilegio }}</a>
                    <!-- Status -->
                    <a href="javascript:void(0);"><i class="fa fa-circle text-success"></i> {{ trans('message.online') }}</a>
                </div>
            </div>
            @if (Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'Programador')
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header">{{ trans('message.navigation') }}</li>
                <li><a href="{{ url('home') }}"><i class='fa fa-bookmark'></i> <span>{{ trans('message.home') }}</span></a></li>
                <li><a href="{{ url('assign') }}"><i class='fa fa-chain-broken'></i> <span>{{ trans('message.assign') }} {{ trans('message.concierge') }}</span></a></li>
                <li><a href="{{ url('assigncl') }}"><i class='fa fa-users'></i> <span>{{ trans('message.assign') }} {{ trans('message.cliente') }}</span></a></li>
                <!--
                <li><a href="{{ url('wlan') }}"><i class='fa fa-wifi'></i> <span>{{ trans('message.wlan') }}</span></a></li>
                -->
                <li><a href="{{ url('generate') }}"><i class='fa fa-pencil-square-o'></i> <span>{{ trans('message.generatereport') }}</span></a></li>
                <li><a href="{{ url('observation') }}"><i class='fa fa-search'></i> <span>{{ trans('message.observation') }}</span></a></li>
                <li><a href="{{ url('viewreports') }}"><i class='fa fa-file-text-o'></i> <span>{{{ trans('message.viewreport') }}}</span></a></li>

                <li class="header">{{ trans('message.page') }}</li>

                <li><a href="{{ url('profile') }}"><i class='fa fa-user'></i> <span>{{ trans('message.profile') }}</span></a></li>
                <li><a href="{{ url('config_one') }}"><i class='fa fa-cog'></i> <span>{{ trans('message.settings') }}</span></a></li>
                <li><a href="{{ url('about') }}"><i class='fa fa-users'></i> <span>{{ trans('message.aboutMe') }}</span></a></li>

            </ul>
            <!-- /.sidebar-menu -->
            @endif
            @if (Auth::user()->Privilegio == 'IT')
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header">{{ trans('message.navigation') }}</li>
                <li><a href="{{ url('home') }}"><i class='fa fa-bookmark'></i> <span>{{ trans('message.home') }}</span></a></li>
                <!--<li><a href="{{ url('wlan') }}"><i class='fa fa-wifi'></i> <span>{{ trans('message.wlan') }}</span></a></li>-->
                <li><a href="{{ url('generate') }}"><i class='fa fa-pencil-square-o'></i> <span>{{ trans('message.generatereport') }}</span></a></li>
                <li><a href="{{ url('observation') }}"><i class='fa fa-search'></i> <span>{{ trans('message.observation') }}</span></a></li>
                <li><a href="{{ url('viewreports') }}"><i class='fa fa-file-text-o'></i> <span>{{{ trans('message.viewreport') }}}</span></a></li>

                <li class="header">{{ trans('message.page') }}</li>

                <li><a href="{{ url('profile') }}"><i class='fa fa-user'></i> <span>{{ trans('message.profile') }}</span></a></li>
                <li><a href="{{ url('about') }}"><i class='fa fa-users'></i> <span>{{ trans('message.aboutMe') }}</span></a></li>
            </ul>
            <!-- /.sidebar-menu -->
            @endif

            @if (Auth::user()->Privilegio == 'Cliente')
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header">{{ trans('message.navigation') }}</li>
                <li><a href="{{ url('home') }}"><i class='fa fa-bookmark'></i> <span>{{ trans('message.home') }}</span></a></li>
                <li><a href="{{ url('viewreport') }}"><i class='fa fa-file-text-o'></i> <span>{{{ trans('message.viewreport') }}}</span></a></li>

                <li class="header">{{ trans('message.page') }}</li>

                <li><a href="{{ url('profile') }}"><i class='fa fa-user'></i> <span>{{ trans('message.profile') }}</span></a></li>
                <li><a href="{{ url('about') }}"><i class='fa fa-users'></i> <span>{{ trans('message.aboutMe') }}</span></a></li>
            </ul>
            <!-- /.sidebar-menu -->
            @endif
        @endif



      @else
        <ul class="sidebar-menu">
          <li class="header">{{ trans('message.header') }}</li>
          <li class='Active'><a href="{{ url('home') }}"><i class='fa fa-close'></i> <span>{{ trans('message.404error') }}</span></a></li>
        </ul>
      @endif
    </section>
    <!-- /.sidebar -->
</aside>
