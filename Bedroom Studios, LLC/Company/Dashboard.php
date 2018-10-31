<?php
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';

    if(!isset($_SESSION['UserID'])) noAccess();

    $roleArray = getAllRolesAccessNumber($_SESSION['UserID']);

    $linkArray = array();

    if(in_array(-1, $roleArray) || in_array(30, $roleArray) || in_array(32, $roleArray)){
        array_push($linkArray, '/Company/Projects/CreateProject');
    }

    if(in_array(-1, $roleArray) || in_array(10, $roleArray) || in_array(12, $roleArray)){
        array_push($linkArray, '/Company/Users/CreateUserHash');
    }

    if(in_array(-1, $roleArray) || in_array(40, $roleArray) || in_array(42, $roleArray)){
        array_push($linkArray, '/Company/Department/CreateDepartment');
    }

    if(in_array(-1, $roleArray) || in_array(50, $roleArray) || in_array(51, $roleArray)){
        array_push($linkArray, '/Company/Role/AddRoleToUser');
    }

    if(in_array(-1, $roleArray) || in_array(40, $roleArray) || in_array(42, $roleArray)){
        array_push($linkArray, '/Company/Team/CreateTeam');
    }

    if(in_array(-1, $roleArray) || in_array(40, $roleArray)){
        array_push($linkArray, '/Company/Team/TeamEdit');
    }

    if(in_array(-1, $roleArray) || in_array(50, $roleArray)){
        array_push($linkArray, '/Company/Role/CreateRole');
    }

    if(in_array(-1, $roleArray) || in_array(50, $roleArray)){
        array_push($linkArray, '/Company/Role/RoleEdit');
    }

    if(in_array(-1, $roleArray) || in_array(40, $roleArray)){
        array_push($linkArray, '/Company/Department/DepartmentEdit');
    }

    if(in_array(-1, $roleArray) || in_array(30, $roleArray)){
        array_push($linkArray, '/Company/Projects/ProjectEdit');
    }

    if(in_array(-1, $roleArray) || in_array(10, $roleArray)){
        array_push($linkArray, '/Company/Hash/HashEdit');
    }

    if(in_array(-1, $roleArray) || in_array(30, $roleArray)){
        array_push($linkArray, '/Company/Projects/ProjectAddUser');
    }

    if(in_array(-1, $roleArray) || in_array(0, $roleArray)){
        array_push($linkArray, '/Company/Team/TeamAddUser');
    }


    $dashboardHTML = "";

    foreach($linkArray as $link){
        $dashboardHTML .= '<div class="col-sm-4"><iframe frameborder="0" style="width: 100%;" scrolling="no" onload="resizeIframe(this)" src="'.$link.'"></iframe></div>';
    }


?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
        <title>Dashboard</title>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
        <script>
            $(document).ready(function(){
            });
        </script>
        <style>
            .col-sm-4, .col-sm-6{
                margin-bottom: 2em;
            }
        </style>
    </head>
        <script>
            function resizeIframe(obj) {
                obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
            }
        </script>
    <body style="">
        <div class="customJumbotron" style="">
            <h1 class="display-4"><b>Bedroom Studios, LLC</b></h1>
            <p class="lead" id="slogan"></p>
        </div>
        <div class="container-fluid">
            <div class="page-header">
                <h1 style=""><b>Dashboard</b></h1>
            </div>
            <?php if(HasSpecificAccessRole(20, $_SESSION['UserID']) || HasSpecificAccessRole(21, $_SESSION['UserID']) || HasSpecificAccessRole(22, $_SESSION['UserID'])) {
                echo '<div class="col-sm-6" ><div class="page-header" ><b ><h2 style="" > Tickets Assigned to Me </h2 ></b ></div ><iframe frameborder = "0" style = "width: 100%;" scrolling = "no" onload = "resizeIframe(this)" src = "https://bedroomstudiosllc.com/Company/TicketSystem/Tickets.php?&AssignedUserID='.$_SESSION['UserID'].'" ></iframe ></div ><div class="col-sm-6" ><div class="page-header" ><b ><h2 style="" > My Tickets </h2 ></b ></div ><iframe frameborder = "0" style = "width: 100%;" scrolling = "no" onload = "resizeIframe(this)" src = "https://bedroomstudiosllc.com/Company/TicketSystem/Tickets.php?&CreatedByUserID='.$_SESSION['UserID'].'" ></iframe ></div ></div >';
            }?>
            <?php echo $dashboardHTML; ?>
        </div>
    </body>
</html>