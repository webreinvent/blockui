<!--flash message-->
@if(Session::has('flash_error'))
    <div class="alert alert-danger fade in">
        <button aria-hidden=true data-dismiss=alert class=close type=button>X</button>
        <p>{{ Session::get('flash_error') }}</p>
    </div>
@endif

@if(Session::has('flash_notice'))
    <div class="alert alert-info fade in">
        <button aria-hidden=true data-dismiss=alert class=close type=button>X</button>
        <p>{{ Session::get('flash_notice') }}</p>
    </div>
@endif

@if(Session::has('flash_warning'))
    <div class="alert alert-warning fade in">
        <button aria-hidden=true data-dismiss=alert class=close type=button>X</button>
        <p>{{ Session::get('flash_warning') }}</p>
    </div>
@endif

@if(Session::has('flash_success'))
    <div class="alert alert-success fade in">
        <button aria-hidden=true data-dismiss=alert class=close type=button>X</button>
        <p>{{ Session::get('flash_success') }}</p>
    </div>
@endif
<!--flash message-->
