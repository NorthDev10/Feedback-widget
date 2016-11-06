<?php defined( 'CONTACT_DETAILS') or die( 'Access denied'); 
require_once VIEW.'theme/headerCP.php';
?>
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
                    <li><a href="/control-panel/">Главная</a></li>
                    <?php
                        if($Users->getUserId() == $_SESSION['userId']) {
                            echo '<li class="active"><a href="/my-profile/">Мой аккаунт</a></li>';
                        } else {
                            echo '<li><a href="/my-profile/">Мой аккаунт</a></li>';
                        }
                    ?>
                    <li><a href="/fetch-contacts/">Вопросы от посетителей</a></li>
                    <?php
                        if($_SESSION['myRights'] & RIGHT_READ_ALL_DATA) {
                            echo '<li><a href="/list-all-users/">Все пользователи</a></li>';
                        }
                    ?>
                </ul>
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <h1 class="sub-header">Информация об аккаунте</h1>
                <div id="infoPanel"></div>
                <div id="mainContent">
                    <?php
                        if($_SESSION['myRights'] & RIGHT_READ_ALL_DATA) {
                    ?>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Дата последнего визита:</label>
                            <p>
                            <?php
                                if($Users->getUserId() == $_SESSION['userId']) {
                                    echo $_SESSION['dateLastEntry'];
                                } else {
                                    echo $Users->getDateLastEntry();
                                }
                                echo '<input id="userId" type="hidden" class="form-control" value="'.$Users->getUserId().'">';
                            ?>
                            </p>
                        </div>
                        <div class="col-sm-3">
                            <label>Группа:</label>
                            <p>
                            <?php
                                if($_SESSION['userId'] == $Users->getUserId()) {
                                    echo $Users->getGroupName();
                                } elseif($_SESSION['myRights'] & RIGHT_WRITE_ALL_DATA) {
                            ?>
                            <select id="listAllGroups">
                                <?php 
                                    $result = $Users->getListAllGroups();
                                    for($i = 0; $i < count($result); $i++) {
                                        echo '<option '.
                                        ($result[$i]['groupsId']==$Users->getGroupId()?"selected":"")
                                        .' value="'.$result[$i]['groupsId'].'">'.$result[$i]['groupName'].'</option>';
                                    }
                                ?>
                                
                            </select>
                            <?php
                                }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Дата регистрации:</label>
                            <p>
                            <?php
                                echo $Users->getDateRegistration();
                            ?>
                            </p>
                        </div>
                        <div class="col-sm-3">
                            <label>ip адрес:</label>
                            <p>
                            <?php
                                echo $Users->getIpAddress();
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <?php
                                if(!empty($Users->getGoogleUserId())) {
                                    echo '<a target="_blank" href="https://plus.google.com/'.$Users->getGoogleUserId().'">Профиль Google+</a>';
                                }
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <?php
                                if(!empty($Users->getVkUserId())) {
                                    echo '<a target="_blank" href="https://vk.com/id'.$Users->getVkUserId().'">Профиль Вконтакте</a>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Имя:</label>
                            <?php
                                echo '<input id="firstName" type="text" class="form-control" value="'.$Users->getFirstName().'">';
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <label>Фамилия:</label>
                            <?php
                                echo '<input id="lastName" type="text" class="form-control" value="'.$Users->getLastName().'">';
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Телефон:</label>
                            <?php
                                echo '<input id="phoneNumber" type="text" class="form-control" value="'.$Users->getMobilePhone().'">';
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <label>Дополнительный телефон:</label>
                            <?php
                                echo '<input id="secondPhoneNumber" type="text" class="form-control" value="'.$Users->getHomePhone().'">';
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Skype:</label>
                            <?php
                                echo '<input id="skype" type="text" class="form-control" value="'.$Users->getSkype().'">';
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <label>Адрес эл.почты:</label>
                            <input id="email" type="email" class="form-control" value="<?php echo $Users->getEmail(); ?>">
                            <?php 
                                if(!$Users->getEmailConfirmation()) {
                                    if($Users->getUserId() == $_SESSION['userId']) {
                                        echo '<p class="palRed confirmEmail">Необходимо <a onClick="ControlPanel.emailConfirmation();" data-placement="right" title="Подтвердить адрес эл.почты">подтвердить</a> адрес эл.почты</p>';
                                    } elseif($_SESSION['myRights'] & RIGHT_READ_ALL_DATA) {
                                        echo '<p class="palRed confirmEmail">Адрес эл.почты не подтверждён</p>';
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Сайт:</label>
                            <?php
                                echo '<input id="site" type="text" class="form-control" value="'.$Users->getSiteURL().'">';
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Новый пароль:</label>
                            <input id="password" type="password" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <label>Подтвердить пароль:</label>
                            <input id="confirmedPassword" type="password" class="form-control">
                        </div>
                    </div>
                    <?php
                        } elseif($_SESSION['myRights'] & RIGHT_READ_MY_DATA) {
                    ?>
                    Дата последнего визита: <?php 
                        if($Users->getUserId() == $_SESSION['userId']) {
                            echo $_SESSION['dateLastEntry'];
                        } else {
                            echo $Users->getDateLastEntry();
                        }
                        echo '<input id="userId" type="hidden" class="form-control" value="'.$Users->getUserId().'">';
                    ?>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Имя пользователя:</label>
                            <?php
                                if(!empty($Users->getFirstName())) {
                                    echo '<input id="firstName" type="text" class="form-control" value="'.$Users->getFirstName().'">';
                                }
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <label>Адрес эл.почты:</label>
                            <input id="email" type="text" class="form-control" value="<?php echo $Users->getEmail(); ?>">
                            <?php 
                                if(!$Users->getEmailConfirmation()) {
                                    if($Users->getUserId() == $_SESSION['userId']) {
                                        echo '<p class="palRed confirmEmail">Необходимо <a onClick="ControlPanel.emailConfirmation();" data-placement="right" title="Подтвердить адрес эл.почты">подтвердить</a> адрес эл.почты</p>';
                                    } elseif($_SESSION['myRights'] & RIGHT_READ_ALL_DATA) {
                                        echo '<p class="palRed confirmEmail">Адрес эл.почты не подтверждён</p>';
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Новый пароль:</label>
                            <input id="password" type="password" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <label>Подтвердить пароль:</label>
                            <input id="confirmedPassword" type="password" class="form-control">
                        </div>
                    </div>
                    <?php
                        }
                        if($_SESSION['myRights'] & RIGHT_WRITE_MY_DATA) {
                    ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <a id="saveMyInfo" data-loading-text="Сохранение..." class="btn btn-info">Сохранить</a>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>