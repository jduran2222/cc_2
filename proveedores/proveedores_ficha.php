<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo_pagina="Prov " . Dfirst("PROVEEDOR","Proveedores", "ID_PROVEEDORES={$_GET["id_proveedor"]} AND $where_c_coste"  ) ;

//$titulo = 'Proveedor Ficha';
$titulo = $titulo_pagina;

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

$id_proveedor=$_GET["id_proveedor"];
 require_once("../proveedores/proveedores_menutop_r.php");
 
$result=$Conn->query($sql="SELECT * FROM Proveedores_View WHERE id_proveedores=$id_proveedor AND $where_c_coste");
$rs = $result->fetch_array(MYSQLI_ASSOC) ;
	
 $titulo= $rs["ID_PERSONAL"] ? "FICHA PROVEEDOR-NOMINA:<br>{$rs["PROVEEDOR"]}" : "PROVEEDOR:<b>{$rs["PROVEEDOR"]}</b>" ;
  //$updates=['NOMBRE_OBRA','NOMBRE_COMPLETO','GRUPOS','EXPEDIENTE', 'NOMBRE' ,'Nombre Completo', 'LUGAR', 'PROVINCIA', 'Presupuesto Tipo', 'Plazo Proyecto' ,'Observaciones']  ;
  $updates=["*"] ;
  $selects["ID_CLIENTE"]=["ID_CLIENTE","CLIENTE","Clientes"] ;   // datos para clave foránea
 // $selects["id_produccion_obra"]=["ID_PRODUCCION","PRODUCCION","Prod_view","../obras/prod_anadir_form.php","../obras/obras_prod_detalle.php?id_obra=$id_obra&id_produccion=","id_produccion_obra","AND ID_OBRA=$id_obra"] ;   // datos para clave foránea

$selects["id_concepto_auto"]=["ID_CONCEPTO","CONCEPTO","Conceptos_View","../proveedores/concepto_anadir.php?id_proveedor=$id_proveedor","../proveedores/concepto_ficha.php?id_concepto=","id_concepto_auto","AND ID_PROVEEDOR=$id_proveedor"] ;   // datos para clave foránea
$selects["id_cuenta_auto"]=["ID_CUENTA","CUENTA_TEXTO","CUENTAS"] ;  
//$selects["id_personal_nomina"]=["ID_PERSONAL","NOMBRE","PERSONAL"] ;    

$links["NOMBRE"] = ["../personal/personal_ficha.php?id_personal=", "ID_PERSONAL"] ;

$tooltips["id_concepto_auto"]="Concepto por defecto a usar para este Proveedor. Generalmente es -Gasto del Proveedor-" ;
$tooltips["id_cuenta_auto"]="Cuenta del Plan General Contable de España (PGC) a la que asociar por defecto los Conceptos de este Proveedor (opcional)" ;
$etiquetas["NOMBRE"]= ["Nombre del Personal","Ficha de Proveedor-Nómina. Está asociada a un Personal (empleado) para el pago de sus nóminas, notas de gastos..."] ;

if (($rs["ID_PROVEEDORES"] == getVar("id_proveedor_auto")) AND !$admin)
{ $updates=[] ;          // ANULA LA EDICION PARA QUE ESTE PROVEEDOR NO PUEDA SER CAMBIADO POR ERROR
}
  
//$id_obra=$rs["ID_PROVEEDORES"] ;
  $id_proveedor=$rs["ID_PROVEEDORES"] ;
  
  // si no existe el proveedor ABORTAMOS
  if (!$id_proveedor) 
  {die ("<BR><BR><BR><BR><h1>ERROR, PROVEEDOR NO ENCONTRADO</h1>" );         // FICHA NO ENCONTRADA. ABORTAMOS LA PAGINA
  }
  
  $tabla_update="Proveedores" ;
  $id_update="ID_PROVEEDORES" ;
  $id_valor= $id_proveedor  ;
  
  $delete_boton=1;
  
$links["TEL1"]=["tel:{$rs['TEL1']}", "","LLAMAR","html","<span class='glyphicon glyphicon-earphone'></span>"] ;

//$sql_format_IBAN=encrypt2("UPDATE `Proveedores` SET `IBAN` = REPLACE(`IBAN`,' ','')  WHERE $where_c_coste AND ID_PROVEEDORES=$id_proveedor; ") ;

        
$COD = substr($rs['IBAN'],4,4);      
$BIC= $COD ?   DFirst('BIC' ,'Proveedores',"  SUBSTR(IBAN,5,4)='$COD' AND  BIC<>''  ") : '' ;

// quitamos espacios, guiones y saltos de linea del IBAN
$sql_format_CIF=encrypt2("UPDATE `Proveedores` SET `CIF` = REPLACE(REPLACE(REPLACE(CIF,' ',''),'-',''),'\n','')   WHERE $where_c_coste AND ID_PROVEEDORES=$id_proveedor ; ") ;
$sql_format_IBAN=encrypt2("UPDATE `Proveedores` SET `IBAN` = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(IBAN,' ',''),'-',''),'\r\n',''),'.',''),'\n',''),CHAR(13),''),CHAR(10),'')   WHERE $where_c_coste AND ID_PROVEEDORES=$id_proveedor ; ") ;
//$sql_format_IBAN=encrypt2("UPDATE `Proveedores` SET `IBAN` = REGEXP_REPLACE(IBAN,'/ |-|\\r|\\n|\\r\\n|./,'')   WHERE $where_c_coste AND ID_PROVEEDORES=$id_proveedor ; ") ;
//$sql_format_IBAN=encrypt2("UPDATE `Proveedores` SET `IBAN` = REGEXP_REPLACE(IBAN,'es','in')   WHERE $where_c_coste AND ID_PROVEEDORES=$id_proveedor ; ") ;
//$sql_format_IBAN=encrypt2("UPDATE `Proveedores` SET `IBAN` =VERSION()   WHERE $where_c_coste AND ID_PROVEEDORES=$id_proveedor ; ") ;
$sql_format_email=encrypt2("UPDATE `Proveedores` SET `email` = REPLACE(email,' ','')  WHERE $where_c_coste AND ID_PROVEEDORES=$id_proveedor ; ") ;
$sql_format_email_pagos=encrypt2("UPDATE `Proveedores` SET `email_pagos` = REPLACE(email_pagos,' ','')  WHERE $where_c_coste AND ID_PROVEEDORES=$id_proveedor ; ") ;
$sql_calcular_BIC=encrypt2("UPDATE `Proveedores` SET `BIC` = '$BIC'   WHERE $where_c_coste AND ID_PROVEEDORES=$id_proveedor ; ") ;


//echo "<BR><BR><BR><BR>ORDEN:" .  ord(substr($rs["IBAN"],4,1));

// $href="../include/sql.php?code=1&sql=$sql_format_CIF"   ;
$spans_html['CIF'] = "<a class='btn-link'  href='#'  onclick=\"js_href('../include/sql.php?code=1&sql=$sql_format_CIF')\"  title='Da formato, quita espacios y simbolos' >formatear</a>" ;
//$spans_html['CIF'] = "<a class='btn-link'  href='#'  onclick=\"js_href('$href')\"  title='Da formato, quita espacios y simbolos' >formatear</a>" ;
$spans_html['IBAN'] = "<a class='btn-link' href='#'  onclick=\"js_href('../include/sql.php?code=1&sql=$sql_format_IBAN')\" title='Da formato, quita espacios y simbolos' >formatear</a>" ;
$spans_html['email'] = " <a class='btn-link'  href='#'  onclick=\"js_href('../include/sql.php?code=1&sql=$sql_format_email')\" title='Da formato, quita espacios y simbolos' >formatear</a>" ;
$spans_html['email_pagos'] = " <a class='btn-link'   href='#'  onclick=\"js_href('../include/sql.php?code=1&sql=$sql_format_email_pagos')\" title='Da formato, quita espacios y simbolos' >formatear</a>" ;
$spans_html['BIC'] = "<a class='btn-link'  href='#'  onclick=\"js_href('../include/sql.php?code=1&sql=$sql_calcular_BIC')\" title='Intenta calcular el BIC del IBAN' >calcular BIC</a>" ;


//  $links["TEL1"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "TEL1", "", "formato_sub"] ;

  
 
  if (Dfirst("ID_FRA_PROV","FACTURAS_PROV", "ID_PROVEEDORES=$id_proveedor"))    //  NO HAY DETALLES, podemos cambiar de Proveedor o borrrar el Vale (CAMBIAR A Dcount(id detalles)
  {
    $disabled_delete=1;
    $delete_title="No es posible eliminar un proveedor que tenga facturas" ;
  }
   
echo   "<br><br><br><br><br><a class='btn btn-link noprint' href='../proveedores/concepto_anadir.php?id_proveedor=$id_proveedor' target='_blank' title='Crea un Concepto o artículo nuevo de este proveedor'>"
        . "<i class='fas fa-plus-circle'></i> Concepto/artículo nuevo</a>" ; // BOTON AÑADIR CONCEPTO
    
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc_50"> 
      <!--<a target="_blank" class="btn btn-link btn-xs"  href="../include/tabla_general.php?url_enc=<?php echo encrypt2("sql=select DISTINCT  SUBSTR( IBAN, 5,4) AS COD,  BIC from Proveedores WHERE BIC<>'' ORDER BY COD"); ?>" >Codigos Bancos/BIC</a>-->
      
      
  <?PHP 
  
  
  require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
 <div class="right2">
	
<?php            //  div documentos  

$tabla_expandida=1;
$tipo_entidad='proveedores' ;
$id_entidad=$id_proveedor;
$id_subdir=$id_proveedor ;
$size='400px' ;

require("../include/widget_documentos.php");

//$sql="SELECT id_documento, documento FROM Documentos  WHERE tipo_entidad='proveedor_doc' AND id_entidad=$id_proveedor AND $where_c_coste ORDER BY id_documento DESC LIMIT 5 ";
//
////echo $sql;
//$result=$Conn->query($sql );
//
//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
//$msg_tabla_vacia="No hay";

?>
	
<!--  <div class="right2"> -->


<!--              FIN DOCUMENTOS   -->
 </div>
	
      
<?php  





///////////////  ULTIMAS FACTURAS DE PROVEEDOR  
//
//
//
//$sql="SELECT id_pago,f_vto,PROVEEDOR,id_proveedor,observaciones,importe,ingreso FROM Pagos_View WHERE  id_cta_banco=$id_cta_banco AND conc=0 AND importe='$importe' AND ingreso='$ingreso') AND $where_c_coste ";
$sql="SELECT ID_FRA_PROV,ID_PROVEEDORES,ID_OBRA,FECHA,N_FRA,NOMBRE_OBRA,IMPORTE_IVA,firmado,conc,pagada,cobrada,path_archivo as pdf,Observaciones "
        . " FROM Fras_Prov_View WHERE ID_PROVEEDORES=$id_proveedor AND $where_c_coste ORDER BY FECHA  DESC LIMIT 20 " ;
$sql_T="SELECT '' as a, '' as aa, '' as aaa, SUM(IMPORTE_IVA) as IMPORTE_IVA,'' as a1, '' as aa1, '' as aaa1   FROM Fras_Prov_View WHERE ID_PROVEEDORES=$id_proveedor AND $where_c_coste ORDER BY FECHA  DESC LIMIT 20 " ;

//echo $sql;
$result=$Conn->query($sql );
$result_T=$Conn->query($sql_T );

$updates=[];
//$updates=['MOTIVO', 'F_solicitud', 'Observaciones'] ;
//  $tabla_update="Avales" ;
//  $id_update="ID_AVAL" ;

//$formats["f_vto"]='fecha';
$formats["IMPORTE_IVA"]='moneda';
$formats["conc"]='semaforo_OK';
$formats["pagada"]='semaforo_OK';
$formats["cobrada"]='semaforo_OK';
$formats["Observaciones"]='textarea';
$formats["pdf"]='pdfDdownload';
$formats["firmado"]='firmado';
//$formats["FECHA"]='pdfDdownload';

$etiquetas["conc"]='cargada';


$links["N_FRA"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV", "ver factura", "formato_sub"] ;
$links["FECHA"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV", "ver factura", "formato_sub"] ;
$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;

// accion de CONCILIAR el MOV_BANCO con el ID_PAGO
//$onclick1_VARIABLE1_="id_pago" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
////$onclick1_VARIABLE2_="" ;     // idem
//
//$sql_insert="INSERT INTO PAGOS_MOV_BANCOS ( id_mov_banco,id_pago ) " . 
//          " VALUES ( '$id_mov_banco', _VARIABLE1_ );" ;
//
//$actions_row["onclick1_link"]="<a class='btn btn-link btn-xs' title='concilia el mov.banco con el Pago' href=\"../include/sql.php?sql=base64_encode($sql_insert) \" >conciliar</a> ";
//$actions_row["id"]="id_pago";
//  

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
//$titulo="Posibles REMESAS, PAGOS, COBROS O TRASPASOS a conciliar " ;


$titulo="Ultimas facturas " ;
$msg_tabla_vacia="No hay";

//echo "<div id='main' class='mainc' style='background-color:orange'>" ;
echo "<div  class='mainc_50' style='background-color:pink;float:left;padding:0 20px;' >" ;
echo   "<a class='btn btn-link noprint' href='../proveedores/factura_proveedor_anadir.php?_m=$_m&id_proveedor=$id_proveedor' target='_blank' ><i class='fas fa-plus-circle'></i> factura nueva</a>" ; // BOTON AÑADIR FACTURA
     
//echo "<a class='btn btn-primary' target='_blank' href= '../bancos/aval_anadir.php?id_linea_avales=$id_linea_avales' ><i class='fas fa-plus-circle'></i>Añadir Aval</a><br>" ;

require("../include/tabla.php"); echo $TABLE ; 
echo "<br>"  ;
echo "</div>" ;



?>
	 

      
      
      
      
<?php  

$Conn->close();

?>
	 

</div>

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');