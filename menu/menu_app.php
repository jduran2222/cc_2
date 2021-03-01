<?php
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

//  $arr=[1,2,['a','b','c2']] ;
//  $arr['c']=[1,2,['a','b','c2']] ;
//  echo  $arr  ;
 //   { c: [{v: 'Frank'}, {v: 25 }, {v: 15 }] },
  
//echo json_encode( (object)$arr , FALSE ) ;
//// {"0":1,"1":2,"2":["a","b","c2"]}
?>



<HTML>
    <HEAD>
        <META NAME="GENERATOR" Content="Microsoft FrontPage 5.0">
        <TITLE>Inicio App</TITLE>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />

        <link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
        
        <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"> </script>-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>-->

    </HEAD>

    <body>
        <style>
            input,button,a { 
                font-size:40px; width:100%; height:150px;
            }
            @media only screen and (max-width:981px) {
                input,button ,a
                {
                    font-size:40px; width:100%; height:150px;
                }
            }


        </style>


        <?php
//        require_once("../../conexion.php");
//        require_once("../include/funciones.php");
        require_once("../include/funciones_js.php");
// require("../menu/general_menutop_r.php"); 
//require_once("../menu/topbar.php");
//require("topbar.php");


//        $dir_raiz = $_SESSION["dir_raiz"];   ANULADO POR DAR PROBLEMAS AL PASAR DE HTTPS A HTTP SIN QUERERLO
        $dir_raiz = "../";  


        if (!$path_logo_empresa = Dfirst("path_archivo", "Documentos", "tipo_entidad='empresa' AND $where_c_coste"))
            $path_logo_empresa = "../img/no_logo.jpg";
        ?>


        <div class="container-fluid">	
            <div class="row">
                <div class="col-sm-6" >

                    <img width="400" src="<?php echo $path_logo_empresa; ?>" >
                </div>

                <div class="col-sm-6" style='float:right ' >

                    <i class="fas fa-building"></i>  <a  target="_blank" href="../configuracion/empresa_ficha.php" ><?php echo $_SESSION["empresa"]; ?>
                    </a>  /  <i class="far fa-user"></i>  <a  target="_blank"  href="../configuracion/usuario_ficha.php" >  <?php echo $_SESSION["user"]; ?></a>
<?php if ($admin) echo " <small>(admin) ".($_SESSION['android'] ? '(android)' : '(pc)' ).'</small>'; ?>
                    <!--<a class="btn btn-link btn-xs" href="../registro/cerrar_sesion.php" >Cerrar sesión</a></h2></p>-->
<button  class='btn btn-warning btn-xs noprint'  onclick='javascript:window.close();'>
            <i class='far fa-window-close'></i>
            
        </button>

<!--<h3 style="background-color: lightgreen"><?php // echo "$msg_licencia" ; ?></h3>    // ANULAMOS PROVISIONALMENTE EL MSG LICENCIA-->
                </div>
            </div>
            <div class="row"> 
                <div class="col-sm-12" style="font-size: 80px; background-color: lightblue">

<?php if (!$_SESSION["invitado"])
{   // MENU SOLO PARA ADMIN    ?>    


                        <form action="../menu/busqueda_global.php" method="post" id="form1" name="form1" target="_blank">
                            <INPUT type="text" id="buscar"  width="20"  name="filtro" placeholder='Busqueda global'>
                            <!--<INPUT type="submit" value="Buscar" id="submit" name="submit">-->
                            <!--<a style="font-size: 80px;" class="btn btn-primary btn-lg" href=# onclick="procesar()"><i class="fas fa-microphone"></i></a>-->
                            <button type="submit"  class="btn btn-info btn-lg border">
                            <i class="fas fa-search"></i> Buscar 
                            </button>
                        </form>                        

                    </div>
                <br><a  target="_blank" class="btn btn-primary border" style="text-align:left;" href="../menu/pagina_inicio.php" ><i class="fas fa-list"></i> MENU COMPLETO</a>
                <br><a target="_blank" class="btn btn-primary border" style="text-align:left;" href="<?php echo $dir_raiz; ?>obras/obras_buscar.php?tipo_subcentro=OE" ><i class="fas fa-hard-hat"></i> OBRAS</a>
                <br><a target="_blank" class="btn btn-primary border" style="text-align:left;" href="<?php echo $dir_raiz; ?>estudios/estudios_calendar.php?fecha=<?php echo date("Y-m-d"); ?>" ><i class="far fa-calendar-alt"></i> CALENDARIO LICITACIONES</a>
                <br><a target="_blank" class="btn btn-primary border" style="text-align:left;" href="<?php echo $dir_raiz; ?>documentos/doc_upload_multiple_form.php"  ><i class="fas fa-cloud-upload-alt"></i> SUBIR DOCUMENTOS</a>
                <br><a target="_blank" class="btn btn-primary border" style="text-align:left;" href="<?php echo $dir_raiz; ?>documentos/doc_upload_multiple_form.php?tipo_entidad=fra_prov"  ><i class="fas fa-cloud-upload-alt"></i> SUBIR FACTURAS PROVEEDOR</a>
        <?php
   }
  ?> 
                <br><a target="_blank" class="btn btn-primary border" style="text-align:left;" href="<?php echo $dir_raiz; ?>personal/partes.php" ><i class="far fa-calendar-alt"></i> CALENDARIO PARTES</a>

                </div>
 

        </div>		

        <div class="row">
            <div id='div_ajax' class="col-sm-12 "> 
             <?php
//                $no_cargado = '<span style=color:red; title=No_Cargado_a_obra> (NC)</span>';
    $fecha = date('Y-m-d');

    $sql = "SELECT ID_PARTE, ID_OBRA,CONCAT(MID(NOMBRE_OBRA,1,20),'...') as NOMBRE_OBRA,Fecha "
            . " FROM Partes_listado WHERE Fecha='$fecha' AND $where_c_coste ORDER BY NOMBRE_OBRA   ";

    $result = $Conn->query($sql);

    $partes_hoy_html = '<p style="font-size: 60px;width:100%; height:150px;">Partes de hoy:</p>';

    if ($result->num_rows > 0)
    {
        while ($rs = $result->fetch_array(MYSQLI_ASSOC))
        {
            $partes_hoy_html .= "<a class='btn btn-default' style='font-size: 60px;width:62%; height:180px;' href='../personal/parte.php?id_parte={$rs["ID_PARTE"]}' "
                    . " target='_blank' >{$rs["NOMBRE_OBRA"]}"
                    . "<br><img src='../img/espere.gif' > </a>  ";

                    //../proveedores/albaran_anadir.php?id_obra='+id_obra+'&id_proveedor='+id_proveedor+'&fecha='+fecha+'&ref='+ref+'&importe='+importe+'&add_foto='+add_foto
            $partes_hoy_html .= "<a class='btn btn-default' style='font-size: 80px;width:12%; height:180px;' "
                    . " href='../proveedores/albaran_anadir.php?id_obra={$rs["ID_OBRA"]}&fecha=$fecha&add_foto=1' "
                    . " target='_blank' ><i class='fas fa-tags'></i></a>";
            $partes_hoy_html .= "<a class='btn btn-default' style='font-size: 80px;width:12%; height:180px;' "
                    . " href='../documentos/doc_upload_multiple_form.php?tipo_entidad=obra_foto&id_entidad={$rs["ID_OBRA"]}&fecha_doc=$fecha' "
                    . " target='_blank' ><i class='fas fa-camera'></i></a>";
            $partes_hoy_html .= "<a class='btn btn-default' style='font-size: 80px;width:12%; height:180px;' "
                    . " href='../obras/obras_ficha.php?id_obra={$rs["ID_OBRA"]}' "
                    . " target='_blank' ><i class='fa fa-hard-hat'></i></a>";
            $partes_hoy_html .= "<br>";
        }
    } else
    {
        $partes_hoy_html .= '<p>no hay Partes</p>';
    }




   $partes_hoy_html .="<br><a target='_blank' class='btn btn-link' style='font-size: 60px;width:100%; height:150px;' "
                   . "  href='../personal/parte_anadir_form_app.php'  ><i class='fas fa-plus-circle'></i> añadir Parte</a>" ;


  echo $partes_hoy_html ;

  
//  echo '----------<br>' ;

  
  
             ?>
                
                
            </div>  

        </div>			

<script>

//console.log("juan duran");

//$("#div_ajax").innerHTML="HOLA SOY JUAN DURAN" ;
//document.getElementById('div_ajax').innerHTML="HOLA SOY JUAN DURAN" ;
cargar_ajax('div_ajax','../menu/menu_app_ajax1.php');

	var recognition;
	var recognizing = false;
	if (!('webkitSpeechRecognition' in window)) {
		alert("¡API no soportada!");
	} else {

		recognition = new webkitSpeechRecognition();
		recognition.lang = "es-VE";
		recognition.continuous = true;
		recognition.interimResults = true;

		recognition.onstart = function() {
			recognizing = true;
			console.log("empezando a escuchar");
		}
		recognition.onresult = function(event) {

		 for (var i = event.resultIndex; i < event.results.length; i++) {
			if(event.results[i].isFinal)
				document.getElementById("texto").value += event.results[i][0].transcript;
		    }
			
			//texto
		}
		recognition.onerror = function(event) {
		}
		recognition.onend = function() {
			recognizing = false;
			document.getElementById("procesar").innerHTML = "Escuchar";
			console.log("terminó de escuchar, llegó a su fin");

		}

	}

	function procesar() {

		if (recognizing == false) {
			recognition.start();
			recognizing = true;
			document.getElementById("procesar").innerHTML = "Detener";
		} else {
			recognition.stop();
			recognizing = false;
			document.getElementById("procesar").innerHTML = "Escuchar";
		}
	}

</script>
        

    </BODY>

</HTML>
