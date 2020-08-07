<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Contacto empresa';

//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');

?>

        <!-- Contenido principal -->
        <div class="container-fluid bg-light">
            <div class="row">
                <!--****************** ESPACIO LATERAL  *****************-->
                <div class="col-12 col-md-4 col-lg-3"></div>
                <!--****************** ESPACIO LATERAL  *****************-->

                <!--****************** BUSQUEDA GLOBAL  *****************-->
                <div class="col-12 col-md-4 col-lg-9">


        <div style="overflow:visible">	   

            <!--************ INICIO *************  -->

            <div id="main" class="mainc_100" style="background-color:#fff">



                <div style='align:center;' >
                    <p align=center style='font-size:30px ; text-align:center; color:lightskyblue; font-family:verdana '><br>ConstruCloud.es<br>
                        <img src="../img/construcloud128.jpg">
                    </p>

                </div>

                <?php
                if (!isset($_POST["nombre"]))
                {
                ?>        
                <h1>Contactar</h1>
                <br><br><br>
                <h4>Antes de hacer una consulta considere buscar solución en  <a href=href="https://wiki.construcloud.es"> ConstruWiki</a>
                    o hacer la consulta pública en 
                    <a href="https://wiki.construcloud.es"> Community forum</a>
                </h4>
                <div class="container" style="width:60%;" >
                    <form action="../menu/contactar.php" method="post">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" value='<?php echo $_SESSION["user"]; ?>'>
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" value='<?php echo $_SESSION["email"]; ?>'>

                        <label for="tipo">Motivo</label>
                        <select id="tipo" name="tipo">
                            <option value="Error">Notificar error</option>
                            <option value="Consulta">Consulta</option>
                            <option value="Sugerencia">Sugerencia</option>
                            <option value="Comentario">Comentario, opiniones y/o agradecimientos</option>
                        </select>


                        <label for="asunto">Asunto</label>
                        <input type="text" id="asunto" name="asunto" placeholder="Asunto...">


                        <label for="msg">Mensaje</label>
                        <textarea id="subject" name="msg" placeholder="Mensaje..." style="height:200px"></textarea>

                        <input style=" width: 100%; font-size:30px" type="submit"  value="Enviar">
                    </form>
                </div>

                <?php
                }
                else
                {

                    if (!cc_email('soporte@construcloud.es', $_POST["tipo"].": ".$_POST["asunto"], $_POST["msg"] , $_POST["email"] ))
                    {
                        echo "<br/><br/><br/><br/><h1>ERROR enviando correo electrónico</h1>";
                        echo "<br><br><br><h1><a class='btn btn-warning btn-lg' href='../menu/contactar.php' title=''>Volver a contactar</a></h1>";

//                    echo "<br/>". $mail->Body;	
                        //	echo "<br/>".$mail->ErrorInfo;	
                    } else
                    {
                        echo "<br/><br/><br/><br/><h1>Mensaje enviado correctamente</h1>";
                        echo "<br><br><br><h1><a class='btn btn-success btn-lg' onclick='window.close()' title=''>Cerrar</a></h1>";

//                    echo "<br/>". $mail->Body;	
                    }
                }
                ?>
                      
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
