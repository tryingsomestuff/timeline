<!doctype html>
<html lang="en" class="no-js">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href='http://fonts.googleapis.com/css?family=Droid+Serif|Open+Sans:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
<link rel="stylesheet" href="css/timeline.css"> <!-- Resource style -->
<link rel="stylesheet" href="css/gallery.css"> <!-- Resource style -->
<script src="js/modernizr.js"></script> <!-- Modernizr -->

<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/lightbox.min.js"></script>
<link href="css/lightbox.css" rel="stylesheet"/>

<title>Photo</title>

</head>

<?php
require("config.php");
require("util.php");
?>

<body>
<header>
<h1>Photos : <?php echo basename($basedir); ?>, by Julia et Vivien</h1>
</header>

<p>
   <a href="index.php?directory=<?php echo $basedir;?>/../">
      <img id="gal_sticky_icon" src="img/up.png" width=64>
   </a>
</p>
<span id="gal_count"></span>
<div id="gal_loading_icon"></div>

<section id="cd-timeline" class="cd-container">

<?php

// list of files and dirs in current directory
$files = listdir($basedir);
//rsort($files, SORT_LOCALE_STRING);

// put files and dirs in specific lists
$dirs=array();
$pics=array();
for ( $i=0 ; $i < count($files); ++$i){
    $f=$files[$i];
    if (is_dir($f)){
        $dirs[] = $f;
    }
    else{
        $pics[] = $f;
    }
}

// can be used to show only dirs as soon as one dir is present
$showonlydir = 0;

// sort be date (exif info for pics)
usort($dirs,'sortDir');
usort($pics,'sortPic');

// show dirs first
for ( $i=0 ; $i < count($dirs); ++$i){
    $f=$dirs[$i];

    // do not disply thumbs dir of course !
    if ( basename($f) == "thumbs" ) continue;

    $showonlydir = 1;

    $linkb='<a href="index.php?directory=' . $f . '">';
    $linke='</a>';

    echo '<div class="cd-timeline-block">';
    echo '<div class="cd-timeline-img cd-picture">';
    echo '<img src="img/cd-icon-location.svg" alt="Picture">';
    echo '</div> <!-- cd-timeline-img -->';
    echo '';
    echo '<div class="cd-timeline-content">';
    echo '<h2> Collection : ' . basename($f) . '</h2>';
    //$dirthumb=getFirstImage($f);
    $dirthumb=getRandomImage($f);
    $camera = cameraUsed($dirthumb);
    echo '<p class="cd-timeline-dirthumb">' . $linkb . '<img class="gal_imgthumb gal_tilt gal_dir" src="createthumb.php?filename=' . $dirthumb . '&amp;size=' . $thumbsize . '" alt="not found"/>' . $linke . '</p>';
    echo '<p class="cd-timeline-legend"> Photo taken on : ' . $camera['date'] . '</p>';
    echo '</div> <!-- cd-timeline-content -->';
    echo '</div> <!-- cd-timeline-block -->';
}

// then show pics
for ( $i=0 ; $i < count($pics); ++$i){
    $f=$pics[$i];
    //if ( $showonlydir == 1 ) continue;
    $camera = cameraUsed($f);
    echo '<div class="cd-timeline-block">';
    echo '<div class="cd-timeline-img cd-picture">';
    echo '<img src="img/cd-icon-picture.svg" alt="Picture">';
    echo '</div> <!-- cd-timeline-img -->';
    echo '';
    echo '<div class="cd-timeline-content">';
    echo '<h2>' . $camera['date'] . '</h2><p></p>';
    echo '<a class="gal_hreflightbox" data-lightbox="lightbox" href="createthumb.php?filename=' . $f . '&amp;size=' . $lightboxsize . '" title="' . $camera['date'] . '">';
    echo '<img class="gal_imgthumb gal_tilt" src="createthumb.php?filename=' . $f . '&amp;size=' . $thumbsize . '"/></a>';
    $fnoext = preg_replace('/\\.[^.\\s]{3,4}$/', '', $f);
    if ( file_exists($fnoext . ".txt" )){
        $txt = file_get_contents($fnoext . ".txt");
        echo '<p class="cd-timeline-desc">' . $txt . '</p>';
    }
    //echo '<p class="cd-timeline-legend">Lens : ' . $camera['lens'] . '</p>';
    echo '<p class="cd-timeline-legend">Parameters : ';
    echo $camera['exposure'] . ', ';
    echo $camera['aperture'] . ', ';
    echo 'iso ' . $camera['iso'];
    //echo $camera['make'] . ' ' . $camera['model'];
    echo '</p>';
    echo '<p class="cd-timeline-legend">File name : ' . basename($f) . '</p>';
    echo '<a href="download.php?download_file='. $f .'" class="cd-read-more" target="_blank">Download</a>';
//    echo '<span class="cd-date">' . $camera['date'] . '</span>';
    echo '</div> <!-- cd-timeline-content -->';
    echo '</div> <!-- cd-timeline-block -->';

}
?>

</section> <!-- cd-timeline -->

<script src="js/gallery.js"></script>
<script src="js/timeline.js"></script>

</body>
</html>
