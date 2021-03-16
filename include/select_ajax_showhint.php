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

$tipo_pagina=isset($_GET["tipo_pagina"]) ? $_GET["tipo_pagina"] : "ficha" ;

$url_enc=decrypt2($_GET['url_enc']) ;       // codigo encriptado desde el php
$url_raw= ($_GET['url_raw']) ? rawurldecode(($_GET['url_raw'])) : ""  ; // codigo semi-encriptado desde javascript

parse_str( $url_enc.$url_raw , $_GET ) ;     // reconstruimos $_GET[] tras desencriptar y continuamos como si nada

//logs( '<pre>');
//logs(print_r($_GET));
//logs( '</pre>');


$filtro=$_GET["filtro"]  ;

$tabla_select= isset($_GET["tabla_select"]) ? $_GET["tabla_select"] : "" ;
$campo_ID= isset($_GET["campo_ID"]) ? $_GET["campo_ID"] : 0 ;   // si no mandamos campo ID cogemos el primer campo
$campo_texto= isset($_GET["campo_texto"]) ? $_GET["campo_texto"] : 1 ;
//$select_id= isset($_GET["select_id"]) ? $_GET["select_id"] : "" ;    // en este sistema no es necesario identificar el id_select
$otro_where= isset($_GET["otro_where"]) ? $_GET["otro_where"] : "" ;
$cadena_link_encode= isset($_GET["cadena_link_encode"]) ? $_GET["cadena_link_encode"] : "" ;// cadena codificada con urlencode() a ser usada por el update_ajax.php para cambiar el ID_CLIENTE en la Tabla OBRAS 
$href= isset($_GET["href"]) ? trim($_GET["href"]) : "" ;// cadena codificada con urlencode() a ser usada por el update_ajax.php para cambiar el ID_CLIENTE en la Tabla OBRAS 
$idtabla= isset($_GET["idtabla"]) ? trim($_GET["idtabla"]) : "" ;// cadena codificada con urlencode() a ser usada por el update_ajax.php para cambiar el ID_CLIENTE en la Tabla OBRAS 
$cont= isset($_GET["cont"]) ? trim($_GET["cont"]) : "" ;// contador de ID para identificar los elementos HTML en javascript

//$a_select_cont = $cont ? "a_select_$cont" : "" ;

$sql_sugerir= isset($_GET["sql_sugerir"]) ? $_GET["sql_sugerir"] : "" ;
$javascript_code = isset($_GET["javascript_code"]) ? $_GET["javascript_code"] : "" ;

//$tipo_pagina=isset($_GET["tipo_pagina"]) ? $_GET["tipo_pagina"] : "ficha" ;



$filtro= str_replace(" ", "%", trim($filtro) ) ;           // cambiamos los espacios por '%' (* asterísticos en SQL) 

// creamos el SELECT donde seleccionar la opción
if ($sql_sugerir)   // nuevo sistema de SELECT
{
//    $sql = decrypt2($sql_encode) ;
 $sql = str_replace("_FILTRO_", $filtro, $sql_sugerir) ;   //sustituimos el filtro en su lugar
} else   // compatibilidad con sistema anterior
{
// $sql= "SELECT $campo_ID , `$campo_texto` FROM `$tabla_select` WHERE  $campo_texto  LIKE '%$filtro%' AND $where_c_coste $otro_where ORDER BY $campo_texto "  ; 
 $sql= "SELECT $campo_ID , $campo_texto FROM `$tabla_select` WHERE  $campo_texto  LIKE '%$filtro%' $otro_where ORDER BY $campo_texto LIMIT 15 "  ; 
}   
 
//echo $sql;
$result = $Conn->query($sql);

 if ($result->num_rows > 0) 
  { 
    $cadena_link= $cadena_link_encode ? urldecode($cadena_link_encode) : ""; 
//    echo "<ul id='ul_$select_id' >" ;
    echo "<ul >" ;
    while($rs = $result->fetch_array(MYSQLI_BOTH))
  {
	 $id_valor=$rs[$campo_ID];
	 $filtro=strtoupper($_GET["filtro"] ) ;
	 $valor_texto=str_replace($filtro ,"<b>$filtro</b>", $rs[$campo_texto]);  // Negrita el filtro en MAYUSCULA
	 $filtro=strtolower($filtro ) ;
	 $valor_texto=str_replace($filtro ,"<b>$filtro</b>", $valor_texto);	     // idem minuscula
         
         // formamos los <LI> con los link para update el valor elegido
         if ($cadena_link) 
         { echo  "<li><button class='btn btn-xs btn-link' onclick=\"{$tipo_pagina}_select_onchange_showHint($id_valor,'$cadena_link','$href','$idtabla','$cont','$valor_texto')\">$valor_texto</button></li>"  ; 
         }else
         {    
             $javascript_code_valor = str_replace("_ID_VALOR_", $id_valor, $javascript_code) ;
             echo "<li><a href=# onclick=\"$javascript_code_valor\">$valor_texto</a></li>"  ;
         }        
             
	 //echo "<tr><td><a href=# onClick=\"selectCountry('{$id_valor}')\">$valor_texto</a></td></tr>";
  }
   echo "</ul>" ;
   // echo "</ul>" ;
 }	  


 $Conn->close();



?>