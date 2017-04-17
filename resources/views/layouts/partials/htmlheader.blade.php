<head>
    <meta charset="UTF-8">
    <title> {{ trans('message.empresa') }} - @yield('htmlheader_title', '')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="description" content="{{ trans('message.landescription') }}">
    <meta name="author" content="{{ trans('message.userdevelop') }} {{ trans('message.userdevelopme') }}">

    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('/css/style_main.css') }}" rel="stylesheet" type="text/css" />
    <!-- Skin Theme-->
    <link href="{{ asset('/css/skins/skin-blue-navy-light.css') }}" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="{{ asset('/plugins/iCheck/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <!--Favicon-->
    <link rel="shortcut icon" type="image/png" href="./favicon/favicon.png"/>
    <!--DataTables-->
    <link href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!--select2-->
    <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- bootstrap datepicker -->
    <link href="{{ asset('/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
