<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @yield('contentheader_title', 'Page Header here')
        <small>@yield('contentheader_description')</small>
    </h1>
    <ol class="breadcrumb">
        <!--<li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('adminlte_lang::message.level') }}</a></li>-->
        <li class="active"><a href="@yield('breadcrumb_route')"><i class="fa fa-dashboard"></i>@yield('breadcrumb_title')</a></li>
    </ol>
</section>
