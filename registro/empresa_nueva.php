<?php
ini_set("session.use_trans_sid",true);
session_start();
?>

<HTML>
<HEAD>
     <title>ConstruCloud.es</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>

    
<?php


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 
require_once("../documentos/doc_function.php"); 

require_once("../include/email_function.php");


$email=trim($_POST["email"])  ; 
$password_hash= cc_password_hash ($_POST["password"] )  ;                  //  $new_password_hash= cc_password_hash($new_password) ;
$empresa= isset($_POST["empresa"]) ? ( $_POST["empresa"]<>'' ? $_POST["empresa"] : 'empresa' ) : 'empresa'  ;
$user= isset($_POST["user"]) ? ( $_POST["user"]<>'' ? $_POST["user"] : 'user' ) : 'user'  ;
//$user= isset($_POST["user"]) ? $_POST["user"] : 'user' ;

//$codigo=($_POST["codigo"])  ;
$logo_file=$_FILES["logo_file"]  ;//$_FILES["fileToUpload"]

$_SESSION["email"]=$email ;


// comprobación de datos frente a BOTS 
if(!$email OR empty(trim($_POST["password"]))) { cc_die( "ERROR EN DATOS DE REGISTRO") ;}


//if (($codigo==='CC_33_2019'))   // CONFIMARMOS CODIGO PROMOCIONAL DE ACCESO
if (1)   // CONFIMARMOS CODIGO PROMOCIONAL DE ACCESO
{    
// comprobamos la existenci del EMAIL
if(Dfirst("email","C_COSTES","email='$email'"))
//          $empresa= (trim($empresa)<>'') ? $empresa : 'empresa'.mt_rand (10, 99)   ;  //evitamos el nombre de empresa vacia 
          $user=$user ? $user : 'user'   ;  //evitamos el nore de empresa vacia
          // vemos si está ya registrado el nombre de la EMPRESA, en caso afirmativo añadimos una numeración las veces que haga falta
          while(Dfirst("id_c_coste","C_COSTES","C_Coste_Texto='$empresa'"))  // comprueba si existe previamente empresa
          {
              $empresa=$empresa.mt_rand (10, 99);  // buscamos un nombre de empresa que no exista
          }        

                // GEOLOCALIZACION DE LA IP
                 $ip=$_SERVER['REMOTE_ADDR'] ;
                 $json_geoip=json_geoip($ip) ;
                 $pais= pais($json_geoip);
                  // PROVISIONAL para detectar un error desde Argentina
//                 $json_geoip='json_geoip' ;
//                 $pais= 'pais';




          // creo una empresa nueva 
//            $sql="INSERT INTO `C_COSTES` (`C_Coste_Texto`, `nombre_centro_coste` , `email`, pais,Moneda_simbolo, json_geoip)   "
//                                 . " VALUES ( '$empresa', '$empresa', '$email','$pais','€','$json_geoip' );" ;
            $sql="INSERT INTO `C_COSTES` (`C_Coste_Texto`, `nombre_centro_coste` , `email`, pais,Moneda_simbolo, json_geoip)   "
                                 . " VALUES ( '$empresa', '$empresa', '$email','pais','€','json_geoip' );" ;

            $result=$Conn->query($sql);
             //echo ($sql);

         if ($id_c_coste=Dfirst("max(id_c_coste)","C_COSTES","C_Coste_Texto='$empresa'"))//compruebo si se ha creado emp.nueva
         { 	  // todo OK, empresa nueva creada. Inicializamos la empresa

              //registramos las variables $_SESSION
              $_SESSION["id_c_coste"]=$id_c_coste ; 
              $where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;
              $_SESSION["empresa"]=$empresa ;
              $_SESSION["user"]=$user ;
              $_SESSION["autorizado"]=1 ;
              $_SESSION["admin"]=0 ;
              $_SESSION["admin_chat"]=0 ;
              $_SESSION["email"]=$email ;
              $_SESSION["cif"]='' ;
              $_SESSION["invitado"]=0 ;       
              $_SESSION["Moneda_simbolo"]='€' ;       
              $_SESSION['android']= preg_match('/Android|iPhone|iPad/', $_SERVER['HTTP_USER_AGENT']) ;     // estamos en un movil o tablet

              // damos todos los permisos al usuario nuevo que ha creado la empresa
              $_SESSION["permiso_licitacion"]=1;
              $_SESSION["permiso_obras"]=1;
              $_SESSION["permiso_administracion"]=1;
              $_SESSION["permiso_bancos"]=1;

              // creo el usuario nuevo           
//               $result=$Conn->query("INSERT INTO `Usuarios` (`id_c_coste`,`usuario`,  `password_hash`, `autorizado`, `email`) "
//                       . "                          VALUES ('$id_c_coste', '$user','$password_hash',1, '$email');" );
//               $_SESSION["id_usuario"]= Dfirst('max(id_usuario)', 'Usuarios', " id_c_coste=$id_c_coste ") ;
//               $result=$Conn->query("INSERT INTO `Usuarios` (`id_c_coste`,`usuario`,  `password_hash`, `autorizado`, `email`) "
//                       . "                          VALUES ('$id_c_coste', '$user','$password_hash',1, '$email');" );
               $_SESSION["id_usuario"]= DInsert_into('Usuarios', "(`id_c_coste`,`usuario`,  `password_hash`, `autorizado`, `email`)", "('$id_c_coste', '$user','$password_hash',1, '$email')") ;

               // REGISTRO DE ACCESO


               registrar_acceso($_SESSION["id_c_coste"],$_SESSION["user"],$_SESSION["empresa"],'Acceso creacion Empresa OK',$ip, 0,$_SESSION['android'], $pais, $json_geoip,$_SESSION["id_usuario"]);
         //function registrar_acceso($id_c_coste,            $user,           $empresa,              $resultado, $error, $android ,$pais='', $json_geoip='')

               
//echo '<pre>';
//print_r($_FILES);
//echo '</pre>';
// echo '<pre>';
//print_r($logo_file);
//echo '</pre>';
 
               
                
               
               // SI SE DETECTA FICHERO DE LOGO , registro LOGO
               if ($logo_file['name'])
               {        // REGISTRAMOS EL LOGO       
                  $id_documento_array = doc_upload($id_c_coste,'empresa',0,$id_c_coste,$logo_file,'logo_empresa','','') ;
                  if(sizeof($id_documento_array)>0)
                  {
                    $id_documento=$id_documento_array[0] ;
                    // asignamos el logo como id_logo_empresa  
                    $result=$Conn->query("UPDATE `C_COSTES` SET `doc_logo` = '$id_documento' WHERE id_c_coste= $id_c_coste " );
                     echo 'REGISTRO DE LOGO OK'     ;



                  }else
                  {
                      echo 'ERROR EN REGISTRO DE LOGO'     ;
//                      logs_db_error ('ERROR EN REGISTRO DE LOGO' )    ;
                  }   
               }
               else
               {
                      echo ' LOGO NO INTRODUCIDO'     ;
               }   

        //
        //
        //       // creo licencia FREE por defecto
               $date=date("Y-m-d");
               $date2=date("2030-m-d");
               $sql="INSERT INTO `Licencias` ( `id_c_coste`,licencia, fecha_contrato,fecha_caducidad )    VALUES ( $id_c_coste , 'Licencia FREE' , '$date' , '$date2');" ;
               $result=$Conn->query($sql);

               //añadimos las VARIABLES GENERALES (tabla semilla  `vars`) a la tabla `c_costes_vars` para esta empresa
               $sql="INSERT INTO `c_coste_vars` ( id_c_coste,variable,valor )    SELECT $id_c_coste ,variable, defecto FROM `vars` ;" ;
               $result=$Conn->query($sql);

               //añadimos las CUENTAS CONTABLES (tabla semilla  `cuentas PGC`) a la tabla `CUENTAS` para esta empresa
               $sql="INSERT INTO `CUENTAS` ( id_c_coste,CUENTA,CUENTA_TEXTO,TIPO )    SELECT $id_c_coste ,CUENTA,CUENTA_TEXTO,TIPO FROM `cuentas_PGC` ;" ;
               $result=$Conn->query($sql);

               //buscamos los valores para las variables de entorno. amortizacion 68200 y cargo de MAQUINARIA 9261, 9221 MANO DE OBRA APLICADA
               $id_cuenta_amortizacion= Dfirst("ID_CUENTA", "CUENTAS", "CUENTA='68200' AND $where_c_coste ")   ;
               setVar("id_cuenta_amortizacion", $id_cuenta_amortizacion) ;        
               $id_cuenta_cargo_mq= Dfirst("ID_CUENTA", "CUENTAS", "CUENTA='9261' AND $where_c_coste ")   ;
               setVar("id_cuenta_cargo_mq", $id_cuenta_cargo_mq) ;      
               $id_cuenta_mo= Dfirst("ID_CUENTA", "CUENTAS", "CUENTA='9221' AND $where_c_coste ")   ;
               setVar("id_cuenta_mo", $id_cuenta_mo) ;   
               $id_cuenta_subcontrato= Dfirst("ID_CUENTA", "CUENTAS", "CUENTA='60600' AND $where_c_coste ")   ;
               setVar("id_cuenta_subcontrato", $id_cuenta_subcontrato) ;   
               $id_cuenta_auto= Dfirst("ID_CUENTA", "CUENTAS", "CUENTA='00000' AND $where_c_coste ")   ;
               setVar("id_cuenta_auto", $id_cuenta_auto) ;   
               $id_cuenta_mo= Dfirst("ID_CUENTA", "CUENTAS", "CUENTA='9221' AND $where_c_coste ")   ;  // MANO DE OBRA APLICADA
               setVar("id_cuenta_mo", $id_cuenta_mo) ;   



               //añadimos la empresa como Cliente nuevo ( AUTO CLIENTE )
               if ($id_cliente_auto=DInsert_into( "Clientes", "( id_c_coste,CLIENTE )" , "   ( $id_c_coste , '$empresa' )" , "ID_CLIENTE" , $where_c_coste ) )
               {  // añadido cliente con éxito        
                   setVar("id_cliente_auto", $id_cliente_auto) ;

               }   
        //           echo "id_cliente_auto: $id_cliente_auto" ;
               //añadimos las OBRAS nuevas 001-GASTOS GENERALES y 002-MANO DE OBRA
               if ($id_obra_gg=DInsert_into( "OBRAS", "( id_c_coste,tipo_subcentro,NOMBRE_OBRA ,ID_CLIENTE)" , "   ( $id_c_coste , 'G','001-GG-GASTOS GENERALES',$id_cliente_auto )" , "ID_OBRA" , $where_c_coste ) )
               {  // añadido  con éxito        
                   setVar("id_obra_gg", $id_obra_gg) ;
//                   setVar("id_obra_oficina", $id_obra_gg) ;    // OBSOLETO, juand, ago2020. para ser compatible con versiones anteriores 
//                   setVar("Vale_ID_OBRA", $id_obra_gg) ;       // OBSOLETO, juand, ago2020. ID_OBRA por defecto al crear un Vale-Factura semiautomatico
               }   
               if ($id_obra_mo=DInsert_into( "OBRAS", "( id_c_coste,tipo_subcentro,NOMBRE_OBRA ,ID_CLIENTE)" , "   ( $id_c_coste , 'G','002-MO-MANO DE OBRA',$id_cliente_auto )" , "ID_OBRA" , $where_c_coste ) )
               {  // añadido  con éxito        
                   setVar("id_obra_mo", $id_obra_mo) ;
               } 

               //añadimos la empresa como Proveedor PDTE DE REGISTRAR
               if ($id_proveedor_auto=DInsert_into( "Proveedores", "( id_c_coste,PROVEEDOR )" , "   ( $id_c_coste , '-proveedor pdte. registrar-' )" , "ID_PROVEEDORES" , $where_c_coste ) )
               {  // añadido cliente con éxito        
                   setVar("id_proveedor_auto", $id_proveedor_auto) ;
//                   setVar("id_proveedor_mo", $id_proveedor_auto) ;
               }   
               //añadimos la empresa como Proveedor MANO DE OBRA PROPIA
               if ($id_proveedor_mo=DInsert_into( "Proveedores", "( id_c_coste,PROVEEDOR )" , "   ( $id_c_coste , '-proveedor Mano Obra y Maq. propia-' )" , "ID_PROVEEDORES" , $where_c_coste ) )
               {  // añadido cliente con éxito        
//                   setVar("id_proveedor_auto", $id_proveedor_auto) ;
                   setVar("id_proveedor_mo", $id_proveedor_mo) ;
               }   

               //añadimos la factura de proveedor ficticia FRA_PROV_mo donde auto conciliaremos la Mano de Obra 
               $msgFra_prov_mo='Factura creada automaticamente por el Sistema para conciliar los cargos de mano de obra aplicada a las obras. No modificar.' ;
               if ($id_fra_mo=DInsert_into( "FACTURAS_PROV", "( ID_PROVEEDORES,FECHA,N_FRA,IMPORTE_IVA,Observaciones )" , "  "
                                                  . " ( $id_proveedor_mo ,'2000-01-01' , 'MANO OBRA PROPIA',0,'$msgFra_prov_mo' )" , "ID_FRA_PROV" , "ID_PROVEEDORES=$id_proveedor_mo" ) )
               {  // añadido con éxito        
                   setVar("id_fra_mo", $id_fra_mo) ;
               }   
                //añadimos la factura de proveedor ficticia FRA_PROV_ id_fra_amortizacion donde auto conciliaremos la amortizazion de maquinaria propia
               $msgFra_prov_amort='Factura creada automaticamente por el Sistema para conciliar los cargos de mano de obra aplicada a las obras. No modificar.' ;
               if ($id_fra_amortizacion=DInsert_into( "FACTURAS_PROV", "( ID_PROVEEDORES,FECHA,N_FRA,IMPORTE_IVA,Observaciones )" , "   ( $id_proveedor_mo ,'2000-01-01', 'AMORTIZACION INMOVILIZADO',0 ,'$msgFra_prov_amort' )" , "ID_FRA_PROV" , "ID_PROVEEDORES=$id_proveedor_auto" ) )
               {  // añadido con éxito        
                   setVar("id_fra_amortizacion", $id_fra_amortizacion) ; 
               }

                //añadimos SUBOBRA <sin imputar> para usarla por defecto
               if ($id_subobra_si=DInsert_into( "SubObras", "(ID_OBRA ,SUBOBRA )" , "   ( $id_obra_gg , '<sin imputar>' )" , "ID_SUBOBRA" , "ID_OBRA=$id_obra_gg" ) )
               {  // añadido con éxito        
                   setVar("id_subobra_si", $id_subobra_si) ;
               }

               // añadimos id_concepto_auto para el proveedor_auto
               if ($id_concepto_auto=DInsert_into( "CONCEPTOS", "( ID_OBRA,ID_CUENTA,CONCEPTO, COSTE,ID_PROVEEDOR )" , "   ( $id_obra_mo ,$id_cuenta_mo ,'€ gasto',1,$id_proveedor_auto )" , "ID_CONCEPTO" , "ID_PROVEEDOR=$id_proveedor_auto" ) )
               {  // añadido con éxito   
                   $result_prov=$Conn->query("UPDATE `Proveedores` SET `id_concepto_auto` = $id_concepto_auto  WHERE ID_PROVEEDORES=$id_proveedor_auto ;" );
               }
               
               
               // añadimos CONCEPTOS necesarios DIETA COMPLETA, MEDIA DIETA y NOMINA
               if ($id_concepto_dc=DInsert_into( "CONCEPTOS", "( ID_OBRA,ID_CUENTA,CONCEPTO, COSTE,ID_PROVEEDOR )" , "   ( $id_obra_mo ,$id_cuenta_mo ,'ud Dieta Completa',20,$id_proveedor_auto )" , "ID_CONCEPTO" , "ID_PROVEEDOR=$id_proveedor_auto" ) )
               {  // añadido con éxito        
                   setVar("id_concepto_dc", $id_concepto_dc) ;
               }
               if ($id_concepto_md=DInsert_into( "CONCEPTOS", "( ID_OBRA,ID_CUENTA,CONCEPTO, COSTE,ID_PROVEEDOR )" , "   ( $id_obra_mo ,$id_cuenta_mo ,'ud Media Dieta',10,$id_proveedor_auto )" , "ID_CONCEPTO" , "ID_PROVEEDOR=$id_proveedor_auto" ) )
               {  // añadido con éxito        
                   setVar("id_concepto_md", $id_concepto_md) ;
               }

               if ($id_concepto_nomina=DInsert_into( "CONCEPTOS", "( ID_OBRA,ID_CUENTA,CONCEPTO, COSTE,ID_PROVEEDOR )" , "   ( $id_obra_mo ,$id_cuenta_mo ,'€ nomina',1,$id_proveedor_auto )" , "ID_CONCEPTO" , "ID_PROVEEDOR=$id_proveedor_auto" ) )
               {  // añadido con éxito        
                   setVar("id_concepto_nomina", $id_concepto_nomina) ;
               }
               // creamos un CONCEPTO para coste de hora estándar
               if ($id_concepto_hora_estandar=DInsert_into( "CONCEPTOS", "( ID_OBRA,ID_CUENTA,CONCEPTO, COSTE,ID_PROVEEDOR )" , "   ( $id_obra_mo ,$id_cuenta_mo ,'h empleado estándar',10,$id_proveedor_auto )" , "ID_CONCEPTO" , "ID_PROVEEDOR=$id_proveedor_auto" ) )
              {  // añadido con éxito        
                   setVar("id_concepto_hora_estandar", $id_concepto_hora_estandar) ;
               }
               // añadimos CTA_BANCO por defecto id_cta_banco_auto
               if ($id_cta_banco_auto=DInsert_into( "ctas_bancos", "( id_c_coste,tipo,Banco, N_Cta,Observaciones )" , "   ( $id_c_coste ,'CCC' ,'cuenta banco habitual','pdte rellenar num. cuenta', 'Cuenta de banco por defecto a rellenar con datos reales')" , "id_cta_banco" , $where_c_coste ) )
               {  // añadido con éxito        
                   setVar("id_cta_banco_auto", $id_cta_banco_auto) ;
               }

               // añadimos CTA_BANCO para COMPENSACIÓN DE ABONOS DE FACTURAS
               if ($id_cta_banco_abono_fras=DInsert_into( "ctas_bancos", "( id_c_coste,tipo,Banco, N_Cta,Observaciones )" , "   ( $id_c_coste ,'CCC' ,'COMP. ABONOS FRAS','pdte rellenar num. cuenta', 'Cuenta de banco para compensar los Abonos a facturas de proveedores')" , "id_cta_banco" , $where_c_coste ) )
               {  // añadido con éxito        
                   setVar("id_cta_banco_abono_fras", $id_cta_banco_abono_fras) ;
               }

               // añadimos las CUENTAS ESPECIALES (NG) otros mov. bancarios
                if ($id_NG_traspasos=DInsert_into( "NOTAS_GASTOS", "( id_c_coste,Cuenta_otros_mov_bancos, observaciones)" , "   ( $id_c_coste , 1 , 'CUENTA TRASPASOS INTERNOS')" , "id_nota_gastos" , $where_c_coste ) )
               {  // añadido con éxito        
                   setVar("id_NG_traspasos", $id_NG_traspasos) ;
               }

               // añadimos las PERSONAL AUTO otros mov. bancarios
                if ($id_personal_auto=DInsert_into( "PERSONAL", "( id_c_coste,NOMBRE, Observaciones)" , "   ( $id_c_coste , '.auto.' , 'empleado interno para emisión de doc. automatica')" , "ID_PERSONAL" , $where_c_coste ) )
               {  // añadido con éxito        
                   setVar("id_personal_auto", $id_personal_auto) ;
               }


               // añadimos Chat de Bienvenida   DEBUG
               $chat_bienvenida='Bienvenido a ConstruCloud.es<br/>'
                              . ' <br/>'
                              . 'Esperamos puedas aprovechar el ponential de esta ERP. <br/>'
                              . 'Cualquier consulta sobre su funcionamiento o sugerencia de mejora, '
                              . 'no dudes en transmitírnosla, te lo agradecemos. <br/>'
                              . ' <br/>'
                              . 'Un saludo <br/>'
                              . 'Equipo de Soporte de ConstruCloud.es';
               $id_usuario_admin_chat= 2;
                DInsert_into( "chat", "(reciever_userid, sender_userid, message, status) " , 
                               "   ( '{$_SESSION["id_usuario"]}' , '$id_usuario_admin_chat' , '$chat_bienvenida','1') "  ) ;
              
               // añadimos TAREA de Bienvenida   DEBUG
               $tarea='TAREAS en ConstruCloud.es<br/>' ;
               $texto_tarea=  'Como ves, se pueden crear Tareas que incluyendo a varios usuarios para debatir o resolver asuntos en grupo. <br/>'
                              . 'Una vez concluida se indica como Terminada y ya deja de estar activa. '
                              . ' <br/>'
                              . 'Un saludo <br/>'
                              . 'ConstruCloud.es';
               
                $sql="INSERT INTO `Tareas` ( id_c_coste,tipo_entidad,indice,id_entidad,Tarea,Texto, usuarios , user) "
                        . "   VALUES (  '{$_SESSION['id_c_coste']}','general','' ,'0' , '$tarea', '$texto_tarea','{$_SESSION['user']} , ','{$_SESSION['user']}' );" ;
                  // echo ($sql);
                $result=$Conn->query($sql);

               
               

               // ESPACIO DEDICADO A INCLUIR DATOS DEMO PARA LA EMPRESA NUEVA (Clientes, Proveedores, Obras, ...) a decidir como opción en el FORM de empresa nueva
               // if ($incluir_datos_demo) ...PARA ESO EST´ALA OBRA DEMO, S.L.

                  //debug
               
               // aviso por email de nueva empresa
               cc_email('juanduran@ingenop.com', "Construclud.es: Nueva empresa $empresa  Pais: $pais ", "Empresa: $empresa <br> Pais: $pais <br> Usuario: $user <br> Email: $email  " , '' ) ;
               
               header('Location: ../menu/pagina_inicio.php');         // TODO OK-> Entramos a pagina_inicio.php
        }
        else
        {
            echo "<br><br><br><br><br><br>";
            echo  "<h1>Error desconocido al crear empresa, inténtelo de nuevo </h1>" ;
//            logs_db_error( "Error desconocido al crear empresa, inténtelo de nuevo") ;
            echo  "<h1><a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a></h1>" ;
        }

echo  "<h1>HEMOS TERMINADO</h1>" ;

}
else
{

    echo  "<h1>CODIGO ERRÓNEO</h1>" ;

    
}    


?>

<?php require '../include/footer.php'; ?>
</BODY>