<?php
$dbName = $_SERVER["DOCUMENT_ROOT"] . "/web/pruebas/cimentaciones.mdb";
echo $dbName ;
if (!file_exists($dbName)) {
    die("Could not find database file.");
}
//$db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbName; Uid=; Pwd=;");

//$db = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=$dbName" ,"Administrador", "");

$conn = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=$dbName" );

if (!$conn)
  {exit("Connection Failed: " . $conn);}
$sql="SELECT * FROM Conceptos";
$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}
echo "<table><tr>";
echo "<th>conceptos</th>";
echo "<th>Contactname</th></tr>";
while (odbc_fetch_row($rs))
{
  $compname=odbc_result($rs,"Origen");
  $conname=odbc_result($rs,"Resumen");
  echo "<tr><td>$compname</td>";
  echo "<td>$conname</td></tr>";
}
odbc_close($conn);
echo "</table>";
?>



echo "Terminado" ; 

?>