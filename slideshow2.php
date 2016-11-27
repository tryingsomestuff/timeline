<!doctype html>
<html>
<head>
<meta charset="utf-8">
<?php
$nb=10;
$freq=5;
echo '<meta http-equiv="refresh" content="' . ($nb*$freq) . '">';
?>
<title>Photos de Jade</title>
<link href="normalize.css" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<style class="cp-pen-styles">

html { min-height: 100%; }
body { height: 100%; }

.slideshow {
  list-style: none;
  z-index: 1;
}

.slideshow li span {
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0px;
  left: 0px;
  color: transparent;
  background-size: contain;
  background-position: 50% 50%;
  background-repeat: no-repeat;
  opacity: 0;
  z-index: 0;
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  -webkit-animation: imageAnimation <?php echo $freq*2;?>s linear 1 0s;
  -moz-animation: imageAnimation <?php echo $freq*2;?>s linear 1 0s;
  animation: imageAnimation <?php echo $freq*2;?>s linear 1 0s;
}

.slideshow li h3 {
  position: absolute;
  text-align: center;
  z-index: 2;
  bottom: 150px;
  left: 0;
  right: 0;
  opacity: 100;
  font-size: 2em;
  font-family: 'roboto', sans-serif;
  text-transform: uppercase;
  color: #999;
/*
  -webkit-animation: titleAnimation <?php echo $freq*4;?>s linear 1 0s;
  -moz-animation: titleAnimation <?php echo $freq*4;?>s linear 1 0s;
  animation: titleAnimation <?php echo $freq*4;?>s linear 1 0s;
*/
}
@media only screen and (min-width: 768px) {

.slideshow li h3 {
  bottom: 30px;
  font-size: 2em;
}
}
@media only screen and (min-width: 1024px) {

.slideshow li h3 { font-size: 2em; }
}

<?php
   require("php/common/util.php");

   $title= array();
   for($i = 0 ; $i < $nb ; $i++){
      $filename=getRandomImage($basedir);
      $camera=cameraUsed($filename);
      $title[]=$camera['date'];
      echo '.slideshow li:nth-child(' . ($i+1) . ') span { ' . "\n";
      echo '     background-image: url(http://192.168.1.19/p/timeline/php/common/createthumb.php?filename=' . $filename . '&size=900&squared=0);' . "\n";
      echo '     -webkit-animation-delay: ' . ($i*$freq) . 's;' . "\n" ;
      echo '     -moz-animation-delay: ' . ($i*$freq) . 's;' . "\n" ;
      echo '     animation-delay: ' . ($i*$freq) . 's;' . "\n" ;
      echo '}' . "\n";
   }
?>

@-webkit-keyframes
imageAnimation {  0% {
 opacity: 0;
 -webkit-animation-timing-function: ease-in;
}
 12.5% {
 opacity: 1;
}
 42.5% {
 opacity: 1;
}
 75% {
 opacity: 1;
 -webkit-animation-timing-function: ease-out;
}
 100% {
 opacity: 0;
}
}
@-moz-keyframes
imageAnimation {  0% {
 opacity: 0;
 -moz-animation-timing-function: ease-in;
}
 12.5% {
 opacity: 1;
}
 42.5% {
 opacity: 1;
}
 75% {
 opacity: 1;
 -moz-animation-timing-function: ease-out;
}
 100% {
 opacity: 0;
}
}
@keyframes
imageAnimation {  0% {
 opacity: 0;
 -webkit-animation-timing-function: ease-in;
 -moz-animation-timing-function: ease-in;
 animation-timing-function: ease-in;
}
 12.5% {
 opacity: 1;
}
 42.5% {
 opacity: 1;
}
 75% {
 opacity: 0;
 -webkit-animation-timing-function: ease-out;
 -moz-animation-timing-function: ease-out;
 animation-timing-function: ease-out;
}
 100% {
 opacity: 0;
}
}
@-webkit-keyframes
titleAnimation {  0% {
 opacity: 0;
}
 12.5% {
 opacity: 1;
}
 25% {
 opacity: 1;
}
 37.5% {
 opacity: 0;
}
 100% {
 opacity: 0;
}
}
@-moz-keyframes
titleAnimation {  0% {
 opacity: 0;
}
 12.5% {
 opacity: 1;
}
 25% {
 opacity: 1;
}
 37.5% {
 opacity: 0;
}
 100% {
 opacity: 0;
}
}
@keyframes
titleAnimation {  0% {
 opacity: 0;
}
 12.5% {
 opacity: 1;
}
 25% {
 opacity: 1;
}
 37.5% {
 opacity: 0;
}
 100% {
 opacity: 0;
}
}

.no-cssanimations .slideshow li span { opacity: 1; }

</style>
</head>

<body>
<ul class="slideshow">
<?php
for($i = 0 ; $i < $nb ; $i++){
   echo '<li>' . "\n";
   echo '<span>' . "\n" ;
   echo '<h3>' . $title[$i] . '</h3>' .  "\n";
   echo '</span>' . "\n";
   echo '</li>' . "\n";
}
?>
</ul>
</body>
</html>
