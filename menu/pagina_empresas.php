<?php

$titulo = 'Acceso como empresa';

include_once('../templates/_inc_registro1_header.php');
include_once('../../conexion.php');

$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} ";

if ($_SESSION["email"]) {

    // triquiñuela para si hay parámetro GET admin, ver todas los logos y empresas    
    $sql =  isset($_GET["admin"])?  
            "SELECT path_logo,id_usuario,C_Coste_Texto,usuario,IF(admin,'(admin)','') AS admin,IF(autorizado,'(autorizado)','') AS autorizado FROM Usuarios_View "
            . " WHERE activo=1 ORDER BY fecha_creacion DESC  " 
            : "SELECT path_logo,id_usuario,C_Coste_Texto,usuario,IF(admin,'(admin)','') AS admin,IF(autorizado,'(autorizado)','') AS autorizado FROM Usuarios_View "
                . " WHERE email='{$_SESSION["email"]}' AND activo=1   " ;        

    $result=$Conn->query($sql);

    $templateItemList = '
          <a href="{{url}}" class="row mb-3">
            <div class="col-12 col-sm-2">
                <img src="{{imagen}}">
            </div>
            <div class="col-12 col-sm-3">
                {{empresa}}
            </div>
            <div class="col-12 col-sm-4">
                {{usuario}}
            </div>
            <div class="col-12 col-sm-3 small">
                {{autorizado}}
            </div>
          </a>';
    $url = '../registro/login_as.php?id_usuario=';
    $htmlSelectList = '';
    while ( $rs = $result->fetch_array(MYSQLI_ASSOC) ) {
        $tmpHtml = $templateItemList;
        $tmpHtml = str_replace('{{url}}', $url.$rs['id_usuario'], $tmpHtml);
        $tmpHtml = str_replace('{{imagen}}', $rs['path_logo'], $tmpHtml);
        $tmpHtml = str_replace('{{empresa}}', $rs['C_Coste_Texto'], $tmpHtml);
        $tmpHtml = str_replace('{{usuario}}', $rs['usuario'], $tmpHtml);
        $tmpHtml = str_replace('{{autorizado}}', $rs['autorizado'], $tmpHtml);
        $htmlSelectList .= $tmpHtml;
    } 

    $links["C_Coste_Texto"]=["../registro/login_as.php?id_usuario=","id_usuario", '','formato_sub'] ;
    $formats["C_Coste_Texto"]='h3' ;
    $links["usuario"]=["../registro/login_as.php?id_usuario=","id_usuario", '','formato_sub'] ;

    $links["path_logo"]=["../registro/login_as.php?id_usuario=","id_usuario", '','formato_sub'] ;
    $formats["path_logo"]='pdflink_300_305' ;

    $div_size_width=320 ;
    $div_size_height=$div_size_width*0.7 ;
    $etiquetas_show= 1 ;

    $titulo="Empresas disponibles";
    $msg_tabla_vacia="<strong>No hay empresas disponibles.</strong>";

    echo "</div>";
}
$Conn->close();


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
        <p class="login-box-msg">Accede como una de las siguientes empresas</p>

        <div class="select">
            <?php echo (isset($htmlSelectList) ? (!empty($htmlSelectList) ? $htmlSelectList : $msg_tabla_vacia) : $msg_tabla_vacia); ?>
        </div>

        <hr>
        <p class="mb-0 text-center">
          <a class="btn btn-danger btn-xs" href="../registro/cerrar_sesion.php">
            <i class="fas fa-power-off"></i>
            Cerrar sesión
          </a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

<?php 
include_once('../templates/_inc_registro3_footer.php');