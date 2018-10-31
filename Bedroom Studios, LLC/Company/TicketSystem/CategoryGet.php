<?php
function processDropdown($selectedVal) {
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(HasSpecificAccessRole(40, $_SESSION['UserID']) || HasSpecificAccessRole(42, $_SESSION['UserID'])){}else{
        noAccess();
    }


    $sql = "SELECT * FROM `Category` WHERE ProjectID = -1 OR ProjectID = " . $_GET['projectValue'];
    $query = mysqli_query($conn, $sql);


    $arrayJson = array();

    if (!$query) {
        array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while ($row = mysqli_fetch_assoc($query)) {
            $a = array(
                "id" => $row['CategoryID'],
                "projectID" => $row['ProjectID'],
                "teamID" => $row['TeamID'],
                "name" => $row['CategoryName'],
                "color" => $row['CategoryColor']
            );
            $arrayJson[] = $a;
        }
    }
    $json = json_encode($arrayJson);

    echo $json;
}

if ($_GET['projectValue']){
    //call the function or execute the code
    processDropdown($_GET['projectValue']);
}

