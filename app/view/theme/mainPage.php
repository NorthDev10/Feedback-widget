<?php defined( 'CONTACT_DETAILS') or die( 'Access denied'); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="">
    <title>Справочник организаций</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" defer></script>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&width=100%" defer></script>
    <script src="/js/bootstrap.min.js" defer></script>
    <script src="/js/company-list.min.js" type="text/javascript" defer></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/ie10-viewport-bug-workaround.js" defer></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body>
    <header>
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Project name</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <?php 
                            if(isset($_SESSION['userId'])) {
                                echo '<li><a href="/control-panel">Панель управления</a></li>';
                                echo '<li><a href="/logout">Выйти</a></li>';
                            } else {
                                echo '<li><a href="/auth">Войти</a></li>';
                            }
                        ?>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </nav>
    </header>
    <footer class="footer">
        <p>&copy; Company 2016</p>
    </footer>
</body>

</html>