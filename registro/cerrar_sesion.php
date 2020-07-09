<?php
//Eliminación de los datos de sesión
session_start();
session_unset();
session_destroy();

//Retornar al home principal el cual se encargará de entrar en la página que corresponda
header('Location: ../index.php');
