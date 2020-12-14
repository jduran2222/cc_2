<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Subobra';

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


$id_subobra=$_GET["id_subobra"];
//$id_produccion=$_GET["id_produccion"];
// require("../obras/obras_menutop_r.php");

?>
	

  <?php              // DATOS   FICHA . PHP
 //echo "<pre>";
 //$result=$Conn->query($sql="SELECT * FROM Udos_View WHERE ID_UDO=$id_udo AND $where_c_coste");       //PDTE pasar a uso de Udos_View
 $result=$Conn->query($sql="SELECT * FROM Subobra_View WHERE ID_SUBOBRA=$id_subobra AND $where_c_coste" );
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;

//  $selects["ID_SUBOBRA"]=["ID_SUBOBRA","SUBOBRA","SUBOBRAS","../clientes/clientes_anadir_form.php","../clientes/clientes_ficha.php?id_cliente=","ID_CLIENTE"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

 
  $titulo="SUBOBRA" ;
//  $updates=['UDO','COD_PROYECTO','ud','TEXTO_UDO', 'PRECIO' ,'MED_PROYECTO', 'COSTE_EST', 'Estudio_coste', 'fecha_creacion', 'user' ]  ;
  $updates=['*' ]  ;
  $id_udo=$rs["ID_SUBOBRA"] ;
  $tabla_update="SubObras" ;
  $id_update="ID_SUBOBRA" ;
  $id_valor=$id_subobra ;
    $delete_boton=1;
  
    
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?PHP 
  
//  echo "<a class='btn btn-link noprint' href='../obras/udo_prod.php?id_udo=$id_udo' >Ver Ficha completa</a>" ;
  
  require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      
      
	
	<!--  fin ficha estudio  -->
	
	
<?php            // ----- div---- UDO - PRODUCCIONS - MEDICIONES  tabla.php   -----

//$med_proyecto=$rs["MED_PROYECTO"] ;
//$med_proyecto= ($med_proyecto==0) ? 1 : $med_proyecto  ;
//$sql="SELECT PRODUCCION, suma_medicion, suma_medicion/$med_proyecto AS P_proyecto FROM Prod_det_suma  WHERE ID_UDO=$id_udo  ORDER BY PRODUCCION   ";
$sql="SELECT ID_UDO,CAPITULO,COD_PROYECTO,ud,UDO,MED_PROYECTO,PRECIO,IMPORTE FROM Udos_View  WHERE ID_SUBOBRA=$id_subobra  AND $where_c_coste  ORDER BY CAPITULO,ID_UDO   ";
$sql_T="SELECT '', 'Suma','' AS AA,'' AS AA2,'' AS A2A,'' AS AA22,SUM(IMPORTE) as IMPORTE FROM Udos_View  WHERE ID_SUBOBRA=$id_subobra  AND $where_c_coste   ";
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
//$formats["importe"]='moneda';
//$formats["Fecha"]='dbfecha';
//
//$links["FECHA"] = ["albaran_proveedor.php?id_vale=", "ID_VALE"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
$links["UDO"] = ["../obras/udo_prod.php?id_udo=", "ID_UDO", "ver ficha de la unidad de obra", "formato_sub"] ;  

//
//$aligns["importe"] = "right" ;
//$aligns["Pdte_conciliar"] = "right" ;
////$aligns["Importe_ejecutado"] = "right" ;
//
////$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;
//
////$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="Unidades de Obra (UDOs) de esta SUBOBRA" ;
$msg_tabla_vacia="No hay ";


$updates=[]  ;
$tabla_update="Udos" ;
$id_update="ID_UDO" ;

$actions_row=[];
$actions_row["ID_UDO"]="ID_UDO";
//$actions_row["update_link"]="../include/update_row.php?tabla=Fra_Cli_Detalles&where=id=";
//$actions_row["delete_link"]="../include/tabla_delete_row.php?tabla=PARTES_PERSONAL&where=id=";
$actions_row["delete_link"]="1";



?>
	
<!--  <div class="right2"> -->
<div  style="background-color:Khaki;float:left;width:60%;padding:0 20px;" >
	
<?php 


//$produccion=Dfirst("PRODUCCION", "PRODUCCIONES", "ID_PRODUCCION=$id_produccion ") ;
//
//echo "<h1>PRODUCCION: $produccion  " ;
//$buttons[0]= "<a class='btn btn-primary' href='#'  onclick='add_udo_prod($id_udo,$id_produccion);'> <span class='glyphicon glyphicon-plus-sign'> añadir medicion</a>" ;
//echo "</h1>" ;

  require("../include/tabla.php"); echo $TABLE ; 
  
 ?>
	 
</div>
	
<!--              FIN producciones   -->
 
	
<?php            //  div PAGOS  tabla.php

//$sql="SELECT id_pago,Banco, tipo_doc, f_vto, importe,id_mov_banco,if(conc,'mov.banco','') as abonado,if(FProv > 1, 'X' , '') as P_multiple FROM Fras_Prov_Pagos_View  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ORDER BY f_vto   ";
////echo $sql;
//$result=$Conn->query($sql );
//
//$sql="SELECT '','','', SUM(importe) FROM Fras_Prov_Pagos_View  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ";
////echo $sql;
//$result_T=$Conn->query($sql );
//
//$formats["f_vto"]='fecha';
//$links["f_vto"] = ["fra_prov_pago.php?id_pago=", "id_pago"] ;
//$links["abonado"]=["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco"] ;
//
//$aligns["importe"] = "right" ;
//$aligns["abonado"] = "center" ;
//$aligns["P_multiple"] = "center" ;
////$aligns["Importe_ejecutado"] = "right" ;
//
//$tooltips["abonado"] = "Pago abonado. Clickar para ver el movimiento bancario" ;
//$tooltips["P_multiple"] = "Pago múltiple. Pago para varias facturas" ;
//
////$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
//$titulo="Pagos emitidos" ;
//$msg_tabla_vacia="No hay Pagos emitidos en esta factura";

?>
	

 <div class="mainc">
	
<?php // require("../include/tabla.php"); echo $TABLE ; ?>
	
</div>	 
<!--              FIN pagos   -->	
	
<?php  

$Conn->close();

?>
	 

</div>

<script>       
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
              	
	
                </div>
                
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>              
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>              
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');

