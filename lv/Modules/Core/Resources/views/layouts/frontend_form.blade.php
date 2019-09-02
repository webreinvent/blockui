@extends('core::layouts.frontend')

@section("page_specific_head")
    <link rel="stylesheet" href="{{assetsCoreMmenu()}}/examples/css/pages/login-v3.css">
@endsection


@section("content")

    <!-- Page -->
    <div class="page vertical-align text-xs-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
        <div class="page-content vertical-align-middle">
            <div class="panel">
                <div class="panel-body">
                    <div class="brand">
                        <img class="brand-img" src="{{moduleAssets('core')}}/images/wri-logo.png"
                             width="200"
                             alt="...">
                        <h2 class="brand-text font-size-18">{{Config::get('core.name')}} v{{Config::get('core.version')}}</h2>
                    </div>
                    @include("core::layouts.partials.frontend.flash")
                    @include("core::layouts.partials.frontend.errors")
                    @yield('form')
                </div>
            </div>
            <footer class="page-copyright page-copyright-inverse">
                <p>Application is licensed to <a href="https://www.webreinvent.com" class="white">WebReinvent</a> </p>
                <p>&copy; {{date("Y")}}. All RIGHT RESERVED.</p>
            </footer>
        </div>
    </div>
    <!-- End Page -->

@endsection
