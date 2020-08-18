<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Acceso web';

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


<?php $id_cta_banco=$_GET["id_cta_banco"];?>

<!-- CONEXION CON LA BBDD Y MENUS -->
<?php // require("../bancos/bancos_menutop_r.php");?>


<div style="overflow:visible">	   
   
	<!--************ INICIO *************  -->

<div id="main" class="mainc" style="background-color:#fff">
	
<?php 
     

$filtro=isset($_POST["filtro"])?$_POST["filtro"] : '' ;
$limite=isset($_POST["limite"])?$_POST["limite"] : 100 ;

 ?>

	
    <FORM action="accesos_web.php?limite=<?php echo $limite;?>" method="post" id="form1" name="form1">
		Filtro<INPUT id="filtro" type="text" name="filtro" value="<?php echo $filtro;?>" placeholder="Filtro (concepto, obs, cargo...)"   >
		
                
                
                Filas<select name="limite" form="form1" value="<?php echo $limite ;?>" >
  			<option value="100">10</option>
  			<option value="300" >30</option>
  			<option value="1000" selected>100</option>
  			<option value="999999999">Todos</option>
		</select>
                <br>
                <INPUT type="submit" value="buscar" id="submit1" name="submit1">
</FORM>
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


$sql="SELECT *  FROM w_Accesos WHERE (CONCAT(ip,usuario,clave,resultado) LIKE '%$filtro%') AND $where_c_coste  ORDER BY fecha_creacion DESC LIMIT $limite" ;

//$sql_T="SELECT  '' AS A1,'' AS B,'Sumas:',  SUM(cargo) as cargo , SUM(ingreso) as ingreso, 'Saldo:' AS A31, SUM(ingreso) - SUM(cargo) as saldo FROM MOV_BANCOS_View WHERE id_cta_banco=$id_cta_banco AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  " ;


//echo $sql ;
$result=$Conn->query($sql) ;
//$result_T=$Conn->query($sql_T) ;

//$links["conc"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

//
//$formats["ingresos"] = "moneda" ;
//$aligns["Importe_ejecutado"] = "right" ;
//$aligns["Neg"] = "center" ;
//$aligns["Pagada"] = "center" ;
//$tooltips["conc"] = "Indica si el mov. bancario está conciliado" ;
//$tooltips["Banco_Neg"] = "Indica el banco o línea de descuento donde está negociada" ;


$titulo="ACCESOS VIA WEB";
$msg_tabla_vacia="No hay.";
?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

</div>

<!--************ FIN MOV. BANCO *************  -->
	
	

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
