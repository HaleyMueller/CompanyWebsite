<?php
include '../Company/API/LoggedIn.php';
include '../Company/API/nav.php';
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Error</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../Company/API/Default.css">
</head>
<body>
<div class="jumbotron" style="background-color: #88B761">
    <h1>Bedroom Studios, LLC</h1>
</div>
<div class="container" style="color: white">
    <div class="page-header">
        <h1>Database Error @ <?php echo $_GET['url'];?></h1>
    </div>
    <p>Sorry there seems to be an issue with the database right now.</p>
</div>
</body>
</html>