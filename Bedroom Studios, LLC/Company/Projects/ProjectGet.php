<?php
function processDropdown($selectedVal) {
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    //include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(HasSpecificAccessRole(30, $_SESSION['UserID'])){}else{
        noAccess();
    }


        $sql = "SELECT * FROM Project JOIN ProjectDetail on Project.ProjectID = ProjectDetail.ProjectID where Project.ProjectID = " . $selectedVal . " LIMIT 1";
        $query = mysqli_query($conn, $sql);


        $arrayJson = array();

        if (!$query) {
            array_push($errors, "DATABASE ERROR");
            die("Error Found " . mysqli_error($conn));
        } else {
            while ($row = mysqli_fetch_assoc($query)) {
                $a = array(
                    "id" => $row['ProjectID'],
                    "name" => $row['ProjectName'],
                    "color" => $row['ProjectColor'],
                    "date" => $row['ProjectDate'],
                    "dateCompleted" => $row['ProjectDateCompleted'],
                    "contactPhone" => $row['ProjectContactPhone'],
                    "contactEmail" => $row['ProjectContactEmail'],
                    "contactName" => $row['ProjectContactName'],
                    "description" => $row['ProjectDescription'],
                    "price" => $row['ProjectPrice']
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

