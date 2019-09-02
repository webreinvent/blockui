<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">

    <title>@if(isset($data->title)){{$data->title}}@else{{Config::get('core.name')}}
        v{{Config::get('core.version')}}@endif</title>

    <base href="{{\URL::to('/')}}">

    @if(assignableMinified())
        <link href="{{themeAssetsUrl('css_minified/style.css')}}" rel="stylesheet" type="text/css">
    @else
        <link rel="stylesheet" href="{{themeAssetsUrl('css/bootstrap.css')}}">
        <link rel="stylesheet" href="{{themeAssetsUrl('css/common.css')}}">
        <link rel="stylesheet" href="{{themeAssetsUrl('css/site.css')}}">
    @endif


    <!---page specific-->
@yield('page_specific_head')
<!--/page specific-->


</head>
