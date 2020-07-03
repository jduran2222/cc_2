<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;   // AND $where_c_coste 
?>
<HTML>
<HEAD>
     <title>Subcontratos</title> 
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


//require_once("../../conexion.php"); 
//require_once("../include/funciones.php"); 
require_once("../menu/topbar.php");

// cogemos el parámetro GET comprobando su coherencia con el id_c_coste
if (!($id_proveedor=Dfirst( "ID_PROVEEDORES" ,"Proveedores"," $where_c_coste AND ID_PROVEEDORES={$_GET['id_proveedor']} " ))) {die("<br><br><br><br><h1>ERROR PROVEEDOR NO ENCONTRADO</h1>");}

require_once("proveedores_menutop_r.php");

?>

<div style="overflow:visible">	   
   
	<!--************ INICIO SUBCONTRATOS *************  -->

<div id="main" class="mainc_100" style="background-color:#fff">
	
<?php 
     
$filtro = isset($_POST["filtro"]) ? $_POST["filtro"] : '' ;
$limite = isset($_POST["limite"]) ? $_POST["limite"] : 10 ;

 ?>

<br><br><br><br><br>
	 
<FORM action="proveedores_subcontratos.php?id_proveedor=<?php echo $id_proveedor;?>" method="post" id="form1" name="form1">
		<INPUT id="filtro" type="text" name="filtro" value="<?php echo $filtro;?>"   >
		<select name="limite" form="form1" value="<?php echo $limite ;?>" >
  			<option value="10">10</option>
  			<option value="30">30</option>
  			<option value="100">100</option>
  			<option value="999999999">Todas</option>
		</select>	
		<INPUT type="submit" class='btn btn-success btn-xl' value='Actualizar' id="submit1" name="submit1">
</FORM>
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045



//$sql="SELECT id_subcontrato, id_obra, NOMBRE_OBRA ,subcontrato,fecha_creacion,FORMAT(Importe_cobro,2) as Importe_cobro, FORMAT(Importe_subcontrato,2) as Importe_subcontrato,CONCAT(FORMAT(100*Margen,2),'%') as Margen  ,	FORMAT(Importe_ejecutado,2) as Importe_ejecutado,CONCAT(FORMAT(100*Porc_ej,1),'%') as  Porc_ej FROM Subcontratos_todos_View WHERE id_proveedor=$id_proveedor AND (filtro LIKE '%$filtro%') ORDER BY fecha_creacion DESC LIMIT $limite" ;
$sql="SELECT id_subcontrato, id_obra, NOMBRE_OBRA ,subcontrato,fecha_creacion,Importe_cobro,  Importe_subcontrato, Margen  ,Importe_ejecutado, Porc_ej "
        . " FROM Subcontratos_todos_View WHERE id_proveedor=$id_proveedor AND (filtro LIKE '%$filtro%') ORDER BY fecha_creacion DESC LIMIT $limite" ;
$sql_T="SELECT '' as a, '' as b, '' as c, SUM( Importe_cobro) as Importe_cobro, SUM( Importe_subcontrato) as Importe_subcontrato,'' AS DD  ,SUM(Importe_ejecutado) as Importe_ejecutado, '' AS FF FROM Subcontratos_todos_View WHERE id_proveedor=$id_proveedor AND (filtro LIKE '%$filtro%') GROUP BY id_proveedor" ;


//echo $sql ;
$result=$Conn->query($sql) ;
$result_T=$Conn->query($sql_T) ;

$links["subcontrato"] = ["../obras/subcontrato.php?id_subcontrato=", "id_subcontrato", "", "formato_sub"] ;
$links["NOMBRE_OBRA"] = ["../obras/obras_ficha.php?id_obra=", "id_obra"] ;

//$aligns["Importe_cobro"] = "right" ;
//$aligns["Importe_subcontrato"] = "right" ;
//$aligns["Importe_ejecutado"] = "right" ;
//$aligns["Margen"] = "center" ;
//$aligns["Porc_ej"] = "center" ;
$tooltips["Margen"] = "Margen de beneficio entre el cobro y lo subcontratado" ;
$tooltips["Porc_ej"] = "Porcentaje de subcontrato ejecutado" ;


$titulo="SUBCONTRATOS DEL PROVEEDOR";
$msg_tabla_vacia="No hay.";
?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

</div>

<!--************ FIN SUBCONTRATOS *************  -->
	
	

<?php  

$Conn->close();

?>
	 

</div>

<!--	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:30px;">
	
	 <script language="javascript" type="text/javascript">
         
            document.writeln("<b>Tú resolución es de:</b> " + screen.width + " x " + screen.height +"");
         //
      </script>
	
	</div>-->
	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

