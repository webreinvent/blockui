<html>
<head>
    <title>Realtime Notifications</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="http://localhost/teamlive/public/assets/theme/global/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost/teamlive/public/assets/theme/global/css/bootstrap-extend.min.css">
    <link rel="stylesheet" href="http://localhost/teamlive/public/assets/theme/mmenu/assets/css/site.min.css">

    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/summernote/summernote.css">
</head>
<body>

<div id="summernote"></div>


<script src="http://localhost/teamlive/public/assets/theme/global/vendor/jquery/jquery.js"></script>
<script src="http://localhost/teamlive/public/assets/theme/global/vendor/moment/moment.min.js"></script>


<script src="http://localhost/teamlive/public/assets/theme/global/vendor/tether/tether.js"></script>
<script src="http://localhost/teamlive/public/assets/theme/global/vendor/bootstrap/bootstrap.js"></script>

<script src="{{assetsCoreGlobalVendor()}}/summernote/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200,
            callbacks: {
                onImageUpload: function(files) {
                    console.log('files-->', files);
                    sendFile(files[0]);
                }
            },

        });
        function sendFile(file, editor, welEditable) {
            data = new FormData();
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: "http://localhost/teamlive/uploader",
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    console.log(url);
                    $('#summernote').summernote("insertImage", url, 'filename');
                    //editor.insertImage(welEditable, url);
                }
            });
        }
    });


</script>

</body>
</html>
