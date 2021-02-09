<?php

$titulo = 'Accede a tu cuenta';

include_once('../templates/_inc_registro1_header.php');

//Comprobaciones de acceso:
$user     = (isset($_SESSION['user']) ? $_SESSION['user'] : '');
$empresa  = (isset($_SESSION['empresa']) ? $_SESSION['empresa'] : '');

//Comprobar credenciales.
$credenciales  = (isset($_GET['credenciales']) ? $_GET['credenciales'] : '');
$htmlAlert = '';
if ($credenciales == 'false') {
  $htmlAlert = '<div class="alert alert-warning small" role="alert">Imposible conectar con estas credenciales.</div>';
}

?>

  <div class="login-box">
    <div class="login-logo">

      <img width="128px" src="../img/logo_cc_blanco.svg" alt="Logo ConstruCloud 2.0"/>
      <br>
      <a href="../"><strong>Constru</strong>Cloud 2.0</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Accede a tu cuenta privada</p>

        <?php echo $htmlAlert; ?>

        <form action="../registro/registrar.php" method="post">
          <div class="input-group mb-3">
            <input type="email" name="email" id="email" class="form-control" required="required" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control" required="required" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6"> 
            </div>
            <!-- /.col -->
            <div class="col-6">
              <input class="d-none" type="hidden" name="Submit" value="Aceptar"/>
              <button type="submit" class="btn  btn-success btn-block">Iniciar sesión</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mb-1">
          <a class="text-muted" href="../registro/olvide_password.php">Olvidé mi password</a>
        </p>
        <hr>
        <p class="mb-0">
          <strong>¿Aún no tienes empresa creada?</strong> 
        </p>
        <br>
        <p class="mb-0 text-center"> 
            <a class="text-muted text-center" href="../registro/empresa_nueva_form.php" >Crea tu perfil de empresa GRATIS. <b>Regístrate</b></a>
            <BR>ó<br><a class="text-muted text-center" href="../registro/registrar.php?login=crypt_4a36334d6a7475686d525279646e4d55796a2f724848422b5a6638566b7a33694d6251554976504f7066615861644f735a75386e37786d55352b515156395954">
                Visita nuestra empresa de ejemplo <b>DEMO, S.L.</b></a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

<?php 
include_once('../templates/_inc_registro3_footer.php');