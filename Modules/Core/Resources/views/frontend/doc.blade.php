<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>@if(isset($data->title)){{$data->title}}@else{{Config::get('core.name')}}
        v{{Config::get('core.version')}}@endif</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{assetsCoreGlobal()}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{assetsCoreGlobal()}}/css/bootstrap-extend.min.css">
    <link rel="stylesheet" href="{{assetsCoreMmenu()}}/css/site.min.css">

    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/highlight/styles/monokai-sublime.css">
    <link rel="stylesheet" href="{{assetsCoreGlobalVendor()}}/highlight/highlight.css">
    <link rel="stylesheet" href="{{assetsCoreMmenu()}}/examples/css/advanced/highlight.css">

    <!-- Scripts -->
    <script src="{{assetsCoreGlobalVendor()}}/breakpoints/breakpoints.js"></script>
    <script>
        Breakpoints();
    </script>

    <style>
        pre{
            border: none;
        }

    </style>

@yield('page_specific_head')
<!--/page specific-->
</head>

<body class="@if(isset($data->body_class)){{$data->body_class}}@endif  layout-full">
<!---content-->

<div class="page ">

    <div class="page-content  ">
        <header class="text-xs-center"><h1 class="animation-slide-top">Documentation</h1></header>


        <h3>Quick Codes</h3>

        <h4>To send email:</h4>
        <pre data-plugin="highlight" style="padding: 0px; margin: 0px;">
            <code class="php">\Mail::to($user)->send(new AdminWelcomeEmail($user));</code>
        </pre>
        <hr/>

        <h4>To Notifications:</h4>
        <pre data-plugin="highlight" style="padding: 0px; margin: 0px;">
            <code class="php">
                try{
                    Notification::send($user, new SyncWithCareAccountInfo($fillable));
                }catch(\Swift_TransportException $e)
                {
                    $event['type'] = "smtp";
                    $event['label'] = "smtp failure";
                    $event['details'] = "Mail delivery failed via smtp during syncing with care";
                    $event['error'] = $e->getMessage();
                    event(new InformErrorAdmin($event));
                }
            </code>

        </pre>
        <hr/>




        <h4>How emails are being logged?</h4>
        Trigger Notification --> in notification class, you use viaMail --> when email is sent
        MessageSending event get triggered which is being listened by LogSentMessage which create
        record in core_email_alerts table
        <hr/>

        <h4>To get lang constant:</h4>
        <pre data-plugin="highlight" style="padding: 0px; margin: 0px;">
            <code class="php">$message = \Lang::get("phseller::messages.smsMobileValidation",
                              ['otp' => $notifiable->mobile_verification_code]
        );</code>
            OR
            <code class="php">trans( 'core::messages.permission-denied' )</code>


        </pre>
        <hr/>

        <h4>Return Response (handle ajax & request):</h4>
        <pre data-plugin="highlight" style="padding: 0px; margin: 0px;">
            <code class="php">
            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;

            if ($request->ajax()) {
                return response()->json($response);
            } else {
                return redirect()->back()->withInput()->withErrors($errors);;
            }
            </code>
        </pre>
        <hr/>

        <h4>Check if any record exists:</h4>
        <pre data-plugin="highlight" style="padding: 0px; margin: 0px;">
            <code class="php">
                $user = User::all();
                if($user->isEmpty())
                {
                }
            </code>
        </pre>
        <hr/>

        <h4>Check if record exists:</h4>
        <pre data-plugin="highlight" style="padding: 0px; margin: 0px;">
            <code class="php">
                if(User::where('email', '=', Input::get('email'))->exists())
                {
                }
            </code>
        </pre>
        <hr/>

        $data->list->isEmpty()





    </div>

</div>


<!--/content-->

<!--scripts-->

<!-- Core Required  -->
<script src="{{assetsCoreGlobalVendor()}}/babel-external-helpers/babel-external-helpers.js"></script>
<script src="{{assetsCoreGlobalVendor()}}/jquery/jquery.js"></script>
<script src="{{assetsCoreGlobalVendor()}}/tether/tether.js"></script>
<script src="{{assetsCoreGlobalVendor()}}/bootstrap/bootstrap.js"></script>


<!-- Core  -->
<script src="{{assetsCoreGlobalVendor()}}/asscrollbar/jquery-asScrollbar.js"></script>
<script src="{{assetsCoreGlobalVendor()}}/asscrollable/jquery-asScrollable.js"></script>
<script src="{{assetsCoreGlobalVendor()}}/highlight/highlight.pack.js"></script>


<!-- Plugins -->
<script src="{{assetsCoreGlobalVendor()}}/slidepanel/jquery-slidePanel.js"></script>



<!--Scripts-->
<script src="{{assetsCoreGlobal()}}/js/State.js"></script>
<script src="{{assetsCoreGlobal()}}/js/Component.js"></script>
<script src="{{assetsCoreGlobal()}}/js/Plugin.js"></script>
<script src="{{assetsCoreGlobal()}}/js/Base.js"></script>
<script src="{{assetsCoreGlobal()}}/js/Config.js"></script>
<script src="{{assetsCoreMmenu()}}/js/Section/Menubar.js"></script>
<script src="{{assetsCoreMmenu()}}/js/Section/Sidebar.js"></script>
<script src="{{assetsCoreMmenu()}}/js/Section/PageAside.js"></script>
<script src="{{assetsCoreMmenu()}}/js/Section/GridMenu.js"></script>
<script>
    Config.set('assets', '{{assetsCoreMmenu()}}');
</script>

<!-- Page -->
<script src="{{assetsCoreMmenu()}}/js/Site.js"></script>

<script src="{{assetsCoreGlobal()}}/js/Plugin/highlight.js"></script>
<script src="{{assetsCoreMmenu()}}/examples/js/advanced/highlight.js"></script>



</body>
</html>
