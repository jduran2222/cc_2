<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Subcontrato';

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

$id_subcontrato=$_GET["id_subcontrato"];
//$id_obra=$_GET["id_obra"];                            // PDTE, hay que activar esto y hacer los links pasando el id_obra 


$id_obra=Dfirst("id_obra", "Subcontratos_obra", "id_subcontrato=$id_subcontrato AND $where_c_coste") ;

 require_once("../obras/obras_menutop_r.php");
 //require("../proveedores/proveedores_menutop_r.php");
$result=$Conn->query($sql="SELECT id_subcontrato,id_obra,id_pof,id_proveedor,subcontrato,Importe_subcontrato,Condiciones, Observaciones,"
        . "Importe_cobro ,Importe_subcontrato,Margen,Importe_ejecutado,Porc_ej "
        . " ,RAZON_SOCIAL,CIF,f_subcontrato,NOMBRE_COMPLETO,Situacion, fecha_creacion, user FROM Subcontratos_todos_View WHERE id_subcontrato=$id_subcontrato AND $where_c_coste");

 $rs = $result->fetch_array(MYSQLI_ASSOC) ;

$titulo="SUBCONTRATO" ;
$updates=['subcontrato','Condiciones','Observaciones','f_subcontrato','id_proveedor','id_pof']; 

$id_subcontrato=$rs["id_subcontrato"] ;

$selects["id_proveedor"]=["ID_PROVEEDORES","filtro","ProveedoresF","../proveedores/proveedores_anadir.php" 
  ,"../proveedores/proveedores_ficha.php?id_proveedor=","id_proveedor"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
$selects["id_pof"]=["ID_POF","NOMBRE_POF","POF_lista","" 
  ,"../pof/pof.php?id_pof=","id_pof"," AND ID_OBRA=$id_obra "] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

$tabla_update="Subcontratos" ;
$id_update="id_subcontrato" ;
$id_valor=$id_subcontrato ;

$delete_boton=1;

// relleno con espacios los elementos del array vacíos  futura ARRAY_QUITA_VACIOS
foreach ($rs as $key => $value){  if (!$value) {$rs[$key]=' ';} }
$array_plantilla = $rs ;      // copiamos array para datos para la Generación de Documentos con PLANTILLAS HTML
//$array_plantilla["FECHA"] = cc_format($array_plantilla["FECHA"],'fecha') ;     

// fin $array_plantilla
 

?>
<div style="overflow:visible">	   
  <div id="main" class="mainc"> 
                
<?php
 
 
 
 require("../include/ficha.php");


?>
	
</div>
      <br><br><br>

    <div class="right2">
	

<?php 
// preparamos la TABLA para #GENERAR_DOC la pof_PDF
$sql="SELECT id,cantidad_max as Cantidad,  CONCAT('<b>',Concepto,'</b><br>', descripcion ) as Concepto, COSTE as Precio "
        . ",cantidad_max*COSTE as Importe"
        . " FROM Subcontratos_Web  WHERE id_subcontrato=$id_subcontrato AND $where_c_coste ORDER BY id ";
//echo $sql;
$result=$Conn->query($sql );

$sql_T="SELECT '' as a,'Suma' as a1,'' as a33,SUM(cantidad_max*COSTE) as Importe  FROM Subcontratos_Web  WHERE id_subcontrato=$id_subcontrato AND $where_c_coste" ;
//echo $sql;
$result_T=$Conn->query($sql_T );

$titulo='';
$msg_tabla_vacia="No hay";
require("../include/tabla.php");
//echo $TABLE ;
$array_plantilla["HTML_TABLA1"]=urlencode($TABLE) ;
// fin de datos para #GENERAR_DOC


$tipo_entidad='subcontrato' ;
$id_entidad=$id_subcontrato;
$id_subdir=$id_obra ;
$size='100px' ;

require("../menu/LRU_registro.php"); require("../include/widget_documentos.php");  
 ?>
	 
</div>


	
<?php            //  div SUBCONT. DETALLES  tabla.php

$sql="SELECT id,cantidad_max,  concepto, descripcion as concepto_TOOLTIP, precio_cobro, importe_cobro,COSTE,importe_sub,cantidad_suma,importe_ejec,Observaciones "
        . " FROM Subcontratos_Web  WHERE id_subcontrato=$id_subcontrato AND $where_c_coste ORDER BY id ";
//echo $sql;
$result=$Conn->query($sql );

$sql_T="SELECT '' as a,'Suma' as a1,'' as a3,SUM( importe_cobro ) as importe_cobro,''as a22 ,SUM( importe_sub ) as importe_sub,'' as a33,SUM(importe_ejec) as importe_ejec  FROM Subcontratos_Web  WHERE id_subcontrato=$id_subcontrato AND $where_c_coste" ;
//echo $sql;
$result_T=$Conn->query($sql_T );

$updates=['precio_cobro','cantidad_max','descripcion','Observaciones'] ;
//$links["concepto"] = ["../include/ficha_general.php?id=", "id_detalle",'', "formato_sub"] ;
//$links["concepto"] = ["../include/ficha_general.php?tabla=Subcontratos_View&id_update=id&id_valor=", "id",'ver Unidad Subcontratada (Usub)', 'formato_sub'] ;
$links["CONCEPTO"] = ["../proveedores/usub_ficha.php?id=", "id",'ver Unidad Subcontratada (Usub)', 'formato_sub'] ;
$links["nid"] = ["../proveedores/usub_ficha.php?id=", "id",'ver Unidad Subcontratada (Usub)', 'formato_sub'] ;


//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="Unidades Subcontratadas ($result->num_rows Usub)" ;
$msg_tabla_vacia="No hay ";

$tabla_update="Subcontrato_conceptos" ;
$id_update="id" ;
//$id_valor=$id_subcontrato ;

//$add_link=1;
$add_link['field_parent']='id_subcontrato';
$add_link['id_parent']=$id_subcontrato ;

$actions_row=[];
$actions_row["id"]="id";
$actions_row["delete_link"]="1";


?>
	

 <div class="mainc_100">
	
<?php require("../include/tabla.php"); echo $TABLE ; ?>
	
</div>	 
<!--              FIN pagos   -->	
	
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