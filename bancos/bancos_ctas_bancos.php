<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$_m=  isset($_GET['_m']) ?  $_GET['_m'] : '' ;
$_m.='\cta_bancaria'  ;

$titulo = 'CUENTAS BANCOS';

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

<?php require_once("bancos_menutop_r.php");?>


<div style="overflow:visible">	   
   
	<!--************ INICIO SUBCONTRATOS *************  -->

<div id="main" class="mainc_100" >
<h1>CUENTAS BANCARIAS</h1>
<?php 
     
$filtro = isset($_POST["filtro"]) ? $_POST["filtro"] : '' ;
$limite = isset($_POST["limite"]) ? $_POST["limite"] : 30 ;
//$activos = isset($_POST["activos"]) ? $_POST["activos"] : 'Activo=1' ;
$activos = isset($_POST["activos"]) ? $_POST["activos"] : '1' ;

//$fmt_activos=isset($_POST["fmt_activos"]) ? ($_POST["fmt_activos"]? 'checked' : '' ) : 'checked'  ;
//$fmt_activos = !isset($_POST["fmt_activos"]) ?  'checked' : '$_POST["fmt_activos"]' ;

//echo $_POST["fmt_activos"] ;
 ?>

<a class="btn btn-link noprint" href="bancos_anadir_cta_banco_form.php"><i class="fas fa-plus-circle"></i> Añadir cuenta bancaria</a><br>
<a class='btn btn-link noprint' href= '../bancos/bancos_mov_bancarios.php' title='pasa a la pantalla de Mov. Bancarios de todas las cuentas bancarias'><i class='fas fa-globe-europe'></i> Mov. bancarios global</a><br>

<div style="width:100% ; border-style:solid;border-width:2px; border-color:silver ;" >
	
 <FORM action="../bancos/bancos_ctas_bancos.php" method="post" id="form1" name="form1">
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
$where=$activos==""? $where : $where . " AND Activo=$activos " ;


$sql="SELECT id_cta_banco,Activo,doc_logo, Banco,Saldo,fecha_ult_mov,DATEDIFF(CURDATE(),fecha_ult_mov) AS num_dias_sa ,num_movs,fecha_primer_mov,tipo as Tipo_Cuenta, "
        . " N_Cta, if(Linea_Dto,'X','') as Linea_Dto , Limite_Dto,Credito_disponible,	Condiciones "
        . "	FROM bancos_saldos WHERE (filtro LIKE '%$filtro%') AND $where_c_coste AND $where  ORDER BY banco LIMIT $limite" ;

$sql_T="SELECT  '' as aaa1,'' as aaa2, 'Suma' as a121,sum(Saldo) as Saldo,'' as a122,'' as a133,SUM(num_movs) as num_movs, '' as a14, '' as a155 , sum( Limite_Dto) as Limite_Dto  "
        . ", sum(Credito_disponible) as Credito_disponible, '' as a13, '' as a15 "
        . "FROM bancos_saldos WHERE (filtro LIKE '%$filtro%') AND $where  AND $where_c_coste  " ;

//$sql="SELECT * FROM bancos_saldos WHERE (filtro LIKE '%$filtro%') AND $where_c_coste  ORDER BY banco LIMIT $limite" ;

//echo $sql ;
$result=$Conn->query($sql) ;
$result_T=$Conn->query($sql_T) ;

$updates=['Activo'] ;
$formats["Limite_Dto"]='moneda' ;
$formats["Credito_disponible"]='moneda' ;
$formats["Saldo"]='moneda' ;
$formats["Activo"]='boolean' ;

$etiquetas["num_dias_sa"]="dias sin act." ;
$tooltips["num_dias_sa"]="Número de días sin actualizar" ;

$links["Banco"] = ["../bancos/bancos_mov_bancarios.php?id_cta_banco=", "id_cta_banco", "", "formato_sub"] ;
//$links["N_Cta"] = $links["Banco"] ;
//$links["N_Cta"] = ["../include/ficha_general.php?url_enc=".encrypt2("tabla=ctas_bancos&id_update=id_cta_banco")."&id_valor=", "id_cta_banco", 'icon'] ;


//$links["Tipo_Cuenta"] = $links["N_Cta"] ;

//$aligns["Limite_Dto"] = "right" ;
//$aligns["Credito_disponible"] = "right" ;
////$aligns["Saldo"] = "right" ;
//$aligns["Linea_Dto"] = "center" ;
//$aligns["Activa"] = "center" ;
$tooltips["Activa"] = "Indica si la cuenta está en uso o no" ;
$tooltips["Linea_Dto"] = "Las líneas de descuento necesitan certificaciones públicas o pagarés privados para disponer del crédito" ;


//  $id_fra=$rs["ID_FRA"] ;
  $tabla_update="ctas_bancos" ;
  $id_update="id_cta_banco" ;
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
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

                <!--</div>-->
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            <!--</div>-->
        <!--</div>-->
        <!-- FIN Contenido principal 

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');