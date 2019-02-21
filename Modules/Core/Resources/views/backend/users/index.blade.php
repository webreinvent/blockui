@extends('core::layouts.backend')

@section("page_specific_head")
    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/bootstrap-select/bootstrap-select.css">
    <link rel="stylesheet" href="{{assetsCoreMmenu()}}/examples/css/forms/masks.css">
@endsection

@section("page_specific_footer")
    <script src="{{assetsCoreGlobalVendor()}}/formatter/jquery.formatter.js"></script>
    <script src="{{assetsCoreGlobalVendor()}}/bootstrap-select/bootstrap-select.js"></script>


    <script src="{{assetsCoreGlobal()}}/js/Plugin/formatter.js"></script>
    <script src="{{assetsCoreGlobal()}}/js/Plugin/bootstrap-select.js"></script>

    <script src="{{moduleAssetsUrl('core', '/users.js')}}"></script>


@endsection

@section('content')

    <!--page-->
    <div class="page">
        <input type="hidden" name="url_current" value="{{url()->current()}}">
        <input type="hidden" name="page" value="1">
        <input type="hidden" name="trashed" value="0">
        <div class="page-content">
            <!--content-->


            <div class="panel">
                <div class="panel-body">
                    <!--search form-->
                    @include("core::backend.users.partials.index-search")
                    <!--search form-->

                    <!--create form-->
                    @include("core::backend.users.partials.index-create-form")
                    <!--/create form-->


                    <!--tabs-->
                    <div class="example-wrap m-lg-0">
                        <div class="nav-tabs-horizontal nav-tabs-animate" >
                            @include("core::backend.users.partials.index-short-by")

                            {{--@include("core::backend.users.partials.index-items")--}}

                            <div id="list">

                            </div>

                            <hr/>
                            <div id="paginate">

                            </div>

                        </div>
                    </div>
                    <!--/tabs-->
                </div>
            </div>
            <!--/content-->
        </div>
    </div>
    <!--/page-->
@endsection


