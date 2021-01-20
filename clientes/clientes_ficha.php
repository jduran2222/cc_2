<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo_pagina="Cliente " . Dfirst("CLIENTE","Clientes", "ID_CLIENTE={$_GET["id_cliente"]} AND $where_c_coste"  ) ;
$titulo = $titulo_pagina;

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

$id_cliente=$_GET["id_cliente"];

$result=$Conn->query($sql="SELECT * FROM Clientes WHERE id_cliente=$id_cliente AND $where_c_coste");
$rs = $result->fetch_array(MYSQLI_ASSOC);

$cliente=$rs["CLIENTE"] ;  
 require_once("../clientes/clientes_menutop_r.php");


if ($id_cliente!=$rs["ID_CLIENTE"]) cc_die("ERROR EN DATOS. EL CLIENTE NO ES DE ESTA EMPRESA") ;

$sql_format_CIF=encrypt2("UPDATE `Clientes` SET `CIF` = REPLACE(REPLACE(REPLACE(CIF,' ',''),'-',''),'\n','')  "
        . " WHERE $where_c_coste AND ID_CLIENTE=$id_cliente ; ") ;
$spans_html['CIF'] = "<a  href='#'  onclick=\"js_href('../include/sql.php?code=1&sql=$sql_format_CIF')\"  "
        . "title='Da formato, quita espacios y simbolos' >formatear</a>" ;




 $titulo="CLIENTE {$rs["CLIENTE"]} " ;
  $updates=['*']  ;
  $id_cliente=$rs["ID_CLIENTE"] ;
  $tabla_update="Clientes" ;
  $id_update="ID_CLIENTE" ;
  $id_valor=$id_cliente ;

  $delete_boton=1 ;
  
  

?>


	
<div style="overflow:visible">	   
   

  <div id="main" class="mainc"> 
	  
 
 <?php require("../include/ficha.php"); ?>
   
  <!--// FIN     **********    FICHA.PHP-->

 
   
 </div>
<div class="right2">
    
<?php   // Iniciamos tabla_div  de ************ DOCUMENTOS *************
echo "<br><br>" ;
$tipo_entidad='cliente' ;
$id_entidad=$id_cliente;
$id_subdir=$id_cliente ;
$size='100px' ;

require("../menu/LRU_registro.php"); require("../include/widget_documentos.php");  

?>

</div>

<div class="right2">
	
  <?php 
// PROCEDIMIENTOS
$tipo_entidad='cliente' ;
require("../agenda/widget_procedimientos.php");
 
 ?>
	 
  </div>
    

<?php   // Iniciamos tabla_div  de ************ obras *************

$result=$Conn->query($sql="SELECT ID_OBRA,NOMBRE_OBRA,IMPORTE from OBRAS WHERE id_cliente=$id_cliente AND $where_c_coste ORDER BY fecha_creacion DESC LIMIT 20" );

//$formats["IMPORTE"] = "moneda" ; 
$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA", "", "formato_sub"] ;


//$titulo="OBRAS";
$titulo= "Obras ({$result->num_rows})" ;
$msg_tabla_vacia="No hay obras";

?>
	
<!--  <div class="right2"> -->
 <div class="right2">
	
<?php require("../include/tabla.php"); echo $TABLE ; ?>
	
<!--  </div> -->
 </div>
<?php   // Iniciamos tabla_div  de ************ PRESUPUESTOS *************

$result=$Conn->query($sql="SELECT ID_OFERTA,NOMBRE_OFERTA,FECHA,Importe_iva,Aceptado,Rechazado from Ofertas_View WHERE ID_CLIENTE=$id_cliente AND $where_c_coste ORDER BY FECHA DESC LIMIT 20" );

//$formats["IMPORTE"] = "moneda" ; 
$links["NOMBRE_OFERTA"]=["../estudios/oferta_cliente.php?id_oferta=", "ID_OFERTA", "", "formato_sub"] ;


//$titulo="OBRAS";
$titulo= "Presupuestos ({$result->num_rows})" ;
$msg_tabla_vacia="No hay presupuestos";

?>
	
<!--  <div class="right2"> -->
 <div class="right2">
	
<?php require("../include/tabla.php"); echo $TABLE ; ?>
	
<!--  </div> -->
 </div>
	
	

<?php  

$Conn->close();

?>
	 

</div>

                <!--</div>-->
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
