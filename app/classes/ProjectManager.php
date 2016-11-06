<?php
defined('CONTACT_DETAILS') or die('Access denied');

require_once ABSTRACTCLASS . '/ProjectManagerDB.php';
require_once CLASSES.'/widgets/handsets/FlatHandset/FlatHandset.php';
require_once CLASSES.'/widgets/windows/OnlyPhoneNumber/OnlyPhoneNumber.php';

class ProjectManager extends ProjectManagerDB {

    protected $mysqli;
    // свойства из таблицы tableApiKeys
    private $userId;
    private $apiKeyId;
    private $apiKey;
    private $domain;
    private $managerPhone;
    private $dateRegistration;
    private $timeZone;
    private $daylightSavingTime;
    private $timeZoneId;
    private $workingDays;
    private $widgetSettings;

    public function __construct() {
        $db = DataBase::getDBObj();
        $this->mysqli = $db->getConnection();
        $this->timeZone = 3;
        $this->daylightSavingTime = 0;
        $this->timeZoneId = 'tZ32';
        $this->workingDays = [
            [1,"09:30","20:00"],
            [1,"09:30","20:00"],
            [1,"09:30","20:00"],
            [1,"09:30","20:00"],
            [1,"09:30","20:00"],
            [0,"09:30","20:00"],
            [0,"09:30","20:00"]
        ];
    }
    
    public function fetchBase($currentPage=1, $number=10) {
        if(!is_numeric($currentPage) || !is_numeric($number) || ($number < 0)) {
            $currentPage = 1;
            $number = 10;
        }
        $projects['countPages'] = ceil($this->countProjects() / $number);
        if($projects['countPages'] > 0) {
            $obj = parent::fetchAll($currentPage, $number);
            for($i = 0; $i < count($obj); $i++) {
                $projects['projects'][$i]['userId'] = $obj[$i]->getUserId();
                $projects['projects'][$i]['apiKeyId'] = $obj[$i]->getApiKeyId();
                $projects['projects'][$i]['apiKey'] = $obj[$i]->getApiKey();
                $projects['projects'][$i]['domain'] = $obj[$i]->getDomain();
                $projects['projects'][$i]['managerPhone'] = $obj[$i]->getManagerPhone();
                $projects['projects'][$i]['dateRegistration'] = $obj[$i]->getDateRegistration();
            }
            return $projects;
        } else {
            if($this->getUserId() == $_SESSION['userId']) {
                return array('error'=>'Добавьте свой проект');
            } else {
                return array('error'=>'Пользователь ещё не добавил проект');
            }
        }
    }
    
    public function save() {
        if(!empty($this->getDomain()) && !empty($this->getManagerPhone())) {
            return parent::save();
        }
    }
    
    public function delete() {
        if(!empty($this->getUserId()) && !empty($this->getApiKeyId())) {
            if(parent::delete() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    public function createNewProject(Users $users) {
        if(!empty($this->getDomain()) && !empty($this->getManagerPhone())) {
            return parent::createNewProject($users);
        }
    }
    
    public function fetchById() {
        if(!empty($this->getApiKeyId())) {
            return parent::fetchById();
        }
    }
    
    public function fetchByApiKey() {
        if(!empty($this->getApiKey())) {
            return parent::fetchByApiKey();
        }
    }
    
    public function getUserId() {
        if(empty($this->userId)) {
            return $_SESSION['userId'];
        }
        return $this->userId;
    }

    public function setUserId($userId) {
        if(is_numeric($userId) && $userId > 0) {
            $this->userId = trim($userId);
        }
    }

    public function getApiKeyId() {
        return $this->apiKeyId;
    }

    public function setApiKeyId($apiKeyId) {
        if(is_numeric($apiKeyId) && $apiKeyId > 0) {
            $this->apiKeyId = trim($apiKeyId);
        }
    }

    public function getApiKey() {
        return $this->apiKey;
    }

    public function setApiKey($apiKey) {
        $apiKey = trim($apiKey);
        if(strlen($apiKey) == 32) {
            $this->apiKey = $apiKey;
        }
    }

    public function getDomain() {
        return htmlentities($this->domain, ENT_QUOTES);
    }

    public function setDomain($domain) {
        $this->domain = trim(parse_url($domain, PHP_URL_HOST));
        if(empty($this->domain)) {
            $this->domain = trim($domain);
        }
    }
    
    public function getManagerPhone() {
        return htmlentities($this->managerPhone, ENT_QUOTES);
    }

    public function setManagerPhone($managerPhone) {
        $this->managerPhone = trim($managerPhone);
    }

    public function getDateRegistration() {
        return $this->dateRegistration;
    }
    
    public function setDateRegistration($dateRegistration) {
        $this->dateRegistration = $dateRegistration;
    }
    
    public function getTimeZone() {
        return htmlentities($this->timeZone, ENT_QUOTES);
    }
    
    public function setTimeZone($timeZone) {
        if(is_numeric($timeZone)) {
            $this->timeZone = trim($timeZone);
        }
    }
    
    public function getDaylightSavingTime() {
        return $this->daylightSavingTime;
    }
    
    public function setDaylightSavingTime($daylightSavingTime) {
        $daylightSavingTime = $this->convStrToBool($daylightSavingTime);
        if($daylightSavingTime == 1) {
            $this->daylightSavingTime = $daylightSavingTime;
        }
    }
    
    public function getTimeZoneId() {
        return htmlentities($this->timeZoneId, ENT_QUOTES);
    }
    
    public function setTimeZoneId($timeZone) {
        $this->timeZoneId = trim($timeZone);
    }
    
    public function getWorkingDays() {
        return $this->workingDays;
    }
    
    protected function convStrToBool($val) {
        switch((string)$val) {
            case "true":
                return 1;
            break;
            case "false":
                return 0;
            break;
            default:
                return $val;
        }
    }
    
    protected function checkWorkingDays(array &$workingDays) {
        if(count($workingDays) == 7) {
            for($i = 0; $i < 7; $i++) {
                $workingDays[$i][0] = $this->convStrToBool($workingDays[$i][0]);
                if(!in_array($workingDays[$i][0], array(1, 0))) {
                    return false;
                }
                $workingDays[$i][1] = trim($workingDays[$i][1]);
                $workingDays[$i][2] = trim($workingDays[$i][2]);
                if(!(preg_match('/(([0|1]\d|2[0-3]):[0-5]\d)/', $workingDays[$i][1]) &&
                    preg_match('/(([0|1]\d|2[0-3]):[0-5]\d)/', $workingDays[$i][2]))) {
                    return false;
                }
            }
            return true;
        }
    }
    
    public function setWorkingDays($workingDays) {
        if(is_array($workingDays) && $this->checkWorkingDays($workingDays)) {
            $this->workingDays = $workingDays;
        } elseif(!is_array($workingDays)) {
            $arr = json_decode($workingDays, true);
            if(is_array($arr) && $this->checkWorkingDays($arr)) {
                $this->workingDays = $arr;
            }
        }
    }
    
    public function getWidgetSettings() {
        return $this->widgetSettings;
    }

    public function setWidgetSettings($widgetSettings) {
        if(!is_array($widgetSettings)) {
            $widgetSettings = json_decode(trim($widgetSettings), true);
        }
        if(is_array($widgetSettings)) {
            $Handset = $this->getObjHandset($widgetSettings);
            $Window = $this->getObjWindow($widgetSettings);
            if(is_object($Handset) && is_object($Window)) {
                $this->widgetSettings[0] = $Handset;
                $this->widgetSettings[1] = $Window;
            }
        }
    }

    public function getWorkingDaysJSON() {
        return $this->widgetSettingsJSON = json_encode($this->workingDays);
    }
    
    public function getWidgetSettingsJSON() {
        return json_encode(
            array(
                $this->widgetSettings[0]->toArray(),
                $this->widgetSettings[1]->toArray()
            )
        );
    }
    
    public function generateWidgetJSFile() {
        if(is_object($this->widgetSettings[0]) &&
                is_object($this->widgetSettings[1])) {
            $this->widgetSettings[0]->getJSCode();
            $this->widgetSettings[1]->getJSCode();
            require_once VIEW.'widgets/MainJSFileGen.php';
        }
    }
    
    public function generateWidgetJSFileMIN($FilePath = true) {
        $params = array(
            'output_format' => 'json',
            'output_info' => 'compiled_code',
            'output_info' => 'warnings',
            'output_info' => 'errors',
            'output_info' => 'statistics',
            'compilation_level' => 'ADVANCED_OPTIMIZATIONS',
            'warning_level' => 'verbose',
            'output_file_name' => 'default.js',
            'code_url' => urlencode(SITE_PROTOCOL.'://'.DOMAIN_SITE.'/gen-widget-js/'.$this->getApiKey().'.js'),
            'js_code' => ''
        );
        $outputFilePath = HttpRequest::post('http://closure-compiler.appspot.com/compile', $params, true);
        if(isset($outputFilePath['outputFilePath'])) {
            if($FilePath) {
                return 'http://closure-compiler.appspot.com/'.$outputFilePath['outputFilePath'];
            } else {
                $outputFile = HttpRequest::get('http://closure-compiler.appspot.com/'.$outputFilePath['outputFilePath']);
                if($outputFile['status'] == 200) {
                    return '<script>'.$outputFile[0].'</script>';
                }
            }
        }
    }
    
    protected function getObjHandset(array $widgetSettings) {
        switch($widgetSettings[0]['btnType']) {
            case 0:
                $FlatHandset = new FlatHandset();
                $FlatHandset->fillingObjFlatHandset($widgetSettings[0]);
                return $FlatHandset;
            break;
        }
    }
    
    protected function getObjWindow(array $widgetSettings) {
        switch($widgetSettings[1]['winType']) {
            case 0:
                $OnlyPhoneNumber = new OnlyPhoneNumber();
                $OnlyPhoneNumber->fillingObjOnlyPhoneNumber($widgetSettings[1], $this);
                return $OnlyPhoneNumber;
            break;
        }
    }
    
    public function defaultWidget() {
        $this->widgetSettings[0] = new FlatHandset();
        $this->widgetSettings[1] = new OnlyPhoneNumber();
    }
}