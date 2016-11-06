<?php
defined( 'CONTACT_DETAILS') or die( 'Access denied');
require_once VIEW.'theme/headerCP.php';
?>
<link rel="stylesheet" href="/css/build.css">
<link rel="stylesheet" href="/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/bootstrap-select.min.css">
<link rel="stylesheet" href="/css/bootstrap-colorpicker.min.css">
<script src="/js/bootstrap-select.min.js" defer></script>
<script src="/js/bootstrap-colorpicker.min.js" defer></script>
<script src="/js/widgetSettings.js" defer></script>
<script src="/js/tinycolor.js" defer></script>
</head>
<body>
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">Project name</a>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="/control-panel/">Главная</a></li>
          <li><a href="/my-profile/">Мой аккаунт</a></li>
          <li><a href="/fetch-contacts/">Вопросы от посетителей</a></li>
          <?php
            if($_SESSION['myRights'] & RIGHT_READ_ALL_DATA) {
              echo '<li><a href="/list-all-users/">Все пользователи</a></li>';
            }
          ?>
          <li><a href="/logout">Выйти</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
          <li class="active"><a href="/control-panel/">Главная</a></li>
          <li><a href="/my-profile/">Мой аккаунт</a></li>
          <li><a href="/fetch-contacts/">Вопросы от посетителей</a></li>
          <?php
            if($_SESSION['myRights'] & RIGHT_READ_ALL_DATA) {
              echo '<li><a href="/list-all-users/">Все пользователи</a></li>';
            }
          ?>
        </ul>
      </div>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1 class="sub-header">Настройки виджета</h1>
        <div id="infoPanel"></div>
        <div id="mainContent">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs">
            <li class="active"><a href="#basicSettings" data-toggle="tab">Основные настройки</a></li>
            <li><a href="#decor" data-toggle="tab">Оформление</a></li>
            <li><a href="#getCode" data-toggle="tab">Получение кода</a></li>
          </ul>
      
          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane active" id="basicSettings">
              <div class="row">
                <div class="col-sm-6">
                  <label>Адрес сайта:</label>
                  <input id="websiteAddress" class="form-control" placeholder="http://example.com/" value="<?php echo $ProjectSettings->getDomain(); ?>">
                  <input id="projectID" type="hidden" value="<?php echo $ProjectSettings->getApiKeyId(); ?>">
                  <input id="userID" type="hidden" value="<?php echo $ProjectSettings->getUserId(); ?>">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3">
                  <label>Телефон менеджера:</label>
                  <input id="managerPhone" class="form-control" placeholder="+79261234567" value="<?php echo $ProjectSettings->getManagerPhone(); ?>">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <h3>Рабочее время</h3>
                  <label>Часовой пояс:</label>
                  <select id="timeZone" class="selectpicker" data-width="auto" data-size="5" data-live-search="true">
                    <option id="tZ-101" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-101'?'selected':''; ?> value="-10">(UTC-10:00) Гавайи</option>
                    <option id="tZ-91" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-91'?'selected':''; ?> value="-9">(UTC-09:00) Аляска</option>
                    <option id="tZ-81" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-81'?'selected':''; ?> value="-8">(UTC-08:00) Нижняя Калифорния</option>
                    <option id="tZ-82" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-82'?'selected':''; ?> value="-8">(UTC-08:00) Тихоокеанское время (США и Канада)</option>
                    <option id="tZ-71" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-71'?'selected':''; ?> value="-7">(UTC-07:00) Аризона</option>
                    <option id="tZ-72" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-72'?'selected':''; ?> value="-7">(UTC-07:00) Горное время (США и Канада)</option>
                    <option id="tZ-73" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-73'?'selected':''; ?> value="-7">(UTC-07:00) Ла-Пас, Мазатлан, Чихуахуа</option>
                    <option id="tZ-61" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-61'?'selected':''; ?> value="-6">(UTC-06:00) Гвадалахара, Мехико, Монтеррей</option>
                    <option id="tZ-62" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-62'?'selected':''; ?> value="-6">(UTC-06:00) Саскачеван</option>
                    <option id="tZ-63" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-63'?'selected':''; ?> value="-6">(UTC-06:00) Центральное время(США и Канада)</option>
                    <option id="tZ-51" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-51'?'selected':''; ?> value="-5">(UTC-05:00) Богота, Кито, Лима, Рио-Бранко</option>
                    <option id="tZ-52" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-52'?'selected':''; ?> value="-5">(UTC-05:00) Восточное время (США и Канада)</option>
                    <option id="tZ-53" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-53'?'selected':''; ?> value="-5">(UTC-05:00) Индиана (восток)</option>
                    <option id="tZ-54" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-54'?'selected':''; ?> value="-5">(UTC-05:00) Четумаль</option>
                    <option id="tZ-41" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-41'?'selected':''; ?> value="-4.5">(UTC-04:30) Каракас</option>
                    <option id="tZ-42" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-42'?'selected':''; ?> value="-4">(UTC-04:00) Асунсьон</option>
                    <option id="tZ-43" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-43'?'selected':''; ?> value="-4">(UTC-04:00) Атлантическое время (Канада)</option>
                    <option id="tZ-44" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-44'?'selected':''; ?> value="-4">(UTC-04:00) Джорджтаун, Ла-Пас, Манаус, Сан-Хуан</option>
                    <option id="tZ-45" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-45'?'selected':''; ?> value="-4">(UTC-04:00) Куяба</option>
                    <option id="tZ-31" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-31'?'selected':''; ?> value="-3.5">(UTC-03:30) Ньюфаундленд</option>
                    <option id="tZ-32" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-32'?'selected':''; ?> value="-3">(UTC-03:00) Бразилия</option>
                    <option id="tZ-33" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-33'?'selected':''; ?> value="-3">(UTC-03:00) Буэнос-Айрес</option>
                    <option id="tZ-34" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-34'?'selected':''; ?> value="-3">(UTC-03:00) Гренландия</option>
                    <option id="tZ-35" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-35'?'selected':''; ?> value="-3">(UTC-03:00) Кайенна, Форталеза</option>
                    <option id="tZ-36" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-36'?'selected':''; ?> value="-3">(UTC-03:00) Монтевидео</option>
                    <option id="tZ-37" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-37'?'selected':''; ?> value="-3">(UTC-03:00) Сальвадор</option>
                    <option id="tZ-38" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-38'?'selected':''; ?> value="-3">(UTC-03:00) Сантьяго</option>
                    <option id="tZ-21" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-21'?'selected':''; ?> value="-2">(UTC-02:00) Время в формате UTC-02</option>
                    <option id="tZ-11" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-11'?'selected':''; ?> value="-1">(UTC-01:00) Азорские о-ва</option>
                    <option id="tZ-12" <?php echo $ProjectSettings->getTimeZoneId()=='tZ-12'?'selected':''; ?> value="-1">(UTC-01:00) Кабо-Верде</option>
                    <option id="tZ01" <?php echo $ProjectSettings->getTimeZoneId()=='tZ01'?'selected':''; ?> value="0">(UTC) Дублин, Лиссабон, Лондон, Эдинбург</option>
                    <option id="tZ02" <?php echo $ProjectSettings->getTimeZoneId()=='tZ02'?'selected':''; ?> value="0">(UTC) Касабланка</option>
                    <option id="tZ03" <?php echo $ProjectSettings->getTimeZoneId()=='tZ03'?'selected':''; ?> value="0">(UTC) Монровия, Рейкьявик</option>
                    <option id="tZ11" <?php echo $ProjectSettings->getTimeZoneId()=='tZ11'?'selected':''; ?> value="1">(UTC+01:00) Амстердам, Берлин, Берн, Вена, Рим, Стокгольм</option>
                    <option id="tZ12" <?php echo $ProjectSettings->getTimeZoneId()=='tZ12'?'selected':''; ?> value="1">(UTC+01:00) Белград, Братислава, Будапешт, Любляна, Прага</option>
                    <option id="tZ13" <?php echo $ProjectSettings->getTimeZoneId()=='tZ13'?'selected':''; ?> value="1">(UTC+01:00) Брюссель, Копенгаген, Мадрид, Париж</option>
                    <option id="tZ14" <?php echo $ProjectSettings->getTimeZoneId()=='tZ14'?'selected':''; ?> value="1">(UTC+01:00) Варшава, Загреб, Сараево, Скопье</option>
                    <option id="tZ15" <?php echo $ProjectSettings->getTimeZoneId()=='tZ15'?'selected':''; ?> value="1">(UTC+01:00) Виндхук</option>
                    <option id="tZ16" <?php echo $ProjectSettings->getTimeZoneId()=='tZ16'?'selected':''; ?> value="1">(UTC+01:00) Западная Центральная Африка</option>
                    <option id="tZ21" <?php echo $ProjectSettings->getTimeZoneId()=='tZ21'?'selected':''; ?> value="2">(UTC+02:00) Амман</option>
                    <option id="tZ22" <?php echo $ProjectSettings->getTimeZoneId()=='tZ22'?'selected':''; ?> value="2">(UTC+02:00) Афины, Бухарест</option>
                    <option id="tZ23" <?php echo $ProjectSettings->getTimeZoneId()=='tZ23'?'selected':''; ?> value="2">(UTC+02:00) Бейрут</option>
                    <option id="tZ24" <?php echo $ProjectSettings->getTimeZoneId()=='tZ24'?'selected':''; ?> value="2">(UTC+02:00) Вильнюс, Киев, Рига, София, Таллин, Хельсинки</option>
                    <option id="tZ25" <?php echo $ProjectSettings->getTimeZoneId()=='tZ25'?'selected':''; ?> value="2">(UTC+02:00) Восточная Европа</option>
                    <option id="tZ26" <?php echo $ProjectSettings->getTimeZoneId()=='tZ26'?'selected':''; ?> value="2">(UTC+02:00) Дамаск</option>
                    <option id="tZ27" <?php echo $ProjectSettings->getTimeZoneId()=='tZ27'?'selected':''; ?> value="2">(UTC+02:00) Иерусалим</option>
                    <option id="tZ28" <?php echo $ProjectSettings->getTimeZoneId()=='tZ28'?'selected':''; ?> value="2">(UTC+02:00) Каир</option>
                    <option id="tZ29" <?php echo $ProjectSettings->getTimeZoneId()=='tZ29'?'selected':''; ?> value="2">(UTC+02:00) Калининград</option>
                    <option id="tZ291" <?php echo $ProjectSettings->getTimeZoneId()=='tZ291'?'selected':''; ?> value="2">(UTC+02:00) Стамбул</option>
                    <option id="tZ292" <?php echo $ProjectSettings->getTimeZoneId()=='tZ292'?'selected':''; ?> value="2">(UTC+02:00) Триполи</option>
                    <option id="tZ293" <?php echo $ProjectSettings->getTimeZoneId()=='tZ293'?'selected':''; ?> value="2">(UTC+02:00) Хараре, Претория</option>
                    <option id="tZ31" <?php echo $ProjectSettings->getTimeZoneId()=='tZ31'?'selected':''; ?> value="3">(UTC+03:00) Багдад</option>
                    <option id="tZ32" <?php echo $ProjectSettings->getTimeZoneId()=='tZ32'?'selected':''; ?> value="3">(UTC+03:00) Волгоград, Москва, Санкт-Петербург</option>
                    <option id="tZ33" <?php echo $ProjectSettings->getTimeZoneId()=='tZ33'?'selected':''; ?> value="3">(UTC+03:00) Кувейт, Эр-Рияд</option>
                    <option id="tZ34" <?php echo $ProjectSettings->getTimeZoneId()=='tZ34'?'selected':''; ?> value="3">(UTC+03:00) Минск</option>
                    <option id="tZ35" <?php echo $ProjectSettings->getTimeZoneId()=='tZ35'?'selected':''; ?> value="3">(UTC+03:00) Найроби</option>
                    <option id="tZ36" <?php echo $ProjectSettings->getTimeZoneId()=='tZ36'?'selected':''; ?> value="3.5">(UTC+03:30) Тегеран</option>
                    <option id="tZ41" <?php echo $ProjectSettings->getTimeZoneId()=='tZ41'?'selected':''; ?> value="4">(UTC+04:00) Абу-Даби, Мускат</option>
                    <option id="tZ42" <?php echo $ProjectSettings->getTimeZoneId()=='tZ42'?'selected':''; ?> value="4">(UTC+04:00) Баку</option>
                    <option id="tZ43" <?php echo $ProjectSettings->getTimeZoneId()=='tZ43'?'selected':''; ?> value="4">(UTC+04:00) Ереван</option>
                    <option id="tZ44" <?php echo $ProjectSettings->getTimeZoneId()=='tZ44'?'selected':''; ?> value="4">(UTC+04:00) Ижевск, Самара</option>
                    <option id="tZ45" <?php echo $ProjectSettings->getTimeZoneId()=='tZ45'?'selected':''; ?> value="4">(UTC+04:00) Порт-Луи</option>
                    <option id="tZ46" <?php echo $ProjectSettings->getTimeZoneId()=='tZ46'?'selected':''; ?> value="4">(UTC+04:00) Тбилиси</option>
                    <option id="tZ47" <?php echo $ProjectSettings->getTimeZoneId()=='tZ47'?'selected':''; ?> value="4.5">(UTC+04:30) Кабул</option>
                    <option id="tZ51" <?php echo $ProjectSettings->getTimeZoneId()=='tZ51'?'selected':''; ?> value="5">(UTC+05:00) Ашхабад, Ташкент</option>
                    <option id="tZ52" <?php echo $ProjectSettings->getTimeZoneId()=='tZ52'?'selected':''; ?> value="5">(UTC+05:00) Екатеринбург</option>
                    <option id="tZ53" <?php echo $ProjectSettings->getTimeZoneId()=='tZ53'?'selected':''; ?> value="5">(UTC+05:00) Исламабад Карачи</option>
                    <option id="tZ54" <?php echo $ProjectSettings->getTimeZoneId()=='tZ54'?'selected':''; ?> value="5.5">(UTC+05:30) Колката, Мумбай, Нью-Дели, Ченнай</option>
                    <option id="tZ55" <?php echo $ProjectSettings->getTimeZoneId()=='tZ55'?'selected':''; ?> value="5.5">(UTC+05:30) Шри-Джаявардене-пура-Котте</option>
                    <option id="tZ61" <?php echo $ProjectSettings->getTimeZoneId()=='tZ61'?'selected':''; ?> value="6">(UTC+06:00) Астана</option>
                    <option id="tZ62" <?php echo $ProjectSettings->getTimeZoneId()=='tZ62'?'selected':''; ?> value="6">(UTC+06:00) Дакка</option>
                    <option id="tZ63" <?php echo $ProjectSettings->getTimeZoneId()=='tZ63'?'selected':''; ?> value="6">(UTC+06:00) Новосибирск</option>
                    <option id="tZ64" <?php echo $ProjectSettings->getTimeZoneId()=='tZ64'?'selected':''; ?> value="6.5">(UTC+06:30) Янгон</option>
                    <option id="tZ71" <?php echo $ProjectSettings->getTimeZoneId()=='tZ71'?'selected':''; ?> value="7">(UTC+07:00) Бангкок, Джакарта, Ханой</option>
                    <option id="tZ72" <?php echo $ProjectSettings->getTimeZoneId()=='tZ72'?'selected':''; ?> value="7">(UTC+07:00) Красноярск</option>
                    <option id="tZ81" <?php echo $ProjectSettings->getTimeZoneId()=='tZ81'?'selected':''; ?> value="8">(UTC+08:00) Гонконг, Пекин, Урумчи, Чунцин</option>
                    <option id="tZ82" <?php echo $ProjectSettings->getTimeZoneId()=='tZ82'?'selected':''; ?> value="8">(UTC+08:00) Иркутск</option>
                    <option id="tZ83" <?php echo $ProjectSettings->getTimeZoneId()=='tZ83'?'selected':''; ?> value="8">(UTC+08:00) Куала-Лумпур, Сингапур</option>
                    <option id="tZ84" <?php echo $ProjectSettings->getTimeZoneId()=='tZ84'?'selected':''; ?> value="8">(UTC+08:00) Перт</option>
                    <option id="tZ85" <?php echo $ProjectSettings->getTimeZoneId()=='tZ85'?'selected':''; ?> value="8">(UTC+08:00) Тайбэй</option>
                    <option id="tZ86" <?php echo $ProjectSettings->getTimeZoneId()=='tZ86'?'selected':''; ?> value="8">(UTC+08:00) Улан-Батор</option>
                    <option id="tZ87" <?php echo $ProjectSettings->getTimeZoneId()=='tZ87'?'selected':''; ?> value="8.5">(UTC+08:30) Пхеньян</option>
                    <option id="tZ91" <?php echo $ProjectSettings->getTimeZoneId()=='tZ91'?'selected':''; ?> value="9">(UTC+09:00) Осака, Саппоро, Токио</option>
                    <option id="tZ92" <?php echo $ProjectSettings->getTimeZoneId()=='tZ92'?'selected':''; ?> value="9">(UTC+09:00) Сеул</option>
                    <option id="tZ93" <?php echo $ProjectSettings->getTimeZoneId()=='tZ93'?'selected':''; ?> value="9">(UTC+09:00) Якутск</option>
                    <option id="tZ94" <?php echo $ProjectSettings->getTimeZoneId()=='tZ94'?'selected':''; ?> value="9.5">(UTC+09:30) Аделаида</option>
                    <option id="tZ95" <?php echo $ProjectSettings->getTimeZoneId()=='tZ95'?'selected':''; ?> value="9.5">(UTC+09:30) Дарвин</option>
                    <option id="tZ101" <?php echo $ProjectSettings->getTimeZoneId()=='tZ101'?'selected':''; ?> value="10">(UTC+10:00) Брисбен</option>
                    <option id="tZ111" <?php echo $ProjectSettings->getTimeZoneId()=='tZ111'?'selected':''; ?> value="10">(UTC+10:00) Владивосток, Магадан</option>
                    <option id="tZ121" <?php echo $ProjectSettings->getTimeZoneId()=='tZ121'?'selected':''; ?> value="10">(UTC+10:00) Гуам, Порт-Морсби</option>
                    <option id="tZ131" <?php echo $ProjectSettings->getTimeZoneId()=='tZ131'?'selected':''; ?> value="10">(UTC+10:00) Канберра, Мельбурн, Сидней</option>
                    <option id="tZ141" <?php echo $ProjectSettings->getTimeZoneId()=='tZ141'?'selected':''; ?> value="10">(UTC+10:00) Хобарт</option>
                    <option id="tZ+111" <?php echo $ProjectSettings->getTimeZoneId()=='tZ+111'?'selected':''; ?> value="11">(UTC+11:00) Соломоновы о-ва, Нов. Каледония</option>
                    <option id="tZ+112" <?php echo $ProjectSettings->getTimeZoneId()=='tZ+112'?'selected':''; ?> value="11">(UTC+11:00) Чокурдах</option>
                    <option id="tZ+121" <?php echo $ProjectSettings->getTimeZoneId()=='tZ+121'?'selected':''; ?> value="12">(UTC+12:00) Анадырь, Петропавловск-Камчатский</option>
                    <option id="tZ+122" <?php echo $ProjectSettings->getTimeZoneId()=='tZ+122'?'selected':''; ?> value="12">(UTC+12:00) Веллингтон, Окленд</option>
                    <option id="tZ+123" <?php echo $ProjectSettings->getTimeZoneId()=='tZ+123'?'selected':''; ?> value="12">(UTC+12:00) Фиджи</option>
                    <option id="tZ+131" <?php echo $ProjectSettings->getTimeZoneId()=='tZ+131'?'selected':''; ?> value="13">(UTC+13:00) Нукуалофа</option>
                    <option id="tZ+132" <?php echo $ProjectSettings->getTimeZoneId()=='tZ+132'?'selected':''; ?> value="13">(UTC+13:00) Самоа</option>
                  </select>
                </div>
              </div>
              <div class="checkbox checkbox-success">
                <input id="daylightSavingTime" <?php echo $ProjectSettings->getDaylightSavingTime()==1?'checked':''; ?> type="checkbox">
                <label for="daylightSavingTime">
                  Автоматический переход на летнее время и обратно
                </label>
              </div>
              <div id="workingDays">
                <label>Рабочие дни:</label>
                <?php $workingDays = $ProjectSettings->getWorkingDays();?>
                <div class="row">
                  <div class="col-sm-2">
                    <div class="checkbox checkbox-success">
                      <input id="cMonday" <?php echo $workingDays[0][0]==1?'checked':''; ?> type="checkbox">
                      <label for="cMonday">
                        Понедельник
                      </label>
                    </div>
                  </div>
                  <div id="cMondayHour" class="col-sm-3">
                    <span>с</span><input class="form-control" type="text" value="<?php echo $workingDays[0][1]; ?>"><span>до</span><input class="form-control" type="text" value="<?php echo $workingDays[0][2]; ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-2">
                    <div class="checkbox checkbox-success">
                      <input id="cTuesday" <?php echo $workingDays[1][0]==1?'checked':''; ?> type="checkbox">
                      <label for="cTuesday">
                        Вторник
                      </label>
                    </div>
                  </div>
                  <div id="cTuesdayHour" class="col-sm-3">
                    <span>с</span><input class="form-control" type="text" value="<?php echo $workingDays[1][1]; ?>"><span>до</span><input class="form-control" type="text" value="<?php echo $workingDays[1][2]; ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-2">
                    <div class="checkbox checkbox-success">
                      <input id="cWednesday" <?php echo $workingDays[2][0]==1?'checked':''; ?> type="checkbox">
                      <label for="cWednesday">
                        Среда
                      </label>
                    </div>
                  </div>
                  <div id="cWednesdayHour" class="col-sm-3">
                    <span>с</span><input class="form-control" type="text" value="<?php echo $workingDays[2][1]; ?>"><span>до</span><input class="form-control" type="text" value="<?php echo $workingDays[2][2]; ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-2">
                    <div class="checkbox checkbox-success">
                      <input id="cThursday" <?php echo $workingDays[3][0]==1?'checked':''; ?> type="checkbox">
                      <label for="cThursday">
                        Четверг
                      </label>
                    </div>
                  </div>
                  <div id="cThursdayHour" class="col-sm-3">
                    <span>с</span><input class="form-control" type="text" value="<?php echo $workingDays[3][1]; ?>"><span>до</span><input class="form-control" type="text" value="<?php echo $workingDays[3][2]; ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-2">
                    <div class="checkbox checkbox-success">
                      <input id="cFriday" <?php echo $workingDays[4][0]==1?'checked':''; ?> type="checkbox">
                      <label for="cFriday">
                        Пятница
                      </label>
                    </div>
                  </div>
                  <div id="cFridayHour" class="col-sm-3">
                    <span>с</span><input class="form-control" type="text" value="<?php echo $workingDays[4][1]; ?>"><span>до</span><input class="form-control" type="text" value="<?php echo $workingDays[4][2]; ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-2">
                    <div class="checkbox checkbox-success">
                      <input id="cSaturday" <?php echo $workingDays[5][0]==1?'checked':''; ?> type="checkbox">
                      <label for="cSaturday">
                        Суббота
                      </label>
                    </div>
                  </div>
                  <div id="cSaturdayHour" class="col-sm-3">
                    <span>с</span><input class="form-control" type="text" value="<?php echo $workingDays[5][1]; ?>"><span>до</span><input class="form-control" type="text" value="<?php echo $workingDays[5][2]; ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-2">
                    <div class="checkbox checkbox-success">
                      <input id="cSunday" <?php echo $workingDays[6][0]==1?'checked':''; ?> type="checkbox">
                      <label for="cSunday">
                        Воскресенье
                      </label>
                    </div>
                  </div>
                  <div id="cSundayHour" class="col-sm-3">
                    <span>с</span><input class="form-control" type="text" value="<?php echo $workingDays[6][1]; ?>"><span>до</span><input class="form-control" type="text" value="<?php echo $workingDays[6][2]; ?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="decor">
              <div class="row">
                <div id="boardExample" class="col-sm-8"></div>
                <div class="col-sm-4">
                  <div class="panel-group marginTop20" id="accordion">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" onClick="WidgetSettings.showDecorBtn();">
                          Оформление кнопки
                          </a>
                        </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                          <div class="row">
                            <div class="col-sm-12 marginTop5">
                              Тип кнопки:
                              <select id="btnType" class="selectpicker" data-width="100%">
                                <option value="0">Плоская трубка</option>
                              </select>
                            </div>
                          </div>
                          <div id="configForBtn">
                            <?php
                              $ProjectSettings->getWidgetSettings()[0]->configureWidget();
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" onClick="WidgetSettings.showModalWindow();">
                            Оформление модального окна
                            </a>
                          </h4>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse">
                        <?php
                          $ProjectSettings->getWidgetSettings()[1]->configureWidget();
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="getCode">
              <div class="alert alert-info fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                Чтобы активировать виджет вставьте данный код во все страницы сайта <strong><?php echo $ProjectSettings->getDomain();?></strong> перед закрывающим тегом <strong>&lt;/body&gt;</strong>
              </div>
              <p><textarea id="widgetCode" onClick="this.select();" class="form-control" rows="7"></textarea></p>
              <p><a id="codeGenerationText" data-loading-text="Генерация кода..." class="btn btn-info">Получить код виджета</a></p>
            </div>
          </div>
          <a id="saveProjectSettings" data-loading-text="Сохранение..." class="btn btn-info">Сохранить</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>