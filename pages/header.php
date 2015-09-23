<?php
// header.php
/* For Debugging, Comment this in
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
*/

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" href="favicon.png" />
        <link rel="shortcut icon" href="favicon.png" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>phpSpark Example Dashboard</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap theme -->
        <link href="css/bootstrap-theme.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/starter-template.css" rel="stylesheet">

        <!-- Spin Kit -->
        <link href="css/spinkit.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            body {
                padding-bottom: 2em;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top navbar-right">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="?">phpSpark Dashboard Example</a>
                </div>
                
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <?php
                        if(isset($_SESSION['accessToken']))
                        {
                            ?>
                            <li><a href="?p=devices">View Your Devices</a></li>
                            <li><a href="?p=tokens">View Your Tokens</a></li>
                            <li><a href="?p=logout">Logout</a></li>
                            <?php
                        }
                        else
                        {
                            ?>
                            <li><a href="?p=login">Login</a></li>
                            <?php
                        }
                        ?>
                        
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>