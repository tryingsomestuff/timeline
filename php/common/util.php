<?php
require("php/common/config.php");

function sortDir($a,$b){
    //$s1=stat($a);
    //$s2=stat($b);
    if($a<$b) return 1;
    return -1;
}

function sortPic($a,$b){
    $c1 = cameraUsed($a);
    $c2 = cameraUsed($b);

    if ( $c1['date'] < $c2['date'] ){
        return 1;
    }
    elseif ( $c1['date'] ==  $c2['date'] ){
        if ( $c1['time'] < $c2['time'] ) return 1;
    }
    else{
       return -1;
    }
}

// check whether $sub is a subdir of $parent
function is_subdir($parent,$sub){
    $parent=rtrim($parent,DIRECTORY_SEPARATOR );
    $sub=rtrim($sub,DIRECTORY_SEPARATOR );
    $parent=explode(DIRECTORY_SEPARATOR ,$parent);
    $sub=explode(DIRECTORY_SEPARATOR ,$sub);
    for($i=0;$i<count($parent);$i++){
        if($parent[$i]!=$sub[$i]){
            return false;
        }
    }
    return true;
}

// allowed images extension
$ext = array("jpg", "png", "jpeg", "gif", "JPG", "PNG", "GIF", "JPEG");

// get first image of a collection (directory) : recursivly if needed
function getFirstImage($dirname) {
    global $ext;
    $imageName = false;
    if($handle = opendir($dirname)){
        while(false !== ($file = readdir($handle)))		{
            if ($file == '.' || $file == '..'){
                continue;
            }
            if ( is_dir($dirname . DIRECTORY_SEPARATOR . $file) ){
                $imageName=getFirstImage($dirname . DIRECTORY_SEPARATOR  . $file);
                closedir($handle);
                return($imageName);
            }
            $lastdot = strrpos($file, '.');
            $extension = substr($file, $lastdot + 1);
            if ($file[0] != '.' && in_array($extension, $ext)) break;
        }
        $imageName = $file;
        closedir($handle);
    }
    return($dirname . "/" . $imageName);
}

// get random image in a collection (directory) : recursivly if needed
function getRandomImage($dirname) {
    global $ext;
    $imageName = false;
    if($handle = opendir($dirname)){
        $files=array();
        while(false !== ($file = readdir($handle))){
            if ($file == '.' || $file == '..' || $file == 'thumbs'){
                continue;
            }
            if ( is_dir($dirname . "/" . $file) ){
                $imageName=getRandomImage($dirname . DIRECTORY_SEPARATOR . $file);
                $files[] = $imageName;
            }
            else{
                $lastdot = strrpos($file, '.');
                $extension = substr($file, $lastdot + 1);
                if ($file[0] != '.' && in_array($extension, $ext)) $files[] = $dirname . DIRECTORY_SEPARATOR . $file;
            }
        }
        if ( ! empty($files) ){
           $imageName = $files[array_rand($files)];
        }
        closedir($handle);
    }
    return($imageName);
}

// scan directory
function listdir($dir='.', $rec = false) {
    if (!is_dir($dir)) {
        return false;
    }
    $files = array();
    listdiraux($dir, $files, $rec);
    return $files;
}

// helper for scanning directory
function listdiraux($dir, &$files, $rec=false) {
    global $ext;
    $handle = opendir($dir);
    while (($file = readdir($handle)) !== false) {
        if ($file == '.' || $file == '..'){
            continue;
        }
        $filepath = $dir == '.' ? $file : $dir . DIRECTORY_SEPARATOR . $file;
        if (is_link($filepath))
            continue;
        if (is_file($filepath)){
            $lastdot = strrpos($file, '.');
            $extension = substr($file, $lastdot + 1);
            if ( ! in_array($extension,$ext)){
                continue;
            }
            $files[] = $filepath;
        }
        else if (is_dir($filepath)){
            $files[] = $filepath;
            if ( $rec ){
                // next if for recursive scanning ...
                listdiraux($filepath, $files, $rec);
            }
        }
    }
    closedir($handle);
}

// check exif data
function cameraUsed($imagePath) {

    // Check if the variable is set and if the file itself exists before continuing
    if ( (isset($imagePath)) and (file_exists($imagePath))) {
        // There are 2 arrays which contains the information we are after, so it's easier to state them both
        $exif_ifd0 = read_exif_data($imagePath ,'IFD0' ,0);
        $exif_exif = read_exif_data($imagePath ,'EXIF' ,0);

        //error control
        $notFound = "Unavailable";
        // Make
        if (@array_key_exists('Make', $exif_ifd0)) {
            $camMake = $exif_ifd0['Make'];
        } else { $camMake = $notFound; }
        // Model
        if (@array_key_exists('Model', $exif_ifd0)) {
            $camModel = $exif_ifd0['Model'];
        } else { $camModel = $notFound; }
        // Exposure
        if (@array_key_exists('ExposureTime', $exif_ifd0)) {
            $camExposure = $exif_ifd0['ExposureTime'];
        } else { $camExposure = $notFound; }
        // Aperture
        if (@array_key_exists('ApertureFNumber', $exif_ifd0['COMPUTED'])) {
            $camAperture = $exif_ifd0['COMPUTED']['ApertureFNumber'];
        } else { $camAperture = $notFound; }
        // Date
        //if (@array_key_exists('DateTime', $exif_ifd0)) {
        if (@array_key_exists('DateTimeOriginal', $exif_ifd0)) {
            $camDateTime = $exif_ifd0['DateTimeOriginal'];
            list($camDate,$camTime) = explode(' ', $camDateTime);
            $camDate=str_replace(":","/",$camDate);
        } else { $camDate = $notFound; $camTime=$notFound; }
        // ISO
        if (@array_key_exists('ISOSpeedRatings',$exif_exif)) {
            $camIso = $exif_exif['ISOSpeedRatings'];
        } else { $camIso = $notFound; }
        // Lens
        $ret = array();
        $ret['make'] = $camMake;
        $ret['model'] = $camModel;
        $ret['exposure'] = $camExposure;
        $ret['aperture'] = $camAperture;
        $ret['date'] = $camDate;
        $ret['time'] = $camTime;
        $ret['iso'] = $camIso;
        //$ret['lens'] = shell_exec('exiv2 -Ptn ' . $imagePath . ' | grep LensType | sed "s/LensType[ ]*//" 2>&1');
        return $ret;
    }
    else {
        return false;
    }
}

function safe_b64encode($string) {
    $data = base64_encode($string);
    $data = str_replace(array('+','/','='),array('-','_',''),$data);
    return $data;
}

function safe_b64decode($string) {
    $data = str_replace(array('-','_'),array('+','/'),$string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
}

function encode($value){
    if(!$value){return false;}
    $text = $value;
    return trim(safe_b64encode($text));
}

function decode($value){
    if(!$value){return false;}
    $crypttext = safe_b64decode($value);
    return trim($crypttext);
}

function getImage(&$dirs,&$pics, $rec = false){
    global $basedir;

	// list of files and dirs in current directory
	$files = listdir($basedir,$rec);
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
	// sort be date (exif info for pics)
	usort($dirs,'sortDir');
	usort($pics,'sortPic');
}

function dirloop($dirs){
   // show dirs
   for ( $i=0 ; $i < count($dirs); ++$i){
     $f=$dirs[$i];
     // do not disply thumbs dir of course !
     if ( basename($f) == "thumbs" ) continue;
     echo generate_html_dir($f);
   }
}

function fileloop($pics){
   // show pics
   for ( $i=0 ; $i < count($pics); ++$i){
     $f=$pics[$i];
     echo generate_html_file($f);
   }
}

function slideshowloop($pics){
   // build slideshow
   for ( $i=0 ; $i < count($pics); ++$i){
     $f=$pics[$i];
     echo generate_html_slideshow($f);
   }
}

function fullUrlOption($dir){

    global $encrypted;
    global $thumbsize;
    global $thumbsizedir;
    global $allowLevelUp;
    global $lightboxsize;
    global $allowNoStartingPoint;
    global $encryptedDefault;
    global $thumbsizeDefault;
    global $thumbsizedirDefault;
    global $allowLevelUpDefault;
    global $lightboxsizeDefault;
    global $allowNoStartingPointDefault;

    if($encrypted){
        $dir=encode($dir);
    }
    $dir = "?d=" . $dir;

    if ( $encrypted != $encryptedDefault ){
       if($encrypted){
           $dir .= '&crt=1';
       }
       else{
           $dir .= '&crt=0';
       }
    }
    if ( $thumbsize != $thumbsizeDefault ){
       $dir .= "&ts=" . $thumbsize;
    }
    if ( $thumbsizedir != $thumbsizedirDefault ){
       $dir .= "&tsd=" . $thumbsizedir;
    }
    if ( $lightboxsize != $lightboxsizeDefault ){
       $dir .= "&lbs=" . $lightboxsize;
    }
    if ( $allowLevelUp != $allowLevelUpDefault ){
       $dir .= "&alu=" . (int) $allowLevelUp;
    }
    if ( $allowNoStartingPoint != $allowNoStartingPointDefault ){
       $dir .= "&ansp=" . (int) $allowNoStartingPoint;
    }
    return $dir;
}

?>
