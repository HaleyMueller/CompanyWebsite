<?php
    $username = "u246470952_root";
    $password = "Markiscool1";
    $database = "u246470952_ticke";
    $hostname = "localhost";

    $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function UserTimeout(){
        $username = "u246470952_root";
        $password = "Markiscool1";
        $database = "u246470952_ticke";
        $hostname = "localhost";

        $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if(isset($_SESSION['UserID'])){
            $sql = "SELECT * FROM `UserTimeout` WHERE UserID = ".$_SESSION['UserID'];

            $query = mysqli_query($conn, $sql);

            if($query) {
                while($row = mysqli_fetch_assoc($query)) {
                    if($row['LastActivity'] > date("Y-m-d H:i:s", strtotime("+1 hours"))){
                        ob_start();
                        session_destroy();
                        echo '<script>alert("Logging you out");window.location.href = "'.$_SERVER['REQUEST_URI'].'"</script>';
                    }else{
                        $sql = "SELECT * FROM `UserTimeout` WHERE UserID = ".$_SESSION['UserID'];
                        $query = mysqli_query($conn, $sql);

                        if(!$query) {
                            die("Connection failed2: " . $conn->connect_error);
                        }
                        $count = mysqli_num_rows($query);

                        if($count == 0) {
                            $sql = "INSERT INTO `UserTimeout` (`UserTimeoutID`, `UserID`, `LastActivity`) VALUES (NULL, '" . $_SESSION['UserID'] . "', CURRENT_TIMESTAMP )";
                            $query = mysqli_query($conn, $sql);

                            if(!$query) {
                                die("Connection failed3: " . $conn->connect_error);
                            }
                        }else{
                            $sql = "UPDATE `UserTimeout` SET `LastActivity` = CURRENT_TIMESTAMP WHERE UserID = ".$_SESSION['UserID'];
                            $query = mysqli_query($conn, $sql);

                            if(!$query) {
                                die("Connection failed4: " . $conn->connect_error);
                            }
                        }
                    }
                }
            }else{
                die("Connection failed1: " . $conn->connect_error);
            }
        }
    }

    function HasSpecificAccessRole($roleAccessLevel, $userID) {
        $username = "u246470952_root";
        $password = "Markiscool1";
        $database = "u246470952_ticke";
        $hostname = "localhost";

        $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());
        $sql = "SELECT * FROM `Role` INNER JOIN RoleDetail on Role.RoleID = RoleDetail.RoleID WHERE UserID = ".$userID;
        $query = mysqli_query($conn, $sql);

        if(!$query){
            //die("Error Found: Can't Access Roles " . mysqli_error($conn));
            return false;
        }else{
            if (mysqli_num_rows($query) > 0) {
                while($row = mysqli_fetch_assoc($query)) {
                    if($row['RoleAccessNumber'] >= $roleAccessLevel || $row['RoleAccessNumber'] == -1){
                        return true;
                    }
                }
            }
            else { //No roles were found
                return false;
            }
            //return false;
        }
    }

    function HasAccessRoleSpectrum($roleAccessLevelLow, $roleAccessLevelHigh, $userID) {
        $username = "u246470952_root";
        $password = "Markiscool1";
        $database = "u246470952_ticke";
        $hostname = "localhost";

        $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());
        $sql = "SELECT * FROM `Role` INNER JOIN RoleDetail on Role.RoleID = RoleDetail.RoleID WHERE UserID = ".$userID;
        $query = mysqli_query($conn, $sql);

        if(!$query){
            //die("Error Found: Can't Access Roles " . mysqli_error($conn));
            return false;
        }else{
            if (mysqli_num_rows($query) > 0) {
                while($row = mysqli_fetch_assoc($query)) {
                    if(($row['RoleAccessNumber'] >= $roleAccessLevelLow && $row['RoleAccessNumber'] <= $roleAccessLevelHigh) || $row['RoleAccessNumber'] == -1){
                        return true;
                    }
                }
            }else { //No roles were found
                return false;
            }
            //return false;
        }
    }

    ///Make sure you are declaring an $error variable and calling it
    function returnErrors($errorList, $top){
        $output = '<div class="alert alert-danger" role="alert">'.$top.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>';

        foreach ($errorList as &$error) {
            $output .= '<li>'.$error.'</li>';
        }

        $output .= '</ul></div>';

        return $output;
    }

    function returnSuccess($successMessage){
        $output = '<div class="alert alert-success" role="alert">'.$successMessage.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';

        return $output;
    }

    function noAccess(){
        echo '<script>window.location.href = "/Company/AccessDenied?url='.$_SERVER['REQUEST_URI'].'";</script>';
    }

    function getName($userID){
        $username = "u246470952_root";
        $password = "Markiscool1";
        $database = "u246470952_ticke";
        $hostname = "localhost";

        $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());
        $sql = "SELECT * FROM User WHERE UserID = " . $userID;
        $query = mysqli_query($conn, $sql);

        if(!$query){
            die("Error Found: Can't Access Name " . mysqli_error($conn));
            return null;
        }else{
            while($row = mysqli_fetch_assoc($query)) {
                if($row['UserID'] == $userID){
                    return array($row['FName'],$row['LName']);
                }
            }
        }
    }

    function hasSpecialCharacter($string){
        /*if(preg_match("/[A-Za-z]^[\\-\\., \']+$/", $string)){
            return true;
        }
        return false; */

        if(strpos($string, "'") !== false || strpos($string, "--") !== false){
            return true;
        }
        return false;
    }

    function returnCamelCasedSpaced($string){
        $arr = preg_split('/(?=[A-Z])/',$string);
        $cache = "";
        foreach ($arr as $obj){
            $cache .= $obj . " ";
        }
        return $cache;
    }

    function getAllRolesAccessNumber($userID){
        $username = "u246470952_root";
        $password = "Markiscool1";
        $database = "u246470952_ticke";
        $hostname = "localhost";

        $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());
        $sql = "SELECT * FROM `Role` INNER JOIN RoleDetail on Role.RoleID = RoleDetail.RoleID WHERE UserID = ".$userID;
        $query = mysqli_query($conn, $sql);

        $roleArray = array();

        if(!$query){
            //die("Error Found: Can't Access Roles " . mysqli_error($conn));
            return false;
        }else{
            if (mysqli_num_rows($query) > 0) {
                while($row = mysqli_fetch_assoc($query)) { array_push($roleArray, $row['RoleAccessNumber']);}
            }
        }

        return $roleArray;
    }

    function phone_number_format($number) {
        // Allow only Digits, remove all other characters.
        $number = preg_replace("/[^\d]/","",$number);

        // get number length.
        $length = strlen($number);

        // if number = 10
        if($length == 10) {
            $number = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $number);
        }

        return $number;

    }

    function getContrast50($hexcolor){
        return (hexdec($hexcolor) > 0xffffff/2) ? 'black':'white';
    }

    function getTeams($UserID){
        $username = "u246470952_root";
        $password = "Markiscool1";
        $database = "u246470952_ticke";
        $hostname = "localhost";

        $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());

        $sql = "SELECT * FROM `Team` JOIN `TeamDetail` ON `Team`.TeamID = `TeamDetail`.TeamID WHERE `Team`.UserID = ".$UserID;
        $query = mysqli_query($conn, $sql);

        $teams = "";

        if (!$query) {
            //array_push($errors, "DATABASE ERROR");
            //die("Error Found " . mysqli_error($conn));
        }else{
            while($row = mysqli_fetch_assoc($query)) {
                $teams .= '<span class="badge" style="color:'.getContrast50($row['TeamColor']).'; background-color: '.$row['TeamColor'].';">'.$row['TeamName'].'</span>';
            }
        }

        return $teams;
    }

    function getRoles($UserID){
        $username = "u246470952_root";
        $password = "Markiscool1";
        $database = "u246470952_ticke";
        $hostname = "localhost";

        $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());

        $sql = "SELECT * FROM `Role` JOIN `RoleDetail` ON `Role`.RoleID = `RoleDetail`.RoleID WHERE `Role`.UserID = ".$UserID;
        $query = mysqli_query($conn, $sql);

        $teams = "";

        if (!$query) {
            //array_push($errors, "DATABASE ERROR");
            //die("Error Found " . mysqli_error($conn));
        }else{
            while($row = mysqli_fetch_assoc($query)) {
                $teams .= '<span class="badge" style="color:'.getContrast50($row['RoleColor']).'; background-color: '.$row['RoleColor'].';">'.$row['RoleName'].'</span>';
            }
        }

        return $teams;
    }

    function getNotCompletedProjects($UserID){
        $username = "u246470952_root";
        $password = "Markiscool1";
        $database = "u246470952_ticke";
        $hostname = "localhost";

        $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());

        $sql = "SELECT * FROM `ProjectUser` JOIN `ProjectDetail` ON `ProjectUser`.ProjectID = `ProjectDetail`.ProjectID JOIN `Project` ON `ProjectDetail`.ProjectID = `Project`.ProjectID WHERE `ProjectUser`.UserID = ".$UserID;
        $query = mysqli_query($conn, $sql);

        $teams = "";

        if (!$query) {
            //array_push($errors, "DATABASE ERROR");
            //die("Error Found " . mysqli_error($conn));
        }else{
            while($row = mysqli_fetch_assoc($query)) {
                if($row['ProjectDateCompleted'] == '0000-00-00')
                    $teams .= '<a href="../Projects/ShowProject?ProjectID='.$row['ProjectID'].'"><span class="badge" style="color:'.getContrast50($row['ProjectColor']).'; background-color: '.$row['ProjectColor'].';">'.$row['ProjectName'].'</span></a>';
            }
        }

        return $teams;
    }

    function getCompletedProjects($UserID){
    $username = "u246470952_root";
    $password = "Markiscool1";
    $database = "u246470952_ticke";
    $hostname = "localhost";

    $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());

    $sql = "SELECT * FROM `ProjectUser` JOIN `ProjectDetail` ON `ProjectUser`.ProjectID = `ProjectDetail`.ProjectID JOIN `Project` ON `ProjectDetail`.ProjectID = `Project`.ProjectID WHERE `ProjectUser`.UserID = ".$UserID;
    $query = mysqli_query($conn, $sql);

    $teams = "";

    if (!$query) {
        //array_push($errors, "DATABASE ERROR");
        //die("Error Found " . mysqli_error($conn));
    }else{
        while($row = mysqli_fetch_assoc($query)) {
            if($row['ProjectDateCompleted'] != '0000-00-00')
                $teams .= '<a href="../Projects/ShowProject?ProjectID='.$row['ProjectID'].'"><span class="badge" style="color:'.getContrast50($row['ProjectColor']).'; background-color: '.$row['ProjectColor'].';">'.$row['ProjectName'].'</span></a>';
        }
    }

    return $teams;
}

    function getUsersOnProject($ProjectID){
    $username = "u246470952_root";
    $password = "Markiscool1";
    $database = "u246470952_ticke";
    $hostname = "localhost";

    $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());

    $sql = "SELECT * FROM `ProjectUser` JOIN `User` ON `ProjectUser`.UserID = `User`.UserID WHERE `ProjectUser`.ProjectID = ".$ProjectID;
    $query = mysqli_query($conn, $sql);

    $teams = "";

    if (!$query) {
        //array_push($errors, "DATABASE ERROR");
        //die("Error Found " . mysqli_error($conn));
    }else{
        while($row = mysqli_fetch_assoc($query)) {
            if($row['ProjectDateCompleted'] != '0000-00-00')
                $teams .= '<a href="../Users/ShowUser?UserID='.$row['UserID'].'"><span class="badge" style="color:'.getContrast50($row['Color']).'; background-color: '.$row['Color'].';">'.$row['UserName'].'</span></a>';
        }
    }

    return $teams;
}

    function getDepartments($UserID){
        $username = "u246470952_root";
        $password = "Markiscool1";
        $database = "u246470952_ticke";
        $hostname = "localhost";

        $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());

        $sql = "SELECT * FROM `Team` JOIN `TeamDetail` ON `Team`.TeamID = `TeamDetail`.TeamID JOIN `Department` ON `TeamDetail`.DepartmentID = `Department`.DepartmentID WHERE `Team`.UserID = ".$UserID;
        $query = mysqli_query($conn, $sql);

        $teams = "";

        if (!$query) {
            //array_push($errors, "DATABASE ERROR");
            //die("Error Found " . mysqli_error($conn));
        }else{
            while($row = mysqli_fetch_assoc($query)) {
                $teams .= '<span class="badge" style="color:'.getContrast50($row['TeamColor']).'; background-color: '.$row['DepartmentColor'].';">'.$row['DepartmentName'].'</span>';
            }
        }

        return $teams;
    }

    function getProfilePicture($UserID){
        $username = "u246470952_root";
        $password = "Markiscool1";
        $database = "u246470952_ticke";
        $hostname = "localhost";

        $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());

        $picture = "default.png";
        $sql = "SELECT * FROM User WHERE User.UserID = ".$UserID;
        $query = mysqli_query($conn, $sql);

        if ($query) {
            while ($row = mysqli_fetch_assoc($query)) {
                if ($row['Picture'] != null && $row['Picture'] != "") $picture = $UserID . "." . $row['Picture']."?cache=".rand(5, 1005);
            }
        }else{
            die("Error Found " . mysqli_error($conn));
        }
        return $picture;
    }

    function getProjectName($ProjectID){
        $username = "u246470952_root";
        $password = "Markiscool1";
        $database = "u246470952_ticke";
        $hostname = "localhost";

        $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());

        $ProjectName = "API ERROR";
        $sql = "SELECT * FROM Project WHERE Project.ProjectID = ".$ProjectID;
        $query = mysqli_query($conn, $sql);

        if ($query) {
            while ($row = mysqli_fetch_assoc($query)) {
                $ProjectName = $row['ProjectName'];
            }
        }else{
            die("Error Found " . mysqli_error($conn));
        }
        return $ProjectName;
    }

    function getCategoryName($ID){
    $username = "u246470952_root";
    $password = "Markiscool1";
    $database = "u246470952_ticke";
    $hostname = "localhost";

    $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());

    $Name = "API ERROR";
    $sql = "SELECT * FROM Category WHERE CategoryID = ".$ID;
    $query = mysqli_query($conn, $sql);

    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $Name = $row['CategoryName'];
        }
    }else{
        die("Error Found " . mysqli_error($conn));
    }
    return $Name;
}

    function getStatusName($ID){
        $username = "u246470952_root";
        $password = "Markiscool1";
        $database = "u246470952_ticke";
        $hostname = "localhost";

        $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());

        $Name = "API ERROR";
        $sql = "SELECT * FROM Status WHERE StatusID = ".$ID;
        $query = mysqli_query($conn, $sql);

        if ($query) {
            while ($row = mysqli_fetch_assoc($query)) {
                $Name = $row['StatusName'];
            }
        }else{
            die("Error Found " . mysqli_error($conn));
        }
        return $Name;
    }

    function getPriorityName($ID){
        $username = "u246470952_root";
        $password = "Markiscool1";
        $database = "u246470952_ticke";
        $hostname = "localhost";

        $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());

        $Name = "API ERROR";
        $sql = "SELECT * FROM Priority WHERE PriorityID = ".$ID;
        $query = mysqli_query($conn, $sql);

        if ($query) {
            while ($row = mysqli_fetch_assoc($query)) {
                $Name = $row['PriorityName'];
            }
        }else{
            die("Error Found " . mysqli_error($conn));
        }
        return $Name;
    }

    function getUserEmailAddress($ID){
        $username = "u246470952_root";
        $password = "Markiscool1";
        $database = "u246470952_ticke";
        $hostname = "localhost";

        $conn = new mysqli($hostname,$username,$password,$database) or die(mysqli_error());

        $Name = "API ERROR";
        $sql = "SELECT * FROM User WHERE UserID = ".$ID;
        $query = mysqli_query($conn, $sql);

        if ($query) {
            while ($row = mysqli_fetch_assoc($query)) {
                $Name = $row['Email'];
            }
        }else{
            die("Error Found " . mysqli_error($conn));
        }
        return $Name;
    }

    function sendEmail($address, $msg, $subject){
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $msg = wordwrap($msg,70);
        mail($address, $subject, $msg, $headers);
    }

    function projectAssignedEmail($projectID, $UserEmail, $projectName){
        include 'Emails.php';
        $message = $AssignedToProject;
        sendEmail($UserEmail, $message, "Project Assigned To You");
    }

    function ticketCreatedEmail($ticketID, $UserEmail, $subject){
        include 'Emails.php';
        $message = $TicketCreated;
        sendEmail($UserEmail, $message, "Ticket #".$ticketID." Created");
    }

    function ticketAssigningEmail($ticketID, $UserEmail, $subject){
        include 'Emails.php';
        $message = $TicketAssigned;
        sendEmail($UserEmail, $message, "Ticket Assigned To You");
    }

?>