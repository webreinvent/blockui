@extends('core::layouts.backend')

@section("page_specific_head")
    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/bootstrap-select/bootstrap-select.css">
    <link rel="stylesheet" href="{{assetsCoreMmenu()}}/examples/css/forms/masks.css">
@endsection

@section("page_specific_footer")
    <script src="{{assetsCoreGlobalVendor()}}/formatter/jquery.formatter.js"></script>
    <script src="{{assetsCoreGlobalVendor()}}/bootstrap-select/bootstrap-select.js"></script>


    <script src="{{assetsCoreGlobal()}}/js/Plugin/formatter.js"></script>
    <script src="{{assetsCoreGlobal()}}/js/Plugin/bootstrap-select.js"></script>

    <script src="{{moduleAssetsUrl('core', '/users-edit.js')}}"></script>

@endsection

@section('content')

    <!--page-->
    <div class="page">
        <input type="hidden" name="url_current" value="{{url()->current()}}">

        <div class="page-header">
            <h1 class="page-title">Edit User - {{$data->item->name}}</h1>
        </div>

        <div class="page-content">

            <!--content-->
            <div class="panel">
                <div class="panel-body">
                    <form  method="post" autocomplete="off" class="UserEditForm"
                          action="{{\URL::route("core.backend.users.update", [$data->item->id])}}">

                            <div class="row">

                                <div class="col-xs-12 col-md-6  form-group">
                                    <input type="text" class="form-control" name="name"
                                           value="{{$data->item->name}}"
                                           placeholder="Name">
                                </div>

                                <div class="col-xs-12 col-md-6 form-group">
                                    <input type="email" class="form-control" name="email"
                                           value="{{$data->item->email}}"
                                           placeholder="Email">
                                </div>

                                <div class="col-xs-12 col-md-6 form-group">

                                    <div class="col-xs-2 col-md-4 p-0">
                                        <input type="text" class="form-control col-xs-2"
                                               name="country_calling_code"
                                               value="{{$data->item->country_calling_code}}"
                                               maxlength="4"
                                               value="+91"
                                               placeholder="Country Calling Code">
                                    </div>

                                    <div class="col-xs-10 col-md-8 p-r-0">
                                        <input type="text" class="form-control" name="mobile"
                                               value="{{$data->item->mobile}}"
                                               data-plugin="formatter"
                                               data-pattern="[[999]]-[[999]]-[[9999]]"
                                               placeholder="Mobile">
                                    </div>
                                </div>

                                <br clear="all"/>

                                <div class="col-xs-12 col-md-6 form-group">
                                    <input type="text" class="form-control" name="username"
                                           value="{{$data->item->username}}"
                                           onfocus="this.removeAttribute('readonly');" readonly
                                           placeholder="Username">
                                </div>

                                <div class="col-xs-12 col-md-6 form-group">
                                    <input type="password" class="form-control" name="password"
                                           onfocus="this.removeAttribute('readonly');" readonly
                                           placeholder="New Password">
                                </div>

                                <div class="col-xs-12 col-md-6 col-xl-12 form-group">


                                    <?php
                                    $gender['Male'] = 'm';
                                    $gender['Female'] = 'f';
                                    $gender['Other'] = 'o';
                                    ?>

                                    @foreach($gender as $key => $value)

                                        @if($value == $data->item->gender)
                                        <div class="radio-custom radio-primary radio-inline">
                                            <input type="radio" name="gender"
                                                   checked
                                                   value="{{$value}}">
                                            <label>{{$key}}</label>
                                        </div>
                                            @else
                                                <div class="radio-custom radio-primary radio-inline">
                                                    <input type="radio" name="gender"
                                                           value="{{$value}}">
                                                    <label>{{$key}}</label>
                                                </div>
                                            @endif
                                        @endforeach



                                </div>


                                <div class="col-xs-12 col-md-4 col-xl-4 form-group">
                                    <input type="text" class="form-control" name="birth_date"
                                           value="{{$data->item->birth_date}}"
                                           data-plugin="formatter"
                                           data-pattern="[[9999]]-[[99]]-[[99]]"
                                           placeholder="Birth Date">
                                    <p class="text-help">YYYY-MM-DD Eg. 1986-12-31</p>
                                </div>

                                <div class="col-xs-12 col-xl-6 form-group">
                                    <select multiple data-plugin="selectpicker"
                                            name="roles[]"
                                            data-live-search="true">
                                        @if($data->roles)
                                            @foreach($data->roles as $role)
                                                @if(in_array($role->id, $data->itemRoles))
                                                <option selected value="{{$role->id}}">{{$role->name}}</option>
                                                @else
                                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                                    @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>


                                <div class="col-xs-12 col-xl-12 form-group">
                                    <div class="radio-custom radio-success radio-inline">
                                        <input type="radio" name="enable" checked value="1">
                                        <label>Enable</label>
                                    </div>
                                    <div class="radio-custom radio-danger radio-inline">
                                        <input type="radio" name="enable" value="0">
                                        <label>Disable</label>
                                    </div>
                                </div>


                                <div class="col-xs-12 col-xl-12 form-group">
                                    <div class="checkbox-custom checkbox-success">
                                        <input type="checkbox" name="send_activation_email"
                                               id="send_activation_email"
                                               value="1">
                                        <label for="send_activation_email">Send Activation Code</label>
                                    </div>
                                    <div class="checkbox-custom checkbox-success">
                                        <input type="checkbox" name="send_welcome_email"
                                               id="send_welcome_email"
                                               value="1">
                                        <label for="send_welcome_email">Send Welcome Email with Password</label>
                                    </div>
                                </div>


                                <div class="col-xs-12 col-md-12 pull-xs-right">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>
                            </div>

                        {{ csrf_field() }}
                    </form>


                </div>
            </div>
            <!--/content-->
        </div>
    </div>
    <!--/page-->
@endsection


