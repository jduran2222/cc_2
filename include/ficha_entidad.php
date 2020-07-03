<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;


$tipo_entidad=$_GET["tipo_entidad"];                 // TABLA DONDE COGER EL REGISTRO-FICHA
$id_entidad=$_GET["id_entidad"];        // campo index primary (clave) a utilizar en la búsqueda

////$id_valor=$_GET["id_valor"];          // valor de la clave a buscar
//
////
////$where= "`$id_update`=$id_valor" ;                // creo el where para la búsqueda del registro `ID_OBRA`=464
//
// require_once("../../conexion.php");
 require_once("../include/funciones.php");
//// require("../menu/topbar.php");
// //require("../proveedores/proveedores_menutop_r.php");
// 
// 
////$result=$Conn->query("SELECT * FROM $tabla WHERE $where AND $where_c_coste");

$entidad_link = entidad_link($tipo_entidad) ;
echo ($entidad_link) ? "<script> window.location='{$entidad_link}{$id_entidad}'; </script>" : "ENTIDAD SIN LINK ASOCIADO" ;

//switch($tipo_entidad) {
//                        // Return just one part
//                        case "procedimiento": 
//                            echo "<script> window.location='../agenda/procedimiento_ficha.php?id_procedimiento=$id_entidad'; </script>";
//                            break;
//                        case "aval": 
//                            echo "<script> window.location='../bancos/aval_ficha.php?id_aval=$id_entidad'; </script>";
//                            break;
//                        case "doc_nuevo": 
//                            echo "<script> window.location='../documentos/documento_ficha.php?id_documento=$id_entidad'; </script>";
//                            break;
//                        case "empresa": 
//                            echo "<script> window.location='../configuracion/empresa_ficha.php'; </script>";
//                            break;
//                        case "estudios": 
//                            echo "<script> window.location='../estudios/estudios_ficha.php?id_estudio=$id_entidad'; </script>";
//                            break;
//                        case "fra_cli": 
//                            echo "<script> window.location='../clientes/factura_cliente.php?id_fra=$id_entidad'; </script>";
//                            break;
//                        case "fra_prov": 
//                            echo "<script> window.location='../proveedores/factura_proveedor.php?id_fra_prov=$id_entidad'; </script>";
//                            break;
//                        case "l_avales": 
//                            echo "<script> window.location='../bancos/l_avales_ficha.php?id_linea_avales=$id_entidad'; </script>";
//                            break;
//                        case "obra_doc": 
//                            echo "<script> window.location='../obras/obras_ficha.php?id_obra=$id_entidad'; </script>";
//                            break;
//                        case "obra_nueva": 
//                            echo "<script> window.location='../obras/obras_ficha.php?id_obra=$id_entidad'; </script>";
//                            break;
//                        case "obra_foto": 
//                            echo "<script> window.location='../obras/obras_fotos.php?id_obra=$id_entidad'; </script>";
//                            break;
//                        case "parte": 
//                            echo "<script> window.location='../personal/parte.php?id_parte=$id_entidad'; </script>";
//                            break;
//                        case "personal": 
//                            echo "<script> window.location='../personal/personal_ficha.php?id_personal=$id_entidad'; </script>";
//                            break;
//                        case "pof_prov": 
//                            echo "<script> window.location='../pof/pof_proveedor_ficha.php?id=$id_entidad'; </script>";
//                            break;
//                        case "pof": 
//                            echo "<script> window.location='../pof/pof.php?id_pof=$id_entidad'; </script>";
//                            break;
//                        case "proveedores": 
//                            echo "<script> window.location='../proveedores/proveedores_ficha.php?id_proveedor=$id_entidad'; </script>";
//                            break;
//                        case "albaran": 
//                            echo "<script> window.location='../proveedores/albaran_proveedor.php?id_vale=$id_entidad'; </script>";
//                            break;
//                        case "rel_valorada": 
//                            echo "<script> window.location='../obras/obras_prod_detalle.php?id_produccion=$id_entidad'; </script>";
//                            break;
//                        case "rel_valorada_nueva": 
//                            echo "<script> window.location='../obras/obras_prod_detalle.php?id_produccion=$id_entidad'; </script>";
//                            break;
//                        
//                        
//                      
//                           default:
//                                echo "ENTIDAD SIN LINK ASOCIADO"  ;
//                                break;
//                }
//  
//  
//  

?>
	 
