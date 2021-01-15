<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Variables de entorno';

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

                </div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <br><br><br><br><br><br><br><br><br><br>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
