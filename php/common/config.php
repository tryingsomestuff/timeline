<?php

//////////////////////////////
//get browsing starting point
//////////////////////////////
$basedir='';
$encryptedDefault=true;
$allowLevelUpDefault=false;
$allowNoStartingPointDefault=false;
$thumbsizeDefault=300;
$thumbsizedirDefault=300;
$lightboxsizeDefault=700;
$createthumbDefault=false;

$encrypted=$encryptedDefault;
$allowLevelUp=$allowLevelUpDefault;
$allowNoStartingPoint=$allowNoStartingPointDefault;
$thumbsize=$thumbsizeDefault;
$thumbsizedir=$thumbsizedirDefault;
$lightboxsize=$lightboxsizeDefault;
$createthumb=$createthumbDefault;

$defaultdir='/mnt/BK1/PHOTO';

$defaultrootdir=$defaultdir;

// from given URL variable
if(isset($_GET['cth'])){
    if ($_GET['cth'] === '1' || $_GET['cth'] === '0'){
        $createthumb=(bool) $_GET['cth'];
    }
}

// from given URL variable
if(isset($_GET['alu'])){
    if ($_GET['alu'] === '1' || $_GET['alu'] === '0'){
        $allowLevelUp=(bool) $_GET['alu'];
    }
}

// from given URL variable
if(isset($_GET['ansp'])){
    if ($_GET['ansp'] === '1' || $_GET['ansp'] === '0'){
        $allowNoStartingPoint=(bool) $_GET['ansp'];
    }
}

// from given URL variable
if(isset($_GET['crt'])){
    if ($_GET['crt'] === '1' || $_GET['crt'] === '0'){
        $encrypted=(bool) $_GET['crt'];
    }
}

// from given URL variable
if(isset($_GET['d'])){
    $basedir=$_GET['d'];
    if($encrypted){
        $basedir=decode($basedir);
    }
}
// or default starting point
else{
    if ( $allowNoStartingPoint ) {
       $basedir=$defaultdir;
    }
    else{
       echo "<br><br><br><br><p>Pas d'accès...</p>";
       exit(1);
    }
}

if(!is_dir($basedir)){
    echo "<br><br><br><br><p>Mauvais lien ...</p>";
    exit(1);
    $basedir=$defaultdir;
}


$basedir=realpath($basedir);

//////////////////////////////
//max level up directory
//////////////////////////////
if($allowLevelUp){
    $rootdir=realpath($defaultrootdir);
}
else{
    $rootdir=$basedir;
}

if(!is_subdir($rootdir,$basedir)){
    echo "<br><br><br><br><p>Pas d'accès, hors du répertoire racine...</p>";
    $basedir=$defaultdir;
}




//////////////////////////////
// thumb size
//////////////////////////////
if(isset($_GET['ts'])){
    $thumbsize=$_GET['ts'];
}

if(isset($_GET['tsd'])){
    $thumbsizedir=$_GET['tsd'];
}

//////////////////////////////
// lightbox size
//////////////////////////////
if(isset($_GET['lbs'])){
    $lightboxsize=$_GET['lbs'];
}

?>
