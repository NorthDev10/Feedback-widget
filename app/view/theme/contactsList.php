<?php defined( 'CONTACT_DETAILS') or die( 'Access denied');
if($_SESSION['myRights'] & RIGHT_READ_ALL_DATA) {
require_once VIEW.'theme/headerCP.php';
?>
<link rel="stylesheet" href="/css/build.css">
<link rel="stylesheet" href="/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/bootstrap-select.min.css">
<script src="/js/bootstrap-select.min.js" defer></script>
<script>
document.addEventListener("DOMContentLoaded", function(event) {
    ControlPanel.fetchContacts(1);
});
</script>
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
                    <li><a href="/list-all-users/">Все пользователи</a></li>
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
                    <li><a href="/my-profile/">Мой аккаунт</a></li>
                    <li class="active"><a href="/fetch-contacts/">Вопросы от посетителей</a></li>
                    <li><a href="/list-all-users/">Все пользователи</a></li>
                </ul>
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <h1 class="sub-header">Вопросы от посетителей</h1>
                <div id="infoPanel"></div>
                <div id="mainContent"></div>
                <div class="modal fade" id="detailedInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Подробности</h4>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    }
?>