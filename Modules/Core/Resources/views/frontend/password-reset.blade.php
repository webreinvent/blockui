
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reset Password</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />

</head>

<body>



<div class="container">

    @include("core::layouts.partials.frontend.flash")
    @include("core::layouts.partials.frontend.errors")

    <div id="passwordreset" style="margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Create New Password</div>
            </div>
            <div class="panel-body">
                <form method="post" action="{{URL::route('core.frontend.password.reset.store')}}" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="email" class=" control-label col-sm-3">Registered email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="email" placeholder="Please input your email used to register with us">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class=" control-label col-sm-3">New password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password" placeholder="create your new password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class=" control-label col-sm-3">Confirm password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="confirm your new password">
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Button -->
                        <div class="  col-sm-offset-3 col-sm-9">
                            <button id="btn-signup" type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="token" value="{{ $token }}">
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>
