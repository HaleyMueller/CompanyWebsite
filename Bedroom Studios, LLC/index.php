<?php
if (session_status() == PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
  <title>Bedroom Studios, LLC</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Small company based in the Midwest that develops and manages websites."/>
  <meta name="keywords" content="cheap websites, website creation, website creation missouri, website">
  <meta name="msvalidate.01" content="31FE0DFA03B647B0E27CBD3F1C7FF544" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link rel="icon" href="favicon.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Corporation",
      "name": "Bedroom Studios, LLC",
      "alternateName": "Bedroom Studios",
      "url": "http://www.bedroomstudiosllc.com",
      "logo": "http://www.bedroomstudiosllc.com/Logo.png",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+1-573-280-7152",
        "contactType": "technical support"
      },
      "sameAs": [
        "http://www.facebook.com/BedroomStudiosLLC",
        "http://www.twitter.com/bstudiosllc",
        "http://instagram.com/bedroomstudiosllc",
        "http://www.youtube.com/channel/UC9cBdpYOxW9MruyiVErSmAg"
      ]
    }
</script>
  <style>
  body {
      font: 400 15px Lato, sans-serif;
      line-height: 1.8;
      color: #818181;
  }
  h2 {
      font-size: 24px;
      text-transform: uppercase;
      color: #303030;
      font-weight: 600;
      margin-bottom: 30px;
  }
  h4 {
      font-size: 19px;
      line-height: 1.375em;
      color: #303030;
      font-weight: 400;
      margin-bottom: 30px;
  }  
  .jumbotron {
      background-color: #1FA89C;
      color: #fff;
      padding: 100px 25px;
      font-family: Montserrat, sans-serif;
  }
  .container-fluid {
      padding: 60px 50px;
  }
  .bg-grey {
      background-color: #f6f6f6;
  }
  .logo-small {
      color: #f4511e;
      font-size: 50px;
  }
  .logo {
      color: #f4511e;
      font-size: 200px;
  }
  .thumbnail {
      padding: 0 0 15px 0;
      border: none;
      border-radius: 0;
  }
  .thumbnail img {
      width: 100%;
      height: 100%;
      margin-bottom: 10px;
  }
  .carousel-control.right, .carousel-control.left {
      background-image: none;
      color: #f4511e;
  }
  .carousel-indicators li {
      border-color: #f4511e;
  }
  .carousel-indicators li.active {
      background-color: #f4511e;
  }
  .item h4 {
      font-size: 19px;
      line-height: 1.375em;
      font-weight: 400;
      font-style: italic;
      margin: 70px 0;
  }
  .item span {
      font-style: normal;
  }
  .panel {
      border: 1px solid #f4511e; 
      border-radius:0 !important;
      transition: box-shadow 0.5s;
  }
  .panel:hover {
      box-shadow: 5px 0px 40px rgba(0,0,0, .2);
  }
  .panel-footer .btn:hover {
      border: 1px solid #f4511e;
      background-color: #fff !important;
      color: #f4511e;
  }
  .panel-heading {
      color: #fff !important;
      background-color: #f4511e !important;
      padding: 25px;
      border-bottom: 1px solid transparent;
      border-top-left-radius: 0px;
      border-top-right-radius: 0px;
      border-bottom-left-radius: 0px;
      border-bottom-right-radius: 0px;
  }
  .panel-footer {
      background-color: white !important;
  }
  .panel-footer h3 {
      font-size: 32px;
  }
  .panel-footer h4 {
      color: #aaa;
      font-size: 14px;
  }
  .panel-footer .btn {
      margin: 15px 0;
      background-color: #f4511e;
      color: #fff;
  }
  .navbar {
      margin-bottom: 0;
      background-color: #1FA89C;
      z-index: 9999;
      border: 0;
      font-size: 12px !important;
      line-height: 1.42857143 !important;
      letter-spacing: 4px;
      border-radius: 0;
      font-family: Montserrat, sans-serif;
  }
  .navbar li a, .navbar .navbar-brand {
      color: #fff !important;
  }
  .navbar-nav li a:hover, .navbar-nav li.active a {
      color: #1FA89C !important;
      background-color: #fff !important;
  }
  .navbar-default .navbar-toggle {
      border-color: transparent;
      color: #fff !important;
  }
  footer .glyphicon {
      font-size: 20px;
      margin-bottom: 20px;
      color: #f4511e;
  }
  .slideanim {visibility:hidden;}
  .slide {
      animation-name: slide;
      -webkit-animation-name: slide;
      animation-duration: 1s;
      -webkit-animation-duration: 1s;
      visibility: visible;
  }
  @keyframes slide {
    0% {
      opacity: 0;
      transform: translateY(70%);
    } 
    100% {
      opacity: 1;
      transform: translateY(0%);
    }
  }
  @-webkit-keyframes slide {
    0% {
      opacity: 0;
      -webkit-transform: translateY(70%);
    } 
    100% {
      opacity: 1;
      -webkit-transform: translateY(0%);
    }
  }
  @media screen and (max-width: 768px) {
    .col-sm-4 {
      text-align: center;
      margin: 25px 0;
    }
    .btn-lg {
        width: 100%;
        margin-bottom: 35px;
    }
  }
  @media screen and (max-width: 480px) {
    .logo {
        font-size: 150px;
    }
  }

                       }
    /* width */
    ::-webkit-scrollbar {
        width: 10px;
    }
    
    /* Track */
    ::-webkit-scrollbar-track {
        background: #f88d6d; 
    }
    
    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #1FA89C; 
    }
    
    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #188178; 
    }
  @media screen and (max-width: 600px) {
      #ttt {
          visibility: hidden;
          clear: both;
          float: left;
          margin: 10px auto 5px 20px;
          width: 28%;
          display: none;
      }
  }
  @media (min-width: 600px) {
      #ddd {
          visibility: hidden;
          clear: both;
          float: left;
          margin: 10px auto 5px 20px;
          width: 28%;
          display: none;
      }
  }
  </style>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#myPage">Bedroom Studios</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a data-toggle="collapse" data-target=".navbar-collapse" href="#about">ABOUT</a></li>
        <li><a data-toggle="collapse" data-target=".navbar-collapse" href="#services">SERVICES</a></li>
        <li><a data-toggle="collapse" data-target=".navbar-collapse" href="#portfolio">PORTFOLIO</a></li>
        <li><a data-toggle="collapse" data-target=".navbar-collapse" href="#pricing">PRICING</a></li>
        <li><a data-toggle="collapse" data-target=".navbar-collapse" href="#contact">CONTACT</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="jumbotron text-center">
  <h1>Bedroom Studios, LLC</h1> 
  <p>We specialize in website creation.</p>
    <a href="WebsiteCalculator" target="_top" style="color:white"><p>Click here to use our Website Calculator.</p></a>
</div>

<!-- Container (About Section) -->
<div id="about" class="container-fluid">
  <div class="row">
    <div class="col-sm-8">
      <h2>About Our Company</h2><br>
      <h4>We are a small company based in the Midwest that develops and manages websites. We only hire the best to ensure that our products are up to our code. No pun intended.<br><br>We are affiliated with <a href="http://www.hostg.xyz/aff_ad?campaign_id=175&aff_id=2376&format=url" target="_blank">Hostinger</a> to host websites to increase stablilty of our websites.</h4><br>
    </div>
    <div class="col-sm-4" id="ttt">
      <span class="glyphicon glyphicon-home logo"></span>
    </div>
  </div>
</div>

<div class="container-fluid bg-grey">
  <div class="row">
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-globe logo slideanim"></span>
    </div>
    <div class="col-sm-8">
      <h2>Our Values</h2><br>
      <h4><strong>MISSION:</strong> Our mission is to help companies reach their audience through aesthetically pleasing and efficient websites on all platforms.</h4><br>
    </div>
  </div>
</div>

<!-- Container (Services Section) -->
<div id="services" class="container-fluid text-center">
  <h2>SERVICES</h2>
  <h4>What we offer</h4>
  <br>
  <div class="row slideanim">
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-download-alt logo-small"></span>
      <h4>BACKUPS</h4>
      <p>We keep backups to ensure no pages would go missing.</p>
    </div>
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-wrench logo-small"></span>
      <h4>BUG SQUASHING</h4>
      <p>We don't expect you to pay for a product that has bugs in it.</p>
    </div>
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-time logo-small"></span>
      <h4>Efficient</h4>
      <p>We work in a timely manner in order to achieve the best possible website.</p>
    </div>
  </div>
  <br><br>
  <div class="row slideanim">
   <div class="col-sm-4">
      <span class="glyphicon glyphicon-th-large logo-small"></span>
      <h4>CERTIFIED</h4>
      <p>Websites are developed by a Microsoft certified developer.</p>
    </div>
    <div class="col-sm-4">
      <span class="	glyphicon glyphicon-info-sign logo-small"></span>
      <h4>INFO</h4>
      <p>You can contact us anytime and we would be glad to help.</p>
    </div>
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-briefcase logo-small"></span>
      <h4 style="color:#303030;">HARD WORK</h4>
      <p>We won't stop working until the website meets our standards.</p>
    </div>
  </div>
</div>

<!-- Container (Portfolio Section) -->
<div id="portfolio" class="container-fluid text-center bg-grey">
  <h2>Portfolio</h2><br>
  <h4>What we have created</h4>
  <div class="row slideanim">
      <center>
          <a href="http://www.oc-doodles.com" target="_blank">
            <img class="rounded mx-auto d-block" src="Website OC Doodles.png" width="50%" height="50%" alt="OC Doodles">
            <h4>OC Doodles</h4>
          </a>
      </center>
  </div>
  <!--<div class="row text-center slideanim">
    <div class="col-sm-4">
      <div class="thumbnail">
        <img src="paris.jpg" alt="Paris" width="400" height="300">
        <p><strong>Paris</strong></p>
        <p>Yes, we built Paris</p>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="thumbnail">
        <img src="newyork.jpg" alt="New York" width="400" height="300">
        <p><strong>New York</strong></p>
        <p>We built New York</p>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="thumbnail">
        <img src="sanfran.jpg" alt="San Francisco" width="400" height="300">
        <p><strong>San Francisco</strong></p>
        <p>Yes, San Fran is ours</p>
      </div>
    </div>
  </div><br>
  
  <h2>What our customers say</h2>
  <div id="myCarousel" class="carousel slide text-center" data-ride="carousel">-->
</div>

<!-- Container (Pricing Section) -->
<div id="pricing" class="container-fluid">
  <div class="text-center">
    <h2>Website Calculator</h2>
    <h4>Create a website that works for you</h4>
  </div>
  <div class="row slideanim">
      <center><a href="WebsiteCalculator" target="_blank" id="ddd"><img src="WebsiteCalculator.png" alt="Website Calculator Link" class="img-rounded img-responsive"> </a></center>
      <center><a href="WebsiteCalculator" target="_blank" id="ttt"><img src="WebsiteCalculatorOld.png" alt="Website Calculator Link" class="img-rounded img-responsive"  width="50%" height="50%"> </a></center>
      <!--<iframe class="hidden" style="width:100%; height:60em;" src="http://bedroomstudiosllc.com/WebsiteCalculator"></iframe>-->
  </div>
</div>

<!-- Container (Contact Section) -->
<div id="contact" class="container-fluid bg-grey">
  <h2 class="text-center">CONTACT</h2>
  <div class="row">
    <div class="col-sm-5">
      <p>Contact us and we'll get back to you within 24 hours.</p>
      <p><span class="glyphicon glyphicon-map-marker"></span> Lake Ozark, US</p>
      <p><span class="glyphicon glyphicon-phone"></span> +1 573.280.7152</p>
      <p><span class="glyphicon glyphicon-envelope"></span> mark@bedroomstudiosllc.com</p>
    </div>
    <div class="col-sm-7 slideanim">
      <form action="" method="post">
              <?php 
        if(isset($_POST['name'])){
            $msg = $_POST['email'] . " has contacted you the following information: \n" . $_POST['comments'];
            mail("bedroomstudiosllc@gmail.com", "Potential Customer", $msg);
            echo '<h3>Email successfully sent</h3>';
        }
    ?>
      <div class="row">
        <div class="col-sm-6 form-group">
          <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
        </div>
        <div class="col-sm-6 form-group">
          <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
        </div>
      </div>
      <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea><br>
      <div class="row">
        <div class="col-sm-12 form-group">
          <button class="btn btn-default pull-right" type="submit">Send</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Add Google Maps -->
<div id="googleMap" style="">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d200685.26405519125!2d-93.10553916344087!3d38.19347373337756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87c4f18849de53ed%3A0xc875e3f42232f406!2sLake+of+the+Ozarks!5e0!3m2!1sen!2sus!4v1527730252886" width="100%" height="400px" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
<!--
To use this code on your website, get a free API key from Google.
Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
-->

<footer class="container-fluid text-center">
  <a href="#myPage" title="To Top">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a>
    <br>
    <span>© 2018 Copyright: Bedroom  Studios, LLC</span>
</footer>

<script>
$(document).ready(function(){
  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
  
  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
        if (pos < winTop + 600) {
          $(this).addClass("slide");
        }
    });
  });
})
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-120131649-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-120131649-1');
</script>
</body>
</html>
