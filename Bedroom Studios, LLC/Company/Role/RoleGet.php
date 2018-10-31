<?php
function processDropdown($selectedVal) {
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(HasSpecificAccessRole(50, $_SESSION['UserID'])){}else{
        noAccess();
    }

    if($selectedVal != 0) {
        $sql = "SELECT * FROM `RoleDetail` where RoleID = " . $selectedVal;
        $query = mysqli_query($conn, $sql);


        $arrayJson = array();

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        } else {
            while ($row = mysqli_fetch_assoc($query)) {
                $a = array("id" => $row['RoleID'], "name" => $row['RoleName'], "color" => $row['RoleColor'], "accessNumber" => $row['RoleAccessNumber']);
                $arrayJson[] = $a;
            }
        }
        $json = json_encode($arrayJson);

        echo $json;
    }
}

if ($_GET['roleValue']){
    //call the function or execute the code
    processDropdown($_GET['roleValue']);
}

