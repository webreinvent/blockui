@extends('core::layouts.frontend_form')

@section('form')


    <form method="post" action="{{URL::route('core.frontend.authenticate')}}" autocomplete="off">


        <div class="form-group form-material floating" data-plugin="formMaterial">
            @if($data->email)
            <input type="text" class="form-control"
                   value="{{$data->email}}"
                   name="email"/>
            <label class="floating-label">Email</label>
                @else
                <input type="text" class="form-control"
                       onfocus="this.removeAttribute('readonly');" readonly
                       name="email"/>
                <label class="floating-label">Email</label>
            @endif
        </div>

        <div class="form-group form-material floating" data-plugin="formMaterial">
            <input type="password" class="form-control"
                   onfocus="this.removeAttribute('readonly');" readonly
                   name="password"/>
            <label class="floating-label">Password</label>
        </div>

        <div class="form-group clearfix">
{{--            <div class="checkbox-custom checkbox-inline checkbox-primary checkbox-lg pull-left">
                <input type="checkbox" id="inputCheckbox" name="remember">
                <label for="inputCheckbox">Remember me</label>
            </div>--}}
        </div>

        <button type="submit" name="signin" value="true" class="btn btn-success btn-block margin-top-40">Sign In</button>

        <button type="submit" name="forgotpassword" value="true" class="btn btn-primary btn-block margin-top-40">Forgot Password?</button>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        @if(isset($data->session['redirect_url']))
            <input type="hidden" name="redirect_url" value="{{ $data->session['redirect_url'] }}"/>
            @endif

    </form>

@endsection


@section("page_specific_footer")
    <script>
        $(document).ready(function () {
            var filled = false;
           $('input[name=email]').keyup(function (e)
           {

               var val = $(this).val();

               var key = e.keyCode || e.charCode;

               if(key == 8 || key == 46)
               {
                   return false;
               } else
               {
                   if( (val.indexOf('@w') !== -1 && filled == false) )
                   {
                       var data = val.split("@")
                       val = data[0]+"@webreinvent.com";
                       $(this).val(val);
                       filled == true;
                   }
               }



           });
        });

       /* $(document).ready(function () {
            $("form").submit(function (e) {
                e.preventDefault();
                var url = $(this).attr('action');
                var method = $(this).attr('method');
                var data = $(this).serialize();
                console.log(data);
                console.log(url);

                $.ajax({
                    type: method,
                    url: url,
                    data: data,
                    context: this,
                    success: function (response) {
                        console.log(response);
                        if (response.status == "failed") {
                            $.each(response.errors, function (key, data) {
                                var input = 'input[name=' + key + ']';
                                $('body').find(input).closest('.form-material')
                                        .addClass("has-danger");
                                alertify.error(data);
                            })
                        } else if(response.status == 'success')
                        {
                            if(response.redirect)
                            {
                                window.location.replace(response.redirect)
                            }

                        }
                    }
                });
            });
        });*/
    </script>

@endsection