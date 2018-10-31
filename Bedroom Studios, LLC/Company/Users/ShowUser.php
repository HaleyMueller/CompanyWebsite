<?php
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(!isset($_SESSION['UserID'])) noAccess();

    foreach ($_GET as $key => $value) {
        if (hasSpecialCharacter($value)){ array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')"); die(); }
    }
if(isset($_GET['UserID'])) {
    $roleArray = getAllRolesAccessNumber($_SESSION['UserID']);

    $isUserManager = false;

    $FullName;
    $Phone;
    $Email;
    $DOB;
    $DateCreated;
    $Description;
    $Address;
    $UserName;
    $Activity;
    $Color;
    $UserID = $_GET['UserID'];

    if (in_array(-1, $roleArray) || in_array(10, $roleArray) || $_GET['UserID'] == $_SESSION['UserID']) {
        $isUserManager = true;
    }

    $sql = "SELECT * FROM `User` LEFT JOIN `UserAddress` ON `User`.UserID = `UserAddress`.UserID LEFT JOIN `UserTimeout` ON `User`.UserID = `UserTimeout`.UserID WHERE `User`.UserID = " . $_GET['UserID'];
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        //array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while ($row = mysqli_fetch_assoc($query)) {
            $FullName = $row['FName'] . " " . $row['LName'];
            $Phone = $row['Phone'];
            $Email = $row['Email'];
            $DOB = $row['DOB'];
            $DateCreated = $row['DateCreated'];
            $Description = $row['Description'];
            $UserName = $row['UserName'];
            $Activity = $row['LastActivity'];
            $Color = $row['Color'];
            $Address = $row['Street'] . " " . $row['City'] . ", " . $row['State'] . " " . $row['ZipCode'];
        }
    }

    if(isset($_POST['SubmitUser'])){

        $errors = array();

        foreach ($_POST as $key => $value) {
            if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
        }

        if ($_POST['Phone'] == "") array_push($errors, "Phone field blank");
        if ($_POST['Email'] == "") array_push($errors, "Email field blank");
        if ($_POST['Color'] == "") array_push($errors, "Color field blank");

        if($errors == array()) {
            $sql = "UPDATE `User` SET `Color` = '#".$_POST['Color']."', `Phone` = '" . $_POST['Phone'] . "', `Email` = '" . $_POST['Email'] . "', `Description` = '" . stripcslashes($_POST['BIO']) . "' WHERE `User`.`UserID` = " . $_GET['UserID'];
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, 'Database Error');
                die("Error Found " . mysqli_error($conn));
            }else{
                echo '<script>window.location.href = "'.$_SERVER['REQUEST_URI'].'&User='.$UserName.'";</script>';
            }
        }

        if($errors != array()) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '".returnErrors($errors, 'You have the following errors:')."'}</script>";
    }

    if(isset($_GET['User'])){
        $test = "<div class='alert alert-success'><strong>Success!</strong> Saved: <b>".$_GET['User']."</b></div>";
        echo'<script>window.onload = function () { document.getElementById("errors").innerHTML = "'.$test.'"};</script>';
    }

}else{
    echo 'No user selected';
}

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
<head>
    <title><?php echo $FullName;?></title>
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
    <form class="form-horizontal" action="ShowUser?UserID=<?php echo $_GET['UserID'];?>" method="post">
        <div id="errors"></div>
        <div class="page-header">
            <h1><b><?php echo $FullName . " (" . $UserName . ")";?></b></h1>
        </div>
        <div class="row">
            <div class="col-sm-4"><center><img class="img-fluid img-thumbnail" src="/Company/Users/ProfilePictures/<?php echo getProfilePicture($_GET['UserID']); ?>" class="rounded" alt="<?php echo $FullName;?>'s Profile Picture"><h5>
                        <?php if($isUserManager) echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Change Picture</button><br><br>'; ?>
                        <b>Joined: </b><?php echo $DateCreated; ?></h5><h5><b>Last Activity: </b><?php echo $Activity; ?> UTC</h5></center></div>
            <div class="col-sm-8">
                <div class="page-header"><b><h3>Bio</h3></b></div><textarea id="BIO" name="BIO" class="form-control" <?php if(!$isUserManager)echo 'disabled'; ?>><?php echo $Description; ?></textarea>
                <div class="page-header"><b><h3>Roles</h3></b></div><?php echo getRoles($_GET['UserID']); ?>
            </div>
        </div>
        <div class="row" id="myForm">
            <div class="col-sm-4">
                <div class="page-header"><b><h3>Information</h3></b></div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="Phone" for="Phone">Phone:</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" value="<?php echo $Phone; ?>" id="Phone" name="Phone" <?php if(!$isUserManager)echo 'disabled'; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="Email" for="Email">Email:</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="email" value="<?php echo $Email; ?>" id="Email" name="Email" <?php if(!$isUserManager)echo 'disabled'; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="Color" for="Color">*Color:</label>
                    <div class="col-sm-10">
                        <input class="form-control jscolor" value="<?php if(isset($Color))echo $Color; else echo 'ffffff'; ?>" id="Color" name="Color">
                    </div>
                </div>
                <?php if($isUserManager) {
                    echo '
                            <div class="form-group" >
                            <label class="control-label col-sm-2" name = "Address" for="Address" > Address:</label >
                            <div class="col-sm-10" >
                                <input class="form-control" type = "text" value = "'.$Address.'" id = "Address" name = "Address" disabled>
                            </div >
                        </div >
                <div class="form-group">
                    <label class="control-label col-sm-2" name="DOB" for="DOB">Date of Birth:</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="date" value="'.$DOB.'" id="DOB" name="DOB" disabled ?>
                    </div>
                </div>';}?>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4">
                        <?php if($isUserManager) echo '<button type="submit" name="SubmitUser" class="btn btn-default">Save User Details</button>'; ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="page-header"><b><h3>Projects On</h3></b></div>
                <?php echo getNotCompletedProjects($_GET['UserID']); ?>
                <div class="page-header"><b><h3>Projects Completed</h3></b></div>
                <?php echo getCompletedProjects($_GET['UserID']); ?>
            </div>
            <div class="col-sm-4">
                <div class="page-header"><b><h3>Departments</h3></b></div>
                <?php echo getDepartments($_GET['UserID']); ?>
                <div class="page-header"><b><h3>Teams</h3></b></div>
                <?php echo getTeams($_GET['UserID']); ?>
            </div>
        </div>
        <?php if(HasSpecificAccessRole(20, $_SESSION['UserID']) || HasSpecificAccessRole(21, $_SESSION['UserID']) || HasSpecificAccessRole(22, $_SESSION['UserID'])) { echo '
            <div class="row" id = "myForm" >
            <div class="col-sm-6" >
                <div class="page-header" ><b ><h3 > Tickets Assigned to Me </h3 ></b ></div >
                <iframe frameborder = "0" style = "width: 100%;" scrolling = "no" onload = "resizeIframe(this)" src = "https://bedroomstudiosllc.com/Company/TicketSystem/Tickets.php?&AssignedUserID='.$_GET['UserID'].'" ></iframe >
            </div >
            <div class="col-sm-6" >
                <div class="page-header" ><b ><h3 > My Tickets </h3 ></b ></div >
                <iframe frameborder = "0" style = "width: 100%;" scrolling = "no" onload = "resizeIframe(this)" src = "https://bedroomstudiosllc.com/Company/TicketSystem/Tickets.php?&CreatedByUserID='.$_GET['UserID'].'" ></iframe >
            </div >
        </div >
        ';}?>
    </form>
</div>
</body>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="UploadProfilePicture.php?UserID=<?php echo $_GET['UserID'];?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input class="form-control" type="file" value="<?php echo $DOB; ?>" id="fileToUpload" name="fileToUpload">
                    </div>
                    <button type="submit" name="submit" class="btn btn-default">Upload Image</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</html>