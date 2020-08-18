<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Migración';

//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');

?>

        <!-- Contenido principal 
        <div class="container-fluid bg-light">
            <div class="row">
                <!--****************** ESPACIO LATERAL  *****************
                <div class="col-12 col-md-4 col-lg-3"></div>
                <!--****************** ESPACIO LATERAL  *****************

                <!--****************** BUSQUEDA GLOBAL  *****************
                <!--<div class="col-12 col-md-4 col-lg-9">-->


<?php 


$id_c_coste=$_SESSION['id_c_coste'] ;

//$id_aval=$_GET["id_aval"];

 //require("../proveedores/proveedores_menutop_r.php");

 //echo "<pre>";
 $result=$Conn->query("SELECT * FROM Fras_Prov_View WHERE $where_c_coste  ");
// $rs = $result->fetch_array(MYSQLI_ASSOC) ;

$dir="../fras_prov/" ;
$a=scandir($dir) ;

echo "NUM. FICHEROS:" . count($a) ;
//print_r($a);

$a_file=[] ;
foreach ($a as $clave => $valor)
     {
    
     $a_file[substr($valor,0,14)] = $valor ;
    
     }
      
     
    
 $c=0;
while($rs = $result->fetch_array(MYSQLI_ASSOC))               // tabla de valores
{
//    echo "Fra_prov_{$rs["ID_FRA_PROV"]}<BR>"  ;
    if (!$rs["PDF"])
        
    {
        set_time_limit(30) ;
//        if( $a_index = array_search( "FRA_prov {$rs["ID_FRA_PROV"]}" , $a  ) ) 
        $clave_file="FRA_prov {$rs["ID_FRA_PROV"]}"  ;
        
        if( isset($a_file[ $clave_file ]) ) 
        {
            echo "<br>COINCIDE:" . $a_file[ $clave_file ] ;
            $c++ ;
            
            $tipo_entidad='fra_prov' ;
            $id_entidad=$rs["ID_FRA_PROV"] ;
            $id_subdir=$rs["ID_PROVEEDORES"] ;
            $path_archivo1=$dir . $a_file[ $clave_file ]  ;
          
            
            /////////////////////////////////////
            
            
            
            
//            $id_c_coste= $_SESSION["id_c_coste"] ;
//$tipo_entidad=$_POST["tipo_entidad"]  ;
//$id_subdir=$_POST["id_subdir"]  ;
//$id_entidad=$_POST["id_entidad"]  ;

//$file=$_FILES["fileToUpload"] ;

$documento='factura proveedor'  ;
$observaciones= ""  ;
$reemplazar=0  ;



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
	
	
$filename = $id_entidad ."_". basename($path_archivo1)  ;
$target_file = $target_dir . $filename ;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// nombro al documento por su descripcion o en su defecto por el nombre del fichero

                                                
// Check if file already exists

$reemplazado = 0 ;
if (file_exists($target_file))
 {
	if($reemplazar)
	{    
    echo "<br>Archivo existente, se procede a reemplazar";
    $uploadOk = 1;
	unlink($target_file) ; 
	$reemplazado = 1 ;
     }
	else
	{
	 echo "<br>Archivo existente, no se ha reemplazado";
    $uploadOk = 0;	
	}
 }
// Check file size
$limite=1024*1024*20  ;
$size = filesize( $path_archivo1 ) ;
if ( $size > $limite)    // LIMITE TAMAÑO 20 MB 
{
    echo "<br>Lo siento, el archivo supera el límite de $limite bytes";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType == "exe" OR $imageFileType == "php" OR $imageFileType == "cgi"
OR $imageFileType == "htm" OR $imageFileType == "bin" ) {
    echo "<br>Lo siento, extensión de archivo no autorizada";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "<br>Existen errores, el archivo no se ha subido a la nube";
// if everything is ok, try to upload file
} else {
    if (copy($path_archivo1, $target_file)) {
        echo "<br>El archivo ". basename( $path_archivo1). " ha sido copiado.";
		
		// creación de THUMBAIL
		$im = new Imagick();

        $im->setResolution(150,150);
        $im->readimage($target_file . "[0]");         // $im->readimage('document.pdf[0]'); 
        $im->setImageFormat('jpeg');    
		// $im->setImageFormat('png');    
		$im=$im->flattenImages();             // quito fondo transparente, evita fondo negro en pdf
		
		$im->setImageCompression(imagick::COMPRESSION_JPEG );  // comprimimos el jpg
        $im->setimagecompressionquality( 20 );
      
		
		$im->thumbnailImage(2000,2000 , true);
       // $im->writeImage("{$target_file}_large.png"); 
		$im->writeImage("{$target_file}_large.jpg");     // sacamos una foto en tres tamaños
		$im->thumbnailImage(320, 320, true);
		$im->writeImage("{$target_file}_medium.jpg"); 
		$im->thumbnailImage(160, 160, true);
		$im->writeImage("{$target_file}_small.jpg"); 
		
        $im->clear(); 
        $im->destroy();
		
	    // FIN THUMBAIL
		
		// registramos el documento en la bbdd
		require_once("../../conexion.php"); 
		
		if ($reemplazado)
		  {
			$result_UPDATE=$Conn->query("UPDATE `Documentos` SET `documento` = $documento,  `tamano` = '$size', `Observaciones` = '$observaciones' WHERE ìd_c_coste`= $id_c_coste AND `tipo_entidad`=$tipo_entidad AND `id_entidad`=$id_entidad AND  `Documentos`.`nombre_archivo` = $filename;" );

		  }
		else
          {
				$result_INSERT=$Conn->query("INSERT INTO `Documentos` (`id_c_coste`, `tipo_entidad`, `id_entidad`, `documento`, `nombre_archivo`,   `path_archivo`, `tamano`, `Observaciones`) VALUES ( '{$id_c_coste}', '$tipo_entidad', '$id_entidad', '$documento', '$filename','$target_file', $size, '$observaciones');" );
           }
		
	echo "<br>ARCHIVO $path_archivo1 REGISTRADO  EXITOSAMENTE<BR>";	
		
		
    } else {
        echo "<br>Existen errores al mover el archivo, el archivo no se ha subido a la nube";
    }
}
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
           ///////////////////////////// fin upload ///////////// 
            
            
        }       
                
//        echo "FRA_prov {$rs["path_archivo"]}   "  ;
//        echo "FRA_prov {$rs["ID_FRA_PROV"]}<BR>"  ;
//        
//        if (file_exists( $dir . $a[$a_index] )) {
//            echo "El fichero  existe<br>";
//          }
//          else
//              {
//           echo "El fichero  NO existe";
//             }
        
    }
    else
    {
//        echo "ELSE FRA_prov {$rs["path_archivo"]}   "  ;
//        echo "ELSE FRA_prov {$rs["ID_FRA_PROV"]}<BR>"  ;
    }    
     
    
}

  
echo "<br><br>CONTADOR = $c"  ;
        

$Conn->close();

?>
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');

