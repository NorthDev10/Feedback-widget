<?php
defined('CONTACT_DETAILS') or die('Access denied');

require_once ABSTRACTCLASS . '/ContactDetailsDB.php';

class ContactDetails extends ContactDetailsDB {
  
  protected $mysqli;
  private $userId;
  private $contactID;
  private $apiKey;
  private $apiKeyId;
  private $title;
  private $origin;
  private $url;
  private $phoneNumber;
  private $customerName;
  private $userEmail;
  private $userQuestions;
  private $processingStatus;
  private $dateAdded;
  
  public function __construct() {
    $db = DataBase::getDBObj();
    $this->mysqli = $db->getConnection();
  }
  
  public function countContacts() {
    if(!$this->getUserId()) {
      $this->setUserId($_SESSION['userId']);
    }
    return parent::countContacts();
  }
  
  public function questionSolved() {
    if($this->getContactID() && $this->getApiKeyId()) {
      if(!$this->getUserId()) {
        $this->setUserId($_SESSION['userId']);
      }
      return parent::questionSolved();
    }
  }
  
  public function fetchALLMyContacts($currentPage=1, $numberContacts=10) {
    if(!is_numeric($currentPage) || !is_numeric($numberContacts) || ($numberContacts < 0)) {
      $currentPage = 1;
      $numberContacts = 10;
    }
    $contacts['countPages'] = ceil($this->countContacts() / $numberContacts);
    if($contacts['countPages'] > 0) {
      if(!$this->getUserId()) {
        $this->setUserId($_SESSION['userId']);
      }
      $obj = parent::fetchALLMyContacts($currentPage, $numberContacts);
      for($i = 0; $i < count($obj); $i++) {
        $contacts['contacts'][$i]['contactID'] = $obj[$i]->getContactID();
        $contacts['contacts'][$i]['apiKeyId'] = $obj[$i]->getApiKeyId();
        $contacts['contacts'][$i]['title'] = $obj[$i]->getTitle();
        $contacts['contacts'][$i]['url'] = $obj[$i]->getUrl();
        $contacts['contacts'][$i]['phoneNumber'] = $obj[$i]->getPhoneNumber();
        $contacts['contacts'][$i]['customerName'] = $obj[$i]->getCustomerName();
        $contacts['contacts'][$i]['userEmail'] = $obj[$i]->getUserEmail();
        $contacts['contacts'][$i]['userQuestions'] = $obj[$i]->getUserQuestions();
        $contacts['contacts'][$i]['processingStatus'] = $obj[$i]->getProcessingStatus();
        $contacts['contacts'][$i]['dateAdded'] = $obj[$i]->getDateAdded();
      }
      return $contacts;
    }
  }
  
  public function getUserId() {
    return $this->userId;
  }
  
  public function setUserId($userId) {
    if(is_numeric($userId) && ($userId > 0)) {
      $this->userId = trim($userId);
    }
  }
  
  public function getContactID() {
    return $this->contactID;
  }
  
  public function setContactID($contactID) {
    if(is_numeric($contactID) && $contactID > 0) {
      $this->contactID = trim($contactID);
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
  
  public function getApiKeyId() {
    return $this->apiKeyId;
  }
  
  public function setApiKeyId($apiKeyId) {
    if(is_numeric($apiKeyId) && $apiKeyId > 0) {
        $this->apiKeyId = trim($apiKeyId);
    }
  }
  
  public function getTitle() {
    return htmlentities($this->title, ENT_QUOTES);
  }
  
  public function setTitle($title) {
    $this->title = $title;
  }
  
  public function getUrl() {
    return htmlentities($this->url, ENT_QUOTES);
  }
  
  public function setUrl($url) {
    $this->url = $url;
  }
  
  public function getOrigin() {
    return htmlentities($this->origin, ENT_QUOTES);
  }
  
  public function setOrigin($origin) {
    $this->origin = trim(parse_url($origin, PHP_URL_HOST));
    if(empty($this->origin)) {
        $this->origin = trim($origin);
    }
  }
  
  public function getPhoneNumber() {
    return htmlentities($this->phoneNumber, ENT_QUOTES);
  }
  
  public function setPhoneNumber($phoneNumber) {
    $this->phoneNumber = trim($phoneNumber);
  }
  
  public function getCustomerName() {
    return htmlentities($this->customerName, ENT_QUOTES);
  }
  
  public function setCustomerName($customerName) {
    $this->customerName = trim($customerName);
  }
  
  public function getUserEmail() {
    return htmlentities($this->userEmail, ENT_QUOTES);
  }
  
  public function setUserEmail($userEmail) {
    if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
      $this->userEmail = $userEmail;
      return true;
    }
  }
  
  public function getUserQuestions() {
    return htmlentities($this->userQuestions, ENT_QUOTES);
  }
  
  public function setUserQuestions($userQuestions) {
    $this->userQuestions = trim($userQuestions);
  }
  
  public function getProcessingStatus() {
    return $this->processingStatus;
  }
  
  public function setProcessingStatus($processingStatus) {
    if(is_numeric($processingStatus)) {
      $this->processingStatus = trim($processingStatus);
    }
  }
  
  public function getDateAdded() {
    return $this->dateAdded;
  }
  
  public function setDateAdded($dateAdded) {
    $this->dateAdded = $dateAdded;
  }
}