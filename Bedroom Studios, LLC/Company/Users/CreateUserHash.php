<?php
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/fakenav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(HasSpecificAccessRole(10, $_SESSION['UserID']) || HasSpecificAccessRole(12, $_SESSION['UserID'])){}else{
        noAccess();
    }

    foreach ($_GET as $key => $value) {
        if (hasSpecialCharacter($value)){ array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')"); die(); }
    }

    if(isset($_POST['SubmitHash'])){ //Update to Database

        $salt = 'B7u3C0w';
        $test = rand();
        $pw_hash = md5($salt.$test);
        $isContractor = 0;
        $isEIN = 0;

        if($_POST['userType'] == "Contractor") $isContractor = 1;
        if($_POST['userType'] == "EIN") $isEIN = 1;

        $sql = "INSERT INTO `UserHash` (`HashID`, `UserID`, `IsContractor`, `isEIN`, `CreatedBy`, `CreatedDate`) VALUES ('".$pw_hash."', null, ".$isContractor.",".$isEIN.",".$_SESSION['UserID'].", default)";
        $query = mysqli_query($conn, $sql);

        if(!$query){
            die("Error Found " . mysqli_error($conn));
        }else{
            echo '<script>window.location.href = "'.$_SERVER['REQUEST_URI'].'?Success=true&Hash='.$pw_hash.'";</script>';
        }
    }

    if(isset($_GET['Success'])&&isset($_GET['Hash'])){
        $test = "<div class='alert alert-success'><strong>Success!</strong> Your hash is ".$_GET['Hash']."</div>";
        echo'<script>window.onload = function () { document.getElementById("SuccessStatus").innerHTML = "'.$test.'"};</script>';
    }
?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
    <head>
        <title>Create User Hash</title>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
    </head>
    <body>
        <!--<div class="customJumbotron" style="">
            <h1 class="display-4"><b>Bedroom Studios, LLC</b></h1>
            <p class="lead" id="slogan"></p>
        </div>-->
        <div class="container">
            <div class="page-header">
                <h1><b>New User Hash</b></h1>
            </div>
            <div id="SuccessStatus"></div>
            <form class="form-horizontal" action="CreateUserHash" method="post" style="padding:1em;">
                <div class="form-group">
                    <label for="userType">Select type of User:</label>
                    <select class="form-control" id="userType" name="userType">
                        <option>EIN</option>
                        <option>Contractor</option>
                    </select>
                </div>
              <div class="form-group">
                <div class="">
                  <button type="SubmitHash" name="SubmitHash" class="btn btn-default">Create Hash</button>
                </div>
              </div>
            </form>
        </div>
    </body>
</html>