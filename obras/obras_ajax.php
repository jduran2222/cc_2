<?php 
require_once("../include/session.php"); 

$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;


 //echo "El filtro es:{$_GET["filtro"]}";

$filtro=$_GET["filtro"]  ;
$tipo_subcentro=$_GET["tipo_subcentro"]  ;

if (strlen($filtro)>=3)
{
 require_once("../../conexion.php");
	
// $sql="Select ID_OBRA, NOMBRE_OBRA FROM OBRAS WHERE tipo_subcentro='$tipo_subcentro' AND NOMBRE_OBRA LIKE '%$filtro%' AND $where_c_coste ORDER BY NOMBRE_OBRA LIMIT 5" ;
 $sql="Select ID_OBRA, NOMBRE_OBRA FROM OBRAS WHERE  NOMBRE_OBRA LIKE '%$filtro%' AND $where_c_coste ORDER BY NOMBRE_OBRA LIMIT 5" ;
 //$sql="Select ID_OBRA, NOMBRE_OBRA FROM OBRAS WHERE NOMBRE_OBRA LIKE '%$filtro%' AND $where_c_coste ORDER BY NOMBRE_OBRA LIMIT 5" ;
 
 $result = $Conn->query($sql);
	
 if ($result->num_rows > 0) 
  { echo "<ul >" ;
    while($rs = $result->fetch_array())
  {
	 $id_obra=$rs["ID_OBRA"];
	 $filtro=strtoupper($_GET["filtro"] ) ;
	 $nombre_obra=str_replace($filtro ,"<b>$filtro</b>", $rs["NOMBRE_OBRA"]);  // Negrita el filtro en MAYUSCULA
	 $filtro=strtolower($filtro ) ;
	 $nombre_obra=str_replace($filtro ,"<b>$filtro</b>", $nombre_obra);	     // idem minuscula
         echo "<li><a href=# onclick=\"onClickAjax({$id_obra},'{$nombre_obra}')\">$nombre_obra</a></li>";
	 //echo "<tr><td><a href=# onClick=\"selectCountry('{$id_obra}')\">$nombre_obra</a></td></tr>";
  }
   echo "</ul>" ;
   // echo "</ul>" ;
 }	  
 $Conn->close();
}

?>