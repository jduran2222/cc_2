<?php



define ("ICON_NUEVO", "<i class='fas fa-plus-circle'></i>");

$ICON = "<span class='glyphicon glyphicon" ;
$SPAN = "'></span>"; 


function pre($array)
{
     return "<pre>".print_r($array,TRUE)."</pre>"  ;
}


// coste de la hora de empleado pordefecto, podemos configurarla para según el pais poner un coste u otro
function cc_coste_hora() 
{
return 15;  //15 coste estandar en España en 2021
} 
function cc_actualiza_ESTUDIO_COSTE( $id_obra )
{
  //extract($GLOBALS);
      if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }
    
  $fecha=date('Y-m-d');

 // calculamos nosotros el ID_PRODUCCION y confirmamos que la $id_obra es del id_c_coste actual
$id_produccion=Dfirst("id_prod_estudio_costes", "OBRAS", "ID_OBRA=$id_obra AND id_c_coste={$_SESSION["id_c_coste"]}  ")  ;

$sql2 = "DELETE FROM PRODUCCIONES_DETALLE WHERE ID_PRODUCCION=$id_produccion ; " ;

$Conn->query($sql2);

$sql2 = "INSERT INTO PRODUCCIONES_DETALLE ( ID_PRODUCCION, Fecha, ID_UDO, MEDICION ) "
        . "SELECT $id_produccion as ID_PRODUCCION, '$fecha' AS Fecha, ID_UDO, MED_PROYECTO AS MEDICION "
           . " FROM Udos WHERE ID_OBRA=$id_obra "  ;

$result = $Conn->query($sql2);
  
return $result;
} 


// consulta si ESTUDIO COSTE es una Relación Valorada IDENTICA al PROYECTO (mismas udos y mismas mediciones)
function cc_is_ESTUDIO_COSTE_actualizado( $id_obra, $id_prod_estudio_costes=0 )
{ 

$desfase=1.234   ; // usamos el desfse para evitar que nuevas UDOs son MED_PROYECTO igual a cero no varíen el $hash_proyecto

$id_prod_estudio_costes=$id_prod_estudio_costes? $id_prod_estudio_costes : Dfirst("id_prod_estudio_costes", "OBRAS", "ID_OBRA=$id_obra AND id_c_coste={$_SESSION["id_c_coste"]} ")  ;

$hash_proyecto=Dfirst("SUM(ID_UDO*(MED_PROYECTO+$desfase))", "Udos", "ID_OBRA=$id_obra")  ;
$hash_estudio_costes=Dfirst("SUM(ID_UDO*(MEDICION+$desfase))", "PRODUCCIONES_DETALLE", "ID_PRODUCCION='$id_prod_estudio_costes'")  ;

  
return ($hash_proyecto==$hash_estudio_costes);
} 







// funcion devuelve el HTML de una pagina de error
function cc_page_error($msg)
{
  $html= "<center><br><br><br><br><br><img width='256px' src='../img/logo_cc.svg' alt='Logo ConstruCloud 2.0'/>"
          .  " <h2 style='text-align:center;'><br><br><br><br>$msg</h2>"
          . "<BR><BR><BR><BR><button style='font-size:200%;background-color:orange;' onclick='javascript:window.close();' title='cerrar'>CERRAR</button></center>" ;
  
  return  $html ;
}

// funcion devuelve el HTML de una pagina de error
function cc_die($msg)
{
    
  die(cc_page_error($msg));
    
  return  ;
}

// funcion que nos permitirá convertir una fila (p. ej. de una tabla) a un content con un formato de HTML. sustituimos las cadenas @@CAMPO1@@ del $HTML por el valor de $rs["CAMPO1"]
function cc_row_html($rs,$html)
{
  foreach ($rs as $clave => $valor)
    {

     if (substr($clave,0,4)=="HTML")    { $valor= urldecode($valor)  ; }  //los HTML vienen en formato urlencode
//     if ($ext==".doc" OR $ext==".xls" ) { $valor=utf8_decode($valor);  }      // adecuamos los caracteres tilde y demás signos puntuación

    $localizador='/@@'.$clave.'@@/i'  ;
    //$html = str_replace($localizador, $valor, $html)  ;          // sustituyo cada posible localizador del HTML por su valor en la base de datos
    $html = preg_replace($localizador, $valor, $html)  ;          // sustituyo cada posible localizador del HTML por su valor en la base de datos

    //$html= str_replace('@@CIUDAD@@', 'Málaga', $html)  ;
    //$html= str_replace('@@FECHA_LARGA@@', '26 de Febrero de 2.019', $html)  ;
    } 
  
  return  $html ;
}

function registra_session($rs)
{
   $_SESSION["email"]=$rs["email"] ;
   $_SESSION["id_c_coste"]=$rs["id_c_coste"] ;
   $_SESSION["empresa"]=$rs["C_Coste_Texto"] ;
   $_SESSION["user"]=$rs["usuario"] ;
   $_SESSION["id_usuario"]=$rs["id_usuario"] ;
   $_SESSION["admin"]=$rs["admin"] ;
   $_SESSION["admin_chat"]=$rs["admin_chat"] ;
   $_SESSION["autorizado"]=$rs["autorizado"] ;
   $_SESSION["Moneda_simbolo"]=trim($rs["Moneda_simbolo"]) ;
   $_SESSION["permiso_licitacion"]=$rs["permiso_licitacion"] ;
   $_SESSION["permiso_obras"]=$rs["permiso_obras"] ;
   $_SESSION["permiso_administracion"]=$rs["permiso_administracion"] ;
   $_SESSION["permiso_bancos"]=$rs["permiso_bancos"] ;

   $_SESSION["cif"]=$rs["cif"] ;
   $_SESSION["invitado"]=0 ;       
   
   
  return  1 ;
}


function str2color($str)
{
   $dec=hexdec(bin2hex(substr($str,-4))) ;
   $mod3 = $dec % 4 ; 
   $mod150 = ( $dec % 50) +150 ; 
   $mod80 = $dec % 180 ; 
   $mod20 = $dec % 20 ; 
//   $mod20 = 0 ; 
   
   return  $mod3==0 ? "rgb($mod150, $mod20, $mod20)" : ($mod3==1 ? "rgb($mod80, $mod150, $mod20)" : ($mod3==2 ? "rgb($mod20, $mod80, $mod150)" : "rgb(0, $mod20, $mod150)" ) )  ; 
//   return  $dec ;
}

function span_wiki($entrada_wiki)
{
//    onmouseover="var myTimer=setTimeout('myFunct()', 1000);"
//onmouseout="clearTimeout(myTimer);"
    
   return     "<a style='opacity : .3;font-size:small;'  href='https://wiki.construcloud.es/index.php?title=$entrada_wiki' title='ver ConstruWIKI' target='_blank'>"
               . "<i class='fab fa-wikipedia-w'></i><i class='fas fa-question-circle'></i></a>"
               . "<div class='box_wiki'>"
           . "<iframe src='https://wiki.construcloud.es/index.php?title=$entrada_wiki' class='col-12' style='min-height:240px'></iframe>"
           . "</div>"   ; 

}




function texto_a_html_hex($chat_message)
{
            // manipulamos el message

//                $chat_message = preg_replace( '/\\n/' , '<br>'  , $chat_message );
     //sustitución nuevas líneas
     $chat_message =preg_replace("/\n|\r\n/", " <br/>", $chat_message);

        // sustitucion http 
//     $pattern = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
//     $pattern = "/(?i)\b(((?<!\")https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
//     $pattern = "/(?i)\b(((?<!\")https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
//     $pattern = "/((?<!=\")https?:\/\/)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/";
//     $pattern = "/((?<!\")https?):\/\/([\w_-]+(?:(?:\.[\w_-]+)+))([\w.,@?^=%&:/~+#-]*[\w@?^=%&/~+#-])?/";
     $pattern = "/((?<![\"\'])https?:\/\/)(\S)+/";
//     $pattern = "/(?<!\")https/";
     $chat_message = preg_replace_callback($pattern, function ($S) {
//     return "<a href='$S[0]' target='_blank' title='$S[0]'>".substr($S[0],0,20)."...</a>";
//     return "<a href=\'$S[0]\' target=\'_blank\' title=\'$S[0]\'>link</a>";
//     return "<a href=\'#\' style=\'cursor:pointer;\'  onclick=\"window.open(\'$S[0]\');\" target=\'_blank\' title=\'$S[0]\'>link</a>";
       $link=  strip_tags($S[0]) ;
       $etiqueta_txt=  str_replace("https://", "", $link);
       $etiqueta_txt=  str_replace("http://", "", $etiqueta_txt);
       $etiqueta_txt= substr( $etiqueta_txt,0,25);
     return "<a href='#' style='cursor:pointer;'  onclick=\"window.open('$link');\"  title='$link'>$etiqueta_txt...</a>";
      }, $chat_message); 

      // # HASHTAGS
     $pattern = "/\B((?<![\"\'=>])#)(\S)+/";
//     $pattern = "/(?<!\")https/";
     $chat_message = preg_replace_callback($pattern, function ($S) {
//     return "<a href='$S[0]' target='_blank' title='$S[0]'>".substr($S[0],0,20)."...</a>";
//     return "<a href=\'$S[0]\' target=\'_blank\' title=\'$S[0]\'>link</a>";
//     return "<a href=\'#\' style=\'cursor:pointer;\'  onclick=\"window.open(\'$S[0]\');\" target=\'_blank\' title=\'$S[0]\'>link</a>";
     // quitamos TAGS, commas y puntos, y quitamos la # y codificamos a URL    
     $filtro= urlencode( str_replace([chr(194),chr(160)," ",",",".","#"],"", trim(strip_tags( $S[0] )) ) )  ; 
     return "<a href='#' style='cursor:pointer;'  onclick=\"window.open('../menu/busqueda_texto.php?ht=1&filtro=$filtro');\"  title='Buscar hashtag'>$S[0]</a>";
      }, $chat_message); 

      // buscar ENTIDADES @
     $pattern = "/\B((?<![\"\'=>])@)(\S)+/";
//     $pattern = "/(?<!\")https/";
     $chat_message = preg_replace_callback($pattern, function ($S) {
//     return "<a href='$S[0]' target='_blank' title='$S[0]'>".substr($S[0],0,20)."...</a>";
//     return "<a href=\'$S[0]\' target=\'_blank\' title=\'$S[0]\'>link</a>";
//     return "<a href=\'#\' style=\'cursor:pointer;\'  onclick=\"window.open(\'$S[0]\');\" target=\'_blank\' title=\'$S[0]\'>link</a>";
     // quitamos TAGS, quitamos la # y codificamos a URL    
//     $filtro= urlencode( str_replace([" ",",",".","@"],"", trim( strip_tags( $S[0] ) )) )  ; 
     $filtro = substr(trim( strip_tags( $S[0] ) ), 1);          // quitamos el primer @        
     $filtro= urlencode( str_replace([",",".","-","_"]," ", $filtro) )  ;  
//     $filtro=preg_replace('/^@/', '', $filtro);
//     $filtro= str_replace("_"," ", $filtro)   ; // cambiamos barra baja por espacio para la búsqueda
     return "<a href='#' style='cursor:pointer;'  onclick=\"window.open('../menu/busqueda_global.php?filtro=$filtro');\"  title='Busca en Búsqueda Global'>$S[0]</a>";
      }, $chat_message); 

      
      
//             $chat_message = preg_replace($pattern, "$1", $chat_message); 

     $chat_message =preg_replace("/\'/", "\'", $chat_message); //corregimos las comillas  lo quitamos PROVISIONALMENTE, abril 20


//    return  "__HEX__".bin2hex($chat_message);
    return  $chat_message ;
}
            


function entidad_link($tipo_entidad)
{
    $array_links["aval"]="../bancos/aval_ficha.php?id_aval=";
    $array_links["obra_doc"]="../obras/obras_ficha.php?id_obra=";
    $array_links["obra_foto"]="../obras/obras_ficha.php?id_obra=";
    $array_links["obra_nueva"]="../obras/obras_ficha.php?id_obra=";
    $array_links["fra_prov"]="../proveedores/factura_proveedor.php?id_fra_prov=";
    $array_links["fra_cli"]="../clientes/factura_cliente.php?id_fra=";
    $array_links["albaran"]="../proveedores/albaran_proveedor.php?id_vale=";
    $array_links["empresa"]="../configuracion/empresa_ficha.php";
    $array_links["estudios"]="../estudios/estudios_ficha.php?id_estudio=";
    $array_links["estud_obra"]="../estudios/estudios_ficha.php?id_estudio=";
    $array_links["l_avales"]="";
    $array_links["oferta_cli"]="../estudios/oferta_cliente.php?id_oferta=";
    $array_links["presup_cli"]="../estudios/oferta_cliente.php?id_oferta=";
    $array_links["parte"]="../personal/parte.php?id_parte=";
    $array_links["personal"]="../personal/personal_ficha.php?id_personal=";
    $array_links["pof"]="../pof/pof.php?id_pof=";
    $array_links["pof_nueva"]="../pof/pof.php?id_pof=";
    $array_links["pof_doc"]="../pof/pof.php?id_pof=";
    $array_links["pof_concepto"]="../pof/pof_concepto_ficha.php?id=";
    $array_links["pof_prov"]="../pof/pof_proveedor_ficha.php?id=";
    $array_links["proveedores"]="../proveedores/proveedores_ficha.php?id_proveedor=";
    $array_links["subcontrato"]="../obras/subcontrato.php?id_subcontrato=";
    $array_links["SUBC_nuevo"]="../obras/subcontrato.php?id_subcontrato=";
    $array_links["tarea"]="../agenda/tarea_ficha.php?id=";
    $array_links["udo"]="../obras/udo_prod.php?id_udo=";
    $array_links["remesa"]="../bancos/remesa_ficha.php?id_remesa=";
    $array_links["cliente"]="../clientes/factura_cliente.php?id_fra=";
    $array_links["cuenta"]="../bancos/pagos_y_cobros.php?cuenta=";
    $array_links["pago"]="../bancos/pago_ficha.php?id_pago=";
    $array_links["pago_nuevo"]="../bancos/pago_ficha.php?id_pago=";
    $array_links["mov_banco"]="../bancos/pago_ficha.php?id_mov_banco=";
    $array_links["banco"]="../bancos/bancos_mov_bancarios.php?id_cta_banco=";
    $array_links["cta_banco"]="../bancos/bancos_mov_bancarios.php?id_cta_banco=";
    $array_links["procedimiento"]="../agenda/procedimiento_ficha.php?id_procedimiento=";
    $array_links["doc_nuevo"]="../documentos/documento_ficha.php?id_documento=";
//    $array_links["pdte_clasif"]="../documentos/documento_ficha.php?id_documento=";
    $array_links["rel_valorada"]="../obras/obras_prod_detalle.php?id_produccion=";
    $array_links["rel_valorada_nueva"]="../obras/obras_prod_detalle.php?id_produccion=";
    $array_links["prod_det"]="../obras/obras_prod_detalle.php?id_produccion=";
    $array_links["usub"]="../proveedores/usub_ficha.php?id=";
    $array_links["subcontrato"]="";
    $array_links["subcontrato"]="";
    $array_links["subcontrato"]=""; 
    
    
    
    return  isset( $array_links[$tipo_entidad]) ? $array_links[$tipo_entidad] :  "#"  ; // el # es para incluirlo directamente al href
}

function entidad_descripcion($tipo_entidad, $id_entidad, $rs=null)
{
  switch ($tipo_entidad) { 
      
    case "fra_prov":    
          // si no enviamos el $row lo calculamos  
         if (!isset($rs))  {  $rs=Drow("Fras_Prov_View", "id_fra_prov=$id_entidad AND id_c_coste={$_SESSION['id_c_coste']} ") ;  }
         $descripcion="Factura {$rs["N_FRA"]} de {$rs["PROVEEDOR"]} (".cc_format($rs["IMPORTE_IVA"], 'moneda').") "  
                       .($rs["conc"] ? "Cargada " : "" ) . ($rs["pagada"] ? "Pagada " : " " ) . ($rs["cobrada"] ? "Cobrada" : "" ) ; ;
    break;
    
    default:
       $descripcion= $tipo_entidad . " con id " . $id_entidad  ;  // nombre de firma general
  }
    
 return  $descripcion ; 
}



// calculamos el siguiente numero de FACTURA CLIENTE
function siguiente_n_fra($id_fra='', $num_fra_ultima='',$serie_fra='')  
{

$where_exclusion_id_fra=   $id_fra? "ID_FRA<>$id_fra"  : "1=1" ;
// valores por defecto
$serie_fra = $serie_fra? $serie_fra : date('Y')."-" ;
$num_fra_ultima = $num_fra_ultima ? $num_fra_ultima : Dfirst("MAX(N_FRA)", "Fras_Cli_Listado", "N_FRA LIKE '$serie_fra%' AND  $where_exclusion_id_fra  AND    id_c_coste={$_SESSION['id_c_coste']}  ");
    
if ($num_fra_ultima)
{  //siguiente del año en curso
      $n_fra_contador_txt = str_replace($serie_fra, "", $num_fra_ultima)  ;
      $n_fra_contador = $n_fra_contador_txt + 1  ;
      $n_fra_nuevo = $serie_fra . sprintf("%03d", $n_fra_contador) ; 
//      echo $num_fra_ultima;
//      echo "<br>";
//      echo $n_fra_contador_txt;
//      echo "<br>";
//      echo $n_fra_contador;
//            echo "<br>";
//
//      echo $n_fra_nuevo; 
      
}else
{  //primera factua cliente del año en curso
      $n_fra_nuevo=  $serie_fra . "001" ; // primera factura del año
}   

return $n_fra_nuevo;
}

function is_picture($path_archivo)
{
    return  in_array( pathinfo($path_archivo,PATHINFO_EXTENSION ) , ['jpg','jpeg','bmp','gif','tif','tiff','png']   );
}
function guid()
{
    return  bin2hex(openssl_random_pseudo_bytes(16));
}


function digito_control($str)
{
    $array = str_split(strtoupper($str));
    $conversion = "";
    foreach ($array as $char)
    {
       $conversion .= preg_match("/[A-Z]{1}/", $char) ?  (ord($char)-55) : $char  ;         // cambiamos los caracteres A-Z por su codigo de 10 a 35
    }
//    $return=(98-(int)$conversion % 97) ;
    
    
    return sprintf("%02d", (98-(int)$conversion % 97) ) ;   // usamos formato 00 para valores meores a 10
}

function like($subject,$pattern)
{
    $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
    return (bool) preg_match("/^{$pattern}$/i", $subject);
}

function dateformat_friendly($datetime1)
{
    setlocale(LC_TIME, "es_ES");

    $fecha1=cc_format($datetime1, "fecha");
    $ts1=strtotime($datetime1) ;
//    date_default_timezone_set("Europe/Madrid");
    $timezone = new DateTimeZone('Europe/Madrid');
//    echo $timezone->getOffset(new DateTime());
    $ts2=time() + $timezone->getOffset(new DateTime());
    
    $diff=$ts2-$ts1 ;
    
    $minutos=floor($diff/60) ;
    $horas=floor($diff/3600 );
    $dias=floor($diff/(3600*24)) ;
    
//    $date_1 = new DateTime($date1);
//    $date_2 = new DateTime();
//    $date_2 = new DateTime("", new DateTimeZone("Europe/Madrid"));  // para el uso en otras franjas horarias habrá que usar getLocate y ver qué hora tiene el servidor Mysql
//    $date_2 = new DateTime();  // para el uso en otras franjas horarias habrá que usar getLocate y ver qué hora tiene el servidor Mysql

//    $diff = $date_1->diff(new DateTime($date_2->format('Y-m-d  H:i:s')));
//    $echo= date('Y-m-d  H:i:s') ;
//    $echo.= "<br>europa:".($hoy_europa=date('Y-m-d  H:i:s')) ;
//  
//    $date_2=new DateTime($hoy_europa);
////    $diff = $date_1->diff(new DateTime(date('Y-m-d  H:i:s')));
//    $diff = $date_2->diff($date_1);

    $dia_demana_hora=ucwords(utf8_encode(strftime( '%A  %H:%I' , $ts1 )));
    if($dias > 365){
      $return = $fecha1;
    }

    elseif($dias < 366 AND $dias > 7){
      $return = $fecha1;
    }

    elseif($dias >= 2 AND $dias < 8){
//      $return = date_format( date_create($datetime1),  'l - H:i');
      $return=$dia_demana_hora ;         //  $fecha->format('F-Y') 

    }

    elseif($dias == 1) $return = " $dia_demana_hora ";

    elseif($horas >= 1) $return = "Hace $horas horas" . (($horas<=2)? " y ". ($minutos-60*$horas) . "minutos" : "");

    elseif($dias == 0 AND $horas <= 1 AND $minutos >= 1) $return = "Hace $minutos minutos ";

    elseif($dias == 0 AND $horas <= 1 AND $minutos < 1) $return = "Ahora";

    else $return =  "Error!";
    
//    return $return . "<br><br>$dias dias =  $horas horas = $minutos minutos  <br>" ;
    return $return  ;

}


            

function badge($number, $tipo='danger')
{  //badge badge-danger navbar-badge
   return (($number) ?  "<span  class='rounded-circle navbar-badge badge badge-$tipo'>$number</span>" : "") ;
//   return (($number) ?  "<span  class='badge badge-$tipo navbar-badge'>$number</span>" : "") ;

}

function badge_sup($number, $tipo='danger')
{  //badge badge-danger navbar-badge
//    <sup class='bg-info small px-0 px-sm-1'>$num_documentos</sup>
   return (($number) ? "<sup class='rounded-circle bg-$tipo small px-0 px-sm-1'>". $number  ."</sup>": "") ;
//   return (($number) ? "<div style='float:right;'><sup class='small px-0 px-sm-1'>". badge($number,$tipo)  ."</sup></div>": "") ;

}

function close_java()
{
   return "<script languaje='javascript' type='text/javascript'>window.close();</script>" ;

}


function logs($msg2='')
{
    $_SESSION['logs'] = isset($_SESSION['logs']) ?  $_SESSION['logs'] : '' ;     // inicializo SESSION LOGS si no existe
        
//    $_SESSION['logs'].=date("Y-m-d H:i:s ")."</small></i>  ".__FILE__ ." ". __LINE__ ."    $msg2<br><small><i>" ;
    $_SESSION['logs'].=date("Y-m-d H:i:s ")."</small></i>  $msg2<br><small><i>" ;   // eliminamos FILE y LINE, siempre son funciones.php y linea 67
    return $_SESSION['logs'];
}

//function logs_db($msg, $tipo='info',$parametros='', $file= __FILE__ ,$line= __LINE__ )
function logs_db($msg, $tipo='info',$parametros='', $file=__FILE__ ,$line=__LINE__ )
{   

$id_c_coste  = isset($_SESSION["id_c_coste"]) ? $_SESSION["id_c_coste"] : 'id_c_coste' ;   
$user  = isset($_SESSION["user"]) ? $_SESSION["user"] : 'user' ;   
$email  = isset($_SESSION["email"]) ? $_SESSION["email"] : 'email' ;   
$empresa  = isset($_SESSION["empresa"]) ? $_SESSION["empresa"] : 'empresa' ;   
    
$id_log_db= DInsert_into('logs_db', "(id_c_coste,user,email,file_php,msg, tipo, empresa, parametros)"
     . " ", "( '$id_c_coste', '$user','$email','$file  $line','$msg' ,'$tipo' ,'$empresa'  ,'$parametros' )" ,'' , '', '', 0  ) ; 
     
// if($id_log_db)
//  { return $id_log_db ;}                  // devuelvo el $id_log_db de la tabla logs_db para localizar el ERROR
// else
//  { return "ERROR:". $msg ;}  

 return $id_log_db ;   
}

//function logs_db_error($msg,$parametros='')
//{   
//return logs_db($msg, 'error',$parametros) ;        
//}

//function logs_db_info($msg, $parametros='')
//{   
//    return logs_db($msg, 'info',$parametros) ;
//        
//}

function is_multiempresa()
{
            
 if ($_SESSION["email"])
     {    // comprobamos si hay más de un usuario con nuestro email
        return ( 1< Dfirst("id_usuario","Usuarios","email='{$_SESSION["email"]}'" )) ;
     }
 else
     {
        return 0 ;    
     }
}    
            
//logs_system_error
//  ANULADO PROVISIONALMENTE PARA PODER VER ERRORES EN CW_PROD   (juand, marzo, 2020)
//function logs_system_error($errno, $errstr, $errfile, $errline)                  // funcion que se usa cuando hay un ERROR en ejecución y no somos ADMIN
//{   
////    if($_SESSION["admin"]){echo "$errno  $errstr $errfile $errline" ; }
//    return logs_db( $errstr , 'system_error',$errno,$errfile,$errline ) ;        
//}

function logs_reset($msg='')
{
    $_SESSION['logs']='' ;
}

//function evalua_expresion_OBSOLETA($exp)
//{
//    require_once("../include/expresiones/Evaluar.php");
//    
//    $error_level=error_reporting();    // quitamos la emisión de mensajes de error para evitar conflictos 
//
//    $evaluadorExpresiones2 = new Evaluar();
//            
////     $exp=dbNumero($exp) ;
//     $Transformado = $evaluadorExpresiones2->TransformaExpresion($exp);
//     $ExprNegativos = $evaluadorExpresiones2->ArreglaNegativos($Transformado);
//
//     
//    $evaluadorExpresiones2->Analizar($ExprNegativos);
//
//    error_reporting($error_level);   // restauramos el nivel de alertas de error
//
//     return round($evaluadorExpresiones2->Calcular(), 14);
//}

function evalua_expresion_mysql($expresion)
{
    if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }

    // quitamos los TAGS
    logs( "Exp previo TAGs: $expresion" );
    
    $expresion = strip_tags( $expresion);    
//    $expresion =  preg_replace('/<(.|\n)*?/', '', $expresion);

//    echo "<script>console.log('Exp tras TAGs: $expresion')</script>";
    logs( "Exp tras TAGs: $expresion" );

    if (!(preg_match('/DROP|DELETE|UPDATE|CREATE|TABLE|ALTER|DATABASE|FROM|WHERE/i', $expresion)))
     {     
//          $expresion = preg_replace("/€|ñ|:|%|$|&|á|é|í|ó|ú/i", "", $expresion);         // quitamos todas las letras 
          $expresion = quita_simbolos_no_matematicos( $expresion);        
          $expresion = preg_replace("([a-z]+)i", "", $expresion);         // quitamos todas las letras 
          if($result=$Conn->query("SELECT  $expresion AS valor  ; " ))
          { if ($rs = $result->fetch_array(MYSQLI_ASSOC) ) 
               {
                  $nuevo_valor= ROUND($rs["valor"],15) ; 
               } 
          }
          else
          {
               $nuevo_valor= 0 ; 
          }   
//      $nuevo_valor=evalua_expresion($nuevo_valor ) ;  // los datos numericos pueden meterse como formulas
//       
//       $nuevo_valor=evalua_expresion($nuevo_valor ) ;  // los datos numericos pueden meterse como formulas
     }
     else
     {
       $nuevo_valor= 0 ;  
     }  

     return $nuevo_valor;
}



function datediff($fecha2,$fecha1)
{
     return (strtotime($fecha2) - strtotime($fecha1))/86400;  ;
}





function fra_cliente_generar_cobro($id_fra)
{
  //extract($GLOBALS);
      if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }
    
// $id_mov_banco=$_GET["id_mov_banco"]  ;	
//  
//$id_fra_prov=$_GET["id_fra_prov"]  ;	

$id_cta_banco=  getVar('id_cta_banco_auto')  ;  // previamente habría que consultar si existe la variable y en caso negativo, crearla cta_banco CAJA_METALICO y la variable
$importe=round(Dfirst("IMPORTE_IVA-IFNULL(Cobro_Prov,0)","Facturas_View", "ID_FRA=$id_fra"),2) ;	
$fecha_banco=Dfirst("FECHA_EMISION","Facturas_View", "ID_FRA=$id_fra") ;	
$concepto=Dfirst( "CONCAT(CLIENTE,' ',NOMBRE_OBRA,' ',CONCEPTO )","Facturas_View", "ID_FRA=$id_fra") ;	

// creamos el MOV.BANCARIO en la cta_banco de CAJA_METALICO
// una vez tenemos el mov_banco, creamos el ID_PAGO , lo conciliamos a la factura y luego lo conciliamos con el MOV_BANCO
$sql="INSERT INTO `PAGOS` ( id_cta_banco,tipo_pago,f_vto,ingreso,observaciones,user )  "
        . "  VALUES ( '$id_cta_banco' ,'C' ,'$fecha_banco' ,'$importe' ,'$concepto' , '{$_SESSION['user']}' );" ;
//   echo ($sql);
  $result=$Conn->query($sql);
  if ($result) //compruebo si se ha creado la obra
        { 	
         $id_pago=Dfirst( "MAX(id_pago)", "PAGOS", "id_cta_banco=$id_cta_banco" ) ; 
//         setVar("id_linea_avales_auto", $id_linea_avales) ;        // creamos la nueva variable 'id_linea_avales_auto' 
         
         $sql="INSERT INTO FRAS_CLI_PAGOS ( id_fra,id_pago ) VALUES ( '$id_fra'  ,'$id_pago'  );" ;
//            echo "<BR>$sql";

          if(!$result=$Conn->query($sql))   echo "ERROR EN CREACION DE FRA_CLI_PAGO";     
        }
      else
       {die('ERROR CREANDO COBRO '.($_SESSION["admin"] ? $sql : "") ); 
       }

return $id_pago;
}




function concilia_mov_banco_fra_prov($modo, $id_mov_banco,$id_fra_prov, $importe=null)
{
  //extract($GLOBALS);
      if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }
    
// $id_mov_banco=$_GET["id_mov_banco"]  ;	
//  
//$id_fra_prov=$_GET["id_fra_prov"]  ;	

    
// si no se ha indicado el Importe, calculamos el importe pendiente de pago de la factura en cuestión    
$importe= is_null($importe)?  Round( Dfirst("pdte_pago","Fras_prov_importes", "ID_FRA_PROV=$id_fra_prov") , 2 ) : evalua_expresion_mysql( $importe) ;	   // hacemos el MOV_BANCO solo por el pdte_pago de la factura
    
if ($modo=='CAJA_METALICO' )          //$id_mov_banco puede ser CAJA_METALICO, SOLO_PAGO (no se concilia el id_pago a bancos, o el id_mov_banco a conciliar el id_pago
{
    // preparamos para crear primero el id_mov_banco en la cta_banco CAJA_METALICO
//$id_cta_banco=  getVar('id_cta_banco_caja_metalico')  ;	              // CUENTA PARA PAGOS EN METALICO previamente habría que consultar si existe la variable y en caso negativo, crearla cta_banco CAJA_METALICO y la variable
$id_cta_banco=  getVar('id_cta_banco_auto')  ;	      // HEMOS ANULADO EL USO DE CAJA_METALICO, irá a la id_cta_banco_auto  (juand, junio2020)     
//$importe=Dfirst("IMPORTE_IVA","FACTURAS_PROV", "ID_FRA_PROV=$id_fra_prov") ;	
//$importe= is_null($importe)?  Round( Dfirst("pdte_pago","Fras_prov_importes", "ID_FRA_PROV=$id_fra_prov") , 2 ) : $importe ;	   // hacemos el MOV_BANCO solo por el pdte_pago de la factura
//$fecha_banco=Dfirst("FECHA","FACTURAS_PROV", "ID_FRA_PROV=$id_fra_prov") ;	
$fecha_banco=date('Y-m-d');	 // cambiamos a la FECHA DE HOY
$concepto=Dfirst( "CONCAT(PROVEEDOR,' ', N_FRA)","Fras_Prov_View", "ID_FRA_PROV=$id_fra_prov") ;	

// creamos el MOV.BANCARIO en la cta_banco de CAJA_METALICO
$sql="INSERT INTO `MOV_BANCOS` ( id_cta_banco,fecha_banco,cargo,Concepto,user )  "
        . "  VALUES ( '$id_cta_banco' ,'$fecha_banco' ,'$importe' ,'$concepto' , '{$_SESSION['user']}' );" ;
  // echo ($sql);
  $result=$Conn->query($sql);
  $id_mov_banco=Dfirst( "MAX(id_mov_banco)", "MOV_BANCOS", "id_cta_banco=$id_cta_banco" ) ; 

}elseif (substr( $id_mov_banco, 0, 4 ) =='CTA_' )   //$id_mov_banco CTA_xxx, debemos crear MOV_BANCO en cta ID_CTA=XXX y conciliar despues (util para ABONOS Y COMPENSACIONES DE FRAS)
{
    // preparamos para crear primero el id_mov_banco en la cta_banco CAJA_METALICO
$id_cta_banco=Dfirst( 'id_cta_banco','ctas_bancos' , " id_c_coste={$_SESSION['id_c_coste']} AND id_cta_banco=". substr( $id_mov_banco, 4 ) ) ;   // CUENTA CTA_XXX y comprobacion SEGURIDAD

//$fecha_banco=Dfirst("FECHA","FACTURAS_PROV", "ID_FRA_PROV=$id_fra_prov") ;	
$fecha_banco=date('Y-m-d');	 // cambiamos a la FECHA DE HOY

$concepto=Dfirst( "CONCAT(PROVEEDOR,' ', N_FRA)","Fras_Prov_View", "ID_FRA_PROV=$id_fra_prov") ;	

// creamos el MOV.BANCARIO en la cta_banco de CTA_XXX
if (!($modo=='SOLO_PAGO'))
 {
    $sql="INSERT INTO `MOV_BANCOS` ( id_cta_banco,fecha_banco,cargo,Concepto,user )  "
        . "  VALUES ( '$id_cta_banco' ,'$fecha_banco' ,'$importe' ,'$concepto' , '{$_SESSION['user']}' );" ;
    // echo ($sql);
    $result=$Conn->query($sql);
    $id_mov_banco=Dfirst( "MAX(id_mov_banco)", "MOV_BANCOS", "id_cta_banco=$id_cta_banco" ) ; 
 }
}  
  
elseif ($modo=='SOLO_PAGO')  // modo SOLO PAGO pero sin definir CTA_xxx
{

$id_cta_banco= getVar('id_cta_banco_auto') ;	                    // CUENTA POR DEFECTO previamente habría que consultar si existe la variable y en caso negativo, crearla cta_banco_auto y la variable
//$importe=Round(Dfirst("pdte_pago","Fras_prov_importes", "ID_FRA_PROV=$id_fra_prov"), 2) ;	
$fecha_banco=Dfirst("FECHA","FACTURAS_PROV", "ID_FRA_PROV=$id_fra_prov") ;	
$concepto=Dfirst( "CONCAT(PROVEEDOR,' ', N_FRA)","Fras_Prov_View", "ID_FRA_PROV=$id_fra_prov") ;	
    
}   
else
{    // conciliamos el nuevo pago con un id_mov_banco existente
    
logs("creando Pago en fra_prov para el id_mov_banco $id_mov_banco ") ;
$id_cta_banco=Dfirst("id_cta_banco","MOV_BANCOS", "id_mov_banco=$id_mov_banco") ;	
$importe=Round(Dfirst("cargo","MOV_BANCOS", "id_mov_banco=$id_mov_banco"), 2) ;	// creamos el nuevo Pago con mov. banco existente con el importe del mov.banco
$fecha_banco=Dfirst("fecha_banco","MOV_BANCOS", "id_mov_banco=$id_mov_banco") ;	
$concepto=Dfirst("Concepto","MOV_BANCOS", "id_mov_banco=$id_mov_banco") ;	
}

// una vez tenemos el mov_banco, creamos el ID_PAGO , lo conciliamos a la factura y luego lo conciliamos con el MOV_BANCO
$sql="INSERT INTO `PAGOS` ( id_cta_banco,tipo_pago,f_vto,importe,observaciones,user )  "
        . "  VALUES ( '$id_cta_banco' ,'P' ,'$fecha_banco' ,'$importe' ,'$concepto' , '{$_SESSION['user']}' );" ;
  // echo ($sql);
  $result=$Conn->query($sql);
  if ($result) //compruebo si se ha creado la obra
        { 	
             $id_pago=Dfirst( "MAX(id_pago)", "PAGOS", "id_cta_banco=$id_cta_banco" ) ; 
    //         setVar("id_linea_avales_auto", $id_linea_avales) ;        // creamos la nueva variable 'id_linea_avales_auto' 

             $sql="INSERT INTO FRAS_PROV_PAGOS ( id_fra_prov,id_pago ) VALUES ( '$id_fra_prov'  ,'$id_pago'  );" ;
             $result=$Conn->query($sql);

             if (!($modo=='SOLO_PAGO'))  // si no estamos en la situacin SOLO_PAGO, vinculamos el id_mov_banco con el id_fra_prov
             { 
//               $sql="INSERT INTO PAGOS_MOV_BANCOS ( id_pago,id_mov_banco ) VALUES ( '$id_pago','$id_mov_banco'   );" ;  // SUSTITUIDA POR ELIMINACION DE TABLA PAGOS_MOV_BANCOS
                 $sql="UPDATE PAGOS SET id_mov_banco='$id_mov_banco' WHERE id_pago=$id_pago ;"  ;

                 $result=$Conn->query($sql);
             }    
         
        }
      else
       {
//          die('ERROR CREANDO PAGO '. ($_SESSION["admin"]? $sql : "") );   // ANULADO JUAND, AGO20, mejor que siga aunque haya errores y concilie el resto
       }

//  echo "CONCILACION CREADA: $id_mov_banco - $id_fra_prov"     ;   //DEBUG

	return $result;
} 

function crea_pago_a_mov_banco($id_mov_banco)
{
  //extract($GLOBALS);
      if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }
    
$result=$Conn->query("SELECT * FROM MOV_BANCOS_View WHERE id_c_coste={$_SESSION['id_c_coste']}  AND id_mov_banco=$id_mov_banco " );

$return=0 ;    // si algo va mal, retorno 0

if ($rs = $result->fetch_array(MYSQLI_ASSOC))  
{    
    $id_cta_banco=$rs["id_cta_banco"] ;	// conciliamos el nuevo pago con un id_mov_banco existente
    $importe=Round($rs["cargo"], 2) ;	
    $ingreso=Round($rs["ingreso"], 2) ;	
    $fecha_banco=$rs["fecha_banco"] ;	
    $concepto=$rs["Concepto"] ;	

    //$id_nota_gastos = getVar("id_NG_traspasos") ;

    // una vez tenemos el mov_banco, creamos el ID_PAGO , lo conciliamos a la factura y luego lo conciliamos con el MOV_BANCO
    $sql="INSERT INTO `PAGOS` ( id_cta_banco,id_mov_banco, tipo_pago, f_vto, importe, ingreso, observaciones, user )  "
            . "  VALUES ( '$id_cta_banco' ,'$id_mov_banco' ,'T' ,'$fecha_banco' ,'$importe' ,'$ingreso' ,'$concepto' , '{$_SESSION['user']}' );" ;
      // echo ($sql);
  
      
  $result_INSERT=$Conn->query($sql);
  if ($result_INSERT) //compruebo si se ha creado la obra
    { 	
     $id_pago=Dfirst( "MAX(id_pago)", "PAGOS", "id_cta_banco=$id_cta_banco" ) ; 

    //         $sql="INSERT INTO NOTA_GASTOS_PAGOS (id_nota_gastos ,id_pago ) VALUES ( '$id_nota_gastos'  ,'$id_pago'  );" ;
    //         $result=$Conn->query($sql);

//     $sql="INSERT INTO PAGOS_MOV_BANCOS ( id_pago,id_mov_banco ) VALUES ( '$id_pago','$id_mov_banco'   );" ;
//     $sql="UPDATE PAGOS SET id_mov_banco='$id_mov_banco' WHERE id_pago=$id_pago ;"  ;

//     $return = ($result=$Conn->query($sql)) ? $id_pago : 0 ;
     $return =  $id_pago  ;

    }
     
}

return $return;
//return $id_pago;
} 

function concilia_traspaso_interno($id_mov_banco1,$id_mov_banco2)
{
  //extract($GLOBALS);
      if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }
    
$return = 0 ; 
    
if (($id_pago1=crea_pago_a_mov_banco($id_mov_banco1)) AND ($id_pago2=crea_pago_a_mov_banco($id_mov_banco2)) )
{       
  $id_nota_gastos = getVar("id_NG_traspasos") ;

  

 $sql1="INSERT INTO NOTA_GASTOS_PAGOS (id_nota_gastos ,id_pago ) VALUES ( '$id_nota_gastos'  ,'$id_pago1'  );" ;
// $result=$Conn->query($sql1);

 $sql2="INSERT INTO NOTA_GASTOS_PAGOS (id_nota_gastos ,id_pago ) VALUES ( '$id_nota_gastos'  ,'$id_pago2'  );" ;
 $return = ($Conn->query($sql1)) AND ($Conn->query($sql2));


     
}

return $return;
} 


function json_geoip($ip)
{
          // GEOLOCALIZACION
        $ip = $_SERVER['REMOTE_ADDR'];
        $access_key = '2cc3ac17c59e7be9495ada797e7ee53a';  // API KEY solicitada y gratuita
        $ch = curl_init('http://api.ipapi.com/'.$ip.'?access_key='.$access_key.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);
//        $api_result = json_decode($json, true);
//        $pais= $api_result['country_name'];

        return $json;
}

function pais($json)
{
   $api_result = json_decode($json, true);
   return $api_result['city'].','.$api_result['region_name'].','.$api_result['country_name'];

}

function registrar_acceso($id_c_coste,$user,$empresa,$resultado,$ip, $error, $android ,$pais='', $json_geoip='', $id_usuario=0)
{
  //extract($GLOBALS);
      if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }
    
      $sql="insert into w_Accesos (id_c_coste  ,  ip   , usuario   , clave  ,  resultado  , sistema     ,error, android , pais , json_geoip,id_usuario) "
              . "values  ($id_c_coste,'$ip','$user','$empresa','$resultado', '{$_SERVER['HTTP_USER_AGENT']}','$error', '$android' ,'$pais','$json_geoip',$id_usuario)";
	
         $result = $Conn->query($sql);

	return $result;
} 

//function encrypt($string) {
//    $key = "Construcloud.es ERP DE CONSTRUCCION. MALAGA. ESPAÑA";
//    return rawurlencode(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))))) ;
//}
// 
//function decrypt($string) {
//    $key = "Construcloud.es ERP DE CONSTRUCCION. MALAGA. ESPAÑA";
//    return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode(rawurldecode($string)), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
//}

function encrypt2($string) {
    $key = "crypt_38064764f4bd84307739297f20892fd66301ca9c6276064f2e52df65757eb288";
//    return "crypt_".bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key)))) ;
    return "crypt_".bin2hex(openssl_encrypt($string , "AES-128-ECB", $key)) ;
}
 
function decrypt2($string) { 
    $key = "crypt_38064764f4bd84307739297f20892fd66301ca9c6276064f2e52df65757eb288";
//    return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), hex2bin(substr($string,6)), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    return openssl_decrypt( hex2bin(substr($string,6)), "AES-128-ECB", $key );
}

function is_encrypt2($string) {
    
    return (substr($string,0,6) == "crypt_" ) ;
}

//  antiguas funciones ENCRYPT de version PHP 7.0
//
//function encrypt2($string) {
//    $key = "crypt_38064764f4bd84307739297f20892fd66301ca9c6276064f2e52df65757eb288";
//    return "crypt_".bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key)))) ;
//}
// 
//function decrypt2($string) {
//    $key = "crypt_38064764f4bd84307739297f20892fd66301ca9c6276064f2e52df65757eb288";
//    return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), hex2bin(substr($string,6)), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
//}
//
//function is_encrypt2($string) {
//    
//    return (substr($string,0,6) == "crypt_" ) ;
//}
//
            

function cc_urlencode($string) {
    return bin2hex($string) ;
}
 
function cc_urldecode($string) {
    return hex2bin($string);
}

function cc_password_hash($string) {
    return 'hash_'.encrypt2(password_hash($string,PASSWORD_DEFAULT));
}
function cc_password_verify_hash($password, $password_hash_db) {
    return password_verify($password,  decrypt2(substr($password_hash_db,5))  );
}


function tipo_dato($valor)
{
    $ret=0 ;  // si no se encuentra devuelve 0
    
    if(preg_match('/^[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}$/', substr($valor,0,10) )) $ret="fecha" ;
    if(preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/', substr($valor,0,10)  )) $ret="dbfecha" ;
    
    
    return $ret;
}

function cc_formato_auto($clave)
{
    $format='';
    if (strtoupper(substr($clave,0,14))=="FECHA_CREACION")
    {   $format='' ;  }
    elseif ((strtoupper(substr($clave,0,2))=="F_") or (strtoupper(substr($clave,0,5))=="FECHA"))
    {   $format='fecha' ;  }
//    elseif (strtoupper(substr($clave,0,14))=="BASE_IMPONIBLE" OR strtoupper(substr($clave,0,6))=="OFERTA" OR strtoupper(substr($clave,0,7))=="CARTERA" 
//              OR strtoupper(substr($clave,0,5))=="BENEF" OR strtoupper(substr($clave,0,7))=="IMPORTE" OR strtoupper(substr($clave,0,5))=="COSTE"
//             OR strtoupper(substr($clave,0,6))=="PRECIO" OR strtoupper(substr($clave,0,7))=="INGRESO" OR strtoupper(substr($clave,0,5))=="GASTO"
//             OR strtoupper(substr($clave,0,5))=="VENTA" OR strtoupper(substr($clave,0,10))=="VALORACION")
    elseif (preg_match("/^BASE_IMPONIBLE|^OFERTA|^CARTERA|^VALORACION|^VENTA|^GASTO|^INGRESO|^PRECIO|^COSTE|^IMPORTE|^BENEF|^PDTE_COBRO/i", $clave))       
    { $format='moneda' ; }          ///, &$valor , &$format_style)
    elseif (strtoupper(substr($clave,0,3))=="IVA")
    { $format='porcentaje0' ; }          ///, &$valor , &$format_style)
//    elseif (strtoupper(substr($clave,0,6))=="MARGEN" OR strtoupper(substr($clave,0,10))=="PORCENTAJE" OR strtoupper(substr($clave,0,2))=="P_" OR strtoupper(substr($clave,0,5))=="PORC_")
    elseif (preg_match("/^MARGEN|^OFERTA|^PORCENTAJE|^P_|^PORC_/i", $clave))
    { $format='porcentaje' ; }       ///, &$valor , &$format_style)
    elseif (preg_match("/^permiso_|^activ[a-o]/i", $clave))
    { $format='boolean' ; }       ///, &$valor , &$format_style)
    elseif (strtoupper(substr($clave,0,8))=="CANTIDAD" OR strtoupper(substr($clave,0,8))=="MEDICION")
    { $format='fijo1' ; }         ///, &$valor , &$format_style)
    elseif (strtoupper(substr($clave,0,4))=="NUM_")
    { $format='fijo0' ; }          ///, &$valor , &$format_style)
    elseif (strtoupper(substr($clave,0,6))=="TAMANO")
    { $format='mb' ; }        ///, &$valor , &$format_style)
    elseif (preg_match("/^TEXTO|^OBS/i", $clave))
    { $format='text_edit' ; }         ///, &$valor , &$format_style)
    elseif (preg_match("/^PATH_/i", $clave))
    { $format='pdf_100_100' ; }       //formato provisional para Empresas_View 
    elseif (preg_match("/^tipo_remesa|^tipo_pago/i", $clave))
    { $format='tipo_pago' ; }       ///, &$valor , &$format_style)

    return $format ;
}


function is_fecha($valor)
{
$regEx = '/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/';

return     preg_match($regEx, $valor);
}

function is_numero($valor)
{
    $re = "~        #delimiter
    ^           # start of input
    -?          # minus, optional
    [0-9]+      # at least one digit
    (           # begin group
        \.      # a dot
        [0-9]+  # at least one digit
    )           # end of group
    ?           # group is optional
    $           # end of input
~xD";


    
     return preg_match($re, $valor)  ;
}



function is_format_numero($format)
{
     return in_array($format , ['moneda','porcentaje','porcentaje0','fijo','fijo0','fijo1','fijo10','text_moneda'] ) ;
}

//require("../include/NumeroALetras.php");


function num2txt_eur($importe)
{
    require_once("../include/NumeroALetras.php");
    return  NumeroALetras::convertir(ROUND($importe,2), 'euros', 'centimos')." (". trim( cc_format(ROUND($importe,2),'moneda_europeo')).")" ;
}

function num2txt($importe)
{
    require_once("../include/NumeroALetras.php");
    return  NumeroALetras::convertir(ROUND($importe,2), '', 'centimos');
}

function cc_etiqueta($clave)
{
    
    $clave=str_replace('ID_','',$clave) ;
    $clave=str_replace('id_','',$clave) ;
    $clave=str_replace('_',' ',$clave) ;
    $clave=str_replace('porcentaje','%',$clave) ;
    $clave=str_replace('Porcentaje','%',$clave) ;
    $clave=str_replace('porc','%',$clave) ;
   
    return  $clave;
}

//str_replace('_',' ',( (strtoupper(substr($clave,0,3))=="ID_")? substr($clave,3) 


function cc_format_align($format_style)  // devuelve la alineacion de un style creado en la variable por referencia formato_style de la func. cc_format()
{
   return ( strpos($format_style ,'left') ? 'left' : (strpos($format_style ,'right') ? 'right' : (strpos($format_style ,'center') ? 'center' : 'center' ))) ;
}


function cc_format($valor , $format="" , &$format_style="", $clave="")     ///, &$valor , &$format_style   $clave == NOMBRE DEL CAMPO, Ej: Importe)
{
// función para dar formato a $valor 
//
//    ej:  $valor=cc_format( $valor) ;            la función tratará de averiguar que tipo de dato contiene (numerico, fecha...)
//         $valor=cc_format( $valor, $format) ;   indicamos el formato que queremos
//         $valor=cc_format( $valor, $formats[$clave], $format_style) ; pasamos el parámetro opcional '$format_style' por referencia para ver qué alineación viene mejor en una tabla

    
    
    
    
    
 // provisional
    $pdf_size=100 ;
    
 // provisionalmente cambiamos todos los semaforos a semaforo_OK, con el tiempo anulamos el formato semaforo a secas
 $format = ($format==="boolean") ? "semaforo_OK" : $format ; 
 $format = ($format==="semaforo") ? "semaforo_OK" : (($format=="semaforo_not") ? "semaforo_not_OK" : $format) ;
    
    
 $color_style="";  
    
//   $format= str_replace('boolean', 'semaforo', $format)  ;  //provisional probamos a cambiar a saco los boolean (X) por semaforos rojo/verde
   if ($format=='auto')
      {
//           preg_match () ;
         //  $format=/\d\d\d\d-\d\d-\d\d/.test(text)  ;
        $format=cc_formato_auto($clave) ;        // miramos el nombre del campo para determinar el formato
      }
  elseif (substr($format,0,8)=="boolean_")                 // formato boolean_txt
     {  $txt=substr($format,8)   ;
        $format="boolean_txt" ;
     }  
  elseif (substr($format,0,13)=="semaforo_txt_")                 // formato boolean_txt
     {  $txt=substr($format,13)   ;
        $format="semaforo_txt" ;
     }  
  elseif (substr($format,0,14)=="semaforo_txt2_")                 // formato boolean_txt
     {  $txt=substr($format,14)   ;
        $format="semaforo_txt2" ;
     }  
//  elseif (substr($format,0,5)=="icon_")                 // formato boolean_txt
//     {  $icon=substr($format,5)   ;
//        $format="icon" ;
//     }  
  elseif (substr($format,0,12)=="textarealert")                 // formato boolean_txt
     {  
        $tooltip_txt_alert= str_replace("\n","\\n", $valor) ;  
//        $tooltip_txt="<i class='fas fa-info-circle btn-link' style='opacity:0.3' onclick=\"alert('$tooltip_txt_alert')\" title='$valor'></i>" ;
//        $tooltip_span="<div class='btn-link' style='border-bottom:2px dotted ;cursor: help;' onclick=\"alert('$tooltip_txt_alert')\" title='$valor'>" ; // QUITO EL PUNTEADO
        $tooltip_span="<div class='btn-link' style='cursor: help;' onclick=\"alert('$tooltip_txt_alert')\" title='$valor'>" ;
        
        // calculamos la longitud TEXTAREA_XXX o por defecto la hacemos 10
        $len= (substr($format,0,9)=="textarea_") ? substr($format,9) : 10 ;
        $len2=10 ;
        $format="textarea_" ;
        
     }  
  elseif (substr($format,0,8)=="textarea")                 // formato boolean_txt
     {  
        $tooltip_txt_alert= "" ;  
//        $tooltip_txt="<i class='fas fa-info-circle btn-link' style='opacity:0.3' onclick=\"alert('$tooltip_txt_alert')\" title='$valor'></i>" ;
//        $tooltip_span="<div class='btn-link' style='border-bottom:2px dotted ;cursor: help;' onclick=\"alert('$tooltip_txt_alert')\" title='$valor'>" ; // QUITO EL PUNTEADO
        $tooltip_span="" ;
        
        // calculamos la longitud TEXTAREA_XXX o por defecto la hacemos 10
        $array_textarea= explode("_", $format) ;
        $len= (substr($format,0,9)=="textarea_") ? substr($format,9) : 10 ;
        $len = isset($array_textarea[1]) ? $array_textarea[1] : 10 ;
        $len2 = isset($array_textarea[2]) ? $array_textarea[2] : 10 ;
        $format="textarea_" ;
        
     }  
  elseif (substr($format,0,4)=="pdf_")                 // formato boolean_txt
     {  
        $a=explode("_", $format);   // exploto el string en un array de 2 o 3 elementos
        $pdf_size= $a[1]   ;
        $pdf_size2= isset($a[2]) ? $a[2] : ''   ;
     
        $format="pdf_" ;
     }  
  elseif (substr($format,0,8)=="pdflink_")                 // formato boolean_txt
     {  
        $a=explode("_", $format);   // exploto el string en un array de 2 o 3 elementos
        $pdf_size= $a[1]   ;
        $pdf_size2= isset($a[2]) ? $a[2] : ''   ;
     
        $format="pdflink_" ;
     }  
    elseif (like($format,"moneda_porcentaje_sobre_%"))      //moneda_porcentaje_
    {
      $valor_comparado= str_replace("moneda_porcentaje_sobre_","", $format);
      $format= "moneda_porcentaje_sobre" ;
    }        
    elseif (preg_match("/^h[0-9]_/i" ,  $format ))      //h1, ... h5
    {
//      $color_style = preg_replace("/^h[0-9]_/i","", $format);             // quito el hX_
      $color_style = "color:". substr($format,3) .";" ;             // quito el hX_
      $format= substr($format,0,2) ;      // cojo los dos primeros chars
    }        
     
    
// pdte desarrollar una funcion que trata de identificar el tipo de dato y su formato: numerico (999,999.99), fecha(01/01/2017 , 2018-01-01 0:00:00 , ...) , textarea...
switch ($format) {
//            case "icon":
//                        //$valor = ($valor==0) ? "" : number_format($valor,2,".",",") . "€"  ;
//                        $valor = "<span class='glyphicon glyphicon-$icon'></span>" ;
//                        $format_style=" style='text-align:left;' " ;
//                        break;
            case "num2txt":
                        //$valor = ($valor==0) ? "" : number_format($valor,2,".",",") . "€"  ;
                        $valor = num2txt($valor) ;
                        $format_style=" style='text-align:left;' " ;
                        break;
            case "num2txt_eur":
                        $valor = num2txt_eur($valor) ;
                        $format_style=" style='text-align:left;' " ;
                        break;
            case "int":
                        //$valor = ($valor==0) ? "" : number_format($valor,2,".",",") . "€"  ;
                        $valor = ($valor==0) ? "" : str_pad(number_format($valor,0,".",",") ,10," ", STR_PAD_LEFT) ;  //str_pad($input, 10, "-=", STR_PAD_LEFT);
                        $format_style=" style='text-align:right;' " ;
                        break;
            case "firmado": 
                        //$valor = ($valor==0) ? "" : number_format($valor,2,".",",") . "€"  ;
//                        $valor = round($valor,2) ;
                        $color= ($valor=='PDTE') ? "blue" : (($valor=='CONFORME') ? "green" : "red") ;
//                        $valor = ($valor) ? "" : str_pad(number_format($valor,2,".",",") ,10," ", STR_PAD_LEFT)." ".$_SESSION["Moneda_simbolo"]  ;  //str_pad($input, 10, "-=", STR_PAD_LEFT);
                        $format_style=" style='font-weight: bold;text-align:center; color: $color' " ;
                        break;
            case "tipo_pago": 
                        $color= ($valor=='P') ? "red" : (($valor=='C') ? "green" : (($valor=='T') ? "blue" : "brown")) ;
                        $valor= ($valor=='P') ? "PAGO" : (($valor=='C') ? "COBRO" : (($valor=='T') ? "TRASPASO" : "OTRO")) ;
                        $format_style=" style='font-weight: bold;text-align:center; color: $color' " ;
                        break;
            case "moneda": 
                        //$valor = ($valor==0) ? "" : number_format($valor,2,".",",") . "€"  ;
                        $valor = round($valor,2) ;
                        $color_numero= ($valor<0) ? "red" : "black" ;
                        $valor = ($valor==0) ? "" : str_pad(number_format($valor,2,".",",") ,10," ", STR_PAD_LEFT)." ".$_SESSION["Moneda_simbolo"]  ;  //str_pad($input, 10, "-=", STR_PAD_LEFT);
                        $format_style=" style='white-space: nowrap;text-align:right; color: $color_numero' " ;
                        break;
            case "moneda_europeo":
                        //$valor = ($valor==0) ? "" : number_format($valor,2,".",",") . "€"  ;
                        $valor = round($valor,2) ;
                        $color_numero= ($valor<0) ? "red" : "black" ;
                        $valor = ($valor==0) ? "" : str_pad(number_format($valor,2,",",".") ,10," ", STR_PAD_LEFT)." ".$_SESSION["Moneda_simbolo"]  ;  //str_pad($input, 10, "-=", STR_PAD_LEFT);
                        $format_style=" style='white-space: nowrap;text-align:right; color: $color_numero' " ;
                        break;
            case "moneda_gris":
                        //$valor = ($valor==0) ? "" : number_format($valor,2,".",",") . "€"  ;
                        $valor = round($valor,2) ;
//                        $color_numero= ($valor<0) ? "grey" : "grey" ;
                        $valor = ($valor==0) ? "" : str_pad(number_format($valor,2,".",",") ,10," ", STR_PAD_LEFT)." ".$_SESSION["Moneda_simbolo"]  ;  //str_pad($input, 10, "-=", STR_PAD_LEFT);
                        $format_style=" style='white-space: nowrap;text-align:right; color: grey; font-style:italic ' " ;
                        break;
            case "moneda_parentesis":
                        $valor = ($valor==0) ? "" : "<small>(".trim(cc_format($valor,'moneda')).")</small>"  ;  //str_pad($input, 10, "-=", STR_PAD_LEFT);
                        //$valor = ($valor==0) ? "" : number_format($valor,2,".","")   ;
                        $format_style=" style='white-space: nowrap;text-align:right;' " ;
                        break;
            case "moneda_porcentaje_sobre":
//                        $valor = round($valor,2) ;
                        $valor_numero = $valor ;
                        $color_numero= ($valor<0) ? "red" : "black" ;
                        $valor = ($valor==0) ? "" : str_pad(number_format($valor,2,".",",") ,10," ", STR_PAD_LEFT)." ". $_SESSION["Moneda_simbolo"] ;
                        // si no hay division por cero, añadimos el porcentaje_sobre...
//                        $valor .= ($valor_comparado==0) ? "" : " <span style='opacity:0.7;font-size:85%;font-style: italic'>(".(trim(cc_format($valor_numero/$valor_comparado,'porcentaje'))).")</span>"  ;  //str_pad($input, 10, "-=", STR_PAD_LEFT);            
                        $valor .= ($valor_comparado==0) ? "" : " <span style='opacity:0.7;font-size:85%;font-style: italic'>(".(number_format(100*$valor_numero/$valor_comparado,1))."%)</span>"  ;  //str_pad($input, 10, "-=", STR_PAD_LEFT);            
                        
                        $format_style=" style='white-space: nowrap;text-align:right; color: $color_numero' " ;
                
//                        $valor = ($valor==0) ? "" : "<small>(".trim(cc_format($valor,'moneda')).")</small>"  ;  //str_pad($input, 10, "-=", STR_PAD_LEFT);
                        //$valor = ($valor==0) ? "" : number_format($valor,2,".","")   ;
//                        $format_style=" style='text-align:right;' " ;
                        break;
            case "fijo":
                        $valor = ($valor==0) ? "" : str_pad(number_format($valor,2,".",","),10," ", STR_PAD_LEFT)  ;  //str_pad($input, 10, "-=", STR_PAD_LEFT);
                        //$valor = ($valor==0) ? "" : number_format($valor,2,".","")   ;
                        $format_style=" style='white-space: nowrap;text-align:right;' " ;
                        break;
            case "fijo_gris":
                        $valor = ($valor==0) ? "" : str_pad(number_format($valor,2,".",","),10," ", STR_PAD_LEFT)  ;  //str_pad($input, 10, "-=", STR_PAD_LEFT);
                        //$valor = ($valor==0) ? "" : number_format($valor,2,".","")   ;
                        $format_style=" style='white-space: nowrap;text-align:right; color: grey' " ;
                        break;
            case "fijo0":
                        $valor = ($valor==0) ? "" : str_pad(number_format($valor,0,".",","),10," ", STR_PAD_LEFT)  ;  //str_pad($input, 10, "-=", STR_PAD_LEFT);
                        //$valor = ($valor==0) ? "" : number_format($valor,2,".","")   ;
                        $format_style=" style='text-align:right;' " ;
                        break;
            case "fijo1":
                        $valor = ($valor==0) ? "" : str_pad(number_format($valor,1,".",","),10," ", STR_PAD_LEFT)  ;  //str_pad($input, 10, "-=", STR_PAD_LEFT);
                        //$valor = ($valor==0) ? "" : number_format($valor,2,".","")   ;
                        $format_style=" style='text-align:right;' " ;
                        break;
            case "fijo10":
                        $valor = ($valor==0) ? "" : str_pad(number_format($valor,10,".",","),10," ", STR_PAD_LEFT)  ;  //str_pad($input, 10, "-=", STR_PAD_LEFT);
                        //$valor = ($valor==0) ? "" : number_format($valor,2,".","")   ;
                        $format_style=" style='text-align:right;' " ;
                        break;
            case "h1":
                        $valor = "<h1>$valor</h1>"   ;
                        $format_style=" style='text-align:center;$color_style' " ;
                        break;
            case "h2":
                        $valor = "<h2>$valor</h2>"   ;
                        $format_style=" style='text-align:center;$color_style' " ;
                        break;
            case "h3":
                        $valor = "<h3>$valor</h3>"   ;
                        $format_style=" style='text-align:center;$color_style' " ;
                        break;
            case "h4":
                        $valor = "<h4>$valor</h4>"   ;
                        $format_style=" style='text-align:center;$color_style' " ;
                        break;
            case "h5":
                        $valor = "<h5>$valor</h5>"   ;
                        $format_style=" style='text-align:center;$color_style' " ;
                        break;
            case "color":
//                        $valor = "<h5>$valor</h5>"   ;
                        $format_style=" style='color:".str2color($valor).";' " ;
                        break;
            case "porcentaje":
                        $valor = ($valor==0)? "" : str_pad(number_format($valor*100,1,".",","),10," ", STR_PAD_LEFT) . "%"   ;
                        $color_numero= ($valor<0) ? "red" : "black" ;
                        $format_style=" style='white-space: nowrap;text-align:right; color: $color_numero' " ;
                        
                        break;
             case "porcentaje0":
                        $valor = ($valor==0)? "" :  str_pad(number_format($valor*100,0,".",","),10," ", STR_PAD_LEFT) . "%"   ;
                        $format_style=" style='white-space: nowrap;text-align:right;' " ;
                        break;        
             case "kb":
                        $valor = str_pad(number_format($valor/1024,0,".",","),10," ", STR_PAD_LEFT) . "&nbsp;kb"   ;
                        $format_style=" style='white-space: nowrap;text-align:right;' " ;
                        break;        
             case "mb":
                        $valor = str_pad(number_format($valor/(1024*1024),0,".",","),10," ", STR_PAD_LEFT) . "&nbsp;mb"   ;
                        $format_style=" style='white-space: nowrap;text-align:right;' " ;
                        break;        
             case "gb":
                        $valor = str_pad(number_format($valor/(1024*1024*1024),0,".",","),10," ", STR_PAD_LEFT) . "&nbsp;gb"   ;
                        $format_style=" style='white-space: nowrap;text-align:right;' " ;
                        break;        
//    					    case "fecha2":
//        						if ($valor<>"")  date_format(date_create($valor),"d/m/Y") ;
//					                $format_style=" style='text-align:center;' " ;
//        						break;
            case "dbfecha":                                                     // formato de fecha como base de datos
                        if ($valor<>"") substr(date_format(date_create($valor),"Y-m-d"),0,10) ;
                        $format_style=" style='text-align:center;' " ;
                        break;        
            case "fecha":                                                     // formato de fecha español
                        if ($valor<>"") $valor = "<span style='opacity : 0 ; font-size: 0px ;'>".date_format(date_create($valor),"Y-m-d")."</span>"." ".date_format(date_create($valor),"d/m/Y");

                        $format_style=" style='text-align:center;' " ;
                        break;        
             case "fecha_es_semana":                                                     // formato de fecha español
                        if ($valor<>"") $valor = date_format(date_create($valor),"l, j  F  Y");

                        $format_style=" style='text-align:center;' " ;
                        break;        
             case "fecha_es":                                                     // formato de fecha español
                        if ($valor<>"") $valor = date_format(date_create($valor),"d/m/Y");

                        $format_style=" style='text-align:center;' " ;
                        break;        
            case "fecha_semana":                                                     // formato de fecha como base de datos
                        if ($valor<>"") $valor = "<span style='opacity : 0 ; font-size: 0px ;'>".date_format(date_create($valor),"Y-m-d")."</span>"." ".date_format(date_create($valor),"D, d/m/Y");

                        $format_style=" style='text-align:center;' " ;
                        break;        
            case "fecha_friendly":  
                        setlocale(LC_TIME, "es_ES");
                        if ($valor<>"") $valor = "<span style='opacity : 0 ; font-size: 0px ;'>".date_format(date_create($valor),"Y-m-d")."</span>"." ".dateformat_friendly($valor);

                        $format_style=" style='text-align:center;' " ;
                        break;        
            case "mes":                                                     // formato de fecha como base de datos
                        setlocale(LC_TIME, "es_ES");
                        $fecha=date_create($valor);          //primero de mes de la fecha0
                        $mes_txt=ucwords(utf8_encode(strftime( '%B-%Y' , $fecha->getTimestamp() ))) ;
//                        if ($valor<>"") $valor = "<span style='opacity : 0 ; font-size: 0px ;'>".date_format($fecha,"Y-m")."</span>"." ".date_format($fecha,"F-Y");
                        if ($valor<>"") $valor = "<span style='opacity : 0 ; font-size: 0px ;'>".date_format($fecha,"Y-m")."-01"."</span>"." ".$mes_txt;

                        $format_style=" style='text-align:left;' " ;
                        break;        
            case "mes_txt":                                                     // formato de fecha como base de datos
                        setlocale(LC_TIME, "es_ES");
                        $fecha=date_create($valor);          //primero de mes de la fecha0
                        $mes_txt=ucwords(utf8_encode(strftime( '%B-%Y' , $fecha->getTimestamp() ))) ;
//                        if ($valor<>"") $valor = "<span style='opacity : 0 ; font-size: 0px ;'>".date_format($fecha,"Y-m")."</span>"." ".date_format($fecha,"F-Y");
                        if ($valor<>"") $valor = $mes_txt;

//                        $format_style=" style='text-align:left;' " ;
                        break;        
            case "boolean":
                        $valor = $valor ? "X" : "" ;
                        $format_style=" style='text-align:center;' " ;
                        break;
            case "icon_usuarios":
                        $icono=" <i class='far fa-user'></i> "  ;
                        $valor = ($valor=="solo_icon") ? $icono : (($valor==0) ? "" : "$valor $icono" ) ;
                        $format_style=" style='text-align:center;' " ;
                        break;
            case "icon_fotos":
                        $icono=" <i class='fas fa-camera'></i> "  ;
                        $valor = ($valor=="solo_icon") ? $icono : (($valor==0) ? "" : "$valor $icono" ) ;
                
                        $format_style=" style='text-align:center;' " ;
                        break;
            case "icon_albaranes":
                        $icono=" <i class='fas fa-tags'></i> "  ;
                        $valor = ($valor=="solo_icon") ? $icono : (($valor==0) ? "" : "$valor $icono" ) ;
                        $format_style=" style='text-align:center;' " ;
                        break;
            case "icon_maquinaria":
                        $icono=" <i class='fas fa-truck-pickup'></i> "  ;
                        $valor = ($valor=="solo_icon") ? $icono : (($valor==0) ? "" : "$valor $icono" ) ;
                        $format_style=" style='text-align:center;' " ;
                        break;
            case "icon_produccion":
                        $icono=" <i class='fas fa-hard-hat'></i> "  ;
                        $valor = ($valor=="solo_icon") ? $icono : (($valor==0) ? "" : "$valor $icono" ) ;
                        $format_style=" style='text-align:center;' " ;
                        break;
            case "boolean_txt":
                        $valor = $valor ? $txt : "" ;
                        $format_style=" style='text-align:center;' " ;
                        break;
            case "cuadro_mes":               // formato para los cuadros mensuales (cada fila un mes y cada columna un día)
                        if ($valor)
                        {
                           $format_style=" style='margin: 0px; padding: 0px;text-align:center; background-color: coral;' " ; 
                        }  
                        else
                        {
                            $valor = "" ;
                            $format_style=" style='text-align:center; background-color: white;' " ;    
                        }

                        break;        
//            case "textarea3":          // antigua textarea
////                        $valor = strlen($valor)<10 ? $valor : $tooltip_span . substr($valor,0,9)."..."."</span>" ;
//                        $valor = strlen($valor)<10 ? $valor : substr($valor,0,9)."...";
//                        $valor = $tooltip_span . $valor."</div>" ;
//                        $format_style=" style='text-align:left;' " ;        
//                        break;
//            case "textarea2":
////                        $valor = strlen($valor)<20 ? $valor : "..".substr($valor,-20).$tooltip_txt ;
////                        $valor = strlen($valor)<20 ? $valor : $tooltip_span .  "..".substr($valor,-20)."</span>" ;
//                        $valor = strlen($valor)<20 ? $valor :   "...".substr($valor,-20);
//                        $valor = $tooltip_span . $valor."</div>";
//                        $format_style=" style='text-align:left;' " ;        
//                        break;
//            case "textarea":            // antigua textarea3
////                        $valor = strlen($valor)<20 ? $valor : substr($valor,0,9)."...".substr($valor,-10).$tooltip_txt ;
////                        $valor = strlen($valor)<20 ? $valor : $tooltip_span . substr($valor,0,9)."...".substr($valor,-10)."</span>" ;
//                        $valor = strlen($valor)<20 ? $valor :  substr($valor,0,9)."...".substr($valor,-10);
//                        $valor = $tooltip_span . $valor."</div>";
//                
//                        $format_style=" style='text-align:left;' " ;        
//                        break;
            case "textarea_":
//                        $tooltip_txt_alert= str_replace("\n","\\n", $valor) ;

//                        $valor = strlen($valor)<($len+3) ? $valor : substr($valor,0,$len)."...".$tooltip_txt;
                        $valor = strlen($valor)<($len+3) ? $valor :  substr($valor,0,$len)."...".( $len2 ? substr($valor,-$len2) : "");
//                        $valor = $tooltip_span . $valor."</div>";
                        $valor = $tooltip_span . $valor;
                        $format_style=" style='text-align:left;' " ;        
                        break;
            case "pdf":
                // mostramos solo el medium sin link ni aumentar
                        $valor_file= (file_exists( $valor . '_medium.jpg') ) ? $valor . '_medium.jpg' : $valor ;  // si existe el _medium.jpg lo mostramos, si no (ej. un link) mostramos el doc directo
                        if ($valor) $valor = "<img src='$valor_file'  width='$pdf_size' alt='imagen no encontrada' >" ;
                        $format_style=" style='text-align:center;' " ;        
                        break;
            case "pdf_":
//        		mostramos el MEDIUM que aumenta en onmouseover linkamos al LARGE
//        										if ($valor) $valor = "<img src='{$valor}_large.jpg' onmouseover='this.width=300;this.height=600;' onmouseout='this.width=100;this.height=200;' width='100' height='200'  >" ;
                        if ($valor)
                        {  
//                         $pdf_size2=  isset($pdf_size2) ? ( $pdf_size2 ? $pdf_size2 :   $pdf_size*2    )  :  $pdf_size*2 ;   
                         $pdf_size2=  (isset($pdf_size2) AND $pdf_size2 ) ?  $pdf_size2  :  $pdf_size*2 ;   
//                            $valor = "<img src='{$valor}_large.jpg' onmouseover='this.width=500;' onmouseout='this.width=100;' width='100' >" ;
             // retardar con uso de setTimeout  PENDIENTE
//                         $valor= "<a style='font-size:0px'   href=\"{$valor}_large.jpg\" target='_blank' >"
                        $valor_file= (file_exists( $valor . '_medium.jpg') ) ? $valor . '_medium.jpg' : $valor ;  // si existe el _medium.jpg lo mostramos, si no (ej. un link) mostramos el doc directo
                        $valor= "<a style='font-size:0px'   href=\"{$valor}\" target='_blank' >" 
                        . "<img style='border: 10px solid white;' src=\"$valor_file\" alt='imagen no encontrada' "
                        . "onmouseover='this.style.borderImageWidth=\"20px 30px\";this.width=\"$pdf_size2\";' "
                                . "onmouseout='this.style.borderImageWidth=20 ;this.width=\"$pdf_size\";' width='$pdf_size'  >"
                                . "</a>" ;
                        }
                        $format_style=" style='text-align:center;' " ;        
                        break;
            case "pdflink_":
//        		muestra imagen con un link al correspondiente array $links[]
                        if ($valor)
                        {  
                         $pdf_size2=  (isset($pdf_size2) AND $pdf_size2 ) ?  $pdf_size2  :  $pdf_size*2 ;   
                   	$valor= "<img style='border: 10px solid white;' src=\"{$valor}_large.jpg\"       alt='imagen no encontrada' "
                        . " onmouseover='this.style.borderImageWidth=\"20px 30px\";this.width=\"$pdf_size2\";' onmouseout='this.style.borderImageWidth=20 ;this.width=\"$pdf_size\";' width='$pdf_size'  >" ;
                        }
                        $format_style=" style='text-align:center;' " ;        
                        break;
            case "pdfDdownload":
                
                        if ($valor) $valor ="<a class='btn btn-link noprint' href=\"$valor\" target='_blank' title='descargar PDF'><i class='fas fa-cloud-download-alt'></i></a>" ;
                        $format_style=" style='text-align:center;' " ;    
                        
                        break;
                        
            case "conciliacion":
                        $format_style=$valor==1 ? " style='background-color: green; text-align:center;' "  : " style='background-color: red; text-align:center;' "  ;   
                        $valor = $valor==1 ? '<i class="fas fa-arrows-alt-h"></i>' : '<i class="fas fa-expand-arrows-alt"></i>' ;

                        break;
            case "semaforo":
//                        $format_style = $valor ? " style='background-color: green; text-align:center;' "  : " style='background-color: red; text-align:center;' "  ;   
//                        $valor = $valor ? '<i class="fas fa-check"></i>' : '' ;

                        break;
           case "semaforo_OK":
                        $format_style = $valor ? " style='background-color: green; text-align:center;' "  : " style='background-color: red; text-align:center;' "  ;   
                        $valor = $valor ? '<i class="fas fa-check"></i>' : '<i class="far fa-window-close"></i>' ;

                        break;
           case "semaforo_not_OK":
                        $format_style = $valor ? " style='background-color: red; text-align:center;' "  : " style='background-color: green; text-align:center;' "  ;   
                        $valor = $valor ? '<i class="fas fa-check"></i>' : '<i class="far fa-window-close"></i>' ;

                        break;
            case "semaforo_not":        // semaforo Rojo/verde (invertido)  al poner el color del font igual que el fondo , el texto desaparece
//                        $format_style = (!$valor) ? " style='background-color: green; text-align:center; color:green;' "  : " style='background-color: red; text-align:center; color:red;' "  ;   
//                        $valor = (!$valor) ? '<i class="fas fa-check"></i>' : '' ;

                        break;
            case "semaforo_txt":   // ej:  CARGADA   o   NO CARGADA
                        $format_style = $valor ? " style='color: green; font-weight: bold;' "  : " style='color: red; font-weight: bold;' "  ;   
                        $valor = $valor ? $txt : 'NO '.$txt ;

                        break;
            case "semaforo_txt2":        // igual que el anterior pero el negativo es vacío, ej: SUBCONTRATADA
                        $format_style = $valor ? " style='color: green; font-weight: bold;' "  : " style='color: red; font-weight: bold;' "  ;   
                        $valor = $valor ? $txt : '';

                        break;
            case "array_pre":
//                        $format_style = $valor ? " style='color: green; font-weight: bold;' "  : " style='color: red; font-weight: bold;' "  ;   
                        $valor = "<pre>". print_r( $valor, true ) . "</pre>" ;

                        break;
            case "vacio":
//        						$format_style=$valor==1 ? " style='background-color: green; text-align:center;' "  : " style='background-color: red; text-align:center;' "  ;   
                        $valor = "" ;

                        break;

       } 

   return $valor;                                       
 }



function quita_simbolos($string){
 
    $string =  quita_simbolos_no_matematicos($string) ;
     //simbolos matematicos
    $string = str_replace(
        array( "-", "/","*", "(", ")", "+",  ">", "< ",".", "%"),
        '',
        $string
    );
return $string;
}
function quita_simbolos_no_matematicos($string){
 
    $string = trim($string);
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
     
    // simbolos no matematicos
    $string = str_replace(
        array("\\", "¨", "º",  "~",
             "#", "@", "|", "!", "\"",
             "·", "€","$", "&",
              "?", "'", "¡",
             "¿", "[", "<code>", "]",
              "}", "{", "¨", "´",
              ";", ",", ":", " "),
        '',
        $string
    );
//    //simbolos matematicos
//    $string = str_replace(
//        array( "-", "/","*", "(", ")", "+",  ">", "< ","."),
//        '',
//        $string
//    );
return $string;
}

function quita_tildes($string){
 
//    $string = trim($string);
    
    // sustituimos las tildes
     $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );

    
    
return $string;
}


function quita_simbolos_file($string){
 
    $string = trim($string);
    
    // sustituimos los simbolos por '_'
    $string = quita_tildes( $string  );
    
    
   // sustituimos los simbolos por '_'
    $string = str_replace(
        array( "¨", "º", "-", "~",
             "#", "@", "|", "!", 
             "·", "$", "%", "&", 
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "<code>", "]",
             "+", "}", "{", "¨", "´",
             ">", "<", ";", ",", ":", " "),
        '_',
        $string
    );
    
 
    
return $string;
}

function quita_simbolos_mysql($string){
 
    $string = trim($string);
 
//    $string = str_replace(  "," , '\,',  $string   );
    $string = str_replace(  ";" , '\;',  $string   );
    $string = str_replace(  '"' , "\"",  $string   );
    $string = str_replace(  "'" , "\'",  $string   );
//    $string = str_replace(  "º" , "\º",  $string   );
    
return $string;
}


function dbNumero($cifra)
{
    
  $cifra=str_replace("€","",$cifra);
  $cifra=str_replace($_SESSION["Moneda_simbolo"],"",$cifra);
  $cifra= "000".trim($cifra) ;
  $cifra_final= substr($cifra,-3,3);  //sacamos las últimas tres character
  $cifra_inicial= substr($cifra,0,strlen($cifra)-3);  
  echo $cifra_inicial ;
  echo $cifra_final ;
  
  
  $cifra_final=str_replace(",",".",$cifra_final);
  $cifra_inicial=str_replace(",","",$cifra_inicial);
  $cifra_inicial=str_replace(".","",$cifra_inicial); 
            
  $return=$cifra_inicial.$cifra_final        ;
   return $return;     
    
}
function dbNumero2($nuevo_valor)
{
       $nuevo_valor = preg_replace("/€|$| |'/", "", $nuevo_valor);         // quitamos simbolos moneda 

       $nuevo_valor= str_replace(',', '.', $nuevo_valor) ;
       $count=substr_count ($nuevo_valor,'.') ;
       $nuevo_valor = preg_replace("/\./", "", $nuevo_valor , $count-1);     

   return $nuevo_valor;     
    
}

function dbDate($nuevo_valor)
{
  $nuevo_valor = preg_replace("~(\d{1,2})\s?[- /.]\s?(\d{1,2})\s?[- /.]\s?(\d{4})~" 
                         ,"$3-$2-$1"   
                         ,$nuevo_valor);
   return $nuevo_valor;     
    
}




function issetVar($variable)
{    // Sintax:  devolvemos 1 si existe la variable en esta empresa y 0 si no existe
    
    if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    } 
    
     $return=Dfirst( 1 , "c_coste_vars", "variable='$variable' AND {$GLOBALS["where_c_coste"]} " )  ;
           
     

    if ($nueva_conn)
    {
      //  $Conn->close();     // cierro Conn si lo he abierto aquí
    }
    return $return;     
}

function getVar2($variable)
{    // Sintax:  devolvemos el valor de una variable de entorno `vars`y si no existe devuelvo 0
    
    $return=Dfirst( "valor" , "c_coste_vars", "variable='$variable' AND {$GLOBALS["where_c_coste"]} " )  ;
}


function getVar($variable, $msg_error=1)
{    // Sintax:  devolvemos el valor de una variable de entorno `vars`y si no existe devuelvo 0
    
    if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }
    
//     $sql = "Select `valor` FROM `c_coste_vars` WHERE variable='$variable' AND {$GLOBALS["where_c_coste"]} ";
     $sql = "Select `valor` FROM `c_coste_vars` WHERE variable='$variable' AND id_c_coste={$_SESSION["id_c_coste"]} ";
    
//    echo $sql ;                            //debug  
    $result = $Conn->query($sql);
    if ($result->num_rows > 0)
    {
        $rs = $result->fetch_array();   // cogemos el primer valor
        $return = $rs["valor"];
    } else
    {
//        echo "RETURN DEL SELECT:" . $result->num_rows ;
        echo $msg_error? "<script>var error='ERROR EN GETVAR: $variable Avise a ADMINISTRADOR'; alert(error); console.log(error);</script>" 
                :"<script>var error='ERROR EN GETVAR: $variable Avise a ADMINISTRADOR'; console.log(error);</script>";
        $return = 0;           // devuelvo 0 si no encuentro nada
    }
    
    // if ($return=Dfirst("valor", "c_coste_vars", "variable='$variable' AND {$GLOBALS["where_c_coste"]} " ) )
       

    if ($nueva_conn)
    {
      //  $Conn->close();     // cierro Conn si lo he abierto aquí
    }
    return $return;     // devolvemos los resultados bien de UPDATE... , bien de INSERT INTO...
}


function setVar($variable, $valor)
{    // Sintax:  actualizamos el valor de una variable de entorno `vars`y si no existe la variable la creamos
    
    if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }
    
    //$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;
    // compruebo si la variable de entorno existe en esta empresa
     if ($id_variable=Dfirst("id_variable", "c_coste_vars", "variable='$variable' AND {$GLOBALS["where_c_coste"]} " ) )
       {  // existe la variable. Cambiamos su valor 
           $sql2 = "UPDATE `c_coste_vars` SET valor='$valor'  WHERE id_variable=$id_variable AND {$GLOBALS["where_c_coste"]} " ;
           $return = ($Conn->query($sql2)) ;      // ejecutamos el sql y devolvemos la respuesta
           
       }
       else   // no existe, hay que crearla y registrar su valor
       {
           $sql2 = "INSERT INTO `c_coste_vars` (id_c_coste,variable,valor) VALUES ( {$_SESSION['id_c_coste']}, '$variable' , '$valor' ) " ;
           $return = ($Conn->query($sql2)) ;  
       }
           
     

    if ($nueva_conn)
    {
      //  $Conn->close();     // cierro Conn si lo he abierto aquí
    }
    return $return;     // devolvemos los resultados bien de UPDATE... , bien de INSERT INTO...
}

function clave_mail()
{
    return $_SESSION["clave_mail"];
} 

function DInsert_into($tabla, $campos, $valores, $id_xxx = "", $where_xxx="", $logs=1)
{    // Sintax: "INSERT INTO $tabla  $campos VALUES $valores "
    //         $id_xxx = "ID_OBRA (p.ej.)  indica que retornemos el ID_OBRA creado
    //         $where_xxx : condición para buscar el $id_xxx  
    // ejemplo: if (DInsert_into("Capitulos", "('ID_OBRA','CAPITULO' )" , "($id_obra,'$capitulo' )"))
    
    if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }

    
    $sql2 = "INSERT INTO $tabla  $campos VALUES $valores " ;
    if ($logs)
    {   
      logs( " DInsert_into: $sql2") ;
//      logs_db( " DInsert_into: $sql2") ;
    }  

//    if ($id_xxx<>"") {$id_xxx_valor_actual=Dfirst("MAX($id_xxx)", $tabla, $where_xxx);}  // cojo el máximo id_xxx antes de la inserción para comprobar que hay uno nuevo diferente
    
    if ($Conn->query($sql2))
    {   
            
        $return=$Conn->insert_id ;
        // ANULADO ANTIGUO SISTEMA DE CONOCER EL ID_NUEVO, ahora usamos el $Conn->insert_id
//        $id_auto=$Conn->insert_id ;
//        if ($id_xxx<>"")           // requiere calcular el id generado para retornarlo
//        {
//         $id_xxx_valor_nuevo= Dfirst("MAX($id_xxx)", $tabla, $where_xxx); // retorno el nuevo valor de id_xxx   
//           logs( " DInsert_INTO -> COINCIDEN EL insert_id ?: ".( ($id_auto==$id_xxx_valor_nuevo) ? "SI CONCIDEN" : "NO COINCIDEN" ));
////         $id_xxx_valor_nuevo= $Conn->query("SELECT MAX($id_xxx) FROM $tabla  WHERE $where_xxx ")[0]; // retorno el nuevo valor de id_xxx   
//         $return = ($id_xxx_valor_actual<>$id_xxx_valor_nuevo) ?  $id_xxx_valor_nuevo : 0 ;   // si no ha cambiado la inserción es de ERROR
//        }
//        else
//        {
//         $return = 1 ;   // retorno true, insercion correcta sin retorno
//        }
        //echo " <br>exito en insercion: id $return sql: $sql2" ;  // debud 
    } else
    {
       // echo "<br> error en insercion: $sql2" ;  // debud
        $return = 0;   // retorno error (false)
    }

    if ($nueva_conn)
    {
      //  $Conn->close();     // cierro Conn si lo he abierto aquí
    }
    return $return;
}



// Devuelve un string con los <options> para un <select>
function DOptions($fields, $table, $where = 1, $order_by = 0)
{
    $options=DArray($fields, $table, $where , $order_by ) ;
    
    $return="" ;
    foreach ($options as  $valor) 
    { 
            $return.= "<option value='$valor[0]]'>$valor[1]</option>" ;
    }
    
    return $return;
}



// Devuelve una consulta como array multidimensional utilizo fetch_array_all
function DOptions_sql($sql,$msg_selecciona='Seleccionar...' , $msg_vacio='sin resultados', $defecto='')
{
    if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }

    /* @var $order_by type */
    //$order_by = $order_by ? "ORDER BY $order_by" : "";  //  configuro $order_by
    //$sql2 = "Select $fields FROM $table WHERE $where $order_by";
    $result2 = $Conn->query($sql);
    if ($result2->num_rows > 0)
    {
        // añadimos primer OPTION, si es vacia, no ponemos nada, si es OPTION lo incorporamos directamente, si es un texto lo añadimos, por defecto 'seleccionar...'
        $return = (substr(strtoupper($msg_selecciona), 0, 7)=='<OPTION' OR $msg_selecciona=='' ) ? $msg_selecciona : "<option value='0'>$msg_selecciona</option>" ;  // Primer OPTION. añadimos los option si no los trae

        while( $rs = $result2->fetch_array(MYSQLI_NUM))
         {
           $selected=  ($defecto==$rs[0])? "selected" : "" ;
           $return.= "<option value='{$rs[0]}' $selected>{$rs[1]}</option>" ;             
         }      

    } else
    {
//        $return = [[0,$msg_vacio]] ;
        $return = "<option value='0'>$msg_vacio</option>" ;       
    }

    if ($nueva_conn)
    {
      //  $Conn->close();     // cierro Conn si lo he abierto aquí
    }
    return $return;
}



// Devuelve una consulta como array multidimensional utilizo fetch_array_all
function row_sql($sql)
{
    if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }

//    $order_by = $order_by ? "ORDER BY $order_by" : "";  //  configuro $order_by
//    $sql2 = "Select $fields FROM $table WHERE $where $order_by";
    $result2 = $Conn->query($sql);
    $return = $result2->fetch_array();
    
//    if ($result2->num_rows > 0)
//    {
//        $return = $result2->fetch_all(MYSQLI_NUM );
//    } else
//    {
//        $return = 0;
//    }

    if ($nueva_conn)
    {
      //  $Conn->close();     // cierro Conn si lo he abierto aquí
    }
    return $return;
} 

// Devuelve una consulta como array multidimensional utilizo fetch_array_all
function DArray($fields, $table, $where = 1, $order_by = 0)
{
    logs("Inicio DARRAY()") ;
    if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }

    /* @var $order_by type */
    $order_by = $order_by ? "ORDER BY $order_by" : "";  //  configuro $order_by
    $sql2 = "Select $fields FROM $table WHERE $where $order_by";
    $result2 = $Conn->query($sql2);
        logs("sql $sql2") ;

    if ($result2->num_rows > 0)
    {
         logs("return DARRAY()") ;
        $return = $result2->fetch_all(MYSQLI_NUM );
    } else
    {
//        $return = 0;    // anulado para devolver array vacío, juand, abril, 2020
        $return = [];   // no hay resultados -> array vacío
    }

    if ($nueva_conn)
    {
      //  $Conn->close();     // cierro Conn si lo he abierto aquí
    }
    return $return;
} 


function Dfirst($field, $select, $where = 1, $order_by = 0)
{        // devuelvo valor o 0 si no encuentro nada
    if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
//        logs( " Dfirst nueva_conn: true") ; 

    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
//        logs( " Dfirst nueva_conn: false") ;

    }

//     logs( " Dfirst nueva_conn: $nueva_conn") ;
    
    $order_by = $order_by ? "ORDER BY $order_by" : "";  //  configuro $order_by 
    $sql2 = "SELECT $field FROM $select WHERE $where  $order_by  LIMIT 1 ;";
    logs( " Dfirst: $sql2") ;
//    logs_db( " Dfirst: $sql2") ;
//    echo "<br><br><br>$sql2" ;
    $result2 = $Conn->query($sql2);  
    
    if (isset($result2->num_rows))
    {
        if ($result2->num_rows > 0)
        {
            $rs2 = $result2->fetch_array();   // cogemos el primer valor
            $return = $rs2[0];                 // devolvemos el primer campo
            logs( " Resultado Dfirst: correcto, esultado:  $return") ;

        } else
        {
            $return = 0;           // devuelvo 0 si no encuentro nada
            logs( " Resultado Dfirst: sin resultados (return=0)") ; 

        }
    }else 
    {
        
            logs( " Resultado Dfirst: ERROR EN CONSULTA: $sql2") ;
            $return=0;
        
    }   



    return $return;
}

function DRow( $table, $where = 1, $order_by = 0)
{        // devuelvo valor o 0 si no encuentro nada
    if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }

    
    
    $order_by = $order_by ? "ORDER BY $order_by" : "";  //  configuro $order_by
    $sql2 = "SELECT * FROM $table WHERE $where  $order_by  LIMIT 1 ;";
    logs( " DRow: $sql2") ;
//    logs_db( " Dfirst: $sql2") ;
//    echo "<br><br><br>$sql2" ;
    $result2 = $Conn->query($sql2); 
    if ($result2->num_rows > 0)
    {
        $return = $result2->fetch_array();   // cogemos el primer valor   // devolvemos todo el ROW
            logs( " Resultado DRow: CORRECTO") ;

    } else
    {
//        echo "<br>VALOR NO ENCONTRADO" ;                            //debug    
        $return = 0;           // devuelvo 0 si no encuentro nada
            logs( " Resultado DRow: ERROR") ;

    }

//    if ($nueva_conn)
//    {
//      //  $Conn->close();     // cierro Conn si lo he abierto aquí
//    }

    return $return;
}



// Devuelve un string con los <options> para un <select>
function factura_proveedor_anadir($id_documento=0, $id_proveedor=0)
{
    // determinamos si además de crear la nueva factura hay que linkarle un documento
//$id_documento=isset($_GET["id_documento"]) ? $_GET["id_documento"] : 0 ;  ;
  if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }
    
    
$id_proveedor= ($id_proveedor==0) ?  getVar('id_proveedor_auto'): $id_proveedor ;

$fecha=date('Y-m-d');

//$sql="INSERT INTO `FACTURAS_PROV` ( `ID_PROVEEDORES`,N_FRA,FECHA,IMPORTE_IVA,`user` )    VALUES (  '$id_proveedor','', '$fecha' ,'0', '{$_SESSION["user"]}' );" ;
$sql="INSERT INTO `FACTURAS_PROV` ( `ID_PROVEEDORES`,`N_FRA`,`FECHA`,`user` )    VALUES (  '$id_proveedor', 'n_fra', '$fecha', '{$_SESSION["user"]}' );" ;
// echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado la FACTURA
             { 
               $id_fra_prov=Dfirst( "MAX(ID_FRA_PROV)", "Fras_Prov_Listado", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
                $return=$id_fra_prov ;
	        // TODO OK-> Entramos a pagina_inicio.php
//	       echo "factura proveedor creada satisfactoriamente." ;
//		echo  "Ir a factura proveedor <a href=\"../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov\" title='ver fra_prov'> $id_fra_prov</a>" ;
              if( $id_documento)    // actualizo el valor del id_entidad con la nueva factura creada
              {
                $sql="UPDATE `Documentos` SET  id_entidad=$id_fra_prov    "
                      ." WHERE id_c_coste={$_SESSION["id_c_coste"]} AND id_documento=$id_documento; " ;
//               echo ($sql);
  
         	if (!$result=$Conn->query($sql))
                {
                    $_SESSION["error"]="ERROR: $sql"  ;
                    $return=0 ;  
                }    
  
              }  
            
             
//                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov'>" ;

	     }
	       else
	     {
//		echo "Error al crear factua prov, inténtelo de nuevo " ;
//		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
                 $return=0 ;    
                   
	     }
       
    return $return;
}


function vale_albaran_anadir($id_documento,$id_obra)
{
    // determinamos si además de crear la nueva factura hay que linkarle un documento
//$id_documento=isset($_GET["id_documento"]) ? $_GET["id_documento"] : 0 ;  ;
  if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
        $nueva_conn = false;
    }
    
    
$id_proveedor= getVar('id_proveedor_auto');
$fecha=date('Y-m-d');

$sql="INSERT INTO `VALES` ( `ID_PROVEEDORES`,ID_OBRA,REF,FECHA,`user` )    VALUES (  '$id_proveedor','$id_obra','auto', '$fecha' , '{$_SESSION["user"]}' );" ;
// echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado la obra
             { 	$id_vale=Dfirst( "MAX(ID_VALE)", "Vales_list", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	        // TODO OK-> Entramos a pagina_inicio.php
//	       echo "factura proveedor creada satisfactoriamente." ;
//		echo  "Ir a factura proveedor <a href=\"../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov\" title='ver fra_prov'> $id_fra_prov</a>" ;
              if( $id_documento)    // actualizo el valor del id_entidad con la nueva factura creada
              {
                $sql="UPDATE `Documentos` SET  id_entidad=$id_vale    "
                      ." WHERE id_c_coste={$_SESSION["id_c_coste"]} AND id_documento=$id_documento; " ;
//               echo ($sql);
  
         	if ($result=$Conn->query($sql))
                {
                     $return=$id_vale ;
                } else {
                    $_SESSION["error"]="ERROR: $sql"  ;
                    $return=0 ;  
                }    
  
              }  
            
             
//                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov'>" ;

	     }
	       else
	     {
//		echo "Error al crear factua prov, inténtelo de nuevo " ;
//		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
                 $return=0 ;    
                   
	     }
       
    return $return;
}





?>