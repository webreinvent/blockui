<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'BlockUI') }}</title>



<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

<!-- Styles -->
<link href="/public/vendor/nprogress/nprogress.css" rel="stylesheet">
<link href="/public/vendor/alertify/alertify.css" rel="stylesheet">
<link href="{{ mix('public/css/app.css') }}" rel="stylesheet">
