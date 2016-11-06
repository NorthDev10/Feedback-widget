<?php
defined('CONTACT_DETAILS') or die('Access denied');

require_once ABSTRACTCLASS . '/UserDB.php';

class Users extends UserDB {

    protected $mysqli;
    // свойства из таблицы users
    private $userId;
    private $userPwd;
    private $email;
    private $emailConfirmation;
    private $vkAccessToken;
    private $vkUserId;
    private $googleUserId;
    private $firstName;
    private $lastName;
    private $mobilePhone;
    private $homePhone;
    private $skype;
    private $siteURL;
    private $dateRegistration;
    private $dateLastEntry;
    private $ipAddress;
    private $groupId;
    private $groupName;
    private $rights;
    private $authorization;

    public function __construct() {
        $db = DataBase::getDBObj();
        $this->mysqli = $db->getConnection();
        $this->authorization = false;
        $this->emailConfirmation = 0;
    }

    public function login($email, $password) {
        if ($this->setEmail($email) && $this->fetchUserByEmail($password)) {
            $_SESSION['userId'] = $this->getUserId();
            $_SESSION['myRights'] = $this->getRights();
            return true;
        }
    }
    
    public function loginById() {
        if(isset($_SESSION['userId']) && $this->fetchUserById($_SESSION['userId'])) {
            $_SESSION['myRights'] = $this->getRights();
            $this->setAuthorization(true);
            return true;
        }
    }
    
    public function loginByVK() {
        if(!empty($this->getVkUserId())) {
            if($this->fetchUserByVKId()) {
                $_SESSION['userId'] = $this->getUserId();
                $_SESSION['myRights'] = $this->getRights();
                return true;
            }
        }
    }
    
    public function loginByGoogle() {
        if(!empty($this->getGoogleUserId())) {
            if($this->fetchUserByGoogleId()) {
                $_SESSION['userId'] = $this->getUserId();
                $_SESSION['myRights'] = $this->getRights();
                return true;
            }
        }
    }

    public function signUp() {
        if($this->createNewAccount()) {
            $_SESSION['userId'] = $this->getUserId();
            $_SESSION['myRights'] = $this->getRights();
            return true;
        }
    }
    
    public function genHhashForPassword($password) {
        if(mb_strlen($password,'UTF-8') > 5) {
            $this->userPwd = password_hash($password, PASSWORD_DEFAULT);
            return true;
        }
    }
    
    public function requestForPasswordRecovery($email) {
        if($this->setEmail($email)) {
            $hash = $this->getHashForRestorePassword();
            $to = $this->getEmail();
            $subject = 'Восстановление пароля на '.DOMAIN_SITE;
            $message = "Здравствуйте!\n\nДля восстановления пароля, вам необходимо перейти по ссылке:\n";
            $message .= 'https://'.DOMAIN_SITE.'/?q=forgot&uid='.$this->getUserId().'&key='.$hash;
            if($hash && mail($to, $subject, $message)) {
                return true;
            }
        }
    }
    
    public function requestForEmailConfirmation() {
        if(!$this->getEmailConfirmation()) {
            $hash = $this->getHashForEmailConfirmation();
            $to = $this->getEmail();
            $subject = 'Подтверждение адрес эл.почты на '.DOMAIN_SITE;
            $message = "Здравствуйте!\n\nДля подтверждения адрес эл.почты, вам необходимо перейти по ссылке:\n";
            $message .= 'https://'.DOMAIN_SITE.'/?q=activate-email&uid='.$this->getUserId().'&key='.$hash;
            if($hash && mail($to, $subject, $message)) {
                return true;
            }
        }
    }
    
    public function fetchAllUsers($currentPage = 1, $numberUsers = 10) {
        if($this->getRights() & RIGHT_READ_ALL_DATA) {
            if(!is_numeric($currentPage) || !is_numeric($numberUsers) || ($numberUsers < 0)) {
                $currentPage = 1;
                $numberUsers = 10;
            }
            $records = parent::fetchAllUsers($currentPage, $numberUsers);
            if($records) {
                $userList = array();
                foreach($records as $key=>$val) {
                    $userList['users'][$key]['userId'] = $val->getUserId();
                    $userList['users'][$key]['email'] = $val->getEmail();
                    $userList['users'][$key]['emailConfirmation'] = $val->getEmailConfirmation();
                    $userList['users'][$key]['firstName'] = $val->getFirstName();
                    $userList['users'][$key]['lastName'] = $val->getLastName();
                    $userList['users'][$key]['mobilePhone'] = $val->getMobilePhone();
                    $userList['users'][$key]['dateLastEntry'] = $val->getDateLastEntry();
                }
                $userList['countPages'] = ceil($this->countUsers() / $numberUsers);
                return $userList;
            }
        }
    }
    
    public function restorePassword($uid, $key) {
        if(is_numeric($uid) && !empty($key)) {
            return parent::restorePassword($uid, $key);
        }
    }
    
    public function emailConfirmation($uid, $key) {
        if(is_numeric($uid) && !empty($key)) {
            return parent::emailConfirmation($uid, $key);
        }
    }
    
    public function saveUserInfo(Users $object) {
        if($this->getRights() & (RIGHT_WRITE_MY_DATA | RIGHT_WRITE_ALL_DATA)) {
            return parent::saveUserInfo($object);
        }
    }
    
    public function getUserProfileById($uid) {
        if(($this->getRights() & RIGHT_READ_ALL_DATA) 
            && is_numeric($uid) && ($uid > 0)) {
            $userProfile = new $this();
            if($userProfile->fetchUserById($uid)) {
                return $userProfile;
            }
        }
    }

    public function getEmail() {
        return htmlentities($this->email, ENT_QUOTES);
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        if(is_numeric($userId) && ($userId > 0)) {
            $this->userId = trim($userId);
        }
    }

    public function getUserPwd() {
        return $this->userPwd;
    }

    public function setUserPwd($userPwd) {
        $this->userPwd = $userPwd;
    }

    public function getVkAccessToken() {
        return $this->vkAccessToken;
    }

    public function setVkAccessToken($vkAccessToken) {
        $this->vkAccessToken = $vkAccessToken;
    }
    
    public function getVkUserId() {
        return $this->vkUserId;
    }

    public function setVkUserId($vkUserId) {
        $this->vkUserId = $vkUserId;
    }

    public function getGoogleUserId() {
        return $this->googleUserId;
    }
    
    public function setGoogleUserId($googleUserId) {
        $this->googleUserId = $googleUserId;
    }

    public function getFirstName() {
        return  htmlentities($this->firstName, ENT_QUOTES);
    }

    public function setFirstName($firstName) {
        $this->firstName = trim($firstName);
    }

    public function getLastName() {
        return htmlentities($this->lastName, ENT_QUOTES);
    }

    public function setLastName($lastName) {
        $this->lastName = trim($lastName);
    }

    public function getMobilePhone() {
        return htmlentities($this->mobilePhone, ENT_QUOTES);
    }

    public function setMobilePhone($mobilePhone) {
        $this->mobilePhone = trim($mobilePhone);
    }

    public function getHomePhone() {
        return htmlentities($this->homePhone, ENT_QUOTES);
    }

    public function setHomePhone($homePhone) {
        $this->homePhone = trim($homePhone);
    }

    public function getSkype() {
        return htmlentities($this->skype, ENT_QUOTES);
    }

    public function setSkype($skype) {
        $this->skype = trim($skype);
    }
    
    public function getRights() {
        return $this->rights;
    }

    protected function setRights($rights) {
        $this->rights = $rights;
    }

    public function getSiteURL() {
        return htmlentities($this->siteURL, ENT_QUOTES);
    }

    public function setSiteURL($siteURL) {
        $this->siteURL = trim($siteURL);
    }
    
    public function getDateRegistration() {
        return $this->dateRegistration;
    }

    public function setDateRegistration($dateRegistration) {
        $this->dateRegistration = $dateRegistration;
    }

    public function getDateLastEntry() {
        return $this->dateLastEntry;
    }

    public function setDateLastEntry($dateLastEntry) {
        $this->dateLastEntry = $dateLastEntry;
    }

    public function getIpAddress() {
        return htmlentities($this->ipAddress, ENT_QUOTES);
    }

    public function setIpAddress($ipAddress) {
        $this->ipAddress = trim($ipAddress);
    }

    public function getGroupId() {
        return $this->groupId;
    }
    
    public function setGroupId($groupId) {
        if(is_numeric($groupId) && $groupId > 0) {
            $this->groupId = trim($groupId);
        }
    }
    
    public function getGroupName() {
        return $this->groupName;
    }
    
    public function setGroupName($groupName) {
        $this->groupName = $groupName;
    }

    public function setEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
            return true;
        }
    }
    
    public function getEmailConfirmation() {
        return $this->emailConfirmation;
    }

    public function setEmailConfirmation($status) {
        $this->emailConfirmation = $status;
    }

    public function getAuthorization() {
        return $this->authorization;
    }

    protected function setAuthorization($authorization) {
        if($authorization) {
            Session::startSession();
        }
        $this->authorization = $authorization;
    }
}