<?php

namespace Modules\Blockui\Libraries;

use PHPHtmlParser\Dom;

class Extractor
{

    var $debug;



    //------------------------------------------------------------
    public function __construct($debug = true)
    {
        $this->debug = $debug;

    }
    //------------------------------------------------------------
    public function getGoogleResult($keyword, $records = 10)
    {

        $google_data = $this->fetchGoogleResult($keyword,$records);

        $search_data = $this->extractUnit($google_data, 'results</div>', 'Terms</a>');

        if(empty(trim($search_data)))
        {
            $search_data = $this->extractUnit($google_data, 'resultStats', 'id="foot');
            $search_data = $this->extractUnit($search_data."###", 'Maps</a>', '###');

        } else
        {
            $search_data = strip_tags($search_data, "<cite><div><a>");
        }

        $search_data = strip_tags($search_data, "<cite><div><a>");


        $list = $this->findContactUrlsAndDomains($search_data);


        $emails = $this->extractEmail($search_data);

        if(is_array($emails) && count($emails) > 0)
        {
            foreach ($emails as $email)
            {
                $ignore_check = $this->checkIgnoreList($email);

                if($ignore_check == true)
                {
                    continue;
                }

                $list['emails'][] = $email;
            }

            if(isset($list['emails']))
            {
                $list['emails'] = array_unique(array_filter($list['emails']));
            }
        }

        return $list;

    }
    //------------------------------------------------------------
    public function extractUnit($string, $start, $end)
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
    //------------------------------------------------------------
    public function findContactUrlsAndDomains($search_data)
    {


        $search_result_urls = $this->extractUrl($search_data);


        $exts = $this->getValidContactPage();
        $result = array();
        $invalid = [];
        $valid = [];

        $i = 0;
        $y = 0;
        foreach ($search_result_urls as $result_url)
        {
            if (is_int(strpos($result_url, '&amp;sa=U')))
            {
                $result_url_d = explode("&amp;sa=U", $result_url);
                $result_url = $result_url_d[0];
            }


            if (strpos($result_url, "www.google.com/aclk") !== FALSE) {
                if ($this->debug) {
                    $invalid[$i]['url'] = $result_url;
                    $invalid[$i]['reason'] = 'Ignored - Google redirection url';
                    $i++;
                }
                continue;
            }

            if (strpos($result_url, "googleusercontent.com") !== FALSE) {
                if ($this->debug) {
                    $invalid[$i]['url'] = $result_url;
                    $invalid[$i]['reason'] = 'Ignored - Google redirection url';
                    $i++;
                }
                continue;
            }


            if (strpos($result_url, 'http:') !== false) {
                //echo 'true';
            } else
            {
                $result_url = "http://".$result_url;
            }

            $domain = $this->getDomainFromUrl($result_url);
            if(!empty($domain))
            {
                //check domain is in ignore list or not
                $ignore_domains = $this->ignoreDomains();
                if(!in_array($domain, $ignore_domains))
                {
                    $valid['domains'][$y] = $domain;
                }
            }

            if (strpos($result_url, "webcache") !== FALSE) {
                if ($this->debug) {
                    $invalid[$i]['url'] = $result_url;
                    $invalid[$i]['reason'] = 'Ignored - Cache';
                    $i++;
                }
                continue;
            }
            foreach ($exts as $ext) {
                if (strpos($result_url, $ext) !== FALSE) {
                    $valid_urls = str_replace($ext, $ext . "***", $result_url);
                    break;
                } else {
                    continue;
                }
            }


            if (!isset($valid_urls))
            {
                if ($this->debug)
                {
                    $invalid[$i]['url'] = $result_url;
                    $invalid[$i]['reason'] = 'Ignored - Not a contact page';
                    $i++;
                }
                continue;
            }
            $valid_url_d = explode("***", $valid_urls);
            $final_url = trim($valid_url_d[0]);

            $valid['urls'][$y] = $final_url;
            $y++;
        }


        if(isset($valid['domains']))
        {
            $valid['domains'] = array_filter(array_unique($valid['domains']));
        }

        if(isset($valid['urls']))
        {
            $valid['urls'] = array_filter(array_unique($valid['urls']));
        }

        if(count($valid) > 0 && $this->debug)
        {
            echo "<h3>Valid Domains</h3>";
            if(isset($valid['domains']))
            {
                echo $this->arrayToTableVertical($valid['domains']);
            }


            echo "<h3>Valid Urls</h3>";
            if(isset($valid['urls']))
            {
                echo $this->arrayToTableVertical($valid['urls']);
            }



        }

        if(count($invalid) > 0 && $this->debug)
        {
            echo "<br/><br/><h3>Invalid URLs</h3>";
            echo $this->arrayToTable($invalid);
        }

        if(isset($valid['urls']))
        {
            $result['urls'] = $valid['urls'];
        }

        if(isset($valid['urls']))
        {
            $result['domains'] = $valid['domains'];
        }

        $result['status'] = 'success';
        return $result;

    }
    //------------------------------------------------------------
    public function extractUrl($str)
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

    //------------------------------------------------------------
    public function extractEmail($content)
    {
        //$pattern = '/[A-Za-z0-9._-]+@[A-Za-z0-9_-]+\.([A-Za-z0-9_-][A-Za-z0-9_]+)/';
        $pattern = '/[a-z0-9_.\-\+]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?/i';
        //$pattern = '~[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[A-Z]{2,4}~';
        preg_match_all($pattern, $content, $matches);
        if (empty($matches[0])) {
            return false;
        }
        $matches[0] = array_unique($matches[0]);
        return $matches[0];
    }
    //------------------------------------------------------------
    public function getValidContactPage()
    {
        $exts = array('.php', '.html', '.htm', '.asp', '/contactus/', "/contact-us/", "/contact_us/", '/contactus', "/contact-us", "/contact_us", "/contact", '/contact.html', 'contact.html', 'contact.aspx', 'contact_us.aspx', );
        return $exts;
    }
    //------------------------------------------------------------
    public function getDomainFromUrl($url)
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : '';
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return strtolower($regs['domain']);
        }
        return false;
    }
    //------------------------------------------------------------
    //------------------------------------------------------------
    //------------------------------------------------------------
    //------------------------------------------------------------
    //------------------------------------------------------------

    public function fetchGoogleResult($keyword, $records=10)
    {

        //$google_term = str_replace(" ", "+", trim($keyword));
        $google_term = urlencode($keyword);

        $url = "https://www.google.com/search?q=" . $google_term . "&num=" . $records;

        $result = $this->getCurlData($url);

        if($this->debug)
        {
            echo "<h2>".$keyword." - ".$url."</h1>";
            echo "<hr/>";
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        }

        return $result;
    }

    //------------------------------------------------------------
    public function getHttpCode($url)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpcode;
    }
    //------------------------------------------------------------
    //------------------------------------------------------------
    public function getCurlData($url, $agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13', $cookie = '', $referer = '', $post_fields = '', $return_transfer = 1, $follow_location = 1, $ssl = '', $curlopt_header = 0)
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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if ($referer) {
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }

        curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/cookies.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cookies.txt');
        $cookie = "checkCookies=yes;TestIfCookie=ok;TestIfCookieP=ok";
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);

        curl_setopt($ch, CURLOPT_VERBOSE, true);


        try {
            $result = curl_exec($ch);
        } catch (\Exception $e) {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return $response;
        }
        curl_close($ch);


        return $result;
    }
    //------------------------------------------------------------
    public function checkIgnoreList($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        } else {
            return true;
        }
        //delete very small domain emails
        $email_parts = explode("@", $email);
        $ignore_words = $this->ignoreEmailWords();
        if (in_array($email_parts[0], $ignore_words)) {
            return true;
        }
        $domain_ignore = $this->ignoreDomains();

        $exist = preg_grep("/$email_parts[1]/i", $domain_ignore);
        if ($exist) {
            return true;
        }
        if (in_array($email_parts[1], $domain_ignore))
        {
            return true;
        }


        $email_domain = $email_parts[1];
        $email_domain_d = explode(".", $email_domain);
        /*        if (strlen($email_domain_d[0]) <= 4 && $email_domain_d[0] != 'aol' && $email_domain_d[0] != 'msn')
                {
                    return true;
                }*/
        if (strlen($email_domain_d[0]) <= 4) {
            return true;
        }
        if (strlen($email_domain_d[0]) > 40) {
            //echo "Deleted: domain extension is too big"; echo "<br/>";
            return true;
        }
        if(in_array($email_domain_d[0], $ignore_words))
        {
            return true;
        }

        //delete gov domains
        if (strpos($email, '.gov') !== false
            || strpos($email, '.org') !== false
            || strpos($email, 'domain') !== false
            || strpos($email, 'hosting') !== false
            || strpos($email, 'virus') !== false
            || strpos($email, 'porn') !== false
            || strpos($email, 'sex') !== false
            || strpos($email, 'privacy') !== false
            || strpos($email, 'protection') !== false
        ) {
            //echo "Ignored: it's a GOV OR ORG or other none targeted domain"; echo "<br/>";
            return true;
        }
        //delete follow domain emails
        if ($email_domain_d[1] == 'cn' || $email_domain_d[1] == 'no' || $email_domain_d[1] == 'in') {
            //echo "Ignored: we don't want to target such domains"; echo "<br/>";
            return true;
        }
        //delete follow domain emails
        if (strlen($email_domain_d[1]) > 5) {
            //echo "Deleted: domain extension is too big"; echo "<br/>";
            return true;
        }
        //if to many special characters
        $num_special_character = $this->countEmailSpecialCharacters($email);
        if ($num_special_character > 6) {
            //echo "Deleted: too many special characters"; echo "<br/>";
            return true;
        }
    }
    //------------------------------------------------------------
    public function countEmailSpecialCharacters($string)
    {
        $pattern = '/[!@#$%^&*\.\-()]/';
        return preg_match_all($pattern, $string, $result);
    }
    //------------------------------------------------------------
    public function ignoreEmailWords()
    {
        $list = array("a", "about", "above", "above", "across", "after", "afterwards", "again", "against", "all", "almost", "alone", "along", "already", "also", "although", "always", "am", "among", "amongst", "amoungst", "amount", "an", "and", "another", "any", "anyhow", "anyone", "anything", "anyway", "anywhere", "are", "around", "as", "at", "back", "be", "became", "because", "become", "becomes", "becoming", "been", "before", "beforehand", "behind", "being", "below", "beside", "besides", "between", "beyond", "bill", "both", "bottom", "but", "by", "call", "can", "cannot", "cant", "co", "con", "could", "couldnt", "cry", "de", "describe", "detail", "do", "done", "down", "due", "during", "each", "eg", "eight", "either", "eleven", "else", "elsewhere", "empty", "enough", "etc", "even", "ever", "every", "everyone", "everything", "everywhere", "except", "few", "fifteen", "fify", "fill", "find", "fire", "first", "five", "for", "former", "formerly", "forty", "found", "four", "from", "front", "full", "further", "get", "give", "go", "had", "has", "hasnt", "have", "he", "hence", "her", "here", "hereafter", "hereby", "herein", "hereupon", "hers", "herself", "him", "himself", "his", "how", "however", "hundred", "ie", "if", "in", "inc", "indeed", "interest", "into", "is", "it", "its", "itself", "keep", "last", "latter", "latterly", "least", "less", "ltd", "made", "many", "may", "me", "meanwhile", "might", "mill", "mine", "more", "moreover", "most", "mostly", "move", "much", "must", "my", "myself", "name", "namely", "neither", "never", "nevertheless", "next", "nine", "no", "nobody", "none", "noone", "nor", "not", "nothing", "now", "nowhere", "of", "off", "often", "on", "once", "one", "only", "onto", "or", "other", "others", "otherwise", "our", "ours", "ourselves", "out", "over", "own", "part", "per", "perhaps", "please", "put", "rather", "re", "same", "see", "seem", "seemed", "seeming", "seems", "serious", "several", "she", "should", "show", "side", "since", "sincere", "six", "sixty", "so", "some", "somehow", "someone", "something", "sometime", "sometimes", "somewhere", "still", "such", "system", "take", "ten", "than", "that", "the", "their", "them", "themselves", "then", "thence", "there", "thereafter", "thereby", "therefore", "therein", "thereupon", "these", "they", "thickv", "thin", "third", "this", "those", "though", "three", "through", "throughout", "thru", "thus", "to", "together", "too", "top", "toward", "towards", "twelve", "twenty", "two", "un", "under", "until", "up", "upon", "us", "very", "via", "was", "we", "well", "were", "what", "whatever", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "whereupon", "wherever", "whether", "which", "while", "whither", "who", "whoever", "whole", "whom", "whose", "why", "will", "with", "within", "without", "would", "yet", "you", "your", "yours", "yourself", "yourselves", "the", "spam", "delivery", "abuse", "privacy", "protect", "customercare", "corporate-services", "whoisproxy", "whois", "proxy","domainabuse", "", "hr", "jobs", "job", "career");

        return $list;
    }
    //------------------------------------------------------------

    public function ignoreDomains()
    {
        $list = array('domaincontrol.com', 'worldnic.com', 'namebrightdns.com', 'dnspod.net', 'hichina.com', 'registrar-servers.com', 'onamae.com', 'kratosdns.net', 'xincache.com', 'name-services.com', '51dns.com', 'register.com', 'hostgator.com', 'wix.com', 'bluehost.com', '1and1-dns.us', 'ovh.net', 'parkingcrew.net', 'value-domain.com', 'iidns.com', 'spam-and-abuse.com', 'name.com', 'myhostadmin.net', 'change-d.net', 'wordpress.com', 'cashparking.com', 'systemdns.com', 'sedoparking.com', 'ndoverdrive.com', 'ipage.com', 'vpweb.com', 'dreamhost.com', '123-reg.co.uk', 'crazydomains.com', '1and1-dns.de', 'conficker-sinkhole.com', 'renewyourname.net', 'orderbox-dns.com', 'gandi.net', 'domainprofi.de', 'voodoo.com', 'interland.net', 'ezdnscenter.com', 'dns-diy.com', 'technorail.com', 'cloudflare.com', 'cnmsn.net', 'websitewelcome.com', 'dns.com.cn', '3g-go.com', "bigrock.in", "bigrock.com", 'bluestone.com', '163.com', 'naver.com', '126.com', "contactprivacy.com", "tucowsdomains.com", "tucows.com", "domaindiscreet.com", "uniregistry.com","privacy-link.com", "netnames.com", 'answer.py', 'quora.com', 'bbb.org', 'wikipedia.org', 'sulekha.com', 'sme.in', 'justdial.com', 'gmail.com', 'sitename.com', 'www.sme.in', 'quikr.com', 'tradeindia.com', 'fotolog.com'

            );


        return $list;

    }

    //------------------------------------------------------------
    public function arrayToTable($array, $recursive = false, $null = '&nbsp;') {


        // Sanity check
        if (empty($array) || !is_array($array)) {
            return false;
        }

        if (!isset($array[0]) || !is_array($array[0])) {
            $array = array($array);
        }

        // Start the table
        $table = "<table class='table-bordered'>\n";

        // The header
        $table .= "\t<tr>";
        // Take the keys from the first row as the headings
        foreach (array_keys($array[0]) as $heading) {
            $table .= '<th>' . $heading . '</th>';
        }
        $table .= "</tr>\n";

        // The body
        foreach ($array as $row) {
            $table .= "\t<tr>" ;
            foreach ($row as $cell) {
                $table .= '<td style="overflow-wrap: break-word; word-wrap: break-word; word-break: break-all;">';

                // Cast objects
                if (is_object($cell)) { $cell = (array) $cell; }

                if ($recursive === true && is_array($cell) && !empty($cell)) {
                    // Recursive mode
                    $table .= "\n" . array2table($cell, true, true) . "\n";
                } else {
                    $table .= (strlen($cell) > 0) ?
                        htmlspecialchars((string) $cell) :
                        $null;
                }

                $table .= '</td>';
            }

            $table .= "</tr>\n";
        }

        $table .= '</table>';
        return $table;
    }
    //------------------------------------------------------------

    public function arrayToTableVertical($arr)
    {
        $html = "";
        if(is_array($arr))
        {
            $i = 0;
            $html .= "<table class='table-bordered'>";
            foreach ($arr as $item)
            {
                $html .= "<tr><td>".$i."</td><td>".$item."</td>";
                $i++;
            }

            $html .= "</table>";
        }

        return $html;
    }

    //------------------------------------------------------------
    public function getEffectiveUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $a = curl_exec($ch); // $a will contain all headers

        $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); // This is what you need, it will return you the last effective URL


        return  $url;
    }
    //------------------------------------------------------------
    public function getEmailFromUrl($url)
    {
        $url_d = $this->getCurlData($url);
        return $this->getEmailFromHTML($url_d, $url);
    }
    //------------------------------------------------------------
    public function getMetaKeywords($html)
    {
        /*echo "<pre>";
        print_r($html);
        echo "</pre>";*/


        $head = $this->extractUnit($html, '<head>', '</head>');
        $keywords = $this->getMetaKeywordsViaDom($head);

        if(!$keywords)
        {
            $keywords = $this->getMetaKeywordsViaExtraction($head);
        }

        return $keywords;

    }
    //------------------------------------------------------------
    public function getMetaKeywordsViaDom($head)
    {

        $dom = new Dom;
        $dom->load($head);
        $metas = $dom->find('meta');

        $keywords = null;
        foreach ($metas as $meta)
        {
            // get the class attr
            $name = $meta->getAttribute('name');


            if($name == 'keywords')
            {
                $content = $meta->getAttribute('content');

                $list = explode(",", $content);

                if(count($list) > 0 && is_array($list))
                {
                    foreach ($list as $item)
                    {
                        if(str_word_count(trim($item)) >= 3)
                        {
                            $keywords[] = 'intitle:"'.strtolower(trim($item)).'" inurl:contact';
                        }
                    }
                }
            }
        }

        return $keywords;
    }
    //------------------------------------------------------------
    public function getMetaKeywordsViaExtraction($head)
    {

        $data = $this->extractUnit($head, 'name="keywords"', ">");
        if(!$data)
        {
            $data = $this->extractUnit($head, 'name="keywords"', "/>");
        }
        if(!$data)
        {
            $data = $this->extractUnit($head, "name='keywords'", "/>");
        }
        if(!$data)
        {
            $data = $this->extractUnit($head, "name='keywords'", ">");
        }

        if(!$data)
        {
            return null;
        }

        $data = $this->extractUnit($data, "content='", "'");

        if(!$data)
        {
            $data = $this->extractUnit($data, 'content="', '"');
        }

        if(!$data)
        {
            return null;
        }

        $list = explode(',', $data);

        if(count($list) < 2 || !is_array($list))
        {
            return null;
        }

        $keywords = null;
        foreach ($list as $item)
        {
            if(str_word_count(trim($item)) >= 3)
            {
                $keywords[] = 'intitle:"'.strtolower(trim($item)).'" inurl:contact';
            }
        }

        return $keywords;

    }
    //------------------------------------------------------------
    public function getEmailFromHTML($html, $url)
    {

        $url_d = $html;

        if (strpos($url, 'http') !== false)
        {

        } else{
            $url = "http://www.".$url;
        }

        $domain_name = $this->extractTLD($url);

        $domain_name_d = explode(".", $domain_name);


        $url_d = $this->extractUnit($url_d, "<body", "</body>");
        $url_d = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $url_d);
        $url_d = strip_tags($url_d, "<a>");
        $email_arr = $this->findEmail($url_d);
        if (!is_array($email_arr)) {
            $email_arr = array($email_arr);
        }

        foreach ($email_arr as $list) {
            $validate = $this->checkIgnoreList($list);
            if ($validate == true) {
                continue;
            }

            if (!empty($domain_name_d[0]) && isset($domain_name_d[0]) && isset($list) && strpos($list, $domain_name_d[0]) !== FALSE) {
                $item_d = explode('@', $list);
                $email_list[] = trim($item_d[0]) . "@" . trim($domain_name);
            } else {
                $email_list[] = $list;
            }
        }
        if (!isset($email_list) || !is_array($email_list) || count($email_list) < 1) {
            $response = [];
            $response['status'] = 'failed';
            $response['errors'][] = 'No Email Found';
            return $response;
        }
        $email_arr = array_unique(array_filter($email_list));
        $response['status'] = 'success';
        $response['data'] = $email_arr;
        return $response;
    }
    //------------------------------------------------------------
    public function extractTLD($domain)
    {
        preg_match("/[a-z0-9\-]{1,63}\.[a-z\.]{2,6}$/", parse_url($domain, PHP_URL_HOST), $_domain_tld);
        if (isset($_domain_tld[0])) {
            return $_domain_tld[0];
        } else {
            return false;
        }
    }
    //------------------------------------------------------------
    public function findEmail($content)
    {
        //$pattern = '/[A-Za-z0-9._-]+@[A-Za-z0-9_-]+\.([A-Za-z0-9_-][A-Za-z0-9_]+)/';
        $pattern = '/[a-z0-9_.\-\+]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?/i';
        //$pattern = '~[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[A-Z]{2,4}~';
        preg_match_all($pattern, $content, $matches);
        if (empty($matches[0])) {
            return false;
        }
        $matches[0] = array_unique($matches[0]);
        return $matches[0];
    }
    //------------------------------------------------------------
    public function findCMS($html)
    {


        if (strpos($html, 'wp-content/themes') !== false)
        {
            $response['status'] = 'success';
            $response['data']['cms'] = 'wordpress';
            return $response;
        } else if(strpos($html, 'woocommerce') !== false)
        {
            $response['status'] = 'success';
            $response['data']['cms']= 'woocommerce';
            return $response;
        }else if(strpos($html, 'skin/frontend/') !== false)
        {
            $response['status'] = 'success';
            $response['data']['cms']= 'magento';
            return $response;
        }else if(strpos($html, 'cdn.shopify.com') !== false)
        {
            $response['status'] = 'success';
            $response['data']['cms']= 'shopify';
            return $response;
        }else if(
            strpos($html, 'Joomla') !== false
            || strpos($html, 'joomla') !== false
        )
        {
            $response['status'] = 'success';
            $response['data']['cms']= 'joomla';
            return $response;
        }

        $response = [];
        $response['errors'][] = "CMS not detected";
        $response['status'] = 'failed';

        return $response;


    }
    //------------------------------------------------------------
    //------------------------------------------------------------
    //------------------------------------------------------------

}
