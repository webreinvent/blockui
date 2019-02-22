@extends("layouts.app")

@section('head')

@endsection


@section('scripts')

@endsection

@section('content')


    <div class="container">


        <div class="row">

            <div class="col-md-3">

                <left :searched="searched" @typed="getTypedInput"  ></left>

            </div>
            <div class="col-md-9">

                <h1>@{{ searched }}</h1>

                <router-view></router-view>

            </div>


        </div>

    </div>




@endsection
