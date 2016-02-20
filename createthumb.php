<?php
$filename=$_GET['filename'];
if ($_GET['size'] == "") $_GET['size'] = 120; // default size


$thumb_path=dirname($filename) . "/thumbs/" . $_GET['size'] . "/" . basename($filename);

if (is_file($thumb_path)){
   if (preg_match("/\.jpg$|\.jpeg$/i", $filename)) header('Content-type: image/jpeg');
   if (preg_match("/\.gif$/i"        , $filename)) header('Content-type: image/gif');
   if (preg_match("/\.png$/i"        , $filename)) header('Content-type: image/png');
   readfile($thumb_path);
}

// Display error image if file isn't found
if (!is_file($filename)) {
	header('Content-type: image/jpeg');
	$errorimage = ImageCreateFromJPEG('img/questionmark.jpg');
	ImageJPEG($errorimage,null,90);
}

// Display error image if file exists, but can't be opened
if (substr(decoct(fileperms($filename)), -1, strlen(fileperms($filename))) < 4 OR substr(decoct(fileperms($filename)), -3,1) < 4) {
	header('Content-type: image/jpeg');
	$errorimage = ImageCreateFromJPEG('img/cannotopen.jpg');
	ImageJPEG($errorimage,null,90);
}

// Define variables
$target = "";
$xoord = 0;
$yoord = 0;

$xoffset = 0;
$yoffset = 0;


$imgsize = GetImageSize($filename);
$width = $imgsize[0];
$height = $imgsize[1];

if ($width > $height) { // If the width is greater than the height its a horizontal picture
	$outw=$_GET['size'];
	$outh=$_GET['size']*$height/$width;
	$yoffset = ($outw-$outh)/2;
} 
else {
	$outw=$_GET['size']*$width/$height;
	$outh=$_GET['size'];
	$xoffset = ($outh-$outw)/2;
}

//set background color
$target = ImageCreatetruecolor($_GET['size'],$_GET['size']);
$bkground = imagecolorallocate($target, 255, 255, 255);
imagefill($target,0,0,$bkground);

if (preg_match("/\.jpg$/i", $filename)) $source = ImageCreateFromJPEG($filename);
if (preg_match("/\.gif$/i", $filename)) $source = ImageCreateFromGIF($filename);
if (preg_match("/\.png$/i", $filename)) $source = ImageCreateFromPNG($filename);

imagecopyresampled($target,$source,$xoffset,$yoffset,$xoord,$yoord,$outw,$outh,$width,$height);
imagedestroy($source);

// Rotate JPG pictures
if (preg_match("/\.jpg$|\.jpeg$/i", $filename)) {
	if (function_exists('exif_read_data') && function_exists('imagerotate')) {
		$exif = exif_read_data($filename);
                $exif_ifd0 = read_exif_data($imagePath ,'IFD0' ,0);
		$ort = $exif['Orientation'];
		$degrees = 0;
		switch($ort){
			case 6: // 90 rotate right
				$degrees = 270;
				break;
			case 8:    // 90 rotate left
				$degrees = 90;
				break;
		}
		if ($degrees != 0)	$target = imagerotate($target, $degrees, 0);
	}
}

if ( is_dir(dirname($thumb_path)) || mkdir(dirname($thumb_path),0755,true)){
   if (preg_match("/\.jpg$/i", $filename)) ImageJPEG($target,$thumb_path,70);
   if (preg_match("/\.gif$/i", $filename)) ImageGIF($target,$thumb_path,70);
   if (preg_match("/\.png$/i", $filename)) ImageJPEG($target,$thumb_path,70); // Using ImageJPEG on purpose
}

if (preg_match("/\.jpg$|\.jpeg$/i", $filename)) header('Content-type: image/jpeg');
if (preg_match("/\.gif$/i"        , $filename)) header('Content-type: image/gif');
if (preg_match("/\.png$/i"        , $filename)) header('Content-type: image/png');

if (preg_match("/\.jpg$/i", $filename)) ImageJPEG($target,null,70);
if (preg_match("/\.gif$/i", $filename)) ImageGIF ($target,null,70);
if (preg_match("/\.png$/i", $filename)) ImageJPEG($target,null,70); // Using ImageJPEG on purpose

imagedestroy($target);

?>
