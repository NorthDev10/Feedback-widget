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
    <div class="container form-signin">
        <h2 class="form-signin-heading text-center">
            <?php 
                if(!empty($message)) { 
                    echo strip_tags($message);
                }
            ?>
        </h2>
    </div>
    <!-- /container -->
</body>

</html>