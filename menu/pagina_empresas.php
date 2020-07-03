<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;   // AND $where_c_coste 
?>
<HTML>
<HEAD>
     <title>Empresas</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</HEAD>
<BODY>





<?php // $id_cta_banco=$_GET["id_cta_banco"];?>

<!-- CONEXION CON LA BBDD Y MENUS -->
<?php
require_once("../../conexion.php");
require_once("../include/funciones.php"); 

//require_once("../menu/topbar.php");

?>


<div style="overflow:visible">	   
   
	<!--************ INICIO *************  -->

<div id="main" class="mainc_100" style="background-color:#fff">
	
  
			 
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


if ($_SESSION["email"])
{

// triquiñuela para si hay parámetro GET admin, ver todas los logos y empresas    
$sql =  isset($_GET["admin"])?  
        "SELECT path_logo,id_usuario,C_Coste_Texto,usuario,IF(admin,'(admin)','') AS admin,IF(autorizado,'(autorizado)','') AS autorizado FROM Usuarios_View "
        . " WHERE activo=1 ORDER BY fecha_creacion DESC  " 
        : "SELECT path_logo,id_usuario,C_Coste_Texto,usuario,IF(admin,'(admin)','') AS admin,IF(autorizado,'(autorizado)','') AS autorizado FROM Usuarios_View "
            . " WHERE email='{$_SESSION["email"]}' AND activo=1   " ;        

$result=$Conn->query($sql) ; 

$links["C_Coste_Texto"]=["../registro/login_as.php?id_usuario=","id_usuario", '','formato_sub'] ;
$formats["C_Coste_Texto"]='h3' ;
$links["usuario"]=["../registro/login_as.php?id_usuario=","id_usuario", '','formato_sub'] ;
//$formats["usuario"]='h3' ;
//$formats["admin"]='h5' ;
//$formats["autorizado"]='h5' ;

$links["path_logo"]=["../registro/login_as.php?id_usuario=","id_usuario", '','formato_sub'] ;
$formats["path_logo"]='pdflink_300_305' ;

$div_size_width=320 ;
$div_size_height=$div_size_width*0.7 ;
$etiquetas_show= 1 ;

$titulo="Empresas disponibles";
$msg_tabla_vacia="No hay.";

require("../include/tabla_cuadros.php");

echo "</div>";

}


$Conn->close();

?>
	 

</div>

	
	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

