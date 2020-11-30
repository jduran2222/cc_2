<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'PERSONAL LISTADO';

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

<?php  

require_once("../personal/personal_menutop_r.php");
 //require("../proveedores/proveedores_menutop_r.php");

?>


<div style="overflow:visible">	   
   
	<!--************ INICIO *************  -->

<div id="main" class="mainc_100" style="background-color:#fff">
	
<?php 
     

$filtro=isset($_POST["filtro"])?$_POST["filtro"] : '' ;
$limite=isset($_POST["limite"])?$_POST["limite"] : 100 ;
$baja= isset($_GET["baja"])? $_GET["baja"] : (isset($_POST["baja"])? $_POST["baja"] : '1=1' );




 ?>

    <h1>LISTADO DE PERSONAL</h1>
    <br><br><br><br>
    <FORM action="personal_listado.php" method="post" id="form1" name="form1">
		Filtro<INPUT id="filtro" type="text" name="filtro" value="<?php echo $filtro;?>" placeholder="Filtro (nombre, Dni...)"   >
		
                <br><input type="radio" name="baja" value="1=1" <?php echo ($baja=="1=1"? 'checked' :'') ;?>> todos 
                <input type="radio" name="baja" value="BAJA=1" <?php echo ($baja=="BAJA=1"? 'checked' :'') ;?>> Personal de Baja
                <input type="radio" name="baja" value="BAJA=0" <?php echo ($baja=="BAJA=0"? 'checked' :'') ;?> > Personal de Alta
                <br>
                
                Filas<select name="limite" form="form1" value="<?php echo $limite ;?>" >
  			<option value="10">10</option>
  			<option value="30" >30</option>
  			<option value="100" selected>100</option>
  			<option value="999999999">Todas</option>
		</select>
                <br>
                <INPUT type="submit" class='btn btn-success btn-xl' value="Actualizar" id="submit1" name="submit1">
</FORM>
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


$sql="SELECT ID_PERSONAL,NOMBRE,CONCEPTO, COSTE , DNI, F_ALTA,Categoria, BAJA,F_BAJA,PROVEEDOR AS Proveedor_Nomina, id_proveedor_nomina, IBAN "
        . " FROM Personal_View WHERE  (CONCAT(IFNULL(NOMBRE,''),IFNULL(DNI,'')) LIKE '%$filtro%') AND $baja AND $where_c_coste  ORDER BY NOMBRE LIMIT $limite" ;

//$sql_T="SELECT  '' AS A1,'' AS B,'Sumas:',  SUM(cargo) as cargo , SUM(ingreso) as ingreso, 'Saldo:' AS A31, SUM(ingreso) - SUM(cargo) as saldo FROM MOV_BANCOS_View WHERE id_cta_banco=$id_cta_banco AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  " ;


//echo $sql ;
$result=$Conn->query($sql) ;
//$result_T=$Conn->query($sql_T) ;

// AÑADE BOTON DE 'BORRAR' PARTE . SOLO BORRARÁ SI ESTÁ VACÍO DE PERSONAL 
 $updates=[]  ;
  $tabla_update="PERSONAL" ;
  $id_update="ID_PERSONAL" ;
    $actions_row=[];
    $actions_row["id"]="ID_PERSONAL";
    $actions_row["delete_link"]="1";
    
    
$links["NOMBRE"] = ["../personal/personal_ficha.php?id_personal=", "ID_PERSONAL",'', "formato_sub"] ;
$links["Proveedor_Nomina"] = ["../proveedores/proveedores_ficha.php?id_proveedor=", "id_proveedor_nomina"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

$formats["F_ALTA"] = "fecha" ;
$formats["IBAN"] = "textarea_10" ;
//$formats["cargo"] = "moneda" ;
$formats["COSTE"] = "moneda" ;
//$formats["fecha_banco"] = "fecha" ;
$formats["BAJA"] = "boolean" ;
//$formats["proveedor_nomina"] = "boolean" ;
//$formats["saldo"] = "moneda" ;
//$formats["ingresos"] = "moneda" ;
//$aligns["Importe_ejecutado"] = "right" ;
//$aligns["Neg"] = "center" ;
//$aligns["Pagada"] = "center" ;
//$tooltips["conc"] = "Indica si el mov. bancario está conciliado" ;
//$tooltips["Banco_Neg"] = "Indica el banco o línea de descuento donde está negociada" ;



//echo   "<a class='btn btn-link btn-lg' href='../personal/personal_anadir.php' target='_blank' ><i class='fas fa-plus-circle'></i> Añadir Personal OLD (empleado)</a>" ; // BOTON AÑADIR FACTURA

echo   "<a class='btn btn-link btn-lg' href='#' onclick=\" js_href2( '../personal/personal_anadir.php?v=1',1,'' ,'PROMPT_Apellidos y Nombre','' , '',''  ) \" ><i class='fas fa-plus-circle'></i> Añadir Personal (empleado)</a>" ; // BOTON AÑADIR FACTURA

$titulo="PERSONAL CONTRATADO ({$result->num_rows})";
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
