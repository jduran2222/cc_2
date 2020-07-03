<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;
?>

<HTML>
<HEAD>
     <title>Parte diario</title>

	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</HEAD>
<BODY>

<style type='text/css'>
    
@media all {
   div.saltopagina{
      display: none;
   }
}
   
@media print{
   div.saltopagina{ 
      display:block; 
      page-break-before:always;
   }
}    

</style>
	
                    
<div style="overflow:visible">	   
  <div id="main" class="mainc_100"> 
  <a href='javascript:window.print(); void 0;'>Imprimir</a>    
  

<?php 

 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 

 if (isset($_GET["id_parte"]))
{  
  $id_parte= $_GET["id_parte"];
  $where= " ID_PARTE=$id_parte " ;
}
elseif (isset($_GET["id_parte_sel"]))
{   
     $where= " ID_PARTE IN {$_GET["id_parte_sel"]} " ; 
}
else   // ERROR EN PARAMETROS _GET
{
     $where= " 1=0 " ;
}  
 

           // DATOS   FICHA . PHP
 //echo "<pre>";
 $result_GRAL=$Conn->query($sql="SELECT ID_PARTE,ID_OBRA,ID_PARTE as NUM_ID_PARTE, NOMBRE_OBRA,Fecha,Observaciones FROM Partes_View WHERE $where AND $where_c_coste");
// $rs = $result->fetch_array(MYSQLI_ASSOC) ;
//while ($a = $result->fetch_field()) {

//print_r ($rs);
//}
//echo "</pre>";
 
 echo "<br>Total partes: " . $result_GRAL->num_rows ;
 
if ($result_GRAL->num_rows>0)
{
 while( $rs = $result_GRAL->fetch_array(MYSQLI_ASSOC)) 
 {


  
//    $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS"] ;   // datos para clave foránea
//  $links["ID_OBRA"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

  
//  $updates=['NOMBRE','DNI','F_ALTA','BAJA', 'F_BAJA' , 'Observaciones', 'pagada']  ;
  
  $id_parte=$rs["ID_PARTE"] ;
  
  $titulo="PARTE DE OBRA Nº $id_parte" ;
  
  $updates=[]  ;
//  $id_proveedor=$rs["ID_PROVEEDORES"] ;
  $tabla_update="PARTES" ;
  $id_update="ID_PARTE" ;
  $id_valor=$id_parte ;
    
  $id_obra=$rs["ID_OBRA"] ;
  $fecha=$rs["Fecha"] ;
  
  $rs["Fecha"]=cc_format($rs["Fecha"],'fecha_semana') ;
  
  $formats["NOMBRE_OBRA"] = "h3" ;
  $formats["Fecha"] = "h3" ;
  $formats["Observaciones"] = "h5" ;

  
  $print_pdf=1;
  
  $result=$result_GRAL ;
  
  require("../include/ficha.php");
  
  ?>
   
      <!--// FIN     **********    FICHA.PHP-->
  </div>
      
<!-- CONTROL CARGO A OBRA.  ID_VALE-->    
    
 

	
<?php            // ----- div PARTES PERSONAL  tabla.php   -----<!--  DETALLE DEL PARTE -->

//$sql="SELECT id,ID_PERSONAL,NOMBRE,DNI,HO,HX,MD,DC,Observaciones FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
$sql="SELECT id,ID_PERSONAL,NOMBRE,DNI,HO, Observaciones FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
//echo $sql;
$result=$Conn->query($sql );

//$sql="SELECT 'Suma' ,COUNT(ID_PERSONAL) as B,SUM(HO) as HO,SUM(HX) as HX,SUM(MD) as MD,SUM(DC) as DC FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
$sql="SELECT 'Suma' ,COUNT(ID_PERSONAL) as B,SUM(HO) as HO, '' FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
//echo $sql;
$result_T=$Conn->query($sql );

//$updates=['HO','HX','MD','DC', 'Observaciones']  ;
//$tabla_update="PARTES_PERSONAL" ;
//$id_update="id" ;
//
//$actions_row=[];
//$actions_row["id"]="id";
////$actions_row["update_link"]="../include/update_row.php?tabla=Fra_Cli_Detalles&where=id=";
////$actions_row["delete_link"]="../include/tabla_delete_row.php?tabla=PARTES_PERSONAL&where=id=";
//$actions_row["delete_link"]="1";
//

//$id_clave="id" ;

//$formats["FECHA"]='fecha';
//$formats["importe"]='moneda';
//
//$links["NOMBRE"] = ["../personal/personal_ficha.php?id_personal=", "ID_PERSONAL"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//
//$aligns["importe"] = "right" ;
//$aligns["Pdte_conciliar"] = "right" ;
////$aligns["Importe_ejecutado"] = "right" ;

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="<h3>Personal en obra</h3>" ;
$msg_tabla_vacia="No hay personal";

?>

        <!--<div id="main" class="mainc">-->
<!--<div  style="background-color:Khaki;float:left;width:60%;padding:0 20px;" >-->
<div  style="float:left;width:100%;padding:0 20px;" >
     
<?php  require("../include/tabla.php"); echo $TABLE ; ?>
 
    <br>
</div>    
    <!--//////   MAQUINARIA PROPIA  ///////-->
    
  <?php            
  

//$sql="SELECT id,ID_PERSONAL,NOMBRE,DNI,HO,HX,MD,DC,Observaciones FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
$sql="SELECT id,id_obra_mq,Maquinaria,id_concepto_mq,CONCEPTO, cantidad , Observaciones FROM Partes_Maquinas_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
//echo $sql;
$result=$Conn->query($sql );



//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="<h3>Maquinaria Propia</h3>" ;
$msg_tabla_vacia="No hay maquinaria";

?>

        <!--<div id="main" class="mainc">-->
<div  style="float:left;width:100%;padding:0 20px;" >


     
<?php  require("../include/tabla.php"); echo $TABLE ; ?>  
    
    <br>
	 
</div>
       <!--FIN MAQUINARIA PROPIA-->  
	
 
   <!--//////   ALBARANES ASOCIADOS  ///////-->
 <div  style="float:left;width:100%;padding:0 20px;" >
   
  <?php            
  

//$sql="SELECT id,ID_PERSONAL,NOMBRE,DNI,HO,HX,MD,DC,Observaciones FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
$sql="SELECT ID_VALE,ID_PROVEEDORES,ID_FRA_PROV,NOMBRE_OBRA, FECHA, PROVEEDOR, REF, importe, Observaciones FROM Vales_view  WHERE ID_OBRA=$id_obra AND FECHA='$fecha' AND $where_c_coste    ";
//echo $sql;
$result=$Conn->query($sql );




//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="<h3>Albaranes</h3>" ;
$msg_tabla_vacia="No hay Albaranes";

?>

        <!--<div id="main" class="mainc">-->


     
<?php  require("../include/tabla.php"); echo $TABLE ; ?>  
    
        <center><br><br>------FIN DEL PARTE------</center>
        <div class="saltopagina"></div>
	 
</div>
       <!--FIN ALBARANES ASOCIADOS-->  
		

	
<?php  

 }

}
else
{
    echo "<h1>NO HA SELECCIONADO PARTES</h1>" ;
}    






$Conn->close();

?>
	 
   
        
        
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

