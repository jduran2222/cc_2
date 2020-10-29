<?php



if (!isset($entidad))  //descripcion de la entidad no existe, la etimamos
{
    if (isset($titulo_pagina))   //posible título de una página
    {
        $entidad=$titulo_pagina ;
    }elseif (isset($titulo_sin_html)) //posible título de una Ficha
        {
        $entidad=$titulo_sin_html ;
    }else
    {
     $entidad=$tipo_entidad ;
    }
}    
    
    
$sql_insert="INSERT INTO `LRU_entidad` ( id_c_coste,id_usuario, tipo_entidad,id_entidad, entidad) "
        . "   VALUES (  '{$_SESSION['id_c_coste']}', '{$_SESSION['id_usuario']}','$tipo_entidad' ,'$id_entidad' ,'$entidad'  );" ;

if (!($result=$Conn->query($sql_insert)))
{
    logs("ERROR en LRU_registro.php:  $sql_insert");
}      
        
  



?>