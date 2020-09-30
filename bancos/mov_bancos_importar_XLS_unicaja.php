<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Importar XLS (unicaja)';

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


// cogemos el id_cta_banco , confirmando que es de este id_c_coste
$id_cta_banco=Dfirst("id_cta_banco","ctas_bancos", " $where_c_coste AND id_cta_banco={$_GET["id_cta_banco"]} " ) ;

//if(!$id_cta_banco) {die("ERROR EN CUENTA BANCARIA");}   // si la cuenta no es del id_c_coste, ABORTAMOS

 
?>
	   	 
	   
<div id="main" class="mainc_100">
	
<h1>IMPORTAR MOVS. BANCOS DESDE .XLS (Unicaja)</h1>

<?php 


//$result=$Conn->query("SELECT * from Proyecto_View WHERE ID_OBRA=".$id_obra);

?>

  
    
    <center>

<form action="mov_bancos_importar_XLS_unicaja.php?id_cta_banco=<?php echo $id_cta_banco ; ?>" id="form1" name="form1" method="POST" enctype="multipart/form-data">
   
<!--    <input type="checkbox" id="borrar_proyecto" name="borrar_proyecto" value="OFF"  />
    Borrar proyecto actual<br>-->
    
    <table style="border: 1px solid black;">
        <tr><td colspan='10'><p>Copia/pega las celdas del XLS donde están los movimientos Bancarios al area de texto con el formato de columnas de abajo.</p>
                <p>No hay que copiar el encabezado, solo las celdas</p>
                <p>Una vez copiado y pegado pulsa 'Importar'</p>
                <p>formato XLS de Unicaja</p>
            </td></tr>

        <tr ><td>-no operativo-</td><td>Fecha Banco</td><td >Concepto</td><td>Importe</td><td>-no operativo-</td><td>-no operativo-</td><td>-no operativo-</td><td>Num.Movimiento</td></tr>
    </table>
  
<!--    <input type="textarea" name="file_XLS" value="" width="400" height="400" required="" />-->
    <textarea rows='5' cols='100' id='file_XLS' name='file_XLS' /></textarea>
    <br><br><br>
    <button  class='btn btn-primary btn-lg' style='font-size:80px;'  type="submit" form="form1" value="Submit">Importar</button>

</form>
    </center>

    
 <?php

if (isset($_POST["file_XLS"]))         //
{     
 
$file_XLS=$_POST["file_XLS"] ;


 if (!$file_XLS)
 {
    echo "XLS vacío, pruebe de nuevo<br>";
 // if everything is ok, try to upload file
 }
 else
 {
     
     $a_rowTxts=explode("\n",$file_XLS) ;
     echo "<br>INICIO DE IMPORTACIÓN";
     echo "<br>Número de filas encontradas:". count($a_rowTxts);
     echo "<br>";

     $a_cells=[];     
     $count=0;        // contador
     
//     $capitulo0='CAPITULO VACIO' ;
     foreach ($a_rowTxts as $a_rowTxt)
     {
          $a_cell=explode("\t",$a_rowTxt) ;         // explotamos cada fila a un array de celdas a_cell
          //control de fila
          if ($columnas=count($a_cell)<5)
          {
                echo "<br>Error en fila. Faltan o sobran columnas: $columnas ,   $a_rowTxt";
                $count++;

          }else
          {
//                   echo "<br>Error en fila. Capitulo vacío: $a_rowTxt";  
                  // no hay capitulo, cojo el Capitulo anterior
//                if ($a_cell[0]=='')
//                {
//                    $a_cell[0]=$capitulo0 ;
//                }else
//                {
//               // copio el capitulo a capitulo0 por si hay una linea vacia posteriomente
//                    $capitulo0 = $a_cell[0] ;          
//                }    
                  $count++;

                 $a_cells[]=$a_cell;           //añado la fila al arrray global
          }    

    //     echo "<br>numero de celdas:". count($a_cell);

      }
//      echo "<br><br><br>Filas importadas:". count($a_cells);          
//      echo "<br><br><br>Filas con errores:". $count;          

      $count=0 ;
      $repetido=0 ;
     foreach ($a_cells as $c)
     {
      foreach ($c as $campo) {$campo = quita_simbolos_mysql(trim($campo)) ; }   // quitamos a cada campo los simbolos comflictivos con MYSQL
 
//       $PROVEEDOR=$c[0] ;  
//       $RAZON_SOCIAL=$c[1] ;  
//       $CIF= quita_simbolos(strtoupper( $c[2])) ;  
//       $IBAN=quita_simbolos(strtoupper($c[3])) ;  
//       $BIC=$c[4] ;  
//       $email_pagos=$c[5] ;  
//       $DIRECCION=$c[6] ;  
//       $LOCALIDAD=$c[7] ;  
//       $CONTACTO=$c[8] ;  
//       $TEL1=$c[9] ;  
       $fecha_banco=dbDate($c[1]) ;  
       $concepto=quita_simbolos_mysql($c[2]) ;  
//       $concepto2=quita_simbolos_mysql($c[3]) ;  
       $concepto2='' ;  
       $importe= (float) dbNumero2($c[3]) ;  
       $cargo= $importe<0 ? -$importe : 0 ;  
       $ingreso=$importe>0 ? $importe : 0 ;   
//       $numero= (int) dbNumero2($c[7]) ;  
       $numero= $c[7] ;  

       
//       $values_insert="( $id_c_coste,'$PROVEEDOR','$RAZON_SOCIAL','$CIF',''$IBAN','$BIC','$email_pagos','$DIRECCION','$LOCALIDAD','$CONTACTO','$TEL1' )" ;
       $values_insert="( $id_cta_banco,'$fecha_banco','$concepto','$concepto2','$cargo','$ingreso','{$_SESSION["user"]}','$numero' )" ;

//           
//       $med_proyecto=dbNumero($c[5]);
//       $precio=dbNumero($c[6]);
       
       
       // si el CAPITULO no existe lo creamos
      
//         $id_capitulo=DInsert_into("Capitulos", "(ID_OBRA, CAPITULO,user)", $values_insert_capitulo , "ID_CAPITULO", "ID_OBRA=$id_obra");
//       $id_subobra=DInsert_into("SubObras", "(ID_OBRA, SUBOBRA,user)", $values_insert , "ID_SUBOBRA", "ID_OBRA=$id_obra");

       // A MEDIAS , para evitar ver por dende iba UNICAJA e importar todo el panel XLS
      if (!Dfirst("id_mov_banco","MOV_BANCOS_View", " $where_c_coste AND id_cta_banco=$id_cta_banco AND Concepto='$concepto' AND numero='$numero' "
              . " AND cargo=$cargo AND ingreso=$ingreso AND fecha_banco='$fecha_banco'  ") )
      {        
           if (!DInsert_into("MOV_BANCOS", "(id_cta_banco,fecha_banco,Concepto,Concepto2,cargo,ingreso,user,numero)" , $values_insert   ))  // ha existido error en la inserción
            {echo "<BR>ERROR insertando MOV BANCO. VALUES INSERT: $values_insert  " ;
            } 
            else
            {
    //            echo "Insertada UDO OK. VALUES INSERT: $values_insert <BR>" ; 
                $count++ ;
            }           
      }else
      {   // REPETIDO, nos lo saltamos
//          echo "<BR>Movimiento banco existente no importado: $a_rowTxt  VALUES  $values_insert  " ;
          echo "<BR>Movimiento banco existente. No se importa:   VALUES  $values_insert  " ;
          $repetido++ ;
      }   
     }
     
     echo "<BR>Total movimientos REPETIDOS no importados:   $repetido " ;
     echo "<BR>Total NUEVOS movimientos registrados:   $count " ;

    
  }

 }
 
 
 echo "<br><br><br><br><br><button  class='btn btn-warning btn-lg noprint' style='font-size:80px;'  onclick=\"window.close()\"/><i class='far fa-window-close'></i> cerrar ventana</button>" ;


?>
                </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');