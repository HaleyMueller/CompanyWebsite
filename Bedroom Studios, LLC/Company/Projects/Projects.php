<?php
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

if(!isset($_SESSION['UserID'])) noAccess();

$roleArray = getAllRolesAccessNumber($_SESSION['UserID']);

$body;

$sql = "SELECT * FROM `Project` JOIN `ProjectDetail` ON `Project`.ProjectID = `ProjectDetail`.ProjectID";

foreach ($_GET as $key => $value) {
    if (hasSpecialCharacter($value)){ array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')"); die(); }
}

if(isset($_GET['UserID'])){
    $sql = "SELECT * FROM `Project` JOIN `ProjectDetail` ON `Project`.ProjectID = `ProjectDetail`.ProjectID JOIN `ProjectUser` ON `ProjectDetail`.ProjectID = `ProjectUser`.ProjectID WHERE `ProjectUser`.UserID = ".$_GET['UserID'];
}

$query = mysqli_query($conn, $sql);

if (!$query) {
    //array_push($errors, "DATABASE ERROR");
    die("Error Found " . mysqli_error($conn));
}else{
    while($row = mysqli_fetch_assoc($query)) {
        $href = "'/Company/Projects/ShowProject?ProjectID=".$row['ProjectID']."'";
        $complete = "In Progress";
        if( $row['ProjectDateCompleted'] != "0000-00-00") $complete = "Completed";
        $body .= '<tr><td>'.$row['ProjectName'].'</td><td>'.$row['ProjectDescription'].'</td><td>'.$row['ProjectDate'].'</td><td>'.$complete.'</td><td>$'.$row['ProjectPrice'].'</td><td><button onClick="window.location.href = '.$href.'" class="">View</button></td></tr>';
    }
}

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
<head>
    <title>Projects</title>
    <script src="https://bedroomstudiosllc.com/Company/API/jscolor.js"></script>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
</head>
<body>
<div class="customJumbotron" style="">
    <h1 class="display-4"><b>Bedroom Studios, LLC</b></h1>
    <p class="lead" id="slogan"></p>
</div>
<div class="container-fluid" style="">
    <div id="errors"></div>
    <div class="page-header">
        <h1><b>Projects</b></h1>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless">
            <thead style="">
                <tr><th style="width:10%">Name</th><th>Description</th><th>Date Started</th><th>Status</th><th>Price</th><th>View</th></tr>
            </thead>
            <tbody style="">
                <?php echo $body; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>