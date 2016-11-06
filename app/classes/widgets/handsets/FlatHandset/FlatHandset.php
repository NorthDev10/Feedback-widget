<?php
defined('CONTACT_DETAILS') or die('Access denied');

class FlatHandset {
  private $btnType;
  private $delayedBtn;
  private $positionID;
  private $position;
  private $colorRing;
  private $colorTube;
  private $soundBtn;
    
  public function __construct() {
    $this->btnType = 0;
    $this->delayedBtn = 5;
    $this->position = array("","50px","40px","");
    $this->positionID = 5;
    $this->colorRing = '#00c853';
    $this->colorTube = '#00c853';
    $this->soundBtn = 1;
  }
    
  public function getBtnType() {
    return $this->btnType;
  }

  public function getDelayedBtn() {
    return $this->delayedBtn;
  }

  public function setDelayedBtn($delayedBtn) {
    if(is_numeric($delayedBtn) && ($delayedBtn >= 0)) {
      $this->delayedBtn = trim($delayedBtn);
    }
  }
  
  public function setPositionID($positionID) {
    if(is_numeric($positionID) && ($positionID >= 0)) {
      $this->positionID = trim($positionID);
    }
  }
  
  public function getPositionID() {
    return $this->positionID;
  }

  public function getPosition() {
    return $this->position;
  }

  protected function checkPosition(array $position) {
    if(count($position) == 4) {
      for($i = 0; $i < 4; $i++) {
        $position[$i] = trim($position[$i]);
        if(!preg_match('/^(\d*\.?\d+)\s?(px|em|ex|%|in|cn|mm|pt|pc+)$/i', $position[$i]) &&
            !empty($position[$i])) {
          return false;
        }
      }
      return true;
    }
  }
  
  public function setPosition($position) {
    if(is_array($position) && $this->checkPosition($position)) {
      $this->position = $position;
    } elseif(!is_array($position)) {
      $arr = json_decode(trim($position), true);
      if(is_array($arr) && $this->checkPosition($arr)) {
        $this->position = $arr;
      }
    }
  }

  public function getColorRing() {
    return $this->colorRing;
  }

  protected function checkColorHex(&$color) {
    $color = strtoupper($color);
    if(preg_match('/^(\#[\dA-F]{6}|[\dA-F]{3})$/i', $color)) {
      return true;
    }
  }

  public function setColorRing($colorRing) {
    $colorRing = trim($colorRing);
    if($this->checkColorHex($colorRing)) {
      $this->colorRing = $colorRing; 
    }
  }

  public function getColorTube(){
    return $this->colorTube;
  }

  public function setColorTube($colorTube) {
    $colorTube = trim($colorTube);
    if($this->checkColorHex($colorTube)) {
      $this->colorTube = $colorTube; 
    }
  }

  public function getSoundBtn() {
    return $this->soundBtn;
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

  public function setSoundBtn($soundBtn) {
    $soundBtn = $this->convStrToBool($soundBtn);
    if(($soundBtn == 0) || ($soundBtn == 1)) {
      $this->soundBtn = $soundBtn;
    }
  }
  
  public function fillingObjFlatHandset(array $array) {
    $this->setDelayedBtn($array['delayedBtn']);
    $this->setPositionID($array['positionID']);
    $this->setPosition($array['position']);
    $this->setColorRing($array['colorRing']);
    $this->setColorTube($array['colorTube']);
    $this->setSoundBtn($array['soundBtn']);
  }
  
  public function getJSCode() {
    require_once VIEW.'widgets/FlatHandset/jsFileGen.php';
  }
  
  public function configureWidget() {
    require_once VIEW.'widgets/FlatHandset/pageSettings.php';
  }
  
  public function toArray() {
    return array(
      'btnType' => $this->getBtnType(),
      'delayedBtn' => $this->getDelayedBtn(),
      'positionID' => $this->getPositionID(),
      'position' => $this->getPosition(),
      'colorRing' => $this->getColorRing(),
      'colorTube' => $this->getColorTube(),
      'soundBtn' => $this->getSoundBtn()
    );
  }
}