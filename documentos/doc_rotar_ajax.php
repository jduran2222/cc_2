<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

$id_documento=$_GET["id_documento"]  ;
$path_archivo=isset($_GET["path_archivo"])? $_GET["path_archivo"] : Dfirst('path_archivo', 'Documentos', "id_documento=$id_documento AND $where_c_coste ") ;
$grados=$_GET["grados"] ;


require_once("../../conexion.php");
require_once("../include/funciones.php");
 
//      $sql= "DELETE FROM `Documentos`  WHERE id_documento=$id_documento AND $where_c_coste "  ;     // ejecuto DELETE
 
//$array_image_ext=['pdf','jpg','jpeg','bmp','gif','tif','tiff','png','pic','ico']   ;
//$is_picture=in_array(strtolower($imageFileType),$array_image_ext) ;
 
 
 
$target_file= $path_archivo ;
$im = new Imagick(); 
//$im->setResolution(150,150);

$im->readimage($path_archivo); 
//$im->readimage($target_file.".jpg"); 

//echo "path:".$path_archivo  ;
//echo "<br>numero imagenes:".$im->count()  ;
//echo "<br>filename:".$im->getImageFilename()   ;

if ($im->rotateImage('none',$grados)) 
{
unlink($path_archivo)  ;


$im->writeImage($target_file);   

unlink($path_archivo. "_large.jpg")  ;
unlink($path_archivo. "_medium.jpg") ;

$im->writeImage("{$target_file}_large.jpg");     // sacamos una foto en tres tamaños
$im->thumbnailImage(320, 320, true);
$im->writeImage("{$target_file}_medium.jpg"); 
//		$im->thumbnailImage(160, 160, true);             // anulamos el _small
//		$im->writeImage("{$target_file}_small.jpg"); 

//$result_UPDATE=$Conn->query("UPDATE `Documentos` SET `path_archivo` = $target_file WHERE $where_c_coste AND id_documento=$id_documento" );

echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
else
{
 echo "ERROR AL ROTAR IMAGEN"   ;
}    


$im->clear(); 
$im->destroy();





?>