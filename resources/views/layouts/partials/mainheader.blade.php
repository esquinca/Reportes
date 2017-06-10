<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini" style="font-size: 50%;">{{ trans('message.empresa') }}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{ trans('message.empresa') }}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="javascript:void(0);" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('message.togglenav') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" title="{{ trans('locale.lang') }}">
                        <i class="fa fa-globe"></i><span class="label label-warning">{{ trans('locale.numlang') }}</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" style="width: 10%">
                        <!--<li class="header">{{ trans('message.tabmessages') }}</li>-->
                        <li>
                            <!-- inner menu: contains the messages -->
                            <ul class="menu" style="width: 100%">
                                <li><a href="{{ url('lang/en') }}"><div class="pull-left"><img src="/img/flags/en.png" class="img-circle" alt="User Image"></div><h4>{{ trans('locale.en') }}</h4> </a></li>
                                <li><a href="{{ url('lang/es') }}"><div class="pull-left"><img src="/img/flags/es.png" class="img-circle" alt="User Image"></div><h4>{{ trans('locale.es') }}</h4> </a></li>
                            </ul><!-- /.menu -->
                        </li>
                        <!--<li class="footer"><a href="javascript:void(0);"></a></li>-->
                    </ul>
                  </li><!-- /.messages-menu -->


                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                @else
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="img/avatars/{{ Auth::user()->avatar }}" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="img/avatars/{{ Auth::user()->avatar }}" class="img-thumbnail" alt="User Image" />
                                <p>
                                    {{ Auth::user()->nombrecomp }}
                                    <small>{{ trans('message.dateAct') }} <?php $now = new \DateTime();
                                    echo $now->format('d-m-Y');?></small>

                                    <small>{{ Auth::user()->email }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                @if (Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'Programador' ||
                                Auth::user()->Privilegio == 'Helpdesk' || Auth::user()->Privilegio == 'Cliente' ||
                                Auth::user()->Privilegio == 'IT')
                                  <div class="pull-left">
                                      <a href="{{ url('/profile') }}" class="btn btn-default btn-flat"><span class="glyphicon glyphicon-user"></span> {{ trans('message.profile') }}</a>
                                  </div>
                                @endif
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"><span class="fa fa-power-off"></span> {{ trans('message.signout') }}</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif

            
            </ul>
        </div>
    </nav>
</header>
