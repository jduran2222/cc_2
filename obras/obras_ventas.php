<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Obra Ventas';

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

 require_once("obras_menutop_r.php");

 
$importe_obra=Dfirst("IMPORTE", "OBRAS", "ID_OBRA=$id_obra AND $where_c_coste") ;
$iva_obra=Dfirst("iva_obra", "OBRAS", "ID_OBRA=$id_obra AND $where_c_coste") ;

 ?>

<div >	   
   
<!--************ INICIO VENTAS *************  -->

<div   id="main" class="mainc_50" style="background-color:lightcoral">

<?php   // Iniciamos variables para tabla.php  


echo   "<br><br><br><a class='btn btn-link noprint' href=# onclick='add_venta($id_obra)' target='_blank' ><i class='fas fa-plus-circle'></i> Venta nueva</a>" ; // BOTON AÑADIR FACTURA


$result=$Conn->query($sql="SELECT id, FECHA, FECHA AS MES ,PLAN,  IMPORTE , GASTOS_EX,(IMPORTE-GASTOS_EX) AS BENEFICIO, OBSERVACIONES from VENTAS WHERE ID_OBRA=$id_obra ORDER BY FECHA " );
$result_T=$Conn->query("SELECT  'Totales',SUM(IMPORTE)/($importe_obra/(1+$iva_obra)) as p_Ventas,'' AS B11,  SUM(IMPORTE) as VENTAS , SUM(GASTOS_EX) AS IMPORTE_GASTOS, SUM(IMPORTE-GASTOS_EX) AS BENEFICIO,SUM(IMPORTE-GASTOS_EX)/SUM(IMPORTE) as Margen from VENTAS WHERE ID_OBRA=$id_obra  " );
$titulo="VENTAS";
$idtabla="VENTAS";
//$dblclicks["MES"]='mes' ;    // pruebas
//$dblclicks["FECHA"]='mes' ;    // pruebas
//$formats["MES"]='mes' ;
//$formats["FECHA"]='dbfecha' ;
$formats["MES"]='mes' ;
$etiquetas["MES"]='MES'  ;
$formats["PLAN"]='text_moneda' ;
$formats["IMPORTE"]='text_moneda' ;
$formats["GASTOS_EX"]='text_moneda' ;
$formats["BENEFICIO"]='moneda' ;

$updates=["FECHA","PLAN","IMPORTE","GASTOS_EX","OBSERVACIONES"] ;
  $tabla_update="VENTAS" ;
  $id_update="id" ;
//  $id_valor=$id_pago ;
  $actions_row["id"]="id";

  $actions_row["delete_link"]="1";



$msg_tabla_vacia="No hay ventas";
?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

</div>
<script>
function add_venta(id_obra) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
//   var id_concepto=document.getElementById("id_concepto").value ;
//   var cantidad=document.getElementById("cantidad").value ;
   var f = new Date();
   var fecha= f.getFullYear()+ "-"+ (f.getMonth()+1)+ "-"+f.getDate();     // fecha en javascript
//   alert(fecha) ;

   var sql="INSERT INTO VENTAS (ID_OBRA,FECHA ) VALUES ('"+id_obra+"','"+ fecha +"' )"    ;   
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
<!--************ FIN VENTAS *************  -->
	
	
<!--************ INICIO CERTIFICACIONES *************  -->

<div  class="right2_50" style="background-color:lightblue">

<?php   // Iniciamos variables para tabla.php  

$fecha=date('Y-m-d');
$num=Dfirst("MAX(NUM)","CERTIFICACIONES", "ID_OBRA=$id_obra") + 1 ;
$sql_insert="INSERT INTO CERTIFICACIONES (ID_OBRA,NUM,FECHA,user) VALUES ('$id_obra' ,'$num' ,'$fecha'  , '{$_SESSION['user']}' )  "  ;
      
$href='../include/sql.php?sql=' . encrypt2($sql_insert)     ;
echo "<br><br><a class='btn btn-link btn-xs noprint ' href='#'  onclick=\"js_href('$href' )\"   "
             . "title='Añadir una certificación nueva' ><i class='fas fa-plus-circle'></i> Certificación nueva</a>" ;

//echo   "<br><br><a class='btn btn-link noprint' href=# onclick='add_venta($id_obra)' target='_blank' ><i class='fas fa-plus-circle'></i> Certificación nueva</a>" ; // BOTON AÑADIR FACTURA


$result=$Conn->query($sql="SELECT id,NUM,FECHA, FECHA AS MES,concepto,importe from CERTIFICACIONES WHERE ID_OBRA=$id_obra ORDER BY FECHA" );
$result_T=$Conn->query("SELECT '' AS A,'Total:','' AS A2,SUM(importe)/$importe_obra as p_facturado,SUM(importe) as importe_certificado  from CERTIFICACIONES WHERE ID_OBRA=$id_obra " );

$updates=["NUM","concepto","importe","FECHA"] ; 

$aligns['concepto']='left' ;

//$formats=[] ;
$formats["MES"]='mes' ;
$formats["concepto"]='text_edit' ;
$formats["importe"]='text_moneda' ;
//$formats["NUM"]='text_edit' ;
$titulo="CERTIFICACIONES";
$idtabla="CERTIFICACIONES";
$msg_tabla_vacia="No hay";

$tabla_update="CERTIFICACIONES" ;
$id_update="id" ;
$actions_row=[];
$actions_row["id"]="id";
$actions_row["delete_link"]="1";

$onclick1_VARIABLE1_="id" ;
//$actions_row["onclick1_link"]="<a class='btn btn-link btn-xs' target='_blank' title='Crea una factura de la Certificación' "
//        . " href=\"../clientes/factura_cliente_anadir.php?id_certificacion=_VARIABLE1_ \" >Facturar</a> ";
$actions_row["onclick1_link"]="<a class='btn btn-link btn-xs' target='_blank' title='Crea una factura de la Certificación' "
        . " onclick= \" js_href('../clientes/factura_cliente_anadir.php?id_certificacion=_VARIABLE1_' ) \" >Facturar</a> ";


?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

</div>

<!-- ************ FIN CERTIFICACIONES *************  -->
<!--************ INICIO FACTURAS *************  -->

<!--   <div id="main" class="mainc" style="background-color:green">    -->
<div  style="background-color:lightgreen;float:left;width:100%;padding:0 20px;" >
<?php   // Iniciamos variables para tabla.php  



$result=$Conn->query($sql="SELECT ID_FRA,N_FRA,FECHA_EMISION,concepto,importe_sin_iva as Base_Imponible "
        . ",IMPORTE_IVA, Cobrado,Pdte_Cobro,Observaciones FROM Facturas_View WHERE ID_OBRA=$id_obra ORDER BY FECHA_EMISION" );
$result_T=$Conn->query("SELECT 'Total facturado','' as aa, SUM(IMPORTE_IVA)/$importe_obra as p_facturado, SUM(importe_sin_iva) as Base_Imponible "
        . ",  SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(Cobrado)as Cobrado, SUM(Pdte_Cobro) AS Pdte_Cobro,'' AS A FROM Facturas_View WHERE ID_OBRA=$id_obra " );
$format=[] ;
$formats["IMPORTE_IVA"]='moneda' ;
$formats["Cobrado"]='moneda' ;
$formats["Base_Imponible"]='moneda' ;
$formats["Pdte_Cobro"]='moneda' ;
$formats["p_facturado"]='porcentaje' ;
$formats["Observaciones"]='textarea' ;
$titulo="FACTURAS";
$idtabla="FACTURAS";
$msg_tabla_vacia="No hay";
$links["N_FRA"]=["../clientes/factura_cliente.php?id_fra=", "ID_FRA","ver factura cliente" ,"formato_sub"] ;
$links["CONCEPTO"]=["../clientes/factura_cliente.php?id_fra=", "ID_FRA","ver factura cliente" ,"formato_sub"] ;

 $updates=['CONCEPTO' , '']  ;
//  $id_proveedor=$rs["ID_PROVEEDORES"] ;
  $tabla_update="FRAS_CLI" ;
  $id_update="ID_FRA" ;
//  $id_valor=$id_vale ;
  
 
echo   "<a class='btn btn-link noprint' href='../clientes/factura_cliente_anadir.php?_m=$_m&id_obra=$id_obra' target='_blank' ><i class='fas fa-plus-circle'></i> añadir Factura</a>" ; // BOTON AÑADIR FACTURA

  
  require("../include/tabla.php"); echo $TABLE ;
 
 
 ?>

</div>

<!-- ************ FIN FACTURAS *************  -->

<?php  

$Conn->close();

?>
	 

</div>

	
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');

