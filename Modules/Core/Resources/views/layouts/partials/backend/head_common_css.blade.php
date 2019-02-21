
@if(env('ASSETS_PRODUCTION_MODE') == false)

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
    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/formvalidation/formValidation.css">
    <link rel="stylesheet" href="{{assetsCoreMmenu()}}/examples/css/forms/validation.css">
    <link rel="stylesheet" href="{{moduleAssets('core')}}/backend-slidepanel.css">



    <link rel="stylesheet" href="{{moduleAssets('core')}}/asScrollable.css">


@else
    <link rel="stylesheet" href="{{moduleAssets('minified/common.css')}}">
@endif
