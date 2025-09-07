
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="refresh" content="3">
<title>Photos de Jade</title>

<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>

<style type="text/css">
* { margin: 0; padding: 0; border: 0; }
body {
background-color: #fff;
background-image:
linear-gradient(90deg, transparent 79px, #abced4 79px, #abced4 81px, transparent 81px),
linear-gradient(#eee .1em, transparent .1em);
background-size: 100% 1.2em;
font-family: Raleway;
}
#container {
width: 80%;
margin: 10px auto;
text-align: center;
}
h1 {
font: bold 65px/60px Helvetica, Arial, Sans-serif;
text-align: center; color: #eee;
text-shadow: 0px 2px 6px #333;
}
h2 {
display: block; text-decoration: none; margin: 0 0 30px 0;
font: italic 45px Georgia, Times, Serif;
text-align: center; color: #bfe1f1;
text-shadow: 0px 2px 6px #333;
}
ul.gallery {
list-style: none;
margin: auto;
margin-top: 100px;
width: 800px;
}
ul.gallery li div {
position: relative;
/*float: left;*/
display: inline-block;
padding: 15px 15px 25px 15px;
background: #eee;
border: 1px solid #fff;
-moz-box-shadow: 0px 2px 15px #333;
max-height: 50%;
width: 80%;
}
ul.gallery div:after {
content: attr(title);
font-size: 200%;
color: #444;
display: block;
}
ul.gallery li div img{
}
ul.gallery li div.pic-1 {
z-index: 1;
-webkit-transform: rotate(-10deg);
-moz-transform: rotate(-10deg);
}
ul.gallery li div.pic-2 {
z-index: 5;
-webkit-transform: rotate(-3deg);
-moz-transform: rotate(-3deg);
}
ul.gallery li div.pic-3 {
z-index: 3;
-webkit-transform: rotate(4deg);
-moz-transform: rotate(4deg);
}
ul.gallery li div.pic-4 {
z-index: 4;
-webkit-transform: rotate(14deg);
-moz-transform: rotate(14deg);
}
ul.gallery li div.pic-5 {
z-index: 2;
-webkit-transform: rotate(-12deg);
-moz-transform: rotate(-12deg);
}
ul.gallery li div.pic-6 {
z-index: 6;
-webkit-transform: rotate(5deg);
-moz-transform: rotate(5deg);
}

</style>
</head>

<body>

<div id="container">
<h1>Photos de Jade</h1>
<ul class="gallery">
<?php
require("php/common/util.php");
for($i = 0 ; $i < 1 ; $i++){
$filename=getRandomImage($basedir);
$camera=cameraUsed($filename);
echo '<li>' . "\n";
echo '<div title="' . $camera['date'] . '" class="pic-' . (rand(0,10)+$i)%7  . '">' . "\n" ;
echo '<img alt="" src="php/common/createthumb.php?filename=' . $filename . '&amp;size=600&amp;squared=0"/>' . "\n";
echo '</div>' . "\n";
echo '</li>' . "\n";
}
?>
</ul>
</body>
</html>
