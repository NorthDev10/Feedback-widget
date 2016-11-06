<?php
defined('CONTACT_DETAILS') or die('Access denied');

class OnlyPhoneNumber {
  private $winType;
  private $bgColor;
  private $fontColor;
  private $colorCross;
  private $colorBtn;
  private $textPrompts;
  private $title;
  private $subtitle;
  private $btnText;
  private $inputError;
  private $ProjectInfo;
  
  public function __construct() {
    $this->winType = 0;
    $this->bgColor = 'rgba(9,121,136,0.901961)';
    $this->fontColor = '#ffffff';
    $this->colorCross = '#ffffff';
    // bg, bgh, bord, bordh
    $this->colorBtn = array('#5cb85c','#449d44','#4cae4c','#398439');
    $this->textPrompts = '+79261234567';
    $this->title = 'Закажите обратный звонок';
    $this->subtitle = 'Наш лучший специалист свяжется с вами в течении 30 секунд.';
    $this->btnText = 'ЖДУ ЗВОНКА';
    $this->inputError = 'Некорректно введен номер телефона';
  } 
  
  protected function checkColorHex(&$color) {
    $color = strtoupper($color);
    if(preg_match('/^(\#[\dA-F]{6}|[\dA-F]{3})$/i', $color)) {
      return true;
    }
  }
  
  protected function checkColorRGB($color) {
    if(preg_match('/^rgba\((\d{1,3}),\s?(\d{1,3}),\s?(\d{1,3}),\s?(\d?.?\d+)\)$/i', $color)) {
      return true;
    }
  }

  public function getWinType() {
    return $this->winType;
  }
  
  public function getBgColor() {
    return $this->bgColor;
  }
  
  public function getHexToRgb($hexColor) {
    if(strlen($hexColor) == 4) {
      return hexdec($hexColor[1].$hexColor[1]).','.hexdec($hexColor[2].$hexColor[2]).','.
      hexdec($hexColor[3].$hexColor[3]);
    } elseif(strlen($hexColor) == 7) {
      return hexdec($hexColor[1].$hexColor[2]).','.hexdec($hexColor[3].$hexColor[4]).','.
      hexdec($hexColor[5].$hexColor[6]);
    }
  }
  
  public function setBgColor($bgColor) {
    $bgColor = trim($bgColor);
    if($this->checkColorRGB($bgColor)) {
      $this->bgColor = $bgColor;
    }
  }
  
  public function getFontColor() {
    return $this->fontColor;
  }
  
  public function setFontColor($fontColor) {
    $fontColor = trim($fontColor);
    if($this->checkColorHex($fontColor)) {
      $this->fontColor = $fontColor;
    }
  }
  
  public function getColorCross() {
    return $this->colorCross;
  }
  
  public function setColorCross($colorCross) {
    $colorCross = trim($colorCross);
    if($this->checkColorHex($colorCross)) {
      $this->colorCross = $colorCross;
    }
  }
  
  public function getColorBtn() {
    return $this->colorBtn;
  }
  
  protected function checkColorBtn(array &$colorBtn) {
    if(count($colorBtn) == 4) {
      for($i = 0; $i < 3; $i++) {
        $colorBtn[$i] = trim($colorBtn[$i]);
        if(!$this->checkColorHex($colorBtn[$i])) {
          return false;
        }
      }
      return true;
    }
  }
  
  public function setColorBtn($colorBtn) {
    if(is_array($colorBtn) && $this->checkColorBtn($colorBtn)) {
      $this->colorBtn = $colorBtn;
    } elseif(!is_array($colorBtn)) {
      $arr = json_decode(trim($colorBtn), true);
      if(is_array($arr) && $this->checkColorBtn($arr)) {
        $this->colorBtn = $colorBtn;
      }
    }
  }
  
  public function getTextPrompts() {
    return $this->textPrompts;
  }
  
  public function setTextPrompts($textPrompts) {
    $this->textPrompts = strip_tags($textPrompts);
  }
  
  public function getTitle() {
    return $this->title;
  }
  
  public function setTitle($title) {
    $this->title = strip_tags($title);
  }
  
  public function getSubtitle() {
    return $this->subtitle;
  }
  
  public function setSubtitle($subtitle) {
    $this->subtitle = strip_tags($subtitle);
  }
  
  public function getBtnText() {
    return $this->btnText;
  }
  
  public function setBtnText($btnText) {
    $this->btnText = strip_tags($btnText);
  }
  
  public function getInputError() {
    return $this->inputError;
  }
  
  public function setInputError($inputError) {
    $this->inputError = strip_tags($inputError);
  }
  
  public function fillingObjOnlyPhoneNumber(array $array, ProjectManager $ProjectInfo) {
    $this->setBgColor($array['bgColor']);
    $this->setFontColor($array['fontColor']);
    $this->setColorCross($array['colorCross']);
    $this->setColorBtn($array['colorBtn']);
    $this->setTextPrompts($array['textPrompts']);
    $this->setTitle($array['title']);
    $this->setSubtitle($array['subtitle']);
    $this->setBtnText($array['btnText']);
    $this->setInputError($array['inputError']);
    $this->ProjectInfo = $ProjectInfo;
  }
  
  public function getJSCode() {
    require_once VIEW.'widgets/OnlyPhoneNumber/jsFileGen.php';
  }
  
  public function configureWidget() {
    require_once VIEW.'widgets/OnlyPhoneNumber/pageSettings.php';
  }
  
  public function toArray() {
    return array(
      'winType' => $this->getWinType(),
      'bgColor' => $this->getBgColor(),
      'fontColor' => $this->getFontColor(),
      'colorCross' => $this->getColorCross(),
      'colorBtn' => $this->getColorBtn(),
      'textPrompts' => $this->getTextPrompts(),
      'title' => $this->getTitle(),
      'subtitle' => $this->getSubtitle(),
      'btnText' => $this->getBtnText(),
      'inputError' => $this->getInputError()
    );
  }
}