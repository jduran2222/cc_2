<?php 
require_once("../include/session.php");

$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

$filtro=$_GET["filtro"]  ;

if (strlen($filtro)>=3)
{
 require_once("../../conexion.php");
	
 $sql="Select ID_PROVEEDORES,filtro FROM ProveedoresF WHERE filtro LIKE '%$filtro%' AND $where_c_coste ORDER BY PROVEEDOR LIMIT 5" ;
 $result = $Conn->query($sql);
	
 if ($result->num_rows > 0) 
  { echo "<ul >" ;
    while($rs = $result->fetch_array())
  {
	 $id=$rs["ID_PROVEEDORES"];
	 $filtro=strtoupper($_GET["filtro"] ) ;
	 $nombre=str_replace($filtro ,"<b>$filtro</b>", $rs["filtro"]);  // Negrita el filtro en MAYUSCULA
	 $filtro=strtolower($filtro ) ;
	 $nombre=str_replace($filtro ,"<b>$filtro</b>", $nombre);	     // idem minuscula
	 echo "<li><a href=# onClick=\"onClickAjax_prov('{$id}')\">$nombre</a></li>";
	
  }
   echo "</ul>" ;
   // echo "</ul>" ;
 }	  
 $Conn->close();
}

?>