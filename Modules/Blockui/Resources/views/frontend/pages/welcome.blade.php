@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-3">

                <bui-nav></bui-nav>

            </div>



            <div class="col-md-12">
                <h1>BlockUI</h1>
                <p>Modular & BEM based UI Component Blocks</p>


                <example-component></example-component>
                <bui-manage></bui-manage>



            </div>
        </div>
    </div>
@endsection