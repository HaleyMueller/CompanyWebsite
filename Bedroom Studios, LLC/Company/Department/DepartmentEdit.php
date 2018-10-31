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

    $roleOption = "";

    if (!$query) {
        array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while($row = mysqli_fetch_assoc($query)) {
            $roleOption .= '<option value="'.$row['DepartmentID'].'">'.$row['DepartmentName'].'</option>';
        }
    }

    if (isset($_POST['DeleteDepartment'])) {

            if (HasSpecificAccessRole(-1, $_SESSION['UserID'])) {
            } else {
                noAccess();
            }

            $TeamDepartmentID = 0;
            $TeamName = "";

            $sql = "INSERT INTO `DepartmentHistory` (`DepartmentHistoryID`, `DepartmentID`, `DepartmentName`, `DeletedBy`, `DeletedDate`) VALUES (NULL, '" . $_POST['DepartmentSelect'] . "', '" . $_POST['DepartmentName'] . "', '" . $_SESSION['UserID'] . "', CURRENT_TIMESTAMP)";
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            } else {
                $sql = "DELETE FROM `Department` WHERE DepartmentID = " . $_POST['DepartmentSelect'];
                $query = mysqli_query($conn, $sql);
                if (!$query) {
                    echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '?DepartmentName=' . 'Deleted' . '";</script>';
                }
            }
        }

    if (isset($_POST['SubmitDepartmentChange'])) {

            $errors = array();

            foreach ($_POST as $key => $value) {
                if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
            }

            if ($_POST['DepartmentSelect'] == "null") array_push($errors, "Department can\'t be blank");
            if ($_POST['DepartmentName'] == "") array_push($errors, "Department Name can\'t be blank");
            if ($_POST['DepartmentColor'] == "") array_push($errors, "Department Color can\'t be blank");


            if ($errors == array()) {

                $sql = "UPDATE `Department` SET `DepartmentColor` = '#" . $_POST['DepartmentColor'] . "', `DepartmentName` = '" . $_POST['DepartmentName'] . "', `CreatedBy` = '" . $_SESSION['UserID'] . "' WHERE `Department`.`DepartmentID` = " . $_POST['DepartmentSelect'];
                $query = mysqli_query($conn, $sql);

                if (!$query) {
                    array_push($errors, "DATABASE ERROR");
                    die("Error Found " . mysqli_error($conn));
                } else {
                    echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '?DepartmentName=' . $_POST['DepartmentName'] . '";</script>';
                }
            }

            if ($errors != array()) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '" . returnErrors($errors, 'You have the following errors:') . "'}</script>";
        }

    if(isset($_GET['DepartmentName'])){
        $test = "<div class='alert alert-success'><strong>Success!</strong> Your department name is: <b>".$_GET['DepartmentName']."</b></div>";
        echo'<script>window.onload = function () { document.getElementById("errors").innerHTML = "'.$test.'"};</script>';
    }

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
<head>
    <title>Edit Department</title>
    <script src="https://bedroomstudiosllc.com/Company/API/jscolor.js"></script>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#DepartmentSelect').change(function(){
                var inputValue = $(this).val();
                $.getJSON("DepartmentGet?departmentValue="+inputValue, function(obj) {
                    $.each(obj, function(key, value) {
                            $("#DepartmentColor").val(value.color.replace('#', ''));
                            $("#DepartmentName").val(value.name);
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
        <h1><b>Edit Department</b></h1>
    </div>
    <form class="form-horizontal" action="DepartmentEdit" method="post">
        <div class="form-group">
            <label class="control-label col-sm-2" name="DepartmentSelect" for="DepartmentSelect">*Department:</label>
            <div class="col-sm-10">
                <select class="form-control" id="DepartmentSelect" name="DepartmentSelect">
                    <option value="null"></option>
                    <?php echo $roleOption; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="DepartmentName" for="DepartmentName">*Department Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="DepartmentName" name="DepartmentName" placeholder="Enter the departments's name" value="<?php echo $_POST['DepartmentName']; ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="DepartmentColor" for="DepartmentColor">*Department Color:</label>
            <div class="col-sm-10">
                <input class="form-control jscolor" value="<?php if(isset($_POST['DepartmentColor']))echo $_POST['DepartmentColor']; else echo 'ffffff'; ?>" id="DepartmentColor" name="DepartmentColor">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4">
                <button type="submit" name="SubmitDepartmentChange" class="btn btn-default">Save Department</button>
                <?php if($_SESSION['UserID'] == 0) echo '<button type="submit" name="DeleteDepartment" class="btn btn-danger">Delete Department</button>'; ?>
            </div>
        </div>
    </form>
</div>
</body>
</html>