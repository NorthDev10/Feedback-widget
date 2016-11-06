<?php
defined('CONTACT_DETAILS') or die('Access denied');
?>
<script>
window.addEventListener('load', function() {
$('#FHColorRing').colorpicker({format:'hex'});
$('#FHColorRing').colorpicker().on('changeColor.colorpicker', function(event){
  $("#flatHandset  path:nth-child(1)").attr('fill', event.color.toHex());
});
$('#colorHandset').colorpicker({format:'hex'});
$('#colorHandset').colorpicker().on('changeColor.colorpicker', function(event){
  $("#flatHandset  path:nth-child(2)").attr('fill', event.color.toHex());
});
$('#FHtopInset').change(function(){
  $("#flatHandset").css('top',$(this).val());
});
$('#FHrightInset').change(function(){
  $("#flatHandset").css('right',$(this).val());
});
$('#FHbottomInset').change(function(){
  $("#flatHandset").css('bottom',$(this).val());
});
$('#FHleftInset').change(function(){
  $("#flatHandset").css('left',$(this).val());
});

$('#FHbtnPos').on('changed.bs.select', function () {
  switch ($(this).val()) {
    case '0':
      $('#FHtopInset').val('40px');
      $('#FHrightInset').val('');
      $('#FHbottomInset').val('');
      $('#FHleftInset').val('50px');
    break;
    case '1':
      $('#FHtopInset').val('40px');
      $('#FHrightInset').val('');
      $('#FHbottomInset').val('');
      $('#FHleftInset').val('50%');
    break;
    case '2':
      $('#FHtopInset').val('40px');
      $('#FHrightInset').val('50px');
      $('#FHbottomInset').val('');
      $('#FHleftInset').val('');
    break;
    case '3':
      $('#FHtopInset').val('');
      $('#FHrightInset').val('');
      $('#FHbottomInset').val('40px');
      $('#FHleftInset').val('50px');
    break;
    case '4':
      $('#FHtopInset').val('');
      $('#FHrightInset').val('');
      $('#FHbottomInset').val('40px');
      $('#FHleftInset').val('50%');
    break;
    case '5':
      $('#FHtopInset').val('');
      $('#FHrightInset').val('50px');
      $('#FHbottomInset').val('40px');
      $('#FHleftInset').val('');
    break;
  }
  $("#flatHandset").css({
    'top':$('#FHtopInset').val(),
    'right':$('#FHrightInset').val(),
    'bottom':$('#FHbottomInset').val(),
    'left':$('#FHleftInset').val()
  });
});
}, false);
</script>
<div class="row">
  <div class="col-sm-6">
    Задержка показа:
    <input id="delayDisplayBtn" class="form-control" type="text" value="<?php echo $this->getDelayedBtn();?>">
  </div>
  <div class="col-sm-6">
    Позиция кнопки:
    <select id="FHbtnPos" class="selectpicker" data-width="125px">
      <option value="0"<?php
        if($this->getPositionID() == 0) {
          echo 'selected';
        }
      ?>>Вверху слева</option>
      <option value="1"<?php
        if($this->getPositionID() == 1) {
          echo 'selected';
        }
      ?>>Вверху по центру</option>
      <option value="2"<?php
        if($this->getPositionID() == 2) {
          echo 'selected';
        }
      ?>>Вверху справа</option>
      <option value="3"<?php
        if($this->getPositionID() == 3) {
          echo 'selected';
        }
      ?>>Внизу слева</option>
      <option value="4"<?php
        if($this->getPositionID() == 4) {
          echo 'selected';
        }
      ?>>Внизу по центру</option>
      <option value="5"<?php
        if($this->getPositionID() == 5) {
          echo 'selected';
        }
      ?>>Внизу справа</option>
    </select>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    Отступ сверху:
    <input id="FHtopInset" class="form-control" type="text" value="<?php echo $this->getPosition()[0]; ?>">
  </div>
  <div class="col-sm-6">
    Отступ справа:
    <input id="FHrightInset" class="form-control" type="text" value="<?php echo $this->getPosition()[1]; ?>">
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    Отступ снизу:
    <input id="FHbottomInset" class="form-control" type="text" value="<?php echo $this->getPosition()[2]; ?>">
  </div>
  <div class="col-sm-6">
    Отступ слева:
    <input id="FHleftInset" class="form-control" type="text" value="<?php echo $this->getPosition()[3]; ?>">
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    Цвет кольца:
    <div id="FHColorRing" class="input-group">
      <input type="text" value="<?php echo $this->getColorRing();?>" class="form-control" />
      <span class="input-group-addon"><i></i></span>
    </div>
    <a onClick="$('#FHColorRing').colorpicker('setValue','#00c853');" href="#">Сбросить цвет</a>
  </div>
  <div class="col-sm-6">
    Цвет трубки:
    <div id="colorHandset" class="input-group">
      <input type="text" value="<?php echo $this->getColorTube();?>" class="form-control" />
      <span class="input-group-addon"><i></i></span>
    </div>
    <a onClick="$('#colorHandset').colorpicker('setValue','#00c853');" href="#">Сбросить цвет</a>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <div class="checkbox checkbox-success">
      <input id="soundShowBtn" <?php if($this->getSoundBtn()) echo 'checked'; ?> type="checkbox">
      <label for="soundShowBtn">
        Звук при первом появлении кнопки
      </label>
    </div>
  </div>
</div>