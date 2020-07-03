<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	
?>



<HTML>
<HEAD>
<META NAME="GENERATOR" Content="Microsoft FrontPage 5.0">
<TITLE>Generar link</TITLE>
	<link href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" rel=stylesheet type="text/css" hreflang="es">
	<!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>

<body>

<?php 

require_once("../../conexion.php");
require_once("../include/funciones.php");


    
$password = isset($_POST["password"]) ? $_POST["password"] : '' ;
$id_c_coste_empresa = isset($_POST["id_c_coste"]) ? $_POST["id_c_coste"] : '0' ;



?>

    

<!--<div class="container-fluid">-->	
<div class="row">
    <br><br><br><br><h1>GENERAR LINK AUTOLOGIN</h1>
    <form action="../registro/generar_link_autologin.php" method="post" id="form1" name="form1">
        <h3>
<!--  anulamos la eleccion de empresas, junio 2020     <select class='btn btn-default btn-lg' id='id_c_coste'  ><option value='<?php // echo $id_c_coste_empresa ;?>' >Todas las empresas</option> 
              <?php // echo  DOptions_sql("SELECT id_c_coste,C_Coste_Texto FROM Usuarios_View WHERE email='{$_SESSION["email"]}' AND activo=1 "); ?>
                 </select>-->
            <br><br>PASSWORD: <INPUT type="password" size='10' name="password" value="<?php echo $password ; ?>">
            <br><br><INPUT type="submit" class='btn btn-success btn-lg' value='generar link' id="submit" name="submit"></h3>
    </form>
    
</div>		
	

<?php

 $password_hash_db= Dfirst('password_hash', 'Usuarios', $where_c_coste.  ' AND  id_usuario='.$_SESSION["id_usuario"] )    ;
 
 if (cc_password_verify_hash($password , $password_hash_db))          //  COMPROBACION DE PASSWORD PENDIENTE DE DESARROLLAR
 {       
         
//  $link= $_SESSION["dir_raiz"].'menu/menu_app.php?login='.encrypt2('email='.$_SESSION["dir_raiz"].'&password='. $password )  ; 
  $get_empresa= $id_c_coste_empresa<>'0' ? "&id_c_coste=$id_c_coste_empresa" : "" ;  
//  $get_empresa=  "&id_c_coste=34"  ;  
  $link= $_SESSION["dir_raiz"].'registro/registrar.php?login='.encrypt2("email={$_SESSION["email"]}&password=$password$get_empresa" )  ; 
 }
 else
 {
     $link=$password ? 'ERROR EN PASSWORD' :'' ; 
  
 }


?>
<div class="row">
    <br><br><br><br><h4>LINK: <textarea rows="5" cols="100" name="link" ><?php echo $link ; ?></textarea></h4>
</DIV>   

	

<?php require '../include/footer.php'; ?>
</BODY>

</HTML>
