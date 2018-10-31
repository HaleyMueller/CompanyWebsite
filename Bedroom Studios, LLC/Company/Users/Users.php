<?php
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(!isset($_SESSION['UserID'])) noAccess();

    foreach ($_GET as $key => $value) {
        if (hasSpecialCharacter($value)){ array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')"); die(); }
    }

    $roleArray = getAllRolesAccessNumber($_SESSION['UserID']);

    $body;

    $sql = "SELECT * FROM `User`";
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        //array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    }else{
        while($row = mysqli_fetch_assoc($query)) {
            $href = "'/Company/Users/ShowUser?UserID=".$row['UserID']."'";
            $body .= '<tr><td>'.$row['FName'].' '.$row['LName'].'</td><td>'.$row['Email'].'</td><td>'.phone_number_format($row['Phone']).'</td><td>'.getTeams($row['UserID']).'</td><td>'.getNotCompletedProjects($row['UserID']).'</td><td><button onClick="window.location.href = '.$href.'" class="">View</button></td></tr>';
        }
    }

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
    <head>
        <title>Users</title>
        <script src="https://bedroomstudiosllc.com/Company/API/jscolor.js"></script>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
    </head>
    <body>
        <div class="customJumbotron" style="">
            <h1 class="display-4"><b>Bedroom Studios, LLC</b></h1>
            <p class="lead" id="slogan"></p>
        </div>
        <div class="container-fluid" style="color:white;">
            <div id="errors"></div>
            <div class="page-header">
                <h1><b>Users</b></h1>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless table-responsive">
                    <thead style="">
                        <tr><th>Name</th><th>Email</th><th>Phone</th><th>Teams</th><th>Projects</th><th>View</th></tr>
                    </thead>
                    <tbody style="">
                        <?php echo $body; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>