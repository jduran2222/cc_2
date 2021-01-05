<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo_pagina="RV ficha. " . Dfirst("PRODUCCION","Prod_view", "ID_PRODUCCION={$_GET["id_produccion"]} AND $where_c_coste"  ) ;
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

$id_obra=$_GET["id_obra"];
$id_produccion=$_GET["id_produccion"];

 //require("../proveedores/proveedores_menutop_r.php");

echo '<br><br><br><br><br>';
 
  echo "<a class='btn btn-link noprint' href= '../obras/obras_prod_detalle.php?_m=$_m&id_obra=$id_obra&id_produccion=$id_produccion' "
          . " title='Ir al detalle la relaciones valoradas ' target='_blank'><i class='fas fa-list'></i> Detalle de Relación Valorada</a>" ;
 
 
 //echo "<pre>";
// $result=$Conn->query($sql="SELECT NOMBRE_OBRA,ID_PRODUCCION,ID_OBRA,PRODUCCION,F_certificacion,OPC_DEDUCIR,CERT_ANTERIOR , A_DEDUCIR,Observaciones,user,fecha_creacion FROM Prod_view WHERE ID_PRODUCCION=$id_produccion AND ID_OBRA=$id_obra AND $where_c_coste");
 $result=$Conn->query($sql="SELECT NOMBRE_OBRA,ID_PRODUCCION,ID_OBRA,PRODUCCION,F_certificacion,OPC_DEDUCIR,CERT_ANTERIOR , A_DEDUCIR,Observaciones"
         . ",Ej_Material,Valoracion,Val_iva_incluido,importe_final,user,fecha_creacion FROM Prod_view WHERE ID_PRODUCCION=$id_produccion AND ID_OBRA=$id_obra AND $where_c_coste");
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
//while ($a = $result->fetch_field()) {

//print_r ($rs);
//}
//echo "</pre>";
  $titulo="RELACIÓN VALORADA" ;
  

// usamos el sistema claves_db para este tooltips
//$tooltips["OPC_DEDUCIR"] = "OPCIÓN 1: Se deduce la Rel. valorada CERT_ANTERIOR en el resumen de Certificación   &#10;  \r\n OPCIÓN 2: Se deduce el importe del campo A_DEDUCIR" ;

  
$selects["CERT_ANTERIOR"]=["ID_PRODUCCION","PRODUCCION","Prod_view","../obras/prod_anadir_form.php","../obras/obras_prod_detalle.php?id_obra=$id_obra&id_produccion=","CERT_ANTERIOR","AND ID_OBRA=$id_obra"] ;   // datos para clave foránea
  
$formats["A_DEDUCIR"] = 'moneda' ; 
$formats["Ej_Material"] = 'moneda' ; 
$formats["Valoracion"] = 'moneda' ; 
$formats["Val_iva_incluido"] = 'moneda' ; 
  
   
$sql_F_certificacion=encrypt2("UPDATE `PRODUCCIONES` SET `F_certificacion` = NULL   WHERE ID_OBRA=$id_obra AND ID_PRODUCCION=$id_produccion ; ") ;
  
$spans_html['F_certificacion'] = "<a class='btn-link'  href='#'  onclick=\"js_href('../include/sql.php?code=1&sql=$sql_F_certificacion')\"  title='borra la fecha para que se imprima Fecha a la firma electrónica' >firma elect.</a>" ;
 
  
  
  
  
  $updates=['CERT_ANTERIOR','Observaciones','PRODUCCION','A_DEDUCIR','F_certificacion','OPC_DEDUCIR']  ;
//  $id_pago=$rs["id_remesa"] ;
  $tabla_update="PRODUCCIONES" ;
  $id_update="ID_PRODUCCION" ;
  $id_valor=$id_produccion ;
  $delete_boton=1 ;
  $boton_cerrar=1 ;
  

  
  

  
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?PHP require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      
 <div class="right2">
	
<?php 
//  WIDGET DOCUMENTOS 
$tipo_entidad='rel_valorada' ;
$id_entidad=$id_produccion ;
//$id_subdir=$id_cliente ;
$id_subdir=0 ;
$size='200px' ;
require("../menu/LRU_registro.php"); require("../include/widget_documentos.php");  

 ?>
	 
</div>	     
	
	
<?php  

$Conn->close();

?>
	 

</div>

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
