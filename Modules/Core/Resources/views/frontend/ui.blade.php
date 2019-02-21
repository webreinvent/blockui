<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>@if(isset($data->title)){{$data->title}}@else{{Config::get('core.name')}} v{{Config::get('core.version')}}@endif</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{assetsCoreGlobal()}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{assetsCoreGlobal()}}/css/bootstrap-extend.min.css">
    <link rel="stylesheet" href="{{assetsCoreMmenu()}}/css/site.min.css">

    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/slidepanel/slidePanel.css">
    <link rel="stylesheet" href="{{asset("assets/core/css/asScrollable.css")}}">

    <style type="text/css">

        .simple {
            height: 200px;
            max-height: 200px;
        }
    </style>

@yield('page_specific_head')
<!--/page specific-->
</head>

<body class="@if(isset($data->body_class)){{$data->body_class}}@endif" >
<!---content-->


<hr/>
<a href="{{URL::route("core.frontend.test")}}" class="example" data-direction="right">Trigger</a>
<hr/>


<div class="simple example">
    <div>
        <div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam malesuada at metus eget sodales. Aenean tincidunt mi sed orci sollicitudin placerat. Nullam tempus nisl augue, sed pulvinar eros lacinia vitae. Mauris vehicula velit a nibh dapibus vehicula. Fusce dui tellus, tincidunt sit amet porttitor efficitur, aliquam ac arcu. Cras non tempor dui. Nunc a dolor sit amet dolor bibendum auctor a eu ipsum.</p>
            <p>Pellentesque lobortis facilisis risus, sit amet maximus turpis venenatis vitae. Donec nec eros iaculis, congue risus at, tempus augue. Donec quis felis vel purus pretium tincidunt. Integer sodales ultricies tristique. Phasellus et risus sagittis, dictum tortor a, semper lorem. Vivamus quis ipsum velit. Nam molestie ut ipsum ultricies volutpat. Integer molestie sagittis tempor. Integer vitae mauris est. Ut laoreet dignissim tellus, non accumsan erat gravida vel. Curabitur non erat id velit aliquam malesuada. Proin aliquet cursus orci quis pulvinar.</p>
            <p>Duis elit massa, scelerisque sed nisl sed, tempus iaculis felis. Duis accumsan eget justo id auctor. Aliquam consequat odio non dolor efficitur, hendrerit porttitor neque porttitor. Integer varius maximus nunc, at malesuada leo tristique id. Sed aliquet pharetra ipsum, non interdum lacus dictum sit amet. Curabitur semper imperdiet sem eget interdum. Nunc at egestas tellus, vel tincidunt lacus. Fusce eget neque vel leo volutpat tincidunt ac non enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vivamus cursus leo in felis viverra interdum.</p>
            <p>Mauris id ultricies magna. Quisque rutrum lobortis elit blandit rutrum. Curabitur mattis enim lorem, eget tempor nunc pretium dignissim. Cras tincidunt ac nisl eget finibus. Fusce lobortis turpis sed dui mollis, eget fringilla risus porttitor. In id neque vitae lorem pharetra sodales. Morbi neque ex, mattis at dolor quis, consequat tincidunt leo. Vivamus sagittis placerat sem at porta.</p>
            <p>Proin varius arcu ac ligula suscipit, sit amet pretium lectus tincidunt. Aliquam eu mi imperdiet, efficitur tellus ac, mollis eros. Cras malesuada feugiat pharetra. Curabitur lectus lacus, bibendum sed odio at, egestas tempor nisl. Vivamus sagittis est porta velit pretium, in elementum arcu tempus. Ut id cursus libero, non ullamcorper velit. Cras pretium arcu lacus, nec dignissim elit accumsan vitae. Aliquam tristique lorem et tempus congue. Donec vel metus enim. Praesent sed turpis et magna suscipit tincidunt. Proin efficitur neque non sapien cursus vehicula. Suspendisse iaculis, neque vel convallis lobortis, mauris dui posuere mi, at maximus lorem tortor a metus. Ut in quam efficitur, finibus nulla et, feugiat orci.</p>
            <p>Sed mattis volutpat enim eget porttitor. Sed lectus ligula, condimentum nec elit eget, vehicula porttitor nunc. Curabitur pulvinar leo velit, a convallis tellus suscipit ac. Donec tempor est ut sagittis varius. Mauris maximus nunc metus, non venenatis justo ornare vel. Phasellus iaculis erat sit amet enim fermentum mattis. Cras sollicitudin tortor dolor, ac aliquam dolor iaculis non. Donec sed sodales enim. Suspendisse potenti. Integer quis turpis cursus enim consectetur fringilla eu eu ante.</p>
        </div>
    </div>
</div>

<!--/content-->

<!--scripts-->

<!-- Core Required  -->
<script src="{{assetsCoreGlobalVendor()}}/babel-external-helpers/babel-external-helpers.js"></script>
<script src="{{assetsCoreGlobalVendor()}}/jquery/jquery.js"></script>
<script src="{{assetsCoreGlobalVendor()}}/tether/tether.js"></script>
<script src="{{assetsCoreGlobalVendor()}}/bootstrap/bootstrap.js"></script>

<!-- Core  -->
<script src="{{assetsCoreGlobalVendor()}}/asscrollbar/jquery-asScrollbar.js"></script>
<script src="{{assetsCoreGlobalVendor()}}/asscrollable/jquery-asScrollable.js"></script>
<link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/animsition/animsition.css">





<!-- Plugins -->
<script src="{{assetsCoreGlobalVendor()}}/slidepanel/jquery-slidePanel.js"></script>





<!--Scripts-->
<script src="{{assetsCoreGlobal()}}/js/State.js"></script>
<script src="{{assetsCoreGlobal()}}/js/Component.js"></script>
<script src="{{assetsCoreGlobal()}}/js/Plugin.js"></script>
<script src="{{assetsCoreGlobal()}}/js/Base.js"></script>
<script src="{{assetsCoreGlobal()}}/js/Config.js"></script>
<script src="{{assetsCoreMmenu()}}/js/Section/Menubar.js"></script>
<script src="{{assetsCoreMmenu()}}/js/Section/Sidebar.js"></script>
<script src="{{assetsCoreMmenu()}}/js/Section/PageAside.js"></script>
<script>
    Config.set('assets', '{{assetsCoreMmenu()}}');
</script>

<!-- Page -->
<script src="{{assetsCoreMmenu()}}/js/Site.js"></script>
<script src="{{assetsCoreGlobal()}}/js/Plugin/asscrollable.js"></script>
<script src="{{assetsCoreGlobal()}}/js/Plugin/slidepanel.js"></script>


<script>
    jQuery(function($) {
        $('.simple').asScrollable({
            contentSelector: ">",
            containerSelector: ">"
        });
    });

    $(document).on('slidePanel::afterLoad', function (e) {
        $('.simple').asScrollable({
            contentSelector: ">",
            containerSelector: ">"
        });
    });

    jQuery(function($) {
        $('.example').slidePanel();
    });

</script>

</body>
</html>
