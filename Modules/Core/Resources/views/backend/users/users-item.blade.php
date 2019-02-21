@extends('core::layouts.backend')

@section("page_specific_head")

    <link rel="stylesheet" href="{{assetsCoreMmenu()}}/examples/css/pages/profile.css">

@endsection

@section("page_specific_footer")

    <script src="{{moduleAssetsUrl('core', '/users-item.js')}}"></script>

@endsection

@section('content')

    <!--page-->
    <div class="page">
        <input type="hidden" name="url_current" value="{{url()->current()}}">


            <div class="page-content container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-lg-3">
                        <!-- Page Widget -->
                        <div class="card card-shadow text-xs-center">
                            <div class="card-block">
                                <a class="avatar avatar-lg" href="javascript:void(0)">
                                    <img src="{{$data->avatar}}" >
                                </a>
                                <h4 class="profile-user">{{$data->item->name}}</h4>
                                <p class="profile-job">{{$data->item->email}}<br/>
                                    {{$data->item->mobile}}
                                </p>

                            </div>

                        </div>
                        <!-- End Page Widget -->
                    </div>
                    <div class="col-xs-12 col-lg-9">
                        <!-- Panel -->
                        <div class="panel">
                            <div class="panel-body nav-tabs-animate nav-tabs-horizontal" data-plugin="tabs">
                                <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                                    <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#activities" aria-controls="activities" role="tab" aria-expanded="true">Activities <span class="tag tag-pill tag-danger">5</span></a></li>
                                    <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#profile" aria-controls="profile" role="tab" aria-expanded="false">Profile</a></li>
                                    <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#messages" aria-controls="messages" role="tab" aria-expanded="false">Messages</a></li>
                                    <li class="nav-item dropdown" style="display: none;">
                                        <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" aria-expanded="false">Menu </a>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item" data-toggle="tab" href="#activities" aria-controls="activities" role="tab">Activities <span class="tag tag-pill tag-danger">5</span></a>
                                            <a class="dropdown-item" data-toggle="tab" href="#profile" aria-controls="profile" role="tab">Profile</a>
                                            <a class="dropdown-item" data-toggle="tab" href="#messages" aria-controls="messages" role="tab">Messages</a>
                                        </div>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane animation-slide-left active" id="activities" role="tabpanel" aria-expanded="true">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a class="avatar" href="javascript:void(0)">
                                                            <img class="img-fluid" src="../../../global/portraits/2.jpg" alt="...">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading">Ida Fleming
                                                            <span>posted an updated</span>
                                                        </h4>
                                                        <small>active 14 minutes ago</small>
                                                        <div class="profile-brief">“Check if it can be corrected with overflow : hidden”</div>
                                                    </div>
                                                </div>
                                            </li>

                                        </ul>
                                        <a class="btn btn-block btn-default profile-readMore" href="javascript:void(0)" role="button">Show more</a>
                                    </div>
                                    <div class="tab-pane animation-slide-left" id="profile" role="tabpanel" aria-expanded="false">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="media media-lg">
                                                    <div class="media-left">
                                                        <a class="avatar" href="javascript:void(0)">
                                                            <img class="img-fluid" src="../../../global/portraits/5.jpg" alt="...">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading">Terrance Arnold
                                                            <span>posted a new blog</span>
                                                        </h4>
                                                        <small>active 14 minutes ago</small>
                                                        <div class="profile-brief">
                                                            <div class="media">
                                                                <a class="media-left">
                                                                    <img class="media-object" src="../../../global/photos/placeholder.png" alt="...">
                                                                </a>
                                                                <div class="media-body p-l-20">
                                                                    <h4 class="media-heading">Getting Started</h4>
                                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                        elit. Integer nec odio. Praesent libero. Sed
                                                                        cursus ante dapibus diam. Sed nisi. Nulla quis
                                                                        sem at nibh elementum imperdiet. Duis sagittis
                                                                        ipsum. Praesent mauris.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a class="avatar" href="javascript:void(0)">
                                                            <img class="img-fluid" src="../../../global/portraits/2.jpg" alt="...">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading">Ida Fleming
                                                            <span>posted an updated</span>
                                                        </h4>
                                                        <small>active 14 minutes ago</small>
                                                        <div class="profile-brief">“Check if it can be corrected with overflow : hidden”</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a class="avatar" href="javascript:void(0)">
                                                            <img class="img-fluid" src="../../../global/portraits/4.jpg" alt="...">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading">Owen Hunt
                                                            <span>posted a new note</span>
                                                        </h4>
                                                        <small>active 14 minutes ago</small>
                                                        <div class="profile-brief">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            Integer nec odio. Praesent libero. Sed cursus ante
                                                            dapibus diam. Sed nisi. Nulla quis sem at nibh elementum
                                                            imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce
                                                            nec tellus sed augue semper porta. Mauris massa.</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a class="avatar" href="javascript:void(0)">
                                                            <img class="img-fluid" src="../../../global/portraits/2.jpg" alt="...">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading">Ida Fleming
                                                            <span>posted an new activity comment</span>
                                                        </h4>
                                                        <small>active 14 minutes ago</small>
                                                        <div class="profile-brief">Cras sit amet nibh libero, in gravida nulla. Nulla vel
                                                            metus.</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a class="avatar" href="javascript:void(0)">
                                                            <img class="img-fluid" src="../../../global/portraits/3.jpg" alt="...">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading">Julius
                                                            <span>uploaded 4 photos</span>
                                                        </h4>
                                                        <small>active 14 minutes ago</small>
                                                        <div class="profile-brief">
                                                            <img class="profile-uploaded" src="../../../global/photos/placeholder.png" alt="...">
                                                            <img class="profile-uploaded" src="../../../global/photos/placeholder.png" alt="...">
                                                            <img class="profile-uploaded" src="../../../global/photos/placeholder.png" alt="...">
                                                            <img class="profile-uploaded" src="../../../global/photos/placeholder.png" alt="...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane animation-slide-left" id="messages" role="tabpanel" aria-expanded="false">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a class="avatar" href="javascript:void(0)">
                                                            <img class="img-fluid" src="../../../global/portraits/2.jpg" alt="...">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading">Ida Fleming
                                                            <span>posted an updated</span>
                                                        </h4>
                                                        <small>active 14 minutes ago</small>
                                                        <div class="profile-brief">“Check if it can be corrected with overflow : hidden”</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="media media-lg">
                                                    <div class="media-left">
                                                        <a class="avatar" href="javascript:void(0)">
                                                            <img class="img-fluid" src="../../../global/portraits/5.jpg" alt="...">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading">Terrance Arnold
                                                            <span>posted a new blog</span>
                                                        </h4>
                                                        <small>active 14 minutes ago</small>
                                                        <div class="profile-brief">
                                                            <div class="media">
                                                                <a class="media-left">
                                                                    <img class="media-object" src="../../../global/photos/placeholder.png" alt="...">
                                                                </a>
                                                                <div class="media-body p-l-20">
                                                                    <h4 class="media-heading">Getting Started</h4>
                                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                        elit. Integer nec odio. Praesent libero. Sed
                                                                        cursus ante dapibus diam. Sed nisi. Nulla quis
                                                                        sem at nibh elementum imperdiet. Duis sagittis
                                                                        ipsum. Praesent mauris.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a class="avatar" href="javascript:void(0)">
                                                            <img class="img-fluid" src="../../../global/portraits/4.jpg" alt="...">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading">Owen Hunt
                                                            <span>posted a new note</span>
                                                        </h4>
                                                        <small>active 14 minutes ago</small>
                                                        <div class="profile-brief">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            Integer nec odio. Praesent libero. Sed cursus ante
                                                            dapibus diam. Sed nisi. Nulla quis sem at nibh elementum
                                                            imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce
                                                            nec tellus sed augue semper porta. Mauris massa.</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a class="avatar" href="javascript:void(0)">
                                                            <img class="img-fluid" src="../../../global/portraits/3.jpg" alt="...">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading">Julius
                                                            <span>posted an updated</span>
                                                        </h4>
                                                        <small>active 14 minutes ago</small>
                                                        <div class="profile-brief">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            Integer nec odio. Praesent libero. Sed cursus ante
                                                            dapibus diam.</div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Panel -->
                    </div>
                </div>
            </div>




    </div>
    <!--/page-->
@endsection


