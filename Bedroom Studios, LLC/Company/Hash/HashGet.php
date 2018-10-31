<?php
function processDropdown($selectedVal) {
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/fakenav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(HasSpecificAccessRole(10, $_SESSION['UserID'])){}else{
        noAccess();
    }


        $sql = "SELECT * FROM `UserHash` where UserID = '" . $selectedVal . "'";
        $query = mysqli_query($conn, $sql);


        $arrayJson = array();

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        } else {
            while ($row = mysqli_fetch_assoc($query)) {
                $type = "";
                if($row['IsContractor'] == 1) $type = "Contractor";
                if($row['isEIN'] == 1) $type = "EIN";
                $a = array("id" => $row['UserID'], "type" => $type);
                $arrayJson[] = $a;
            }
        }
        $json = json_encode($arrayJson);

        echo $json;

}

if ($_GET['hashValue']){
    //call the function or execute the code
    processDropdown($_GET['hashValue']);
}

