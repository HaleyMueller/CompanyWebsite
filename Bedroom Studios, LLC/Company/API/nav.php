<nav class="navbar navbar-default navbar-fixed-top" style="margin-bottom: 2em;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" style="color:white; outline: none;">
                <span class="icon-bar" style="background-color: white;"></span>
                <span class="icon-bar" style="background-color: white;"></span>
                <span class="icon-bar" style="background-color: white;"></span>
            </button>
            <a class="navbar-brand" href="/Company/Home" style="color:white;">Bedroom Studios, LLC</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <?php if(isset($_SESSION['UserID'])) {
                    echo '<li><a href="/Company/Dashboard" style="color:white"><b>Dashboard</b></a></li>';
                    echo '<li class="dropdown" id="userNavName">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="userNavName"><b>Projects</b>
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/Company/Projects/Projects" style="color:white">Projects</a></li>
                            <li><a href="/Company/Projects/Projects?UserID=' . $_SESSION['UserID'] . '" style="color:white">My Projects</a></li>
                        </ul>
                    </li>';
                    echo '<li><a href="/Company/Users/Users" style="color:white"><b>Users</b></a></li>';
                }
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if(isset($_SESSION['UserID'])){
                    echo '<li class="dropdown" id="userNavName">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="userNavName"><img style="height:30px; width:30px;" class="img-fluid img-rounded" src="/Company/Users/ProfilePictures/'.getProfilePicture($_SESSION['UserID']).'" /> Hello '.getName($_SESSION['UserID'])[1].', '.getName($_SESSION['UserID'])[0].'
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/Company/Users/ShowUser?UserID='.$_SESSION['UserID'].'" style="color:white"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
                            <li><a href="/Company/UserLoginSystem/LogOut" style="color:white"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
                        </ul>
                    </li>
';
                }else
                    echo '
                    <li><a href="/Company/UserLoginSystem/Register" style="color: white"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li><a href="/Company/UserLoginSystem/Login" style="color: white"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
                ?>
            </ul>
        </div>
    </div>
</nav>
