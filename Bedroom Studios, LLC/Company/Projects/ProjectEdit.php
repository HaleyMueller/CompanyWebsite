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

    $sql = "SELECT * FROM `Project`";
    $query = mysqli_query($conn, $sql);

    $roleOption = "";

    if (!$query) {
        array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while($row = mysqli_fetch_assoc($query)) {
            $roleOption .= '<option value="'.$row['ProjectID'].'">'.$row['ProjectName'].'</option>';
        }
    }

    if (isset($_POST['DeleteDepartment'])) {

        if (HasSpecificAccessRole(-1, $_SESSION['UserID'])) {
        } else {
            noAccess();
        }

        $TeamDepartmentID = 0;
        $TeamName = "";

        $sql = "SELECT * FROM `Project` WHERE ProjectID = ".$_POST['ProjectSelect'];
        $query = mysqli_query($conn, $sql);

        $ProjectName = "";

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        } else {
            while($row = mysqli_fetch_assoc($query)) {
                $ProjectName = $row['ProjectName'];
            }
        }

        $sql = "INSERT INTO `ProjectHistory` (`ProjectHistoryID`, `ProjectID`, `ProjectName`, `DeletedBy`, `DeletedDate`) VALUES (NULL, '".$_POST['ProjectSelect']."', '".$ProjectName."', '".$_SESSION['UserID']."', CURRENT_TIMESTAMP )";
        $query = mysqli_query($conn, $sql);

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        } else {
            $sql = "DELETE FROM `Project` WHERE ProjectID = " . $_POST['ProjectSelect'];
            $query = mysqli_query($conn, $sql);
            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            }else{
                $sql = "DELETE FROM `ProjectDetail` WHERE ProjectID = " . $_POST['ProjectSelect'];
                $query = mysqli_query($conn, $sql);
                if (!$query) {
                    array_push($errors, "DATABASE ERROR");
                    die("Error Found " . mysqli_error($conn));
                }else{
                    echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '?ProjectName=' . 'Deleted' . '";</script>';
                }
            }
        }
    }

    if (isset($_POST['SubmitDepartmentChange'])) {

        $errors = array();

        foreach ($_POST as $key => $value) {
            if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
        }

        if ($_POST['ProjectSelect'] == "null") array_push($errors, "Project can\'t be blank");
        if ($_POST['ProjectName'] == "") array_push($errors, "Project Name can\'t be blank");
        if ($_POST['ProjectColor'] == "") array_push($errors, "Project Color can\'t be blank");
        if ($_POST['ProjectDescription'] == "") array_push($errors, "Project Description can\'t be blank");
        if ($_POST['ProjectColor'] == "") array_push($errors, "Project Price can\'t be blank");
        if ($_POST['ProjectContactName'] == "") array_push($errors, "Contact Name can\'t be blank");

        if ($errors == array()) {

            $sql = "UPDATE `ProjectDetail` SET `ProjectDateCompleted` = '".$_POST['ProjectDateCompleted']."', `ProjectContactPhone` = '".$_POST['ProjectContactPhone']."', `ProjectContactEmail` = '".$_POST['ProjectContactEmail']."', `ProjectContactName` = '".$_POST['ProjectContactName']."', `ProjectDescription` = '".$_POST['ProjectDescription']."', `ProjectPrice` = '".$_POST['ProjectPrice']."', `ProjectColor` = '#".$_POST['ProjectColor']."', `CreatedBy` = '".$_SESSION['UserID']."' WHERE `ProjectDetail`.`ProjectDetailID` = " . $_POST['ProjectSelect'];
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            } else {
                $sql = "UPDATE `Project` SET `ProjectName` = '".$_POST['ProjectName']."' WHERE `Project`.`ProjectID` = ".$_POST['ProjectSelect'];
                $query = mysqli_query($conn, $sql);

                if (!$query) {
                    array_push($errors, "DATABASE ERROR");
                    die("Error Found " . mysqli_error($conn));
                } else {
                    echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '?ProjectName=' . $_POST['ProjectName'] . '";</script>';
                }
            }
        }

        if ($errors != array()) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '" . returnErrors($errors, 'You have the following errors:') . "'}</script>";
    }

    if(isset($_GET['ProjectName'])){
        $test = "<div class='alert alert-success'><strong>Success!</strong> Your project name is: <b>".$_GET['ProjectName']."</b></div>";
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
            $('#ProjectSelect').change(function(){
                var inputValue = $(this).val();
                $.getJSON("ProjectGet?projectValue="+inputValue, function(obj) {
                    $.each(obj, function(key, value) {
                        $("#ProjectContactName").val(value.contactName);
                        $("#ProjectContactPhone").val(value.contactPhone.replace('-', '').replace('-', ''));
                        $("#ProjectContactEmail").val(value.contactEmail);
                        $("#ProjectDateCompleted").val(value.dateCompleted);
                        $("#ProjectDate").val(value.date);
                        $("#ProjectDescription").val(value.description);
                        $("#ProjectPrice").val(value.price);
                        $("#ProjectName").val(value.name);
                        $("#ProjectColor").val(value.color.replace('#', ''));
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
        <h1><b>Edit Project</b></h1>
    </div>
    <form class="form-horizontal" action="ProjectEdit" method="post">
        <div class="form-group">
            <label class="control-label col-sm-2" name="ProjectSelect" for="ProjectSelect">*Project:</label>
            <div class="col-sm-10">
                <select class="form-control" id="ProjectSelect" name="ProjectSelect">
                    <option value="null"></option>
                    <?php echo $roleOption; ?>
                </select>
            </div>
        </div>
        <div class="page-header">
            <h3>Details</h3>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="ProjectName" for="ProjectName">*Project Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="ProjectName" name="ProjectName" placeholder="Enter the project's name" value="<?php echo $_POST['ProjectName']; ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="ProjectDate" for="ProjectDate">Project Date:</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" id="ProjectDate" name="ProjectDate" value="<?php echo $_POST['ProjectDateCompleted']; ?>" disabled/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="ProjectDateCompleted" for="ProjectDateCompleted">Project Completed Date:</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" id="ProjectDateCompleted" name="ProjectDateCompleted" placeholder="Enter the project's completed date" value="<?php echo $_POST['ProjectDateCompleted']; ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="ProjectDescription" for="ProjectDescription">*Project Description:</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="ProjectDescription" name="ProjectDescription" placeholder="Enter the project's description"><?php echo $_POST['ProjectDescription']; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="ProjectPrice" for="ProjectPrice">*Project Price:</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="ProjectPrice" name="ProjectPrice" placeholder="Enter the project's price" value="<?php echo $_POST['ProjectPrice']; ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="ProjectColor" for="ProjectColor">*Project Color:</label>
            <div class="col-sm-10">
                <input class="form-control jscolor" value="<?php if(isset($_POST['ProjectColor']))echo $_POST['ProjectColor']; else echo 'ffffff'; ?>" id="ProjectColor" name="ProjectColor">
            </div>
        </div>
        <div class="page-header">
            <h3>Contact Information</h3>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="ProjectContactName" for="ProjectContactName">*Contact Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="ProjectContactName" name="ProjectContactName" placeholder="Enter the contact's name" value="<?php echo $_POST['ProjectContactName']; ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="ProjectContactPhone" for="ProjectContactPhone">Contact Phone:</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="ProjectContactPhone" name="ProjectContactPhone" placeholder="Enter the contact's phone" value="<?php echo $_POST['ProjectContactPhone']; ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" name="ProjectContactEmail" for="ProjectContactEmail">Contact Email:</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="ProjectContactEmail" name="ProjectContactEmail" placeholder="Enter the contact's email" value="<?php echo $_POST['ProjectContactEmail']; ?>"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4">
                <button type="submit" name="SubmitDepartmentChange" class="btn btn-default">Save Project</button>
                <?php if($_SESSION['UserID'] == 0) echo '<button type="submit" name="DeleteDepartment" class="btn btn-danger">Delete Project</button>'; ?>
            </div>
        </div>
    </form>
</div>
</body>
</html>