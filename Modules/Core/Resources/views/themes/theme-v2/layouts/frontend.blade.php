<!DOCTYPE html>
<html lang="en">

@include("core::themes.theme-v2.layouts.partials.frontend.head")

<body class="@if(isset($data->body_class)){{$data->body_class}}@endif" >

@include("core::themes.theme-v2.layouts.partials.frontend.flash")
@include("core::themes.theme-v2.layouts.partials.frontend.header")

<!---content-->
@yield('content')
<!--/content-->

<!--footer-->
@include("core::themes.theme-v2.layouts.partials.frontend.footer")
<!--/footer-->

<!--common scripts-->
@include("core::themes.theme-v2.layouts.partials.frontend.script")
<!--/common scripts-->

<!---page specific-->
@yield('page_specific_footer')
<!--/page specific-->

</body>
</html>
