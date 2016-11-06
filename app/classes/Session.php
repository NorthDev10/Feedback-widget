<?php
defined('CONTACT_DETAILS') or die('Access denied');

class Session {
    
    public static function startSession($isUserActivity = true) {
        if (session_id()) {
            return self::lastActivity($isUserActivity);
        } else {
            if(session_start()) {
                if(SESSION_LIFETIME && $isUserActivity) {
                    if(isset($_SESSION['lastActivity'])) {
                        return self::lastActivity($isUserActivity);
                    } else {
                        $t = time();
                        $_SESSION['lastActivity'] = $t;
                    }
                }
                return true;
            }
        }
    }
    
    protected static function lastActivity($isUserActivity) {
        if(SESSION_LIFETIME) {
            $t = time();
            if(isset($_SESSION['lastActivity']) && ($t-$_SESSION['lastActivity'] >= SESSION_LIFETIME)) {
                self::destroySession();
                return false;
            } else {
                if ($isUserActivity) {
                    $_SESSION['lastActivity'] = $t;
                }
            }
        }
        return true;
    }
    
    public static function destroySession() {
        if(session_id()) {
        	session_unset();
        	setcookie(session_name(), session_id(), time()-60*60*24);
        	session_destroy();
        }
    }
}