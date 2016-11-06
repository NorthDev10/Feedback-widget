<?php
defined('CONTACT_DETAILS') or die('Access denied');

require_once CLASSES.'Session.php';
require_once CLASSES.'DataBase.php';
require_once CLASSES.'HttpRequest.php';
require_once CLASSES.'Users.php';
require_once CLASSES.'AuthVK.php';
require_once CLASSES.'AuthGoogle.php';
require_once CLASSES.'ProjectManager.php';
require_once CLASSES.'ContactDetails.php';
require_once VIEW.'View.php';

if(isset($_COOKIE[session_name()])) {
    if(!Session::startSession()) {
        if(isset($_POST['ajax'])) {
            header("Location: /auth/", true, 200);
        } else {
            header("Location: /auth/");
        }
    }
}

switch($_GET['q']) {
    case 'auth':
        View::getAuthPage();
    break;
    case 'control-panel':
        if(session_id() && isset($_SESSION['userId'])) {
            $User = new Users();
            if($User->loginById()) {
                View::getControlPanel();
            } else {
                header("Location: /auth/");
            }
        } elseif(isset($_POST['email']) && isset($_POST['password']) 
                && isset($_POST['g-recaptcha-response'])) {
            if(mb_strlen($_POST['password'], 'UTF-8') > 5) {
                $params = array(
                    'secret' => RECAPTCHA_SECRET_KEY,
                    'response' => $_POST['g-recaptcha-response'],
                    'remoteip' => $_SERVER['REMOTE_ADDR']
                );
                $result = HttpRequest::post('https://www.google.com/recaptcha/api/siteverify', $params, true);
                if($result['success']) {
                    $User = new Users();
                    if($User->login($_POST['email'], $_POST['password'])) {
                        $ProjectManager = new ProjectManager($User);
                        View::getControlPanel();
                    } else {
                        header("Location: /?q=auth&m=".urlencode('Неправильный Email или пароль'));
                    }
                } else {
                    header("Location: /?q=auth&m=".urlencode('Вы не прошли проверку. Вы случайно не робот?'));
                }
            } else {
                header("Location: /?q=auth&m=".urlencode('Длина пароля, должна быть не менее 6 символов.'));
            }
        } else {
            if(LOG_IN_USING_SOCIAL_NETWORKS) {
                if(isset($_GET['error'])) {
                    header("Location: /?q=auth&m=".urlencode('Не удалось авторизоваться'));
                } else {
                    if(isset($_GET['code'])) {
                        switch($_GET['state']) {
                            case 'auth-vk':
                                $dataAccess = AuthVK::getAccessToken($_GET['code']);
                                if(is_array($dataAccess)) {
                                    $user = AuthVK::getUserInfo($dataAccess);
                                    if(is_object($user) && $user->loginByVK()) {
                                        header("Location: /control-panel/");
                                    } else {
                                        header("Location: /?q=auth&m=".urlencode('Не удалось авторизоваться'));
                                    }
                                }
                            break;
                            case 'auth-google':
                                $dataAccess = AuthGoogle::getAccessToken($_GET['code']);
                                if(is_array($dataAccess)) {
                                    $user = AuthGoogle::getUserInfo($dataAccess);
                                    if(is_object($user) && $user->loginByGoogle()) {
                                        header("Location: /control-panel/");
                                    } else {
                                        header("Location: /?q=auth&m=".urlencode('Не удалось авторизоваться'));
                                    }
                                }
                            break;
                            default:
                                header("Location: /?q=auth&m=".urlencode('Не удалось авторизоваться'));
                        }
                    } else {
                        header("Location: /auth/");
                    }
                }
            } else  {
                header("Location: /auth/");
            }
        }
    break;
    case 'logout':
        Session::destroySession();
        header("Location: /");
    break;
    case 'new-account':
        if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['g-recaptcha-response'])) {
            try {
                if(mb_strlen($_POST['password'], 'UTF-8') > 5) {
                    $params = array(
                        'secret' => RECAPTCHA_SECRET_KEY,
                        'response' => $_POST['g-recaptcha-response'],
                        'remoteip' => $_SERVER['REMOTE_ADDR']
                    );
                    $result = HttpRequest::post('https://www.google.com/recaptcha/api/siteverify', $params, true);
                    if($result['success']) {
                        $User = new Users();
                        if($User->setEmail($_POST['email']) && $User->genHhashForPassword($_POST['password'])) {
                            if($User->signUp()) {
                                header("Location: /control-panel/");
                            } else {
                                throw new Exception('Пользователь с такой почтой уже существует.');
                            }
                        } else {
                            throw new Exception('Некорректный email.');
                        }
                        
                    } else {
                        throw new Exception('Вы не прошли проверку. Вы случайно не робот?');
                    }
                } else {
                    throw new Exception('Длина пароля, должна быть не менее 6 символов.');
                }
            } catch (Exception $e) {
                header("Location: /?q=new-account&m=".urlencode('Не удалось создать аккаунт. '.$e->getMessage()));
            }
        } else {
            View::getNewAccount();
        }
    break;
    case 'forgot':
        if(isset($_GET['key']) && isset($_GET['uid'])) {
            $User = new Users();
            if($User->restorePassword($_GET['uid'], $_GET['key'])) {
                header("Location: /control-panel/");
            } else {
                header("Location: /?q=forgot&m=".urlencode('Срок действия ссылки восстановления пароля истек или ссылка некорректна.'));
            }
        } elseif(isset($_POST['email']) && isset($_POST['g-recaptcha-response'])) {
            $params = array(
                'secret' => RECAPTCHA_SECRET_KEY,
                'response' => $_POST['g-recaptcha-response'],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            );
            $result = HttpRequest::post('https://www.google.com/recaptcha/api/siteverify', $params, true);
            if($result['success']) {
                $User = new Users();
                if($User->requestForPasswordRecovery($_POST['email'])) {
                    View::getInfoPage('На ваш электронный ящик были высланы инструкции по смене пароля.');
                } else {
                    header("Location: /?q=forgot&m=".urlencode('Этот адрес эл.почты не зарегистрирован'));
                }
            } else {
                header("Location: /?q=forgot&m=".urlencode('Вы не прошли проверку. Вы случайно не робот?'));
            }
        } else {
            View::getRestorePwd();
        }
    break;
    case 'activate-email':
        if(isset($_GET['key']) && isset($_GET['uid'])) {
            $User = new Users();
            if($User->emailConfirmation($_GET['uid'], $_GET['key'])) {
                View::getInfoPage('Адрес эл.почты успешно подтверждён.');
            } else {
                View::getInfoPage('Срок действия ссылки подтверждения адреса эл.почты истек или ссылка некорректна.');
            }
        } elseif(isset($_POST['sendConfirm'])) {
            $User = new Users();
            if($User->loginById() && $User->requestForEmailConfirmation()) {
                echo '[true]';
            }
        }
    break;
    case 'save-user-info':
        if(isset($_POST['ajax']) && isset($_POST['user-id'])) {
            $user = new Users();
            if($user->loginById()) {
                $newInfoForUser = new Users();
                $newInfoForUser->setUserId($_POST['user-id']);
                $newInfoForUser->setGroupId($_POST['group-ip']);
                $newInfoForUser->setFirstName($_POST['first-name']);
                $newInfoForUser->setLastName($_POST['last-name']);
                $newInfoForUser->setMobilePhone($_POST['phone-number']);
                $newInfoForUser->setHomePhone($_POST['second-phone-number']);
                $newInfoForUser->setSkype($_POST['skype']);
                $newInfoForUser->setEmail($_POST['email']);
                $newInfoForUser->setSiteURL($_POST['site']);
                $newInfoForUser->genHhashForPassword($_POST['password']);
                if($user->saveUserInfo($newInfoForUser)) {
                    echo '[true]';
                } else {
                    echo json_encode(array('error'=>'Не удалось сохранить'));
                }
            }
        }
    break;
    case 'list-all-users':
        if(isset($_POST['ajax'])) {
            $user = new Users();
            if($user->loginById()) {
                echo json_encode($user->fetchAllUsers($_POST['currentPage']));
            }
        } else {
            View::getListAllUsers();
        }
    break;
    case 'my-projects':
        if(isset($_POST['ajax'])) {
            $user = new Users();
            if($user->loginById()) {
                $ProjectManager = new ProjectManager();
                if(isset($_POST['user-id'])) {
                    $ProjectManager->setUserId($_POST['user-id']);
                }
                echo json_encode($ProjectManager->fetchBase($_POST['currentPage']));
            }
        }
    break;
    case 'my-profile':
        if(session_id() && isset($_SESSION['userId'])) {
            $User = new Users();
            if($User->loginById()) {
                View::getUserProfile($User);
            } else {
                header("Location: /auth/");
            }
        } else {
            header("Location: /auth/");
        }
    break;
    case 'user-profile':
        $user = new Users();
        if($user->loginById()) {
            $userProfile = $user->getUserProfileById($_GET['uid']);
            if($userProfile) {
                View::getUserProfile($userProfile);
            }
        }
    break;
    case 'project-settings':
        $user = new Users();
        if($user->loginById()) {
            if(isset($_GET['pid'])) {
                $ProjectSettings = new ProjectManager();
                if(isset($_GET['uid'])) {
                    $ProjectSettings->setUserId($_GET['uid']);
                }
                $ProjectSettings->setApiKeyId($_GET['pid']);
                if($ProjectSettings->fetchById()) {
                    View::getProjectSettings($ProjectSettings);
                }
            }
        }
    break;
    case 'new-project':
        $user = new Users();
        if($user->loginById()) {
            $ProjectSettings = new ProjectManager();
            $ProjectSettings->defaultWidget();
            View::getProjectSettings($ProjectSettings);
        }
    break;
    case 'del-project':
        if(isset($_POST['ajax']) && isset($_POST['projectID'])) {
            $user = new Users();
            if($user->loginById()) {
                $ProjectSettings = new ProjectManager();
                $ProjectSettings->setUserId($_POST['userID']);
                $ProjectSettings->setApiKeyId($_POST['projectID']);
                if($ProjectSettings->delete()) {
                    echo json_encode([true, 'message' => 'Проект успешно удалён']);
                } else {
                    echo json_encode([false, 'message' => 'Не удалось удалить проект']);
                }
            }
        }
    break;
    case 'save-project':
        if(isset($_POST['ajax']) && isset($_POST['userID'])) {
            $user = new Users();
            if($user->loginById()) {
                $ProjectSettings = new ProjectManager();
                $ProjectSettings->setUserId($_POST['userID']);
                $ProjectSettings->setApiKeyId($_POST['projectID']);
                $ProjectSettings->setDomain($_POST['url']);
                $ProjectSettings->setManagerPhone($_POST['managerPhone']);
                $ProjectSettings->setTimeZone($_POST['timeZone']);
                $ProjectSettings->setDaylightSavingTime($_POST['daylightSavingTime']);
                $ProjectSettings->setTimeZoneId($_POST['timeZoneId']);
                $ProjectSettings->setWorkingDays($_POST['workingDays']);
                $ProjectSettings->setWidgetSettings($_POST['widgetSettings']);
                if(isset($_POST['newProject'])) {
                    if($ProjectSettings->createNewProject($user)) {
                        echo json_encode(array(
                            'true',
                            'projectID' => $ProjectSettings->getApiKeyId()
                        ));
                    } else {
                        echo json_encode(array('error'=>'Не удалось сохранить'));
                    }
                } else {
                    if($ProjectSettings->save()) {
                        echo '[true]';
                    } else {
                        echo json_encode(array('error'=>'Не удалось сохранить'));
                    }
                }
            }
        }
    break;
    case 'json-widget-settings':
        if(isset($_POST['ajax'])) {
            $user = new Users();
            if($user->loginById()) {
                $ProjectSettings = new ProjectManager();
                if(isset($_POST['newProject'])) {
                    $ProjectSettings->defaultWidget();
                    echo $ProjectSettings->getWidgetSettingsJSON();
                } else {
                    $ProjectSettings->setUserId($_POST['userID']);
                    $ProjectSettings->setApiKeyId($_POST['projectID']);
                    if($ProjectSettings->fetchById()) {
                        echo $ProjectSettings->getWidgetSettingsJSON();
                    } else {
                        echo json_encode(array('error'=>'Не удалось получить конфигурации виджета'));
                    }
                }
                
            }
        }
    break;
    case 'gen-widget-js':
        header('Content-Type: application/javascript; charset=utf-8');
        $ProjectSettings = new ProjectManager();
        $ProjectSettings->setApiKey($_GET['apiKey']);
        $ProjectSettings->fetchByApiKey();
        $ProjectSettings->generateWidgetJSFile();
    break;
    case 'gen-code-widget':
        if(isset($_POST['ajax'])) {
            $user = new Users();
            if($user->loginById()) {
                $ProjectSettings = new ProjectManager();
                $ProjectSettings->setUserId($_POST['userID']);
                $ProjectSettings->setApiKeyId($_POST['projectID']);
                if($ProjectSettings->fetchById()) {
                    $code =  $ProjectSettings->generateWidgetJSFileMIN(false);
                    if($code) {
                        echo json_encode($code);
                    } else {
                        echo json_encode(array('error'=>'Не удалось получить код виджета'));
                    }
                } else {
                    echo json_encode(array('error'=>'Не удалось получить код виджета'));
                }
            }
        }
    break;
    case 'add-contacts':
        $ContactDetails = new ContactDetails();
        $ContactDetails->setTitle($_GET['title']);
        $ContactDetails->setUrl($_GET['url']);
        $ContactDetails->setCustomerName($_GET['name']);
        $ContactDetails->setUserEmail($_GET['email']);
        $ContactDetails->setUserQuestions($_GET['questions']);
        $ContactDetails->setApiKey($_GET['ApiKey']);
        $ContactDetails->setPhoneNumber($_GET['PhoneNumber']);
        $ContactDetails->setOrigin($_SERVER['HTTP_ORIGIN']);
        if($ContactDetails->addContacts()) {
            header('Access-Control-Allow-Origin: *');
        }
    break;
    case 'question-solved':
        if(isset($_POST['ajax'])) {
            $user = new Users();
            if($user->loginById()) {
                $ContactDetails = new ContactDetails();
                $ContactDetails->setContactID($_POST['contactID']);
                $ContactDetails->setApiKeyId($_POST['ApiKeyID']);
                $ContactDetails->setProcessingStatus($_POST['pStatus']);
                echo json_encode(array('status'=>$ContactDetails->questionSolved()));
            }
        }
    break;
    case 'fetch-contacts':
        if(isset($_POST['ajax'])) {
            $user = new Users();
            if($user->loginById()) {
                $ContactDetails = new ContactDetails();
                $ContactDetails->setUserId($_POST['uid']);
                $myContacts = $ContactDetails->fetchALLMyContacts($_POST['currentPage']);
                if($myContacts) {
                    echo json_encode($ContactDetails->fetchALLMyContacts($_POST['currentPage']));
                } else {
                    echo json_encode(array('error'=>'Не один пользователь ещё не оставил свои контактные данные'));
                }
            }
        } else {
            View::getContactsList();
        }
    break;
    default:
        View::getMainPage();
}