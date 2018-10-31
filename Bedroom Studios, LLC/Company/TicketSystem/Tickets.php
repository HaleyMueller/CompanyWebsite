    <?php
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/fakenav.php';

    if(HasSpecificAccessRole(20, $_SESSION['UserID']) || HasSpecificAccessRole(21, $_SESSION['UserID']) || HasSpecificAccessRole(22, $_SESSION['UserID'])){}else{
        noAccess();
    }

    $AssignedUserID = -1;
    $CreatedByUserID = -1;
    $TeamID = -1;

    $filterArray = array();

    if(isset($_GET['AssignedUserID'])) array_push($filterArray, "AssignedUserID");
    if(isset($_GET['CreatedByUserID'])) array_push($filterArray, "CreatedByUserID");
    if(isset($_GET['TeamID'])) array_push($filterArray, "TeamID");
    if(isset($_GET['ProjectID'])) array_push($filterArray, "ProjectID");

    $whereClause;

    if(count($filterArray) > 0){
        $whereClause = 'WHERE ';
    }

    foreach ($filterArray as &$value) {
        $whereClause .= $value . " = " . $_GET[$value] . " AND ";
    }

    if(isset($_GET['OrderBy'])) $OrderBy = $_GET['OrderBy']; else $OrderBy = "TicketID";
    if(isset($_GET['ASCDESC'])) $ASCDESC = $_GET['ASCDESC']; else $ASCDESC = "DESC";
    if(isset($_GET['Offset'])) $Offset = $_GET['Offset']; else $Offset = "0";
    if(isset($_GET['Rows'])) $RowView = $_GET['Rows']; else $RowView = "5"; //How many shown at once

    $sql = "SELECT COUNT(*) FROM Ticket;";
    $query = mysqli_query($conn, $sql);

    $query = $conn->prepare("SELECT * FROM Ticket ".substr($whereClause, 0, -5));
    $query->execute();
    $query->store_result();

    $rows = $query->num_rows;

    $pagination;

    if(($rows/$RowView) > 1){
        for ($x = 0; $x <= ceil($rows / $RowView) - 1; $x++) {
            $active;
            if ($_GET['Offset'] == $x) $active = 'active'; else $active = '';
            $pagination .= '<li class="page-item ' . $active . '"><a class="page-link" href="#" onclick="clickedPagination(' . $x . ')">' . ($x + 1) . '</a></li>';
        }
    }

    $sql = "SELECT * FROM `Ticket` ".substr($whereClause, 0, -5)." ORDER BY ".$OrderBy." ".$ASCDESC." LIMIT ".($RowView*$Offset).", ".$RowView." ";
    $query = mysqli_query($conn, $sql);

    $tableRows;

    if (!$query) {
        array_push($errors, "DATABASE ERROR");
        die("Error Found " . mysqli_error($conn));
    } else {
        while($row = mysqli_fetch_assoc($query)) {
            $tableRows .= '<tr><td>'.$row['TicketID'].'</td><td>'.getProjectName($row['ProjectID']).'</td><td>'.getCategoryName($row['CategoryID']).'</td><td>'.$row['Subject'].'</td><td>'.getPriorityName($row['PriorityID']).'</td><td>'.getStatusName($row['StatusID']).'</td><td>'.$row['DateCreated'].'</td></tr>';
        }
    }

    if($errors != array()) echo "<script>window.onload = function () { document.getElementById('errors').innerHTML = '".returnErrors($errors, 'You have the following errors:')."'}</script>";

?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
<head>
    <title>Tickets</title>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        function clickedHeader(name){
            insertParam("OrderBy", name);
        }

        function clickedPagination(num){
            insertParam("Offset", num);
        }

        //Updates GET
        function insertParam(key, value)
        {
            key = encodeURI(key); value = encodeURI(value);
            var kvp = document.location.search.substr(1).split('&');
            var i=kvp.length; var x; while(i--)
        {
            x = kvp[i].split('=');
            if (x[0]==key)
            {
                x[1] = value;
                kvp[i] = x.join('=');
                break;
            }
        }
            if(i<0) {kvp[kvp.length] = [key,value].join('=');}
            //this will reload the page, it's likely better to store this until finished
            document.location.search = kvp.join('&');
        }
    </script>
    <style>
        th{ cursor: pointer; }
    </style>
</head>
    <body>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col" onclick="clickedHeader('TicketID')">ID</th>
                    <th scope="col" onclick="clickedHeader('ProjectID')">Project</th>
                    <th scope="col" onclick="clickedHeader('CategoryID')">Category</th>
                    <th scope="col" onclick="clickedHeader('Subject')">Subject</th>
                    <th scope="col" onclick="clickedHeader('PriorityID')">Priority</th>
                    <th scope="col" onclick="clickedHeader('StatusID')">Status</th>
                    <th scope="col" onclick="clickedHeader('DateCreated')">Date Created</th>
                </tr>
                </thead>
                <tbody>
                    <?php echo $tableRows; ?>
                </tbody>
            </table>
            <center>
                <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php echo $pagination; ?>
                </ul>
                </nav>
            </center>
        </div>
    </body>
</html>