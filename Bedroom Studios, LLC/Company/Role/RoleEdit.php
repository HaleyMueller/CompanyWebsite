<?php
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/fakenav.php';

    if(HasSpecificAccessRole(50, $_SESSION['UserID'])){}else{
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

if(isset($_POST['DeleteRole'])){

    if(HasSpecificAccessRole(-1, $_SESSION['UserID'])){}else{
        noAccess();
    }

    $TeamDepartmentID = 0;
    $TeamName = "";

    $sql = "INSERT INTO `RoleDetailHistory` (`RoleHistoryID`, `RoleID`, `RoleName`, `RoleAccessNumber`, `DeletedBy`, `DeletedDate`) VALUES (NULL, '".$_POST['RoleSelect']."', '".$_POST['RoleName']."', '".$_POST['RoleAccessNumber']."', '".$_SESSION['UserID']."', CURRENT_TIMESTAMP)";
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        $sql = "DELETE FROM `RoleDetail` WHERE `RoleID` = ".$_POST['RoleSelect'];
        $query = mysqli_query($conn, $sql);

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        } else {
            $sql = "DELETE FROM `Role` WHERE `RoleID` = ".$_POST['RoleSelect'];
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            } else {
                echo '<script>window.location.href = "'.$_SERVER['REQUEST_URI'].'?RoleName='.'Deleted'.'";</script>';
            }
        }
    }
}

if(isset($_POST['SubmitRoleChange'])) {

    $errors = array();

    foreach ($_POST as $key => $value) {
        if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
    }

    if ($_POST['RoleSelect'] == "null") array_push($errors, "Role can\'t be blank");
    if ($_POST['RoleName'] == "") array_push($errors, "Role Name can\'t be blank");
    if ($_POST['RoleAccessNumber'] == "") array_push($errors, "Role Access Number can\'t be blank"); else
        if ($_POST['RoleAccessNumber'] < 0) array_push($errors, "Role Access Number can\'t be below 0");
    if ($_POST['RoleColor'] == "") array_push($errors, "Role Color can\'t be blank");


    if($errors == array()) {

        $sql = "UPDATE `RoleDetail` SET `RoleAccessNumber` = '".$_POST['RoleAccessNumber']."', `RoleName` = '".$_POST['RoleName']."', `RoleColor` = '".$_POST['RoleColor']."', `CreatedBy` = '".$_SESSION['UserID']."' WHERE `RoleDetail`.`RoleID` = ".$_POST['RoleSelect'];
        $query = mysqli_query($conn, $sql);

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        }
        else {
            echo '<script>window.location.href = "'.$_SERVER['REQUEST_URI'].'?RoleName='.$_POST['RoleName'].'";</script>';
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
    <title>Edit Role</title>
    <script src="https://bedroomstudiosllc.com/Company/API/jscolor.js"></script>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#RoleSelect').change(function(){
                var inputValue = $(this).val();
                $.getJSON("RoleGet?roleValue="+inputValue, function(obj) {
                    var i = 0;
                    $.each(obj, function(key, value) {
                        if(i ==0){
                            $("#RoleColor").val(value.color.replace('#', ''));
                            $("#RoleAccessNumber").val(value.accessNumber);
                            $("#RoleName").val(value.name);
                        }
                        $("#RoleSelect").append("<option value='"+value.id+"'>" + value.name + "</option>");
                        i = i + 1;
                    });
                });
            });
        });
    </script>
</head>
<body>
<div class="container">
    <div id="errors"></div>
    <div class="page-header">
        <h1><b>Edit Role</b></h1>
    </div>
    <form class="form-horizontal" action="RoleEdit" method="post">
        <div class="form-group">
            <label class="control-label col-sm-2" name="RoleSelect" for="RoleSelect">*Role:</label>
            <div class="col-sm-10">
                <select class="form-control" id="RoleSelect" name="RoleSelect">
                    <option value="null"></option>
                    <?php echo $roleOption; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="RoleName" for="RoleName">*Role Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="RoleName" name="RoleName" placeholder="Enter the role's name" value="<?php echo $_POST['RoleName']; ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="RoleAccessNumber" for="RoleAccessNumber">*Role Access Number:</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="RoleAccessNumber" name="RoleAccessNumber" placeholder="Enter the role's access number" value="<?php echo $_POST['RoleAccessNumber']; ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="RoleColor" for="RoleColor">*Role Color:</label>
            <div class="col-sm-10">
                <input class="form-control jscolor" value="<?php if(isset($_POST['RoleColor']))echo $_POST['RoleColor']; else echo 'ffffff'; ?>" id="RoleColor" name="RoleColor">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4">
                <button type="submit" name="SubmitRoleChange" class="btn btn-default">Save Role</button>
                <?php if($_SESSION['UserID'] == 0) echo '<button type="submit" name="DeleteRole" class="btn btn-danger">Delete Role</button>'; ?>
            </div>
        </div>
    </form>
</div>
</body>
</html>