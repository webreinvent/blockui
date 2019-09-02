@extends('core::layouts.backend')

@section("page_specific_head")
@endsection

@section("page_specific_footer")
    <script src="{{moduleAssetsUrl('core', '/rolesItem.js')}}"></script>
@endsection

@section('content')

    <div class="page">
        <input type="hidden" name="url_current" value="{{url()->current()}}">
        <input type="hidden" name="url_item_permissions" value="{{route("core.backend.roles.permissions", $data->item->id)}}">
        <!--header-->
        <div class="page-header">
            <h1 class="page-title">{{$data->item->name}}</h1>

            <div class="page-header-actions">
                <a class="btn btn-sm btn-inverse btn-round" href="{{route('core.backend.roles')}}">
                    <i class="icon wb-arrow-left" aria-hidden="true"></i>
                    <span class="hidden-sm-down">Back</span>
                </a>
            </div>
        </div>
        <!--header-->
        <!--content-->


        <div class="page-content container-fluid">
            <!--role details-->


                <div class="col-xxl-4 col-lg-6 col-xs-12">
                    <div class="widgetScore card card-shadow p-b-20">
                        <div class="card-block">
                                <div class="card-actions">
                                <a href="{{route("core.backend.roles.stats",
                                            [$data->item->id])}}"
                                   class="icon wb-reload pk-item-stats pk-action-reload"
                                   data-target="#stats"
                                   aria-hidden="true"></a>
                            </div>
                            <div class="row text-xs-center m-b-20" id="stats">

                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"></h3>
                            <div class="panel-actions panel-actions-keep">
                                <a class="panel-action icon wb-pencil pk-form-edit"
                                   data-target="#item-edit-form"
                                   aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive item">



                            </div>
                        </div>
                    </div>

                </div>

            <!--/role details-->

            <!--permissions-->
            <div class="col-xxl-3 col-lg-6 col-xs-12">
                <!-- Panel Watchlist -->
                <div class="card card-shadow widgetTable">
                    <div class="card-block p-30">
                        <h3 class="card-title">
                            <span class="text-truncate">Permissions</span>
                            <div class="card-header-actions">
                                {{--<span class="red-600 font-size-24">$ 102,967</span>--}}
                            </div>
                        </h3>
                        <form class="m-t-25" action="#" role="search">
                            <div class="input-search input-search-dark">
                                <i class="input-search-icon wb-search" aria-hidden="true"></i>
                                <input type="text" class="form-control"
                                       id="permission-search"
                                       placeholder="Search..">
                            </div>
                        </form>
                    </div>
                    <div class="h-300 scrollable is-enabled scrollable-vertical" data-plugin="scrollable"
                         style="position: relative;">
                        <div data-role="container" class="scrollable-container">
                            <div data-role="content" class="scrollable-content">
                                <div id="permissions-list">

                                </div>
                            </div>
                        </div>
                        <div class="scrollable-bar scrollable-bar-vertical is-disabled scrollable-bar-hide"
                             draggable="false">
                            <div class="scrollable-bar-handle"></div>
                        </div>
                    </div>
                </div>
                <!-- End Panel Watchlist -->
            </div>
            <!--/permissions-->



        </div>
        <!--/content-->

    </div>
@endsection


