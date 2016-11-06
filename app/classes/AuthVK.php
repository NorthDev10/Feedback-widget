<?php
defined('CONTACT_DETAILS') or die('Access denied');

class AuthVK {
    public static function getURLForAuthorize() {
        $url = 'https://oauth.vk.com/authorize?';
        $params = array(
            'client_id'     => VK_APP_ID,
            'redirect_uri'  => VK_REDIRECT_URI,
            'display' => 'page',
            'scope' => 'email,offline', 
            'response_type' => 'code',
            'state' => 'auth-vk',
            'v' => 5.44 
        );
        return $url.urldecode(http_build_query($params));
    }
    
    public static function getAccessToken($code) {
        $params = array(
            'client_id'     => VK_APP_ID,
            'client_secret'  => VK_SECRET_KEY,
            'redirect_uri' => VK_REDIRECT_URI,
            'code' => $code
        );
        $result = HttpRequest::get('https://oauth.vk.com/access_token', $params, true);
        if(isset($result['access_token'])) {
            return $result;
        }
    }
    
    public static function getUserInfo(array $dataAccess) {
        $params = array(
            'user_id' => $dataAccess['user_id'],
            'fields' => 'sex,bdate,city,country,photo_200_orig,contacts,site,nickname,connections',
            'access_token' => $dataAccess['access_token'],
            'v' => 5.8,
            'lang' => 'ru',
            'https' => 1
        );
        $result = HttpRequest::get('https://api.vk.com/method/users.get', $params, true);
        if(!isset($result['error'])) {
            $Users = new Users();
            if(isset($dataAccess['email'])) {
                $Users->setEmail($dataAccess['email']);
                $Users->setEmailConfirmation(1);
            }
            if(isset($dataAccess['access_token'])) {
                $Users->setVkAccessToken($dataAccess['access_token']);
            }
            if(!empty($result['response'][0]['id'])) {
                $Users->setVkUserId($result['response'][0]['id']);
            }
            if(!empty($result['response'][0]['first_name'])) {
                $Users->setFirstName($result['response'][0]['first_name']);
            }
            if(!empty($result['response'][0]['last_name'])) {
                $Users->setLastName($result['response'][0]['last_name']);
            }
            if(isset($result['response'][0]['mobile_phone']) 
                && !empty($result['response'][0]['mobile_phone'])) {
                $Users->setMobilePhone($result['response'][0]['mobile_phone']);
            }
            if(isset($result['response'][0]['home_phone']) 
                && !empty($result['response'][0]['home_phone'])) {
                $Users->setHomePhone($result['response'][0]['home_phone']);
            }
            if(isset($result['response'][0]['skype']) 
                && !empty($result['response'][0]['skype'])) {
                $Users->setSkype($result['response'][0]['skype']);
            }
            if(isset($result['response'][0]['site']) 
                && !empty($result['response'][0]['site'])) {
                $Users->setSiteURL($result['response'][0]['site']);
            }
            $Users->setIpAddress($_SERVER["HTTP_X_FORWARDED_FOR"]);
            return $Users;
        }
    }
}