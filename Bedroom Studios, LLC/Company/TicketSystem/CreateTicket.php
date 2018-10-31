<?php
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(HasSpecificAccessRole(40, $_SESSION['UserID']) || HasSpecificAccessRole(42, $_SESSION['UserID'])){}else{
        noAccess();
    }

    $sql = "SELECT * FROM `Project`";
    $query = mysqli_query($conn, $sql);

    $projectOption = "";

    if (!$query) {
        array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while($row = mysqli_fetch_assoc($query)) {
            $projectOption .= '<option value="'.$row['ProjectID'].'">'.$row['ProjectName'].'</option>';
        }
    }

    $sql = "SELECT * FROM `Priority`";
    $query = mysqli_query($conn, $sql);

    $priorityOption = "";

    if (!$query) {
        array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while($row = mysqli_fetch_assoc($query)) {
            $priorityOption .= '<option value="'.$row['PriorityID'].'">'.$row['PriorityName'].'</option>';
        }
    }

    if(isset($_POST['SubmitTicket'])) {

        $errors = array();

        foreach ($_POST as $key => $value) {
            if (hasSpecialCharacter($value)) array_push($errors, returnCamelCasedSpaced($key) . " field can\'t have special characters (-\')");
        }

        if ($_POST['ProjectSelect'] == "" || $_POST['ProjectSelect'] == "null") array_push($errors, "Project field blank");
        if ($_POST['category'] == "" || $_POST['category'] == "null") array_push($errors, "Category field blank");
        if ($_POST['priority'] == "" || $_POST['priority'] == "null") array_push($errors, "Priority field blank");
        if ($_POST['subject'] == "") array_push($errors, "Subject can\'t be blank");
        if ($_POST['issue'] == "") array_push($errors, "Issue field blank");

        if ($errors == array()) {

            $CTeamID = -1;

            $sql = "SELECT * FROM `Category` WHERE CategoryID = " . $_POST['category'];
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            } else {
                while($row = mysqli_fetch_assoc($query)) {
                    $CTeamID = $row['TeamID'];
                }
            }

            $CTeamLeadID = -1;

            $sql = "SELECT * FROM `TeamDetail` WHERE TeamID = " . $CTeamID;
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            } else {
                while($row = mysqli_fetch_assoc($query)) {
                    $CTeamLeadID = $row['TeamLeadUserID'];
                }
            }

            //Get team and team lead

            $sql = "INSERT INTO `Ticket` (`TicketID`, `ProjectID`, `CategoryID`, `StatusID`, `PriorityID`, `Subject`, `Issue`, `CompletedByUserID`, `CreatedByUserID`, `DateCreated`, `DateCompleted`, `AssignedTeamID`, `AssignedUserID`) VALUES 
            (NULL, ".$_POST['ProjectSelect'].", ".$_POST['category'].", 2, ".$_POST['priority'].", '".$_POST['subject']."', '".$_POST['issue']."', NULL, ".$_SESSION['UserID'].", CURRENT_TIMESTAMP, NULL, ".$CTeamID.", ".$CTeamLeadID.")";
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                array_push($errors, "DATABASE ERROR");
                die("Error Found " . mysqli_error($conn));
            } else {
                $last_id = $conn->insert_id;
                ticketCreatedEmail($last_id, getUserEmailAddress($_SESSION['UserID']), $_POST['subject']);
                ticketAssigningEmail($last_id, getUserEmailAddress($CTeamLeadID), $_POST['subject']);
                echo '<script>window.location.href = "' . $_SERVER['REQUEST_URI'] . '?TeamName=' . $_POST['TeamName'] . '";</script>';
            }
        }
    }

    if($errors != array()) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '".returnErrors($errors, 'You have the following errors:')."'}</script>";

/*
    TicketID
    ProjectID
    CategoryID
    StatusID
    PriorityID
    Subject
    Issue
    CompletedByUserID
    CreatedByUserID
    DateCreated
    DateCompleted
    AssignedTeamID
    AssignedUserID

    NoteID
    TicketID
    NoteUserID
    NoteCreatedDate
    Noted
*/

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
    <head>
        <title>Create Ticket</title>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $('#ProjectSelect').change(function(){
                    var inputValue = $(this).val();
                    $.getJSON("CategoryGet?projectValue="+inputValue, function(obj) {
                        $("#category").empty();
                        $.each(obj, function(key, value) {
                            $("#category").append("<option value='"+value.id+"'>" + value.name + "</option>");
                        });
                    });
                });
            });
        </script>
    </head>
    <body>
    <div class="customJumbotron" style="">
        <h1 class="display-4"><b>Bedroom Studios, LLC</b></h1>
        <p class="lead" id="slogan"></p>
    </div>
        <div class="container">
            <div id="errors"></div>
            <div class="page-header">
                <h1><b>Create a Ticket</b></h1>
            </div>
            <form class="form-horizontal" action="CreateTicket" method="post" style="padding:1em;">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="ProjectSelect">Select the project:</label>
                        <select class="form-control" id="ProjectSelect" name="ProjectSelect">
                            <option value="null"></option>
                            <?php echo $projectOption ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category">Select a category:</label>
                        <select class="form-control" id="category" name="category">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="priority">Select a priority:</label>
                        <select class="form-control" id="priority" name="priority">
                            <?php echo $priorityOption; ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="subject">Subject of ticket:</label>
                        <input type="text" class="form-control" id="subject" name="subject">
                    </div>
                    <div class="form-group">
                        <label for="userType">Issue:</label>
                        <textarea class="form-control" id="issue" name="issue" style="height:7.5em;"></textarea>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="">
                            <button type="SubmitTicket" name="SubmitTicket" class="btn btn-default">Create Ticket</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>