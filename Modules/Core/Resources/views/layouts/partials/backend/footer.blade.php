@if(env('PUSHCREW_HASH'))
<!--Pushcrew Desktop Notifications-->
<script type="text/javascript">
    (function(p,u,s,h){
        p._pcq=p._pcq||[];
        p._pcq.push(['_currentTime',Date.now()]);
        s=u.createElement('script');
        s.type='text/javascript';
        s.async=true;
        s.src='https://cdn.pushcrew.com/js/{{env('PUSHCREW_HASH')}}.js';
        h=u.getElementsByTagName('script')[0];
        h.parentNode.insertBefore(s,h);
    })(window,document);
</script>
<!--Pushcrew Desktop Notifications-->
@endif