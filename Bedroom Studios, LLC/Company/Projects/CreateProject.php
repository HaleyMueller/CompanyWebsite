<?php
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/fakenav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(HasSpecificAccessRole(30, $_SESSION['UserID']) || HasSpecificAccessRole(21, $_SESSION['UserID'])|| HasSpecificAccessRole(32, $_SESSION['UserID'])){}else{
        noAccess();
    }

    foreach ($_GET as $key => $value) {
        if (hasSpecialCharacter($value)){ array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')"); die(); }
    }

if(isset($_POST['SubmitProject'])) {

    $errors = array();

    foreach ($_POST as $key => $value) {
        if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
    }

    if ($_POST['ProjectName'] == "") array_push($errors, "Project Name field blank");
    if ($_POST['ProjectStartDate'] == "") array_push($errors, "Project Start Date field blank");
    if ($_POST['ClientName'] == "") array_push($errors, "Client Name field blank");
    if ($_POST['ProjectDescription'] == "") array_push($errors, "Project Description field blank");
    if ($_POST['ProjectColor'] == "") array_push($errors, "Project Color field blank");

    if($errors == array()) {

        $sql = "SELECT * FROM `Project` WHERE ProjectName = '".$_POST['ProjectName']."'";
        $query = mysqli_query($conn, $sql);

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        }

        $count = mysqli_num_rows($query);

        if($count == 0){
            $sql = "INSERT INTO `Project` (`ProjectID`, `ProjectName`) VALUES (NULL, '".$_POST['ProjectName']."')";
            $query = mysqli_query($conn, $sql);

            $ProjectID = 0;

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            } else {
                $ProjectID = mysqli_insert_id($conn);

                $sql = "INSERT INTO `ProjectDetail` (`ProjectDetailID`, `ProjectID`, `ProjectDate`, `ProjectDateCompleted`, `ProjectContactPhone`, `ProjectContactEmail`, `ProjectContactName`, `ProjectDescription`, `ProjectPrice`, `ProjectColor`, `CreatedBy`) VALUES (NULL, $ProjectID, '".$_POST['ProjectStartDate']."', '".$_POST['ProjectDateCompleted']."', '".$_POST['ClientPhone']."', '".$_POST['ClientEmail']."', '".$_POST['ClientName']."', '".$_POST['ProjectDescription']."', '".$_POST['ProjectPrice']."', '#".$_POST['ProjectColor']."', ".$_SESSION['UserID'].")";
                $query = mysqli_query($conn, $sql);

                $ProjectID = 0;

                if (!$query) {
                    array_push($errors, "DATABASE ERROR");
                    die("Error Found " . mysqli_error($conn));
                } else {
                    echo '<script>window.location.href = "'.$_SERVER['REQUEST_URI'].'?ProjectName='.$_POST['ProjectName'].'";</script>';
                }
            }
        }else{
            array_push($errors, "Project ".$_POST['ProjectName']." already exists");
        }
    }

    if($errors != array()) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '".returnErrors($errors, 'You have the following errors:')."'}</script>";
}

/*
    ProjectName
    ProjectDate Auto fills todays
    ProjectDateCompleted button that shows it if checked
    ProjectContactName
    ProjectContactPhone
    ProjectContactEmail
    ProjectDetails
    ProjectPrice
    ProjectColor
*/

if(isset($_GET['ProjectName'])){
    $test = "<div class='alert alert-success'><strong>Success!</strong> Your project name is: <b>".$_GET['ProjectName']."</b></div>";
    echo'<script>window.onload = function () { document.getElementById("errors").innerHTML = "'.$test.'"};</script>';
}

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
    <head>
        <title>Create Project</title>
        <script src="https://bedroomstudiosllc.com/Company/API/jscolor.js"></script>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
    </head>
    <script>
        /*function hide() {
            var x = document.getElementById("ProjectDateCompleted");
            var y = document.getElementById("show");
            if (x.style.display === "none") {
                x.style.display = "block";
                y.innerText = "Click to remove a completed date.";
            } else {
                x.style.display = "none";
                x.value = "2014-02-09";
                x.
                alert(x.value);
                y.innerText = "Click to add a completed date.";
            }
        }*/
    </script>
    <body>
    <!--<div class="customJumbotron" style="">
        <h1 class="display-4"><b>Bedroom Studios, LLC</b></h1>
        <p class="lead" id="slogan"></p>
    </div>-->
        <div class="container">
            <div id="errors"></div>
            <div class="page-header">
                <h1><b>Create Project</b></h1>
            </div>
            <form class="form-horizontal" action="CreateProject" method="post">
                <div class="form-group">
                    <label class="control-label col-sm-2" name="ProjectName" for="ProjectName">*Project Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ProjectName" name="ProjectName" placeholder="Enter the project's name" value="<?php echo $_POST['ProjectName']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="ProjectStartDate" for="ProjectStartDate">*Project Start Date:</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="ProjectStartDate" name="ProjectStartDate" value="<?php if(isset($_POST['ProjectStartDate']))echo $_POST['ProjectStartDate']; else echo date('Y-m-d'); ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="ProjectDateCompleted" for="ProjectDateCompleted">Project Date Completed:</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="ProjectDateCompleted" name="ProjectDateCompleted" value="<?php echo $_POST['ProjectDateCompleted']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="ClientName" for="ClientName">*Client Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ClientName" name="ClientName" placeholder="Enter the date the client's name" value="<?php echo $_POST['ClientName']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="ClientPhone" for="ClientPhone">Client Phone:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="ClientPhone" name="ClientPhone" placeholder="Enter the date the client's phone number" value="<?php echo $_POST['ClientPhone']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="ClientEmail" for="ClientEmail">Client Email:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ClientEmail" name="ClientEmail" placeholder="Enter the date the client's email" value="<?php echo $_POST['ClientEmail']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="ProjectDescription" for="ProjectDescription">*Project Description:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="5" id="ProjectDescription" name="ProjectDescription" placeholder="Enter the description of the project"><?php echo $_POST['ProjectDescription']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="ProjectPrice" for="ProjectPrice">Project Price:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="ProjectPrice" name="ProjectPrice" placeholder="Enter the full price of the project" value="<?php echo $_POST['ProjectPrice']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="ProjectColor" for="ProjectColor">*Project Color:</label>
                    <div class="col-sm-10">
                        <input class="form-control jscolor" value="<?php if(isset($_POST['ProjectColor']))echo $_POST['ProjectColor']; else echo 'ffffff'; ?>" id="ProjectColor" name="ProjectColor">
                    </div>
                </div>
                <!--<center><u><p onclick="hide()" style="text-decoration: #88B761;" id="show">Click to add a completed date.</p></u></center>-->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="SubmitProject" class="btn btn-default">Create Project</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>