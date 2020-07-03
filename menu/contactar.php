<?php
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";   // AND $where_c_coste 
?>

<!DOCTYPE html>
<HTML>
    <HEAD>
        <title>Empresas</title>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />

        <link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
        
        <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
    </HEAD>
    <BODY>


        <style>
            body {font-family: Arial, Helvetica, sans-serif;}
            * {box-sizing: border-box;}

            input[type=text], select, textarea {
                width: 100%;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                margin-top: 6px;
                margin-bottom: 16px;
                resize: vertical;
            }

            input[type=submit] {
                background-color: #4CAF50;
                color: white;
                padding: 12px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            input[type=submit]:hover {
                background-color: #45a049;
            }

            .container {
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
            }
        </style>


        <?php
        require_once("../../conexion.php");
        require_once("../include/funciones.php");
        require_once("../include/email_function.php");

        require_once("../menu/topbar.php");
        ?>


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
                      
                <?php require '../include/footer.php'; ?>
                </BODY>
                </HTML>
