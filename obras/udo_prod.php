<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;
?>

<HTML>
<HEAD>
     <title>UDO. Unidad de Obra</title>

	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>


<?php 


$id_udo=$_GET["id_udo"];
$id_produccion= isset($_GET["id_produccion"]) ? $_GET["id_produccion"] : '';

 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 require_once("../menu/topbar.php");
// require("../obras/obras_menutop_r.php");
 require("../menu/topbar.php");


 
// DATOS   FICHA . PHP
  
  
//$boton_recalcular= "<a class='btn btn-link noprint' href='#'  onclick='eval_coste($id_udo);' >recalcular coste</a>" ;
$boton_recalcular= "<button class='btn-warning'  onclick=eval_coste($id_udo); title='Recalcula el Coste Estimado calculando la fórmula indicada tras un signo = en el Estudio de Coste ' >recalcular coste</button>" ;

  
  // 
 //echo "<pre>";
 //$result=$Conn->query($sql="SELECT * FROM Udos_View WHERE ID_UDO=$id_udo AND $where_c_coste");       //PDTE pasar a uso de Udos_View
 $sql="SELECT ID_CAPITULO,NOMBRE_OBRA,ID_OBRA,ID_UDO,COD_PROYECTO,ud,UDO,TEXTO_UDO,path_archivo,  "
         . "MED_PROYECTO,'Descompuesto de Medicion' as  EXPAND2 , Descompuesto_MED,'' as FIN_EXPAND2,PRECIO,'Descompuesto de Precio' as  EXPAND , Descompuesto_PRECIO,'' as FIN_EXPAND,ID_SUBOBRA,COSTE_EST,Estudio_coste "
         . ",Precio_Cobro, IMPORTE,GASTO_EST,IMPORTE-GASTO_EST AS Beneficio,(1-GASTO_EST/IMPORTE) AS Margen, "
         . "fecha_creacion,user "
         . " FROM Udos_View WHERE ID_UDO=$id_udo AND $where_c_coste" ;
 
 
 $result=$Conn->query($sql);
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
 
$id_obra=$rs["ID_OBRA"];

$selects["ID_SUBOBRA"]=["ID_SUBOBRA","SUBOBRA","Subobra_View","../obras/subobra_anadir.php?id_obra=$id_obra","../obras/subobra_ficha.php?id_subobra=","ID_SUBOBRA","AND ID_OBRA=$id_obra"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
$selects["ID_CAPITULO"]=["ID_CAPITULO","CAPITULO","Capitulos_View","../obras/add_capitulo_ajax.php?no_ajax=1&id_obra=$id_obra&id_udo=$id_udo" 
        ,"../include/ficha_general.php?url_enc=".encrypt2("tabla=Capitulos&id_update=ID_CAPITULO")."&id_valor=","ID_CAPITULO","AND ID_OBRA=$id_obra"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

//$links["N_Cta"] = ["../include/ficha_general.php?tabla=ctas_bancos&id_update=id_cta_banco&id_valor=", "id_cta_banco", 'icon'] ;


// $selects["CERT_ANTERIOR"]=["ID_PRODUCCION","PRODUCCION","Prod_view","../obras/prod_anadir_form.php","../obras/obras_prod_detalle.php?id_obra=$id_obra&id_produccion=","CERT_ANTERIOR","AND ID_OBRA=$id_obra"] ;   // datos para clave foránea

$titulo="UNIDAD DE OBRA (UDO)" ;
$updates=['ID_CAPITULO','ID_SUBOBRA','UDO','COD_PROYECTO','ud','TEXTO_UDO', 'PRECIO' ,'MED_PROYECTO', 'COSTE_EST', 'Estudio_coste' ]  ;
$id_udo=$rs["ID_UDO"] ;
//$udo=$rs["UDO"] ;
$tabla_update="Udos" ;
$id_update="id_udo" ;
$id_valor=$id_udo ;

$array_udo=$rs ;

$formats["TEXTO_UDO"]='text_edit';
$formats["Estudio_coste"]='text_edit';

$spans_html['Estudio_coste']=$boton_recalcular ;

$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA", "ver Obra", "formato_sub"] ;


$wikis["COSTE_EST"] = "COSTE_EST";
$wikis["Estudio_coste"] = "Estudio_Coste";
$tooltips["Estudio_coste"] = "Introducir formula tras signos = \n Ej:  = 3*(5+4/2) y pulsar recalcular coste";
//  $anadir["Estudio_coste"]="JUANILLO" ;

    
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?PHP 
  
// hemos anulado la ficha general de udo  
//  echo "<br><br><br><a class='btn btn-link noprint' href='../obras/udo_prod.php?_m=$_m&id_udo=$id_udo' >Ver Ficha UDO general</a>" ;
  echo "<br><br><br>" ;
  
  require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      
 <!--************ DOCUMENTOS POF *************  -->
<div class="right2">
	

<?php 

$tipo_entidad='udo' ;
$id_entidad=$id_udo;
$id_subdir=0 ;
$size='400px' ;

require("../include/widget_documentos.php");
 ?>
	 
</div>     
	
	<!--  fin ficha estudio  -->
<?php            //  div `POF  tabla.php

$sql="SELECT id,ID_POF,CONCAT(NUMERO,'-',NOMBRE_POF) AS NOMBRE_POF,CANTIDAD,CONCEPTO,Precio_Cobro FROM  POF_concepto_View WHERE id_udo=$id_udo  AND $where_c_coste ORDER BY NUMERO ";
//echo $sql;
$result=$Conn->query($sql );

//$sql="SELECT '','','', SUM(importe) FROM Fras_Prov_Pagos_View  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ";
////echo $sql;
//$result_T=$Conn->query($sql );

//$formats["f_vto"]='fecha';
$links["CONCEPTO"] = ["../pof/pof_concepto_ficha.php?id=", "id", "ver POF CONCEPTO",'formato_sub'] ;
$links["NOMBRE_POF"] = ["../pof/pof.php?id_pof=", "ID_POF",'abrir Peticion de Oferta' ,'formato_sub'] ;

//$aligns["importe"] = "right" ;
//$aligns["abonado"] = "center" ;
//$aligns["P_multiple"] = "center" ;
//$aligns["Importe_ejecutado"] = "right" ;

//$tooltips["abonado"] = "Pago abonado. Clickar para ver el movimiento bancario" ;
//$tooltips["P_multiple"] = "Pago múltiple. Pago para varias facturas" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="POF vinculadas" ;
$msg_tabla_vacia="No hay";

?>
	

 <div class="right2">
	
<?php 

$guid =  guid(); 
$sql_insert="INSERT INTO `PETICION_DE_OFERTAS` ( ID_OBRA,NUMERO,NOMBRE_POF,`user`,guid )    VALUES (  '$id_obra',0, '{$array_udo["UDO"]}' , '{$_SESSION["user"]}' ,'$guid' );" ;

$sql_insert.="INSERT INTO POF_CONCEPTOS (ID_POF, id_udo,CANTIDAD,CONCEPTO,DESCRIPCION,Precio_Cobro,user) VALUES " 
      ."( (SELECT ID_POF FROM PETICION_DE_OFERTAS WHERE guid='$guid' ),'$id_udo', '{$array_udo["MED_PROYECTO"]}', '{$array_udo["UDO"]}', '{$array_udo["TEXTO_UDO"]}' "
      . " , '{$array_udo["Precio_Cobro"]}' , '{$_SESSION["user"]}' )  " ;

//$sql_insert.="INSERT INTO POF_CONCEPTOS (ID_POF, id_udo,CANTIDAD,CONCEPTO,DESCRIPCION,Precio_Cobro,user) VALUES " 
//      ."( (SELECT ID_POF FROM PETICION_DE_OFERTAS WHERE guid='$guid' ),'$id_udo', '0', 'conepto', 'descripcion' "
//      . " , '1' , '{$_SESSION["user"]}' )  " ;

$href='../include/sql.php?sql=' . encrypt2($sql_insert)     ;
$content_sel="<a class='btn btn-link btn-xs noprint ' href='#' "
     . " onclick=\"js_href('$href' )\"   "
     . "title='Crea POF con la UDO' >crear POF</a>" ;

echo $content_sel;
require("../include/tabla.php"); echo $TABLE ; ?>
	
</div>	 
<!--              FIN pagos   -->	
	
	
<?php            // ----- div---- UDO - PRODUCCIONS - MEDICIONES  tabla.php   -----

// SOLO SI VENIMOS DESDE UNA PRODUCCIÓN VEMOS LOS ESTADILLOS, EN CASO CONTRARIO VEMOS LA MEDICION DE CADA PRODUCCION
if ($id_produccion)
{
    $sql="SELECT id,Fecha,Observaciones,MEDICION, importe FROM ConsultaProd  WHERE ID_UDO=$id_udo AND ID_PRODUCCION=$id_produccion ORDER BY Fecha   ";
    $sql_T="SELECT '', 'Suma',SUM(MEDICION) as MEDICION,SUM(importe) as importe FROM ConsultaProd  WHERE ID_UDO=$id_udo AND ID_PRODUCCION=$id_produccion   ";
    ////echo $sql;
    $result=$Conn->query($sql );
    $result_T=$Conn->query($sql_T );
    //
    //$sql="SELECT '' as a,'' as b,'' as c, SUM(importe) as importe FROM Vales_view  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ";
    ////echo $sql;
    //$result_T=$Conn->query($sql );
    //
    //$formats["P_proyecto"]='porcentaje';
    //$formats["MEDICION"]='fijo';            // QUITAMOS EL FORMATO PARA QUE SE VEAN TODOS LOS DECIMALES DE LA MEDICION
    $formats["importe"]='moneda';
    //$formats["Fecha"]='dbfecha';
    //
    //$links["Fecha"] = ["albaran_proveedor.php?id_vale=", "ID_VALE"] ;
    //$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
    //
    //$aligns["importe"] = "right" ;
    //$aligns["Pdte_conciliar"] = "right" ;
    ////$aligns["Importe_ejecutado"] = "right" ;
    //
    ////$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;
    //
    ////$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
    $titulo="Detalles de Medición" ;
    $msg_tabla_vacia="No hay ";


    $updates=['Fecha','MEDICION', 'Observaciones']  ;
    $tabla_update="PRODUCCIONES_DETALLE" ;
    $id_update="id" ;

    $actions_row=[];
    $actions_row["id"]="id";
    //$actions_row["update_link"]="../include/update_row.php?tabla=Fra_Cli_Detalles&where=id=";
    //$actions_row["delete_link"]="../include/tabla_delete_row.php?tabla=PARTES_PERSONAL&where=id=";
    $actions_row["delete_link"]="1";
    $formats["MEDICION"] = "text_moneda" ;
    $tooltips["MEDICION"] = "Admite formula matemática a calcular y comentarios, anteponer =,  ejemplo\n = hormigon 50*.15 + mallazo 2.5" ;



	
 echo "<div  style='background-color:Khaki;float:left;width:100%;padding:0 20px;' >" ;
	
   $produccion=Dfirst("PRODUCCION", "PRODUCCIONES", "ID_PRODUCCION=$id_produccion ") ;

    echo "<h1>Relación Valorada: <a href='../obras/obras_prod_detalle.php?id_produccion=$id_produccion' target='_blank' title='abrir Relación Valorada'>$produccion</a></h1> " ;
//    $buttons[0]= "<a class='btn btn-link' href='#'  onclick='add_udo_prod($id_udo,$id_produccion);'> <i class='fas fa-plus-circle'></i> añadir medicion</a>" ;
    $add_link_html= "<a class='btn btn-link' href='#'  onclick='add_udo_prod($id_udo,$id_produccion);'> <i class='fas fa-plus-circle'></i> añadir medicion</a>" ;
//    $buttons[1]= "<a class='btn btn-link' href='../obras/udo_prod.php?id_udo=$id_udo'  > <i class='fas fa-list'></i> ficha Udo general</a>" ;

    require("../include/tabla.php"); echo $TABLE ;    // tabla de MEDICIONES DE UDO-RELACION VALORADA
    echo "</div>" ;

}
 else      // estamos en UDO general, vemos la presencia en todas las RELACIONES VALORADAS
{
    $med_proyecto=$rs["MED_PROYECTO"] ;
    $med_proyecto= ($med_proyecto==0) ? 1 : $med_proyecto  ;
    $sql="SELECT ID_PRODUCCION, PRODUCCION, suma_medicion, suma_medicion/$med_proyecto AS P_proyecto FROM Prod_det_suma  WHERE ID_UDO=$id_udo  ORDER BY PRODUCCION   ";
    ////echo $sql;
    $result=$Conn->query($sql );
    //
    //$sql="SELECT '' as a,'' as b,'' as c, SUM(importe) as importe FROM Vales_view  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ";
    ////echo $sql;
    //$result_T=$Conn->query($sql );
    //
    $formats["P_proyecto"]='porcentaje';
    $formats["suma_medicion"]='fijo';
    //
    //$links["PRODUCCION"] = ["albaran_proveedor.php?id_vale=", "ID_VALE"] ;
    $links["PRODUCCION"]=["../obras/obras_prod_detalle.php?id_obra=$id_obra&id_produccion=", "ID_PRODUCCION",'', 'formato_sub'] ;
    //
    //$aligns["importe"] = "right" ;
    //$aligns["Pdte_conciliar"] = "right" ;
    ////$aligns["Importe_ejecutado"] = "right" ;
    //
    ////$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;
    //
    ////$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
    $titulo="Producciones" ;
    $msg_tabla_vacia="No hay registro en ninguna Producción";
    $updates=[] ;

    echo "<div  style='background-color:lightblue;float:left;width:60%;padding:0 20px;' >" ;

    echo "<h1>Relaciones Valorada con esta UDO</h1> " ;
//    $buttons[0]= "<a class='btn btn-link' href='#'  onclick='add_udo_prod($id_udo,$id_produccion);'> <i class='fas fa-plus-circle'></i> añadir medicion</a>" ;

    require("../include/tabla.php"); echo $TABLE ; //TABLA DE RELACIONES VALORADAS

    echo "</div>" ;
  
}
    
    
    
    
    
    
 ?>
	 
	
	
<?php  

$Conn->close();

?>
	 

</div>

<script>       
    
function eval_coste(id_udo) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
//    var medicion=window.prompt("Medicion "+prompt , '0.00');
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
//   var id_personal=document.getElementById("id_personal").value ;
//   var sql="INSERT INTO PRODUCCIONES_DETALLE (ID_UDO,ID_PRODUCCION,Fecha,MEDICION ) VALUES ('"+ id_udo +"','"+ id_produccion +"' ,'2018-01-01','"+ medicion +"' )"    ;   
//   alert('hola') ;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                                        // hay un error y lo muestro en pantalla
        else
        { //document.getElementById(pcont).innerHTML = this.responseText ;   // "pinto" en la pantalla el campo devuelto por la BBDD tras el Update
//            alert(this.responseText) ;   //debug
              location.reload(true);  // refresco la pantalla tras edición
        }
      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
      
    }
    }
     xhttp.open("GET", "../obras/udo_eval_coste_ajax.php?id_udo="+id_udo, true);
     xhttp.send();   
    
    
    return ;
 }
    
    
function add_udo_prod(id_udo,id_produccion) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
    var medicion=window.prompt("Medicion "+prompt , '0.00');
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
//   var id_personal=document.getElementById("id_personal").value ;
   var sql="INSERT INTO PRODUCCIONES_DETALLE (ID_UDO,ID_PRODUCCION,Fecha,MEDICION ) VALUES ('"+ id_udo +"','"+ id_produccion +"' ,'2018-01-01','"+ medicion +"' )"    ;   
//   alert(sql) ;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                                        // hay un error y lo muestro en pantalla
        else
        { //document.getElementById(pcont).innerHTML = this.responseText ;   // "pinto" en la pantalla el campo devuelto por la BBDD tras el Update
//            alert(this.responseText) ;   //debug
              location.reload(true);  // refresco la pantalla tras edición
        }
      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
      
    }
    }
     xhttp.open("GET", "../include/insert_ajax.php?sql="+sql, true);
     xhttp.send();   
    
    
    return ;
 }
</script>
    	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

