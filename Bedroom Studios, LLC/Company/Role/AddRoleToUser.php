<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Company/API/LoggedIn.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/fakenav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(HasSpecificAccessRole(50, $_SESSION['UserID']) || HasSpecificAccessRole(51, $_SESSION['UserID'])|| HasSpecificAccessRole(51, $_SESSION['UserID'])){}else{
        noAccess();
    }

    foreach ($_GET as $key => $value) {
        if (hasSpecialCharacter($value)){ array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')"); die(); }
    }

    $sql = "SELECT * FROM `RoleDetail`";
    $query = mysqli_query($conn, $sql);

    $roleOption = "";

    if (!$query) {
        array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while($row = mysqli_fetch_assoc($query)) {
            if($row['RoleID'] != 0)$roleOption .= '<option value="'.$row['RoleID'].'">'.$row['RoleName'].'</option>';
        }
    }

    $sql = "SELECT * FROM `User`";
    $query = mysqli_query($conn, $sql);

    $userOption = "";

    if (!$query) {
        array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while($row = mysqli_fetch_assoc($query)) {
            $userOption .= '<option value="'.$row['UserID'].'">'.$row['FName']. ' ' . $row ['LName'] . ' (' . $row['UserName'] . ')</option>';
        }
    }

    if (isset($_POST['DeleteUser'])) {

        if (HasSpecificAccessRole(-1, $_SESSION['UserID'])) {
        } else {
            noAccess();
        }

        $sql = "SELECT * FROM `Role` WHERE RoleID = ".$_POST['RoleUser']." AND UserID = ".$_POST['RoleUserName'];
        $query = mysqli_query($conn, $sql);

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        }

        $count = mysqli_num_rows($query);

        if($count > 0) {
            $sql = "INSERT INTO `RoleHistory` (`RoleHistoryID`, `RoleID`, `UserID`, `DeletedBy`, `DeletedDate`) VALUES (NULL, '" . $_POST['RoleUser'] . "', '" . $_POST['RoleUserName'] . "', '" . $_SESSION['UserID'] . "', CURRENT_TIMESTAMP)";
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            } else {
                $sql = "DELETE FROM Role WHERE RoleID = " . $_POST['RoleUser'] . " AND UserID = " . $_POST['RoleUserName'];
                $query = mysqli_query($conn, $sql);
                if (!$query) {
                    array_push($errors, "DATABASE ERROR");
                    die("Error Found " . mysqli_error($conn));
                } else {
                    echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '?Added=' . 'Deleted' . '";</script>';
                }
            }
        }else{
            echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '?Added=' . 'User doesn\'t have role' . '";</script>';
        }
    }

    if(isset($_POST['SubmitRoleToUser'])) {

        $errors = array();

        foreach ($_POST as $key => $value) {
            if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
        }

        if ($_POST['RoleUser'] == "") array_push($errors, "Team Name field blank");
        if ($_POST['RoleUserName'] == "") array_push($errors, "Team Department field blank");

        if($errors == array()) {


            $sql = "SELECT * FROM `Role` WHERE RoleID = ".$_POST['RoleUser']." AND UserID = ".$_POST['RoleUserName'];
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            }

            $count = mysqli_num_rows($query);

            //echo $count;

            if ($count > 0){
                array_push($errors, "User Already Has Role");
            }else{
                $sql = "INSERT INTO `Role` (`RoleCacheID`, `RoleID`, `UserID`) VALUES (NULL, '".$_POST['RoleUser']."', '".$_POST['RoleUserName']."')";
                $query = mysqli_query($conn, $sql);

                if (!$query) {
                    array_push($errors, "DATABASE ERROR");
                    die("Error Found " . mysqli_error($conn));
                }
                else {
                    echo '<script>window.location.href = "'.$_SERVER['REQUEST_URI'].'?Added='.$count.'";</script>';
                }
            }
        }

        if($errors != array()) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '".returnErrors($errors, 'You have the following errors:')."'}</script>";
    }

    if(isset($_GET['Added'])){
        $test = "<div class='alert alert-success'><strong>Success!</strong> Role added: ".$_GET['Added']."</div>";
        echo'<script>window.onload = function () { document.getElementById("errors").innerHTML = "'.$test.'"};</script>';
    }

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
<head>
    <title>Assign Role</title>
    <script src="https://bedroomstudiosllc.com/Company/API/jscolor.js"></script>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Company/API/Head.php';?>
</head>
<body>
<div class="container">
    <div id="errors"></div>
    <div class="page-header">
        <h1><b>Assign Role</b></h1>
    </div>
    <form class="form-horizontal" action="AddRoleToUser" method="post">
        <div class="form-group">
            <label class="control-label col-sm-2" name="RoleUser" for="RoleUser">*Role:</label>
            <div class="col-sm-10">
                <select class="form-control" id="RoleUser" name="RoleUser">
                    <?php echo $roleOption; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="RoleUserName" for="RoleUserName">*User:</label>
            <div class="col-sm-10">
                <select class="form-control" id="RoleUserName" name="RoleUserName">
                    <?php echo $userOption; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" name="SubmitRoleToUser" class="btn btn-default">Assign Role</button>
                <?php if($_SESSION['UserID'] == 0) echo '<button type="submit" name="DeleteUser" class="btn btn-danger">Delete Role From User</button>'; ?>
            </div>
        </div>
    </form>
</div>
</body>
</html>