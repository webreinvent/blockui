@extends('core::layouts.frontend_form')

@section('form')

    <form method="post" action="{{URL::route('core.frontend.register.store')}}" autocomplete="off">

        <div class="form-group form-material floating" data-plugin="formMaterial">
            <input type="text" class="form-control"
                   onfocus="this.removeAttribute('readonly');" readonly
                   name="name"/>
            <label class="floating-label">Name</label>
        </div>

        <div class="form-group form-material floating" data-plugin="formMaterial">
            <input type="text" class="form-control"
                   onfocus="this.removeAttribute('readonly');" readonly
                   name="email"/>
            <label class="floating-label">Email</label>
        </div>

        <div class="form-group form-material floating" data-plugin="formMaterial">
            <input type="text" class="form-control"
                   onfocus="this.removeAttribute('readonly');" readonly
                   name="mobile"/>
            <label class="floating-label">Mobile</label>
        </div>

        <div class="form-group form-material floating" data-plugin="formMaterial">
            <input type="password" class="form-control"
                   onfocus="this.removeAttribute('readonly');" readonly
                   name="password"/>
            <label class="floating-label">Password</label>
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-lg margin-top-40">Sign Up</button>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
@endsection

@section("page_specific_footer")
    <script>
        $(document).ready(function () {
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
        });
    </script>

@endsection
