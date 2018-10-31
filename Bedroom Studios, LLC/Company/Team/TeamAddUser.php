<?php
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/fakenav.php';

    if(HasSpecificAccessRole(30, $_SESSION['UserID'])){}else{
        noAccess();
    }

    foreach ($_GET as $key => $value) {
        if (hasSpecialCharacter($value)){ array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')"); die(); }
    }

    $sql = "SELECT * FROM `TeamDetail`";
    $query = mysqli_query($conn, $sql);

    $roleOption = "";

    if (!$query) {
        array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while($row = mysqli_fetch_assoc($query)) {
            $roleOption .= '<option value="'.$row['TeamID'].'">'.$row['TeamName'].'</option>';
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

        $sql = "SELECT * FROM `Team` WHERE UserID = ".$_POST['UserSelect']." AND TeamID = ".$_POST['TeamSelect'];
        $query = mysqli_query($conn, $sql);

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        }

        $count = mysqli_num_rows($query);

        if($count != 0) {
            $sql = "INSERT INTO `TeamHistory` (`TeamHistoryID`, `TeamID`, `UserID`, `DeletedBy`, `DeletedDate`) VALUES (NULL, '" . $_POST['TeamSelect'] . "', '" . $_POST['UserSelect'] . "', '" . $_SESSION['UserID'] . "', CURRENT_TIMESTAMP)";
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            } else {
                $sql = "DELETE FROM Team WHERE TeamID = " . $_POST['TeamSelect'] . " AND UserID = " . $_POST['UserSelect'];
                $query = mysqli_query($conn, $sql);
                if (!$query) {
                    array_push($errors, "DATABASE ERROR");
                    die("Error Found " . mysqli_error($conn));
                } else {
                    echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '?RoleName=' . 'Deleted' . '";</script>';
                }
            }
        }else {
            echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '?RoleName=' . 'User doesn\'t have Team' . '";</script>';
        }
    }

    if(isset($_POST['SubmitUser'])) {

        $errors = array();

        foreach ($_POST as $key => $value) {
            if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
        }

        if ($_POST['TeamSelect'] == "null") array_push($errors, "Team can\'t be blank");
        if ($_POST['UserSelect'] == "") array_push($errors, "User can\'t be blank");

        if($errors == array()) {

            $sql = "SELECT * FROM `Team` WHERE UserID = ".$_POST['UserSelect']." AND TeamID = ".$_POST['TeamSelect'];
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            }

            $count = mysqli_num_rows($query);

            if($count == 0) {
                $sql = "INSERT INTO `Team` (`TeamCacheID`, `TeamID`, `UserID`) VALUES (NULL, '".$_POST['TeamSelect']."', '".$_POST['UserSelect']."')";
                $query = mysqli_query($conn, $sql);

                if (!$query) {
                    array_push($errors, "DATABASE ERROR");
                    die("Error Found " . mysqli_error($conn));
                } else {
                    echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '?RoleName=' . $_POST['UserSelect'] .  '";</script>';
                }
            }else {
                echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '?RoleName=' . 'User already in Team' . '";</script>';
            }
        }

        if($errors != array()) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '".returnErrors($errors, 'You have the following errors:')."'}</script>";
    }

    if(isset($_GET['RoleName'])){
        $test = "<div class='alert alert-success'><strong>Success!</strong> Your project has assigned User #<b>".$_GET['RoleName']."</b></div>";
        echo'<script>window.onload = function () { document.getElementById("errors").innerHTML = "'.$test.'"};</script>';
    }

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
<head>
    <title>Add User to Team</title>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
</head>
<body>
<div class="container">
    <div id="errors"></div>
    <div class="page-header">
        <h1><b>Add User to Team</b></h1>
    </div>
    <form class="form-horizontal" action="TeamAddUser" method="post">
        <div class="form-group">
            <label class="control-label col-sm-2" name="TeamSelect" for="TeamSelect">*Team:</label>
            <div class="col-sm-10">
                <select class="form-control" id="TeamSelect" name="TeamSelect">
                    <?php echo $roleOption; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="UserSelect" for="UserSelect">*User:</label>
            <div class="col-sm-10">
                <select class="form-control" id="UserSelect" name="UserSelect">
                    <?php echo $userOption; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4">
                <button type="submit" name="SubmitUser" class="btn btn-default">Add User</button>
                <?php if($_SESSION['UserID'] == 0) echo '<button type="submit" name="DeleteUser" class="btn btn-danger">Delete User From Team</button>'; ?>
            </div>
        </div>
    </form>
</div>
</body>
</html>