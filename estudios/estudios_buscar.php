<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Listado Estudios';

//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');

                  

if (!empty($_POST))
{
  $num_max=$_POST["num_max"];
  $filtro=$_POST["filtro"];
 } else {
  $num_max=20;
  $filtro="";
};
?>

        <!-- Contenido principal -->
        <div class="container-fluid bg-light">
            <div class="row">
                <!--****************** ESPACIO LATERAL  *****************-->
                <div class="col-12 col-md-4 col-lg-3"></div>
                <!--****************** ESPACIO LATERAL  *****************-->

                <!--****************** BUSQUEDA GLOBAL  *****************-->
                <div class="col-12 col-md-4 col-lg-9">




<div align=center class="encabezadopagina2">Buscar Licitaciones</div>
  <!--<a class="boton" href="../estudios/estudios_calendar.php?fecha=<?php echo date("Y-m-d"); ?>" >Calendario Licitaciones</a>-->
  <a class="btn btn-link" href="../estudios/estudios_nuevo.php" ><i class='fas fa-plus-circle'></i> añadir Licitación</a>

  <form action="estudios_buscar.php" method="post" >
    <table width="76%" border="0" align="center">
      <tr>
	     <td width="8%" height="24">Num Max:</td>
	     <td width="7%" height="24"><input name="num_max" type="text" id="num_max" value="<?php   echo $num_max ;?>" size="10" ></td>
	     <td width="54%" height="24"><input name="filtro" type="text" id="filtro" value="<?php   echo $filtro ;?>" size="90" ></td>
         <td width="31%"><input name="submit" type="submit" value="FILTRAR"></td></tr>
	<tr>
	  <td></td>
	  <td></td>
	  <td><font color="#FF0000" size="0">Buscar por: Numero + Nombre + Expdte + Titulo + Organismo </font></td>
	</tr>
    </table>
  </form>	
	
<?php 


	

?>

Numero lineas= <?php   echo $num_max ;?> <BR>
filtro= <?php echo $filtro;?>
	

	
 <?php 

   require ("../../conexion.php");

//$sql="SELECT TOP ". $num_max . " * FROM Estudios_view WHERE filtro2 Like '%".{$_POST["filtro"]}."%' ;";
//$sql="SELECT * FROM Estudios_view WHERE filtro2 Like '%mijas%' ;";
$filtro_mysql=str_replace(" ","%", $filtro ) ;
$sql="SELECT ID_ESTUDIO,NUMERO,NOMBRE,`PLAZO ENTREGA`,`Presupuesto Tipo`,Organismo,`NO VAMOS` FROM Estudios_listado "
        . " WHERE filtro2  LIKE '%". $filtro_mysql ."%' AND $where_c_coste ORDER BY fecha_creacion DESC LIMIT ". $num_max . " ;";
//$sql="SELECT * FROM OBRAS  ;";


$result=$Conn->query($sql);




?>
<div id="main" class="mainc_100" >
<h1>LISTADO LICITACIONES</h1>
	
<?php

$updates=['NO VAMOS'] ;
$formats["PLAZO ENTREGA"]='fecha' ;
$formats["Presupuesto Tipo"]='moneda' ;
//$formats["Saldo"]='moneda' ;
$formats["NO VAMOS"]='boolean' ;

//$etiquetas["num_dias_sa"]="dias sin act." ;
//$tooltips["num_dias_sa"]="Número de días sin actualizar" ;
//
//$links["Banco"] = ["../bancos/bancos_mov_bancarios.php?id_cta_banco=", "id_cta_banco", "", "formato_sub"] ;
////$links["N_Cta"] = $links["Banco"] ;
$links["NOMBRE"] = ["../estudios/estudios_ficha.php?&id_estudio=", "ID_ESTUDIO", '', 'formato_sub'] ;


//$links["Tipo_Cuenta"] = $links["Banco"] ;

//$aligns["Limite_Dto"] = "right" ;
//$aligns["Credito_disponible"] = "right" ;
////$aligns["Saldo"] = "right" ;
//$aligns["Linea_Dto"] = "center" ;
//$aligns["Activa"] = "center" ;
//$tooltips["Activa"] = "Indica si la cuenta está en uso o no" ;
//$tooltips["Linea_Dto"] = "Las líneas de descuento necesitan certificaciones públicas o pagarés privados para disponer del crédito" ;


//  $id_fra=$rs["ID_FRA"] ;
  $tabla_update="Estudios_de_Obra" ;
  $id_update="ID_ESTUDIO" ;
//  $id_valor=$id_cta_banco ;

  $actions_row["delete_link"]="1" ;
  
$titulo="";
$msg_tabla_vacia="No hay.";
?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

</div>


<?php 

$Conn->close();


?>
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');

