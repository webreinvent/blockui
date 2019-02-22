@extends('layouts.app')

@section('scripts')
    <script src="{{url("/")}}/public{{ mix('js/welcome.js') }}" defer></script>
@endsection


@section('content')

<master></master>


@endsection