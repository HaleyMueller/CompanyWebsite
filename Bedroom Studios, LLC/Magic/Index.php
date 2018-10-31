<?php
?>
<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
    <head>
        <title>Capital City`s Game Emporium</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
        <link rel="icon" href="/favicon.png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-120131649-1"></script>
        <style>
            .intro-2 {
                background: url("http://mdbootstrap.com/img/Photos/Others/img%20(42).jpg")no-repeat center center;
                background-size: cover;
            }
            .top-nav-collapse {
                background-color: #3f51b5 !important;
            }
            .navbar:not(.top-nav-collapse) {
                background: transparent !important;
            }
            @media (max-width: 768px) {
                .navbar:not(.top-nav-collapse) {
                    background: #001a76 !important;
                }
            }
            h6 {
                line-height: 1.7;
            }
            @media (max-width: 740px) {
                .full-height,
                .full-height body,
                .full-height header,
                .full-height header .view {
                    height: 1040px;
                }
            }
            .footer {
                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
                background-color: #03005b;
                color: white;
                text-align: center;
            }
            .myclass {
                width: auto;
                height: auto;
                max-width: 80%;
                max-height: 100%;
            }
            .borderPatrol {
                border: 3px solid #ffcb46;
            }
            #bg {
                position: fixed;
                top: 0;
                left: 0;

                /* Preserve aspet ratio */
                min-width: 100%;
                min-height: 100%;
            }
        </style>
    </head>

    <body style="margin-bottom: 5em;">

    <img src="3.jpg" id="bg" alt="">
    <!--Main Navigation-->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-7" aria-controls="navbarSupportedContent-7" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span> Capital City`s Game Emporium
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent-7">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!--Main Navigation-->

    <div class="container-fluid" style="margin-top:5em">
        <div class="row" style="margin-top:5em">
            <div class="col-sm-12">
                <center><img src="CardShop.png" class="img img-fluid myclass"></center>
            </div>
        </div>
        <div class="row" style="margin-top:5em">
            <div class="col-sm-9">
                <center><img src="Capitol.jpg" class="img img-fluid borderPatrol" style="width:50%;"/></center>
            </div>
            <div class="col-sm-3">
                <center><iframe style="margin-top:1em;" class="borderPatrol" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fjc.emporium%2F&tabs=events&width=340&height=259&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="340" height="259" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe></center>
            </div>
        </div>
        <div class="row" style="margin-top:5em; margin-bottom:3em; padding:1em;">
            <div class="col-sm-12 borderPatrol">
                <div style="height:10em;"></div>
            </div>
        </div>
    </div>

    </body>

    <div class="footer">
        <p>Footer</p>
    </div>
</html>