<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




function anadir_estudio_XML($file_array)
{

    
    if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }
    $where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;


// Creo ficha Nueva

//  $titulo2="ESTUDIO (nueva)";
//  $nombre=$_POST["NOMBRE"];
//  $observaciones=$_POST["Observaciones"];
  
  
 // ACTUAMOS VIA XML DE la plataforma contrataciondelestado.es
    
//  echo $_FILES["xml_file"]["name"];
  $target_dir = "../../uploads/tmp";
 $target_file = $target_dir .strtotime("now"). basename($file_array["name"]);

 move_uploaded_file($file_array["tmp_name"], $target_file);

// echo "$target_file<BR>";
//        $xml=simplexml_load_file($target_file) or die("Error: No se puede crear Objeto (juand)");
        
      
//         $xml= simplexml_load_file($target_file);        // funcion original de PHP 
//        $xml= simplexml_load_string_nons($target_file);       // funcin que evita los ns     simplexml_load_string_nons
      $target_text= file_get_contents($target_file) ;
//    }    
   // EMPEZAMOS A IMPORTAR XML 
    
    $xml= simplexml_load_string(str_replace("c:","c_",  $target_text));       // funcin que evita los ns     simplexml_load_string_nons
         
//          $xml= simplexml_load_file("https://contrataciondelestado.es/wps/wcm/connect/PLACE_es/Site/area/docAccCmpnt?srv=cmpnt&cmpntname=GetDocumentsById&source=library&DocumentIdParam=0b7d00fa-8fc3-4ee2-ad3f-8023f9ea7ede");
//        $xml=simplexml_load_file('https://www.w3schools.com/xml/simplexsl.xml') or die("Error: No se puede crear Objeto (juand)");
          
     // DEBUG
//        echo "<pre>";
//        print_r($xml);   
//        echo "</pre>";
        
        
//        foreach(libxml_get_errors() as $error) {
//                echo "\t", $error->message;
//                echo "error juand";
//              }
     
        
        // extraemos datos
          
//        $f_presentacion=$xml->cac_TenderingProcess->cac_DocumentAvailabilityPeriod->cbc_EndDate ;
        $f_presentacion=$xml->cac_TenderingProcess->cac_TenderSubmissionDeadlinePeriod->cbc_EndDate ;
//        $observaciones=$xml->cac_TendererQualificationRequest->cac_RequiredBusinessClassificationScheme->cac_ClassificationCategory->cbc_CodeValue ;
       
        $nombre_completo=htmlspecialchars($xml->cac_ProcurementProject->cbc_Name) ;
        $presupuesto=$xml->cac_ProcurementProject->cac_BudgetAmount->cbc_TaxExclusiveAmount ;
//        $observaciones.= $xml->cac_TenderingTerm->cac_TenderRecipientParty->cac_PartyName->cbc_Name ;
        $observaciones= '' ;
        $xml_electronica=$xml->cac_TenderingProcess->cbc_SubmissionMethodCode ;
        $observaciones.= $xml_electronica==1 ? ' ELECTRONICA ' :'MANUAL(PAPEL)' ;

        $organismo=$xml->cac_ContractingParty->cac_Party->cac_PartyName->cbc_Name ;

        $URL_licitacion=$xml->cac_TenderingProcess->cac_AdditionalDocumentReference->cac_Attachment->cac_ExternalReference->cbc_URI ;
        
         $nombre=  "es-".substr($nombre_completo, 0,40);
        
//        echo $f_presentacion ;
//        echo '<br>' ;
//        echo $nombre_completo ;
//        echo '<br>' ;
//        echo $presupuesto ;
//        echo '<br>' ;
  
    
 
// }
//else         // lo metemos manualmente
//{
//    echo "NO HAY FILES"; 
//  $f_presentacion=$_POST["F_Presentacion"];
//  $presupuesto=$_POST["PRESUPUESTO"];
//  $nombre_completo=$_POST["nombre_completo"];
//  $presupuesto=dbNumero($presupuesto)  ;
// }
 
// YA HEMOS DEFINIDO LAS VARIABLES, CREAMOS EL ESTUDIO
//Calculo el numero de Estudio mayor
  
//  $result=$Conn->query("SELECT MAX(numero) AS max_numero FROM `Estudios_de_Obra` WHERE $where_c_coste");
//  $rs = $result->fetch_array();
  $numero=1 + Dfirst("MAX(numero)", "Estudios_de_Obra", $where_c_coste) ;
//  echo "NUMERO:".$numero;
  //$fecha = date_create_from_format('j/m/Y', $f_presentacion);   // con el input type='date' ya viene al formato mysql
  //echo $fecha->format('Y-m-d');
  //$f_presentacion2=$fecha->format('Y-m-d');
  
  $sql="INSERT INTO `Estudios_de_Obra` (id_c_coste,URL_licitacion, NUMERO,NOMBRE, `PLAZO ENTREGA`,`presupuesto tipo`,provincia,`Nombre completo`,observaciones,Organismo, user)"
     . " VALUES ({$_SESSION['id_c_coste']} ,'$URL_licitacion', '$numero','$nombre','$f_presentacion','$presupuesto','provincia','$nombre_completo','$observaciones','$organismo','web')";


  if ($result=$Conn->query($sql))
  {      $return=1;  }
  else
      {$return=0;}
      
//
//if(!$f_presentacion)
//    {$f_presentacion=date("Y-m-d");} 
//    else
//     {$f_presentacion=substr($f_presentacion,0,10);}     
//
//
//echo  $target_text; 
//    
    
    
return $return ;
    
}


///////////////////////////////////////////////////////////////////////////////////////////


// FUNCTION ---------------

function simplexml_load_string_nons($xml, $sxclass = 'SimpleXMLElement', $nsattr = false, $flags = null){
	// Validate arguments first
	if(!is_string($sxclass) or empty($sxclass) or !class_exists($sxclass)){
		trigger_error('$sxclass must be a SimpleXMLElement or a derived class.', E_USER_WARNING);
		return false;
	}
	if(!is_string($xml) or empty($xml)){
		trigger_error('$xml must be a non-empty string.', E_USER_WARNING);
		return false;
	}
	// Load XML if URL is provided as XML
	if(preg_match('~^https?://[^\s]+$~i', $xml) || file_exists($xml)){
		$xml = file_get_contents($xml);
	}
	// Let's drop namespace definitions
	if(stripos($xml, 'xmlns=') !== false){
		$xml = preg_replace('~[\s]+xmlns=[\'"].+?[\'"]~i', null, $xml);
	}
	// I know this looks kind of funny but it changes namespaced attributes
	if(preg_match_all('~xmlns:([a-z0-9]+)=~i', $xml, $matches)){
		foreach(($namespaces = array_unique($matches[1])) as $namespace){
			$escaped_namespace = preg_quote($namespace, '~');
			$xml = preg_replace('~[\s]xmlns:'.$escaped_namespace.'=[\'].+?[\']~i', null, $xml);
			$xml = preg_replace('~[\s]xmlns:'.$escaped_namespace.'=["].+?["]~i', null, $xml);
			$xml = preg_replace('~([\'"\s])'.$escaped_namespace.':~i', '$1'.$namespace.'_', $xml);
		}
	}
	// Let's change <namespace:tag to <namespace_tag ns="namespace"
	$regexfrom = sprintf('~<([a-z0-9]+):%s~is', !empty($nsattr) ? '([a-z0-9]+)' : null);
	$regexto = strlen($nsattr) ? '<$1_$2 '.$nsattr.'="$1"' : '<$1_';
	$xml = preg_replace($regexfrom, $regexto, $xml);
	// Let's change </namespace:tag> to </namespace_tag>
	$xml = preg_replace('~</([a-z0-9]+):~is', '</$1_', $xml);
	// Default flags I use
	if(empty($flags)) $flags = LIBXML_COMPACT | LIBXML_NOBLANKS | LIBXML_NOCDATA;
	// Now load and return (namespaceless)
	return $xml = simplexml_load_string($xml, $sxclass, $flags);
}

function file_get_contents_curl( $url ) {

  $ch = curl_init();

  curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
  curl_setopt( $ch, CURLOPT_HEADER, 0 );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt( $ch, CURLOPT_URL, $url );
  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

  $data = curl_exec( $ch );
  curl_close( $ch );

  return $data;

}






function doc_upload($id_c_coste,$tipo_entidad,$id_subdir,$id_entidad,$file,$documento='',$observaciones='',$fecha_doc='',$reemplazar=0,$dividir_pdf=0,$eliminar_original=1)
{

    $fecha_doc= ($fecha_doc=='') ? date('Y-m-d') : $fecha_doc;

    if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }

// require_once("../include/funciones.php");
   
// $file["name"]=quita_simbolos_file($file["name"])  ;                 // quitamos simbolos como # que están permitidos en Windows pero no en Linux

    
$id_documento=Dfirst("MAX(id_documento)", "Documentos", "1=1")+1  ;    // id para hacer único el nombre del documento Y EVITAR CONFLICTOS DE NOMBRES

//$_SESSION['logs'].='<br>function doc_upload: Inicio <br>' ;
logs('function doc_upload: Inicio') ;

// Defino directorios, compruebo existencia, si FALSO ->  creo los dirs
$target_c_coste="../../uploads/{$id_c_coste}/"  ;
if (!file_exists($target_c_coste) )
	{  mkdir($target_c_coste) ;   logs("make dir: $target_c_coste") ; }	

$target_tipo_entidad = $target_c_coste . $tipo_entidad . "/" ; 
if (!file_exists($target_tipo_entidad) )
	{  mkdir($target_tipo_entidad) ;   logs("make dir: $target_tipo_entidad") ; }	

if ($id_subdir<>"")               // si $id_subdir no es vacío se organiza en subcarpetas
    {
	$target_dir = $target_tipo_entidad . $id_subdir . "/" ; 
    if (!file_exists($target_dir) )
	    {   mkdir($target_dir) ;  logs("make dir: $target_dir") ;
     	    }	
    }  
    else
    {   
	   $target_dir = $target_tipo_entidad ;
    }
	
	
$filename = quita_simbolos_file(basename($file["name"]))  ;            // quitamos simbolos para eviatr conflictos en LINUX
$target_file = $target_dir . "doc_".$id_documento."_".$filename ;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// nombro al documento por su descripcion o en su defecto por el nombre del fichero

                                                
// Check if file already exists

$reemplazado = 0 ;
if (file_exists($target_file))
 {
	if($reemplazar)
	{    
//    echo "Archivo existente, se procede a reemplazar";
        $uploadOk = 1;
	unlink($target_file) ; 
	$reemplazado = 1 ;
     }
	else
	{
//	 echo "Archivo existente, no se ha reemplazado";
    $uploadOk = 0;	
	}
 }
// Check file size
$limite=1024*1024*40  ; // 40 mb
$size = $file["size"]  ;
if ( $size > $limite)    // LIMITE TAMAÑO 40 MB 
{
        $_SESSION["error"]  = "Lo siento, el archivo supera el límite de $limite bytes";
    $return = 0;
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType == "exe" OR $imageFileType == "php" OR $imageFileType == "cgi"
OR $imageFileType == "htm" OR $imageFileType == "bin" ) {
        $_SESSION["error"] = "Lo siento, extensión de archivo no autorizada";
     $return = 0;
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0)
{
     $_SESSION["error"]  = "Existen errores, el archivo no se ha subido a la nube";
     $return = 0;
// if everything is ok, try to upload file
}else
{   
    logs('function doc_upload: vamos a move_uploaded_file') ;

    if (move_uploaded_file($file["tmp_name"], $target_file))
     {
        //        echo "El archivo ". basename( $file["name"]). " ha sido subido.";

        //        unlink($file["tmp_name"]) ;    // borramos el fichero temporal
               logs("move_uploaded_file: $target_file") ;
               
              
               
                // creación de 
//                $im = new Imagick(); //  PRUEBAS
//                
                // Plan: hacer array de imagenes a crear documentos independientes si es PDF y si está activado DIVIDIR_PDF
                // en caso contrario hacer una array con una sola imagen
                // luego hacer un foreach para todo el array añadir extension al nombre del fuchero para separar cada _page
//               $dividir_pdf=0; // ANULAMOS HASTA NUEVA ORDEN LA DIVISION DE PDF 
               if ($dividir_pdf)
                   {
                    logs("dividimos PDF: ") ;
                  
//                   $file = "./path/to/file/name.pdf";
//                   $fileOpened = @fopen($target_file, 'rb');
                   $images_pdf = new Imagick();
//                   $images_pdf->readImageFile($fileOpened);

                   
                    $images_pdf->pingImage($target_file);
//                    echo $im->getNumberImages();
                   
//                   $pdf_pages=sizeof($images_pdf) ;
                   $pdf_pages= $images_pdf->getNumberImages();
                   
//                   logs("paginas PDF:  ".sizeof($images_pdf)) ;
                   logs("paginas PDF: $pdf_pages ") ;       
                   
                   $images_pdf->clear();  
                   $images_pdf->destroy();  

//                   @fclose($fileOpened);
                   } // FUTURO CAMBIO importar $im es un array con cada página del PDF desde [0]
                else
                {
                    $pdf_pages=1 ;
                }

        $id_documento_array=[] ;
//       foreach($images as $i=>$im) {
        for ($i = 0; $i < $pdf_pages; $i++) {
                     
                $filename_i= ($i<>0) ? $filename."_".$i : $filename ; // añado _page al nombre del fichero si ha más de una imagen
                $target_file_i= ($i<>0) ? $target_file."_".$i : $target_file ; // añado _page al nombre del fichero si ha más de una imagen
                                    
                $im = new Imagick();
                $im->setResolution(150,150);

                $array_image_ext=['pdf','jpg','jpeg','bmp','gif','tif','tiff','png','pic','ico']   ;
                $is_picture=in_array(strtolower($imageFileType),$array_image_ext) ;

                // definimos qué fichero será la foto del archivo subido.
                if( $is_picture)             // comprobamos si el fichero tiene conversión a jpg
                {     
                $im->readimage($target_file . "[$i]");         // $im->readimage('document.pdf[0]'); PRUEBAS
                                
                }
                else
                {     
                $im->readimage("../img/no_image.png");         // si el fichero no tiene conversion a jpg metemos la imagen 'no_image.png' para evitar errores.
                }
                
//                $im->setResolution(150,150);

                $im->thumbnailImage(2000,2000 , true);                        


                $im->setImageCompression(imagick::COMPRESSION_JPEG );  // comprimimos el jpg
                $im->setimagecompressionquality( 60 );

                $es_foto= ($imageFileType == "jpg" OR $imageFileType == "jpeg" OR $imageFileType == "png") ;
                
               //EXIF DATA (metadatos de imagen)
               $exif= ($imageFileType == "jpg" OR $imageFileType == "jpeg") ? exif_read_data($target_file,NULL,true) : [];  // devuelve array EXIF o array vacio para los NO PICTURES
               $exif_data_json=json_encode($exif) ;  // codifico el array en json
               $exif_data_json= bin2hex ($exif_data_json); // paso el string json a HEX para evitar problemas al grabarlo en mysql


                $es_division_pdf= ($dividir_pdf AND  $pdf_pages>1 ) ;
                        
                        
               // si el fichero original es jpg (foto) lo sustituimos por el resize sin ningún tratamiento
                if( $es_foto OR $es_division_pdf)
                           { 
                              $target_file_i .= ($es_division_pdf ?  ".jpg" : "") ;
                              $im->writeImage($target_file_i);    // sustituimos el original por 
                              $size=filesize($target_file_i) ;    // recalculamos nuevo tamaño
                           }  

            
                $im->setImageFormat('jpeg');    
                        // $im->setImageFormat('png');   
                        error_reporting(E_ALL ^ E_DEPRECATED); // anulamos temporalmente el error E_DEPRECATED para evitar mensajes  de error al usuario
                        $im=$im->flattenImages();             // quito fondo transparente, evita fondo negro en pdf
                        error_reporting(E_ALL); 

                //   si  es FOTO mejoramos poco el contraste     
                if ($es_foto)
                        { 
//                              $im->normalizeImage();             // normalizo los colores para mejorar contraste
                              $im->contrastImage(1);     
                              $im->contrastImage(1);     
                            
                        
//                        $im->normalizeImage();             // normalizo los colores para mejorar contraste
//                        $im->contrastImage(1);             // mejoro el contraste
//                        $im->contrastImage(1);             // mejoro el contraste
        //		$im->contrastImage(1);             // mejoro el contraste
        //		$im->contrastImage(1);             // mejoro el contraste
        //		$im->contrastImage(1);             // mejoro el contraste
                        $im->unsharpMaskImage(0 , 0.5 , 1 , 0.05);             // mejoro el contraste
        //		$im->adaptiveSharpenImage(10,2);             // mejoro el contraste

                        } 
                        else
                        { 
                              $im->normalizeImage();             // normalizo los colores para mejorar contraste
                              $im->contrastImage(1);     
                              $im->contrastImage(1);     
                            
                        
//                        $im->normalizeImage();             // normalizo los colores para mejorar contraste
//                        $im->contrastImage(1);             // mejoro el contraste
//                        $im->contrastImage(1);             // mejoro el contraste
        //		$im->contrastImage(1);             // mejoro el contraste
        //		$im->contrastImage(1);             // mejoro el contraste
        //		$im->contrastImage(1);             // mejoro el contraste
                        $im->unsharpMaskImage(0 , 0.5 , 1 , 0.05);             // mejoro el contraste
        //		$im->adaptiveSharpenImage(10,2);             // mejoro el contraste

                        } 



        //		$im->thumbnailImage(2000,2000 , true);
               // $im->writeImage("{$target_file}_large.png"); 
                        $im->writeImage("{$target_file_i}_large.jpg");     // sacamos una foto en tres tamaños
                        $im->thumbnailImage(480, 480, true);
                        $im->writeImage("{$target_file_i}_medium.jpg"); 
        //		$im->thumbnailImage(160, 160, true);             // anulamos el _small
        //		$im->writeImage("{$target_file}_small.jpg"); 

                $im->clear();  
                $im->destroy();  

                    // FIN THUMBAIL

                        // registramos el documento en la bbdd
        //		require_once("../../conexion.php"); 
                
                                // si es FOTO borramos el original para ahorrar
                if ($es_foto AND $eliminar_original)
                    {
                      unlink($target_file_i) ;   // borramos el original
                      $size = filesize("{$target_file_i}_large.jpg") ;   // actualizamos el tamaño al _large.jpg
                    } 


                if ($reemplazado)
                {
                $sql="UPDATE `Documentos` SET `documento` = $documento,  `tamano` = '$size', `Observaciones` = '$observaciones' "
                        . "WHERE ìd_c_coste`= $id_c_coste AND `tipo_entidad`=$tipo_entidad AND `id_entidad`=$id_entidad AND  `Documentos`.`nombre_archivo` = $filename;" ;
                $result=$Conn->query($sql);
                logs("reemplazo doc: $sql") ;

                }
                else
                {
                if ($id_entidad)    
                {$orden_nuevo = Dfirst("MAX(orden)","Documentos"," id_c_coste={$_SESSION['id_c_coste']} AND tipo_entidad='$tipo_entidad' AND id_entidad=$id_entidad ")  + 100 ;  }
//                  logs("nuevo orden" . $orden_nuevo) ;
                else
                {$orden_nuevo = 100 ;  }
                
                $sql= "INSERT INTO `Documentos` (`id_c_coste`, `tipo_entidad`, `id_entidad`,`id_subdir`, `documento`, `nombre_archivo`,   `path_archivo`, `tamano`, `Observaciones` ,fecha_doc, orden,info_imagen, user) "
                                 . "VALUES ( '{$id_c_coste}', '$tipo_entidad', '$id_entidad', '$id_subdir', '$documento', '$filename_i','$target_file_i', '$size', '$observaciones', '$fecha_doc','$orden_nuevo','$exif_data_json', '{$_SESSION['user']}' );"   ;

                $result=$Conn->query($sql);
                
                
//                logs("inserto doc: $sql") ;

                }

        //	echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";	
//                $id_documento= Dfirst('MAX(id_documento)', 'Documentos', "id_c_coste={$_SESSION["id_c_coste"]}")     ;
                $id_documento=$Conn->insert_id    ;
                $id_documento_array[] = $id_documento ;            //$array[] = $var;
                
                $_SESSION["error"]='' ;
                logs("documento creado OK id_documento=" . $id_documento) ;
                
      } // FIN FOREACH
      
       
         $return =  $id_documento_array  ;      // TODO HA IDO BIEN


    }else
    {
        //        echo "Existen errores al mover el archivo, el archivo no se ha subido a la nube";
                $_SESSION["error"] = "Existen errores al mover el archivo, el archivo no se ha subido a la nube";
                logs("documento ERROR: {$file['name']} ... {$_SESSION["error"]}") ;

                $return = [] ;
    }
}

if (isset($fileOpened))  {  @fclose($fileOpened); }

if ($return==0) {logs('function doc_upload: return 0:'.  $_SESSION["error"]) ;}
$return = ($return==0) ? [] : $return ;   // convertimos a array la respuesta
return $return ;

}

?>


