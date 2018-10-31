<?php
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

$errors = array();

if(isset($_POST['submit'])) {


    if ($_POST['userName'] == "") array_push($errors, "Username blank");
    if ($_POST['password'] == "") array_push($errors, "Password blank");


    $sql = "SELECT * FROM `User` INNER JOIN UserPass on UserPass.UserID = User.UserID";
    $query = mysqli_query($conn, $sql);

    $isLoggingIn = false;

    $thing = explode(".", $_POST['userName']);
    $userName = ucfirst(strtolower($thing[0])) . '.' . ucfirst(strtolower($thing[1]));

    if (!$query) {
        die("Error Found " . mysqli_error($conn));
    } else {
        while($row = mysqli_fetch_assoc($query)) {
            if($row['UserName'] == $userName && $row['UserPassword'] == $_POST['password']){
                $isLoggingIn = true;

                $sql = "INSERT INTO `UserLog` (`UserLogID`, `UserID`, `LastLoginDate`, `LastLoggedIP`, `LastUpdated`) VALUES (NULL, '".$row['UserID']."', CURRENT_TIMESTAMP, '".$_SERVER['REMOTE_ADDR']."', CURRENT_TIMESTAMP)";
                $query = mysqli_query($conn, $sql);

                $_SESSION['UserID'] = $row['UserID'];

                if (!$query) {
                    die("Error Found " . mysqli_error($conn));
                } else {
                    $sql = "SELECT * FROM `UserTimeout` WHERE UserID = ".$_SESSION['UserID'];
                    $query = mysqli_query($conn, $sql);

                    if(!$query) {
                        die("Connection failed2: " . $conn->connect_error);
                    }
                    $count = mysqli_num_rows($query);

                    if($count == 0) {
                        echo 'new';
                        $sql = "INSERT INTO `UserTimeout` (`UserTimeoutID`, `UserID`, `LastActivity`) VALUES (NULL, '" . $_SESSION['UserID'] . "', CURRENT_TIMESTAMP )";
                        $query = mysqli_query($conn, $sql);

                        if(!$query) {
                            die("Connection failed3: " . $conn->connect_error);
                        }
                        $_SESSION['UserID'] = $row['UserID'];
                    }else{
                        echo 'update';
                        $sql = "UPDATE `UserTimeout` SET `LastActivity` = CURRENT_TIMESTAMP WHERE UserID = ".$_SESSION['UserID'];
                        $query = mysqli_query($conn, $sql);

                        if(!$query) {
                            die("Connection failed4: " . $conn->connect_error);
                        }
                        $_SESSION['UserID'] = $row['UserID'];
                    }
                    if($query) {
                        echo '<script>window.location.href = "/Company/Dashboard";</script>';
                    }
                }
            }
        }
        if(!$isLoggingIn){
            array_push($errors, "Username and/or Password invalid");
            if($errors != array()) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '".returnErrors($errors, 'You have the following errors:')."'}</script>";
        }
    }
}

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
    <head>
        <title>Login</title>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
    </head>
<body>
    <div class="customJumbotron" style="">
        <h1 class="display-4"><b>Bedroom Studios, LLC</b></h1>
        <p class="lead" id="slogan"></p>
    </div>
    <div class="container">
        <div id="errors"></div>
        <div class="page-header">
            <h1><b>Login</b></h1>
    </div>
    <form class="form-horizontal" action="Login" method="post">
        <div class="form-group">
            <label class="control-label col-sm-2" for="userName">User Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="userName" id="userName" value="<?php echo $_POST['userName']; ?>"placeholder="Enter username">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="password">Password:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" name="submit" class="btn btn-default">Login</button>
            </div>
        </div>
    </form>
        <center><a href="Register" style="color:white;">Don't have an account? Register</a></center>
</body>
<?php
//ob_end_flush();
?>
</html>