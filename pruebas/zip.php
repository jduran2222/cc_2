<?php
 
$zip = new ZipArchive();
 
$filename = 'test4.zip';
 
$files=array_diff(scandir("uploads"), array('..', '.'));

if($zip->open($filename,ZIPARCHIVE::CREATE)===true) {
        $zip->addFile('zip.php');
        $zip->addFile('upload.php');
	    foreach($files as $i => $file) {
		$zip->addFile("uploads/$file");
		
		}
        $zip->close();
        echo 'Creado '.$filename;
	//   DOWNLOAD FILE
	 header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: binary");
    readfile($filename);   // download file
	
	unlink($filename);     // borro el fichero.zip del servidor
	
	
}
else {
        echo 'Error creando '.$filename;
}
 
?>