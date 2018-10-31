<?php
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/fakenav.php';

    if(HasSpecificAccessRole(10, $_SESSION['UserID'])){}else{
        noAccess();
    }

    foreach ($_GET as $key => $value) {
        if (hasSpecialCharacter($value)){ array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')"); die(); }
    }

    $sql = "SELECT * FROM `UserHash`";
    $query = mysqli_query($conn, $sql);

    $roleOption = "";

    if (!$query) {
        array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while($row = mysqli_fetch_assoc($query)) {
            $roleOption .= '<option value="'.$row['UserID'].'">'.$row['HashID'].'</option>';
        }
    }

    if(isset($_POST['DeleteHash'])){

        if(HasSpecificAccessRole(-1, $_SESSION['UserID'])){}else{
            noAccess();
        }

        $sql = "SELECT * FROM `UserHash` JOIN `User` ON `UserHash`.`UserID` = `User`.`UserID` WHERE `UserHash`.`UserID` = '".$_POST['HashSelect']."'";
        $query = mysqli_query($conn, $sql);

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        }

        $count = mysqli_num_rows($query);

        if($count == 0){
            $sql = "INSERT INTO `UserHashHistory` (`HashID`, `DeletedBy`, `DeletedDate`) VALUES ('".$_POST['HashSelect']."', '".$_SESSION['UserID']."', CURRENT_TIMESTAMP)";
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            } else {
                $sql = "DELETE FROM `UserHash` WHERE `UserID` = ".$_POST['HashSelect'];
                $query = mysqli_query($conn, $sql);

                if (!$query) {
                    array_push($errors, "DATABASE ERROR");
                    die("Error Found " . mysqli_error($conn));
                } else {
                    echo '<script>window.location.href = "'.$_SERVER['REQUEST_URI'].'?HashName='.'Deleted'.'";</script>';
                }
            }
        }else{
            echo '<script>window.location.href = "'.$_SERVER['REQUEST_URI'].'?HashName='.'Hash already in use'.'";</script>';
        }
    }

    if(isset($_POST['SubmitHashChange'])) {

        $errors = array();

        foreach ($_POST as $key => $value) {
            if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
        }

        if ($_POST['HashSelect'] == "null") array_push($errors, "Hash can\'t be blank");
        if ($_POST['HashType'] == "") array_push($errors, "Hash Type can\'t be blank");

        $EIN = 0;
        $Contractor = 0;

        if ($_POST['HashType'] == "EIN") $EIN = 1;
        if ($_POST['HashType'] == "Contractor") $Contractor = 1;

        if($errors == array()) {

            $sql = "UPDATE `UserHash` SET `IsContractor` = '".$Contractor."', `isEIN` = '".$EIN."', `CreatedBy` = '".$_SESSION['UserID']."', `CreatedDate` = CURRENT_TIMESTAMP WHERE `UserHash`.`UserID` = '".$_POST['HashSelect']."'";
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            }
            else {
                echo '<script>window.location.href = "'.$_SERVER['REQUEST_URI'].'?HashName='.$_POST['HashID'].'";</script>';
            }
        }

        if($errors != array()) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '".returnErrors($errors, 'You have the following errors:')."'}</script>";
    }

    if(isset($_GET['HashName'])){
        $test = "<div class='alert alert-success'><strong>Success!</strong> Your hash type is: <b>".$_GET['HashName']."</b></div>";
        echo'<script>window.onload = function () { document.getElementById("errors").innerHTML = "'.$test.'"};</script>';
    }

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
<head>
    <title>Edit Hash</title>
    <script src="https://bedroomstudiosllc.com/Company/API/jscolor.js"></script>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#HashSelect').change(function(){
                var inputValue = $(this).val();
                $.getJSON("HashGet?hashValue="+inputValue, function(obj) {
                    $.each(obj, function(key, value) {
                        $("#HashType").val(value.type);
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
        <h1><b>Edit Hash</b></h1>
    </div>
    <form class="form-horizontal" action="HashEdit" method="post">
        <div class="form-group">
            <label class="control-label col-sm-2" name="HashSelect" for="HashSelect">*Hash:</label>
            <div class="col-sm-10">
                <select class="form-control" id="HashSelect" name="HashSelect">
                    <option value="null"></option>
                    <?php echo $roleOption; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="HashType" for="HashType">*HashType:</label>
            <div class="col-sm-10">
                <select class="form-control" id="HashType" name="HashType">
                    <option value="null"></option>
                    <option value="EIN">EIN</option>
                    <option value="Contractor">Contractor</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4">
                <button type="submit" name="SubmitHashChange" class="btn btn-default">Save Hash</button>
                <?php if($_SESSION['UserID'] == 0) echo '<button type="submit" name="DeleteHash" class="btn btn-danger">Delete Hash</button>'; ?>
            </div>
        </div>
    </form>
</div>
</body>
</html>