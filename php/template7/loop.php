<?php
require("php/common/util.php");

function get_linkb($f){
   return '';
}

function get_linke($f){
   return '';
}

function generate_html_dir($f){

    global $thumbsize;
    global $thumbsizedir;
    global $lightboxsize;

    return '';
}

function generate_html_file($f){

    global $thumbsize;
    global $thumbsizedir;
    global $lightboxsize;

    //$camera = cameraUsed($f);
    //$fnoext = preg_replace('/\\.[^.\\s]{3,4}$/', '', $f);

    $ret .= '<a href="#">';
    $ret .= '<img src="php/common/createthumb.php?filename=' . $f . '&amp;size=' . $thumbsize . '&amp;squared=0" alt="not found"</img>';
    $ret .= '</a>' . "\n";
   
    return $ret;
}

function generate_html_slideshow($f){
   return '';
}

?>