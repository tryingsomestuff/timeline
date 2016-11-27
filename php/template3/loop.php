<?php
require("php/common/util.php");

function get_linkb($f){
   return '<a href="index_all.php' . fullUrlOption($f) . '">';
}

function get_linke($f){
   return '</a>';
}

function generate_html_dir($f){

    global $thumbsize;
    global $thumbsizedir;
    global $lightboxsize;

    $linkb=get_linkb($f);
    $linke=get_linke($f);

    //$dirthumb=getFirstImage($f);
    $dirthumb=getRandomImage($f);
    $camera = cameraUsed($dirthumb);
    
    $ret = "";
    $ret .= '<li>' . "\n";
    $ret .= '<figure>' . "\n";
    $ret .= $linkb .'<img class="gal_dirthumb" src="php/common/createthumb.php?filename=' . $dirthumb . '&amp;size=' . $thumbsizedir . '&amp;squared=0" alt="not found"/>' . $linke . "\n";
//  $ret .= '<figcaption><h3> Collection : ' . basename($f) . '</h3></figcaption>' . "\n";
    $ret .= '</figure>' . "\n";
    $ret .= '</li>' . "\n" . "\n";
    return $ret;
}

function generate_html_file($f){

    global $thumbsize;
    global $thumbsizedir;
    global $lightboxsize;

    $camera = cameraUsed($f);
    $fnoext = preg_replace('/\\.[^.\\s]{3,4}$/', '', $f);
    
    $ret = "";
    $r=rand(0,10);
    if ( $r == 1 ){
       $ret .= '<li class="featureA">' . "\n";
    }
    else if ( $r == 2){
       $ret .= '<li class="featureB">' . "\n";
    }
    else{
       $ret .= '<li>' ."\n";
    }
    $ret .= '<figure>' . "\n";
    $ret .= '<img class="gal_imgthumb" src="php/common/createthumb.php?filename=' . $f . '&amp;size=' . $thumbsize . '&amp;squared=0" alt="not found"/>' . "\n";
    $ret .= '</figure>' . "\n";
    $ret .= '</li>' . "\n" . "\n";
    return $ret;
}

function generate_html_slideshow($f){

    global $thumbsize;
    global $thumbsizedir;
    global $lightboxsize;

    $camera = cameraUsed($f);
    $fnoext = preg_replace('/\\.[^.\\s]{3,4}$/', '', $f);

    $ret = "";
    $ret .= '<li>' . "\n";
    $ret .= '<figure>' . "\n";
    $ret .= '<figcaption><h3>' . $camera['date'] . '</h3>';
    $ret .= '<p>Parameters : ';
    $ret .= $camera['exposure'] . ', ';
    $ret .= $camera['aperture'] . ', ';
    $ret .= 'iso ' . $camera['iso'];
    $ret .= '</p>' . "\n";
    $ret .= '<a href="php/common/download.php?download_file='. $f .'" target="_blank">Download</a>' . "\n";
    if ( file_exists($fnoext . ".txt" )){
        $txt = file_get_contents($fnoext . ".txt");
        $ret .= '<p>' . $txt . '</p>';
    }
    $ret .= '</figcaption>' . "\n";
    $ret .= '<img  class="gal_imgthumb" src="php/common/createthumb.php?filename=' . $f . '&amp;size=' . $lightboxsize . '&amp;squared=0" alt="not found"/>' . "\n";
    $ret .= '</figure>' . "\n";
    $ret .= '</li>' . "\n" . "\n";
	return $ret;
	
}

?>