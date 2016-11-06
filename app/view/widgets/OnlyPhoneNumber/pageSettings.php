<?php
defined('CONTACT_DETAILS') or die('Access denied');
?>
<script>
window.addEventListener('load', function() {
  $('#OPNBgColor').colorpicker({format:'rgba'});
$('#OPNBgColor').colorpicker().on('changeColor.colorpicker', function(event){
  $("#formFillCD").css('background-color', event.color);
});
$('#OPNcolorCross').colorpicker({format:'hex'});
$('#OPNcolorCross').colorpicker().on('changeColor.colorpicker', function(event){
  OnlyPhoneNumber.updateCssCross(event.color.toHex());
  WidgetSettings.applyStyles();
});
$('#OPNfontColor').colorpicker({format:'hex'});
$('#OPNfontColor').colorpicker().on('changeColor.colorpicker', function(event){
  $("#formFillCD h3").css('color', event.color.toHex());
  $("#formFillCD h4").css('color', event.color.toHex());
  $("#formFillCD input").css('color', event.color.toHex());
  $("#formFillCD p a").css('color', event.color.toHex());
  $("#formFillCD strong").css('color', event.color.toHex());
  OnlyPhoneNumber.updateCssPlaceholder(event.color.toHex());
  WidgetSettings.applyStyles();
});
$('#OPNbtnSendColor').colorpicker({format:'hex'});
$('#OPNbtnSendColor').colorpicker().on('changeColor.colorpicker', function(event){
  OnlyPhoneNumber.updateCssBtn(event.color.toHex());
  WidgetSettings.applyStyles();
});
 $('#OPNPlaceholder input').change(function(){
  $("#formFillCD input").attr('placeholder', $(this).val());
});
}, false);
</script>
<div class="panel-body">
  <div class="row">
    <div class="col-sm-12">
      Тип окна:
      <select id="modalWinType" class="selectpicker" data-width="100%">
        <option value="0">Только номер</option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      Цвет фона:
      <div id="OPNBgColor" class="input-group">
        <input type="text" value="<?php echo $this->getBgColor();?>" class="form-control" />
        <span class="input-group-addon"><i></i></span>
      </div>
      <a onClick="$('#OPNBgColor').colorpicker('setValue','rgba(9,121,136,0.901961)');" href="#">Сбросить цвет</a>
    </div>
    <div class="col-sm-6">
       Цвет шрифта:
      <div id="OPNfontColor" class="input-group btnColor">
        <input type="text" value="<?php echo $this->getFontColor();?>" class="form-control" />
        <span class="input-group-addon"><i></i></span>
      </div>
      <a onClick="$('#OPNfontColor').colorpicker('setValue','#FFFFFF');" href="#">Сбросить цвет</a>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      Цвет крестика:
      <div id="OPNcolorCross" class="input-group btnColor">
        <input type="text" value="<?php echo $this->getColorCross();?>" class="form-control" />
        <span class="input-group-addon"><i></i></span>
      </div>
      <a onClick="$('#OPNcolorCross').colorpicker('setValue','#FFFFFF');" href="#">Сбросить цвет</a>
    </div>
    <div class="col-sm-6">
       Цвет кнопки:
      <div id="OPNbtnSendColor" class="input-group">
        <input type="text" value="<?php echo $this->getColorBtn()[0];?>" class="form-control">
        <span class="input-group-addon"><i></i></span>
      </div>
      <div id="OPNbtnSendColorOther">
        <input type="hidden" value="<?php echo $this->getColorBtn()[1];?>" class="form-control">
        <input type="hidden" value="<?php echo $this->getColorBtn()[2];?>" class="form-control">
        <input type="hidden" value="<?php echo $this->getColorBtn()[3];?>" class="form-control">
      </div>
      <a onClick="$('#OPNbtnSendColor').colorpicker('setValue','#5CB85C');" href="#">Сбросить цвет</a>
    </div>
  </div>
  <div class="row">
    <div id="OPNPlaceholder" class="col-sm-12">
      Подсказывающий текст:
      <input type="text" value="<?php echo $this->getTextPrompts();?>" class="form-control" />
    </div>
  </div>
</div>