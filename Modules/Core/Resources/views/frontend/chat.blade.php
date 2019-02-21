<!DOCTYPE html>
<html>
<head>
    <title>Pusher Test</title>
    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">

</head>
<body>
<div id="app">
<!--urls-->
<input type="hidden" data-type="url" name="base" value="{{url("/")}}" />
<input type="hidden" data-type="url" name="current" value="{{url()->current()}}" />
<!--/urls-->

<h1>Chat</h1>

    <ul>

    </ul>


<textarea v-model="message"></textarea>
<br/>
<button v-on:click="sendMessage($event)">Send</button>

</div>


<!--scripts-->
<script src="http://localhost/teamlive/public/assets/modules/minified/common.js"></script>

<script src="http://localhost/teamlive/public/assets/modules/core/vue.min.js?v=2.8"></script>
<script src="http://localhost/teamlive/public/assets/modules/core/vue-resource.min.js?v=2.8"></script>

<script src="http://localhost/teamlive/public/assets/modules/core/VueCommon.js?v=2.8"></script>

<script src="https://tempemails.io/public/assets/modules/tempemails/pusher.min.js"></script>
<script>


    //--------------------------------------------------------------------------
    const app = new VueCommon({
        el: '#app',
        data: {

            urls: null,
            pusher: null,
            channel: null,
            channel_name: null,
            message: null,

        },
        mounted: function () {

            //----------------------------------------------
            var geturl = [];
            $("input[data-type=url]").each(function () {
                var name = $(this).attr('name');
                var value = $(this).val();
                geturl[name] = value;
            });
            this.urls = geturl;
            //----------------------------------------------
            //----------------------------------------------
            this.pusher = new Pusher('<?php echo $data['key']; ?>', {
                authEndpoint: this.urls.current+'/auth',
                cluster: '<?php echo $data['cluster']; ?>',
                auth: {
                    headers: {
                        'X-CSRF-Token': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    }
                }
            });
            console.log("pusher", this.pusher);
            //----------------------------------------------

            this.pusherSubscribe();
            //----------------------------------------------
            //----------------------------------------------
            //----------------------------------------------

        },
        methods:{
            pusherSubscribe: function () {
                this.channel_name = 'private-task.15';
                this.channel = this.pusher.subscribe(this.channel_name);

                //listen to the event new.message
                this.channel.bind("new.message", function(data)
                {
                    $('ul').append('<li><b>'+data.name+'</b>: '+data.message+'</li>');
                    console.log("data received", data);
                });

            },
            //-------------------------------------------------------------------
            sendMessage: function (event) {
                if(event)
                {
                    event.preventDefault();
                }

                var url = this.urls.current+"/send";
                var params = {channel_name: this.channel_name, message: this.message, onsignal_user_id: onsignal_user_id };

                console.log('--->', params);

                OneSignal.push(function() {
                    /* These examples are all valid */
                    OneSignal.getUserId(function(userId) {

                        onsignal_user_id = userId;

                        console.log(userId);

                        OneSignal.sendTag("page", "chat");

                        OneSignal.sendTags({
                            task: 3,
                        });

                    });

                });


                this.processHttpRequest(url, params, this.sendMessageAfter);
            },
            //---------------------------------------------------------------------
            sendMessageAfter: function (data) {

                console.log('data-->',data);


                NProgress.done();

            },
            //-------------------------------------------------------------------

            //-------------------------------------------------------------------
            //-------------------------------------------------------------------
            //-------------------------------------------------------------------

        },

    });
    //--------------------------------------------------------------------------
    //--------------------------------------------------------------------------
    //--------------------------------------------------------------------------



</script>

<!--/scripts-->


</body>
</html>