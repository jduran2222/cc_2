<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;   // AND $where_c_coste 
?>
<HTML>
<HEAD>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>


<style type='text/css'>
 
tr:nth-child(odd) {
    background-color:#f2f2f2;
}
tr:nth-child(even) {
    background-color:#ffffff;
}
 
tr:hover {background-color: #ddd;}



.mainc {
  float:left;
  width:50%;
  padding:0 20px;
}
.right2 {
  background-color:lightblue;
  float:left;
  width:40%;
  padding:10px 15px;
  margin-top:7px;
}

@media only screen and (max-width:980px) {
  /* For tablets: antes 800px */
  .mainc, .right2 {
    width:100%;
  }

}
@media only screen and (max-width:980px) {
  /* For mobile phones: antes 500px */
   .mainc, .right2 {
    width:100%;
  }

 
</style>


<?php //if ($_SESSION['logado']=="0") { header("Location: "."cerrar_sesion.asp");}
	?>

<h5><?php echo $_SERVER["SCRIPT_NAME"];?></h5>

<?php $id_proveedor=$_GET["id_proveedor"];?>

<!-- CONEXION CON LA BBDD Y MENUS -->
<?php require_once("../../conexion.php"); ?> 
<?php require_once("../include/funciones.php"); ?> 
<?php require("../menu/topbar.php");?>
<?php require("../proveedores/proveedores_menutop_r.php");?>


<div style="overflow:visible">	   
   
	<!--************ INICIO SUBCONTRATOS *************  -->

<div id="main" class="mainc" style="background-color:#fff">
	
<?php 
      if (isset($_POST["filtro"])) 
	   { $filtro=$_POST["filtro"] ;
	   }
        else
		{ $filtro='' ;
		}   ;

$limite=isset($_POST["limite"])?$_POST["limite"] : 10 ;

 ?>

	
<FORM action="proveedores_facturas.php?id_proveedor=<?php echo $id_proveedor;?>" method="post" id="form1" name="form1">
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


$sql="SELECT ID_FRA_PROV ,N_FRA, FECHA,FECHA_ENTRADA,Fecha_Creacion, IMPORTE_IVA,iva,  conc,FORMAT(pdte_conciliar,2) as Pdte_conciliar, pagada FROM Fras_Prov_View WHERE id_proveedores=$id_proveedor AND (filtro LIKE '%$filtro%') AND $where_c_coste ORDER BY FECHA DESC LIMIT $limite" ;
$sql_T="SELECT '' as a2, '' as a3,sum(Importe_iva) as IMPORTE_IVA,'' as a13,  '' as a111,'' as a15, '' as a16 FROM Fras_Prov_View WHERE id_proveedores=$id_proveedor AND (filtro LIKE '%$filtro%') AND $where_c_coste " ;



//echo $sql ;
$result=$Conn->query($sql) ;
$result_T=$Conn->query($sql_T) ;

$links["N_FRA"] = ["factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV"] ;
//$links["FECHA"]=$links["N_FRA"] ;

$formats["IMPORTE_IVA"]='moneda';
$formats["FECHA"]='dbfecha';
$formats["iva"]='porcentaje0';

$formats["conc"] = "boolean" ;
$formats["pagada"] = "boolean" ;
        
$aligns["Importe_iva"] = "right" ;
$aligns["Pdte_conciliar"] = "right" ;
//$aligns["Importe_ejecutado"] = "right" ;

$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;
$tooltips["pagada"] = "Factura pagada. Se han emitido pagos por importe de la factura" ;


$titulo="FACTURAS DE PROVEEDOR";
$msg_tabla_vacia="No hay.";
?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

</div>

<!--************ FIN SUBCONTRATOS *************  -->
	
	

<?php  

$Conn->close();

?>
	 

</div>

	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:30px;">
	
	 <script language="javascript" type="text/javascript">
         <!--
            document.writeln("<b>Tú resolución es de:</b> " + screen.width + " x " + screen.height +"");
         //-->
      </script>
	
	</div>
	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

