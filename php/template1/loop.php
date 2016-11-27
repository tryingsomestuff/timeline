<?php
require("php/common/util.php");

function get_linkb($f){
   return '<a href="index.php' . fullUrlOption($f) . '">';
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
    $ret .=  '<div class="cd-timeline-block">';
    $ret .= '<div class="cd-timeline-img cd-picture">';
    $ret .= '<img src="css/img/cd-icon-location.svg" alt="Picture">';
    $ret .= '</div> <!-- cd-timeline-img -->';
    $ret .= '';
    $ret .= '<div class="cd-timeline-content">';
    $ret .= '<h2> Collection : ' . basename($f) . '</h2>';
    $ret .= '<p class="cd-timeline-dirthumb">' . $linkb . '<img class="gal_dirthumb gal_bw gal_tilt gal_dir" src="php/common/createthumb.php?filename=' . $dirthumb . '&amp;size=' . $thumbsizedir . '" alt="not found"/>' . $linke . '</p>';
    $ret .= '<p class="cd-timeline-legend"> Photo taken on : ' . $camera['date'] . '</p>';
    $ret .= '</div> <!-- cd-timeline-content -->';
    $ret .= '</div> <!-- cd-timeline-block -->';
    return $ret;
}

function generate_html_file($f){

    global $thumbsize;
    global $thumbsizedir;
    global $lightboxsize;

    $camera = cameraUsed($f);
    $fnoext = preg_replace('/\\.[^.\\s]{3,4}$/', '', $f);
    
    $ret = "";
    
    $ret .= '<div class="cd-timeline-block">';
    $ret .= '<div class="cd-timeline-img cd-picture">';
    $ret .= '<img src="css/img/cd-icon-picture.svg" alt="Picture">';
    $ret .= '</div> <!-- cd-timeline-img -->';
    $ret .= '';
    $ret .= '<div class="cd-timeline-content">';
    $ret .= '<h2>' . $camera['date'] . '</h2><p></p>';
    $ret .= '<a class="gal_hreflightbox" data-lightbox="lightbox" href="php/common/createthumb.php?filename=' . $f . '&amp;size=' . $lightboxsize . '" title="' . $camera['date'] . '">';
    $ret .= '<img class="gal_imgthumb gal_bw gal_tilt" src="php/common/createthumb.php?filename=' . $f . '&amp;size=' . $thumbsize . '"/></a>';
    
    if ( file_exists($fnoext . ".txt" )){
        $txt = file_get_contents($fnoext . ".txt");
        $ret .= '<p class="cd-timeline-desc">' . $txt . '</p>';
    }
    //$ret .= '<p class="cd-timeline-legend">Lens : ' . $camera['lens'] . '</p>';
    $ret .= '<p class="cd-timeline-legend">Parameters : ';
    $ret .= $camera['exposure'] . ', ';
    $ret .= $camera['aperture'] . ', ';
    $ret .= 'iso ' . $camera['iso'];
    //$ret .= $camera['make'] . ' ' . $camera['model'];
    $ret .= '</p>';
    $ret .= '<p class="cd-timeline-legend">File name : ' . basename($f) . '</p>';
    $ret .= '<a href="php/common/download.php?download_file='. $f .'" class="cd-read-more" target="_blank">Download</a>';
//    $ret .= '<span class="cd-date">' . $camera['date'] . '</span>';
    $ret .= '</div> <!-- cd-timeline-content -->';
    $ret .= '</div> <!-- cd-timeline-block -->';    
    
    return $ret;
}

?>