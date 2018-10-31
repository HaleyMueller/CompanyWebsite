<?php
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Access Denied</title>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
    </head>
    <body>
        <div class="customJumbotron" style="">
            <h1 class="display-4"><b>Bedroom Studios, LLC</b></h1>
            <p class="lead" id="slogan"></p>
        </div>
        <div class="container">
            <div class="page-header">
                <h1><b>Access Denied</b></h1>
            </div>
            <p>Sorry you don't have access to the page: <?php echo $_GET['url'];?></p>
        </div>
    </body>
</html>