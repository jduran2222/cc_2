<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Tabla General';

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
 



<?php // $id_cta_banco=$_GET["id_cta_banco"];?>

<!-- CONEXION CON LA BBDD Y MENUS -->

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


$sql="SELECT $select FROM $tabla WHERE  $where  $order_by $limit  " ;

}


$link= isset($_GET["link"])? ( is_encrypt2($_GET["link"]) ?  decrypt2($_GET["link"])  :  $_GET["link"] )  :  "" ;
$campo_id=  isset($_GET["campo_id"])? ( is_encrypt2($_GET["campo_id"]) ?  decrypt2($_GET["campo_id"])  :  $_GET["campo_id"] ) : "" ;
$campo=  isset($_GET["campo"])? ( is_encrypt2($_GET["campo"]) ?  decrypt2($_GET["campo"])  :  $_GET["campo"]) : "" ;


//if ($admin)
//{    
//echo $sql ;
//echo '<pre>';
//print_r($_GET);
//echo '</pre>';
//}

$titulo= isset($_GET["titulo"])? $_GET["titulo"] : ( isset($tabla) ? "$tabla" : "$titulo") ;
$titulo="<h1>$titulo</h1>";

if ($admin)  {echo "<span class='c_text'>solo admin: $sql </span> "; } ;
//logs("Tabla general: $sql") ; 
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

	
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
