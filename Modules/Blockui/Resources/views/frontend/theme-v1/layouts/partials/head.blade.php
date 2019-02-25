<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'BlockUI') }}</title>



<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

<!-- Styles -->
<link href="{{url("/")}}/public{{ mix('css/blockui-vendor.css') }}" rel="stylesheet">
<link href="{{url("/")}}/public{{ mix('css/app.css') }}" rel="stylesheet">
