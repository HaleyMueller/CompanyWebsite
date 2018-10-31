<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_set_cookie_params(0);
		session_start();
	}
	include 'nav.php';
?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
    <head>
        <title>Logging Out</title>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
        <meta http-equiv="Pragma" content="no-cache"/>
        <meta http-equiv="Expires" content="0"/>
    </head>
    <body>
        <div class="jumbotron">
            <h1>Bedroom Studios, LLC</h1>
        </div>
        <?php
            ob_start();
            session_destroy();

            echo '<script>window.open("http://bedroomstudiosllc.com/Company/Home", "_self");</script>';
        ?>
    </body>
</html>