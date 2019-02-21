@extends('core::layouts.backend')

@section("page_specific_footer")


    <script src="{{moduleAssetsUrl('collab', '/profile.js')}}"></script>
@endsection

@section('content')
    <div id="app">
    <div class="page">
        <div class="page-content container-fluid">

            <!--urls-->
            <input type="hidden" data-type="url" name="base" value="{{url("/")}}" />
            <input type="hidden" data-type="url" name="current" value="{{url()->current()}}" />
            <input type="hidden" data-type="url" name="profile"
                   value="{{\URL::route('core.backend.user.profile.data', [Request::segment(4)])}}" />
            <input type="hidden" data-type="url" name="profile_update"
                   value="{{\URL::route('core.backend.user.update')}}" />
            <input type="hidden" data-type="url" name="profile_activities"
                   value="{{\URL::route('core.backend.user.activities')}}" />
            <!--/urls-->

            <div class="row">
                <div class="col-xs-12 col-lg-3">
                    @include("core::layouts.partials.backend.extendable.profile_left")
                </div>
                <div class="col-xs-12 col-lg-9">
                    <!--panel-->
                    <div class="panel">
                        <div class="panel-body nav-tabs-animate nav-tabs-horizontal" data-plugin="tabs">

                            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-toggle="tab"
                                       href="#activities" aria-controls="activities"
                                       role="tab">Activities</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-toggle="tab"
                                       href="#account" aria-controls="activities"
                                       role="tab">Account</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <!--tab activities-->
                                <div class="tab-pane active animation-slide-top" id="activities" role="tabpanel">
                                    <ul class="list-group">


                                        <li v-for="activity in list_activities" class="list-group-item">
                                            <div class="media">
                                                <div v-if="activity.created_by" class="media-left">
                                                    <a class="avatar" href="javascript:void(0)">
                                                        <img class="img-fluid" v-bind:src="activity.created_by.thumbnail" alt="...">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h4 v-if="activity.created_by" class="media-heading">@{{ activity.created_by.name  }}
                                                        <span class="tag tag-default">@{{ activity.label  }}</span>
                                                    </h4>
                                                    <small>@{{ fromNow(activity.created_at) }}</small>
                                                    <div class="profile-brief">@{{ activity.title  }}</div>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                    <a class="btn btn-block btn-default profile-readMore"
                                       v-on:click="getProfileActivities($event)"
                                       href="javascript:void(0)" role="button">Show more</a>
                                </div>
                                <!--/tab activities-->


                                <!--tab account-->
                                <div class="tab-pane  animation-slide-top" id="account" role="tabpanel">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="example-wrap">
                                                <h4 class="example-title">Account Information</h4>
                                                <div class="example">
                                                    <form v-on:submit="updateProfile($event)" autocomplete="off">
                                                        <div class="row">
                                                            <div class="form-group col-xs-12 col-md-6">
                                                                <label class="form-control-label" >Name</label>
                                                                <input type="text" class="form-control"
                                                                       placeholder="Name" v-model="item.name" autocomplete="off">
                                                            </div>
                                                            <div class="form-group col-xs-12 col-md-6">
                                                                <label class="form-control-label" >Email</label>
                                                                <input type="text" class="form-control"
                                                                       placeholder="Email" v-model="item.email" autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="form-group col-xs-12 col-md-6">

                                                            <label class="form-control-label">Gender</label>
                                                            <div>

                                                                <!--male-->
                                                                <div v-if="item.gender == 'm'" class="radio-custom radio-default radio-inline">
                                                                    <input type="radio"
                                                                           name="gender"
                                                                           checked>
                                                                    <label>Male</label>
                                                                </div>

                                                                <div v-else class="radio-custom radio-default radio-inline">
                                                                    <input type="radio"
                                                                           v-on:click="changeGender('m')"
                                                                           name="gender">
                                                                    <label>Male</label>
                                                                </div>
                                                                <!--/male-->


                                                                <!--female-->
                                                                <div v-if="item.gender == 'f'" class="radio-custom radio-default radio-inline">
                                                                    <input type="radio"
                                                                           name="gender"
                                                                           checked>
                                                                    <label>Female</label>
                                                                </div>

                                                                <div v-else class="radio-custom radio-default radio-inline">
                                                                    <input type="radio"
                                                                           v-on:click="changeGender('f')"
                                                                           name="gender">
                                                                    <label>Female</label>
                                                                </div>
                                                                <!--/female-->

                                                                <!--other-->
                                                                <div v-if="item.gender == 'o'" class="radio-custom radio-default radio-inline">
                                                                    <input type="radio"
                                                                           name="gender"
                                                                           checked>
                                                                    <label>Other</label>
                                                                </div>

                                                                <div v-else class="radio-custom radio-default radio-inline">
                                                                    <input type="radio"
                                                                           v-on:click="changeGender('o')"
                                                                           name="gender">
                                                                    <label>Other</label>
                                                                </div>
                                                                <!--/other-->

                                                        </div>
                                                            </div>
                                                            <div class="form-group col-xs-12 col-md-6">
                                                                <label class="form-control-label" >Date of Birth</label>
                                                                <input type="text" class="form-control"
                                                                       placeholder="YYYY-MM-DD"
                                                                       maxlength="10"
                                                                       v-bind:value="formatDate(item.birth_date)"
                                                                       autocomplete="off">

                                                            </div>

                                                        </div>

                                                        <div class="row">
                                                            <div class="form-group col-xs-12 col-md-4">
                                                                <label class="form-control-label" >Country Code</label>
                                                                <input type="text" class="form-control"
                                                                       v-model="item.country_calling_code" autocomplete="off">
                                                            </div>
                                                            <div class="form-group col-xs-12 col-md-8">
                                                                <label class="form-control-label" >Mobile Number</label>
                                                                <input type="text" class="form-control"
                                                                       v-model="item.mobile" autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="form-group col-xs-12 col-md-12">
                                                                <label class="form-control-label" >New Password</label>
                                                                <input type="password" class="form-control"
                                                                       placeholder="Type new password if you want to update"
                                                                       v-model="password" autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <button type="submit" class="btn btn-primary">Update</button>

                                                    </form>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <!--/tab account-->

                            </div>
                        </div>
                    </div>
                    <!--/panel-->

                </div>
            </div>
        </div>
    </div>

    </div>
@endsection
