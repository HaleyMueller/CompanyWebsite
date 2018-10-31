<?php
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

if(HasSpecificAccessRole(20, $_SESSION['UserID']) || HasSpecificAccessRole(21, $_SESSION['UserID'])|| HasSpecificAccessRole(22, $_SESSION['UserID'])){}else{
    noAccess();
}

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
    <head>
        <title>Ticket #<!--TODO Ticket Number--></title>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
    </head>
    <body>
    <div class="customJumbotron" style="">
        <h1 class="display-4"><b>Bedroom Studios, LLC</b></h1>
        <p class="lead" id="slogan"></p>
    </div>
        <div class="container">

        </div>
    </body>
</html>