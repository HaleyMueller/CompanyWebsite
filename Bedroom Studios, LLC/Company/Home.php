<?php
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/LoggedIn.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/nav.php';
    include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Slogan.php';
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Home</title>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/Company/API/Head.php';?>
    </head>
    <body>
        <div class="customJumbotron" style="">
            <h1 class="display-4"><b>Bedroom Studios, LLC</b></h1>
            <p class="lead" id="slogan"></p>
        </div>
        <div class="container-fluid">
            <div class="page-header">
                <h1 style=""><b>Home</b></h1>
            </div>
            <div class="row">
                <div class="col-sm-4" style="">
                    <p>If you are an employee or contractor you will use this to login and access your tools.</p>
                    <br>
                    <p>If you need to make an account please contact Mark.</p>
                </div>
                <div class="col-sm-3"></div>
                <div class="col-sm-2">
                    <iframe height="100%" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FBedroomStudiosLLC%2F&tabs=timeline&width=340&height=800&small_header=true&adapt_container_width=true&hide_cover=true&show_facepile=true&appId" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                    <br>
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-2">
                    <a class="twitter-timeline" href="https://twitter.com/BStudiosLLC?ref_src=twsrc%5Etfw">Tweets by BStudiosLLC</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                </div>
            </div>
        </div>
    </body>
</html>