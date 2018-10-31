<?php
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/fakenav.php';
//include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
//include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(HasSpecificAccessRole(50, $_SESSION['UserID']) || HasSpecificAccessRole(52)){}else{
        noAccess();
    }

    foreach ($_GET as $key => $value) {
        if (hasSpecialCharacter($value)){ array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')"); die(); }
    }

if(isset($_POST['SubmitRole'])) {

    $errors = array();

    foreach ($_POST as $key => $value) {
        if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
    }

    if ($_POST['RoleName'] == "") array_push($errors, "Role Name field blank");
    if ($_POST['RoleNum'] == "") array_push($errors, "Role Access Number field blank"); else
        if ($_POST['RoleNum'] < 1) array_push($errors, "Role Access Number can\'t be below 1");
    if (strpos($_POST['RoleNum'], "e")) array_push($errors, "Role Access Number can\'t have letters");
    if ($_POST['RoleColor'] == "") array_push($errors, "Role Color field blank");

    if($errors == array()) {

        $sql = "SELECT * FROM `RoleDetail` WHERE RoleName = '" . $_POST['RoleName']. "'";
        $query = mysqli_query($conn, $sql);

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        }

        $count = mysqli_num_rows($query);

        if ($count == 0) {

            $sql = "INSERT INTO `RoleDetail` (`RoleID`, `RoleAccessNumber`, `RoleName`, `RoleColor`, `CreatedBy`) VALUES (NULL, '" . $_POST['RoleNum'] . "', '". $_POST['RoleName'] . "', '#" . $_POST['RoleColor'] . "', " . $_SESSION['UserID'] . ")";
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            } else {
                echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '?RoleName=' . $_POST['RoleName'] . '";</script>';
            }
        }else{
            array_push($errors, "Role ".$_POST['RoleName']." already exists");
        }
    }

    if($errors != array()) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '".returnErrors($errors, 'You have the following errors:')."'}</script>";
}

if(isset($_GET['RoleName'])){
    $test = "<div class='alert alert-success'><strong>Success!</strong> Your role name is: <b>".$_GET['RoleName']."</b></div>";
    echo'<script>window.onload = function () { document.getElementById("errors").innerHTML = "'.$test.'"};</script>';
}

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
<head>
    <title>Create Role</title>
    <script src="https://bedroomstudiosllc.com/Company/API/jscolor.js"></script>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
</head>
<body>
<div class="container">
    <div id="errors"></div>
    <div class="page-header">
        <h1><b>Create Role</b></h1>
    </div>
    <form class="form-horizontal" action="CreateRole" method="post">
        <div class="form-group">
            <label class="control-label col-sm-2" name="RoleName" for="RoleName">*Role Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="RoleName" name="RoleName" placeholder="Enter the role's name" value="<?php echo $_POST['RoleName']; ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="RoleNum" for="RoleNum">*Role Access Number:</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="RoleNum" name="RoleNum" placeholder="Enter the role's access number" value="<?php echo $_POST['RoleNum']; ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="RoleColor" for="RoleColor">*Role Color:</label>
            <div class="col-sm-10">
                <input class="form-control jscolor" value="<?php if(isset($_POST['RoleColor']))echo $_POST['RoleColor']; else echo 'ffffff'; ?>" id="RoleColor" name="RoleColor">
            </div>
        </div>
        <div class="form-group" style="margin-bottom: 1em;">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" name="SubmitRole" class="btn btn-default">Create Role</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>