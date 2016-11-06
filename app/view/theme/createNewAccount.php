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
    <script>
        $(document).ready(function() {
            $("#createNewAccount").submit(function(){
                try {
                    var passwordArray = $("[type=password]");
                    if (passwordArray.length > 1) {
                        if (passwordArray[0].value == passwordArray[1].value) {
                            if (passwordArray[0].value.length <= 5) {
                                passwordArray[0].focus();
                                throw ('Длина пароля, должна быть не менее 6 символов');
                            }
                        } else {
                            passwordArray[0].focus();
                            throw ('Пароли не совпадают');
                        }
                    }
                }
                catch (e) {
                    $("#message").html('<div class="alert alert-warning fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>' + e + '</strong></div>');
                    return false;
                }
            });
        });
    </script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <a class="logo" href="/">Project name</a>
    <div class="container">
        <form id="createNewAccount" class="form-signin text-center" role="form" method="post">
            <h2 class="form-signin-heading text-center">Создание нового аккаунта</h2>
            <div id="message">
            <?php 
                if($_GET[ 'm']) { 
                    echo '<div class="alert alert-warning fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>'.strip_tags($_GET[ 'm']). '</strong></div>';
                }
            ?>
            </div>
            <input type="email" name="email" class="form-control" placeholder="Адрес эл.почты" required autofocus>
            <input type="password" name="password" class="form-control" placeholder="Пароль">
            <input type="password" class="form-control borderRadius4" placeholder="Подтвердите пароль">
            <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_KEY; ?>"></div>
            <button class="btn btn-lg btn-success btn-block" type="submit">Создать аккаунт</button>
        </form>
    </div>
    <!-- /container -->
</body>

</html>