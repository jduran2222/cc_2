<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


?>
<?php

require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

if (isset($_POST["nombre_obra"]))
{   
    $nombre_obra=strtoupper(ltrim(rtrim($_POST["nombre_obra"]))) ;
    $id_cliente=0  ;
//    $id_cliente=$_POST["id_cliente"]  ;
    $NOMBRE_COMPLETO=$nombre_obra ;
    $tipo_subcentro='O' ;
    $activa=1;
    $IMPORTE=0;
    $TIPO_LICITACION=0;
    $ID_ESTUDIO='';
    
    //$email=$_POST["email"]  ;
}
else
{   
    $nombre_obra=$_GET["nombre_obra"] ;
//    $id_cliente = isset($_GET["id_cliente"]) ? $_GET["id_cliente"] : getvar('id_cliente_auto')  ;
    $id_cliente = isset($_GET["id_cliente"]) ? $_GET["id_cliente"] : 0  ;
    $NOMBRE_COMPLETO = isset($_GET["NOMBRE_COMPLETO"]) ? urldecode( $_GET["NOMBRE_COMPLETO"]) : $nombre_obra  ;
    $tipo_subcentro = isset($_GET["tipo_subcentro"]) ? $_GET["tipo_subcentro"] : 'O'  ;
    $IMPORTE = isset($_GET["IMPORTE"]) ? $_GET["IMPORTE"] : ''  ;
    $TIPO_LICITACION = $IMPORTE ;
    $ID_ESTUDIO = isset($_GET["ID_ESTUDIO"]) ? $_GET["ID_ESTUDIO"] : ''  ;
    
    $activa= ($tipo_subcentro<>'E')   ;  // las  OBRA-ESTUDIO (E) las declaramos inactivas
    //$email=$_POST["email"]  ;
}
    

// registramos el documento en la bbdd


$sql=    "INSERT INTO `OBRAS` ( `id_c_coste`,id_cliente, `NOMBRE_OBRA`,NOMBRE_COMPLETO  ,  tipo_subcentro , activa , IMPORTE , TIPO_LICITACION,ID_ESTUDIO,`user` ) "
   . "VALUES ( {$_SESSION["id_c_coste"]} ,'$id_cliente','$nombre_obra','$NOMBRE_COMPLETO','$tipo_subcentro','$activa','$IMPORTE','$TIPO_LICITACION' ,'$ID_ESTUDIO', '{$_SESSION["user"]}' );" ;
 //echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado la obra
         { 	
             $id_obra=Dfirst( "MAX(id_obra)", "OBRAS", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	    
            // creamos la PRODUCCION OBRA 
//            $produccion= ($tipo_subcentro=='E')? 'ESTUDIOS DE COSTES' : 'PRODUCCION OBRA' ;
//            $campo_id_prod= ($tipo_subcentro=='E')? 'ESTUDIOS DE COSTES' : 'PRODUCCION OBRA' ;
//            $sql2="INSERT INTO `PRODUCCIONES` ( ID_OBRA, PRODUCCION,`user` )    VALUES (  '$id_obra', '$produccion' , '{$_SESSION["user"]}' );" ;
//            //echo ($sql2);
//            $result=$Conn->query($sql2);
//            $id_produccion=Dfirst( "MAX(ID_PRODUCCION)", "Prod_view", "ID_OBRA=$id_obra AND PRODUCCION='$produccion' AND id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
            
            $id_prod_estudio_costes=DInsert_into('PRODUCCIONES', '( ID_OBRA, PRODUCCION,`user` ) ', "(  '$id_obra', 'PROYECTO' , '{$_SESSION["user"]}' )", 'ID_PRODUCCION', "ID_OBRA=$id_obra");
            $id_produccion_obra=DInsert_into('PRODUCCIONES', '( ID_OBRA, PRODUCCION,`user` ) ', "(  '$id_obra', 'PRODUCCION OBRA' , '{$_SESSION["user"]}' )", 'ID_PRODUCCION', "ID_OBRA=$id_obra");
            
            logs("añadir OBRA-ESTUDIO id_prod_estudio: $id_prod_estudio_costes ");
            logs("añadir OBRA-ESTUDIO id_prod_prod: $id_produccion_obra ");
            
            
            $id_subobra_auto=DInsert_into('SubObras', '( ID_OBRA,SUBOBRA ,`user` ) ', "(  '$id_obra', 'sin imputar $nombre_obra' , '{$_SESSION["user"]}' )", 'ID_SUBOBRA',"ID_OBRA=$id_obra");
            
            // actualizamos valores en OBRAS
            $result=$Conn->query($sql_update="UPDATE `OBRAS` SET `id_prod_estudio_costes` = $id_prod_estudio_costes,`id_produccion_obra` = $id_produccion_obra, id_subobra_auto=$id_subobra_auto "
                    . " WHERE  ID_OBRA=$id_obra AND id_c_coste={$_SESSION["id_c_coste"]} ; ");
                    
//            logs("UPDATE OBRA-ESTUDIO result: $result ");
            // Si es una id_obra_estudio la vinculamos a su ID_ESTUDIO
            if ($ID_ESTUDIO)
            {
            $sql_update="UPDATE `Estudios_de_Obra` SET `id_obra_estudio` = $id_obra WHERE  ID_ESTUDIO=$ID_ESTUDIO AND id_c_coste={$_SESSION["id_c_coste"]} ; " ;
            //echo ($sql_update);
            $result=$Conn->query($sql_update);
                
            }
            
//            echo "Obra creada satisfactoriamente." ;
//	    echo  "Ir a obra <a href=\"obras_ficha.php?id_obra=$id_obra\" title='ver obra'> $nombre_obra</a>" ;
            if($tipo_subcentro<>'E' )
            {  echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../obras/obras_ficha.php?id_obra=$id_obra'>" ;  }
            else
            {  echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../estudios/estudios_ficha.php?id_estudio=$ID_ESTUDIO'>" ;  }    
            
         }
	   else
	  {
	    echo "Error al crear obra, inténtelo de nuevo.  SQL: $sql" ;
	    echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	  }
       

?>