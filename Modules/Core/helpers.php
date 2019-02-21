<?php



//---------------------------------------------------


function getDomain($url=null)
{
    if(!$url)
    {
        $url = \URL::current();
    }

    $host = @parse_url($url, PHP_URL_HOST);
    // If the URL can't be parsed, use the original URL
    // Change to "return false" if you don't want that
    if (!$host)
        $host = $url;
    // The "www." prefix isn't really needed if you're just using
    // this to display the domain to the user
    if (substr($host, 0, 4) == "www.")
        $host = substr($host, 4);
    // You might also want to limit the length if screen space is limited
    if (strlen($host) > 50)
        $host = substr($host, 0, 47) . '...';
    return $host;
}
//---------------------------------------------------
function br2nl($string)
{
    return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
}
//---------------------------------------------------
function moduleAssetsThemeUrl()
{
    $asset = asset("public/assets/theme");
    return $asset;
}
//---------------------------------------------------
function moduleAssets($name)
{
    $asset = asset("public/assets/modules/" . $name);
    return $asset;
}
//---------------------------------------------------
function moduleAssetsUrl($module_name, $file_name)
{
    $asset = asset("public/assets/modules/" . $module_name.$file_name."?v=".Config::get($module_name.'.version'));
    return $asset;
}
//---------------------------------------------------
function themeAssetsMinified()
{
    return false;
}
//---------------------------------------------------
function getDefaultTheme()
{
    $theme = "theme-v2";

    return $theme;
}
//---------------------------------------------------
function themeAssetsUrl($file_path_and_name, $theme_name=null)
{
    if(!$theme_name)
    {
        $theme_name = getDefaultTheme();
    }

    $asset = asset("public/assets/".$theme_name."/".$file_path_and_name."?v=".Config::get(' core.version'));
    return $asset;

}
//---------------------------------------------------
function assetsCoreGlobal()
{
    $asset = asset("public/assets/theme/global");
    return $asset;
}

//---------------------------------------------------
function assetsCoreGlobalVendor()
{
    $asset = asset("public/assets/theme/global/vendor");
    return $asset;
}

//---------------------------------------------------
function assetsCoreMmenu()
{
    $asset = asset("public/assets/theme/mmenu/assets");
    return $asset;
}

//---------------------------------------------------
function loadExtendableView($view_name)
{
    /*$modules = new Modules\Core\Entities\Module();
    $modules = $modules->enabled()->slugs()->toArray();*/


    $modules = \NwidartModule::allEnabled();
    
    $modules = (array)json_decode(json_encode($modules));

    $module_order = array();


    $view = "";
    $i = 0;
    foreach ($modules as $module=>$item) {
        $module = strtolower($module);

        $order = Config::get($module.".order");

        if($order == 0 && $module != 'core')
        {
            $order = $i;
        }
        $module_order[$order] = $module;

        $i++;
    }

    ksort($module_order);

    foreach ($module_order as $module) {
        $module = strtolower($module);
        $full_view_name = $module . '::backend.extendable.' . $view_name;

        if (View::exists($full_view_name)) {
            try {
                $view = \View::make($full_view_name);
                echo $view;
            } catch (Exception $e) {
                echo json_encode($e->getMessage());
            }
        }
    }

}

//---------------------------------------------------
function isValidateDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

//---------------------------------------------------
function errorsToArray($errors)
{
    $errors = $errors->toArray();
    $error = array();
    foreach ($errors as $error_list) {
        foreach ($error_list as $item) {
            $error[] = $item;
        }
    }
    return $error;
}

//---------------------------------------------------
function fileNameFromPath($path)
{
    $info = pathinfo($path);
    $file_name = basename($path, '.' . $info['extension']);
    return $file_name;
}

//---------------------------------------------------
function imageResize($path, $width = null, $height = null, $new_file_name = null, $destination = null)
{

    //read more details about the package at: http://image.intervention.io/getting_started/installation#laravel

    if($width==null && $height == null)
    {
        return $path;
    }

    $file_name = fileNameFromPath($path);
    $file_extension = $extension = pathinfo($path, PATHINFO_EXTENSION);
    $full_file_name = $file_name . "." . $file_extension;
    $file_directory = str_replace($full_file_name, "", $path);
    if ($new_file_name == null)
    {
        if ($width != null) {
            $new_file_name = $file_name . "-" . $width;
        }
        if ($height != null) {
            $new_file_name = $new_file_name . "-" . $height;
        }
    }
    $new_file_name = $new_file_name . "." . $file_extension;

    if($destination == null)
    {
        $destination = $file_directory. $new_file_name;
    }

    if(file_exists( $destination)) {
        return $destination;
    }
    $img = \Image::make($path)->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
    });
    $img->save($destination);
    return $destination;
}

//---------------------------------------------------
function highlight($text, $words) {
    $highlighted = preg_filter('/' . preg_quote($words) . '/i', '<span style="background-color: #fbfab6; color: #7e7d01; padding: 2px 5px; font-size: 12px; display: inline-block; margin-top: 3px; border-radius: 3px;">$0</span>', $text);
    if (!empty($highlighted)) {
        $text = $highlighted;
    }
    return $text;
}
//---------------------------------------------------
function getConstant($key)
{
    $val = null;
    switch ($key) {
        case 'permission.denied':
            $val = "Permission denied";
            break;
        //------------------------------------------
        case 'credentials.invalid':
            $val = "Invalid credentials";
            break;
        //------------------------------------------
        case 'account.disabled':
            $val = "Your account is disabled";
            break;
        //------------------------------------------
        case 'login.required':
            $val = "You must be logged in";
            break;
        //------------------------------------------
        case 'core.backend.logout':
            $val = "You have successfully logged out";
            break;
        //------------------------------------------
        case 'core.backend.not-found':
            $val = "Record not found";
            break;
        //------------------------------------------
    }
    return $val;
}
//---------------------------------------------------
function getModuleSetting($module_name, $setting_name)
{
    $config = \Config::get( $module_name );

    $settings = (array) $config['settings'];

    if(!isset($settings[$setting_name]))
    {
        return null;
    }

    return $settings[$setting_name];
}

//---------------------------------------------------------------

function getIp()
{
    $ip = \Illuminate\Support\Facades\Request::ip();

    //$ip = '103.68.217.226';

    return $ip;
}

//---------------------------------------------------------------
function getCountryNameFromIp($ip=null)
{
    if(!$ip)
    {
        $ip = getIp();
    }
    $location = geoip($ip);
    return $location->country;
}

//---------------------------------------------------------------
function getCountryCodeFromIp($ip=null)
{
    if(!$ip)
    {
        $ip = getIp();
    }

    $location = geoip($ip);
    return $location->iso_code;
}
//---------------------------------------------------------------
function getCurrencyFromIp($ip=null)
{
    if(!$ip)
    {
        $ip = getIp();
    }
    $location = geoip($ip);
    return $location->currency;
}
//---------------------------------------------------------------
//---------------------------------------------------
//---------------------------------------------------
//---------------------------------------------------
//---------------------------------------------------
//---------------------------------------------------
