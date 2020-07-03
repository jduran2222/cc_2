<?php

require_once("../../conexion.php");


$sql = "SELECT * FROM Proyecto_View where id_obra=934 ORDER BY CAPITULO";
$result = $Conn->query($sql);

$header = '';

if ($result->num_rows > 0) {
	
	$header .= "CAPITULO\t";
	$header .= "UDO\t";
	$header .= "MED_PROYECTO\t";
	$header .= "PRECIO\t";
	$header .= "IMPORTE\t\n";
	
    while($rs = $result->fetch_array()) 
	{
       // echo "id: " . $rs[0]. " - Name: " . $rs["usuario"]. "  -   " . $rs[3]. "<br>";
		//$rs["usuario"]="hola";
		//print_r ($rs);
		//echo  "<br><br><br>";
		
    $header .= $rs["CAPITULO"]."\t";
	$header .= $rs["UDO"]."\t";
	$header .= number_format($rs["MED_PROYECTO"],2,',','.')."\t";
	$header .= number_format($rs["PRECIO"],2,',','.')."\t";
	$header .= "=C?*D?\t\n";	
	}
	



header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=exportfile.xls");
header("Pragma: no-cache");
header("Expires: 0");

// output data
echo $header;
}
else
{ echo  "No hay registros" ;}

mysql_close($Conn);
	
?>