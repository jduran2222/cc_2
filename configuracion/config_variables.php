<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;   // AND $where_c_coste 
?>
<HTML>
<HEAD>
    <TITLE>Variables entorno</TITLE>
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

require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

require_once("../menu/topbar.php");
require_once("../menu/topbar.php"); 


?>



<div style="overflow:visible">	   
   
	<!--************ INICIO SUBCONTRATOS *************  -->

<div id="main" class="mainc_100" >
	<h1>VARIABLES DE ENTORNO</h1>
<?php 
     
$filtro = isset($_POST["filtro"]) ? $_POST["filtro"] : '' ;
$limite = isset($_POST["limite"]) ? $_POST["limite"] : 30 ;

 ?>

<!--<a class="boton" href="bancos_anadir_cta_banco_form.php"><i class="fas fa-plus-circle"></i> Añadir cuenta bancaria</a><br>-->

<div style="width:40% ; border-style:solid;border-width:2px; border-color:silver ;" >
	
    <FORM action="../configuracion/config_variables.php" method="post" id="form1" name="form1">
		<INPUT id="filtro" type="text" name="filtro" value="<?php echo $filtro;?>" placeholder="Filtrar..."   >

		<INPUT type="submit" class='btn btn-success btn-xl' value='Actualizar' id="submit1" name="submit1">
 </FORM>

</div>
	
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045

echo   "<a class='btn btn-primary' href='../configuracion/variable_anadir.php' target='_blank' >Variable nueva</a>" ; // BOTON AÑADIR 

if ($_SESSION["admin"])
{    
//$sql="SELECT *	FROM c_coste_vars_View WHERE (variable LIKE '%$filtro%') AND publica=1 AND ambito<>'MDB' AND $where_c_coste  ORDER BY variable " ;
$sql="SELECT *	FROM c_coste_vars_View WHERE (variable LIKE '%$filtro%')  AND $where_c_coste  ORDER BY variable " ;     // ahora solo ADMIN, ponemos todas las vars
//$sql_T="SELECT  '' as a12,'' as a133, '' as a14, '' as a155 , sum( Limite_Dto) as Limite_Dto,	sum(Credito_disponible) as Credito_disponible,	'' as a13,	sum(Saldo) as Saldo,	'' as a15	FROM bancos_saldos WHERE (filtro LIKE '%$filtro%') AND $where_c_coste  " ;

//$sql="SELECT * FROM bancos_saldos WHERE (filtro LIKE '%$filtro%') AND $where_c_coste  ORDER BY banco LIMIT $limite" ;

//echo $sql ;
$result=$Conn->query($sql) ;
//$result_T=$Conn->query($sql_T) ;

echo "<div class='noprint'>Variables: {$result->num_rows} <br></div>" ;


$updates=['variable','valor'] ;
$tabla_update="c_coste_vars" ;
$id_update="id_variable" ;
$id_clave="id_variable" ;

//$formats["Limite_Dto"]='moneda' ;
//$formats["Credito_disponible"]='moneda' ;
$formats["variable"]='text_edit' ; 
$formats["valor"]='text_edit' ;


//$links["Banco"] = ["../bancos/bancos_mov_bancarios.php?id_cta_banco=", "id_cta_banco"] ;
//$links["N_Cta"] = $links["Banco"] ;
//$links["Tipo_Cuenta"] = $links["Banco"] ;
//
//$aligns["Limite_Dto"] = "right" ;
//$aligns["Credito_disponible"] = "right" ;
//$aligns["Saldo"] = "right" ;
//$aligns["Linea_Dto"] = "center" ;
//$aligns["Activa"] = "center" ;
$tooltips["valor"] = "valor de la variable" ;
//$tooltips["Linea_Dto"] = "Las líneas de descuento necesitan certificaciones públicas o pagarés privados para disponer del crédito" ;



$titulo="";
$msg_tabla_vacia="No hay.";
?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

</div>

<!--************ FIN SUBCONTRATOS *************  -->
	
	

<?php  

}
$Conn->close();

?>
	 

</div>

<!--	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:30px;">
	
	 <script language="javascript" type="text/javascript">
         
            document.writeln("<b>Tú resolución es de:</b> " + screen.width + " x " + screen.height +"");
         //
      </script>
	
	</div>
	-->
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

