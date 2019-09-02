@extends('core::layouts.backend')

@section("page_specific_head")

@endsection

@section("page_specific_footer")
    <script src="{{moduleAssetsUrl('core', '/permissions.js')}}"></script>
@endsection

@section('content')


    <div class="page">
        <!--header-->
        <div class="page-header">
            <input type="hidden" name="url_current" value="{{url()->current()}}">
            <input type="hidden" name="page" value="1">
        </div>
        <!--header-->
        <!--content-->
        <div id="exampleTransition"
             class="page-content container-fluid"
             data-plugin="animateList">
            <ul class="blocks-sm-100 blocks-md-12 blocks-lg-12 blocks-xxl-3">
                <li>
                    <div class="panel panel-bordered animation-scale-up"
                         style="animation-fill-mode: backwards; animation-duration: 250ms; animation-delay: 0ms;">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{$data->title}}</h3>
                            <div class="panel-actions">
                                <nav>
                                    <ul class="pagination_con pagination pagination-md">
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="pull-xs-left">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-pure" data-toggle="dropdown"
                                            aria-expanded="false">
                                        More
                                        <span class="icon wb-chevron-down-mini" aria-hidden="true"></span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item bulkEnable" href="javascript:void(0)">Enable</a>
                                        <a class="dropdown-item bulkDisable" href="javascript:void(0)">Disable</a>
                                    </div>
                                </div>
                            </div>

                            <div class="pull-xs-right ">
                                <div class="form-group">
                                    <div class="input-search">
                                        <button type="submit" class="input-search-btn"><i class="icon wb-search"
                                                                                          aria-hidden="true"></i>
                                        </button>
                                        <input type="text" class="form-control search" name="" placeholder="Search...">
                                    </div>
                                </div>
                            </div>

                            <div id="list">
                            </div>

                        </div>
                    </div>
                </li>
            </ul>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="SidebarModal" aria-hidden="true"
             role="dialog" tabindex="-1">
            <div class="modal-dialog modal-sidebar">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>

                    </div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->

        <!--/content-->
    </div>
@endsection


