<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;   // AND $where_c_coste 
?>
<HTML>
<HEAD>
    <TITLE>Tabla General</TITLE>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>

 



<?php // $id_cta_banco=$_GET["id_cta_banco"];?>

<!-- CONEXION CON LA BBDD Y MENUS -->
<?php require_once("../../conexion.php"); ?> 
<?php require_once("../include/funciones.php"); ?> 
<?php require_once("../menu/topbar.php");?>


<div style="overflow:visible">	   
   
	<!--************ INICIO *************  -->

<div id="main" class="mainc_100" style="background-color:#fff">
	
<?php 
     
//foreach ($_GET as $clave => $valor)
//{
//    if(is_encrypt2($valor)) { $_GET[$clave]= decrypt2($valor) ;}      // desencriptamos cualquier get encriptado
//}


echo '<BR><BR><BR><BR>';
//echo '<BR>VALOR decrypt url<BR>';
//echo  decrypt2($_GET['url']) ;
//
//
//echo '<BR>PRIMER VALOR<BR>';
//echo $_SERVER['QUERY_STRING'] ;

//echo '<pre>';
//print_r($_GET);
//echo '</pre>';

if (isset($_GET['url_enc']))         // Si venimos ENCRYPTADOS, desencriptamos, juntamos las dos url y metemos en GET las variables
{    
    $url_dec=decrypt2($_GET['url_enc']) ;
    $url_raw= isset($_GET['url_raw']) ? rawurldecode(($_GET['url_raw'])) : ""  ;

    parse_str( $url_dec.$url_raw , $_GET ) ;
}





//echo '<BR>segundo valor tras cambios VALOR<BR>';
//echo $_SERVER['QUERY_STRING'] ;

$link= ''; 

if (isset($_GET["sql"]))
{
    $sql=$_GET["sql"];
    
}else
{    
    
$tabla=  is_encrypt2($_GET["tabla"]) ?  decrypt2($_GET["tabla"])  :  $_GET["tabla"] ;
$where=  is_encrypt2($_GET["where"]) ?  decrypt2($_GET["where"])  :  $_GET["where"] ;
//$where=$_GET["where"]  ;

$select= isset($_GET["select"])? ( is_encrypt2($_GET["select"]) ?  decrypt2($_GET["select"])  :  $_GET["select"] ) : "*" ;
$order_by= isset($_GET["order_by"])? (is_encrypt2($_GET["order_by"]) ?  " ORDER BY ".decrypt2($_GET["order_by"])  :  " ORDER BY ".$_GET["order_by"]): "" ;
$limit= isset($_GET["limit"])? ( is_encrypt2($_GET["limit"]) ? " LIMIT ". decrypt2($_GET["limit"])  : " LIMIT ". $_GET["limit"]) : "" ;

$link= isset($_GET["link"])? ( is_encrypt2($_GET["link"]) ?  decrypt2($_GET["link"])  :  $_GET["link"] )  :  "" ;
$campo_id=  isset($_GET["campo_id"])? ( is_encrypt2($_GET["campo_id"]) ?  decrypt2($_GET["campo_id"])  :  $_GET["campo_id"] ) : "" ;
$campo=  isset($_GET["campo"])? ( is_encrypt2($_GET["campo"]) ?  decrypt2($_GET["campo"])  :  $_GET["campo"]) : "" ;


//$select= isset($_GET["select"])? $_GET["select"] : "*" ;
//$order_by= isset($_GET["order_by"])? " ORDER BY ".$_GET["order_by"] : "" ;
//$limit= isset($_GET["limit"])? " LIMIT ".$_GET["limit"] : "" ;

//$link= isset($_GET["link"])? $_GET["link"] : "" ;
//$campo_id= isset($_GET["campo_id"])? $_GET["campo_id"] : "" ;
//$campo= isset($_GET["campo"])? $_GET["campo"] : "" ;

$sql="SELECT $select FROM $tabla WHERE  $where  $order_by $limit  " ;

}


//if ($admin)
//{    
//echo $sql ;
//echo '<pre>';
//print_r($_GET);
//echo '</pre>';
//}

$titulo= isset($titulo) ? "<h1>$titulo</h1>" : "<h1>$tabla</h1>" ;


if ($admin)  {echo "<span class='c_text'>solo admin: $sql </span> "; } ;
logs("Tabla general: $sql") ;
$result=$Conn->query($sql) ;
//$result_T=$Conn->query($sql_T) ;

// AÑADE BOTON DE 'BORRAR' PARTE . SOLO BORRARÁ SI ESTÁ VACÍO DE PERSONAL 
// $updates=[]  ;
//  $tabla_update="PERSONAL" ;
//  $id_update="ID_PERSONAL" ;
//    $actions_row=[];
//    $actions_row["id"]="ID_PERSONAL";
//    $actions_row["delete_link"]="1";
//    
//    

if ($link)  
{   
   $links[$campo] = [str_replace("__AND__", "&", $link ), $campo_id,'', 'formato_sub'] ;  // cambiamos __AND__ por su simbolo & para compatibilizar con ficha_general
}

$scroll='';

//$titulo="$tabla <BR> $where";

$msg_tabla_vacia="No hay.";
?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

</div>

<!--************ FIN MOV. BANCO *************  -->
	
	

<?php  

$Conn->close();

?>
	 

</div>

	
	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

