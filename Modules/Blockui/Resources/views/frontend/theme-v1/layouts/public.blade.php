<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
@include('blockui::frontend.theme-v1.layouts.partials.head')

<!--page specific head-->
@yield('head')
<!--/page specific head-->

</head>
<body>
<div id="app">

    @include('partials.nav')

    <main class="py-4">

        @yield('content')



    </main>


</div>


<!-- Scripts -->
<script src="{{url("/")}}/public/vendor/ace/ace.js"></script>
<script src="{{url("/")}}/public{{ mix('js/blockui-vendor.js') }}" defer></script>
<script src="{{url("/")}}/public{{ mix('js/blockui.js') }}" defer></script>

<!--page specific scripts-->
@yield('scripts')
<!--/page specific scripts-->

</body>
</html>
