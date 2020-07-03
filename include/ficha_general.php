<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;
?>

<HTML>
<HEAD>
     <title>Config. Empresa</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>

<?php 

 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 require_once("../menu/topbar.php");
 require_once("../menu/topbar.php");


 
 // primero cogemos el id_valor si no viene encriptado
if (isset($_GET["id_valor"]))  
    { $id_valor=$_GET["id_valor"];          // valor de la clave a buscar
      $valor_encriptado=False ;
    }else
    {
    $valor_encriptado=True ;     // id_valor viene dentro del encriptado

    }    

// si el url está encriptado lo desencriptamos y rellenamos de nuevo el $_GET[]
if (isset($_GET['url_enc']))         // venimos ENCRYPTADOS, desencriptamos, juntamos las dos url y metemos en GET las variables
{    
    $url_dec=decrypt2($_GET['url_enc']) ;
    $url_raw= isset($_GET['url_raw']) ? rawurldecode(($_GET['url_raw'])) : ""  ;

    parse_str( $url_dec.$url_raw , $_GET ) ;
    
    if ($valor_encriptado) {$id_valor=$_GET["id_valor"]; }        // si id_valor viene dentro del encriptado lo asignamos 
}


$tabla=$_GET["tabla"];                 // TABLA DONDE COGER EL REGISTRO-FICHA
$id_update=isset($_GET["id_update"])? $_GET["id_update"] : "" ;        // campo para hacer los update de la ficha
$no_update=isset($_GET["no_update"])? $_GET["no_update"] : "" ;        // hace que la ficha sea NO_UPDATE, no actualizable


$where= "`$id_update`=$id_valor" ;                // creo el where para la búsqueda del registro `ID_OBRA`=464

$sql="SELECT * FROM $tabla WHERE $where " ;
//echo $sql ;
$result=$Conn->query($sql);                      // esta búsqueda tiene poca seguridad nececita confirmar lel id_c_coste
$rs = $result->fetch_array(MYSQLI_ASSOC) ;
	
 $titulo= substr( preg_replace('/View/i', '',  str_replace('_', ' ', $tabla) ) , 0, -1); // quitamos las extension View, las _ y la ultima letra previsiblemente una S

// si está definido $no_update es que queremos editar los campos, en caso contrario no editamos nada 
$updates=[] ;
$tabla_update=$tabla ; 

if (!$no_update)         
{
 $updates=["*"] ;
  //$selects["ID_CLIENTE"]=["ID_CLIENTE","CLIENTE","Clientes"] ;   // datos para clave foránea
  //$id_obra=$rs["ID_PROVEEDORES"] ;

  $id_update=$id_update;
  $id_valor=$id_valor ;
  $delete_boton=1;
}   
  
    
  
                  
	   
echo "  <div id='main' class='mainc_100'> ";
      
require("../include/ficha.php");

echo " </div> " ;

?>

	
<?php  

$Conn->close();

?>
	 

</div>

	<!--<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:12px;">FOOTER</div>-->
	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

