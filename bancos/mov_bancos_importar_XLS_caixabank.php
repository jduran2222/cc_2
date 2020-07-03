<?php
require_once("../include/session.php");
?>

<HTML>
<HEAD>
<META NAME="GENERATOR" Content="NOTEPAD.EXE">
     <title>Importar XLS</title>

<!--<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />-->
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>--> 
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8_spanish_ci" />-->
<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->

</HEAD>
<BODY>



<?php 


// cogemos el id_cta_banco , confirmando que es de este id_c_coste
$id_cta_banco=Dfirst("id_cta_banco","ctas_bancos", " $where_c_coste AND id_cta_banco={$_GET["id_cta_banco"]} " ) ;

//if(!$id_cta_banco) {die("ERROR EN CUENTA BANCARIA");}   // si la cuenta no es del id_c_coste, ABORTAMOS

require("../../conexion.php"); 
require_once("../include/funciones.php"); 
require_once("../menu/topbar.php");
 
?>
	   	 
	   
<div id="main" class="mainc_100">
	
<h1>IMPORTAR MOVS. BANCOS DESDE .XLS (caixabank)</h1>

<?php 


//$result=$Conn->query("SELECT * from Proyecto_View WHERE ID_OBRA=".$id_obra);

?>

  
    
    <center>

<form action="mov_bancos_importar_XLS_caixabank.php?id_cta_banco=<?php echo $id_cta_banco ; ?>" id="form1" name="form1" method="POST" enctype="multipart/form-data">
   
<!--    <input type="checkbox" id="borrar_proyecto" name="borrar_proyecto" value="OFF"  />
    Borrar proyecto actual<br>-->
    
    <table style="border: 1px solid black;">
        <tr><td colspan='10'><p>Copia/pega las celdas del XLS donde están los movimientos Bancarios al area de texto con el formato de columnas de abajo.</p>
                <p>No hay que copiar el encabezado, solo las celdas</p>
                <p>Una vez copiado y pegado pulsa 'Importar'</p>
                <p>formato XLS de Caixabank</p>
            </td></tr>

        <tr ><td>Concepto</td><td >-col.vacia-</td><td >Fecha</td><td>Concepto2</td><td>Importe</td></tr>
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
       $fecha_banco=dbDate($c[2]) ;  
       $concepto=quita_simbolos_mysql($c[0]) ;  
       $concepto2=quita_simbolos_mysql($c[3]) ;  
       $importe= (float) dbNumero2($c[4]) ;  
       $cargo= $importe<0 ? -$importe : 0 ;  
       $ingreso=$importe>0 ? $importe : 0 ;   
       
//       $values_insert="( $id_c_coste,'$PROVEEDOR','$RAZON_SOCIAL','$CIF',''$IBAN','$BIC','$email_pagos','$DIRECCION','$LOCALIDAD','$CONTACTO','$TEL1' )" ;
       $values_insert="( $id_cta_banco,'$fecha_banco','$concepto','$concepto2','$cargo','$ingreso','{$_SESSION["user"]}' )" ;

//           
//       $med_proyecto=dbNumero($c[5]);
//       $precio=dbNumero($c[6]);
       
       
       // si el CAPITULO no existe lo creamos
      
//         $id_capitulo=DInsert_into("Capitulos", "(ID_OBRA, CAPITULO,user)", $values_insert_capitulo , "ID_CAPITULO", "ID_OBRA=$id_obra");
//       $id_subobra=DInsert_into("SubObras", "(ID_OBRA, SUBOBRA,user)", $values_insert , "ID_SUBOBRA", "ID_OBRA=$id_obra");

       // A MEDIAS , para evitar ver por dende iba la Caixa e importar todo el panel XLS
      if (!Dfirst("id_mov_banco","MOV_BANCOS_View", " $where_c_coste AND id_cta_banco=$id_cta_banco AND Concepto='$concepto' AND Concepto2='$concepto2' "
              . " AND cargo=$cargo AND ingreso=$ingreso AND fecha_banco='$fecha_banco'  ") )
      {        
           if (!DInsert_into("MOV_BANCOS", "(id_cta_banco,fecha_banco,Concepto,Concepto2,cargo,ingreso,user)" , $values_insert   ))  // ha existido error en la inserción
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
     
     echo "<BR>----------------------------------------------<BR>Total movimientos repetidos no importados:   $repetido " ;

    
  }

 }
 
 
 echo "<br><br><br><br><br><button  class='btn btn-warning btn-lg noprint' style='font-size:80px;'  onclick=\"window.close()\"/><i class='far fa-window-close'></i> cerrar ventana</button>" ;


?>