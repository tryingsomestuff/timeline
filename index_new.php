<!doctype html>
<html lang="en" class="no-js">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<meta name="description" content="Photo" />
<meta name="author" content="Vivien" />

<link rel="stylesheet" href="css/common/reset.css">
<link rel="stylesheet" href="css/template2/style.css" />
<link rel="stylesheet" href="css/common/loadingcount.css">

<script src="js/common/jquery-1.11.0.min.js"></script>
<script src="js/common/modernizr.custom.js"></script>

<title>Photos</title>

</head>

<body>
<div class="container">

<header class="clearfix">
<span>Jade</span>
<h1>Photos</h1>
<p>
<?php
require("php/template2/loop.php");

if ( $allowLevelUp ){
    $updir=fullUrlOption($basedir . '/../');
    echo '<nav>';
    echo '<a href="index_new.php' .  $updir .'" class="bp-icon bp-icon-prev"></a>';
    echo '</nav>';
}
?>
</p>

</header>

<span id="gal_count"></span>
<div id="gal_loading_icon"></div>

<div id="grid-gallery" class="grid-gallery">

<?php

$dirs=array();
$pics=array();
getImage($dirs,$pics);

if ( count($dirs) > 0 ){
    echo '<section class="grid-wrap">' . "\n";
    echo '<ul class="grid">' . "\n";
    dirloop($dirs);
    echo '</ul>' . "\n";
    echo '</section>' . "\n" . "\n";
}

if ( count($pics) > 0 ){
    echo '<section class="grid-wrap">';
    echo '<ul class="grid">';
    fileloop($pics);
    echo '</ul>';
    echo '</section>' . "\n" . "\n";

}

echo '<section class="slideshow">' . "\n";
echo '<ul>' . "\n";
slideshowloop($pics);
echo '</ul>' . "\n" . "\n";

echo '<nav>' . "\n";
echo '<span class="icon nav-prev"></span>' . "\n";
echo '<span class="icon nav-next"></span>' . "\n";
echo '<span class="icon nav-close"></span>' . "\n";
echo '</nav>' . "\n";

echo '<div class="info-keys icon">Navigate with arrow keys</div>' . "\n";

echo '</section>' . "\n" . "\n";

?>

</div>
</div>

<script src="js/gallery_new.js"></script>
<script src="js/common/imagesloaded.pkgd.min.js"></script>
<script src="js/common/masonry.pkgd.min.js"></script>
<script src="js/common/classie.js"></script>
<script src="js/cbpGridGallery.js"></script>

<script>
new CBPGridGallery( document.getElementById( 'grid-gallery' ) );
</script>

</body>
</html>
