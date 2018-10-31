<?php
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>404</title>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
</head>
<body>
<div class="jumbotron" style="">
    <h1 class="display-4">Bedroom Studios, LLC</h1>
    <p class="lead" id="slogan"></p>
</div>
<div class="container">
    <div class="page-header">
        <h1>404 Page not found</h1>
    </div>
    <p>Sorry we couldn't find the page you was looking for.</p>
</div>
</body>
</html>