<?php
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/fakenav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(HasSpecificAccessRole(40, $_SESSION['UserID']) || HasSpecificAccessRole(21, $_SESSION['UserID'])|| HasSpecificAccessRole(42, $_SESSION['UserID'])){}else{
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

if(isset($_POST['SubmitTeam'])) {

    $errors = array();

    foreach ($_POST as $key => $value) {
        if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
    }

    if ($_POST['TeamName'] == "") array_push($errors, "Team Name field blank");
    if ($_POST['TeamDepartment'] == "") array_push($errors, "Team Department field blank");
    if ($_POST['TeamLead'] == "") array_push($errors, "Team Lead field blank");
    if ($_POST['TeamColor'] == "") array_push($errors, "Team Color field blank");


    if($errors == array()) {

        $sql = "SELECT * FROM `TeamDetail` WHERE DepartmentID = ".$_POST['TeamDepartment']." AND TeamName = '".$_POST['TeamName']."'";
        $query = mysqli_query($conn, $sql);

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        }

        $count = mysqli_num_rows($query);

        if($count == 0) {

            $TeamLead = $_POST['TeamLead'];

            if ($_POST['TeamLead'] == "null") {
                $TeamLead = -1;
            }

            $sql = "INSERT INTO `TeamDetail` (`TeamID`, `DepartmentID`, `TeamLeadUserID`, `TeamName`, `TeamColor`, `CreatedBy`) VALUES (NULL, '" . $_POST['TeamDepartment'] . "', '" . $TeamLead . "', '" . $_POST['TeamName'] . "', '#" . $_POST['TeamColor'] . "', " . $_SESSION['UserID'] . ")";
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            } else {
                $TeamID = mysqli_insert_id($conn);
                if ($_POST['TeamLead'] != -1) {
                    $sql = "INSERT INTO `Team` (`TeamCacheID`, `TeamID`, `UserID`) VALUES (NULL, '" . $TeamID . "', '" . $TeamLead . "')";
                    $query = mysqli_query($conn, $sql);

                    if (!$query) {
                        array_push($errors, "DATABASE ERROR");
                        die("Error Found " . mysqli_error($conn));
                    }
                }
                echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '?TeamName=' . $_POST['TeamName'] . '";</script>';
            }
        }else{
            array_push($errors, "Team ".$_POST['TeamName']." already exists");
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
    <title>Create Team</title>
    <script src="https://bedroomstudiosllc.com/Company/API/jscolor.js"></script>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
</head>
<body>
<div class="container">
    <div id="errors"></div>
    <div class="page-header">
        <h1><b>Create Team</b></h1>
    </div>
    <form class="form-horizontal" action="CreateTeam" method="post">
        <div class="form-group">
            <label class="control-label col-sm-2" name="TeamDepartment" for="TeamDepartment">*Team's Department:</label>
            <div class="col-sm-10">
                <select class="form-control" id="TeamDepartment" name="TeamDepartment">
                    <?php echo $departmentOption; ?>
                </select>
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
            <label class="control-label col-sm-2" name="TeamName" for="TeamName">*Team Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="TeamName" name="TeamName" placeholder="Enter the team's name" value="<?php echo $_POST['TeamName']; ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="TeamColor" for="TeamColor">*Team Color:</label>
            <div class="col-sm-10">
                <input class="form-control jscolor" value="<?php if(isset($_POST['TeamColor']))echo $_POST['TeamColor']; else echo 'ffffff'; ?>" id="TeamColor" name="TeamColor">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" name="SubmitTeam" class="btn btn-default">Create Team</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>