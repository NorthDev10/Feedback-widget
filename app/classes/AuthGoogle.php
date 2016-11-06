<?php
defined('CONTACT_DETAILS') or die('Access denied');

class AuthGoogle {
    public static function getURLForAuthorize() {
        $url = 'https://accounts.google.com/o/oauth2/v2/auth?';
        $params = array(
            'response_type' => 'code',
            'client_id' => GOOGLE_APP_ID,
            'scope' => 'email profile',
            'state' => 'auth-google',
            'redirect_uri'  => GOOGLE_REDIRECT_URI
        );
        return $url.urldecode(http_build_query($params));
    }
    
    public static function getAccessToken($code) {
        $params = array(
            'client_id'     => GOOGLE_APP_ID,
            'client_secret'  => GOOGLE_SECRET_KEY,
            'redirect_uri' => GOOGLE_REDIRECT_URI,
            'code' => $code,
            'grant_type' => 'authorization_code'
        );
        $result = HttpRequest::post('https://www.googleapis.com/oauth2/v4/token', $params, true);
        if(isset($result['access_token'])) {
            return $result;
        }
    }
    
    public static function getUserInfo(array $dataAccess) {
        $params = array('access_token' => $dataAccess['access_token']);
        $result = HttpRequest::get('https://www.googleapis.com/userinfo/v2/me', $params, true);
        if(!isset($result['error'])) {
            $Users = new Users();
            if(isset($result['email'])) {
                $Users->setEmail($result['email']);
            }
            if(isset($result['verified_email']) && $result['verified_email']) {
                $Users->setEmailConfirmation(1);
            }
            if(!empty($result['id'])) {
                $Users->setGoogleUserId($result['id']);
            }
            if(!empty($result['given_name'])) {
                $Users->setFirstName($result['given_name']);
            }
            if(!empty($result['family_name'])) {
                $Users->setLastName($result['family_name']);
            }
            $Users->setIpAddress($_SERVER["HTTP_X_FORWARDED_FOR"]);
            return $Users;
        }
    }
}