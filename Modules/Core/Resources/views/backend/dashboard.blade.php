@extends('core::layouts.backend')


@section("page_specific_footer")

@endsection

@section('content')

    <div class="page">
        @include("core::layouts.partials.backend.extendable.dashboard")
    </div>
@endsection
