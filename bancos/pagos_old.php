<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;   // AND $where_c_coste 
?>
<HTML>
<HEAD>
     <title>Pagos</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>

    <BR><BR><BR><BR><BR><BR>



<?php $tipo=$_GET["tipo"];?>

<!-- CONEXION CON LA BBDD Y MENUS -->
<?php require_once("../../conexion.php"); ?> 
<?php require_once("../menu/topbar.php");?>
<?php require_once("../bancos/bancos_menutop_r.php");?>


<div style="overflow:visible">	   
   
	<!--************ INICIO *************  -->

<div id="main" class="mainc" style="width:80%;background-color:#fff">
	
<?php 
     

$filtro=isset($_POST["filtro"])?$_POST["filtro"] : '' ;
$limite=isset($_POST["limite"])?$_POST["limite"] : 100 ;
$conc=isset($_POST["conc"])?$_POST["conc"] : '1=1' ;
$grupo=isset($_POST["grupo"])?$_POST["grupo"] : 'listado' ;
 ?>

	
    <FORM action="pagos.php?tipo=<?php echo $tipo;?>" method="post" id="form1" name="form1">
		Filtro<INPUT id="filtro" type="text" name="filtro" value="<?php echo $filtro;?>" placeholder="Filtro (concepto, obs, cargo...)"   >
		
                <br><input type="radio" name="conc" value="1=1"> todos 
                <input type="radio" name="conc" value="conc=1"> conciliados
                <input type="radio" name="conc" value="conc=0"> no conciliados
                <br>
                
                Filas<select name="limite" form="form1" value="<?php echo $limite ;?>" >
  			<option value="10">10</option>
  			<option value="30" >30</option>
  			<option value="100" selected>100</option>
  			<option value="999999999">todos</option>
		</select>
                <br>
                <br>Agrupar <input type="radio" name="grupo" value="listado"> listado 
                <input type="radio" name="grupo" value="meses"> por meses
                <input type="radio" name="grupo" value="bancos"> por banco
                <br>
                <INPUT type="submit" class='btn btn-success btn-xl' value='Actualizar' id="submit1" name="submit1">
</FORM>
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045

 switch ($grupo) {
    case "listado":
     $sql="SELECT id_mov_banco,id_pago,id_remesa,f_vto , observaciones,importe,ingreso,FProv,NG,conc, banco, Obs, remesa  FROM Pagos_View WHERE tipo_pago='$tipo' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  ORDER BY f_vto DESC LIMIT $limite" ;
     $sql_T="SELECT '' AS A1 , '' AS A2,SUM(importe) as importe,SUM(ingreso) as ingreso,'' AS B,'' AS C,'' as d,'' as f  FROM Pagos_View WHERE tipo_pago='$tipo' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  ORDER BY f_vto LIMIT $limite" ;
    break;
   case "meses":
     $sql="SELECT  DATE_FORMAT(f_vto, '%Y-%m') as mes,SUM(importe) as importe, SUM(importe*conc) as importe_conc,  SUM(ingreso) as ingreso ,  SUM(ingreso*conc) as ingreso_conc FROM Pagos_View WHERE tipo_pago='P' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  GROUP BY mes " ;
     $sql_T="SELECT  'Sumas' AS A2,SUM(importe) as importe, SUM(importe*conc) as importe_conc,  SUM(ingreso) as ingreso ,  SUM(ingreso*conc) as ingreso_conc  FROM Pagos_View WHERE tipo_pago='P' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  " ;
    break;
   case "bancos":
     $sql="SELECT  id_cta_banco, banco,SUM(importe) as importe, SUM(importe*conc) as importe_conc,  SUM(ingreso) as ingreso ,  SUM(ingreso*conc) as ingreso_conc FROM Pagos_View WHERE tipo_pago='P' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  GROUP BY id_cta_banco " ;
     $sql_T="SELECT  'Sumas' AS A2,SUM(importe) as importe, SUM(importe*conc) as importe_conc,  SUM(ingreso) as ingreso ,  SUM(ingreso*conc) as ingreso_conc  FROM Pagos_View WHERE tipo_pago='P' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  " ;
    break;
 }

//echo $sql ;
$result=$Conn->query($sql) ;
$result_T=$Conn->query($sql_T) ;

$links["f_vto"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago"] ;
$links["observaciones"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago"] ;
$links["remesa"] = ["../bancos/remesa_ficha.php?id_remesa=", "id_remesa"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

$formats["importe"] = "moneda" ;
$formats["importe_conc"] = "moneda" ;
$formats["ingreso_conc"] = "moneda" ;
$formats["ingreso"] = "moneda" ;
$formats["f_vto"] = "fecha" ;
$formats["conc"] = "boolean" ;
$formats["saldo"] = "moneda" ;
//$formats["ingresos"] = "moneda" ;
//$aligns["Importe_ejecutado"] = "right" ;
//$aligns["Neg"] = "center" ;
//$aligns["Pagada"] = "center" ;
$tooltips["conc"] = "Indica si el pago está conciliado" ;
//$tooltips["Banco_Neg"] = "Indica el banco o línea de descuento donde está negociada" ;


$titulo="PAGOS REGISTRADOS";
$msg_tabla_vacia="No hay.";
?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

</div>

<!--************ FIN  *************  -->
	
	

<?php  

$Conn->close();

?>
	 

</div>

	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:30px;">
	
	
	</div>
	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

