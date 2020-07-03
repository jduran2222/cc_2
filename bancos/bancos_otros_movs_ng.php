<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;   // AND $where_c_coste 
$_m=  isset($_GET['_m']) ?  $_GET['_m'] : '' ;
$_m.='\cta_bancaria'  ;

?>
<HTML>
<HEAD>
     <title>Cuentas bancarias</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
        	<!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>




<!-- CONEXION CON LA BBDD Y MENUS -->
<?php 

require_once("../menu/topbar.php");
require_once("bancos_menutop_r.php");?>


<div style="overflow:visible">	   
   
	<!--************ INICIO SUBCONTRATOS *************  -->

<div id="main" class="mainc_100" >
	<h1>OTRAS CUENTAS</h1>
<?php 
     
$filtro = isset($_POST["filtro"]) ? $_POST["filtro"] : '' ;
$limite = isset($_POST["limite"]) ? $_POST["limite"] : 30 ;
//$activos = isset($_POST["activos"]) ? $_POST["activos"] : 'Activo=1' ;
$activos = isset($_POST["activos"]) ? $_POST["activos"] : '1' ;

//$fmt_activos=isset($_POST["fmt_activos"]) ? ($_POST["fmt_activos"]? 'checked' : '' ) : 'checked'  ;
//$fmt_activos = !isset($_POST["fmt_activos"]) ?  'checked' : '$_POST["fmt_activos"]' ;

//echo $_POST["fmt_activos"] ;
 ?>

<a class="btn btn-link btn-lg" href="bancos_anadir_cta_banco_form.php"><i class="fas fa-plus-circle"></i> Añadir cuenta bancaria</a><br>

<div style="width:100% ; border-style:solid;border-width:2px; border-color:silver ;" >
	
 <FORM action="../bancos/bancos_otros_movs_ng.php" method="post" id="form1" name="form1">
		<INPUT id="filtro" type="text" name="filtro" value="<?php echo $filtro;?>" placeholder="Filtrar..."   >
               

<!--		<br>Solo bancos Activos<select name="activos" form="form1" value="<?php // echo $activos ;?>" >
  			<option value="SI" selected>SI</option>
  			<option value="NO" >NO</option>
  		</select>	-->
 <?php               
 $radio=$activos ;
$chk_todos =  ""  ; $chk_on =  ""  ; $chk_off =  ""  ;
if ($radio=="") { $chk_todos =   "checked"  ;} elseif ($radio==1) { $chk_on =   "checked"  ;} elseif ($radio==0)  { $chk_off =   "checked"  ;}
echo "<br><input type='radio' id='activos' name='activos' value='' $chk_todos />Todas      <input type='radio' id='activos' name='activos' value='1' $chk_on />activos  <input type='radio' id='activos' name='activos' value='0' $chk_off  />No activos" ;
 ?>              
		<br>Limite:<select name="limite" form="form1" value="<?php echo $limite ;?>" >
  			<option value="10">10</option>
  			<option value="30" selected>30</option>
  			<option value="100">100</option>
  			<option value="999999999">Todas</option>
		</select>	
		<INPUT type="submit" class='btn btn-success btn-xl' value='Actualizar' id="submit1" name="submit1">
 </FORM>

</div>
	
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045

//$where_activos = $activos='SI'? ' Activo=1 ' : ' 1=1 '  ;
$where=' 1=1 ';
//$where_activos = ($activos=='SI')? ' Activo=1 ' : ' 1=1 '  ;
$where=$activos==""? $where : $where . " AND Cuenta_otros_mov_bancos=$activos " ;


$sql="SELECT id_nota_gastos,Cuenta_otros_mov_bancos,observaciones,importe,facturas,cargo,abono,cargo-abono as saldo "
        . "	FROM Nota_Gastos_View WHERE (NOMBRE LIKE '%$filtro%') AND $where_c_coste AND $where  ORDER BY NOMBRE LIMIT $limite" ;
//$sql_T="SELECT  '' as aaa1, 'Suma' as a121,sum(Saldo) as Saldo,'' as a122,'' as a133,SUM(num_movs) as num_movs, '' as a14, '' as a155 , sum( Limite_Dto) as Limite_Dto  "
//        . ", sum(Credito_disponible) as Credito_disponible, '' as a13, '' as a15 "
//        . "FROM bancos_saldos WHERE (filtro LIKE '%$filtro%') AND $where  AND $where_c_coste  " ;

//$sql="SELECT * FROM bancos_saldos WHERE (filtro LIKE '%$filtro%') AND $where_c_coste  ORDER BY banco LIMIT $limite" ;

//echo $sql ;
$result=$Conn->query($sql) ;
//$result_T=$Conn->query($sql_T) ;

$updates=['NOMBRE','','Cuenta_otros_mov_bancosXXX'] ;
$formats["facturas"]='moneda' ;
$formats["cargo"]='moneda' ;
$formats["abono"]='moneda' ;
$formats["saldo"]='moneda' ;
//$formats["observaciones"]='textarea' ;
//$formats["Cuenta_otros_mov_bancos"]='boolean' ;
//
//$etiquetas["num_dias_sa"]="dias sin act." ;
//$tooltips["num_dias_sa"]="Número de días sin actualizar" ;
//
$links["observaciones"] = ["../bancos/pagos_y_cobros.php?cuenta=", "observaciones", "", "formato_sub"] ;
$etiquetas["observaciones"] = "Cuenta" ;
$etiquetas["Cuenta_otros_mov_bancos"] = "C" ;

////$links["N_Cta"] = $links["Banco"] ;
//$links["N_Cta"] = ["../include/ficha_general.php?tabla=ctas_bancos&id_update=id_cta_banco&id_valor=", "id_cta_banco", 'icon'] ;
//
//
//$links["Tipo_Cuenta"] = $links["Banco"] ;
//
//$aligns["Limite_Dto"] = "right" ;
//$aligns["Credito_disponible"] = "right" ;
//$aligns["Saldo"] = "right" ;
//$aligns["Linea_Dto"] = "center" ;
//$aligns["Activa"] = "center" ;
//$tooltips["Activa"] = "Indica si la cuenta está en uso o no" ;
//$tooltips["Linea_Dto"] = "Las líneas de descuento necesitan certificaciones públicas o pagarés privados para disponer del crédito" ;


//  $id_fra=$rs["ID_FRA"] ;
  $tabla_update="NOTAS_GASTOS" ;
  $id_update="id_nota_gastos" ;
//  $id_valor=$id_cta_banco ;

  $actions_row["delete_link"]="1" ;
  
$titulo="";
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

