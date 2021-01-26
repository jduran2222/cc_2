<?php
require_once("../include/session.php");


//$proveedor =  isset($_GET["proveedor"]) ?  $_GET["proveedor"] : (isset($_POST["proveedor"]) ?  $_POST["proveedor"] : 'proveedor nuevo'  ) ;
//$cif =  isset($_GET["cif"]) ?  $_GET["cif"] : (isset($_POST["cif"]) ?  $_POST["cif"] : 'B99999999'  ) ;
//
//$id_fra_prov =  isset($_GET["id_fra_prov"]) ?  $_GET["id_fra_prov"] : "" ;  // variables que harán actualizar campos de otras tablas
//$id_personal =  isset($_GET["id_personal"]) ?  $_GET["id_personal"] : "" ;

$id_pof_proveedor =  $_GET["id_pof_proveedor"] ;



// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 
require_once("../include/funciones_js.php"); 

$result_POF_prov=$Conn->query("SELECT * FROM POF_prov_View WHERE id=$id_pof_proveedor AND $where_c_coste ");
$rs_POF_prov = $result_POF_prov->fetch_array(MYSQLI_ASSOC) ;




$id_pof = $rs_POF_prov["ID_POF"];   // por seguridad
$id_pof_oferta=$rs_POF_prov["id"] ;
$num_prov=$rs_POF_prov["NUM"] ;
$id_proveedor=$rs_POF_prov["id_proveedor"];
$oferta=$rs_POF_prov["PROVEEDOR"];
$id_obra=$rs_POF_prov["ID_OBRA"];


if (!($id_proveedor))
{
   $href1="../proveedores/proveedores_anadir.php?proveedor=$oferta&id_pof_proveedor=$id_pof_proveedor" ; 
   $href2="../proveedores/subcontrato_anadir_desde_pof.php?id_pof_proveedor=$id_pof_proveedor" ; 
    
   echo "<h2>ATENCION !!, OFERTA sin proveedor asociado</h2>" ;
   echo "<h2>¿Crear nuevo Proveedor llamado <b>$oferta</b> y crear el Subcontrato?</h2>" ;
//   echo  "<br><button class='btn btn-primary' onclick=\"js_href('$href1');js_href('$href2');window.close(); \"   "
//           . "title='Ir la página anterior'>Aceptar</button>" ;
   echo  "<br><button class='btn btn-primary' onclick=\"js_href('$href1'); \"   "
           . "title='Ir la página anterior'>Aceptar</button>" ;
   echo  "<button class='btn btn-warning' onclick='window.close();' title='Ir la página anterior'>Cancelar</button>" ;
}
else
{    
$fecha= date('Y-m-d') ;

$sql="INSERT INTO `Subcontratos` ( id_obra,id_pof,id_proveedor,subcontrato,Condiciones,f_subcontrato, `user` )  "
        . "  VALUES ( '$id_obra' ,'$id_pof' ,'$id_proveedor' "
        . " ,'{$rs_POF_prov["NOMBRE_POF"]}','{$rs_POF_prov["Condiciones"]}' ,'$fecha' ,  '{$_SESSION["user"]}' )" ;
 //echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) 
     {
        $id_subcontrato=Dfirst( "MAX(id_subcontrato)", "Subcontratos_obra", "id_obra=$id_obra AND id_c_coste={$_SESSION["id_c_coste"]}" ) ; 

        $sql="SELECT * , P$num_prov AS COSTE  FROM POF_CONCEPTOS WHERE ID_POF=$id_pof  AND Ocultar=0 " ;
        $result=$Conn->query($sql );

        $id_cuenta_auto = getVar("id_cuenta_auto") ;
        
        // marcamos la Oferta (POF_DETALLE) como adjudicada
        $sql_update_adjudicada= "UPDATE `POF_DETALLE` SET Adjudicada=1  WHERE  id='$id_pof_oferta'  ; "  ;        
        $Conn->query($sql_update_adjudicada ) ;   


        while ($rs = $result->fetch_array(MYSQLI_ASSOC)) 
        {


            $sql_insert_CONCEPTO =  "INSERT INTO `CONCEPTOS` ( ID_PROVEEDOR,ID_OBRA,ID_CUENTA,CONCEPTO,COSTE,`user` ) "
         . " VALUES ( '$id_proveedor', '$id_obra','$id_cuenta_auto' ,'{$rs["CONCEPTO"]}' ,'{$rs["COSTE"]}' , '{$_SESSION["user"]}' )" ;

    //                    echo ($sql4);
            $result4=$Conn->query($sql_insert_CONCEPTO);

            // rescato el nuevo id_concepto creado y lo asigno a la variable id_concepto
            $id_concepto=Dfirst( "MAX(ID_CONCEPTO)", "CONCEPTOS", "ID_PROVEEDOR=$id_proveedor " ) ; 

            $sql_insert_USUB =  "INSERT INTO `Subcontrato_conceptos` "
                    . " ( id_subcontrato,id_concepto,id_udo,precio_cobro,cantidad_max,descripcion ) "
              . " VALUES ( '$id_subcontrato', '$id_concepto','{$rs["id_udo"]}' ,'{$rs["Precio_Cobro"]}' ,'{$rs["CANTIDAD"]}' ,'{$rs["DESCRIPCION"]}' )" ;

    //                    echo ($sql4);
            $result5=$Conn->query($sql_insert_USUB);
            
            
        }
//	       echo  "Ir al proveedor <a href='../proveedores/proveedores_ficha.php?id_proveedor=$id_proveedor' title='ver proveedor'> $proveedor</a>" ;
       echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../obras/subcontrato.php?id_subcontrato=$id_subcontrato'>" ;

         }
        else
       {
           echo "<h2>Error al crear SUBCONTRATO, inténtelo de nuevo </h2>" ;
           echo  "<br><button class='btn btn-warning' onclick='window.close();' >Cerrar</button>" ;
       }
       
}
?>