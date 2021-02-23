<?php

require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

require_once("../../conexion.php");

switch ($_POST['accion']) {


	
	case 'CARGAR':
		$xSql="Select subcontratos.*, peticion_de_ofertas.NOMBRE_POF, proveedores.PROVEEDOR, proveedores.RAZON_SOCIAL, proveedores.CIF, "; 
		$xSql.="sum(subcontrato_conceptos.cantidad_max * conceptos.COSTE) as importe ";
		$xSql.="From ((((subcontratos ";
		$xSql.="left join peticion_de_ofertas on subcontratos.id_pof=peticion_de_ofertas.id_pof) ";
		$xSql.="left join proveedores on subcontratos.id_proveedor=proveedores.ID_PROVEEDORES) ";
		$xSql.="left join subcontrato_conceptos on subcontratos.id_subcontrato = subcontrato_conceptos.id_subcontrato) ";
		$xSql.="left join conceptos on subcontrato_conceptos.ID_CONCEPTO=conceptos.ID_CONCEPTO) ";
		$xSql.="where subcontratos.id_obra=".$_POST['id_obra']." ";
		if (!empty($_POST['filtro'])){
			if (is_numeric($_POST['filtro'])) {
				$xSql.="and (subcontratos.id_subcontrato=".$_POST['filtro'].") ";}
			else {
				$xSql.="and (peticion_de_ofertas.NOMBRE_POF like '%".$_POST['filtro']."%') ";
			}	
		}
		if ($_POST['id_proveedor']<>0){
			$xSql.="and subcontratos.id_proveedor=".$_POST['id_proveedor']." ";
		}
		$xSql.="group by id_subcontrato ";
		$xSql.="order by fecha_creacion desc ";
		$resul= mysqli_query($Conn, $xSql) or die ("Error SQL: " . mysqli_error($Conn) . "<br/><br/>" . $xSql . "<br/><br/>");
		//$xtabla="<div class='altoLista1'>";
		$xtabla="";
		$xtabla.="<table width=100% class='tdatos'>";
		$xtabla.="<thead><tr>";
		$xtabla.="<th style='width:80px;'>id</th>";
		$xtabla.="<th>Subcontrato (POF)</th>";
		$xtabla.="<th>Proveedor</th>";
		$xtabla.="<th>Fecha</th>";
		$xtabla.="<th style='text-align:center;'>Importe subcontrato</th>";
		$xtabla.="<th style='text-align:center;'>Importe ejecutado</th>";
		$xtabla.="<th style='text-align:center;'>Porc ej</th>";
		$xtabla.="</tr></thead>";
		if ($fila= mysqli_fetch_array($resul, MYSQLI_ASSOC)){ 
   			$son=0;
   			$t1=0;
   			$t2=0;
   			$t3=0;
   			do { 
				$xtabla.="<tr onclick='ficha1(".$fila["id_subcontrato"].")'>";
				$xtabla.="<td class='txtResaltado'>".$fila["id_subcontrato"]."</td>";			
				$xtabla.="<td>".$fila["NOMBRE_POF"]."</td>";
				$xtabla.="<td>".$fila["PROVEEDOR"]."</td>";
				$xtabla.="<td>".date_format(date_create($fila["f_pof"]),'d/m/Y')."</td>";
				$xtabla.="<td style='text-align:right;'>".number_format($fila["importe"], 2, ',','.')."</td>";
				$xtabla.="<td style='text-align:right;'>".number_format(0, 2, ',','.')."</td>";
				$xtabla.="<td style='text-align:right;'>".number_format(0, 2, ',','.')."%</td>";

				$xtabla.= "</tr>";
				$son += 1;
				$t1+=$fila["importe"];
			} while ($fila = mysqli_fetch_array($resul, MYSQLI_ASSOC)); 
			$xtabla.="<tr style='font-weight:bold; border-top:2px solid #0a8ac2;'>";
			$xtabla.="<td colspan=4><b>Total Subcontratos: ".number_format($son, 0, '','.')."</b></td>";
			$xtabla.="<td style='text-align:right;'>".number_format($t1, 2, ',','.')."</td>";
			$xtabla.="<td style='text-align:right;'>".number_format($t2, 2, ',','.')."</td>";
			$xtabla.="<td style='text-align:right;'>".number_format($t3, 2, ',','.')."%</td>";
			$xtabla.="</td>";
		} else { 
			$xtabla.="<tr><td colspan=7 style='color:red; text-align:center; font-weight:bold;'>Subcontratos NO encontrados!</td></tr>"; 
		}
		$xtabla.="</table>";
		$xtabla.="</div>";
		
		echo $xtabla;
		break;
	



	case "FICHA1": //Subcontrato
		$xtabla="";

		//Buscar el sub contrato
		$xSql="Select * from subcontratos where subcontratos.id_obra=".$_POST['id_obra']." and subcontratos.id_subcontrato=".$_POST['id_subcontrato'];
		$resul=mysqli_query($Conn, $xSql) or die ("Error SQL: ".mysqli_error($Conn)."<br/><br/>".$xSql."<br/>");
		if ($fila=mysqli_fetch_array($resul, MYSQLI_ASSOC)){
			$nueva=0;}
		else {
			$nueva=1;
			//$fila["fecha"]=date("Y-m-d");
			$fila['id_pof']=0;
			$fila['id_proveedor']=0;
			$fila['Condiciones']="";
			$fila['Observaciones']="";
			$fila['f_pof']=date("Y-m-d");
			$fila["user"]=$_SESSION["user"];
		}	

		// $xtabla.="<h3 style='color:#eb9316;'>id ";
		// if ($nueva==1){$xtabla.=" (NUEVO)";} else {$xtabla.=$_POST['id_subcontrato'];}
		// $xtabla.="</h3>";
		$xtabla.="<input hidden id='id_subcontrato' value=".$_POST['id_subcontrato'].">";

		$xtabla.="<div class='altoLista1'>"; 

		$xtabla.="<div class='fila'>";
		$xtabla.="<div class='col1 pt'>Subcontrato (POF):</div>";
		$xtabla.="<div class='col2'>";
		if ($fila['id_pof']=="") {$fila['id_pof']=0;}
		$xSql="Select peticion_de_ofertas.NOMBRE_POF from peticion_de_ofertas where ID_POF=".$fila['id_pof'];
		$resul2= mysqli_query($Conn, $xSql) or die ("Error SQL: " . mysqli_error($Conn));
		$xtabla.="<div id='d_id_pof' class='etiqueE pt'>";
		if ($fila2=mysqli_fetch_array($resul2, MYSQLI_ASSOC)){
			$xtabla.=$fila2["NOMBRE_POF"]; }
		else {
			$xtabla.="* SIN POF *"; }	
		$xtabla.="</div>";
		$xtabla.="<input hidden id='id_pof' value=".$fila['id_pof'].">";
		$xtabla.="<button class='boton1 ve fas fa-search' type='button' onClick='buscar1(1);' style='margin-top:0;'></button>";
		$xtabla.="</div></div>";
		

		$xtabla.="<div class='fila'>";
		$xtabla.="<div class='col1 pt'>Proveedor:</div>";
		$xtabla.="<div class='col2'>";
		if ($fila['id_proveedor']==""){$fila['id_proveedor']=0;}
		$xSql="Select proveedores.PROVEEDOR, proveedores.RAZON_SOCIAL, proveedores.CIF from proveedores where ID_PROVEEDORES=".$fila['id_proveedor'];
		$resul2= mysqli_query($Conn, $xSql) or die ("Error SQL: " . mysqli_error($Conn));
		$xtabla.="<div id='d_id_proveedor' class='etiqueE pt'><b>";
		if ($fila2=mysqli_fetch_array($resul2, MYSQLI_ASSOC)){
			$xtabla.=$fila2["PROVEEDOR"]; }
		else {
			$xtabla.="* SIN PROVEEDOR *"; }	
		$xtabla.="</div>";
		$xtabla.="</b><input hidden id='id_proveedor' value=".$fila['id_proveedor'].">";
		$xtabla.="<button class='boton1 ve fas fa-search' type='button' onClick='buscar1(2);' style='margin-top:0;'></button>";
        $xtabla.="</button>";
		$xtabla.="</div></div>";


		$xtabla.="<div class='fila'>";
		$xtabla.="<div class='col1'>Condiciones:</div>";
		$xtabla.="<div class='col2'><textarea id='Condiciones' rows='3' class='campo100' value=''>".$fila['Condiciones']."</textarea></div>";
		$xtabla.="</div>";

		$xtabla.="<div class='fila'>";
		$xtabla.="<div class='col1'>Observaciones:</div>";
		$xtabla.="<div class='col2'><textarea id='Observaciones' rows='3' class='campo100' value=''>".$fila['Observaciones']."</textarea></div>";
		$xtabla.="</div>";

		$xtabla.="<div class='fila'>";
		$xtabla.="<div class='col1'>Fecha:</div>";
		$xtabla.="<div class='col2'><input type='date' id='f_pof' value='".date_format(date_create($fila["f_pof"]),'Y-m-d')."'></div>";
		$xtabla.="</div>";

		$xtabla.="<div class='fila'>";
		$xtabla.="<div class='col1'>Ultima Actualización:</div>";
		$xtabla.="<div class='col2'>";
		if ($nueva<>1){ $xtabla.=$fila["user"].", ".date_format(date_create($fila['fecha_creacion']),'d/m/Y g:ia');}
		$xtabla.="</div></div>";

		$xtabla.="</div>";  //de altoLista1

		//Unidades Subcontratadas
		$xtabla.="<div class='fila' style='margin-bottom:0px;'>";
		$xtabla.="<h3 class='txtResaltado' style='float:left; padding-top: 5px;'>Unidades Subcontratadas:</h3>";

		$puede=true;
		if ($puede){
			$xtabla.="<button class='boton1 ve' type='button' onClick='ficha3(0);'";
            $xtabla.="title='Agrega un nueva unidad a este Subcontrato' style='float:right; margin-top:0;'>";
            $xtabla.="<i class='fas fa-plus-circle'></i>Agregar</button>";
		}
		$xtabla.="</div>";

		
		$xtabla.="<div id='lista2' class='altoLista2'>";

		$xSql="Select subcontrato_conceptos.*, "; 
		$xSql.="conceptos.CONCEPTO, conceptos.COSTE "; 
		$xSql.="From (subcontrato_conceptos ";
		$xSql.="left join conceptos on subcontrato_conceptos.ID_CONCEPTO=conceptos.ID_CONCEPTO) ";
		$xSql.="where subcontrato_conceptos.id_subcontrato=".$_POST['id_subcontrato'];

		$resul= mysqli_query($Conn, $xSql) or die ("Error SQL: " . mysqli_error($Conn) . "<br/><br/>" . $xSql . "<br/><br/>");

		$xtabla.="<table width=100% class='tdatos'><tr>";
		$xtabla.="<th rowspan=2>id</th>";
		$xtabla.="<th rowspan=2>Concepto</th>";
		$xtabla.="<th rowspan=2 style='text-align:center;'>Cantidad Max</th>";
		$xtabla.="<th colspan=2 style='text-align:center;'>Cobro</th>";
		$xtabla.="<th colspan=2 style='text-align:center;'>Subcontrato</th>";
		$xtabla.="</tr><tr>";
		$xtabla.="<th style='text-align:center;'>Precio</th>";
		$xtabla.="<th style='text-align:center;'>Importe</th>";
		$xtabla.="<th style='text-align:center;'>Coste</th>";
		$xtabla.="<th style='text-align:center;'>Importe</th>";
		$xtabla.="</tr>";

		$son=0;
		$t1=0;
		$t2=0;
		$t3=0;
		$t4=0;
		$t5=0;
		if ($fila= mysqli_fetch_array($resul, MYSQLI_ASSOC)){ 
   			do {
				$xtabla.="<tr onclick='ficha3(".$fila["id"].")'>";
				$xtabla.="<td class='txtResaltado'>".$fila["id"]."</td>";
				$xtabla.="<td>".$fila["CONCEPTO"]."</td>";
				$xtabla.="<td style='text-align:right;'>".number_format($fila["cantidad_max"], 2, ',','.')."</td>";
				$xtabla.="<td style='text-align:right;'>".number_format($fila["precio_cobro"], 2, ',','.')."</td>";
				$xtabla.="<td style='text-align:right;'>".number_format(($fila["cantidad_max"]*$fila["precio_cobro"]), 2, ',','.')."</td>";
				$xtabla.="<td style='text-align:right;'>".number_format($fila["COSTE"], 2, ',','.')."</td>";
				$xtabla.="<td style='text-align:right;'>".number_format(($fila["cantidad_max"]*$fila["COSTE"]), 2, ',','.')."</td>";
				$xtabla.= "</tr>";
				$son+=1;
				$t1+=$fila["cantidad_max"];
				$t2+=$fila["precio_cobro"];
				$t3+=($fila["cantidad_max"]*$fila["precio_cobro"]);
				$t4+=$fila["COSTE"];
				$t5+=($fila["cantidad_max"]*$fila["COSTE"]);
			} while ($fila = mysqli_fetch_array($resul, MYSQLI_ASSOC)); 
			$xtabla.="<tr style='font-weight:bold; border-top:2px solid #0a8ac2;'>";
			$xtabla.="<td colspan=2 style='text-align:right;'>Total Unidades Subcontratadas: ".$son."</td>";
			$xtabla.="<td style='text-align:right;'>".number_format($t1, 2, ',','.')."</td>";
			$xtabla.="<td style='text-align:right;'>".number_format($t2, 2, ',','.')."</td>";
			$xtabla.="<td style='text-align:right;'>".number_format($t3, 2, ',','.')."</td>";
			$xtabla.="<td style='text-align:right;'>".number_format($t4, 2, ',','.')."</td>";
			$xtabla.="<td style='text-align:right;'>".number_format($t5, 2, ',','.')."</td>";
			$xtabla.="</tr>";
		} else { 
			$xtabla.="<tr>";
			$xtabla.="<td colspan=7 class='txtResaltado' style='text-align:center;'>Sin Unidades Subcontratadas registradas</td>";
			$xtabla.="</tr>";
		}	

		$xtabla.="</table>";

		$xtabla.="</div>";

		//Botones
		$xtabla.="<div class='venEmerBot1'>";
        $xtabla.="<div id='aviso1' class='aviso'></div>";
        $xtabla.="<div class='venEmerBot2'>";
        $xtabla.="<button type='button' class='boton1 mr' id='guardar1' onClick='guardarFicha1(1);' title='Guarda el registro actual'><i class='far fa-save'></i>Guardar</button>";
        if ($nueva==0) {
	        $xtabla.="<button type='button' class='boton1 mr' id='eliminar1' onClick='eliminarPregunta1();' title='Elimina el registro actual'><i class='far fa-trash-alt'></i>Eliminar</button>";
	        $xtabla.="<button type='button' class='boton1 mr' id='eliminarSi1' style='display:none; width:60px; text-align:center;' onClick='eliSi1();'>Si</button>"; 
	        $xtabla.="<button type='button' class='boton1' id='eliminarNo1' style='display:none; width:60px; text-align:center;' onClick='eliNo1();'>No</button>";
    	}
        $xtabla.="<button type='button' class='boton1' id='cerrar1' onClick='cerrarVentana();'><i class='far fa-times-circle'></i>Cerrar</button>";
		$xtabla.="</div></div>";

		echo $xtabla;
		break;



	case "GUARDAR1": //Subcontrato
		$ahora=date("Y-m-d H:i:s");
		if ($_POST['id_subcontrato']==0){
			$xSql="Insert into subcontratos set ";
			$xSql.="id_obra=".$_POST['id_obra'].", ";
		}
		else {
			$xSql="Update subcontratos set ";
		}
		$xSql.="id_pof=".$_POST['id_pof'].", ";
		$xSql.="subcontrato='".$_POST['subcontrato']."', ";
		$xSql.="id_proveedor=".$_POST['id_proveedor'].", ";
		if ($_POST['Condiciones']<>"") { $xSql.="Condiciones='".$_POST['Condiciones']."', "; }
		if ($_POST['Observaciones']<>"") { $xSql.="Observaciones='".$_POST['Observaciones']."', "; }
		if ($_POST['f_pof']<>"") { $xSql.="f_pof='".$_POST['f_pof']."', "; } else {$xSql.="f_pof=null, ";}
		if (isset($_SESSION["user"])) { $xSql.="user='".$_SESSION["user"]."', "; }
		$xSql.="fecha_creacion='".$ahora."' ";
		if ($_POST['id_subcontrato']<>0){ $xSql.="where id_subcontrato=".$_POST['id_subcontrato']." "; }
		$resul=mysqli_query($Conn, $xSql) or die ("Error SQL: ".mysqli_error($Conn)."<br/><br/>".$xSql."<br/>");

		//buscar el nuevo id del subcontrato creado 
		if ($_POST['id_subcontrato']==0){
			$xSql="Select id_subcontrato from subcontratos where id_pof=".$_POST['id_pof']." and id_proveedor=".$_POST['id_proveedor']." and fecha_creacion='".$ahora."' limit 1";
			$resul=mysqli_query($Conn, $xSql) or die ("Error SQL: ".mysqli_error($Conn)."<br/><br/>".$xSql."<br/>");
			$fila= mysqli_fetch_array($resul, MYSQLI_ASSOC);
			echo $fila['id_subcontrato'];}
		else {
			echo $_POST['id_subcontrato'];}	
		break;


	case "ELIMINAR1": //Subcontrato
		$xSql="delete from subcontratos where id_subcontrato=".$_POST['id_subcontrato'];
		$resul=mysqli_query($Conn, $xSql) or die ("Error SQL: ".mysqli_error($Conn)."<br/><br/>".$xSql."<br/>");

		$xSql="delete from subcontrato_conceptos where id_subcontrato=".$_POST['id_subcontrato'];
		$resul=mysqli_query($Conn, $xSql) or die ("Error SQL: ".mysqli_error($Conn)."<br/><br/>".$xSql."<br/>");
		break;



	case 'BUSCAR':
		$cols=2;
		switch ($_POST['buscar']) {
			case 1: //pof
				$xSql="Select ID_POF as id, NOMBRE_POF as nombre from peticion_de_ofertas where id_obra=".$_POST['id_obra']." and NOMBRE_POF like '%".$_POST['filtro']."%' order by NOMBRE_POF";
				break;
			case 2: //Proveedor
				$xSql="Select ID_PROVEEDORES as id, PROVEEDOR as nombre from proveedores where id_c_coste=".$id_c_coste." and PROVEEDOR like '%".$_POST['filtro']."%' order by PROVEEDOR";
				break;
			case 3: //Concepto
				$xSql="Select ID_CONCEPTO as id, CONCEPTO as nombre, COSTE from conceptos where id_obra=".$_POST['id_obra']." and ID_PROVEEDOR=".$_POST['id_proveedor']." and CONCEPTO like '%".$_POST['filtro']."%' order by CONCEPTO";
				$cols=3;
				break;
		}

		$resul= mysqli_query($Conn, $xSql) or die ("Error SQL: " . mysqli_error($Conn) . "<br/><br/>" . $xSql . "<br/><br/>");
		//$xtabla="<div class='altoLista1'>";
		$xtabla="";
		$xtabla.="<table width=100% class='tdatos'>";
		$xtabla.="<thead><tr>";
		$xtabla.="<th style='width:80px;'>id</th>";
		$xtabla.="<th>Nombre</th>";
		if ($_POST['buscar']==3){ $xtabla.="<th style='text-align:center;'>Coste</th>"; }
		$xtabla.="</tr></thead>";
		if ($fila= mysqli_fetch_array($resul, MYSQLI_ASSOC)){ 
   			$son=0;
   			do { 
				$xtabla.="<tr onclick='buscar3(".$_POST['buscar'].", ".$fila["id"].", ".chr(34).$fila['nombre'].chr(34);
				if ($_POST['buscar']==3){ $xtabla.=", ".chr(34).number_format($fila["COSTE"], 2, ',','.').chr(34);}
				$xtabla.=")' >";
				$xtabla.="<td>".$fila["id"]."</td>";			
				$xtabla.="<td>".$fila["nombre"]."</td>";
				if ($_POST['buscar']==3){ $xtabla.="<td style='text-align:right;'>".number_format($fila["COSTE"], 2, ',','.')."</td>"; }
				$xtabla.= "</tr>";
				$son += 1;
			} while ($fila = mysqli_fetch_array($resul, MYSQLI_ASSOC)); 
		} else { 
			$xtabla.="<tr><td colspan=".$cols." style='color:red; text-align:center; font-weight:bold;'>Filtro NO encontrado!</td></tr>"; 
		}
		$xtabla.="</table>";
		$xtabla.="</div>";
		
		echo $xtabla;
		break;




	case "FICHA3":
		$xtabla="";

		//Buscar la Unidades Subcontratadas
		$xSql="Select subcontrato_conceptos.*, "; 
		$xSql.="conceptos.CONCEPTO, conceptos.COSTE "; 
		$xSql.="From (subcontrato_conceptos ";
		$xSql.="left join conceptos on subcontrato_conceptos.id_concepto=conceptos.ID_CONCEPTO) ";
		$xSql.="where subcontrato_conceptos.id=".$_POST['id_usc'];

		$resul=mysqli_query($Conn, $xSql) or die ("Error SQL: ".mysqli_error($Conn)."<br/><br/>".$xSql."<br/>");
		if ($fila=mysqli_fetch_array($resul, MYSQLI_ASSOC)){
			$nueva=0;}
		else {
			$nueva=1;
			//$fila["fecha"]=date("Y-m-d");
			$fila['id_concepto']=0;
			$fila['CONCEPTO']="* SIN CONCEPTO *";
			$fila['COSTE']=0;

			$fila['cantidad_max']="";
			$fila['precio_cobro']="";
			$fila['Observaciones']="";
		}	

		$xtabla.="<input hidden id='id_usc' value=".$_POST['id_usc'].">";

		$xtabla.="<div class='altoLista1'>"; 

		$xtabla.="<div class='fila'>";
		$xtabla.="<div class='col1 pt'>Concepto:</div>";
		$xtabla.="<div class='col2'>";
		$xtabla.="<div id='d_ID_CONCEPTO' class='etiqueE pt'>";
		$xtabla.=$fila["CONCEPTO"]; 
		$xtabla.="</div>";
		$xtabla.="<input hidden id='ID_CONCEPTO' value=".$fila['id_concepto'].">";
		$xtabla.="<button class='boton1 ve fas fa-search' type='button' onClick='buscar1(3);' style='margin-top:0;'></button>";
        //$xtabla.="<i class='fas fa-search'></i>Buscar</button>";
		$xtabla.="</div></div>";


		$xtabla.="<div class='fila'>";
		$xtabla.="<div class='col1'>Coste:</div>";
		$xtabla.="<div class='col2' id='coste'>";
		$xtabla.=number_format($fila["COSTE"], 2, ',','.');
		$xtabla.="</div></div>";

		$xtabla.="<div class='fila'>";
		$xtabla.="<div class='col1'>Cantidad Max:</div>";
		$xtabla.="<div class='col2'><input type='text' id='cantidad_max' value='".$fila["cantidad_max"]."' ";
		$xtabla.="onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;' onFocus='this.select();' ";
		$xtabla.="></div>";
		$xtabla.="</div>";

		$xtabla.="<div class='fila'>";
		$xtabla.="<div class='col1'>Precio Cobro:</div>";
		$xtabla.="<div class='col2'><input type='text' id='precio_cobro' value='".$fila["precio_cobro"]."' ";
		$xtabla.="onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;' onFocus='this.select();' ";
		$xtabla.="></div>";
		$xtabla.="</div>";

		$xtabla.="<div class='fila'>";
		$xtabla.="<div class='col1'>Observaciones:</div>";
		$xtabla.="<div class='col2'><textarea id='Observaciones' rows='3' class='campo100' value=''>".$fila['Observaciones']."</textarea></div>";
		$xtabla.="</div>";

		$xtabla.="</div>";  //de altoLista1

		//Botones
		$xtabla.="<div class='venEmerBot1'>";
        $xtabla.="<div id='aviso3' class='aviso'></div>";
        $xtabla.="<div class='venEmerBot2'>";
        $xtabla.="<button type='button' class='boton1 mr' id='guardar3' onClick='guardarFicha3();' title='Guarda el registro actual'><i class='far fa-save'></i>Guardar</button>";
        if ($nueva==0) {
	        $xtabla.="<button type='button' class='boton1 mr' id='eliminar3' onClick='eliminarPregunta3();' title='Elimina el registro actual'><i class='far fa-trash-alt'></i>Eliminar</button>";
	        $xtabla.="<button type='button' class='boton1 mr' id='eliminarSi3' style='display:none; width:60px; text-align:center;' onClick='eliSi3();'>Si</button>"; 
	        $xtabla.="<button type='button' class='boton1' id='eliminarNo3' style='display:none; width:60px; text-align:center;' onClick='eliNo3();'>No</button>";
    	}
        $xtabla.="<button type='button' class='boton1' id='cerrar3' onClick='cerrarVentana3();'><i class='far fa-times-circle'></i>Cerrar</button>";
		$xtabla.="</div></div>";

		echo $xtabla;
		break;



	case "GUARDAR3": //Unidad Subcontratada
		if ($_POST['id_usc']==0){
			$xSql="Insert into subcontrato_conceptos set ";
			$xSql.="id_subcontrato=".$_POST['id_subcontrato'].", ";
		}
		else {
			$xSql="Update subcontrato_conceptos set ";
		}
		$xSql.="id_concepto=".$_POST['id_concepto'].", ";
		if ($_POST['precio_cobro']<>"") { $xSql.="precio_cobro=".$_POST['precio_cobro'].", "; }
		$xSql.="cantidad_max=".$_POST['cantidad_max']." ";
		if ($_POST['Observaciones']<>"") { $xSql.=", Observaciones='".$_POST['Observaciones']."' "; }
		if ($_POST['id_usc']<>0){ $xSql.="where id=".$_POST['id_usc']; 		}
		$resul=mysqli_query($Conn, $xSql) or die ("Error SQL: ".mysqli_error($Conn)."<br/><br/>".$xSql."<br/>");
		break;


	case "ELIMINAR3": //Unidad Subcontratada
		$xSql="delete from subcontrato_conceptos where id=".$_POST['id_usc'];
		$resul=mysqli_query($Conn, $xSql) or die ("Error SQL: ".mysqli_error($Conn)."<br/><br/>".$xSql."<br/>");
		break;

}

?>