<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;
?>

<HTML>
<HEAD>
     <title>Usuario</title>

	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</HEAD>
<BODY>



<?php 



 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 require_once("../menu/topbar.php");
// require("../menu/topbar.php");

//echo '<br>' ;echo '<br>' ;echo '<br>' ;echo '<br>' ;echo '<br>' ;
// echo isset($_GET["id_usuario"]); 
// echo '<br>' ;
//echo $_SESSION["admin"] ;
//echo '<br>' ;
//echo $_SESSION["id_usuario"] ;
//echo '<br>' ;

 
  $id_usuario_get =isset($_GET["id_usuario"]) ? $_GET["id_usuario"]  : $_SESSION["id_usuario"] ;

  $cambio_password=1;
  $href_get='';
 
 if ( $_SESSION["admin"]  )  // admin puee ver TODO de cualquier usuario
 {
     $id_usuario = $id_usuario_get ;
     // el administrador ver el perfil completo de cualquier usuario
     $sql=  "SELECT * FROM Usuarios  WHERE id_usuario=$id_usuario " ; // AND $where_c_coste" 
     
     $href_get="?id_usuario=$id_usuario";
     

 }    
 elseif($_SESSION["autorizado"]  )
 {  
       $id_empresa_get = Dfirst('id_c_coste','Usuarios' , " id_usuario=$id_usuario_get " ) ;
       $id_empresa_autorizado = Dfirst('id_c_coste','Usuarios' , " id_usuario={$_SESSION["id_usuario"]} " ) ;
       
       if ($id_empresa_get == $id_empresa_autorizado )
       {
            $id_usuario = $id_usuario_get ;   // es autorizado de su misma empresa
            // el autorizado ve el perfil restringido de un usuario de su empresa y puede cambiar sus PERMISOS
            $sql=   "SELECT  id_usuario,usuario,email,nombre_completo,autorizado,activo,permiso_licitacion,permiso_obras,permiso_administracion,permiso_bancos, fecha_creacion FROM Usuarios  WHERE id_usuario=$id_usuario AND $where_c_coste" ;  // autorizando viendo perfil de administrado            
             $href_get="?id_usuario=$id_usuario";
//            $cambio_password=0;  // anulado, el autorizado puede cambiar el password de sus usuarios
       }
       else
       {
           // el autorizado ve su propio perfil
           $id_usuario =  $_SESSION["id_usuario"] ;
            $sql="SELECT  id_usuario,usuario,email,nombre_completo,fecha_creacion FROM Usuarios  WHERE id_usuario=$id_usuario AND $where_c_coste" ;
       }    
 }       
 else     
 {
        // el usuario ve su perfil    
        $id_usuario =  $_SESSION["id_usuario"] ;
        $sql="SELECT  id_usuario,usuario,email,nombre_completo,fecha_creacion FROM Usuarios  WHERE id_usuario=$id_usuario AND $where_c_coste" ;
 }    
 
 
 
 
// echo $sql ;
 
 $result=$Conn->query($sql);
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;

 $id_usuario=$rs["id_usuario"] ;    // comprobamos hay un concepto con ese ID, en caso contrario habrá un error
 
  $titulo="USUARIO" ;
  
//  $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS"] ;   // datos para clave foránea
//  $selects["ID_CUENTA"]=["ID_CUENTA","CUENTA_TEXTO","CUENTAS"] ;   // datos para clave foránea
//  $selects["ID_PROVEEDOR"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores","../proveedores/proveedores_anadir.php"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
//  $links["ID_OBRA"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDOR"] ;

  
//  $updates=['NOMBRE','DNI','F_ALTA','BAJA', 'F_BAJA' , 'Observaciones', 'pagada']  ;
  
  $updates=['*']  ;
  $no_updates=  $_SESSION["admin"] ? ['password_hash']:['password_hash','email'] ; // solo admin puede cambiar email
  $tabla_update="Usuarios" ;
  $id_update="id_usuario" ;
  $id_valor=$id_usuario ;
  
  $formats["password_hash"]='textarea_30' ;
  $formats["admin"]='boolean' ;
  $formats["autorizado"]='boolean' ;
  $formats["activo"]='semaforo' ;
  $tootips["activo"]='Si se desactiva al usuario éste no podrá acceder al sistema' ;
  
  $delete_boton=1;

  ?>
  
                  
                    
<div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?php 
  
//     echo "<a class='btn btn-primary' href='../personal/parte_pdf.php?id_parte=$id_parte' >imprimir PDF</a>" ;

  
  require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
  </div>
      
    <div class="right2">
      <?php     
        echo  $cambio_password ? "<br><a class='btn btn-primary noprint' href='../registro/cambiar_password.php{$href_get}' target='_blank' >"
                         . " Cambiar password</a>" : ""; // BOTON CAMBIO PASSWORD
        echo   "<br><a class='btn btn-primary noprint' href='../registro/generar_link_autologin.php' target='_blank' >"
                         . " Generar link autologin</a>" 

       ?>  
    </div>
	
	<!--  DOCUMENTOS  -->
	
  <div class="right2">
	
  <?php 

  $tipo_entidad='usuario' ;
  $id_entidad=$id_usuario;
  $id_subdir=1 ;

  require("../include/widget_documentos.php");

 
 ?>
	 
  </div>
	
	
<?php            // ----- div PARTES PERSONAL  tabla.php   -----<!--  DETALLE DEL PARTE -->

////$sql="SELECT id,ID_PERSONAL,NOMBRE,DNI,HO,HX,MD,DC,Observaciones FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
//$sql="SELECT id,ID_VALE,REF,FECHA,ID_OBRA,NOMBRE_OBRA,CANTIDAD,COSTE,IMPORTE,ID_FRA_PROV ,facturado, Observaciones  FROM ConsultaGastos_View  WHERE ID_CONCEPTO=$id_concepto  AND $where_c_coste    ";
////echo $sql;
//$result=$Conn->query($sql );
//
////$sql="SELECT 'Suma' ,COUNT(ID_PERSONAL) as B,SUM(HO) as HO,SUM(HX) as HX,SUM(MD) as MD,SUM(DC) as DC FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
//
//$sql="SELECT 'Suma',' ','' as b1,SUM(CANTIDAD) as cantidad,COSTE,SUM(IMPORTE) as importe,'' as b2 FROM ConsultaGastos_View  WHERE ID_CONCEPTO=$id_concepto  AND $where_c_coste    ";
////$sql="SELECT 'Suma' ,COUNT(ID_PERSONAL) as B,SUM(HO) as HO, '','  ' FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
////echo $sql;
//$result_T=$Conn->query($sql );
//
//$updates=[ 'Observaciones']  ;
//$tabla_update="GASTOS_T" ;
//$id_update="id" ;
//
//$actions_row=[];
//$actions_row["id"]="id";
////$actions_row["update_link"]="../include/update_row.php?tabla=Fra_Cli_Detalles&where=id=";
////$actions_row["delete_link"]="../include/delete_row.php?tabla=PARTES_PERSONAL&where=id=";
//$actions_row["delete_link"]="1";
//
//
//$links["NOMBRE_OBRA"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//$links["PROVEEDOR"] = ["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
//$links["CONCEPTO"] = ["../proveedores/concepto_ficha.php?id_concepto=", "ID_CONCEPTO"]  ;
//$links["REF"] = ["../proveedores/albaran_proveedor.php?id_vale=", "ID_VALE"] ;
//$links["facturado"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura" ,"formato_sub"] ;
//
//
//
//
////$id_clave="id" ;
//
//$formats["facturado"]='boolean_factura';
////$formats["importe"]='moneda';
////
//$links["NOMBRE"] = ["../personal/personal_ficha.php?id_personal=", "ID_PERSONAL"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//
//$aligns["importe"] = "right" ;
//$aligns["Pdte_conciliar"] = "right" ;
////$aligns["Importe_ejecutado"] = "right" ;

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
//$titulo="" ;
//$msg_tabla_vacia="No hay vales";

?>

        <!--<div id="main" class="mainc">-->
<div  style="background-color:Khaki;float:left;width:60%;padding:0 20px;" >


 <div class="container">
  <!--<h2>Vales donde aparece el Concepto</h2>-->

</div>

     
<?php 
//require("../include/tabla.php"); echo $TABLE ; 
?>
 
    <br><br><br>
</div>    
    <!--//////   MAQUINARIA PROPIA  ///////-->
    
 


	
<?php  

$Conn->close();

?>
	 


	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:12px;">FOOTER</div>


               
        
        
        
        
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

