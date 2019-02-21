@extends('core::layouts.backend')

@section("page_specific_head")
@endsection

@section("page_specific_footer")
    <script src="{{moduleAssetsUrl('core', '/roles.js')}}"></script>
@endsection

@section('content')

    <div class="page">
        <input type="hidden" name="url_current" value="{{url()->current()}}">
        <input type="hidden" name="page" value="1">
        <input type="hidden" name="trashed" value="0">


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
                                        Actions
                                        <span class="icon wb-chevron-down-mini" aria-hidden="true"></span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item bulkEnable" href="javascript:void(0)">Enable</a>
                                        <a class="dropdown-item bulkDisable" href="javascript:void(0)">Disable</a>
                                        <a class="dropdown-item bulkDelete" href="javascript:void(0)">Delete</a>
                                        <a class="dropdown-item bulkRestore" href="javascript:void(0)">Restore</a>
                                        <a class="dropdown-item bulkDeletePermanent" href="javascript:void(0)">Permanent
                                            Delete</a>
                                    </div>
                                </div>
                            </div>
                            <div class="pull-xs-right m-l-10">
                                <!-- Modal -->
                                <div class="modal fade" id="ModalFormCreate" aria-hidden="false"
                                     role="dialog"
                                     tabindex="-1">
                                    <div class="modal-dialog">
                                        <form class="modal-content" method="post"
                                              action="{{\URL::route('core.backend.roles.store')}}">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true" class="icon wb-close"></span>
                                                </button>
                                                <h4 class="modal-title">Create New Role</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-xs-12 col-xl-4 form-group">
                                                        <input type="text" class="form-control" name="name"
                                                               placeholder="Role Name">
                                                    </div>
                                                    <div class="col-xs-12 col-xl-12 form-group">
                                                        <textarea class="form-control" name="details"
                                                                  rows="5" placeholder="Details"></textarea>
                                                    </div>
                                                    <div class="col-xs-12 col-xl-12 form-group">
                                                        <div class="radio-custom radio-success radio-inline">
                                                            <input type="radio" name="enable" checked value="1">
                                                            <label>Yes</label>
                                                        </div>
                                                        <div class="radio-custom radio-danger radio-inline">
                                                            <input type="radio" name="enable" value="0">
                                                            <label>No</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-md-12 pull-xs-right">
                                                        <button class="btn btn-primary" type="submit">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- End Modal -->
                                <div class="btn-group" aria-label="Button group with nested dropdown" role="group">
                                    <button type="button" class="btn btn-outline btn-default"
                                            data-target="#ModalFormCreate" data-toggle="modal">
                                        <i class="icon wb-plus" aria-hidden="true"></i>
                                    </button>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline btn-default" id="showTrashed">
                                            <i class="icon wb-check showTrashedChecked" style="display: none;"></i>
                                            Trashed
                                        </button>
                                        <input type="hidden" name="trashed" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="pull-xs-right ">
                                <div class="form-group">
                                    <div class="input-search">
                                        <button type="submit" class="input-search-btn">
                                            <i class="icon wb-search" aria-hidden="true"></i>
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
        <!--/content-->
    </div>
@endsection


