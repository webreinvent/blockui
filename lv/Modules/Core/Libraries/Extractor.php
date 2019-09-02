<?php
namespace Modules\Core\Libraries;
class Extractor
{


//----------------------------------------------------------------------------------------
//to the data from the url
    public static function LoadCURLPage($url, $agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13', $cookie = '', $referer = '', $post_fields = '', $return_transfer = 1, $follow_location = 1, $ssl = '', $curlopt_header = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($ssl) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        }
        curl_setopt($ch, CURLOPT_HEADER, $curlopt_header);
        if ($agent) {
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        }
        if ($post_fields) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        if ($referer) {
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }
        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        }
        $result = curl_exec($ch);
        curl_close($ch);
//print_r($result);
        return $result;
    }

//----------------------------------------------------------------------------------------
    public static function extract_unit($string, $start, $end)
    {
        $pos = stripos($string, $start);
        if ($pos != false) {
            $str = substr($string, $pos);
            $str_two = substr($str, strlen($start));
            $second_pos = stripos($str_two, $end);
            $str_three = substr($str_two, 0, $second_pos);
            $unit = trim($str_three); // remove whitespaces
            return $unit;
        } else {
            return "";
        }
    }

//----------------------------------------------------------------------------------------
    public static function get_links($content)
    {
//print_r($content);
//$pattern = "/<a style=\"(.*)\" href=\"(.*)\">(.*)<\/a>/";
//$pattern = "/<a href=\"(.*?)\">/";
//$pattern = "/<a href=\"([^\"]*)\">(.*)<\/a>/iU";
//$pattern = "/href\=\'(.*?)\'/";
//$pattern = '/#<i(.*)>#ims/';
        $pattern = "/<a.*? href=\"(.*?)\".*?>(.*?)<\/a>/i";
        preg_match_all($pattern, $content, $match);
        return $match[1];
    }

//----------------------------------------------------------------------------------------
    public static function strip_attributes($msg, $tag, $attr = "", $suffix = "")
    {
        $lengthfirst = 0;
        while (strstr(substr($msg, $lengthfirst), "<$tag ") != "") {
            $tag_start = $lengthfirst + strpos(substr($msg, $lengthfirst), "<$tag ");
            $partafterwith = substr($msg, $tag_start);
            $img = substr($partafterwith, 0, strpos($partafterwith, ">") + 1);
            $img = str_replace(" =", "=", $img);
            $out = "<$tag";
            for ($i = 0; $i < count($attr); $i++) {
                if (empty($attr[$i])) {
                    continue;
                }
                $long_val =
                    (strpos($img, " ", strpos($img, $attr[$i] . "=")) === false) ?
                        strpos($img, ">", strpos($img, $attr[$i] . "=")) - (strpos($img, $attr[$i] . "=") + strlen($attr[$i]) + 1) :
                        strpos($img, " ", strpos($img, $attr[$i] . "=")) - (strpos($img, $attr[$i] . "=") + strlen($attr[$i]) + 1);
                $val = substr($img, strpos($img, $attr[$i] . "=") + strlen($attr[$i]) + 1, $long_val);
                if (!empty($val)) {
                    $out .= " " . $attr[$i] . "=" . $val;
                }
            }
            if (!empty($suffix)) {
                $out .= " " . $suffix;
            }
            $out .= ">";
            $partafter = substr($partafterwith, strpos($partafterwith, ">") + 1);
            $msg = substr($msg, 0, $tag_start) . $out . $partafter;
            $lengthfirst = $tag_start + 3;
        }
        return $msg;
    }

//----------------------------------------------------------------------------------------
    public static function cleanText($str)
    {
        $str = str_replace("Ñ", "&#209;", $str);
//$str =  preg_replace('/Ñ/g',"|&#209;|", $str);
//echo "Text BEGIN ".$str."  --- ".bin2hex ("Ñ")."\n<BR>";     // d1
        /*
        for($i = 0 ; $i < strlen($str) ; $i++){
        echo "".$str{$i}."  - ". bin2hex ( $str{$i})."<BR>";
        }
        */
        $str = str_replace("�", "", $str);
        $str = str_replace("ñ", " ", $str);
        $str = str_replace("ñ", " ", $str);
        $str = str_replace("Á", " ", $str);
        $str = str_replace("á", " ", $str);
        $str = str_replace("É", " ", $str);
        $str = str_replace("é", " ", $str);
        $str = str_replace("ú", " ", $str);
        $str = str_replace("ù", " ", $str);
        $str = str_replace("Í", " ", $str);
        $str = str_replace("í", " ", $str);
        $str = str_replace("Ó", " ", $str);
        $str = str_replace("ó", " ", $str);
        $str = str_replace("“", " ", $str);
        $str = str_replace("”", " ", $str);
        $str = str_replace("‘", " ", $str);
        $str = str_replace("’", " ", $str);
        $str = str_replace("—", " ", $str);
        $str = str_replace("–", " ", $str);
        $str = str_replace("™", " ", $str);
        $str = str_replace("ü", " ", $str);
        $str = str_replace("Ü", " ", $str);
        $str = str_replace("Ê", " ", $str);
        $str = str_replace("ê", " ", $str);
        $str = str_replace("Ç", " ", $str);
        $str = str_replace("ç", " ", $str);
        $str = str_replace("È", " ", $str);
        $str = str_replace("è", " ", $str);
        $str = str_replace("•", " ", $str);
        $str = str_replace("Ã¼", " ", $str);
        $str = str_replace("â€¦", " ", $str);
        $str = str_replace("ü", " ", $str);
        $str = str_replace("â€¢", " ", $str);
        $str = str_replace('â€™', '\'', $str);
        $str = str_replace('â€¦', '...', $str);
        $str = str_replace('â€“', '-', $str);
        $str = str_replace('â€œ', '"', $str);
        $str = str_replace('â€˜', '\'', $str);
        $str = str_replace('â€¢', '-', $str);
        $str = str_replace('â€¡', 'c', $str);
        $str = preg_replace('!\s+!', ' ', $str);
        $str = htmlspecialchars($str, ENT_QUOTES, "UTF-8");
//$str = iconv("UTF-8", "ISO-8859-1", $str);
        $str = utf8_decode($str);
        $str = str_replace("?", " ", $str);
        return $str;
    }

//----------------------------------------------------------------------------------------
    public static function remove_line_breaks($output)
    {
        $output = str_replace(array("\r\n", "\r"), "\n", $output);
        $lines = explode("\n", $output);
        $new_lines = array();
        foreach ($lines as $i => $line) {
            if (!empty($line))
                $new_lines[] = trim($line);
        }
        return implode($new_lines);
    }

//----------------------------------------------------------------------------------------
    public static function find_email($content)
    {
        $pattern = '/[A-Za-z0-9._-]+@[A-Za-z0-9_-]+\.([A-Za-z0-9_-][A-Za-z0-9_]+)/';
//$pattern = '~[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[A-Z]{2,4}~';
        preg_match_all($pattern, $content, $matches);
        if (empty($matches[0])) {
            return false;
        }
        $matches[0] = array_unique($matches[0]);
        return $matches[0];
    }

//----------------------------------------------------------------------------------------
    public static function find_phone($content)
    {
//$content = str_replace(".", "", $content);
        preg_match_all('/[0-9]{3}[\-][0-9]{6}|[0-9]{3}[\s][0-9]{6}|[0-9]{3}[\s][0-9]{3}[\s][0-9]{4}|[0-9]{9}|[0-9]{3}[\-][0-9]{3}[\-][0-9]{4}/', $content, $matches);
        $matches = $matches[0];
        return $matches;
    }

//----------------------------------------------------------------------------------------
//generate comma string from array
    public static function array_comma_string($array)
    {
        $count = count($array);
        $html = "";
        $i = 1;
        if (is_array($array)) {
            foreach ($array as $row) {
                if ($i != $count) {
                    $row = trim($row);
                    $html .= $row . ", ";
                } else if ($i == $count) {
                    $html .= $row;
                }
                $i++;
            }
        } else {
            $html = $array;
        }
        return $html;
    }

//----------------------------------------------------------------------------------------
    public static function find_domains($str)
    {
        $pattern = '#[a-zA-Z0-9]{2,254}\.[a-zA-Z0-9]{2,4}(\S*)#i';
        preg_match_all($pattern, $str, $matches, PREG_PATTERN_ORDER);
        $result = array();
        foreach ($matches[0] as $domain) {
            $domain = str_replace('whois', '', $domain);
            $result[] = $domain;
        }
        return $result;
    }
//----------------------------------------------------------------------------------------
    public static function clean_domain($domain)
    {



        if(empty($domain) || $domain =="")
        {
            return null;
        }

        $domain = strtolower($domain);



        if (strpos($domain, 'prntscr.com') !== false
        || strpos($domain, 'themeforest.net') !== false
        || strpos($domain, 'wordpress.net') !== false
        || strpos($domain, 'xe.gr') !== false
        || strpos($domain, 'authorize.net') !== false
        || strpos($domain, 'websitebuilder.com') !== false
        || strpos($domain, 'google.com') !== false
        || strpos($domain, 'demo') !== false
        || strpos($domain, 'asp.net') !== false
        || strpos($domain, 'youtube.com') !== false
        || strpos($domain, 'salesforce.com') !== false
        || strpos($domain, 'zapier.com') !== false
        || strpos($domain, 'box.com') !== false
        || strpos($domain, 'my.cnf') !== false
        || strpos($domain, 'ember.js') !== false
        || strpos($domain, 'jquery.js') !== false
        || strpos($domain, 'vuejs') !== false
        || strpos($domain, 'node.js') !== false
        || strpos($domain, '.png') !== false
        || strpos($domain, '.doc') !== false
        || strpos($domain, '.gif') !== false
        || strpos($domain, '.jpg') !== false
        || strpos($domain, '.mp4') !== false
        || strpos($domain, '.mp3') !== false
        || strpos($domain, 'megento') !== false
        || strpos($domain, 'joomla') !== false
        || strpos($domain, 'github.com') !== false
        ) {
            return null;
        }


        //remove last dot
        $domain = rtrim($domain, '.');

        //remove last dot
        $domain = rtrim($domain, ',');

        //remove last slash
        $domain = rtrim($domain, '/');

        //remove last slash
        $domain = rtrim($domain, ')');

        //remove https://www.
        $domain = str_replace("https://www.", "", $domain);

        //remove http://www.
        $domain = str_replace("http://www.", "", $domain);

        //remove www.
        $domain = str_replace("www.", "", $domain);

        $array = ['domain' => "http://www".$domain];
        $rules = array(
            'domain' => 'required|url',
        );

        $validator = \Validator::make( $array, $rules);
        if ( $validator->fails() ) {

            return null;
        }


        //remove last dot
        $domain = rtrim($domain, '.');

        //remove last dot
        $domain = rtrim($domain, ',');

        //remove last slash
        $domain = rtrim($domain, '/');

        //remove last slash
        $domain = rtrim($domain, ')');

        return $domain;


    }
//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------
//---------------------------------------------------
//---------------------------------------------------
//---------------------------------------------------
//---------------------------------------------------
//---------------------------------------------------
//---------------------------------------------------
}