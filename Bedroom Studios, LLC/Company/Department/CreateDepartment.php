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

if(isset($_POST['SubmitDepartment'])) {

    $errors = array();

    foreach ($_POST as $key => $value) {
        if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
    }

    if ($_POST['DepartmentName'] == "") array_push($errors, "Department Name field blank");
    if ($_POST['DepartmentColor'] == "") array_push($errors, "Department Color field blank");

    if($errors == array()) {

        $sql = "SELECT * FROM `Department` WHERE DepartmentName = '" . $_POST['DepartmentName']. "'";
        $query = mysqli_query($conn, $sql);

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        }

        $count = mysqli_num_rows($query);

        if ($count = 0) {

            $sql = "INSERT INTO `Department` (`DepartmentID`, `DepartmentColor`, `DepartmentName`, `CreatedBy`) VALUES (NULL, '#" . $_POST['DepartmentColor'] . "', '" . $_POST['DepartmentName'] . "', " . $_SESSION['UserID'] . ")";
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            } else {
                echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '?DepartmentName=' . $_POST['DepartmentName'] . '";</script>';
            }
        }else{
            array_push($errors, "Department ".$_POST['DepartmentName']." already exists");
        }
    }

    if($errors != array()) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '".returnErrors($errors, 'You have the following errors:')."'}</script>";
}

if(isset($_GET['DepartmentName'])){
    $test = "<div class='alert alert-success'><strong>Success!</strong> Your department name is: <b>".$_GET['DepartmentName']."</b></div>";
    echo'<script>window.onload = function () { document.getElementById("errors").innerHTML = "'.$test.'"};</script>';
}

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
    <head>
        <title>Create Department</title>
        <script src="https://bedroomstudiosllc.com/Company/API/jscolor.js"></script>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
    </head>
    <body>
        <div class="container">
            <div id="errors"></div>
            <div class="page-header">
                <h1><b>Create Department</b></h1>
            </div>
            <form class="form-horizontal" action="CreateDepartment" method="post">
                <div class="form-group">
                    <label class="control-label col-sm-2" name="DepartmentName" for="DepartmentName">*Department Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="DepartmentName" name="DepartmentName" placeholder="Enter the department's name" value="<?php echo $_POST['DepartmentName']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="DepartmentColor" for="DepartmentColor">*Department Color:</label>
                    <div class="col-sm-10">
                        <input class="form-control jscolor" value="<?php if(isset($_POST['DepartmentColor']))echo $_POST['DepartmentColor']; else echo 'ffffff'; ?>" id="DepartmentColor" name="DepartmentColor">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 1em;">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="SubmitDepartment" class="btn btn-default">Create Department</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>