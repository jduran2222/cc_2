<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Tabla Debug';

//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');

?>

        <!-- Contenido principal 
        <div class="container-fluid bg-light">
            <div class="row">
                <!--****************** ESPACIO LATERAL  *****************
                <div class="col-12 col-md-4 col-lg-3"></div>
                <!--****************** ESPACIO LATERAL  *****************

                <!--****************** BUSQUEDA GLOBAL  *****************
                <!--<div class="col-12 col-md-4 col-lg-9">-->



<?php 
// $id_cta_banco=$_GET["id_cta_banco"];
?>

<!-- CONEXION CON LA BBDD Y MENUS -->


<div style="overflow:visible">	   
   
	<!--************ INICIO *************  -->

<div id="main" class="mainc_100" style="background-color:#fff">
	
<?php 

if (!$admin){ cc_die("ERROR USUARIO NO AUTORIZADO");}   // medida de seguridad para evitar HACKEOS

if (isset($_GET['url_enc']))         // venimos ENCRYPTADOS, desencriptamos, juntamos las dos url y metemos en GET las variables
{    
    $url_dec=decrypt2($_GET['url_enc']) ;
    $url_raw= isset($_GET['url_raw']) ? rawurldecode(($_GET['url_raw'])) : ""  ;

    parse_str( $url_dec.$url_raw , $_GET ) ;
}

echo '<br><br><br>' ;

//$tabla=$_GET["tabla"]  ;
//$where=$_GET["where"]  ;
//
//$select= isset($_GET["select"])? $_GET["select"] : "*" ;
//$order_by= isset($_GET["order_by"])? " ORDER BY ".$_GET["order_by"] : "" ;
//$limit= isset($_GET["limit"])? " LIMIT ".$_GET["limit"] : "" ;

if($_SESSION['admin'])
{    

        if (isset($_GET["sql"]))
        {    

        //    $code=isset($_GET["


            $filtro= ( $_GET["sql"] ) ;

            $tabla_update=isset($_GET["tabla_update"])? ($_GET["tabla_update"]) : '' ;
            $id_update=isset($_GET["id_update"])? ( $_GET["id_update"] ) : '' ;
            $link=isset($_GET["link"])? ( $_GET["link"] ) : '' ;
            $link_campo=isset($_GET["link_campo"])? ( $_GET["link_campo"] ) : '' ;
            $link_campo_id=isset($_GET["link_campo_id"])? ( $_GET["link_campo_id"] ) : '' ;

        }
        else
        {  

        $filtro=isset($_POST["filtro"])?$_POST["filtro"] : '' ;
        $tabla_update=isset($_POST["tabla_update"])?$_POST["tabla_update"] : '' ;
        $id_update=isset($_POST["id_update"])?$_POST["id_update"] : '' ;
        $link=isset($_POST["link"])?$_POST["link"] : '' ;
        $link_campo=isset($_POST["link_campo"])?$_POST["link_campo"] : '' ;
        $link_campo_id=isset($_POST["link_campo_id"])?$_POST["link_campo_id"] : '' ;

        }

         ?>  

         <FORM action="../include/tabla_debug.php" method="post" id="form1" name="form1">
                 SQL:  <INPUT id="filtro" type="text" name="filtro" value="<?php echo $filtro;?>" size="200"    ><br>
                        <br><B>--- UPDATE ---</B><br>
                        tabla_update: <INPUT id="tabla_update" type="text" name="tabla_update" value="<?php echo $tabla_update;?>" size="30"    ><br>
                        id_update:  <INPUT id="id_update" type="text" name="id_update" value="<?php echo $id_update;?>" size="30"    ><br>
                        <br><B>--- LINK ---</B><br>
                        link:<INPUT id="link" type="text" name="link" value="<?php echo $link;?>" size="60"    ><br>
                        link_campo:  <INPUT id="link_campo" type="text" name="link_campo" value="<?php echo $link_campo;?>" size="30"    ><br>
                        link_campo_id:  <INPUT id="link_campo_id" type="text" name="link_campo_id" value="<?php echo $link_campo_id;?>" size="30"    ><br>
                        <br>
                        <INPUT type="submit" class='btn btn-success btn-xl' value="Actualizar" id="submit1" name="submit1">

                        <br><br><p>SELECT * FROM Avales WHERE id_aval=$id_aval AND $where_c_coste</p>
                        <p>INSERT INTO FRAS_PROV_PAGOS ( id_fra_prov,id_pago ) VALUES ( '$id_fra_prov'  ,'$id_pago'  );</p>
                        <p>UPDATE `Documentos` SET `tipo_entidad` = 'obra_foto',  `id_entidad` = '$id_obra' WHERE $where_c_coste AND  id_documento=$id_documento;</p>
                        <p>DELETE FROM `Documentos`  WHERE id_documento=$id_documento AND $where_c_coste ;</p>



        </FORM>	


        <?php   // Iniciamos variables para tabla.php  background-color:#B4045

        if ($tabla_update) $updates=['*'] ;

        if ($link) $links[$link_campo] = [ $link , $link_campo_id,'', 'formato_sub'] ;  // cambiamos __AND__ por su simbolo & para compatibilizar con ficha_general


        //$sql="SELECT $select FROM $tabla WHERE  $where  $order_by $limit  " ;

        $sql= $filtro ;

        echo $sql ;

        $print_id=1 ;

        //if ((strtoupper(substr($sql,0,6))=='SELECT') )
        if($sql)
        {    
        $time0=microtime(true);

        if ($result=$Conn->query($sql) )
        {        


            echo "<BR>RESULTADO: <big><b> {$result->num_rows} filas </b></big>" ;
            echo "<BR>Tiempo: ".number_format(microtime(true)-$time0,3)." segundos " ;
            if(isset($_SESSION['tabla_debug']))
            {
                $_SESSION['tabla_debug']= $sql ."<br>". $_SESSION['tabla_debug'] ;
            }  else {
                $_SESSION['tabla_debug']= $sql ;
            }
            echo  "<br>". $_SESSION['tabla_debug'] ;
            $titulo="";
            $msg_tabla_vacia="No hay.";
            require("../include/tabla.php"); echo $TABLE ;    

        }
        else
        {
            echo "<BR>sentencia sql errónea:" .$Conn->error;
        }
        }


//        echo "<br><br><br><br><br><br>INICIO \$_SERVER[]";
//
//        echo "<pre>";
//        //$a = array ('a' => 'manzana', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
//        print_r ($_SERVER);
//        echo "</pre>";
//        echo "<br><br><br><br><br><br>INICIO \$_SESSION[]";
//
//        echo "<pre>";
//        //$a = array ('a' => 'manzana', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
//        print_r ($_SESSION);
//        echo "</pre>";
//
//        echo "<br><br><br><br><br><br>";


        ?>

        </div>


<?php  

}
$Conn->close();

?>
	 

</div>

	
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');