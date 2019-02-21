@extends('core::themes.theme-v2.layouts.frontend')

@section('page_specific_head')
    <link rel="stylesheet" href="{{themeAssetsUrl('css/page-login.css')}}">
@endsection

@section('page_specific_footer')

@endsection

@section('content')
<!--app-->
<div id="app">













    <?php

        $classes = ["default", "primary", "success", "info", "warning", "danger", "link"];


    ?>


    <div class="container-fluid">

        <div class="row">

            <div class="col-sm-12">
                <h1 class="text-center">UI Elements</h1>
                <hr/>
            </div>

            <!--left-->
            <div class="col-sm-2" style=" width: 100%; height: 500px; overflow: auto; ">

                <?php

                    $elements = [
                        'nav', 'nav-bar', 'alert', 'cards', 'list',
                        'panel', 'search', 'forms', 'voting-rating', 'buttons',
                        'carousel', 'comments', 'errors', 'media', 'modal',
                        'gallery', 'timeline', 'cart', 'counter', 'notification',
                        'steps', 'tab', 'testimonials', 'validation', 'progress',
                        'table', 'chat', 'faq', 'headers', 'price-table',
                        'tabs', 'calender', 'dropdown', 'icons', 'tooltip',
                        'popover', 'accordions', 'images', 'badges', 'typography',
                        'tour', 'animations', 'lightbox', 'scrollable', 'alerts',
                        'masonry', 'context-menu', 'tree-view', 'toastr', 'sortable',
                        'nestable', 'bootbox', 'overlay', 'pagination', 'breadcrum',
                        'loader', 'auto-complete',
                    ];

                sort($elements);

                ?>

                <ul class="nav flex-column" >


                    @foreach($elements as $index => $element)
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{url()->current()}}?element={{$element}}">{{$index}}) {{$element}}</a>
                    </li>
                    @endforeach

                </ul>

            </div>
            <!--/left-->


            <!--right-->
            <div class="col-sm-8">

                {!! $data->element !!}


            </div>
            <!--/right-->

        </div>

    </div>


</div>
<!--/app-->






@endsection
