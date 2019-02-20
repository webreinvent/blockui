<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')

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
    <script src="/public/vendor/nprogress/nprogress.js" defer></script>
    <script src="/public/vendor/alertify/alertify.js" defer></script>
    <script src="{{ mix('public/js/app.js') }}" defer></script>


    <!--page specific scripts-->
    @yield('scripts')
    <!--/page specific scripts-->

</body>
</html>
