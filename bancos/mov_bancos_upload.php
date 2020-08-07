<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Banco Subida';

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

$id_cta_banco = $_GET["id_cta_banco"] ;


$id_c_coste= $_SESSION["id_c_coste"] ;

 $uploadOk = 1;
// Defino directorios, compruebo existencia, si FALSO ->  creo los dirs
$target_c_coste="../../uploads/{$id_c_coste}/"  ;
if (!file_exists($target_c_coste) )
	{  mkdir($target_c_coste) ;   }	

$target_tipo_entidad = $target_c_coste . 'csb_temp' . "/" ; 
if (!file_exists($target_tipo_entidad) )
	{  mkdir($target_tipo_entidad) ;   }	

$target_dir = $target_tipo_entidad ;	
$filename = basename($_FILES["fileToUpload"]["name"])  ;
$target_file = $target_dir . $filename ;

$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// nombro al documento por su descripcion o en su defecto por el nombre del fichero
                                                
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
} else
{
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
    {
        echo "El archivo ". basename( $_FILES["fileToUpload"]["name"]). " ha sido subido.";
		
		
    include_once("../include/c43.class.php");

    //    $argv[1]="movimientos.csb";  //juand

    //comprobacion de CCC 
    $IBAN = Dfirst("N_Cta","ctas_bancos", "$where_c_coste AND id_cta_banco=$id_cta_banco") ;
//    $entidad=  substr($IBAN, 5, 4) ;
//    $oficina=  substr($IBAN, 9, 4) ;
//    $cuenta=  substr($IBAN, 11, 10) ;


    $argv[1]=$target_file;  //juand
    $c43=new C43($argv[1]);


    echo "<BR>DATOS DEL FICHERO:";
    echo "<BR>STATUS= ".$c43->status."\n";
    echo "<BR>MENSAJE= ".$c43->message."<br>";
    echo "<BR>IBAN del fichero= ".$c43->entidad."  ".$c43->oficina."  ".$c43->cuenta;
    echo "<BR>IBAN de la cuenta= $IBAN";


    if (like(str_replace(" ", "", $IBAN),"%{$c43->entidad}%{$c43->oficina}%{$c43->cuenta}%"))
    {

    //parse_cabecera_cuenta
    echo "<br>IBAN DE CUENTA CORRECTA<br><br>";

    $numero_ultimo=Dfirst("MAX(numero)", "MOV_BANCOS", "id_cta_banco=$id_cta_banco" ) ;  // numero del ultimo mov_banco registrado en la cuenta 

    $total_movs=0 ;
    $correctos=0;
    $errores=0 ;
    foreach ( $c43->movimientos as $clave => $valor)
       {

    //    echo $clave . $valor["fecha_operacion"] ."<br>";

        $numero=   substr($valor["ref2"] , -6)   ;
        $fecha_banco= substr($valor["fecha_operacion"] ,0,4) ."-". substr($valor["fecha_operacion"] ,4,2)."-". substr($valor["fecha_operacion"] ,6,2) ;
        $concepto=$valor["conceptos_extra"][1]  ;
        $concepto2=$valor["conceptos_extra"][0]  ;

        if ($valor["importe"] >= 0 )     // es un ingreso
        {
            $cargo="" ;
            $ingreso=$valor["importe"] ;
        }else
        {
            $ingreso="" ;
            $cargo = - $valor["importe"] ;

        }

        $total_movs++ ;
        if ($numero>$numero_ultimo) // confirmamos para añadir solo los mov_bancos qu no existan

        {

           $sql= "INSERT INTO `MOV_BANCOS` (`id_cta_banco`, `numero`, `fecha_banco`, `Concepto`,`Concepto2`, `cargo`,   `ingreso` )" . 
                 " VALUES ( '$id_cta_banco', '$numero', '$fecha_banco', '$concepto','$concepto2', '$cargo','$ingreso');";    
    //       echo $sql . "<br>" ;

           if($result=$Conn->query($sql))              // registro un nuevo MOV_BANCO
           {
               $correctos++ ;
           } else
           {
               $errores++ ;
           }

        }


       }

     echo "IMPORTACION TERMINADA<BR>"  ;
     echo "Movimientos totales: $total_movs<BR>"  ;
     echo "Movimientos importados: $correctos<BR>"  ;
     echo "Movimientos erróneos: $errores<BR>"  ;

    }
    else
    {
        echo "<br> ERROR EN IBAN. LAS CUENTAS CORRIENTES NO COINCIDEN <br> <br> <br> "  ;
    }    
   
   
   
   //var_dump($c43);
//   echo "<pre>" ;
//   print_r ($c43);
//
//   echo "</pre>" ;

		
		// registramos el documento en la bbdd
		
//		if ($reemplazado)
//		  {
//			$result=$Conn->query("UPDATE `Documentos` SET `documento` = $documento,  `tamano` = '$size', `Observaciones` = '$observaciones' WHERE ìd_c_coste`= $id_c_coste AND `tipo_entidad`=$tipo_entidad AND `id_entidad`=$id_entidad AND  `Documentos`.`nombre_archivo` = $filename;" );
//
//		  }
//		else
//          {
//				$result=$Conn->query("INSERT INTO `Documentos` (`id_c_coste`, `tipo_entidad`, `id_entidad`, `documento`, `nombre_archivo`,   `path_archivo`, `tamano`, `Observaciones`) VALUES ( '{$id_c_coste}', '$tipo_entidad', '$id_entidad', '$documento', '$filename','$target_file', $size, '$observaciones');" );
//           }
//		
//	echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";	
		
		
    } else {
        echo "Existen errores al mover el archivo, el archivo no se ha subido a la nube";
    }
}

echo "<button  class='btn btn-warning btn-lg noprint' style='font-size:80px;'  onclick=\"window.close()\"/><i class='far fa-window-close'></i> cerrar ventana</button>" ;

?>

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');