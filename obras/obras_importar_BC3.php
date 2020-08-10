<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Importación BC3';

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
                <div class="col-12 col-md-4 col-lg-9">

                <!--****************** BUSQUEDA GLOBAL  *****************-->

<?php

$id_obra=$_GET["id_obra"];

require_once("../obras/obras_menutop_r.php");
//require_once("../menu/menu_migas.php");

?>
	   	 
	   
<div id="main" class="mainc">
  <?php // require_once("obras_menutop_r.php");?>	
	
<h1>IMPORTAR PROYECTO DESDE .BC3</h1>

<?php 


$result=$Conn->query("SELECT * from Proyecto_View WHERE ID_OBRA=".$id_obra);

if (!isset($_FILES["file_BC3"]))         // evitamos que salga el Form una vez importado el BC3
{     
?>

<form action="obras_importar_BC3.php?_m=$_m&id_obra=<?php echo $id_obra;?>" method="POST" enctype="multipart/form-data">
   
<!--    <input type="checkbox" id="borrar_proyecto" name="borrar_proyecto" value="OFF"  />
    Borrar proyecto actual<br>-->
    <h3>Selecciona o arrastra sobre el boton el fichero .BC3</h3>
    <input type="file" name="file_BC3"  style="font-size:40px;" class="btn btn-primary btn-lg"  >
    <br>
    <label><h5> <input type="checkbox" name="costes_indirectos"   class="btn btn-primary btn-lg" checked >  Añadir Capitulo y Udo de COSTES INDIRECTOS</h5>
    </label><br>
    <label><h5> <input type="checkbox" name="debug_BC3"   class="btn btn-primary btn-xs"  >  Depurar importación para ver errores</h5>
    </label><br>
    <input style="font-size:80px;" type="submit" class="btn btn-success btn-lg" value="Aceptar" >

</form>

    
 <?php
}
 
 
 $debug_bc3=isset($_POST["debug_BC3"]) ;       // variable local para ver si emitimos información durante la importación
 $cont_capitulos=0 ;
 $cont_udos=0 ;
 $cont_conceptos_error=0 ;
 $cont_udos_error=0 ;
 
 
if (isset($_FILES["file_BC3"]))         // 
{     

// echo 'LOGS_DB:' .  logs_db('Inicio importacion BC3:', 'info', basename($_FILES["file_BC3"]["name"])  ,'file' , 'line') ; //registro los intentos de importación BC3     
 
 $target_dir = "../../uploads/tmp/";
 
 // creamos el dir TMP si no existe
 if ( !is_dir( $target_dir ) ) {
    mkdir( $target_dir );       
}
 
 $target_file = $target_dir .strtotime("now"). basename($_FILES["file_BC3"]["name"]);
 $uploadOk = 1;

 $extension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
 // Check if image file is a actual image or fake image

 
//}
// Check file size
 if ($_FILES["file_BC3"]["size"] > 5000000) {
    echo "Error. Archivo demasiado grande";
    $uploadOk = 0;
 }
// Allow certain file formats
 if($extension != "bc3" ) {
    echo "Error, archivo sin extensión .bc3<br>";
    $uploadOk = 0;
 }
 // Check if $uploadOk is set to 0 by an error
 if ($uploadOk == 0)
 {
    echo "BC3 no importado, pruebe de nuevo<br>";
 // if everything is ok, try to upload file
 } else {
    if (move_uploaded_file($_FILES["file_BC3"]["tmp_name"], $target_file)) {
         //echo "Jmmmm". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	
        
        // TODO OK, procedemos a la importación del fichero y lo metemos línea a línea en el array $bc3
        
       if ($bc3 = file($target_file))
       {
//           //
           // inicializo arrays
           $capitulos = [] ;
           $udos = [] ;
           foreach ($bc3 as $key => $value)   // PRIMERA pasada al array para buscar capitulos, conceptos y textos
           {
                // $value=utf8_encode($value) ;
//               echo utf8_encode($value) ;  //debug
//                echo '<BR>' ;  //debug
               
               //$a = explode("|", $value) ;
               $cod_BC3= substr($value, 0, 2) ;
               if ($cod_BC3== "~C")           // estamos en un capítulo o concepto
               {   
                  $a = explode("|", utf8_encode($value)) ;          // explotamos el Registro en cada Campo del Fiebc, $a[1] es el código de presto
                 if(isset($a[3]))  // comprobamos si es un array de varios elementos
                 {
                     if (substr($a[1],-1)=="#")   // es capítulo
                    { 
                      //$capitulos[str_replace("#","",$a[1])]["capitulo"]=$a[3] ;   //añado un capitulo con su key al array capitulos[]      //DEBUG JUAND
                      $capitulos[$a[1]]["capitulo"]=$a[3] ;   //añado un capitulo con su key al array capitulos[]      //DEBUG JUAND
                    }
                    else                         // es un concepto. Lo registro en su array
                    { 
                      $conceptos[$a[1]]["COD_PROYECTO"] = $a[1] ;
                      $conceptos[$a[1]]["ud"] = $a[2] ;
                      $conceptos[$a[1]]["UDO"] = $a[3] ;
                      $conceptos[$a[1]]["PRECIO"] = $a[4] ;
                     }
                 }else
                 {
                   echo ( $debug_bc3 ? "<br>ERROR EN LINEA DE BC3":"" ) ; 
                 }   
               }
               if ($cod_BC3== "~T")           // estamos en un Texto de concepto
               { 
//                  $a = explode("|", utf8_encode($value)) ;
                  $a = explode("|", utf8_encode($value)) ; 
                  $conceptos[$a[1]]["TEXTO_UDO"] = htmlspecialchars( str_replace("'", "\'" , $a[2] ) ) ;  //probamos htmlspecialchars
                }
               
           }
           
           foreach ($capitulos as $key => $value)
           {
               $capitulo= substr($key, 0, -1)." ".$value["capitulo"] ;
               $values_insert_cap= "($id_obra ,'$key', '$capitulo','{$_SESSION["user"]}')" ;
               $values_insert_subobra= "($id_obra , '$capitulo','{$_SESSION["user"]}')" ;  
               echo ( $debug_bc3 ? " VALUES INSERT: $values_insert_cap <BR>" : "") ;
               $id_capitulo=DInsert_into("Capitulos", "(ID_OBRA,cod_capitulo, CAPITULO,user)", $values_insert_cap , "ID_CAPITULO", "ID_OBRA=$id_obra");
               $id_subobra=DInsert_into("SubObras", "(ID_OBRA, SUBOBRA,user)", $values_insert_subobra , "ID_SUBOBRA", "ID_OBRA=$id_obra");
               
               echo ( $debug_bc3 ?  "INSERTADO ID_CAPITULO $id_capitulo " : "")  ;
               $capitulos[$key]["id_capitulo"]=$id_capitulo ;
               $capitulos[$key]["id_subobra"]=$id_subobra ;
               
               $cont_capitulos++ ;
           }
           
           //   DEBUG
//           echo "<pre>" ;
//           print_r($capitulos) ;    
//           echo "</pre>" ;
//           echo "<pre>" ;
//           print_r($conceptos) ;    
//           echo "</pre>" ;
           
           //$id_subobra=getvar("id_subobra_si") ;
           
           $udos = [] ;
           $mediciones = [] ;
            foreach ($bc3 as $key => $value)   // SEGUNDA pasada al array con $capitulos y $conceptos creados para buscar ~D descompuestos de Capítulos (es decir, udos)
           {
               $cod_BC3 = substr($value, 0, 2) ;
               if ($cod_BC3== "~D")           // estamos en un descompuesto (UDO)
               {                  
                   $a = explode("|", utf8_encode($value)) ;
                   if (isset($capitulos[$a[1]]))     // es el descompuesto de un capítulo, es decir , una UDO
                   {
                       // nueva UNIDAD DE OBRA (UDO)
                     $id_capitulo= $capitulos[$a[1]]["id_capitulo"] ;     // extraigo el id_capitulo 
                     $id_subobra= $capitulos[$a[1]]["id_subobra"] ;     // extraigo el id_subobra 
                     $d=explode("\\",$a[2])  ;       // fragmento el Descompuesto en un array donde cada 3 item es un udo
                     $i=0 ;
                     while(isset($d[$i]))
                     {
                      if(isset($conceptos[$d[$i]]))           // si existe el concepto de la UDO , Inserto la UDO en su capítulo
                      {
                       $MED_PROYECTO=$d[$i+2] ;    
                       $c=$conceptos[$d[$i]] ;
                       
                       $c["TEXTO_UDO"]= isset($c["TEXTO_UDO"])? $c["TEXTO_UDO"] : $c["UDO"] ;   // evitamos un error de TEXTO_UDO no definido
//                       $c["Descompuesto_PRECIO"]= isset($c["Descompuesto_PRECIO"])? $c["Descompuesto_PRECIO"] : "No hubo descompuesto Precio" ;   // evitamos un error de TEXTO_UDO no definido
                       
                       $values_insert="($id_obra,$id_capitulo,$id_subobra,'{$c["UDO"]}','{$c["COD_PROYECTO"]}','{$c["ud"]}','{$c["TEXTO_UDO"]}' "
                                         . " ,{$c["PRECIO"]},{$c["PRECIO"]},$MED_PROYECTO   )";
                                             
                       //$values_insert="($id_obra,$id_capitulo,$id_subobra,'UDO','ud','TEXTO_UDO' ,123,567 )";
                      
                       
                       if (!DInsert_into("Udos", "(ID_OBRA,ID_CAPITULO,ID_SUBOBRA,UDO,COD_PROYECTO,ud,TEXTO_UDO,PRECIO,COSTE_EST,MED_PROYECTO)" , $values_insert   ))  // ha existido error en la inserción
                          {   $cont_udos_error++ ;
                           echo ( $debug_bc3 ?  "ERROR insertando UDO. VALUES INSERT: $values_insert <BR>" :"" ); 
                          
                          } 
                          else
                          {   $cont_udos++ ;
                              echo ( $debug_bc3 ?  "Insertada UDO OK. VALUES INSERT: $values_insert <BR>" : "" ) ;
                           }     
                      }
                      else
                      { $cont_conceptos_error++ ;
                       echo ( $debug_bc3 ?  "ERROR Concepto no definido previamente en el BC3: id_capitulo=$id_capitulo , concepto: {$d[$i]} <BR>" :"" );     
                      }
                       $i += 3 ;  //salto 3 índices
                       
                     }  

                   }elseif (isset($conceptos[$a[1]]))    // Es el Descompuesto de una UDO, su Descompuesto_PRECIO
                   {
                       // DESCOMPUESTO_PRECIO  de una Udo (similar a las Udos de un  Capítulo)
                     $conceptos[$a[1]]['Descompuesto_PRECIO'] = '<table><tr><th>codigo</th><th>ud</th><th>concepto</th><th>rendimiento</th><th>precio</th><th>importe</th></tr>' ; 
                     $d=explode("\\",$a[2])  ;       // fragmento el Descompuesto en un array donde cada 3 item es un udo
                     $i=0 ;
                     $importe_d_suma=0 ;
                     while(isset($d[$i]))
                     {
                          if(isset($conceptos[$d[$i]]))           // si existe el concepto de la UDO , Inserto la UDO en su capítulo
                          {
                           $rendimiento=$d[$i+2] ;    
                           $c=$conceptos[$d[$i]] ;

                           $c["TEXTO_UDO"]= isset($c["TEXTO_UDO"])? $c["TEXTO_UDO"] : $c["UDO"] ;   // evitamos un error de TEXTO_UDO no definido
                           $importe_d_suma += ($c["ud"]=='%') ? $rendimiento * $importe_d_suma : $rendimiento * $c["PRECIO"] ;
                           $importe_d=cc_format($rendimiento * $c["PRECIO"], 'moneda' ) ;
                           
                           $conceptos[$a[1]]['Descompuesto_PRECIO'].= "<tr><td>{$c["COD_PROYECTO"]}</td><td>{$c["ud"]}</td><td>{$c["UDO"]}</td><td align=right>$rendimiento</td>"
                                   . "<td align=right>{$c["PRECIO"]}</td><td align=right>$importe_d</td></tr>" ;

    //                       $values_insert="($id_obra,$id_capitulo,$id_subobra,'{$c["UDO"]}','{$c["COD_PROYECTO"]}','{$c["ud"]}','{$c["COD_PROYECTO"]}' ,{$c["PRECIO"]},{$c["PRECIO"]},$MED_PROYECTO )";                                                                 

                          }
                          else
                          { $cont_conceptos_error++ ;
                           echo ( $debug_bc3 ?  "ERROR Concepto no definido previamente en el BC3: id_capitulo=$id_capitulo , concepto: {$d[$i]} <BR>" :"" );     
                          }
                           $i += 3 ;  //salto 3 índices
                       
                     } 
                    $conceptos[$a[1]]['Descompuesto_PRECIO'].= "<tr><td></td><td></td><td></td><td></td><td><strong>Suma</strong></td>"
                            . "<td align=right><strong>".cc_format($importe_d_suma,'moneda')."</strong></td></tr></table>" ; 

                   }    
               }elseif ($cod_BC3== "~M")           // estamos en un DESCOMPUESTO DE MEDICION
               {
                      // estamos en un DESCOMPUESTO DE MEDICION
                     $a = explode("|", utf8_encode($value)) ;
                     $cod_cap_udo=$a[1];
                     $mediciones[$cod_cap_udo] = '<table><tr><th>detalle</th><th>ud</th><th>longitud</th><th>ancho</th><th>alto</th><th>medicion</th></tr>' ; 
                     $m=explode("\\",$a[4])  ;       // fragmento el Descompuesto en un array donde cada XXX item es un udo
                     $i=1 ;
                     $med_total=0 ;
                     while(isset($m[$i+4]))
                     {
                           $med_parcial = cc_format( $m[$i+1]*($m[$i+2]? $m[$i+2]:1)*($m[$i+3]? $m[$i+3]:1)*($m[$i+4]? $m[$i+4]:1), 'fijo' ) ;
                           $med_total += $med_parcial ;
                           
                           $mediciones[$cod_cap_udo].= "<tr><td>{$m[$i+0]}</td><td align=right>{$m[$i+1]}</td><td>{$m[$i+2]}</td><td align=right>{$m[$i+3]}</td>"
                           . "<td align=right>{$m[$i+4]}</td><td align=right>$med_parcial</td></tr>" ;

    //                       $values_insert="($id_obra,$id_capitulo,$id_subobra,'{$c["UDO"]}','{$c["COD_PROYECTO"]}','{$c["ud"]}','{$c["COD_PROYECTO"]}' ,{$c["PRECIO"]},{$c["PRECIO"]},$MED_PROYECTO )";                                                                 

                           $i += 6 ;  //salto 5 índices
                       
                     } 
                     $mediciones[$cod_cap_udo].= "<tr><td></td><td></td><td></td><td></td><td><strong>Suma</strong></td><td align=right><strong>".cc_format($med_total,'fijo')."</strong></td></tr></table>" ; 
                    
                   
               }else    
               {   $cont_udos_error++ ;
                   echo ( $debug_bc3 ?  "ERROR EN descompuesto de precio: CONCEPTO {$a[1]} NO ENCONTRADO <BR>" :"" ); 
                          
               } 
    
           }
           // incluimos el Descompuesto_PRECIO de las Udos que lo tengan.
           
         $sql="SELECT * FROM Udos_View WHERE ID_OBRA=$id_obra AND $where_c_coste" ;
         $result=$Conn->query($sql);
         $sql_UPDATE="";
         while ($rs = $result->fetch_array(MYSQLI_ASSOC))
         {
           $Descompuesto_PRECIO = isset($conceptos[$rs["COD_PROYECTO"]]["Descompuesto_PRECIO"]) ?  $conceptos[$rs["COD_PROYECTO"]]["Descompuesto_PRECIO"] : "SIN DESCOMPUESTO" ;
           
           $clave_mediciones = $rs["cod_capitulo"] . "\\" . $rs["COD_PROYECTO"] ;
           $Descompuesto_MED = isset($mediciones[$clave_mediciones]) ? $mediciones[$clave_mediciones] : "SIN MEDICIONES" ;
           
//           $sql_UPDATE.="UPDATE `Udos` SET `Descompuesto_MED` = '$Descompuesto_PRECIO' WHERE ID_UDO={$rs["ID_UDO"]} AND ID_OBRA=$id_obra   ;"   ;
           $sql_UPDATE.="UPDATE `Udos` SET `Descompuesto_PRECIO` = '$Descompuesto_PRECIO',  `Descompuesto_MED` = '$Descompuesto_MED' WHERE ID_UDO={$rs["ID_UDO"]} AND ID_OBRA=$id_obra   ;"   ;
//           $sql_UPDATE.="UPDATE `Udos` SET `Descompuesto_PRECIO` = '$Descompuesto_PRECIO' WHERE ID_UDO={$rs["ID_UDO"]} AND ID_OBRA=$id_obra   ;"   ;
         }        
         
         
            // Datos para la impresión de RESUMEN
           $rs_Obra= DRow("OBRAS", "ID_OBRA='$id_obra' AND $where_c_coste") ;
          
           $gg_bi=$rs_Obra['GG_BI']; 
           $iva_obra=$rs_Obra['iva_obra'];
           $coef_baja=$rs_Obra['COEF_BAJA'];
           $importe=$rs_Obra['IMPORTE'];

         
         
         // ANULAMOS EL USO E MULTI_QUERY YA QUE IMPIDE POSTERIORMENTE USAR QUERY. YA QUE DA ERROR
         // el uso de multi_query da errores a posteiori para usar query normal
//          if( !$Conn->multi_query($sql_UPDATE))
//          {   echo ( $debug_bc3 ?  "<br><h1>ERROR EN MULTI QUERY UPDATE</h1>  <BR>" :"" ) ;
//          }else
//          {
//               echo ( $debug_bc3 ?  "<br><h1>SIN ERRORES EN MULTI QUERY UPDATE</h1>  <BR>" : "" );
//          }    
//          
           // ejecutamos las sentencias una a una
          $array_sql=  explode(";", $sql_UPDATE);
          foreach ($array_sql as $sql) {
              if (trim($sql)!='') {$Conn->query($sql) ;}
          }
          
            
           
           //debug
          if  ( $debug_bc3  )
          {    
           echo '<pre>' ;
           echo print_r($capitulos);
           echo '/<pre>' ;
           echo '<pre>' ;
           echo print_r($conceptos);
           echo '/<pre>' ;
          } 
           
//           $gg_bi=Dfirst('GG_BI','OBRAS',"ID_OBRA='$id_obra'"); 
//           $iva_obra=Dfirst('iva_obra','OBRAS','ID_OBRA='.$id_obra);
//           $coef_baja=Dfirst('COEF_BAJA','OBRAS','ID_OBRA='.$id_obra);
//           $importe=Dfirst('IMPORTE','OBRAS','ID_OBRA='.$id_obra);
           
           
           
           $pem_proyecto=Dfirst('SUM(PRECIO*MED_PROYECTO)','Proyecto_View','ID_OBRA='.$id_obra) ;
           
           echo "<br>--------- RESUMEN DE IMPORTACIÓN -------" ;
           echo "<br>ERRORES Conceptos: $cont_conceptos_error" ;
           echo "<br>ERRORES Udos: $cont_udos_error" ;           
           echo "<br><br>CAPITULOS IMPORTADOS: $cont_capitulos" ;
           echo "<br>UNIDADES DE OBRA IMPORTADAS: $cont_udos" ;
           
           
           echo "<br><br><table class='table table-bordered'><tr><th>RESUMEN</th><th>IMPORTES</th></tr>" ;
           echo "<tr><td>PRESUP. EJEC. MATERIAL (PEM de Proyecto): </td><td>". cc_format($pem_proyecto, 'moneda')."</td></tr>" ;
           echo "<tr><td>PRESUP. EJEC. CONTRATA (PEC) (GG+BI - BAJA): </td><td>". cc_format($pem_proyecto*(1+$gg_bi)*$coef_baja, 'moneda')."</td></tr>"  ;
           echo "<tr><td>PRESUP. EJEC. CONTRATA iva inc. (del Proyecto): ".cc_format($iva_obra,'porcentaje0')."</td><td>". cc_format($pem_proyecto*$coef_baja*(1+$gg_bi)*(1+$iva_obra), 'moneda')."</td></tr>"  ;           
           echo "<tr><td></td><td></td></tr>" ;
           echo "<tr><td>PRESUPUESTO DE LA OBRA IVA INC. </td><td>". cc_format($importe, 'moneda')."</td></tr>"  ;   
           $pec_proyecto_iva=$pem_proyecto*$coef_baja*(1+$gg_bi)*(1+$iva_obra) ;
           
           if ($pec_proyecto_iva==$importe)
           {
              echo "<tr><td>PROYECTO CORRECTO</td></tr>" ;                  
           }
           else
           {
              echo "<tr><td>ERROR EN PROYECTO </td><td>".cc_format($importe-$pec_proyecto_iva, 'moneda'). "</td></tr>" ;                  
              echo "<tr><td>RATIO EN PROYECTO </td><td>".cc_format($importe/$pec_proyecto_iva, 'porcentaje'). "</td></tr>" ;                  
           }
               
              echo "</table>" ;                  
           
//            echo 'LOGS_DB:' . logs_db('importacion BC3 correcta ' ) ;

// 
//           
//           echo "<br><a class='btn btn-success' style='font-size:40px'  href=\"../obras/obras_proy.php?id_obra=$id_obra\">Volver a Proyecto</a>  " ;
//            echo "<script languaje='javascript' type='text/javascript'>window.location.href = '../obras/obras_proy.php?id_obra=$id_obra';</script>"  ;
            if (isset($_POST["costes_indirectos"]))
            {
                echo "<script languaje='javascript' type='text/javascript'>window.open('../obras/obras_proy_add_CI.php?id_obra=$id_obra','_blank');</script>"  ;                
            }
            else  
            {
                echo "<script languaje='javascript' type='text/javascript'>window.location.href = '../obras/obras_proy.php?id_obra=$id_obra';</script>"  ;                
            }  
            
           
           
           // fin de importación
       }     
        else
        {
            echo ( $debug_bc3 ?  "Error en carga de fichero temporal" : "") ;
        }
        
        	
		
    } else {
        echo ( $debug_bc3 ?  "Error al descargar archivo en el servidor: ".$_FILES["file_BC3"]["error"] : "" );
    }
  }

 }
 
  echo "<br><br><br><br><br><button  class='btn btn-warning btn-lg noprint' style='font-size:80px;'  onclick=\"window.close()\"/><i class='far fa-window-close'></i> cerrar ventana</button>" ;
  echo "<br><br><br><br><br>" ;


$Conn->close();
 
 
?>


        
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');