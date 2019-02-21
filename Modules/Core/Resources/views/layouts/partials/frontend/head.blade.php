<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">
    <title>@if(isset($data->title)){{$data->title}}@else{{Config::get('core.name')}} v{{Config::get('core.version')}}@endif</title>
    <!--common head-->
    <link rel="apple-touch-icon" href="{{assetsCoreMmenu()}}/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="{{assetsCoreMmenu()}}/images/favicon.ico">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{assetsCoreGlobal()}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{assetsCoreGlobal()}}/css/bootstrap-extend.min.css">
    <link rel="stylesheet" href="{{assetsCoreMmenu()}}/css/site.min.css">
    <!-- Plugins -->
    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/animsition/animsition.css">
    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/asscrollable/asScrollable.css">
    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/switchery/switchery.css">
    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/intro-js/introjs.css">
    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/slidepanel/slidePanel.css">
    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/jquery-mmenu/jquery-mmenu.css">
    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/flag-icon-css/flag-icon.css">
    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/ladda/ladda.css">
    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/alertify/alertify.css">
    <link rel="stylesheet" href="{{assetsCoreMmenu()}}/examples/css/advanced/alertify.css">
    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/nprogress/nprogress.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{assetsCoreGlobal()}}/fonts/web-icons/web-icons.min.css">
    <link rel="stylesheet" href="{{assetsCoreGlobal()}}/fonts/brand-icons/brand-icons.min.css">
    {{--<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>--}}

    <base href="{{\URL::to('/')}}">

    <!--[if lt IE 9]>
    <script src="{{assetsCoreGlobalVendor()}}/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
    <!--[if lt IE 10]>
    <script src="{{assetsCoreGlobalVendor()}}/media-match/media.match.min.js"></script>
    <script src="{{assetsCoreGlobalVendor()}}/respond/respond.min.js"></script>
    <![endif]-->
    <!-- Scripts -->
    <script src="{{assetsCoreGlobalVendor()}}/breakpoints/breakpoints.js"></script>
    <script>
        Breakpoints();
    </script>
    <!--/common head-->
    <!---page specific-->
@yield('page_specific_head')
<!--/page specific-->
</head>
