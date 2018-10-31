<?php

$holiday = "";

$curYir = date("Y");//current year

$now = new DateTime();
$now->format('Y-m-d H:i:s');

$NewYearsBegin = new DateTime($curYir.'-1-01');
$NewYearsEnd = new DateTime($curYir.'-1-02');
if($now > $NewYearsBegin && $now < $NewYearsEnd) $holiday = "newyears";

$EasterBegin = new DateTime($curYir.'-4-24');
$EasterEnd = new DateTime($curYir.'-4-25');
if($now > $EasterBegin && $now < $EasterEnd) $holiday = "easter";

$FourthBegin = new DateTime($curYir.'-7-04');
$FourthEnd = new DateTime($curYir.'-7-05');
if($now > $FourthBegin && $now < $FourthEnd) $holiday = "fourthofjuly";

$HalloweenBegin = new DateTime($curYir.'-10-24');
$HalloweenEnd = new DateTime($curYir.'-10-31');
if($now > $HalloweenBegin && $now < $HalloweenEnd) $holiday = "halloween";

$ChristmasBegin = new DateTime($curYir.'-12-01');
$ChristmasEnd = new DateTime($curYir.'-12-26');
if($now > $ChristmasBegin && $now < $ChristmasEnd) $holiday = "christmas";

switch($holiday) {
    case "halloween":
        $bodyBGColor = "#e67300";
        $bodyColor = "white";

        $headerbackgroundColor = "#ffb366";
        $h1FontColor = "black";

        $companyNameColor = "black";
        $sloganColor = "black";

        $h2FontColor = "black";

        $iframeBorderColor = "white";

        $navbarHeaderFontColor = "white";
        $navbarHeaderBGColor = "black";
        $navbarUserNavFontColor = "white";
        $navbarUserBGColor = "black";
        $navbarBGColor = "black";
        $navbarBorderColor = "#1FA89C";
        $navbarHoverFontColor = "#e67300";
        $navbarHoverBGColor = "black";
        $navbarIconBarsColor = "white";

        $defaultbuttonColor = "black";
        $defaultbuttonBorderColor = "black";

        $tableColor = "black";
        break;
    case "christmas":
        $bodyBGColor = "#bf4040";
        $bodyColor = "white";

        $headerbackgroundColor = "white";
        $h1FontColor = "white";

        $companyNameColor = "#bf4040";
        $sloganColor = "#bf4040";

        $h2FontColor = "white";

        $iframeBorderColor = "white";

        $navbarHeaderFontColor = "#A8D383";
        $navbarHeaderBGColor = "#bf4040";
        $navbarUserNavFontColor = "white";
        $navbarUserBGColor = "#bf4040";
        $navbarBGColor = "#bf4040";
        $navbarBorderColor = "#bf4040";
        $navbarHoverFontColor = "#3399ff";
        $navbarHoverBGColor = "#bf4040";
        $navbarIconBarsColor = "white";

        $defaultbuttonColor = "white";
        $defaultbuttonBorderColor = "white";

        $tableColor = "white";
        break;
    case "easter":
        $bodyBGColor = "#99ccff";
        $bodyColor = "white";

        $headerbackgroundColor = "white";
        $h1FontColor = "white";

        $companyNameColor = "#ff99bb";
        $sloganColor = "#ff99bb";

        $h2FontColor = "white";

        $iframeBorderColor = "white";

        $navbarHeaderFontColor = "#A8D383";
        $navbarHeaderBGColor = "#99ccff";
        $navbarUserNavFontColor = "white";
        $navbarUserBGColor = "#99ccff";
        $navbarBGColor = "#99ccff";
        $navbarBorderColor = "#b3ffe0";
        $navbarHoverFontColor = "#ff99bb";
        $navbarHoverBGColor = "#99ccff";
        $navbarIconBarsColor = "white";

        $defaultbuttonColor = "white";
        $defaultbuttonBorderColor = "white";

        $tableColor = "white";
        break;
    case "newyears":
        $bodyBGColor = "#3399ff";
        $bodyColor = "white";

        $headerbackgroundColor = "white";
        $h1FontColor = "white";

        $companyNameColor = "#bf4040";
        $sloganColor = "#bf4040";

        $h2FontColor = "white";

        $iframeBorderColor = "white";

        $navbarHeaderFontColor = "#A8D383";
        $navbarHeaderBGColor = "#bf4040";
        $navbarUserNavFontColor = "white";
        $navbarUserBGColor = "#bf4040";
        $navbarBGColor = "#bf4040";
        $navbarBorderColor = "#bf4040";
        $navbarHoverFontColor = "#3399ff";
        $navbarHoverBGColor = "#bf4040";
        $navbarIconBarsColor = "white";

        $defaultbuttonColor = "white";
        $defaultbuttonBorderColor = "white";

        $tableColor = "white";
        break;
    case "fourthofjuly":
        $bodyBGColor = "#3399ff";
        $bodyColor = "white";

        $headerbackgroundColor = "white";
        $h1FontColor = "white";

        $companyNameColor = "#bf4040";
        $sloganColor = "#bf4040";

        $h2FontColor = "white";

        $iframeBorderColor = "white";

        $navbarHeaderFontColor = "#A8D383";
        $navbarHeaderBGColor = "#bf4040";
        $navbarUserNavFontColor = "white";
        $navbarUserBGColor = "#bf4040";
        $navbarBGColor = "#bf4040";
        $navbarBorderColor = "#bf4040";
        $navbarHoverFontColor = "#3399ff";
        $navbarHoverBGColor = "#bf4040";
        $navbarIconBarsColor = "white";

        $defaultbuttonColor = "white";
        $defaultbuttonBorderColor = "white";

        $tableColor = "white";
        break;
    default:
        $bodyBGColor = "#1FA89C";
        $bodyColor = "white";

        $headerbackgroundColor = "white";
        $h1FontColor = "white";

        $companyNameColor = "#1FA89C";
        $sloganColor = "#1FA89C";

        $h2FontColor = "white";

        $iframeBorderColor = "white";

        $navbarHeaderFontColor = "#A8D383";
        $navbarHeaderBGColor = "#1FA89C";
        $navbarUserNavFontColor = "white";
        $navbarUserBGColor = "#1FA89C";
        $navbarBGColor = "#1FA89C";
        $navbarBorderColor = "#1FA89C";
        $navbarHoverFontColor = "#A8D383";
        $navbarHoverBGColor = "#1FA89C";
        $navbarIconBarsColor = "white";

        $defaultbuttonColor = "white";
        $defaultbuttonBorderColor = "white";

        $tableColor = "white";
        break;
}

?>
body{
background-color: <?php echo $bodyBGColor ?>;
color: <?php echo $bodyColor ?>;
}
h1{
color: <?php echo $h1FontColor ?>;
}
.display-4{
color: <?php echo $companyNameColor ?>;
}
#slogan{
color: <?php echo $sloganColor ?>;
}
h2, h3, p, label{
color: <?php echo $h2FontColor ?>;
}
.customJumbotron{
background-color: <?php echo $headerbackgroundColor ?>;
margin-top: 3em;
color: <?php echo $h1FontColor ?>;
padding: 2em;
}
.container{
color: <?php echo $h1FontColor ?>; //Color of iframe headers
}

ul.nav a:hover {
color: <?php echo $navbarHoverFontColor ?> !important; background-color: <?php echo $navbarHoverBGColor ?>;
}

#userNavName, #userNavName ul, #userNavName ul li{
color: <?php echo $navbarUserNavFontColor ?>;
background-color: <?php echo $navbarUserBGColor ?>;
}

iframe{
border: 1px solid <?php echo $iframeBorderColor ?>;
border-radius: 1em;
}

table{
color: ?php echo $tableColor ?>;
}

.inset {
width: 48px;
height: 48px;
border-radius: 50%;
box-shadow:
inset 0 0 0 2px rgba(255,255,255,0.6),
0 1px 1px rgba(0,0,0,0.1);
background-color: transparent !important;
z-index: 999;
}

.inset img {
border-radius: inherit;
width: inherit;
height: inherit;
display: block;
position: relative;
z-index: 998;
}

.navbar{
background-color: <?php echo $navbarBGColor ?>;
margin-bottom: 10em;
border-color: <?php echo $navbarBorderColor ?>;
}

.navbar-header{
background-color: <?php echo $navbarBGColor ?>;
border-color: <?php echo $navbarBGColor ?>;
}

.navbar .container-fluid{
background-color: <?php echo $navbarBGColor ?>;
border-color: <?php echo $navbarBGColor ?>;
}

.icon-bar{ //Mobile Bars
background-color: <?php echo $navbarIconBarsColor ?>;
}
.pagination, .page-item, .page-link{
 background-color: red;
}
button {
border: 2px solid <?php echo $defaultbuttonBorderColor ?>;
background-color: transparent;
color: <?php echo $defaultbuttonColor ?>;
}
.table{
color: <?php echo $tableColor ?>;
}