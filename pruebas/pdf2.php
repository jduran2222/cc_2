<?php
$file = 'Rev.pdf';
//$filepath = "doc/" . $file;
$filepath =  $file;
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream; charset=utf-8');
header('Content-Disposition: attachment; filename='.basename($filepath));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($filepath));

readfile($filepath);
exit;
?>