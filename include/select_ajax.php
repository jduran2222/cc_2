<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}"; 





require_once("../../conexion.php");
require_once("../include/funciones.php");

//
//logs( 'ESTAMOS EN SELECT_AJAX.PHP');
//logs(print_r($_GET));
//logs( '</pre>');
//

//echo '<pre>';
//print_r($_GET);
//echo '</pre>';

$url_enc=decrypt2($_GET['url_enc']) ;       // codigo encriptado desde el php
$url_raw= ($_GET['url_raw']) ? rawurldecode(($_GET['url_raw'])) : ""  ; // codigo semi-encriptado desde javascript

parse_str( $url_enc.$url_raw , $_GET ) ;     // reconstruimos $_GET[] tras desencriptar y continuamos como si nada

//logs( '<pre>');
//logs(print_r($_GET));
//logs( '</pre>');





$tabla_select=$_GET["tabla_select"]  ;
$campo_ID=$_GET["campo_ID"]  ;
$campo_texto=$_GET["campo_texto"]  ;
$select_id=$_GET["select_id"]  ;
$filtro=$_GET["filtro"]  ;
$otro_where= isset($_GET["otro_where"]) ? $_GET["otro_where"] : "" ;

$cadena_link_encode=$_GET["cadena_link_encode"]  ;    // cadena codificada con urlencode() a ser usada por el update_ajax.php para cambiar el ID_CLIENTE en la Tabla OBRAS 



$filtro= str_replace(" ", "%", trim($filtro) ) ;           // cambiamos los espacios por '%' (* asterísticos en SQL) 
//$sql= "SELECT $campo_ID , `$campo_texto` FROM `$tabla_select` WHERE  $campo_texto  LIKE '%$filtro%' AND $where_c_coste $otro_where ORDER BY $campo_texto "  ;
$sql= "SELECT $campo_ID , `$campo_texto` FROM `$tabla_select` WHERE  $campo_texto  LIKE '%$filtro%' $otro_where ORDER BY $campo_texto "  ;
 
$result = $Conn->query($sql);
	
if ($result->num_rows > 0)
  { 
    $size = ( $result->num_rows > 10 ) ? 10: $result->num_rows ;
    echo ($_SESSION["android"]? "<label id='label_$select_id' class='btn btn-primary' for='$select_id' style='z-index:0' ><p>Selecciona...</p>" : "" ) ;    // en android usamos LABEL, EN pc FALLA
    echo "<select style='z-index:1' id='$select_id' name='$select_id' size=$size onchange=\"ficha_select_onchange('$select_id')\" >" ;
    $cadena_link= urldecode($cadena_link_encode) ;
    echo " <option value='$cadena_link'>Elija una opción de $campo_texto</option>"  ;              // primer options llevará la $cadena_link_ para uso en update_ajax.php
    //echo " <option value='$cadena_link_encode'>$cadena_link_encode</option>"  ;   
    while($rs = $result->fetch_array(MYSQLI_ASSOC))  
    {
     echo " <option value='{$rs[$campo_ID]}'>{$rs[$campo_texto]}</option>"  ; 
    }
    echo "</select>" ; 
    echo ($_SESSION["android"]? "</label>" : "" ) ;   // en android usamos LABEL
    
  } 
   else
   { 
       //echo "___ERROR___" ;                           // mando mensaje de error
       echo "NO HAY VALORES: $sql" ;
   }
   
 $Conn->close();



?>