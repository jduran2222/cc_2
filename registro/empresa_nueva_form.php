<?php

$titulo = 'Crear nueva empresa';

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
        <p class="login-box-msg">Nueva empresa en <strong>Constru</strong>Cloud</p>

        <?php echo $htmlAlert; ?>

        <form action="../registro/empresa_nueva.php" method="post" enctype="multipart/form-data">
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
          <div class="input-group mb-3">
            <input type="text" name="empresa" id="empresa" class="form-control" placeholder="Empresa (opcional)">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-home"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" name="user" id="user" class="form-control" placeholder="Usuario (opcional)">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="far fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <div class="custom-file">
              <input type="file" name="logo_file" id="logo_file" class="custom-file-input" placeholder="Logo empresa (opcional)">
              <label class="custom-file-label text-muted" for="logo_file">Logo empresa (opcional)</label>
            </div>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-camera"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" name="acepto" id="acepto" required="required">
              <label class="custom-control-label" for="acepto">
                  He leído y acepto la <a href="#">Condiciones de uso</a>, <a href="#">Política de privacidad</a> y <a href="#">Aviso legal</a> 
              </label>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <a class="btn btn-secondary small text-white" href="../">Volver</a>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <input class="d-none" type="hidden" name="Submit" value="Aceptar"/>
              <button type="submit" class="btn btn-success btn-block">Crear</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

<?php 
include_once('../templates/_inc_registro3_footer.php');