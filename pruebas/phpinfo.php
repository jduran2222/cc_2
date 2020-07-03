<?php


 include ("../menu/topbar.php");


var_dump(openssl_get_cert_locations());

// Muestra toda la información, por defecto INFO_ALL
phpinfo();

// Muestra solamente la información de los módulos.
// phpinfo(8) hace exactamente lo mismo.

?>