<!DOCTYPE html>
<html>
<head>
    <title>Image Cropping Test</title>
    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">
    <base href="{{\URL::to("/")}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.3.6/cropper.css" />


    <style>
        .container {
            max-width: 640px;
            margin: 20px auto;
        }

        img {
            max-width: 100%;
        }
    </style>


</head>
<body>
<div id="app">




    <div class="container">
        <h1>Cropper with a range of aspect ratio</h1>
        <div>
            <img id="image" src="{{\URL::to("/")}}/files/test.jpg" alt="Picture">
        </div>
    </div>


    <button>Button</button>

    <!--scripts-->
    <script src="http://localhost/teamlive/public/assets/modules/minified/common.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.3.6/cropper.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            var image = document.querySelector('#image');
            var minAspectRatio = 1;
            var maxAspectRatio = 1;
            var cropper = new Cropper(image);


            $("button").click(function () {

                cropper.getCroppedCanvas().toBlob(function (blob) {

                    console.log("blob", blob);

                    var formData = new FormData();


                    formData.append('croppedImage', blob);

                    console.log("formData", formData);

                    // Use `jQuery.ajax` method
                    $.ajax('{{\URL::route('core.frontend.ajax.uploader')}}', {
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            console.log('data-->', data);
                            console.log('Upload success');
                        },
                        error: function () {
                            console.log('Upload error');
                        }
                    });
                });

            })

        });
    </script>




<script src="http://localhost/teamlive/public/assets/modules/core/vue.min.js?v=2.8"></script>
<script src="http://localhost/teamlive/public/assets/modules/core/vue-resource.min.js?v=2.8"></script>

<script src="http://localhost/teamlive/public/assets/modules/core/VueCommon.js?v=2.8"></script>



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
            //this.urls.base = $('base').attr('href');
            //this.urls.current = window.location.href;
            //----------------------------------------------
            //----------------------------------------------

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