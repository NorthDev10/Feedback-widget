<?php defined( 'CONTACT_DETAILS') or die( 'Access denied'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/signin.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" defer></script>
    <script src="/js/bootstrap.min.js" defer></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <a class="logo" href="/">Project name</a>
    <div class="container">
        <div class="row form-signin">
            <div class="col-xs-12 col-sm-7">
                <form class="text-center" role="form" method="post" action="/control-panel/">
                    <h2 class="form-signin-heading text-center">Войти</h2>
                    <?php 
                        if($_GET[ 'm']) { 
                            echo '<div class="alert alert-warning fade in">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>'.strip_tags($_GET[ 'm']). '</strong></div>';
                        }
                    ?>
                    <input type="email" name="email" class="form-control" placeholder="Адрес эл.почты" required autofocus>
                    <input type="password" name="password" class="form-control" placeholder="Пароль" required>
                    <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_KEY; ?>"></div>
                    <button class="btn btn-lg btn-success btn-block" type="submit">Войти</button>
                </form>
                <p class="signUpOrRecoverPwd">
                    <a title="Создать аккаунт" href="/new-account/">Создать аккаунт</a>
                    <a title="Восстановить пароль" href="/forgot/">Восстановить пароль</a>
                </p>
            </div>
            <?php
            if(LOG_IN_USING_SOCIAL_NETWORKS) {
                echo '<div class="col-xs-12 col-sm-5">
                    <div class="text-center top-15px"><span class="loginInOr">или</span></div>
                    <ul class="social-buttons">
                        <li>
                            <a class="vk-sign" href="'.AuthVK::getURLForAuthorize(). '" title="Войти через ВКонтакте">
                                <span class="vk-icon"></span> ВКонтакте
                            </a>
                        </li>
                        <li>
                            <a class="gplus-sign" href="'.AuthGoogle::getURLForAuthorize().'" title="Войти через Google">
                                <span class="gplus-icon"></span> Google
                            </a>
                        </li>
                    </ul>
                </div>';
            } 
            ?>
        </div>
    </div>
    <!-- /container -->
</body>

</html>