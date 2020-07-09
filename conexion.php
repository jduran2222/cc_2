<?php

$_SESSION["is_desarrollo"] = 1 ;
$Conn = new mysqli("construcloud.es", "db_pruebas2", "y4fEiwnLaWQh2bPQ", 'db_pruebas6');
if ($Conn->connect_error) {
	die("Fallo en conexion: " . $conn->connect_error);
}
else {
	$Conn->set_charset("utf8");
} 

//[TODO] : revisar el punto de las conexiones y sugerir realizar un nuevo módulo para las consultas.
// 1. Comentar la realización de una API de cara al futuro.
// 2. Es un error el tener las coneiones a la BBDD abiertas al cargar toda página, lo suyo sería realizar una conexión por consulta.
