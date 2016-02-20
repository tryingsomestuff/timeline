<?php

function sortDir($a,$b){
   //$s1=stat($a);
   //$s2=stat($b);
   if($a<$b) return 1;
   return -1;
}

function sortPic($a,$b){
    $c1 = cameraUsed($a);
    $c2 = cameraUsed($b);
    if ( $c1['date'] < $c2['date'] ) return 1;
    return -1;
}

// check whether $sub is a subdir of $parent
function is_subdir($parent,$sub){
	$parent=rtrim($parent,'/');
	$sub=rtrim($sub,'/');
	$parent=explode('/',$parent);
	$sub=explode('/',$sub);
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
			if ( is_dir($dirname . "/" . $file) ){
				$imageName=getFirstImage($dirname . "/" . $file);
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
				$imageName=getRandomImage($dirname . "/" . $file);
				$files[] = $imageName;
			}
			else{
				$lastdot = strrpos($file, '.');
				$extension = substr($file, $lastdot + 1);
				if ($file[0] != '.' && in_array($extension, $ext)) $files[] = $dirname . "/" . $file;
			}
		}
		$imageName = $files[array_rand($files)];
		closedir($handle);
	}
	return($imageName);
}

// scan directory
function listdir($dir='.') {
	if (!is_dir($dir)) {
		return false;
	}
	$files = array();
	listdiraux($dir, $files);
	return $files;
}

// helper for scanning directory
function listdiraux($dir, &$files) {
	global $ext;
	$handle = opendir($dir);
	while (($file = readdir($handle)) !== false) {
		if ($file == '.' || $file == '..'){
			continue;
		}
		$filepath = $dir == '.' ? $file : $dir . '/' . $file;
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
			// next if for recursive scanning ...
			//listdiraux($filepath, $files);
		}
	}
	closedir($handle);
}

// check exif data
function cameraUsed($imagePath) {

	// Check if the variable is set and if the file itself exists before continuing
	if ((isset($imagePath)) and (file_exists($imagePath))) {
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
			list($camDate,$camTime) = split(' ', $camDateTime);
			$camDate=str_replace(":","/",$camDate);
		} else { $camDate = $notFound; }
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
		$ret['iso'] = $camIso;
        //$ret['lens'] = shell_exec('exiv2 -Ptn ' . $imagePath . ' | grep LensType | sed "s/LensType[ ]*//" 2>&1');
        return $ret;
	}
	else {
		return false;
	}
}

?>
