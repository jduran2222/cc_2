<?php
require_once("../include/session.php");
?>
<?php


$id_c_coste= $_SESSION["id_c_coste"] ;
$tipo_entidad='fra_prov' ;
$id_subdir=$_POST["id_subdir"]  ;
$id_entidad=$_POST["id_entidad"]  ;

// Defino directorios, compruebo existencia, si FALSO ->  creo los dirs
$target_c_coste="../../uploads/{$id_c_coste}/"  ;
if (!file_exists($target_c_coste) )
	{  mkdir($target_c_coste) ;   }	

$target_tipo_entidad = $target_c_coste . $tipo_entidad . "/" ; 
if (!file_exists($target_tipo_entidad) )
	{  mkdir($target_tipo_entidad) ;   }	

if ($id_subdir<>"")               // si $id_subdir no es vacío se organiza en subcarpetas
    {
	$target_dir = $target_tipo_entidad . $id_subdir . "/" ; 
    if (!file_exists($target_dir) )
	    {  
		   mkdir($target_dir) ;  
     	}	
     }
  
   else
     {   
	   $target_dir = $target_tipo_entidad ;
     }
	
	
$filename = $id_entidad . basename($_FILES["fileToUpload"]["name"])  ;
$target_file = $target_dir . $filename ;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// nombro al documento por su descripcion o en su defecto por el nombre del fichero
$documento=(isset($_POST["documento"])) ? $_POST["documento"] : basename($_FILES["fileToUpload"]["name"])  ;
$observaciones= isset($_POST["observaciones"]) ? $_POST["observaciones"] : ""  ;
                                                
// Check if file already exists
$reemplazar=isset($_POST["reemplazar"])  ;
$reemplazado = 0 ;
if (file_exists($target_file))
 {
	if($reemplazar)
	{    
    echo "Archivo existente, se procede a reemplazar";
    $uploadOk = 1;
	unlink($target_file) ; 
	$reemplazado = 1 ;
     }
	else
	{
	 echo "Archivo existente, no se ha reemplazado";
    $uploadOk = 0;	
	}
 }
// Check file size
$limite=1024*1024*20  ;
$size = $_FILES["fileToUpload"]["size"]  ;
if ( $size > $limite)    // LIMITE TAMAÑO 20 MB 
{
    echo "Lo siento, el archivo supera el límite de $limite bytes";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType == "exe" OR $imageFileType == "php" OR $imageFileType == "cgi"
OR $imageFileType == "htm" OR $imageFileType == "bin" ) {
    echo "Lo siento, extensión de archivo no autorizada";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Existen errores, el archivo no se ha subido a la nube";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "El archivo ". basename( $_FILES["fileToUpload"]["name"]). " ha sido subido.";
		
		// creación de THUMBAIL
		$im = new Imagick();

        $im->setResolution(150,150);
        $im->readimage($target_file . "[0]");         // $im->readimage('document.pdf[0]'); 
        $im->setImageFormat('jpeg');    
		// $im->setImageFormat('png');    
		$im=$im->flattenImages();             // quito fondo transparente, evita fondo negro en pdf
                
		$im=$im->normalizeImage();             // normalizo los colores para mejorar contraste
		$im=$im->contrastImage(1);             // mejoro el contraste
		$im=$im->unsharpMaskImage(0);             // mejoro el contraste
                
		$im->setImageCompression(imagick::COMPRESSION_JPEG );  // comprimimos el jpg
        $im->setimagecompressionquality( 20 );
      
		
		$im->thumbnailImage(2000,2000 , true);
       // $im->writeImage("{$target_file}_large.png"); 
		$im->writeImage("{$target_file}_large.jpg");     // sacamos una foto en tres tamaños
		$im->thumbnailImage(320, 320, true);
		$im->writeImage("{$target_file}_medium.jpg"); 
//		$im->thumbnailImage(160, 160, true);
//		$im->writeImage("{$target_file}_small.jpg"); 
		
        $im->clear(); 
        $im->destroy();
		
	    // FIN THUMBAIL
		
		// registramos el documento en la bbdd
		require_once("../../conexion.php"); 
		
		if ($reemplazado)
		  {
			$result=$Conn->query("UPDATE `Documentos` SET `documento` = $documento,  `tamano` = '$size', `Observaciones` = '$observaciones' WHERE ìd_c_coste`= $id_c_coste AND `tipo_entidad`=$tipo_entidad AND `id_entidad`=$id_entidad AND  `Documentos`.`nombre_archivo` = $filename;" );

		  }
		else
          {
				$result=$Conn->query("INSERT INTO `Documentos` (`id_c_coste`, `tipo_entidad`, `id_entidad`, `documento`, `nombre_archivo`,   `path_archivo`, `tamano`, `Observaciones`) VALUES ( '{$id_c_coste}', '$tipo_entidad', '$id_entidad', '$documento', '$filename','$target_file', $size, '$observaciones');" );
           }
		
		
		
		
    } else {
        echo "Existen errores al mover el archivo, el archivo no se ha subido a la nube";
    }
}
?>