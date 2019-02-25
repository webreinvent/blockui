@extends("blockui::frontend.theme-v1.layouts.public")

@section('head')

    <style>

        iframe {
            width: 100%;
            height: 100%;
            border: none;

            background: #eee ;


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


    <div class="container">

        <div class="row">
            <div class="col-md-12">

                <h1>BlockUI.io</h1>
                <p>Independent, Reusable & BEM (Block Element Modifier) based UI Blocks/Components Snippets</p>

                <hr/>

            </div>
        </div>

        <div class="row">

            <div class="col-md-3">

                <left :searched="searched" @typed="getTypedInput"  ></left>

            </div>
            <div class="col-md-9">

                <router-view @on-click="appOnClick"></router-view>


            </div>


        </div>

    </div>




@endsection
