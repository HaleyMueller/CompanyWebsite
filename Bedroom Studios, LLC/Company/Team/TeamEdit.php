<?php
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/fakenav.php';

    if(HasSpecificAccessRole(40, $_SESSION['UserID'])){}else{
        noAccess();
    }

    foreach ($_GET as $key => $value) {
        if (hasSpecialCharacter($value)){ array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')"); die(); }
    }

    $sql = "SELECT * FROM `Department`";
    $query = mysqli_query($conn, $sql);

    $departmentOption = "";

    if (!$query) {
        array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while($row = mysqli_fetch_assoc($query)) {
            $departmentOption .= '<option value="'.$row['DepartmentID'].'">'.$row['DepartmentName'].'</option>';
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

    if(isset($_POST['DeleteTeam'])){

        if(HasSpecificAccessRole(-1, $_SESSION['UserID'])){}else{
            noAccess();
        }

        $TeamDepartmentID = 0;
        $TeamName = "";

        $sql = "SELECT * FROM `TeamDetail` WHERE TeamID = ".$_POST['TeamSelected'];
        $query = mysqli_query($conn, $sql);

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        } else {
            while($row = mysqli_fetch_assoc($query)) {
                $TeamDepartmentID = $row['DepartmentID'];
                $TeamName = $row['TeamName'];
            }
        }

        $sql = "INSERT INTO `TeamDetailHistory` (`TeamHistoryID`, `TeamID`, `DepartmentID`, `DeletedBy`, `DeletedDate`, `TeamName`) VALUES (NULL, '".$_POST['TeamSelected']."', '".$TeamDepartmentID."', '".$_SESSION['UserID']."', CURRENT_TIMESTAMP, '".$TeamName."')";
        $query = mysqli_query($conn, $sql);

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        } else {
            $sql = "DELETE FROM `Team` WHERE `TeamID` = ".$_POST['TeamSelected'];
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            } else {
                $sql = "DELETE FROM `TeamDetail` WHERE `TeamDetail`.`TeamID` = ".$_POST['TeamSelected'];
                $query = mysqli_query($conn, $sql);

                if (!$query) {
                    array_push($errors, "DATABASE ERROR");
                    die("Error Found " . mysqli_error($conn));
                } else {
                    echo '<script>window.location.href = "'.$_SERVER['REQUEST_URI'].'?TeamName='.'Deleted'.'";</script>';
                }
            }
        }
    }

    if(isset($_POST['SubmitTeamChange'])) {

        $errors = array();

        foreach ($_POST as $key => $value) {
            if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
        }

        if ($_POST['TeamName'] == "") array_push($errors, "Team Name field blank");
        if ($_POST['TeamSelected'] == "") array_push($errors, "Team field blank");
        if ($_POST['TeamDepartment'] == "") array_push($errors, "Team Department field blank");
        if ($_POST['TeamDepartment'] == "null") array_push($errors, "Team Department can\'t be blank");
        if ($_POST['TeamLead'] == "") array_push($errors, "Team Lead field blank");
        if ($_POST['TeamColor'] == "") array_push($errors, "Team Color field blank");


        if($errors == array()) {

            $TeamLead = $_POST['TeamLead'];

            if($_POST['TeamLead'] == "null"){
                $TeamLead = -1;
            }

            $sql = "UPDATE `TeamDetail` SET `DepartmentID` = '".$_POST['TeamDepartment']."', `TeamLeadUserID` = '".$TeamLead."', `TeamName` = '".$_POST['TeamName']."', `TeamColor` = '#".$_POST['TeamColor']."', `CreatedBy` = '".$_SESSION['UserID']."'  WHERE `TeamDetail`.`TeamID` = " . $_POST['TeamSelected'];
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            }
            else {
                $sql = "UPDATE `Team` SET `UserID` = '".$TeamLead."' WHERE `Team`.`TeamID` = " . $_POST['TeamSelected'];
                $query = mysqli_query($conn, $sql);

                if (!$query) {
                    array_push($errors, "DATABASE ERROR");
                    die("Error Found " . mysqli_error($conn));
                }
                else {
                    echo '<script>window.location.href = "'.$_SERVER['REQUEST_URI'].'?TeamName='.$_POST['TeamName'].'";</script>';
                }
            }
        }

        if($errors != array()) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '".returnErrors($errors, 'You have the following errors:')."'}</script>";
    }

    if(isset($_GET['TeamName'])){
        $test = "<div class='alert alert-success'><strong>Success!</strong> Your team name is: <b>".$_GET['TeamName']."</b></div>";
        echo'<script>window.onload = function () { document.getElementById("errors").innerHTML = "'.$test.'"};</script>';
    }

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
<head>
    <title>Edit Team</title>
    <script src="https://bedroomstudiosllc.com/Company/API/jscolor.js"></script>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>


        $(document).ready(function(){
            $('#TeamDepartment').change(function(){
                var inputValue = $(this).val();
                $.getJSON("TeamGet?dropdownValue="+inputValue, function(obj) {
                    $("#TeamSelected").empty();
                    var i = 0;
                    $.each(obj, function(key, value) {
                        if(i ==0){
                            $("#TeamColor").val(value.color.replace('#', ''));
                            $("#TeamName").val(value.name);
                            $("#TeamLead").val(value.lead);
                        }
                        $("#TeamSelected").append("<option value='"+value.id+"'>" + value.name + "</option>");
                        i = i + 1;
                    });
                });
            });
            $('#TeamSelected').change(function(){
                var inputValue = $(this).val();
                $.getJSON("TeamGet?teamValue="+inputValue, function(obj) {
                    var i = 0;
                    $.each(obj, function(key, value) {
                        if(i ==0){
                            $("#TeamColor").val(value.color.replace('#', ''));
                            $("#TeamName").val(value.name);
                        }
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
        <h1><b>Edit Team</b></h1>
    </div>
    <form class="form-horizontal" action="TeamEdit" method="post">
        <div class="form-group">
            <label class="control-label col-sm-2" name="TeamDepartment" for="TeamDepartment">*Department:</label>
            <div class="col-sm-10">
                <select class="form-control" id="TeamDepartment" name="TeamDepartment">
                    <option value="null"></option>
                    <?php echo $departmentOption; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="TeamSelected" for="TeamSelected">*Team:</label>
            <div class="col-sm-10">
                <select class="form-control" id="TeamSelected" name="TeamSelected">
                    <?php echo $teamOption; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="TeamName" for="TeamName">*Team Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="TeamName" name="TeamName" placeholder="Enter the team's name" value="<?php echo $_POST['TeamName']; ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="TeamLead" for="TeamLead">Team's Lead:</label>
            <div class="col-sm-10">
                <select class="form-control" id="TeamLead" name="TeamLead">
                    <option value="null">N/A</option>
                    <?php echo $userOption; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="TeamColor" for="TeamColor">*Team Color:</label>
            <div class="col-sm-10">
                <input class="form-control jscolor" value="<?php if(isset($_POST['TeamColor']))echo $_POST['TeamColor']; else echo 'ffffff'; ?>" id="TeamColor" name="TeamColor">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4">
                <button type="submit" name="SubmitTeamChange" class="btn btn-default">Save Team</button>
                <?php if($_SESSION['UserID'] == 0) echo '<button type="submit" name="DeleteTeam" class="btn btn-danger">Delete Team</button>'; ?>
            </div>
        </div>
    </form>
</div>
</body>
</html>