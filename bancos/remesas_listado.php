<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Remesa';

//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');

?>

        <!-- Contenido principal -->
        <div class="container-fluid bg-light">
            <div class="row">
                <!--****************** ESPACIO LATERAL  *****************-->
                <div class="col-12 col-md-4 col-lg-3"></div>
                <!--****************** ESPACIO LATERAL  *****************-->

                <!--****************** BUSQUEDA GLOBAL  *****************-->
                <div class="col-12 col-md-4 col-lg-9">


<!-- CONEXION CON LA BBDD Y MENUS -->

<?php require_once("../bancos/bancos_menutop_r.php");?> 
   

<div style="overflow:visible">	   
   
	<!--************ INICIO *************  -->

<div id="main" class="mainc_100" style="background-color:#fff">
	
<?php 
     

$filtro=isset($_POST["filtro"])?$_POST["filtro"] : '' ;
$limite=isset($_POST["limite"])?$_POST["limite"] : 100 ;

$tipo_remesa=isset($_POST["tipo_remesa"])? $_POST["tipo_remesa"] : ( isset($_GET["tipo_remesa"])? $_GET["tipo_remesa"] : '1=1' ) ;
$conc=isset($_POST["conc"])? $_POST["conc"] : ( isset($_GET["conc"])? $_GET["conc"] : '1=1' ) ;
$cobradas=isset($_POST["cobradas"])?$_POST["cobradas"] : '1=1' ;
$grupo=isset($_POST["grupo"])?$_POST["grupo"] : 'listado' ;
 ?>

	
<FORM action="remesas_listado.php" method="post" id="form1" name="form1">
		Remesa<INPUT id="filtro" type="text" name="filtro" value="<?php echo $filtro;?>"    >
		
                <br><input type="radio" name="tipo_remesa" value="1=1"> todas 
                <input type="radio" name="tipo_remesa" value="tipo_remesa='P'"> Remesas Pagos
                <input type="radio" name="tipo_remesa" value="tipo_remesa='C'"> Remesas cobros
                <br>
                
                <br><input type="radio" name="conc" value="1=1"> todas 
                <input type="radio" name="conc" value="activa=1"> Remesas Activas
                <input type="radio" name="conc" value="activa=0"> Remesas no Activas
                <br>
                
                <br><input type="radio" name="cobradas" value="1=1"> todas 
                <input type="radio" name="cobradas" value="cobrada=1"> cobradas
                <input type="radio" name="cobradas" value="cobrada=0"> no cobradas
                <br>
                
                Filas<select name="limite" form="form1" value="<?php echo $limite ;?>" >
  			<option value="10">10</option>
  			<option value="30" >30</option>
  			<option value="100" selected>100</option>
  			<option value="999999999">todos</option>
		</select>
                <br>
<!--                <br>Agrupar <input type="radio" name="grupo" value="listado"> listado 
                <input type="radio" name="grupo" value="meses"> por meses
                <input type="radio" name="grupo" value="bancos"> por banco
                <br>-->
                <INPUT type="submit" class='btn btn-success btn-xl' value='Actualizar' id="submit1" name="submit1">
</FORM>
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045

 switch ($grupo) {
    case "listado":
//     $sql="SELECT id_remesa,remesa,activa,Observaciones,Banco,importe,num_pagos  FROM Remesas_View WHERE  (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  ORDER BY id_remesa DESC LIMIT $limite" ;
     $sql="SELECT id_remesa,activa,tipo_remesa,f_vto,remesa,Observaciones,doc_logo,Banco,importe,ingreso,num_pagos,firmada, cobrada "
            . "  FROM Remesas_View WHERE remesa LIKE '%$filtro%' AND $conc  AND $cobradas AND $tipo_remesa AND $where_c_coste  ORDER BY f_vto,id_remesa DESC LIMIT $limite" ;


     $sql_T="SELECT '' AS A1 ,'' AS A11 ,'Suma:' AS A12 ,'' AS A41 , '' AS A2,SUM(importe) as importe,SUM(ingreso) as ingreso,'' AS B,'' AS C,'' as d,'' as f FROM Remesas_View WHERE remesa LIKE '%$filtro%' AND $conc  AND $cobradas AND $tipo_remesa AND $where_c_coste  " ;
    break;
   case "meses":
//     $sql="SELECT  DATE_FORMAT(f_vto, '%Y-%m') as mes,SUM(importe) as importe, SUM(importe*conc) as importe_conc,  SUM(ingreso) as ingreso ,  SUM(ingreso*conc) as ingreso_conc FROM Pagos_View WHERE tipo_pago='P' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  GROUP BY mes " ;
//     $sql_T="SELECT  'Sumas' AS A2,SUM(importe) as importe, SUM(importe*conc) as importe_conc,  SUM(ingreso) as ingreso ,  SUM(ingreso*conc) as ingreso_conc  FROM Pagos_View WHERE tipo_pago='P' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  " ;
//    break;
   case "bancos":
//     $sql="SELECT  id_cta_banco, banco,SUM(importe) as importe, SUM(importe*conc) as importe_conc,  SUM(ingreso) as ingreso ,  SUM(ingreso*conc) as ingreso_conc FROM Pagos_View WHERE tipo_pago='P' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  GROUP BY id_cta_banco " ;
//     $sql_T="SELECT  'Sumas' AS A2,SUM(importe) as importe, SUM(importe*conc) as importe_conc,  SUM(ingreso) as ingreso ,  SUM(ingreso*conc) as ingreso_conc  FROM Pagos_View WHERE tipo_pago='P' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  " ;
//    break;
 }

echo   "<a class='btn btn-link btn-lg' href='../bancos/remesa_anadir.php' target='_blank' ><i class='fas fa-plus-circle'></i> Añadir Remesa</a>" ;
    
//echo $sql ;
$result=$Conn->query($sql) ;
$result_T=$Conn->query($sql_T) ;

//$links["f_vto"] = ["../bancos/remesa_ficha.php?id_remesa=", "id_remesa"] ;
//$links["observaciones"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago"] ;
$links["remesa"] = ["../bancos/remesa_ficha.php?id_remesa=", "id_remesa", "ver remesa completa", "formato_sub"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

 $updates=['firmada', 'activa','Observaciones']  ;
  $tabla_update="Remesas" ;
  $id_update="id_remesa" ;
    $actions_row=[];
    $actions_row["id"]="id_remesa";
    $actions_row["delete_link"]="1";


$formats["importe"] = "moneda" ;
$formats["importe_conc"] = "moneda" ;
$formats["ingreso_conc"] = "moneda" ;
$formats["ingreso"] = "moneda" ;
$formats["f_vto"] = "fecha" ;
$formats["activa"] = "boolean" ;
$formats["firmada"] = "semaforo" ;
$formats["saldo"] = "moneda" ;
$formats["cobrada"] = "semaforo_OK" ;
//$formats["ingresos"] = "moneda" ;
//$aligns["Importe_ejecutado"] = "right" ;
$aligns["num_pagos"] = "center" ;
//$aligns["Pagada"] = "center" ;
$tooltips["activa"] = "Indica si la Remesa está activa y pueden añadirse pagos" ;
//$tooltips["Banco_Neg"] = "Indica el banco o línea de descuento donde está negociada" ;


$titulo="REMESAS";
$msg_tabla_vacia="No hay.";
?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

</div>

<!--************ FIN  *************  -->
	
	

<?php  

$Conn->close();

?>
	 

</div>

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');