<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Proveedores Importar XLS';

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
	   
<div id="main" class="mainc_100">
	
<h1>IMPORTAR PROVEEDORES DESDE .XLS</h1>

<?php 


//$result=$Conn->query("SELECT * from Proyecto_View WHERE ID_OBRA=".$id_obra);

?>
<STYLE>
    table, th, td {
  border: 1px solid black;
  padding: 15px; 
  margin: 10px; 
  text-align: center;
}
</STYLE>
  
    
    <center>

<form action="proveedores_importar_XLS.php" method="POST" enctype="multipart/form-data">
   
<!--    <input type="checkbox" id="borrar_proyecto" name="borrar_proyecto" value="OFF"  />
    Borrar proyecto actual<br>-->
    
    <table >
        <tr><td colspan='10'><p>Copia/pega las celdas del XLS donde están las Unidades de Obra (UDO) al area de texto con el formato de columnas de abajo.</p>
                <p>No es necesario que cada fila tenga el nombre de capitulo, basta con que esté en la primera UDO del capitulo</p>
                <p>No hay que copiar el encabezado, solo las celdas</p>
                <p>Si desconoce algún dato deje igualmente la columna vacía, respete el formato. No suprima columnas o altere el orden</p>
                <p>Eliminar columnas o filas de subtotales o celdas agrupadas para evitar conflictos</p>
                <p>Una vez copiado y pegado pulsa 'Importar'</p>
            </td></tr>

        <tr ><td >PROVEEDOR</td><td>RAZON SOCIAL</td><td>CIF</td><td>IBAN</td><td>BIC</td><td>EMAIL</td><td>DIRECCION</td><td>LOCALIDAD</td><td>CONTACTO</td><td>TELEFONO</td></tr>
    </table>
  
<!--    <input type="textarea" name="file_XLS" value="" width="400" height="400" required="" />-->
    <textarea rows='10' cols='100' id='file_XLS' name='file_XLS' /></textarea>
    <br>
    <button  class='btn btn-primary btn-lg' type="submit" form="form1" value="Submit">Importar</button>

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
     
     $capitulo0='CAPITULO VACIO' ;
     foreach ($a_rowTxts as $a_rowTxt)
     {
          $a_cell=explode("\t",$a_rowTxt) ;         // explotamos cada fila a un array de celdas a_cell
          //control de fila
          if (count($a_cell)<>10)
          {
                echo "<br>Error en fila. Faltan columnas: $a_rowTxt";
                $count++;

          }else
          {
                   echo "<br>Error en fila. Capitulo vacío: $a_rowTxt";  
                  // no hay capitulo, cojo el Capitulo anterior
                if ($a_cell[0]=='')
                {
                    $a_cell[0]=$capitulo0 ;
                }else
                {
               // copio el capitulo a capitulo0 por si hay una linea vacia posteriomente
                    $capitulo0 = $a_cell[0] ;          
                }    
                  $count++;

                 $a_cells[]=$a_cell;           //añado la fila al arrray global
          }    

    //     echo "<br>numero de celdas:". count($a_cell);

      }
      echo "<br><br><br>Filas importadas:". count($a_cells);          
      echo "<br><br><br>Filas con errores:". $count;          

      $count=0 ;
     foreach ($a_cells as $c)
     {
      foreach ($c as $campo) {$campo = quita_simbolos_mysql(trim($campo)) ; }   // quitamos a cada campo los simbolos comflictivos con MYSQL
 
       $PROVEEDOR=$c[0] ;  
       $RAZON_SOCIAL=$c[1] ;  
       $CIF= quita_simbolos(strtoupper( $c[2])) ;  
       $IBAN=quita_simbolos(strtoupper($c[3])) ;  
       $BIC=$c[4] ;  
       $email_pagos=$c[5] ;  
       $DIRECCION=$c[6] ;  
       $LOCALIDAD=$c[7] ;  
       $CONTACTO=$c[8] ;  
       $TEL1=$c[9] ;  
       
       $values_insert="( $id_c_coste,'$PROVEEDOR','$RAZON_SOCIAL','$CIF',''$IBAN','$BIC','$email_pagos','$DIRECCION','$LOCALIDAD','$CONTACTO','$TEL1' )" ;

//           
//       $med_proyecto=dbNumero($c[5]);
//       $precio=dbNumero($c[6]);
       
       
       // si el CAPITULO no existe lo creamos
      
         $id_capitulo=DInsert_into("Capitulos", "(ID_OBRA, CAPITULO,user)", $values_insert_capitulo , "ID_CAPITULO", "ID_OBRA=$id_obra");
//       $id_subobra=DInsert_into("SubObras", "(ID_OBRA, SUBOBRA,user)", $values_insert , "ID_SUBOBRA", "ID_OBRA=$id_obra");

       
       if (!DInsert_into("Proveedores", "(id_c_coste,PROVEEDOR,RAZON_SOCIAL,CIF,IBAN,BIC,email_pagos,DIRECCION,LOCALIDAD,CONTACTO,TEL1)" , $values_insert   ))  // ha existido error en la inserción
        {echo "<BR>ERROR insertando PROVEEDOR. VALUES INSERT: $values_insert  " ; } 
        else
        {
//            echo "Insertada UDO OK. VALUES INSERT: $values_insert <BR>" ; 
            $count++ ;
        }           
      }
    
  }

 }  

?>
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');