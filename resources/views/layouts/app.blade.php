<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
    @include('layouts.partials.htmlheader')
@show

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-blue-navy-light sidebar-mini">
<div class="wrapper">

    @include('layouts.partials.mainheader')

    @include('layouts.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @if(Auth::check())
      {{ csrf_field() }}
            @if (Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'Programador' ||
            Auth::user()->Privilegio == 'Helpdesk' || Auth::user()->Privilegio == 'Cliente' ||
            Auth::user()->Privilegio == 'IT' || Auth::user()->Privilegio == 'Encuestado' || Auth::user()->Privilegio == 'Encuestador' )

                @include('layouts.partials.contentheader')
                @include('layouts.partials.alert')
                <section class="content">
                    @yield('main-content')
                </section>
            @else
                <section class="content-header">
                  <h1>
                    {{ trans('message.error') }}
                    <small> {{ trans('message.detalleD') }}</small>
                  </h1>
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> {{ trans('message.alerta') }}</a></li>
                </ol>
                </section>
                <section class="content">
                    @include('layouts.partials.error')
                </section>
            @endif
      @else
        <section class="content">
           @yield('main-content')
        </section>
      @endif
    </div><!-- /.content-wrapper -->

    @include('layouts.partials.controlsidebar')

    @include('layouts.partials.footer')

</div><!-- ./wrapper -->

@section('scripts')
    @include('layouts.partials.scripts')
@show

</body>
</html>
