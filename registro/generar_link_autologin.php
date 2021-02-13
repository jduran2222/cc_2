<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	

$titulo = 'Generar AutoLogin';


include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');

require_once("../../conexion.php");
require_once("../include/funciones.php");
require_once("../include/funciones_js.php");


    
$password = isset($_POST["password"]) ? $_POST["password"] : '' ;
$id_c_coste_empresa = isset($_POST["id_c_coste"]) ? $_POST["id_c_coste"] : '0' ;



?>

    

<!--<div class="container-fluid">-->	
<!--<div class="row">
    <br><br><br><br><h1>GENERAR LINK AUTOLOGIN</h1>
    <form action="../registro/generar_link_autologin.php" method="post" id="form1" name="form1">
        <h3>
  anulamos la eleccion de empresas, junio 2020     <select class='btn btn-default btn-lg' id='id_c_coste'  ><option value='<?php // echo $id_c_coste_empresa ;?>' >Todas las empresas</option> 
              <?php // echo  DOptions_sql("SELECT id_c_coste,C_Coste_Texto FROM Usuarios_View WHERE email='{$_SESSION["email"]}' AND activo=1 "); ?>
                 </select>
            <br><br>PASSWORD: <INPUT type="password" size='10' name="password" value="<?php echo $password ; ?>">
            <br><br><INPUT type="submit" class='btn btn-success btn-lg' value='generar link' id="submit" name="submit"></h3>
    </form>
    
</div>		-->
	

<?php

 $password_hash_db= Dfirst('password_hash', 'Usuarios', $where_c_coste.  ' AND  id_usuario='.$_SESSION["id_usuario"] )    ;
 
 if (cc_password_verify_hash($password , $password_hash_db))          //  COMPROBACION DE PASSWORD PENDIENTE DE DESARROLLAR
 {       
         
//  $link= $_SESSION["dir_raiz"].'menu/menu_app.php?login='.encrypt2('email='.$_SESSION["dir_raiz"].'&password='. $password )  ; 
  $get_empresa= $id_c_coste_empresa<>'0' ? "&id_c_coste=$id_c_coste_empresa" : "" ;  
//  $get_empresa=  "&id_c_coste=34"  ;  
  $link= $_SESSION["dir_raiz"].'registro/autologin.php?login='.encrypt2("email={$_SESSION["email"]}&password=$password$get_empresa" )  ; 
 }
 else
 {
     $link=$password ? 'ERROR EN PASSWORD' :'' ; 
  
 }


?>
<!--<div class="row">
    <br><br><br><br><h4>LINK: <textarea rows="5" cols="100" name="link" ><?php echo $link ; ?></textarea></h4>
</DIV>   -->


<!--FIN ANTIGUO HTRML-->



  <div class="login-box " style='margin: 0 auto;'>
    <div class="login-logo">

      <img width="128px" src="../img/logo_cc_blanco.svg" alt="Logo ConstruCloud 2.0"/>
      <br>
      <a href="../"><strong>Constru</strong>Cloud 2.0</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">
          Generar link AutoLogin de 
          <strong ><?php echo $_SESSION["user"];  ?></strong>
        </p>

        <form action="../registro/generar_link_autologin.php" method="post">
          <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control" required="required" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3"> 
            Link a copiar <textarea class='small' rows="5" cols="100" name="link" ><?php echo $link ; ?></textarea>
          </div>
          <div class="row">  
            <div class="col-12">
              <button class="btn btn-default" onclick="copyToClipboard('<?php echo $link ; ?>');this.style.color = '#C8C4C3' ;" title='copy a portapapeles' ><i class='far fa-copy'></i></button>      
              <a class="btn btn-default" href='https://wa.me/?<?php echo $link ; ?>' target='_blank' title='enviar link por Whatsapp' ><i class='fab fa-whatsapp'></i></a>      
              <a class="btn btn-default" href="mailto:?subject=ConstruCloud.es link Autologin&body=Link autologin de acceso a ConstruCloud:<br> <?php echo $link ; ?>"  title='enviar link por email' ><i class='far fa-envelope'></i></a> 
            </div>
            <!-- /.col -->

            <!-- /.col -->
          </div>
            
          <hr>
          <div class="row">
            <div class="col-6">
              <button class="btn btn-secondary small text-white" onclick="javascript:window.close();" >Cerrar</button>
            </div>
            <!-- /.col -->
            <div class="col-6">
              <input class="d-none" type="hidden" name="Submit" value="Aceptar"/>
              <button type="submit" class="btn btn-success btn-block">Generar link</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
<br><br><br><br><br><br><br><br><br><br>
  <!-- /.login-box -->

<?php 
//include_once('../templates/_inc_registro3_footer.php');

include_once('../templates/_inc_privado3_footer.php');
