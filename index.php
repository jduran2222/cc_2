<?php
//Gestión de sesiones, simplemente con el session_start sería suficiente.
ini_set("session.use_trans_sid",true);
session_start();

header('Location: ./registro/index.php');