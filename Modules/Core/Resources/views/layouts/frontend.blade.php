<!DOCTYPE html>
<html lang="en">
@include("core::layouts.partials.frontend.head")
<body class="@if(isset($data->body_class)){{$data->body_class}}@endif" >
<!---content-->
@yield('content')
<!--/content-->
@include("core::layouts.partials.frontend.footer")
@include("core::layouts.partials.frontend.scripts")
<!---page specific-->
@yield('page_specific_footer')
<!--/page specific-->

<script>
    (function(document, window, $) {
        'use strict';
        var Site = window.Site;
        $(document).ready(function() {
            Site.run();
        });
    })(document, window, jQuery);
</script>

</body>
</html>
