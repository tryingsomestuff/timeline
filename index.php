<!doctype html>
<html lang="en" class="no-js">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<meta name="description" content="Photo" />
<meta name="author" content="Vivien" />

<link rel="stylesheet" href="css/common/reset.css">
<link rel="stylesheet" href="css/template1/style.css">
<link rel="stylesheet" href="css/common/loadingcount.css">

<script src="js/common/jquery-1.11.0.min.js"></script>
<script src="js/common/modernizr.js"></script>

<script src="js/common/lightbox.min.js"></script>
<link rel="stylesheet" href="css/common/lightbox.css"/>

<title>Photos</title>

</head>

<body>

<header>
<h1>Photos, by Julia et Vivien</h1>
</header>

<p>
<?php
require("php/template1/loop.php");

$allowLevelUp=false;
if ( $allowLevelUp ){
   echo '<a href="index.php' . fullUrlOption($basedir . "/../") . '">';
   echo '   <img id="gal_sticky_icon" src="css/img/up.png" width=64>';
   echo '</a>';
}
?>
</p>

<span id="gal_count"></span>
<div id="gal_loading_icon"></div>

<section id="cd-timeline" class="cd-container">

<?php
$dirs=array();
$pics=array();
getImage($dirs,$pics);
dirloop($dirs);
fileloop($pics);
?>

</section> <!-- cd-timeline -->

<script src="js/gallery.js"></script>
<script src="js/timeline.js"></script>

</body>
</html>
