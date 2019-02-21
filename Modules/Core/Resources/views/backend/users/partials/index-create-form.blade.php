<!-- Modal -->
<div class="modal fade" id="ModalFormCreate" aria-hidden="false" role="dialog"
     tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="post"
              autocomplete="off"
              action="{{\URL::route("core.backend.users.store")}}">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true" class="icon wb-close"></span>
                </button>
                <h4 class="modal-title">Create New User</h4>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-xs-12 col-md-6  form-group">
                        <input type="text" class="form-control" name="name"
                               placeholder="Name">
                    </div>

                    <div class="col-xs-12 col-md-6 form-group">
                        <input type="email" class="form-control" name="email"
                               placeholder="Email">
                    </div>

                    <div class="col-xs-12 col-md-6 form-group">

                        <div class="col-xs-2 col-md-4 p-0">
                        <input type="text" class="form-control col-xs-2" name="country_calling_code"
                               maxlength="4"
                                value="+91"
                               placeholder="Country Calling Code">
                        </div>

                        <div class="col-xs-10 col-md-8 p-r-0">
                        <input type="text" class="form-control" name="mobile"
                               data-plugin="formatter"
                               data-pattern="[[999]]-[[999]]-[[9999]]"
                               placeholder="Mobile">
                        </div>
                    </div>

                    <br clear="all"/>

                    <div class="col-xs-12 col-md-6 form-group">
                        <input type="text" class="form-control" name="username"
                               onfocus="this.removeAttribute('readonly');" readonly
                               placeholder="Username">
                    </div>

                    <div class="col-xs-12 col-md-6 form-group">
                        <input type="password" class="form-control" name="password"
                               onfocus="this.removeAttribute('readonly');" readonly
                               placeholder="Password">
                    </div>

                    <div class="col-xs-12 col-md-6 col-xl-12 form-group">
                        <div class="radio-custom radio-primary radio-inline">
                            <input type="radio" name="gender" value="m">
                            <label>Male</label>
                        </div>

                        <div class="radio-custom radio-primary radio-inline">
                            <input type="radio" name="gender" value="f">
                            <label>Female</label>
                        </div>

                        <div class="radio-custom radio-primary radio-inline">
                            <input type="radio" name="gender" value="o">
                            <label>Other</label>
                        </div>

                    </div>


                    <div class="col-xs-12 col-md-4 col-xl-4 form-group">
                        <input type="text" class="form-control" name="birth_date"
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
                            <option value="{{$role->id}}">{{$role->name}}</option>
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
            </div>
            {{ csrf_field() }}
        </form>
    </div>
</div>
<!-- End Modal -->
