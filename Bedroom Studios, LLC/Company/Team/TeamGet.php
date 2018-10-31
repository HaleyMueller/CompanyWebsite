<?php


function processDropdown($selectedVal) {
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(HasSpecificAccessRole(40, $_SESSION['UserID'])){}else{
        noAccess();
    }

    $sql = "SELECT * FROM `TeamDetail` INNER JOIN `Department` ON Department.DepartmentID = TeamDetail.DepartmentID where TeamDetail.DepartmentID = " . $selectedVal;
    $query = mysqli_query($conn, $sql);

    $departmentOption = "";

    $arrayJson = array();

    if (!$query) {
        array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while($row = mysqli_fetch_assoc($query)) {
            $a = array("id" => $row['TeamID'], "name" => $row['TeamName'], "color" => $row['TeamColor'], "lead" => $row['TeamLeadUserID']);
            $arrayJson[] = $a;
        }
    }
    $json = json_encode($arrayJson);

    echo $json;
}

function teamDropdown($selectedVal) {
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(HasSpecificAccessRole(40, $_SESSION['UserID'])){}else{
        noAccess();
    }

    $sql = "SELECT * FROM `TeamDetail` WHERE TeamID = " . $selectedVal;
    $query = mysqli_query($conn, $sql);

    $departmentOption = "";

    $arrayJson = array();

    if (!$query) {
        array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while($row = mysqli_fetch_assoc($query)) {
            $a = array("id" => $row['TeamID'], "name" => $row['TeamName'], "color" => $row['TeamColor'], "lead" => $row['TeamLeadUserID']);
            $arrayJson[] = $a;
        }
    }
    $json = json_encode($arrayJson);

    echo $json;
}

function userDropdown($selectedVal) {
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(HasSpecificAccessRole(40, $_SESSION['UserID'])){}else{
        noAccess();
    }

    $sql = "SELECT * FROM `User` WHERE UserID = " . $selectedVal;
    $query = mysqli_query($conn, $sql);

    $arrayJson = array();

    if (!$query) {
        array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while($row = mysqli_fetch_assoc($query)) {
            $a = array("id" => $row['UserID'], "userName" => $row['UserName']);
            $arrayJson[] = $a;
        }
    }
    $json = json_encode($arrayJson);

    echo $json;
}

if ($_GET['dropdownValue']){
    //call the function or execute the code
    processDropdown($_GET['dropdownValue']);
}

if ($_GET['teamValue']){
    //call the function or execute the code
    teamDropdown($_GET['teamValue']);
}

if ($_GET['userValue']){
    //call the function or execute the code
    userDropdown($_GET['userValue']);
}