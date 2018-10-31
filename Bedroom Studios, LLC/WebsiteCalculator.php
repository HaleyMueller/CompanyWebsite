<!DOCTYPE html PUBLIC "-W3C//DD XHTML 1.0 Strict//EN""Http//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmins="http://www.w3.org/1999.xhtml">
<head>
    <title>Website Calculator</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta name="description" content="Easy to use website calculator."/>
    <meta name="keywords" content="cheap websites, website calculator, website creation missouri, website creation">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        function guid() {
            return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
                s4() + '-' + s4() + s4() + s4();
        }

        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
                .toString(16)
                .substring(1);
        }
        var GUID = guid();
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            var i = 0;
            $('#buttonQuestion').click(function(){
                alert("pushed");
                var inputValue = GUID;
                $.getJSON("WebsiteCalculator?GUID="+GUID+"value="+i, function(obj) {
                });
                i += i;
            });
        });
    </script>
</head>
<?php
    if(isset($_GET['GUID'])){
        $username = "u246470952_root";
        $password = "Markiscool1";
        $database = "u246470952_ticke";
        $hostname = "localhost";

        $conn = mysqli_connect($hostname, $username, $password, $database);

        $GUID = stripcslashes($_GET['GUID']);
        $Value = stripcslashes($_GET['value']);

        if(!$conn){
            die("Failed to connect to database" . mysqli_connect_error());
        }

        $sql =  "INSERT INTO `WebsiteCalculatorDistance` (`WebsiteCalculatorDistanceID`, `GUID`, `Value`) VALUES (NULL, '".$GUID."', ".$Value.")";
        if (mysqli_query($conn, $sql) === TRUE) {

        }
    }
?>
<style>
    body{
        height: 100%;
        -webkit-background-size: auto;
        -moz-background-size: auto;
        -o-background-size: auto;
        background-size: auto;
        background: #3366cc;
        background-repeat:repeat;
        background: -webkit-linear-gradient(#3366cc, #1f3d7a);
        background:    -moz-linear-gradient(#3366cc, #1f3d7a);
        background:         linear-gradient(#3366cc, #1f3d7a);
    }

    html {
        height: 100%;
        -webkit-background-size: auto;
        -moz-background-size: auto;
        -o-background-size: auto;
        background-size: auto;
        background: #3366cc;
        background-repeat:repeat;
        background: -webkit-linear-gradient(#3366cc, #1f3d7a);
        background:    -moz-linear-gradient(#3366cc, #1f3d7a);
        background:         linear-gradient(#3366cc, #1f3d7a);
    }

    .stepwizard-step p {
        margin-top: 1%;
    }

    .stepwizard-row {
        display: table-row;
        opacity: 1;
    }

    .stepwizard {
        display: table;
        width: 100%;
        position: relative;
    }

    .stepwizard-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important;
    }

    .stepwizard-row:before {
        top: 25%;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1%;
        background-color: #ccc;
        z-order: 0;

    }

    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
    }

    .btn-circle {
        width: 3em;
        height: 3em;
        text-align: center;
        padding: 1% 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 100%;
    }

    .buttonText{
        color: white;
        font-size: 1.25em;
    }

    @media min-width: 6px{
        .col button h2{
            color: blue;
            font-size: .1em;
        }
        .test{
            font-size: 1em;
        }
        .end{
            font-size: .1em;
        }
    }
    @media (min-width:320px) {
        .test{
            font-size: 2em;
        }
        .col button h2{
            color: white;
            font-size: .6em;
        }
        .end{
            font-size: 2em;
        }
    }
    @media (min-width:800px) {
        .test{
            font-size: 2em;
        }
        .col button h2{
            color: white;
            font-size: .8em;
        }
        .end{
            font-size: 3em;
        }
    }
    @media (min-width:1025px) {
        .test{
            font-size: 3em;
        }
        .col button h2{
            color: white;
            font-size: 1em;
        }
        .end{
            font-size:4em;
        }
    }

    .col button h2{

    }
</style>
<body <?php if(!isset($_POST['submit']))echo"onload='stepWizard(0);pages();'";?>>
    <div class="stepwizard" id="stepwizard">
    </div>
    <center>
        <div style="margin:20%; margin-top:5%" id="Main">

        </div>
    </center>
    <div id="Main2">
     <?php
        if(isset($_POST['submit'])){

            $username = "u246470952_root";
            $password = "Markiscool1";
            $database = "u246470952_ticke";
            $hostname = "localhost";

            $conn = mysqli_connect($hostname, $username, $password, $database);

            if(!$conn){
                die("Failed to connect to database" . mysqli_connect_error());
            }

                $sql = "INSERT INTO `WebsiteCalculator` (`InquiryID`, `Price`, `Needed`, `Email`, `DateSent`) VALUES (null, ".$_POST['price'].", '".str_replace("'", "\'", $_POST['Needed'])."', '".$_POST['email']."', '".date("Y-m-d h:i:sa")."');";
                //$query = mysqli_query($conn, $sql);
                if (mysqli_query($conn, $sql) === TRUE) {
                    mail("mark@bedroomstudiosllc.com", "New Website Calculator Result", "From: ".$_POST['email']."\nCost: $".$_POST['price']."\nDetails: " . str_replace("'", "\'", $_POST['Needed']));
                } else {
                    echo "Error updating record: " . $conn->error;
                }


            echo  '<script>stepWizard(2);</script><center><h3 class="display-1 end" style="color:white;margin-top:20%;margin-bottom:5%;">Your estimated price is:</h3>' .
            '<h3 class="display-1 end" style="color:white;margin-bottom:2%;">$'.$_POST['price'].'</h3></center>';
        }
     ?>
    </div>
    <footer class="footer">
        <center>
            <!--<h4><a href="bedroomstudiosllc.com" style="color:white;">© 2018 Copyright: Bedroom Studios, LLC</a></h4>-->
        </center>
    </footer>
</body>
<script>

    function stepWizard(pos){
        switch(pos){
            case 0:
                document.getElementById("stepwizard").innerHTML = '        <div class="stepwizard-row">\n' +
                    '            <div class="stepwizard-step">\n' +
                    '                <button type="button" class="btn btn-primary btn-circle" style="background-color:#2e5cb8">1</button>\n' +
                    '                <p class="buttonText">Detail</p>\n' +
                    '            </div>\n' +
                    '            <div class="stepwizard-step">\n' +
                    '                <button type="button" class="btn btn-default btn-circle">2</button>\n' +
                    '                <p class="buttonText">Specifics</p>\n' +
                    '            </div>\n' +
                    '            <div class="stepwizard-step">\n' +
                    '                <button type="button" class="btn btn-default btn-circle">3</button>\n' +
                    '                <p class="buttonText">Price</p>\n' +
                    '            </div>\n' +
                    '        </div>';
                break;
            case 1:
                document.getElementById("stepwizard").innerHTML = '        <div class="stepwizard-row">\n' +
                    '            <div class="stepwizard-step">\n' +
                    '                <button type="button" class="btn btn-default btn-circle">1</button>\n' +
                    '                <p class="buttonText">Detail</p>\n' +
                    '            </div>\n' +
                    '            <div class="stepwizard-step">\n' +
                    '                <button type="button" class="btn btn-primary btn-circle" style="background-color:#2e5cb8">2</button>\n' +
                    '                <p class="buttonText">Specifics</p>\n' +
                    '            </div>\n' +
                    '            <div class="stepwizard-step">\n' +
                    '                <button type="button" class="btn btn-default btn-circle">3</button>\n' +
                    '                <p class="buttonText">Price</p>\n' +
                    '            </div>\n' +
                    '        </div>';
                break;
            case 2:
                document.getElementById("stepwizard").innerHTML = '        <div class="stepwizard-row">\n' +
                    '            <div class="stepwizard-step">\n' +
                    '                <button type="button" class="btn btn-default btn-circle">1</button>\n' +
                    '                <p class="buttonText">Detail</p>\n' +
                    '            </div>\n' +
                    '            <div class="stepwizard-step">\n' +
                    '                <button type="button" class="btn btn-default btn-circle">2</button>\n' +
                    '                <p class="buttonText">Specifics</p>\n' +
                    '            </div>\n' +
                    '            <div class="stepwizard-step">\n' +
                    '                <button type="button" class="btn btn-primary btn-circle" style="background-color:#2e5cb8">3</button>\n' +
                    '                <p class="buttonText">Price</p>\n' +
                    '            </div>\n' +
                    '        </div>';
                break;
        }
    }

    var numPages;
    var mobileFriendlyV;
    var slideShowV;
    var socialMediaV;
    var contactFormV;
var ii = 0;
    function display(header, middleType, middle, click){
        var middleMeat = "";

        switch(middleType){
            case "Buttons":
                middleMeat = '<div class="row">';
                for (var i = 0; i < middle.length; i++) {
                    middleMeat += '<div class="col"><button style="margin-top:5%;" id="buttonQuestion" class="btn btn-sq-lg btn-primary buttonQuestion test" onclick="'+click[i]+'" value="YES."><h2>'+middle[i]+'</h2></button></div>';
                }
                middleMeat+= '</div>';
                break;
            case "Number":
                middleMeat = middle;
                middleMeat += '<button style="margin-top:7%" id="buttonQuestion" class="btn btn-sq-lg btn-primary buttonQuestion test" onclick="' + click + '"><h2>Continue</h2></button>';
                break;
        }
        var inputValue = GUID;
        $.getJSON("WebsiteCalculator?GUID="+GUID+"&value="+ii, function(obj) {
        });
        ii = ii + 1;
        document.getElementById("Main").innerHTML = '<h2 class="display-3 test" style="color:white;">'+header+'</h2>' + middleMeat ;
    }

    function pages(){
        display("How Many Web Pages Would You Like?", "Number", "<input style='width:50%; margin-top:7%;' class='form-control' type='number' id='Pages'></input>", "numPages = document.getElementById('Pages').value;if(!isNaN(document.getElementById('Pages').value) && document.getElementById('Pages').value.length > 0 && document.getElementById('Pages').value > 0)mobileFriendly();");
    }

    function mobileFriendly(){
        var c = ["YES.", "NO."];
        var d = ['mobileFriendlyV=true;slideShow();', 'mobileFriendlyV=false;slideShow();'];
        display("Would You Like A Mobile Friendly Website?", "Buttons", c, d);
    }

    function slideShow() {
        var c = ["YES.", "NO."];
        var d = ['slideShowV=true;socialMedia();', 'slideShowV=false;socialMedia();'];
        display("Would You Like A Picture Slideshow?", "Buttons", c, d);
    }

    function socialMedia() {
        var c = ["YES.", "NO."];
        var d = ['socialMediaV=true;contactForm();', 'socialMediaV=false;contactForm();'];
        display("Would You Like Social Media Integration?", "Buttons", c, d);
    }

    function contactForm() {
        var c = ["YES.", "NO."];
        var d = ['contactFormV=true;loginSystem();', 'contactFormV=false;loginSystem();'];
        display("Would You Like A 'Contact Us' Form?", "Buttons", c, d);
    }

    var login = -1; //2 Multiple, 1 Admin, 0 None
    function loginSystem() {
        var c = ["Multiple Credentials for Users.", "Just an Admin Login is Fine.", "I Don't Need to be Able to Log In."];
        var d = ['login=2;registerSystem();', 'login=1;registerSystem();', 'login=0;registerSystem();'];
        display("Would You Like A Way To Log In?", "Buttons", c, d);
    }

    var register = false;
    function registerSystem() {
        var c = ["YES.", "NO."];
        var d = ['register=true;forumSystem();', 'register=false;forumSystem();'];
        display("Would Users Need to 'Sign Up' To Make An Account?", "Buttons", c, d);
    }

    var comment = false;
    function forumSystem() {
        var c = ["YES.", "NO."];
        var d = ['comment=true;rateSystem();', 'comment=false;rateSystem();'];
        display("Would You Like A Comment System?", "Buttons", c, d);
    }

    var rate = false;
    function rateSystem() {
        var c = ["YES.", "NO."];
        var d = ['rate=true;searchSystem();', 'rate=false;searchSystem();'];
        display("Would You Like A Rating System?", "Buttons", c, d);
    }

    var search = false;
    function searchSystem() {
        var c = ["YES.", "NO."];
        var d = ['search=true;google();', 'search=false;google();'];
        display("Would You Like A Search Bar System?", "Buttons", c, d);
    }

    var SEO = false;
    function google() {
        var c = ["YES.", "NO."];
        var d = ['SEO=true;analytical();', 'SEO=false;analytical();'];
        display("Would You Like Your Website To Be Shown On Google?", "Buttons", c, d);
    }

    var analytics = false;
    function analytical() {
        var c = ["YES.", "NO."];
        var d = ['analytics=true;mapSystem();', 'analytics=false;mapSystem();'];
        display("Would You Like Your Website To Show Analytical Data?", "Buttons", c, d);
    }

    var maps = false;
    function mapSystem() {
        var c = ["YES.", "NO."];
        var d = ['maps=true;adSystem();', 'maps=false;adSystem();'];
        display("Would You Like To Include Google Maps?", "Buttons", c, d);
    }

    var ads = false;
    function adSystem() {
        var c = ["YES.", "NO."];
        var d = ['ads=true;details();', 'ads=false;details();'];
        display("Would You Like Ads On Your Page?", "Buttons", c, d);
    }

    var price = 0;
    function details(){
        stepWizard(1);
        price += numPages * 5;
        if(slideShowV) price += 2;
        if(mobileFriendlyV) price += numPages * 5;
        if(socialMediaV) price += 3;
        if(contactFormV) price += 3;
        switch (login){
            case 2: //Multiple
                price += 7;
                break;
            case 1: //Admin Only
                price += 3;
                break;
        }
        if(register) price += 6;
        if(comment) price += 5;
        if(rate) price += 5;
        if(search) price += 10;
        if(SEO) price += 3;
        if(analytics) price += 3;
        if(maps) price += 3;
        if(ads) price += 4;
        document.getElementById("Main").innerHTML = '<h3 class="display-3 test" style="color:white;margin-bottom:7%;">We Need Additional Information for Your Free Quote</h3>'+
            '<form method="post">' +
            '<input type="text" name="email" class="form-control" placeholder="Email or Phone Number"/><br><br>' +
            '<h4 class="display-3 test" style="color:white;margin-bottom:7%;">What Are You Looking For in a Website?</h4>' +
            '<input type="hidden" name="price" id="hiddenField" value="'+(price*50)+'"/>' +
            '<textarea name="Needed" cols="50" rows="7" style="height:100%;" class="form-control" id="textArea"></textarea>' +
            '<button name="submit" style="margin-top:7%" class="btn btn-sq-lg btn-primary buttonQuestion test">Submit</button>' +
            '</form>';
        $.getJSON("WebsiteCalculator?GUID="+GUID+"&value=99", function(obj) {
        });
    }

    function pricing(){
        stepWizard(2);


        document.getElementById("Main").innerHTML =
            '<h3 class="display-1 end" style="color:white;margin-top:25%;margin-bottom:5%;">Your estimated price is:</h3>' +
            '<h3 class="display-1 end" style="color:white;margin-bottom:2%;">$'+(price*50).toFixed(0).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')+'</h3>';
            /*'<div style="">' +
            '<table style="color:white; display:inline-block" class="buttonQuestion test">' +
            '<tr><th>Item</th><th>Wanted</th></tr>' +
            '<tr><td>Pages</td><td align="right">'+numPages+'</td></tr>' +
            '<tr><td>SlideShow</td><td align="right">'+slideShowV+'</td></tr>' +
            '<tr><td>Social Media</td><td align="right">'+socialMediaV+'</td></tr>' +
            '<tr><td>Contact Form</td><td align="right">'+contactFormV+'</td></tr>' +
            '<tr><td>Login System</td><td align="right">'+login+'</td></tr>' +
            '<tr><td>Registration</td><td align="right">'+register+'</td></tr>' +
            '<tr><td>Comment System</td><td align="right">'+comment+'</td></tr>' +
            '<tr><td>Rating System</td><td align="right">'+rate+'</td></tr>' +
            '<tr><td>Search System</td><td align="right">'+search+'</td></tr>' +
            '<tr><td>Search Engine Optimization</td><td align="right">'+SEO+'</td></tr>' +
            '<tr><td>Analytical Data</td><td align="right">'+analytics+'</td></tr>' +
            '<tr><td>Google Maps</td><td align="right">'+maps+'</td></tr>' +
            '</table>' +
            '</div>';*/
    }
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-120131649-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-120131649-1');
</script>
</html>

<!--slideshow//
contact form//
SEO//
Login//
Register //
amount of pages //
cms
social media integration//
chat forms //
google analytics//
create profiles//
rate/review //
serach bar //
google maps//
adsense-->