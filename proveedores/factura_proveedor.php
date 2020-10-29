<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$id_fra_prov=$_GET["id_fra_prov"];
 
$sql="SELECT CONCAT(PROVEEDOR,'-',N_FRA) as id_titulo_pagina,   id_fra_prov AS Nid_fra_prov, ID_FRA_PROV,ID_PROVEEDORES,"
         . "'Metadatos factura' as EXPAND,  metadatos , '-' AS FIN_EXPAND,"
         . "N_FRA,FECHA,Base_Imponible,iva,IMPORTE_IVA  , grupo, Observaciones "
         . ", 0 as Registrada,conc,importe_vales as importe_cargado,pdte_conciliar,pagada,importe_pagado,pdte_pago,id_fra_prov_abono,n_fra_prov_abono_ppal,id_fra_prov_abono_ppal,cobrada"
        . ",user,Fecha_Creacion, PROVEEDOR "
         . "FROM Fras_Prov_View WHERE id_fra_prov=$id_fra_prov AND $where_c_coste";

//$sql="SELECT CONCAT(PROVEEDOR,'-',N_FRA) as id_titulo_pagina,   id_fra_prov AS Nid_fra_prov, ID_FRA_PROV,ID_PROVEEDORES,"
//         . "'Metadatos factura' as EXPAND,  metadatos , '-' AS FIN_EXPAND,"
//         . "N_FRA,FECHA,Base_Imponible,iva,IMPORTE_IVA "
//         . " ,  Observaciones "
//         . ", 0 as Registrada,conc,importe_vales as importe_cargado,pdte_conciliar,pagada,importe_pagado,pdte_pago,cobrada,user,Fecha_Creacion, PROVEEDOR "
//         . "FROM Fras_Prov_View WHERE id_fra_prov=$id_fra_prov AND $where_c_coste";
 


//$sql="SELECT * FROM Fras_Prov_View WHERE id_fra_prov=$id_fra_prov AND $where_c_coste";
 
//echo $sql;
$result=$Conn->query($sql);
$rs = $result->fetch_array(MYSQLI_ASSOC) ; 

$titulo_pagina="Fra. " . $rs["id_titulo_pagina"] ;

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

 //require("../proveedores/proveedores_menutop_r.php");

?>

 <!--<div style=" overflow: scroll;">-->	   
 <div >	   
 <div id="main" class="mainc_40"> 
     <br><a class="btn btn-link noprint" title="imprimir" href=#  onclick="window.print();"><i class="fas fa-print"></i> Imprimir</a>
 
  <!--<a class='btn btn-link btn-xs' href= '../proveedores/proveedores_anadir.php' >proveedor nuevo</a>-->
    
    
  
<?php  

// DATOS   FICHA . PHP

  
 
$titulo="FACTURA DE PROVEEDOR" ;


//  $links["RAZON_SOCIAL"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;

$ocultos=['PROVEEDOR'];
$updates=[ 'ID_PROVEEDORES',  'N_FRA','FECHA','IMPORTE_IVA','iva', 'FECHA_ENTRADA' , 'grupo' , 'Observaciones', 'id_fra_prov_abono']  ;

//  $not_id_var=['RAZON_SOCIAL','CIF','ID_FRA_PROV'] ;

$selects["ID_PROVEEDORES"]=["ID_PROVEEDORES","filtro","ProveedoresF","../proveedores/proveedores_anadir.php?id_fra_prov=$id_fra_prov" 
  ,"../proveedores/proveedores_ficha.php?id_proveedor=","ID_PROVEEDORES"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

$tooltips["ID_PROVEEDORES"]='Buscar por Proveedor o CIF' ;
$id_proveedor=$rs["ID_PROVEEDORES"] ;

$requeridos["ID_PROVEEDORES"] =  (getvar("id_proveedor_auto")==$rs["ID_PROVEEDORES"] )    ; // Campo requerido. Condición: ID_PROVEEDOR<> getvar id_prov_auto
$requeridos["N_FRA"] =  ( $rs["N_FRA"]=='') ; // Campo requerido. Condición: ID_PROVEEDOR<> getvar id_prov_auto
$requeridos["IMPORTE_IVA"] = ($rs["IMPORTE_IVA"]==0)  ; // Campo requerido. Condición: ID_PROVEEDOR<> getvar id_prov_auto
$requeridos["FECHA"] = ($rs["FECHA"]=='' OR $rs["FECHA"]== '0000-00-00 00:00:00')  ; // Campo requerido. Condición: ID_PROVEEDOR<> getvar id_prov_auto

$factura_registrada= ! in_array ( 1, $requeridos ) ; // la factura no está totalmente REGISTRADA si algún requerimiento no está cumplido

$rs["Registrada"]= $factura_registrada ;      // rellenamos el valor del campo que metimos en SQL para completar la ficha
$formats["Registrada"]= 'semaforo_txt_REGISTRADA' ;
//  $formats["metadatos"]= 'textarea_30' ;
//  $tooltips["metadatos"]= $rs["metadatos"] ;

// si no está registrada intentamos encontrar sus datos en los metadatos
// patterns
//$patrones['cif']= "~\s([A-z])\s?[- \.]?\s?(\d{8})\s|(\d{8}[A-z])|([A-z])\s?[- \.]?\s?(\d{2})\s?[- .]\s?(\d{3})\s?[- .]\s?(\d{3})|(\d{2})\s?[- .]\s?(\d{3})\s?[- .]\s?(\d{3})\s?[- .]\s?([A-z])~" ;
$patrones['cif']= "~\s([A-z])\s?[- \.]?\s?(\d{8})\s|(\d{8}[A-z])|([A-z])\s?[- \.]?\s?(\d{2})\s?[- \.]\s?(\d{3})\s?[- \.]\s?(\d{3})"
                                                        . "|(\d{2})\s?[- \.]?\s?(\d{3})\s?[- \.]?\s?(\d{3})\s?[- \.]?\s?([A-z])~" ;
$patrones['fecha']=  "~\s(\d{2})\s?([-])\s?(\d{2})\s?([-])\s?(\d{4}|\d{2})\s|\s(\d{2})\s?([ ])\s?(\d{2})\s?([ ])\s?(\d{4})\s"
                . "|(\d{2})\s?([\/])\s?(\d{2})\s?([\/])\s?(\d{4}|\d{2})\s|\s(\d{2})\s?([.])\s?(\d{2})\s?([.])\s?(\d{4}|\d{2})\s~";
$patrones['importe']= "~(\d{1,3}?)\s?\.?\s?(\d{1,3})\s?([\,\.])\s?(\d{2})\s(€)?~"  ;
$patrones['email']="/[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/"   ;
//$patrones['iban']="/(ES\d\d)\s?(\d{4})\s?(\d{4})\s?(\d{4})\s?(\d{4})\s?(\d{4})/"       ;
$patrones['iban']="~(ES\d\d)\s?[-]?\s?(\d{4})\s?[-]?\s?(\d{4})\s?[-]?\s?(\d{4})\s?[-]?\s?(\d{4})\s?[-]?\s?(\d{4})|(ES\d\d)\s?(\d{4})\s?(\d{4})\s?(\d{2})\s?(\d{10})~"       ;
//$patrones['iban']="~(ES\d\d)\s?(\d{4})\s?(\d{4})\s?(\d{2})\s?(\d{10})~"       ;
$patrones['tel']= "~\s(\d{9})\s|\s(\d{3})\s?([- .])\s?(\d{3})\s?([- .])\s?(\d{3})\s|\s(\d{3})\s?([- .])\s?(\d{2})\s?([- .])\s?(\d{2})\s?([- .])\s?(\d{2})\s~";

 
if (!$factura_registrada AND $_SESSION["admin"])
//if (1)
{
    echo 'SOLO ADMIN:<BR>';
    $a_cif=[] ;
    preg_match_all($patrones['cif'], $rs["metadatos"], $a_cif) ;
    echo 'CIF encontrados<br><pre>';
    print_r($a_cif[0]);
    echo '</pre>';

    $a_fechas=[] ;
    preg_match_all($patrones['fecha'], $rs["metadatos"], $a_fechas) ;
    echo 'fechas encontrados<br><pre>';
    print_r($a_fechas[0]);
    echo '</pre>';
    
    $a_importes=[] ;
    preg_match_all( $patrones['importe'], $rs["metadatos"], $a_importes) ;
    echo 'importes encontrados<br><pre>';
    print_r($a_importes[0]);
    echo '</pre>';
    
    $a_emails=[] ;
    preg_match_all($patrones['email'], $rs["metadatos"], $a_emails) ;
    echo 'email encontrados<br><pre>';
    print_r($a_emails[0]);
    echo '</pre>';
    
    $a_ibans=[] ;
    preg_match_all($patrones['iban'], $rs["metadatos"], $a_ibans) ;
    echo 'iban encontrados<br><pre>';
    print_r($a_ibans[0]);
    echo '</pre>';
    
    $a_tels=[] ;
    preg_match_all($patrones['tel'], $rs["metadatos"], $a_tels) ;
    echo 'Tels encontrados<br><pre>';
    print_r($a_tels[0]);
    echo '</pre>';
    
}

// proceso METADATOS
  
//$palabras=explode(" ","FACTURA CLIENTE TOTAL IMPORTE FECHA SUMA BASE IMPONIBLE NUM FRA CIF IBAN CCC NUMERO LIQUIDO PERCIBIR"); 
//
////ILUMINAMOS EN NEGRITA LAS PALABRAS
//foreach ($palabras as $palabra) {  
////  $rs["metadatos"] = preg_replace("/(".trim($palabra).")/i","<font color='green'>$1</font>",$rs["metadatos"]);
//  }

////ILUMINAMOS EN VERDE LAS PALABRAS RESERVADAS
$rs["metadatos"] = preg_replace("/(FACTURA)|(CLIENTE)|(TOTAL)|(IMPORTE)|(FECHA)|(SUMA)|(BASE)|(IMPONIBLE)"
        . "|(NUM)|(FRA)|(CIF)|(IBAN)|(CCC)|(NUMERO)|(LIQUIDO)|(PERCIBIR)/i"
        ,"<font color='green'>$1$2$3$4$5$6$7$8$9$10$11$12$13$14$15$16$17$18$19$20</font>",$rs["metadatos"]);

//$patrones = [$patron_cif , $patron_fecha ,  $patron_tel  ,$patron_importe  , $patron_email , $patron_iban ]; 
       
$replaces = " <span style='color:blue;cursor:pointer;' "
        . " onclick=\"copyToClipboard('$1$2$3$4$5$6$7$8$9$10$11$12$13$14$15$16$17$18$19$20');this.style.color = 'grey'\" >$1$2$3$4$5$6$7$8$9$10$11$12$13$14$15$16$17$18$19$20</span> "; 

//HACEMOS LA SUSTITUCION
$rs["metadatos"] = preg_replace($patrones,$replaces,$rs["metadatos"]);
  
// fin metadatos  



  
$tabla_update="FACTURAS_PROV" ;
$id_update="ID_FRA_PROV" ;
$id_valor=$id_fra_prov ;

$n_fra=$rs["N_FRA"] ;  
$proveedor=$rs["PROVEEDOR"] ;  
$importe_iva=$rs["IMPORTE_IVA"] ;
$conc=$rs["conc"] ;
$pdte_conciliar=$rs["pdte_conciliar"] ;
$pagada=$rs["pagada"] ;
$cobrada=$rs["cobrada"] ;
$pdte_pago=round($rs["pdte_pago"],2) ;

$formats["conc"]= 'semaforo_txt_CARGADA A OBRA' ;
$formats["pagada"]= 'semaforo_txt_PAGADA' ;
$formats["cobrada"]= 'semaforo_txt_COBRADA POR PROVEEDOR' ;
//  $formats["FECHA"]= '' ;

$selects["id_fra_prov_abono"]=["ID_FRA_PROV","N_FRA","Fras_Prov_Listado","../proveedores/factura_proveedor_anadir.php?id_proveedor=$id_proveedor" 
  ,"../proveedores/factura_proveedor.php?id_fra_prov=","id_fra_prov_abono","AND ID_PROVEEDORES=$id_proveedor AND IMPORTE_IVA<0"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
 $selects[ "id_fra_prov_abono" ]["valor_null"] =  0;
 $selects[ "id_fra_prov_abono" ]["valor_null_title"] =  'desvincular abono'; 
 $selects[ "id_fra_prov_abono" ]["href"] =  "../proveedores/fra_prov_abono.php?id_fra_prov=$id_fra_prov"; 


  
//$links["id_fra_prov_abono_ppal"]=["ID_FRA_PROV","N_FRA","Fras_Prov_Listado"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
if ($rs["id_fra_prov_abono_ppal"]) {
  $links["n_fra_prov_abono_ppal"]=["../proveedores/factura_proveedor.php?id_fra_prov=", "id_fra_prov_abono_ppal", "ver Factura donde se descuenta este abono", "formato_sub"] ;
}else
{
  $ocultos[]= "n_fra_prov_abono_ppal" ;
}    
 
 
 
//  BOTON SPAN EN FICHA.PHP  INLINE   ULTIMA_VERSION
$sql_span=encrypt2("UPDATE `$tabla_update` SET `iva` = 0   WHERE $id_update=$id_valor ; ") ;
//$spans_html['iva'] = "<a class='btn-link noprint' target='_blank' title='cambia Iva al 0%' href='../include/sql.php?code=1&sql=$sql_span' >0%</a>" ;
$spans_html['iva'] = "<a class='btn-link noprint' title='cambia Iva al 0%'  onclick=\"js_href('../include/sql.php?code=1&sql=$sql_span' ) \" >0%</a>" ;
  
//  BOTON SPAN EN FICHA.PHP  INLINE   ATENCION !!! HAY QUE HACER SEGURO EL SITIO CONSTRUWIN.SW24.ES
//$sql_span=encrypt2("UPDATE `$tabla_update` SET `iva` = 0   WHERE $id_update=$id_valor ; ") ;
//$spans_html['IMPORTE_IVA'] = "<a class='btn-link'  title='' href=#  onclick=\"alert(win2dow.clipboardData.getData('Text'));\" >PASTE</a>" ;
//$spans_html['IMPORTE_IVA'] = "<a class='btn-link'  title='' href=#  onclick=\"$('#editableDiv').trigger('paste');\" >PASTE</a>" ;
//$spans_html['IMPORTE_IVA'] = "<a class='btn-link'  title='' href=#  onclick=\"document.dispatchEvent('paste');\" >PASTE</a>" ;
//$spans_html['IMPORTE_IVA'] = "<a class='btn-link'  title='' href=#  onclick=\"paste2();\" >PASTE</a>" ;
//$spans_html['IMPORTE_IVA'] = "<a class='btn-link'  title='' href=#  onclick=\"alert( navigator.clipboard.readText() ) ;\" >PASTE</a>" ;
//$spans_html['IMPORTE_IVA'] = "<a class='btn-link'  title='' href=#  onclick=\"alert('editableDiv');\" >PASTE</a>" ;

?>
<!--<div id='editableDiv' contenteditable='true'>Paste</div>
<textarea id="textarea" onclick="paste2()"></textarea>-->

<script> 
      
//function handlePaste (e) {
//		var clipboardData, pastedData;
//
//		// Stop data actually being pasted into div
//		e.stopPropagation();
//    e.preventDefault();
//
//		// Get pasted data via clipboard API
//    clipboardData = e.clipboardData || window.clipboardData;
//    pastedData = clipboardData.getData('Text');
//    
//    // Do whatever with pasteddata
//    alert(pastedData);
//}
//
//document.getElementById('editableDiv').addEventListener('paste', handlePaste);      
//document.addEventListener('paste', function (event) {
//  var clipText = event.clipboardData.getData('Text');alert(clipText);
//});
//async function paste() {
//  const text = await navigator.clipboard.readText();
////  input.value = text;
//alert(text) ;
//}
//async function paste2() {
//  const text = await navigator.clipboard.readText();
////  input.value = text;
// document.getElementById('textarea').value = text;
////alert(text) ;
////return document.getElementById('textarea').value ;
//return text ;
//}

//document.querySelector('#paste').addEventListener('click', () => {
//  navigator.clipboard.readText()
//    .then(text => {
//      document.querySelector('#out').value = text;
//      ChromeSamples.log('Text pasted.');
//    })
//    .catch(() => {
//      ChromeSamples.log('Failed to read from clipboard.');
//    });
//});
  </script>    
         
 <?php       


  
$formats["pdte_conciliar"]= 'moneda' ;
$formats["pdte_pago"]= 'moneda' ;

$delete_boton=1;
if (Dfirst("ID_VALE","VALES","ID_FRA_PROV=$id_fra_prov") )         // simulamos un OR
{        
$disabled_delete=1;
$delete_title="Para eliminar la Factura previamente elimnine sus Albaranes, sus Pagos y Documentos escaneados" ;
}elseif (Dfirst("id_pago","FRAS_PROV_PAGOS","id_fra_prov=$id_fra_prov"))
{
$disabled_delete=1;
$delete_title="Para eliminar la Factura previamente elimnine sus Albaranes , sus Pagos y Documentos escaneados" ;

}        



require("../include/ficha.php"); 



?>

  <!--// FIN     **********    FICHA.PHP-->
</div>



<?php          // POSIBLE FACTURA DUPLICADA

$id_fra_prov_duplicada=Dfirst("ID_FRA_PROV","Fras_Prov_Listado", " $where_c_coste AND ID_FRA_PROV<>$id_fra_prov AND ID_PROVEEDORES={$rs["ID_PROVEEDORES"]} ". 
                                                                  "AND FECHA='{$rs["FECHA"]}' AND IMPORTE_IVA=$importe_iva AND NOT PROVEEDOR='-proveedor pdte registrar-'  " )  ;
                                                                  // AND NOT PROVEEDOR=='-proveedor pdte registrar-'              (PDTE AÑADIR)

if ($id_fra_prov_duplicada)
{
    echo "<div class='right2' style='background-color: orange' >" ;

    echo "<h1 style='color:red'>¡¡OJO FACTURA DUPLICADA!!</h1>" ;
    echo  "<a href=\"../proveedores/factura_proveedor.php?_m=$_m&id_fra_prov=$id_fra_prov_duplicada\" target='_blank' title='ver posible factura duplicada de ésta'> ver fra duplicada</a>" ;

    echo "</div>" ;   
}   

?>
         

     
     
<!--  <div class="right2"> -->
 <div class="right2_50"  >      

	
<?php            // ----- div VALES CONCILIADOS Y CARGOS A OBRA tabla.php   -----

// <div de CARGAR A OBRA y otros DIV una vez rellena la factura_prov
if ($factura_registrada )     // si ID_PROVEEDOR es diferente a <proveedor pted definir> pintamos el DIV CARGAR A OBRA
{    


$sql="SELECT ID_VALE,FECHA, ID_OBRA, NOMBRE_OBRA, REF,importe,path_archivo as pdf , Observaciones FROM Vales_view  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ORDER BY FECHA ";
//echo $sql;
$result=$Conn->query($sql );

$sql="SELECT '' as a,'' as b,'Suma' as c, SUM(importe) as importe, '' as c1 FROM Vales_view  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ";
//echo $sql;
$result_T=$Conn->query($sql );

$formats["FECHA"]='fecha';
$formats["importe"]='moneda';
$formats["pdf"]='pdf_50';

$links["FECHA"] = ["albaran_proveedor.php?id_vale=", "ID_VALE", "ver Albarán", "formato_sub"] ;
$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

$aligns["importe"] = "right" ;
$aligns["Pdte_conciliar"] = "right" ;
//$aligns["Importe_ejecutado"] = "right" ;

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
//$num_vales=Dfirst("COUNT(ID_VALE)","VALES", "ID_FRA_PROV=$id_fra_prov") ;
$num_vales= $result->num_rows;


$titulo="<span>Albaranes conciliados ($num_vales <span class='glyphicon glyphicon-tags'></span>):</span>" ; 

if ($conc AND ($num_vales>0))              // está conciliado y hay albaranes
{
 $titulo.="<br><span style='color:green;'>CARGADA A OBRA</span>" ; 
 $tabla_expandida=0 ;     // contraemos los Vales conciliados
}
else
{
    // creamos el <SELECT> para cargar a Obra   

//    $link_conciliar="<div class='form-group'>" ;
    $link_conciliar="<div >" ;
//    $link_conciliar.="<label for='id_obra'>Cargar a obra:</label>" ;
    $link_conciliar.="<p>Cargar a obra:</p>" ;
//    $link_conciliar.="<select class='form-control' id='id_obra' style='width: 50%;'>" ;
    $link_conciliar.="<select  id='id_obra' style='width: 60%; '>" ;
    $link_conciliar.=DOptions_sql("SELECT ID_OBRA,NOMBRE_OBRA FROM OBRAS WHERE activa=1  AND $where_c_coste ORDER BY NOMBRE_OBRA ") ;
    $link_conciliar.="  </select>" ;
    $link_conciliar.=" <a class='btn btn-warning btn-xs' href='#'  onclick='cargar_a_obra_href($id_fra_prov);location.reload();'>Cargar</a>" ;
    $link_conciliar.="</div>" ;


 $pdte_conciliar_txt=cc_format($pdte_conciliar,'moneda') ;   
// $titulo.="<span style='font-weight: bold;color:red;'>NO CARGADA (Pdte:$pdte_conciliar_txt)</span>" ;   
 $titulo.="<br><small><span style='color:red;'>NO CARGADA (Pdte:$pdte_conciliar_txt)</span></small>" ;   
 $add_link_html=$link_conciliar ;

}


$updates=['REF', 'Observaciones']  ;
$tabla_update="VALES" ;
$id_update="ID_VALE" ;
$actions_row=[];
$actions_row["id"]="ID_VALE";
$actions_row["delete_link"]="1";




// accion de DESCONCILIAR el ALBARAN (vale) de la FRA_PROV
$onclick1_VARIABLE1_="ID_VALE" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
//$onclick1_VARIABLE2_="" ;     // idem

 $sql_update="UPDATE `VALES` SET `ID_FRA_PROV` = NULL  " 
         ."WHERE  ID_VALE=_VARIABLE1_ ; " ;
 
 $sql_update=encrypt2($sql_update) ;
 
//$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs noprint' target='_blank' title='Desconcilia el ALBARAN  a la factura' href=\"../include/sql.php?code=1&variable1=_VARIABLE1_&sql=$sql_update \" >desconciliar</a> ";
$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs noprint' target='_blank' title='Desconcilia el ALBARAN  a la factura' "
        . " onclick='js_href(\"../include/sql.php?code=1&variable1=_VARIABLE1_&sql=$sql_update \" )' >desconciliar</a> ";
    
    
$msg_tabla_vacia="No hay albaranes cargados a obra en esta factura";

 require("../include/tabla.php"); echo $TABLE ; //  VALES 


 
?>
	 
</div>

 <div class="right2_50" style="background-color: lightgreen" >

 <?php            // ----- div VALES PDTE CONCILIAR tabla.php   -----

//$num_vales=Dfirst("COUNT(ID_VALE)","VALES", "ID_FRA_PROV=$id_fra_prov") ;               // ANULADO POR ESTAR REPETIDO (juand, 16-5-2019)

//if (!($conc AND ($num_vales>0)))      // no está Conciliado o no tiene Albaranes aún

//$tabla_expandida  =  (!($conc AND ($num_vales>0)))  ;  

 $sql_update="UPDATE `VALES` SET `ID_FRA_PROV` = '$id_fra_prov' WHERE  ID_VALE IN _VARIABLE1_ ; " ;
//$sql_delete= "DELETE FROM `PAGOS` WHERE  id_pago IN _VARIABLE1_ ; "  ;
 
$href='../include/sql.php?sql=' . encrypt2($sql_update)  ;    

//$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' target='_blank' title='concilia el ALBARAN  a la factura' onclick='js_href(\"../include/sql.php?code=1&variable1=_VARIABLE1_&sql=$sql_update \" )' >conciliar</a> ";

$add_link_html= "<a class='btn btn-warning btn-xs noprint' href='#' "
     . " onclick=\"js_href('$href' ,'1','' ,'table_selection_IN()' )\"   "
     . "title='Conciliar los albaranes seleccionados con la factura' >conciliar seleccionados</a>" ;
      
 
 
 
 $tabla_expandida  =  0  ;  // provisionalmente lo quitamos, resulta engorroso y confuso
    
$sql="SELECT ID_VALE,FECHA, ID_OBRA, NOMBRE_OBRA, REF,importe,path_archivo as pdf  FROM Vales_view "
        . " WHERE ID_PROVEEDORES=$id_proveedor AND ISNULL(ID_FRA_PROV) AND $where_c_coste AND FECHA>='2017-01-01' ORDER BY FECHA DESC  ";
$col_sel="ID_VALE";
//echo $sql;
$sql_T="SELECT '' as a2,'' as a3,'Total',SUM(importe) as importe  FROM Vales_view "
        . " WHERE ID_PROVEEDORES=$id_proveedor AND ISNULL(ID_FRA_PROV) AND $where_c_coste AND FECHA>='2017-01-01'  ";
//echo $sql;
$result=$Conn->query($sql );
$result_T=$Conn->query($sql_T );
$importe_pdte_conc=dfirst('SUM(importe)', "Vales_view","ID_PROVEEDORES=$id_proveedor AND ISNULL(ID_FRA_PROV) AND $where_c_coste AND FECHA>='2017-01-01'") ;

//$sql="SELECT '' as a,'' as b,'' as c, SUM(importe) as importe FROM Vales_view  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ";
////echo $sql;
//$result_T=$Conn->query($sql );



$formats["FECHA"]='fecha';
$formats["importe"]='moneda';
$formats["pdf"]='pdf_50';


$links["FECHA"] = ["albaran_proveedor.php?id_vale=", "ID_VALE", "ver vale", "formato_sub"] ;
$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA", '', 'formato_sub'] ;

$aligns["importe"] = "right" ;
$aligns["Pdte_conciliar"] = "right" ;

// accion de CONCILIAR el MOV_BANCO con el ID_PAGO
$onclick1_VARIABLE1_="ID_VALE" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
//$onclick1_VARIABLE2_="" ;     // idem

 $sql_update="UPDATE `VALES` SET `ID_FRA_PROV` = '$id_fra_prov'  " 
         ."WHERE  ID_VALE=_VARIABLE1_ ; " ;

  $sql_update=encrypt2($sql_update) ;

//$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' target='_blank' title='concilia el ALBARAN  a la factura' href=\"../include/sql.php?code=1&variable1=_VARIABLE1_&sql=$sql_update \" >conciliar</a> ";
$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' target='_blank' title='concilia el ALBARAN  a la factura' onclick='js_href(\"../include/sql.php?code=1&variable1=_VARIABLE1_&sql=$sql_update \" )' >conciliar</a> ";
$actions_row["id"]="ID_VALE";
  
$num_vales_sin_conc= $result->num_rows;

 $titulo="<span>Albaranes sin conciliar  ($num_vales_sin_conc <span class='glyphicon glyphicon-tags'></span>) <br><small>Alb. sin conciliar:  ".cc_format($importe_pdte_conc,"moneda")."</small></span>" ; 

 $msg_tabla_vacia="No hay Albaranes sin conciliar de este proveedor";


 
 require("../include/tabla.php"); echo $TABLE ;         // vales pdtes de conciliar

//  VALES
?>
	 
</div>
	
<!--              FIN vales   -->
<div class="right2_50 ">
	
<?php 
//  WIDGET #FIRMAS 
$tipo_entidad='fra_prov' ;
$id_entidad=$id_fra_prov ;

$flags_firma = ($conc ? "Cargada " : "" ) . ($pagada ? "Pagada " : " " ) . ($cobrada ? "Cobrada" : "" ) ;
$firma="Factura $n_fra de $proveedor (".cc_format($importe_iva, 'moneda').") $flags_firma " ;

//$id_subdir=$id_proveedor ;
//$size='400px' ;
require("../include/widget_firmas.php");          // FIRMAS

 ?>
	 
</div>	



<div class="right2_50" style="background-color: #ffcc99"> 

	
<?php            //  div PAGOS  tabla.php

//$sql="SELECT id_pago,Banco, tipo_doc, f_vto, importe,id_mov_banco,if(conc,'<small>mov_banco</small>','') as cobrado,if(FProv > 1, 'X' , '') as P_multiple FROM Fras_Prov_Pagos_View  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ORDER BY f_vto   ";
$sql="SELECT id_pago,id_cta_banco,id_remesa, id_pago as nid_pago,Banco,  remesa, f_vto, importe,id_mov_banco,conc as cobrado,tipo_doc,fecha_banco,concepto as concepto_banco "
        . " FROM Fras_Prov_Pagos_View  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ORDER BY f_vto   ";
//echo $sql;
$result=$Conn->query($sql );

$sql_T="SELECT '','' as a,'' as a1,'' as a11, SUM(importe) as importe,'' as a2,'' as a111 FROM Fras_Prov_Pagos_View  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ";
//echo $sql;
$result_T=$Conn->query($sql_T );

$formats["f_vto"]='fecha';
$formats["cobrado"]='boolean';
$links["nid_pago"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago", "", "formato_sub"] ;
//$links["f_vto"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago", "", "formato_sub"] ;
//$links["cobrado"]=["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco","ver el mov. bancario del cobro", "formato_sub"] ;
$links["fecha_banco"]=["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco","ver el mov. bancario del cobro", "formato_sub_vacio"] ;
$links["concepto_banco"]=["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco","ver el mov. bancario del cobro", "formato_sub_vacio"] ;
$links["Banco"] = ["../bancos/bancos_mov_bancarios.php?id_cta_banco=", "id_cta_banco", "", ""] ;
$links["remesa"] = ["../bancos/remesa_ficha.php?id_remesa=", "id_remesa", "ver Remesa", "formato_sub_vacio"] ;

$formats["importe"] = "moneda" ;
$aligns["abonado"] = "center" ;
$aligns["P_multiple"] = "center" ;
//$aligns["Importe_ejecutado"] = "right" ;

$tooltips["fecha_banco"] = "fecha de cobro del proveedor. Clickar para ver el movimiento bancario" ;
//$tooltips["P_multiple"] = "Pago múltiple. Pago para varias facturas" ;


//  $id_pago=$rs["id_pago"] ;
  $tabla_update="PAGOS" ;
  $id_update="id_pago" ;
//  $id_valor=$id_pago ;
  $actions_row["id"]="id_pago";

  $actions_row["delete_link"]="1";

  //////////////
  
   $updates=['importe','f_vto']  ;
//  $tabla_update="VALES" ;
//  $id_update="ID_VALE" ;
//    $actions_row=[];
//    $actions_row["id"]="ID_VALE";
//    $actions_row["delete_link"]="1";




// accion de DESCONCILIAR el PAGO de la FRA_PROV
$onclick1_VARIABLE1_="id_pago" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
//$onclick1_VARIABLE2_="" ;     // idem

// $sql_update="UPDATE `VALES` SET `ID_FRA_PROV` = NULL  " 
//         ."WHERE  ID_VALE=_VARIABLE1_ ; " ;

 $sql_delete="DELETE FROM `FRAS_PROV_PAGOS`  " 
         ."WHERE id_fra_prov=$id_fra_prov AND id_pago=_VARIABLE1_ ; " ;
 
 $sql_delete=encrypt2($sql_delete) ;
        
$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs noprint' target='_blank' title='Desconcilia el Pago de la factura' href=\"../include/sql.php?code=1&variable1=_VARIABLE1_&sql=$sql_delete \" >desconciliar</a> ";

  
  
  ////////////  PAGOS REALIZADOS  /////////
 
$num_pagos= $result->num_rows;


//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="Pagos ($num_pagos) " ;   
$pdte_pago_txt= $pdte_pago<>0 ?  "(Pdte:" .  trim(cc_format($pdte_pago,'moneda')) .")" : "" ;   

if ($pagada)
{
 $cobrada_text= ($cobrada) ? "PAGADA y COBRADA " : "PAGO ENVIADO y pdte COBRO" ;   
 $color_cobrada= ($cobrada) ? "green" : "orange" ;   
 $titulo.="<br><span style='color:$color_cobrada;'> $cobrada_text $pdte_pago_txt</span>" ;
 $tabla_expandida=0;          // CONTRAEMOS en caso de que esté pagada
}
else
{
 $titulo.="<br><span style='bold;color:red;'>NO PAGADA $pdte_pago_txt</span>" ;   
}    
if (1)     // antiguo else
{

   // creamos el <SELECT> para conciliar con MOV_BANCO si existe 
    $gestionar_collapse = (!$pagada) ?  'collapse in' : 'collapse' ;   // si NO PAGADA -> EXPANDIDA

    // inicio el div con EXPAND
    $link_conciliar="<div class='div_boton_expand'><button data-toggle='collapse' class='btn btn-link  noprint' data-target='#div_gestionar'>"
            . "Gestionar pagos </button></div>"
            . "<div id='div_gestionar' class='$gestionar_collapse'>" ;
    
//    añadir a REMESA 
    
    $link_conciliar.="<div class='noprint' style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>"
        . "Añadir a remesa de pagos"
         ."<select class='noprint'  id='id_remesa' style='width: 20%;'>"
            ."<OPTION value='0' selected>*crear remesa nueva*</OPTION>"
        . DOptions_sql("SELECT id_remesa,CONCAT(remesa,' (' ,FORMAT(IFNULL(importe,0),2),'€ en ' ,IFNULL(num_pagos,0),' pagos)') "
                                          . " FROM Remesas_View WHERE activa=1 AND tipo_remesa='P' AND firmada=0 AND $where_c_coste ORDER BY f_vto ")
        ."</select>"
//        ."<a class='btn btn-link noprint' href='#' onclick=\"window.open('../bancos/remesa_anadir_selection.php?array_str=$id_fra_prov&id_remesa='+document.getElementById('id_remesa').value )\" "
        ."<a class='btn btn-link noprint' href='#' onclick=\"js_href('../bancos/remesa_anadir_selection.php?array_str=$id_fra_prov&id_remesa='+document.getElementById('id_remesa').value )\" "
                                . " title='Añade/Genera remesa con la factura' ><i class='fas fa-link'></i> Añadir a remesa</a>"
        ."<a class='btn btn-link btn-xs noprint' style='opacity:0.3;' href='#' onclick=\"window.open('../bancos/remesa_ficha.php?id_remesa='+document.getElementById('id_remesa').value ) \" "
                                   . " title='abre la remesa seleccionada' >Ver remesa</a>"
        ."</div>" ;

//  CONCILIAR MOV. EXISTENTE
    $link_conciliar.="<div  class='noprint'  style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>" ;
//    $link_conciliar.="<label for='id_obra'>Cargar a obra:</label>" ;
    $link_conciliar.="Conciliar con mov.banco existente:" ;
//    $link_conciliar.="<select class='form-control' id='id_obra' style='width: 50%;'>" ; 
    $link_conciliar.="<select  class='noprint'  id='id_mov_banco' style='width: 40%; '>" ;
//    $link_conciliar.=DOptions_sql("SELECT id_mov_banco,CONCAT(DATE_FORMAT(fecha_banco, '%d-%m-%Y'),'  ', Banco, '-', Concepto,' ',cargo,'€') FROM MOV_BANCOS_conc_fras WHERE ID_FRA_PROV=$id_fra_prov AND $where_c_coste ORDER BY fecha_banco DESC ") ;
    $link_conciliar.=DOptions_sql("SELECT id_mov_banco,CONCAT(DATE_FORMAT(fecha_banco, '%d-%m-%Y'),'- ', Banco, '-', Concepto,' ',cargo,'€') FROM MOV_BANCOS_View "
                        . "WHERE $where_c_coste  AND NOT conc AND cargo=$pdte_pago ORDER BY fecha_banco DESC ") ;
    $link_conciliar.="  </select>" ;
    $link_conciliar.=" <a class='btn btn-link noprint' href='#'  onclick='mov_bancos_conciliar_selection_fras($id_fra_prov);' title='Ej. Cuando ya se ha pagado previamente. Ej. pagos con tarjeta'  >"
                        . "<i class='fas fa-link'></i> Crea Pago y lo concilia con el mov.banco</a>"
                      ." <a class='btn btn-link btn-xs noprint' style='opacity:0.3;'  href='#' onclick=\"window.open('../bancos/pago_ficha.php?id_mov_banco='+document.getElementById('id_mov_banco').value ) \"    "
                       ." title='Ver Movimiento bancario' >Ver mov banco</a>" ;

    $link_conciliar.="</div>" ;

//    *** ANULAMOS EL BOTON PAGAR CON CAJA METALICO, LO PONEMOS POR DEFECTO EN EL SIGUIENTE SELECT ****    
//    // pago con CAJA METALICO    
//    $link_conciliar.="<div style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>" ;
//    $link_conciliar.=" <a class='btn btn-link' href='#'  onclick='mov_bancos_conciliar_fras_caja_metalico($id_fra_prov);' title='Ej. Cuando la fra. ya está pagada por bolsillo'  >"
//                    . "pagar con cuenta de CAJA METALICO($pdte_pago_txt)</a>" ;    
//    $link_conciliar.="</div>" ;

    
    // pago con cuenta a seleccionar
    $link_conciliar.="<div   class='noprint' style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>" ;
    $link_conciliar.="Pagar y anotar en cuenta: <select  class='noprint'  id='id_cta_banco' style='width: 40%; '>" ;
    $link_conciliar.=DOptions_sql("SELECT id_cta_banco, Banco FROM ctas_bancos WHERE Activo AND $where_c_coste ORDER BY Banco") ; //por defecto CAJA METALICO
    $link_conciliar.="  </select>" ;    
    $link_conciliar.=" <a class='btn btn-link noprint' href='#'  onclick='mov_bancos_conciliar_fras_cta($id_fra_prov);' "
                    . " title='Crea Pago nuevo, crea un mov. bancario en la cta.banco seleccionada y los concilia \n Ej. Cuando se paga con Caja Metálico, pagos hechos a cargo de Notas de Gastos de empleados, cuando hay compensaciones de facturas o abonos...' >"
                    . "<i class='fas fa-plus-circle'></i><i class='fas fa-link'></i> Crear Pago, crea mov.banco y concilia ($pdte_pago_txt)</a>" 
                    .""
                     . " <a class='btn btn-link btn-xs noprint' style='opacity:0.3;'  href='#' onclick=\"window.open('../bancos/bancos_mov_bancarios.php?id_cta_banco='+document.getElementById('id_cta_banco').value ) \"    "
                    ." title='Ver cuenta bancaria' >ver cta bancaria</a>" ;

    $link_conciliar.="</div>" ;
    
    // crea pago nuevo 
    $link_conciliar.="<div  class='noprint' style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>" ;
    $link_conciliar.=" <a class='btn btn-link noprint' href='#'  onclick='fra_prov_crear_pago($id_fra_prov);' title='Crea un Pago nuevo en la cta banco por defecto. Se usa cuando vamos a emitir un pago. \n Ej. Pagarés, pagos fraccionados,... '><i class='fas fa-plus-circle'></i> Crear Pago nuevo ($pdte_pago_txt)</a>" ;    
    $link_conciliar.="</div>" ;

    //
    $link_conciliar.="<div  class='noprint' style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>" ;
    $link_conciliar.=" <a class='btn btn-link noprint' href='#'  onclick='fra_prov_conciliar_a_pago($id_fra_prov);' title='concilia la factura con un ID_PAGO existente del mismo proveedor.\n Ej. Un pago para varias facturas'>"
            . "<i class='fas fa-link'></i> Conciliar ID_PAGO ya existente a esta fra_prov</a>" ;    
    $link_conciliar.="</div>" ;
    $link_conciliar.="</div>" ;   // fin expand


    
    
//  $titulo.="<span style='font-weight: bold;color:red;'>NO PAGADA (Pdte: $pdte_pago_txt)</span>" ;   
  $add_link_html=$link_conciliar;
 
 
 
 
 
}
$msg_tabla_vacia="No hay Pagos emitidos en esta factura";

$tabla_expandida= 0;
	
 require("../include/tabla.php"); echo $TABLE ;  // PAGOS
 
 ?>
	

<?php

}       // FIN DEL IF QUE NO PINTA <DIVs> SI NO ESTA ACTUALIZADO AL PROVEEDOR DE LA FACTURA
else
{
    echo "<h1 style='color:red;'>FACTURA NO REGISTRADA</h1> " ;
}    

?>
</div>	 





<!--              FIN pagos   -->	

	<!-- WIDGET DOCUMENTOS  -->
	
	
<?php 
//  WIDGET DOCUMENTOS 
echo "<div class='right2_50'>"  ;

$tabla_update="FACTURAS_PROV" ;
$id_update="ID_FRA_PROV" ;
$id_valor=$id_fra_prov ;

$tipo_entidad='fra_prov' ;
$id_entidad=$id_fra_prov ;
$id_subdir=$id_proveedor ;
$size='400px' ;
$tabla_expandida=1 ;     // en facturas mostramos los documentos por defecto

require("../menu/LRU_registro.php"); require("../include/widget_documentos.php");  
echo "</div>" ;


// PROCEDIMIENTOS
echo "<div class='right2 noprint'>"  ;
$tipo_entidad='fra_prov' ;
require("../agenda/widget_procedimientos.php");
echo "</div>" ;



$Conn->close();

?>
	 

</div>

<script>       

 function fra_prov_conciliar_a_pago(id_fra_prov) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
    var id_pago=window.prompt("Introduzca el ID_PAGO o nid_pago a conciliar: " );
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
//   var id_obra=document.getElementById("id_obra").value ;
//   var d= new Date() ;
//   var date_str=d.toISOString();
   if (id_pago)
   {
       window.open('../bancos/conciliar_fra_prov_pago.php?id_fra_prov='+id_fra_prov+'&id_pago='+id_pago);
       location.reload();     
   }
//   window.open('../obras/obras_anadir_parte.php?id_obra='+id_obra, '_blank');
 //echo "<a class='btn btn-primary' href= '../obras/obras_anadir_parte.php?id_obra=$id_obra' >Añadir parte</a><br>" ;
        

    
    return ;
 }
 function fra_prov_crear_pago(id_fra_prov) {
    
   
//   window.open('../bancos/mov_bancos_conciliar_selection_fras.php?id_fra_prov='+id_fra_prov+'&id_mov_banco=SOLO_PAGO');
//   location.reload();

   js_href('../bancos/mov_bancos_conciliar_selection_fras.php?id_fra_prov='+id_fra_prov+'&id_mov_banco=SOLO_PAGO');
        
    
    return ;
 }
 
    function mov_bancos_conciliar_fras_caja_metalico(id_fra_prov) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
//    alert("el nuevo valor es: "+valor) ;
    window.open('../bancos/mov_bancos_conciliar_selection_fras.php?id_fra_prov='+id_fra_prov+'&id_mov_banco=CAJA_METALICO');
    location.reload();

//    js_href('../bancos/mov_bancos_conciliar_selection_fras.php?id_fra_prov='+id_fra_prov+'&id_mov_banco=CAJA_METALICO');
    
    return ;
 }
 
    function mov_bancos_conciliar_fras_cta(id_fra_prov) {
    
//   alert('debug') ;

   var id_cta_banco=document.getElementById("id_cta_banco").value ;
//   window.open('../bancos/mov_bancos_conciliar_selection_fras.php?id_fra_prov='+id_fra_prov+'&id_mov_banco=CTA_' + id_cta_banco);
//   document.body.style.cursor = "wait" ;
   window.open('../bancos/mov_bancos_conciliar_selection_fras.php?id_fra_prov='+id_fra_prov+'&id_mov_banco=CTA_' + id_cta_banco);
//   js_href('../bancos/mov_bancos_conciliar_selection_fras.php?id_fra_prov='+id_fra_prov+'&id_mov_banco=CTA_' + id_cta_banco);
location.reload();
        
    
    return ;
 }
 
 function mov_bancos_conciliar_selection_fras(id_fra_prov) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;

   var id_mov_banco=document.getElementById("id_mov_banco").value ;
//   var d= new Date() ;
//   var date_str=d.toISOString();
   
   window.open('../bancos/mov_bancos_conciliar_selection_fras.php?id_fra_prov='+id_fra_prov+'&id_mov_banco='+id_mov_banco);
//   js_href('../bancos/mov_bancos_conciliar_selection_fras.php?id_fra_prov='+id_fra_prov+'&id_mov_banco='+id_mov_banco);
location.reload();
        

    
    return ;
 }
 
 
function cargar_a_obra_href(id_fra_prov) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
   var id_obra=document.getElementById("id_obra").value ;
//   var d= new Date() ;
//   var date_str=d.toISOString();

 var xhttp = new XMLHttpRequest();
 xhttp.open("GET", '../proveedores/fra_prov_cargar_a_obra.php?id_fra_prov='+id_fra_prov+'&id_obra='+id_obra, true);
 xhttp.send();   

//location.reload();
//   window.open('../proveedores/fra_prov_cargar_a_obra.php?id_fra_prov='+id_fra_prov+'&id_obra='+id_obra);

    
    return ;
 }
</script>

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');