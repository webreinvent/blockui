<!DOCTYPE html>
<html lang="en">
@include("core::layouts.partials.backend.head")
<body class="@if(isset($data->body_class)){{$data->body_class}}@endif animsition site-navbar-small">
@include("core::layouts.partials.backend.header")

<!--side navigation-->
@include("core::layouts.partials.backend.extendable.sidebar")
@include("core::layouts.partials.backend.extendable.grid_menu")
<!--/side navigation-->

<!--flash-->
<div class="flash_box">

@include("core::layouts.partials.backend.flash")
@include("core::layouts.partials.backend.errors")

</div>
<!--/flash-->

<!---content-->
@yield('content')
<!--/content-->

@include("core::layouts.partials.backend.footer")
@include("core::layouts.partials.backend.scripts")

<!---page specific-->
@yield('page_specific_footer')
<!--/page specific-->

<!---page specific script-->
@yield('page_specific_script')
<!--/page specific script-->

<!-- Page -->
<script>
    (function (document, window, $) {
        'use strict';
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        var Site = window.Site;
        $(document).ready(function () {
            Site.run();
        });
    })(document, window, jQuery);
</script>
<!--/common js-->

</body>
</html>
