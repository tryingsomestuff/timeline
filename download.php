<?php
ignore_user_abort(true);
set_time_limit(0);

$dl_file = $_GET['download_file'];
$dl_file = filter_var($dl_file, FILTER_SANITIZE_URL);
$filename = $dl_file;

$size = @getimagesize($filename);
$fp = @fopen($filename, "rb");
if ($size && $fp){
	header("Content-type: {$size['mime']}");
	header("Content-Length: " . filesize($filename));
	header("Content-Disposition: attachment; filename=$filename");
	header('Content-Transfer-Encoding: binary');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	fpassthru($fp);
	exit;
}
header("HTTP/1.0 404 Not Found");
?>
