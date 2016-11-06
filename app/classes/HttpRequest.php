<?php
defined('CONTACT_DETAILS') or die('Access denied');

class HttpRequest {

    public static function post($url, $params, $parse = false) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($parse) {
            $result = json_decode($result, true);
            $result['status'] = $status;
        } else {
            $result = array($result, 'status' => $status);
        }
        return $result;
    }

    public static function get($url, $params="", $parse = false) {
        $curl = curl_init();
        if(is_array($params)) {
            curl_setopt($curl, CURLOPT_URL, $url . '?' . urldecode(http_build_query($params)));
        } else {
            curl_setopt($curl, CURLOPT_URL, $url);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($parse) {
            $result = json_decode($result, true);
            $result['status'] = $status;
        } else {
            $result = array($result, 'status' => $status);
        }
        return $result;
    }

    public static function getUsingCookie($url, $params="", $parse = false) {
        $curl = curl_init();
        $userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.10240";
        if(is_array($params)) {
            curl_setopt($curl, CURLOPT_URL, $url . '?' . urldecode(http_build_query($params)));
        } else {
            curl_setopt($curl, CURLOPT_URL, $url);
        }
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_COOKIE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, TEMP."Cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, TEMP."Cookie.txt");
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($parse) {
            $result = json_decode($result, true);
            $result['status'] = $status;
        } else {
            $result = array($result, 'status' => $status);
        }
        return $result;
    }
    
    public static function postUsingCookie($url, $params, $parse = false, $headre = false) {
        $curl = curl_init();
        $userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.10240";
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HEADER, $headre);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, TEMP."Cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, TEMP."Cookie.txt");
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($parse) {
            $result = json_decode($result, true);
            $result['status'] = $status;
        } else {
            $result = array($result, 'status' => $status);
        }
        return $result;
    }
}