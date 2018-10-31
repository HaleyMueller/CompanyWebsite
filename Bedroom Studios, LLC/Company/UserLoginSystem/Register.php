<?php
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    $errors = array();

    $UserID = -1;

    if(isset($_POST['submit'])){

        foreach($_POST as $key=>$value){
            if(hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
        }

        if($_POST['Hash'] == "") array_push($errors, "Hash field blank");
        if($_POST['FirstName'] == "") array_push($errors, "FirstName field blank");
        if($_POST['LastName'] == "") array_push($errors, "Last name field blank");
        if($_POST['BirthDay'] == "") array_push($errors, "Birthday field blank");
        if($_POST['StreetAddress'] == "") array_push($errors, "Street Address field blank");
        if($_POST['City'] == "") array_push($errors, "City field blank");
        if($_POST['State'] == "") array_push($errors, "State field blank");
        if($_POST['Zipcode'] == "") array_push($errors, "Zipcode field blank");
        if($_POST['Password'] == "") array_push($errors, "Password field blank");
        else if($_POST['Password1'] == "") array_push($errors, "Retype Password field blank");
        else if($_POST['Password'] != $_POST['Password1']) array_push($errors, "Passwords do not match");
        else if(strlen($_POST['Password']) <= 5) array_push($errors, "Passwords must be longer than 5 characters");

        $sql = "SELECT * FROM `UserHash` INNER JOIN User on User.UserID = UserHash.UserID";
        $query = mysqli_query($conn, $sql);

        $passedHashVerification = false;

        if(!$query){
            die("Error Found " . mysqli_error($conn));
        }else{
            $matchedHash = false;
            while($row = mysqli_fetch_assoc($query)) {
                if($row['HashID'] == $_POST['Hash']){
                    $matchedHash = true;
                }
            }
            if($matchedHash) array_push($errors, "Hash is invalid");
            else{
                $sql = "SELECT * FROM `UserHash`";
                $query = mysqli_query($conn, $sql);

                if(!$query){
                    die("Error Found " . mysqli_error($conn));
                }else{
                    $matchedHash = false;
                    while($row = mysqli_fetch_assoc($query)) {
                        if($row['HashID'] == $_POST['Hash']){
                            $matchedHash = true;
                            $UserID = $row['UserID'];
                        }
                    }
                    if(!$matchedHash) array_unshift($errors, 'Hash is invalid');
                    else $passedHashVerification = true;
                }
            }
        }

        $UserName = ucfirst(strtolower($_POST['FirstName'])) . '.' . ucfirst(strtolower($_POST['LastName']));
        $sq = "SELECT * FROM User WHERE UserName LIKE '".$UserName."%'";
        $quer = mysqli_query($conn, $sq);
        $count = mysqli_num_rows($quer);
        if($count > 0) {
            $UserName = $UserName . $count; // or $userName = $userName . ($count + 1)
        }

        if($passedHashVerification && $errors == array()){
            $sql = "INSERT INTO `User` (`UserID`, `UserName`, `EIN`, `FName`, `LName`, `Phone`, `Email`, `DOB`, `DateCreated`) VALUES ('".$UserID."', '".$UserName."', NULL, '".ucfirst(strtolower($_POST['FirstName']))."', '".ucfirst(strtolower($_POST['LastName']))."', '".$_POST['Phone']."', '".$_POST['Email']."', '".$_POST['BirthDay']."', CURRENT_TIMESTAMP)";
            $query = mysqli_query($conn, $sql);

            if(!$query){
                die("Error Found " . mysqli_error($conn));
            }else{
                $sql = "INSERT INTO `UserPass` (`UserPassID`, `UserID`, `UserPassword`) VALUES (NULL, '".$UserID."', '".$_POST['Password']."')";
                $query = mysqli_query($conn, $sql);

                if(!$query){
                    array_push($errors, "DATABASE ERROR");
                    die("Error Found " . mysqli_error($conn));
                }else{
                    $sql = "INSERT INTO `UserAddress` (`UserID`, `Street`, `City`, `State`, `Zipcode`) VALUES ('".$UserID."', '".$_POST['StreetAddress']."', '".$_POST['City']."', '".$_POST['State']."', '".$_POST['Zipcode']."')";
                    $query = mysqli_query($conn, $sql);

                    if(!$query){
                        array_push($errors, "DATABASE ERROR");
                        die("Error Found " . mysqli_error($conn));
                    }else{
                        echo '<script>window.location.href = "'.$_SERVER['REQUEST_URI'].'?UserName='.$UserName.'";</script>';
                    }
                }
            }
        }

        if($errors != array()) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '".returnErrors($errors, 'You have the following errors:')."'}</script>";
    }

    if(isset($_GET['UserName'])) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '".returnSuccess('You have successfully created an account. Your username is <b>'.$_GET['UserName'].'</b>')."'}</script>";
?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
    <head>
        <title>Register</title>
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
                <h1><b>Register User</b></h1>
            </div>
            <form class="form-horizontal" action="Register" method="post">
                <div class="form-group">
                    <label class="control-label col-sm-2" name="Hash" for="Hash">*User Hash:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="Hash" name="Hash" placeholder="Enter your given hash" value="<?php echo $_POST['Hash']; ?>"/>
                    </div>
                </div>
                <h3>Personal Information</h3><hr>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="FirstName" for="FirstName">*FirstName:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="Enter your first name" value="<?php echo $_POST['FirstName']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="LastName" for="LastName">*Last Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="LastName" name="LastName" placeholder="Enter your last name" value="<?php echo $_POST['LastName']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="Phone" for="Phone">Phone Number:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="Phone" name="Phone" placeholder="Enter your phone number" value="<?php echo $_POST['Phone']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="Email" for="Email">Email:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="Email" name="Email" placeholder="Enter your Email" value="<?php echo $_POST['Email']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="BirthDay" for="BirthDay">*Date of Birth:</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="BirthDay" name="BirthDay" placeholder="Enter your date of birth" value="<?php echo $_POST['BirthDay']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="StreetAddress" for="StreetAddress">*Street:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="StreetAddress" name="StreetAddress" placeholder="Enter your street address" value="<?php echo $_POST['StreetAddress']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="City" for="City">*City:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="City" name="City" placeholder="Enter your City" value="<?php echo $_POST['City']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="State" for="State">*State:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="State" name="State">
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="DC">District Of Columbia</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO" selected>Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="Zipcode" for="Zipcode">*Zip Code:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="Zipcode" name="Zipcode" placeholder="Enter your zip code" value="<?php echo $_POST['Zipcode']; ?>"/>
                    </div>
                </div>
                <h3>Password</h3><hr>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="Password" for="Password">*Password:</label>
                    <div class="col-sm-10">
                        <input type="Password" class="form-control" id="Password" name="Password" placeholder="Enter a Password"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" name="Password1" for="Password1">*Retype Password:</label>
                    <div class="col-sm-10">
                        <input type="Password" class="form-control" id="Password1" name="Password1" placeholder="Retype Password"/>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" name="submit" class="btn btn-default">Register</button>
                    </div>
                  </div>
            </form>
        </div>
    </body>
</html>