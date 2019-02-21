<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">
    <title>@if(isset($data->title)){{$data->title}}@else{{Config::get('core.name')}}
        v{{Config::get('core.version')}}@endif</title>
    <!--common head-->
    <link rel="apple-touch-icon" href="{{assetsCoreMmenu()}}/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="{{assetsCoreMmenu()}}/images/favicon.ico">

    @include('core::layouts.partials.backend.head_common_css')


    <!-- Fonts -->
    <link rel="stylesheet" href="{{assetsCoreGlobal()}}/fonts/font-awesome/font-awesome.css">
    <link rel="stylesheet" href="{{assetsCoreGlobal()}}/fonts/web-icons/web-icons.min.css">
    <link rel="stylesheet" href="{{assetsCoreGlobal()}}/fonts/brand-icons/brand-icons.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>

    <base href="{{\URL::to('/')}}">
    <link rel="stylesheet" href="{{moduleAssetsUrl('core', '/backend-common.css')}}">

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

    <style>
        body{
            zoom: 90%;
        }
    </style>

    <!--/common head-->

    <!-- Global Scripts -->
    @include("core::layouts.partials.backend.extendable.global_styles")
    <!-- Global Scripts -->

    <!---page specific-->
    @yield('page_specific_head')

    <!--/page specific-->

    <!--push notification-->
    @if(env('ONESIGNAL_APP_ID'))
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        var OneSignal_player_id;
        var OneSignal = window.OneSignal || [];
        OneSignal.push(["init", {
            appId: "<?php echo env('ONESIGNAL_APP_ID') ?>",
            autoRegister: true,
            notifyButton: {
                enable: true
            }
        }]);

        OneSignal.push(function() {
            OneSignal.showHttpPrompt();
        });

        OneSignal.push(function() {
            OneSignal.getUserId(function(userId)
            {

                console.log("one signal-->", userId);

                OneSignal.sendTag('{{env('APP_SHORT_NAME')}}-user-id', {{\Auth::user()->id}});
                OneSignal_player_id = userId;
            });
        });
    </script>
    @endif

    <!--/push notification-->

</head>
