@if(assignableMinified())
    <script src="{{themeAssetsUrl('js_minified/script.js')}}"></script>
@else
    <script src="{{themeAssetsUrl('js/jquery-3.3.1.slim.min.js')}}"></script>
    <script src="{{themeAssetsUrl('js/bootstrap.min.js')}}"></script>
@endif
