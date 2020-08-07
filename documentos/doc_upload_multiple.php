<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Resultados Upload';

//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');

?>

        <!-- Contenido principal -->
        <div class="container-fluid bg-light">
            <div class="row">
                <!--****************** ESPACIO LATERAL  *****************-->
                <div class="col-12 col-md-4 col-lg-3"></div>
                <!--****************** ESPACIO LATERAL  *****************-->

                <!--****************** BUSQUEDA GLOBAL  *****************-->
                <div class="col-12 col-md-4 col-lg-9">

<?php

 require_once("../documentos/doc_function.php");
 require_once("../vendor/funciones_ocr.php");



$id_c_coste= $_SESSION["id_c_coste"] ;


$tipo_entidad=$_POST["tipo_entidad"]  ;
if(!$tipo_entidad) {$tipo_entidad='pdte_clasif'  ; } // por defecto los subimos sin clasificar (tipo_entidad='pdte_clasif'

//$id_subdir=$_POST["id_subdir"]  ;

$id_entidad = isset($_POST["id_entidad"])? $_POST["id_entidad"]  :  '' ;
$id_subdir = isset($_POST["id_subdir"])? $_POST["id_subdir"]  :  '' ;
$fecha_doc = isset($_POST["fecha_doc"])? $_POST["fecha_doc"]  :  '' ;
//$dividir_pdf = isset($_POST["dividir_pdf"])? $_POST["dividir_pdf"]  :  '' ;

$dividir_pdf = (isset($_POST['dividir_pdf']) && $_POST['dividir_pdf'] <> '') ? 1 : 0 ;
$eliminar_original = (isset($_POST['dividir_pdf']) && $_POST['dividir_pdf'] <> '') ? 1 : 0 ;

// echo  "<br>EMPEZAMOS EL UPLOADS" ;
// 
//echo "<pre>";
//print_r ($file);
//echo "</pre>";


//$id_subdir=0 ;
//$id_entidad=0 ;

echo "<br><button  class='btn btn-warning btn-lg noprint' style='font-size:80px;' "
       . " onclick=\"window.close()\"/><i class='far fa-window-close'></i> cerrar ventana</button><br>" ;

$c=0;

for ($i = 1; $i <= 4; $i++)           // hacemos el FOREACH para los cuatro botones del FORM
{
//    echo $i;


$file=$_FILES["fileToUpload_{$i}"] ;

//echo "<pre>";
//print_r ($file);
//echo "</pre>";

if ($file["name"][0])     // comprobamos que en ese $_FILE[] se han depositado ficheros o fotos
 {    
  foreach ($file["name"] as $key => $value)
  {
 
   // creamos el array $f ( file) con los valores de un único file para pasar a la función
   $documento=$file["name"][$key] ;     // cogemos el nombre del archivo como nombre del documento
      
   $f["name"]=quita_simbolos_file($documento)  ;                 // quitamos simbolos como # que están permitidos en Windows pero no en Linux
   $f["size"]=$file["size"][$key]  ;
   $f["error"]=$file["error"][$key]  ;
   $f["tmp_name"]=$file["tmp_name"][$key]  ;
   $f["type"]=$file["type"][$key]  ;   
   
   
   if ($tipo_entidad=="estudios_XML")      // nuevo tipo de fichero Estudio o licitacion XML de contrataciondelestado.es
   {
     if (anadir_estudio_XML($f))   // creamos la nueva factura y le linkamos el recien creado id_documento
     {
//         echo "<h1>  ESTUDIO LICITACION AÑADIDA CORRECTAMENTE</h1> {$f["name"]}" ; 
         
         }
     else
     { die("<h1>  ERROR AL AÑADIR LICITACION XML</h1> {$f["name"]}") ; }  

   }
   else   // otros tipos de fichero (fotos, albaranes, fras_prov...)
   {
    // cargamos el fichero y producimos sus dos .jpg (_medium.jpg y _large.jpg)
   $id_documento_array = doc_upload($id_c_coste,$tipo_entidad,$id_subdir,$id_entidad,$f,$documento,'',$fecha_doc,'',$dividir_pdf,$eliminar_original) ;
//   echo "<pre>";
//print_r ($id_documento_array);
//echo "</pre>";

   if ( sizeof($id_documento_array)>0 )        // documentos subidos, procedemos a registrar ffra_prov y albaranes y presentarlos con su link
   {   
       echo "<br>Doc. generados : ".sizeof($id_documento_array)   ;
        foreach($id_documento_array as $i=>$id_documento) 
             {
                     $path_archivo = Dfirst("path_archivo","Documentos","id_documento=$id_documento AND $where_c_coste" ) . "_large.jpg"  ;
                     
                     // procedemos a registrar los metadatos
                     if ($tipo_entidad<>'obra_foto')
                     {
                         $texto_ocr= quita_simbolos_mysql( Google\Cloud\Samples\Vision\texto_ocr($path_archivo) ) ;                     
                         $result2=$Conn->query("UPDATE `Documentos` SET `metadatos` = '$texto_ocr' WHERE id_documento=$id_documento  AND $where_c_coste;" );
                     }    


                     // tratamiento según el tipo_entidad
                     if($tipo_entidad=='fra_prov' AND !$id_entidad)  // los documentos subidos son facturas no creadas aún, procedemos a crear la entidad factura_proveedor y linkarle su documento
                     {    
                          if ($id_fra_prov=factura_proveedor_anadir($id_documento))   // creamos la nueva factura y le linkamos el recien creado ID_FRA_PROV
                          { 
                         echo  "<br><h1>SUBIDA FACTURA PROVEEDOR: $value</h1>" ;
                         echo  "<center><a href='../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov' target='_blank'><img src=\"$path_archivo\"  ></a></center>" ;
                          }
                          else
                          { 
                //              echo "<h1>  ERROR AL AÑADIR FACTURA</h1>" ; 
                          die("ERROR AL AÑADIR FACTURA");
                          }  
                     }
                     elseif($tipo_entidad=='albaran' AND $id_entidad)  // los documentos subidos son facturas no creadas aún, procedemos a crear la entidad factura_proveedor y linkarle su documento
                     {    

                         echo  "<br><h1>SUBIDO ALBARAN PROVEEDOR: $value</h1>" ;
                         echo  "<center><a href='../proveedores/albaran_proveedor.php?id_vale=$id_entidad' target='_blank'><img src=\"$path_archivo\"  ></a></center>" ;

                     }
                     else
                     {
                         echo  "<br><h1>SUBIDO FOTO/FICHERO: $value</h1>" ;
                         echo  "<center><a href='../documentos/documento_ficha.php?id_documento=$id_documento' target='_blank'><img src=\"$path_archivo\"  ></a></center>" ;
            //             echo  "<center><img src=\"$path_archivo\"  ></center>" ;

                     }
             }    
   }
   else
   {
//     echo  "<br>ERROR EN FICHERO: $value" ; // lo quitamos provisionalmente
//     die(  "<br>ERROR EN FICHERO: $value" ) ;
   }
   
   $c++ ;
   }
  }

 }

}

echo  "<br><br><h1>TOTAL SUBIDOS  $c fotos o ficheros</h1>" ;
echo "<button  class='btn btn-warning btn-lg noprint' style='font-size:80px;'  onclick=\"window.close()\"/><i class='far fa-window-close'></i> cerrar ventana</button>" ;

//echo "<script>window.close()</script>" ;  // si no ha habido ERRORES y un die() posterior, cerramos la página


?>

    
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
    