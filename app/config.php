<?php
defined('CONTACT_DETAILS') or die('Access denied');

define('RIGHT_DELETE_ALL_DATA',1 << 7); //удаление всех данных
define('RIGHT_WRITE_ALL_DATA', 1 << 6); //изменение всех данных
define('RIGHT_ADD_ALL_DATA',   1 << 5); //добавление всех данных
define('RIGHT_READ_ALL_DATA',  1 << 4); //чтение всех данных
define('RIGHT_DELETE_MY_DATA', 1 << 3); //удаление своих данных
define('RIGHT_ADD_MY_DATA',    1 << 2); //добавление своих данных
define('RIGHT_WRITE_MY_DATA',  1 << 1); //изменение своих данных
define('RIGHT_READ_MY_DATA',   1 << 0); //чтение своих данных
define('CONTROLLER', __DIR__.'/controller/controller.php');
define('VIEW', __DIR__.'/view/');
define('CLASSES', __DIR__.'/classes/');
define('ABSTRACTCLASS', __DIR__.'/abstractClasses/');
define('TEMP', __DIR__.'/app/temp/');


session_name('phone_numbers');
date_default_timezone_set('Europe/Kiev');
define('SITE_PROTOCOL', 'https');
define('DOMAIN_SITE', 'contact-details-dregvali.c9users.io');
define('SESSION_LIFETIME', 900);
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB', 'db_phones');
define('LOG_IN_USING_SOCIAL_NETWORKS', true);
// Аутентификация через ВКонтакте
//https://vk.com/dev
define('VK_APP_ID', '5245361');
define('VK_SECRET_KEY', 'ABdYdZtk5xlWyUmmqTPZ');
define('VK_REDIRECT_URI', 'https://'.DOMAIN_SITE.'/?q=control-panel');
// Аутентификация через Google
//https://console.developers.google.com/apis/credentials
define('GOOGLE_APP_ID', '358309530423-9fd8h2s732nrf4m8m8virck9rhckugn5.apps.googleusercontent.com');
define('GOOGLE_SECRET_KEY', 'kG-lUoRxyC5aCKIh0M3o1OT6');
define('GOOGLE_REDIRECT_URI', 'https://'.DOMAIN_SITE.'/?q=control-panel');
// reCAPTCHA
//https://www.google.com/recaptcha/intro/index.html
define('RECAPTCHA_KEY', '6Le2fx0TAAAAAER_yNMZLChZdFXtV-mZfOrcZDzj');
define('RECAPTCHA_SECRET_KEY', '6Le2fx0TAAAAAHbkSaSwr_V_-5S5qlZNjrDJ1O7C');