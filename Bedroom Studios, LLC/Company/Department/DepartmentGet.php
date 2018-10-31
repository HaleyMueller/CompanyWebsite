<?php
function processDropdown($selectedVal) {
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/fakenav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(HasSpecificAccessRole(40, $_SESSION['UserID'])){}else{
        noAccess();
    }

    if($selectedVal != 0) {
        $sql = "SELECT * FROM `Department` where DepartmentID = " . $selectedVal;
        $query = mysqli_query($conn, $sql);


        $arrayJson = array();

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        } else {
            while ($row = mysqli_fetch_assoc($query)) {
                $a = array("id" => $row['DepartmentID'], "name" => $row['DepartmentName'], "color" => $row['DepartmentColor']);
                $arrayJson[] = $a;
            }
        }
        $json = json_encode($arrayJson);

        echo $json;
    }
}

if ($_GET['departmentValue']){
    //call the function or execute the code
    processDropdown($_GET['departmentValue']);
}

