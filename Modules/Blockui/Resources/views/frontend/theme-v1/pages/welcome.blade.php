@extends("blockui::frontend.theme-v1.layouts.public")

@section('head')

    <style>

        iframe {
            width: 100%;
            height: 100%;
            background: #ccc ;
            border: 1px solid #ccc;
            padding: 2px;
            z-index: 1;
        }
    </style>

    <style type="text/css" media="screen">
        #editor {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }
    </style>

@endsection


@section('scripts')

@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <h4 class="text-center">Independent, Reusable & BEM (Block Element Modifier) based UI Blocks/Components Snippets</h4>

                <hr/>

            </div>
        </div>
    </div>


    <div class="container">


            <router-view @on-click="appOnClick"></router-view>


    </div>




@endsection
