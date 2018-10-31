<?php
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

if(!isset($_SESSION['UserID'])) noAccess();

if(isset($_GET['ProjectID'])) {
    $roleArray = getAllRolesAccessNumber($_SESSION['UserID']);

    $isProjectManager = false;

    $Name;
    $ProjectDate;
    $ProjectDateCompleted;
    $ContactPhone;
    $ContactEmail;
    $ContactName;
    $Description;
    $Price;
    $Color;
    $ProjectID = $_GET['ProjectID'];

    if (in_array(-1, $roleArray) || in_array(30, $roleArray)) {
        $isProjectManager = true;
    }

    $sql = "SELECT * FROM `Project` JOIN `ProjectDetail` ON `Project`.ProjectID = `ProjectDetail`.ProjectID WHERE `Project`.ProjectID = " . $_GET['ProjectID'];
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        //array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while ($row = mysqli_fetch_assoc($query)) {
            $Name = $row['ProjectName'];
            $ProjectDate = $row['ProjectDate'];
            $ProjectDateCompleted = $row['ProjectDateCompleted'];
            $ContactPhone = $row['ProjectContactPhone'];
            $ContactEmail = $row['ProjectContactEmail'];
            $ContactName = $row['ProjectContactName'];
            $Description = $row['ProjectDescription'];
            $Price = $row['ProjectPrice'];
            $Color = $row['ProjectColor'];
        }
    }

    if(isset($_POST['SubmitProject'])){

        $errors = array();

        foreach ($_POST as $key => $value) {
            if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
        }

        foreach ($_GET as $key => $value) {
            if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
        }

        if ($_POST['Name'] == "") array_push($errors, "Project Name field blank");
        if ($_POST['Description'] == "") array_push($errors, "Description field blank");
        if ($_POST['ContactPhone'] == "") array_push($errors, "Contact Phone field blank");
        if ($_POST['ContactEmail'] == "") array_push($errors, "Contact Email field blank");
        if ($_POST['ContactName'] == "") array_push($errors, "Contact Name field blank");
        if ($_POST['Color'] == "") array_push($errors, "Color field blank");

        if($errors == array()) {
            $sql = "UPDATE `ProjectDetail` SET `ProjectDateCompleted` = '".$_POST['DateCompleted']."', `ProjectContactPhone` = '".$_POST['ContactPhone']."', `ProjectContactEmail` = '".$_POST['ContactEmail']."', `ProjectContactName` = '".$_POST['ContactName']."', `ProjectDescription` = '".$_POST['Description']."', `ProjectPrice` = '".$_POST['Price']."', `ProjectColor` = '#".$_POST['Color']."' WHERE ProjectID = " . $_GET['ProjectID'];
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, 'Database Error');
                die("Error Found " . mysqli_error($conn));
            }else{
                $sql = "UPDATE `Project` SET `ProjectName` = '".$_POST['Name']."' WHERE ProjectID = " . $_GET['ProjectID'];
                $query = mysqli_query($conn, $sql);

                if (!$query) {
                    array_push($errors, 'Database Error');
                    die("Error Found " . mysqli_error($conn));
                }else {
                    echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '&Project=' . $Name . '";</script>';
                }
            }
        }

        if($errors != array()) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '".returnErrors($errors, 'You have the following errors:')."'}</script>";
    }

    if(isset($_GET['Project'])){
        $test = "<div class='alert alert-success'><strong>Success!</strong> Saved: <b>".$_GET['Project']."</b></div>";
        echo'<script>window.onload = function () { document.getElementById("errors").innerHTML = "'.$test.'"};</script>';
    }

}else{
    echo 'No project selected';
}

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml" xmlns="http://www.w3.org/1999/html">
<head>
    <title><?php echo $Name;?></title>
    <script src="https://bedroomstudiosllc.com/Company/API/jscolor.js"></script>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
    <script>
        function resizeIframe(obj) {
            obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
        }
    </script>
</head>
<body>
<div class="customJumbotron" style="">
    <h1 class="display-4"><b>Bedroom Studios, LLC</b></h1>
    <p class="lead" id="slogan"></p>
</div>
<div class="container-fluid" style="color:white;">
        <div id="errors"></div>
        <div class="page-header">
            <h1><b><?php echo $Name;?></b></h1>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <form class="form-horizontal" action="ShowProject?ProjectID=<?php echo $_GET['ProjectID'];?>" method="post">
                    <div class="page-header"><b><h3>Information</h3></b></div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" name="Name" for="Name">*Project Name:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" value="<?php echo $Name; ?>" id="Name" name="Name" <?php if(!$isProjectManager)echo 'disabled'; ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" name="Description" for="Description">*Description:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="Description" name="Description" <?php if(!$isProjectManager)echo 'disabled'; ?>><?php echo $Description; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" name="Date" for="Date">*Date Started:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="date" value="<?php echo $ProjectDate; ?>" id="Date" name="Date" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" name="DateCompleted" for="DateCompleted">Date Complete:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="date" value="<?php echo $ProjectDateCompleted; ?>" id="DateCompleted" name="DateCompleted" <?php if(!$isProjectManager)echo 'disabled'; ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" name="ContactName" for="ContactName">*Contact Name:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" value="<?php echo $ContactName; ?>" id="ContactName" name="ContactName" <?php if(!$isProjectManager)echo 'disabled'; ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" name="ContactPhone" for="ContactPhone">Contact Phone:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="number" value="<?php echo $ContactPhone; ?>" id="ContactPhone" name="ContactPhone" <?php if(!$isProjectManager)echo 'disabled'; ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" name="ContactEmail" for="ContactEmail">Contact Email:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" value="<?php echo $ContactEmail; ?>" id="ContactEmail" name="ContactEmail" <?php if(!$isProjectManager)echo 'disabled'; ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" name="Price" for="Price">*Price:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="number" value="<?php echo $Price; ?>" id="Price" name="Price" <?php if(!$isProjectManager)echo 'disabled'; ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" name="Color" for="Color">*Project Color:</label>
                        <div class="col-sm-10">
                            <input class="form-control jscolor" value="<?php if(isset($Color))echo $Color; else echo 'ffffff'; ?>" id="Color" name="Color">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-4">
                            <?php if($isProjectManager) echo '<button type="submit" name="SubmitProject" class="btn btn-default">Save Project Details</button>'; ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-4">
                <?php if($isProjectManager) echo'<div class="page-header"><b><h3>Add User to Project</h3></b></div><iframe frameborder="0" style="width: 100%;" scrolling="no" onload="resizeIframe(this)" src="/Company/Projects/ProjectAddUser"></iframe>'; ?>
            </div>
            <div class="col-sm-3">
                <?php

                    if(isset($_POST['Credentials'])){
                        $errors = array();

                        foreach ($_POST as $key => $value) {
                            if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
                        }

                        foreach ($_GET as $key => $value) {
                            if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
                        }

                        if ($_POST['Service'] == "") array_push($errors, "Service field blank");
                        if ($_POST['UserName'] == "") array_push($errors, "User Name field blank");
                        if ($_POST['Pass'] == "") array_push($errors, "Password field blank");

                        if($errors == array()) {
                            $sql = "INSERT INTO `ProjectPass` (`ProjectPassID`, `ProjectID`, `ProjectService`, `ProjectUserName`, `ProjectPassword`) VALUES (NULL, '" . $_GET['ProjectID'] . "', '" . $_POST['Service'] . "', '" . $_POST['UserName'] . "', '" . $_POST['Pass'] . "')";
                            $query = mysqli_query($conn, $sql);

                            $userOption = "";

                            if (!$query) {
                                array_push($errors, "DATABASE ERROR");
                                die("Error Found " . mysqli_error($conn));
                            } else {
                                echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '&Cred=' . $Name . '";</script>';
                            }
                        }else{
                            echo "<script>window.onload = function () { document.getElementById('cred').innerHTML = '".returnErrors($errors, 'You have the following errors:')."'}</script>";
                        }
                    }

                    if(isset($_GET['Cred'])){
                        $tes = "<div class='alert alert-success'><strong>Success!</strong> Saved: <b>".$_GET['Cred']."</b></div>";
                        echo'<script>window.onload = function () { document.getElementById("errors").innerHTML = "'.$tes.'"};</script>';
                    }

                if($isProjectManager) echo'<div class="page-header"><b><h3>Add Credentials</h3></b></div>'; ?>
                <div id="cred"></div>
                <form class="form-horizontal" action="ShowProject?ProjectID=<?php echo $_GET['ProjectID'];?>" method="post">
                    <div class="form-group">
                        <label class="control-label col-sm-2" name="Service" for="Service">*Service:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="Service" name="Service">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" name="UserName" for="UserName">*User Name:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="UserName" name="UserName">
                        </div>
                    </div><div class="form-group">
                        <label class="control-label col-sm-2" name="Pass" for="Pass">*Password:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="password" id="Pass" name="Pass">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-4">
                            <button type="submit" name="Credentials" class="btn btn-default">Save Credentials</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row" style="margin-bottom: 1em;">
            <?php if(HasSpecificAccessRole(20, $_SESSION['UserID']) || HasSpecificAccessRole(21, $_SESSION['UserID']) || HasSpecificAccessRole(22, $_SESSION['UserID'])) {
            echo '
            <div class="col-sm-8">
                <div class="page-header"><b><h3>Tickets</h3></b></div>
                <iframe frameborder="0" style="width: 100%;" scrolling="no" onload="resizeIframe(this)" src="https://bedroomstudiosllc.com/Company/TicketSystem/Tickets.php?&ProjectID='.$_GET['ProjectID'].'"></iframe>
            </div>
                    '; } ?>
            <div class="col-sm-4">
                <div class="page-header"><b><h3>Users Assigned to Project</h3></b></div>
                <?php echo getUsersOnProject($_GET['ProjectID']); ?>
            </div>
        </div>
    </div>
</body>
</html>