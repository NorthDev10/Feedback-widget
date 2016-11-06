<?php
defined('CONTACT_DETAILS') or die('Access denied');

abstract class ContactDetailsDB {
  
  private static $numberContacts;
    
  protected function countContacts() {
      if(!self::$numberContacts) {
          $sqlCode = "SELECT COUNT(CD.contactID)";
          $sqlCode .= ' FROM contactDetails AS CD, tableApiKeys AS tAK';
          $sqlCode .= " WHERE tAK.userId = '%d'";
          $sqlCode .= " AND tAK.apiKeyId = CD.apiKeyId";
          $sqlCode = sprintf($sqlCode, $this->getUserId());
          if($result = $this->mysqli->query($sqlCode)) {
              self::$numberContacts = $result->fetch_row()[0];
          }
      }
      return self::$numberContacts;
  }  
    
  public function addContacts() {
    $sqlCode = "INSERT INTO contactDetails (
      apiKeyId,
      title,
      url,
      phoneNumber,
      customerName,
      userEmail,
      userQuestions,
      dateAdded
    )";
    $sqlCode .= "VALUES (
      (SELECT apiKeyId FROM tableApiKeys WHERE apiKey = '%s' AND domain = '%s'),
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s'
    )";
    $sqlCode = sprintf(
      $sqlCode,
      $this->mysqli->real_escape_string($this->getApiKey()),
      $this->mysqli->real_escape_string($this->getOrigin()),
      $this->mysqli->real_escape_string($this->getTitle()),
      $this->mysqli->real_escape_string($this->getUrl()),
      $this->mysqli->real_escape_string($this->getPhoneNumber()),
      $this->mysqli->real_escape_string($this->getCustomerName()),
      $this->mysqli->real_escape_string($this->getUserEmail()),
      $this->mysqli->real_escape_string($this->getUserQuestions()),
      date("Y-m-d H:i:s")
    );
    if($this->mysqli->query($sqlCode)) {
      return true;
    }
  }
  
  protected function questionSolved() {
    if(($this->getUserId() == $_SESSION['userId'])
          || ($_SESSION['myRights'] & RIGHT_WRITE_ALL_DATA)) {
      $sqlCode = "UPDATE contactDetails SET processingStatus = '%d'";
      $sqlCode .= " WHERE contactID = '%d' AND";
      $sqlCode .= " apiKeyId = (
        SELECT apiKeyId
        FROM tableApiKeys 
        WHERE apiKeyId = '%d' AND userId = '%d'
      )";
      $sqlCode = sprintf(
        $sqlCode,
        $this->getProcessingStatus(),
        $this->getContactID(),
        $this->getApiKeyId(),
        $this->getUserId()
      );
      if($this->mysqli->query($sqlCode)) {
        return true;
      }
    }
  }
  
  protected function fetchALLMyContacts($currentPage=1, $numberContacts=10) {
    if(($this->getUserId() == $_SESSION['userId'])
       || ($_SESSION['myRights'] & RIGHT_WRITE_ALL_DATA)) {
      $sqlCode = 'SELECT CD.*';
      $sqlCode .= ' FROM contactDetails AS CD, tableApiKeys AS tAK';
      $sqlCode .= " WHERE tAK.userId = '%d'";
      $sqlCode .= " AND tAK.apiKeyId = CD.apiKeyId";
      $sqlCode .= ' ORDER BY dateAdded DESC LIMIT %d, %d';
      $page = ($currentPage-1) * $numberContacts;
      $sqlCode = sprintf(
        $sqlCode,
        $this->getUserId(),
        $page,
        $numberContacts
      );
      if($result = $this->mysqli->query($sqlCode)) {
        $records = array();
        while ($row = $result->fetch_assoc()) {
          $temp = new $this();
          $temp->setOptions($row);
          $records[] = $temp;
        }
        $result->close();
        return $records;
      }
    }
  }
  
  protected function setOptions(array $options) {
    $methods = get_class_methods($this);
    foreach($options as $key => $value) {
      $method = 'set'.ucfirst($key);
      if(in_array($method, $methods)) {
        $this->$method($value);
      }
    }
  }
}