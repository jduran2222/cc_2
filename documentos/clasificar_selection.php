<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 
		
$tipo_entidad=$_GET["tipo_entidad"]   ;
$array_str=$_GET["array_str"]   ;
$id_obra=$_GET["id_obra"]   ;

$array_id_documentos = explode("-", $array_str);


$fecha=date('Y-m-d');

     echo "TIPO DE ENTIDAD: $tipo_entidad"    ;


switch($tipo_entidad) {
     case "fra_prov": 
     echo "<br>INICIO pdte de clasificar fra_prov"    ;
     
       foreach ($array_id_documentos as $id_documento)    
       {
          echo "<br>pdte de clasificar fra_prov: $id_documento"    ;
          if (factura_proveedor_anadir($id_documento))
          { echo "<br>FACTURA AÑADIDA CORRECTAMENTE" ; }
          else
          { echo "<br>ERROR AL  AÑADIR FACTURA" ; }    
  
       }
     
         
//     echo "<script> window.location='../proveedores/factura_proveedor_anadir.php?id_documento=$id_entidad'; </script>";
     break;
     case "albaran": 
     echo "<br>INICIO pdte de clasificar albaran"    ;
     
       foreach ($array_id_documentos as $id_documento)    
       {
          echo "<br>pdte de clasificar albaran: $id_documento"    ;
          if (vale_albaran_anadir($id_documento,$id_obra))
          { echo "<br>albaran AÑADIDA CORRECTAMENTE" ; }
          else
          { echo "<br>ERROR AL  AÑADIR albaran :".$_SESSION["error"] ; }    
  
       }
     break;
     case "obra_foto": 
     echo "<br>INICIO pdte de clasificar obra_foto"    ;
     
       foreach ($array_id_documentos as $id_documento)    
       {
           $sql="UPDATE `Documentos` SET `tipo_entidad` = 'obra_foto',  `id_entidad` = '$id_obra'  " 
               ."WHERE $where_c_coste AND  id_documento=$id_documento; " ;
          

//          echo "<br>pdte de clasificar obra_foto: $id_documento"    ;
          if ( $result=$Conn->query($sql))
          { echo "<br>FOTO CLASIFICADA CORRECTAMENTE" ; }
          else
          { echo "<br>ERROR AL CLASIFICAR FOTO : $sql <br>ERROR MSG: ".$_SESSION["error"] ; }    
  
       }
     
         
//     echo "<script> window.location='../proveedores/factura_proveedor_anadir.php?id_documento=$id_entidad'; </script>";
     break;
                       case "partes": 
                            echo "<script> window.location='../personal/parte.php?id_parte=$id_entidad'; </script>";
                            break;
                        case "personal": 
                            echo "<script> window.location='../personal/personal_ficha.php?id_personal=$id_entidad'; </script>";
                            break;
                        case "pof_prov": 
                            echo "<script> window.location='../pof/pof_proveedor_ficha.php?id=$id_entidad'; </script>";
                            break;
                        case "proveedores": 
                            echo "<script> window.location='../proveedores/proveedores_ficha.php?id_proveedor=$id_entidad'; </script>";
                            break;
                        case "fra_cli": 
                            echo "<script> window.location='../clientes/factura_cliente.php?id_fra=$id_entidad'; </script>";
                            break;
                        case "albaran": 
                            echo "<script> window.location='../proveedores/albaran_proveedor.php?id_vale=$id_entidad'; </script>";
                            break;
                        
                        
                      
                           default:
                                echo "ENTIDAD SIN LINK ASOCIADO"  ;
                                break;
     }
  
       

?>