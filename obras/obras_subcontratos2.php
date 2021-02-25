<?php
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$id_obra=$_GET["id_obra"];

//Proveedores de la obra
$xSql="Select DISTINCT Subcontratos.id_proveedor, Proveedores.PROVEEDOR ";
$xSql.="From (Subcontratos ";
$xSql.="left join Proveedores on Subcontratos.id_proveedor=Proveedores.ID_PROVEEDORES) ";
$xSql.="where Subcontratos.id_obra=".$id_obra." ";
$xSql.="order by  Proveedores.PROVEEDOR";
$s_proveedores="<option value=0 selected>* TODOS *</option>"; 

//$xSql="Select * FROM OBRAS WHERE $where_c_coste ";

$resul= mysqli_query($Conn, $xSql) or die ("Error SQL: " . mysqli_error($Conn) . "<br/><br/>" . $xSql . "<br/><br/>");
//$resul= $Conn->query($xSql) or die ("Error SQL2: " . mysqli_error($Conn) . "<br/><br/>" . $xSql . "<br/><br/>");
//$resul= $Conn->query($xSql);
//$result=$Conn->query($xSql);

if ($fila=mysqli_fetch_array($resul, MYSQLI_ASSOC)) {
    do {
        $s_proveedores.="<option value=".$fila['id_proveedor'].">".$fila['PROVEEDOR']."</option>";
    } while ($fila = mysqli_fetch_array($resul, MYSQLI_ASSOC)); 
}

//INICIO
$titulo="SUBCONTRATOS";
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');
require_once("../obras/obras_menutop_r.php"); 
?>

<!-- El css debe estar en _inc_privado1_header.php -->
<!--<link rel="stylesheet" type="text/css" href="../css/estilos2.css?v=0.1">-->

<div style="overflow:visible;">	   
    <div id="main" class="mainc_100" style="background-color:#fff; padding:10px;">

        <div class="panel">
            <h2>Subcontratos</h2>
            <form autocomplete="off">
                <div class="divleft">
                    <label>Buscar:</label>
                    <input type="text" id="filtro0" maxlength="20" value="" placeholder="id / Subcontrato"
                    onKeyPress="if (event.keyCode==13){cargatabla(); event.preventDefault();}">
                </div>
                <div class="divleft">
                    <label>Proveedor: </label>
                    <select id="id_proveedor0" onchange="cargatabla();">
                        <?php echo $s_proveedores; ?>
                    </select>    
                </div>

                <div class="divright">
                    <button class="boton1 mr" type="button" onClick="cargatabla();"
                    title="Ejecuta la busqueda y muestra los resultados">
                    <i class="fas fa-search"></i>Buscar</button>

                    <button class="boton1" type="button" onClick="ficha1(0);"
                    title="Agrega un nuevo Subcontrato a la Obra">
                    <i class="fas fa-plus-circle"></i>Agregar</button>
                </div>        
            </form>
        </div>
        <div class="panel" id="aviso"></div>
    </div>
</div>
</div>

<div id="espera" class="espera"></div>
<div id="fondo" class="capaoscura" onClick="cerrarVentana();"></div>

<div id="ficha1" class="ventanEmergente ventanEmergenteAncha_90 animate">
    <div class="tituloEmergente">
        <h3 id="titulo1">Subcontrato</h3>
        <i class="fas fa-times botonEmergente" onClick="cerrarVentana();"></i>
    </div>
    <div class="ventanEmergenteInterno" id="dataficha1"></div>
</div>

<div id="fondo2" class="capaoscura" onClick="cerrarVentana2();" style="z-index:1005;"></div>

<div id="ficha2" class="ventanEmergente ventanEmergenteAncha_600 animate" style="z-index:1006;">
    <div class="tituloEmergente">
        <h3 id="titulo2">Buscar</h2>
        <i class="fas fa-times botonEmergente" onClick="cerrarVentana2();"></i>
    </div>
    <div class="ventanEmergenteInterno" style='padding:10px;'>
            <div class="fila">
                <div class="divleft" style="width:auto;">
                    <label>Buscar: </label>
                    <input type='text' id='filtro2' class='campo30' maxlength='30' value='' onKeyPress="if (event.keyCode==13) {buscar2(); event.preventDefault(); }">
                    <input hidden id="buscar">
                </div> 
                <div class="divright">            
                   <button class="boton1" type="button" onClick="buscar2();"
                    title="Ejecuta la busqueda y muestra los resultados">
                    <i class="fas fa-search"></i>Buscar</button>
                </div>
            </div> 
        <div id="aviso2" class="fila" style="height: 350px; overflow: auto;"></div>
    </div>
</div>

<div id="fondo3" class="capaoscura" onClick="cerrarVentana3();" style="z-index:1003;"></div>

<div id="ficha3" class="ventanEmergente ventanEmergenteAncha_600 animate" style="z-index:1004;">
    <div class="tituloEmergente">
        <h3 id="titulo3">Unidad Subcontratada</h3>
        <i class="fas fa-times botonEmergente" onClick="cerrarVentana3();"></i>
    </div>
    <div class="ventanEmergenteInterno" id="dataficha3"></div>
</div>


<script>
    var id_obra=<?php echo $id_obra; ?>;

    cargatabla();

    function cargatabla() {
        var parametros = {
            "accion": "CARGAR",
            "id_obra": id_obra,
            "filtro": document.getElementById('filtro0').value, 
            "id_proveedor": document.getElementById('id_proveedor0').value
        };
        document.getElementById('espera').style.display='block';
        $.ajax({ async:true, method: 'POST', url: 'obras_subcontratos2_sql.php',  data: parametros, success:  function (response) {
            document.getElementById('espera').style.display='none';
            switch (response.substr(0, 1)) {
                case "0":
                    document.location.href='login.php';
                    break;
                default:
                    var scroll_y=document.getElementById('aviso').scrollTop; 
                    $("#aviso").html(response);
                    document.getElementById('aviso').scrollTop=scroll_y;
                    break;
            }
        }});   
    }

    function ficha1(id_subcontrato){
        var parametros = {
            "accion": "FICHA1",
            "id_obra": id_obra,
            "id_subcontrato": id_subcontrato
        };
        document.getElementById('espera').style.display='block';
        $.ajax({ async:true, method: 'POST', url: 'obras_subcontratos2_sql.php',  data: parametros, success:  function (response) {
            document.getElementById('espera').style.display='none';
            switch (response.substr(0, 1)) {
                case "0":
                    document.location.href='login.php';
                    break;
                default:
                    $("#dataficha1").html(response);
                    document.getElementById('titulo1').innerHTML="Subcontrato id "+id_subcontrato;
                    document.getElementById('ficha1').classList.add('mostrar');
                    document.getElementById('fondo').classList.add('mostrar');
                    break;
            }
        }});
    }

    function cerrarVentana() {
        document.getElementById('fondo').classList.remove('mostrar');
        document.getElementById('ficha1').classList.remove('mostrar');
    }  

    function guardarFicha1(salir){
        document.getElementById('aviso1').innerHTML='';
        document.getElementById('aviso1').classList.remove('avisoR');
        if (document.getElementById('id_pof').value==0 || document.getElementById('id_pof').value==''){
            document.getElementById('aviso1').innerHTML="Indique el Subcontrato (POF)!";
            document.getElementById('aviso1').classList.add('avisoR');
            return 0;
        }
        if (document.getElementById('id_proveedor').value==0 || document.getElementById('id_proveedor').value==''){
            document.getElementById('aviso1').innerHTML="Indique un Proveedor!";
            document.getElementById('aviso1').classList.add('avisoR');
            return 0;
        }    
        var parametros = {
            "accion": "GUARDAR1",
            "id_subcontrato": document.getElementById('id_subcontrato').value,
            "id_obra": id_obra,
            "id_pof": document.getElementById('id_pof').value,
            "subcontrato": document.getElementById('d_id_pof').innerHTML,
            "id_proveedor": document.getElementById('id_proveedor').value,
            "Condiciones": document.getElementById('Condiciones').value,
            "Observaciones": document.getElementById('Observaciones').value,
            "f_pof": document.getElementById('f_pof').value
        };
        document.getElementById('espera').style.display='block';
        $.ajax({ async:true, method: 'POST', url: 'obras_subcontratos2_sql.php',  data: parametros, success:  function (response) {
            document.getElementById('espera').style.display='none';
            switch (response.substr(0, 1)) {
                case "0":
                    document.location.href='login.php';
                    break;
                default: 
                    //if (response!="") {alert(response);}
                    document.getElementById('titulo1').innerHTML="Subcontrato id "+response;
                    document.getElementById('id_subcontrato').value=response;
                    if (salir==1) {cerrarVentana(); }
                    cargatabla();
                    break;
             }
        }});
    }

    function eliminarPregunta1(){
        document.getElementById('eliminarSi1').style.display = 'inline';
        document.getElementById('eliminarNo1').style.display = 'inline';
        document.getElementById('guardar1').style.display = 'none';
        document.getElementById('eliminar1').style.display = 'none';
        document.getElementById('cerrar1').style.display = 'none';
        document.getElementById('aviso1').innerHTML = 'Desea eliminar este Subcontrato?';
        document.getElementById('aviso1').classList.add('avisoR');
    }

    function eliNo1(){
        document.getElementById('aviso1').innerHTML = '';
        document.getElementById('aviso1').classList.remove('avisoR');
        document.getElementById('eliminarSi1').style.display = 'none';
        document.getElementById('eliminarNo1').style.display = 'none';
        document.getElementById('guardar1').style.display = 'inline';
        document.getElementById('eliminar1').style.display = 'inline';
        document.getElementById('cerrar1').style.display = 'inline';
    }

    function eliSi1(){
        document.getElementById('aviso1').innerHTML='';
        document.getElementById('aviso1').classList.remove('avisoR');
        var parametros = {
            "accion": "ELIMINAR1",
            "id_subcontrato": document.getElementById('id_subcontrato').value
        };
        
        document.getElementById('espera').style.display='block';
        $.ajax({ async:true, method: 'POST', url: 'obras_subcontratos2_sql.php',  data: parametros, success:  function (response) {
            document.getElementById('espera').style.display='none';
            switch (response.substr(0, 1)) {
                case "0":
                    document.location.href='login.php';
                    break;
                default: 
                    if (response!="") {alert(response);}
                    cerrarVentana();
                    cargatabla();
                    break;
             }
        }});
    }   


    //Buscar
    function buscar1(buscar){
       if (document.getElementById('buscar').value!=buscar){
            document.getElementById('filtro2').value="";
            document.getElementById('aviso2').innerHTML="";
        }
        document.getElementById('buscar').value=buscar;
        switch (buscar) {
            case 1: //Por POF
                document.getElementById('titulo2').innerHTML="Buscar POF";
                break;
            case 2: //por Proveedor
                document.getElementById('titulo2').innerHTML="Buscar Proveedor";
                break;
            case 3: //por Concepto
                document.getElementById('titulo2').innerHTML="Buscar Concepto del Proveedor";
                break;                
        }
        document.getElementById('ficha2').classList.add('mostrar');
        document.getElementById('fondo2').classList.add('mostrar');
    } 


    function buscar2(){
        var parametros = {
            "accion": "BUSCAR",
            "id_obra": id_obra,
            "filtro": document.getElementById('filtro2').value, 
            "buscar": document.getElementById('buscar').value,
            "id_proveedor": document.getElementById('id_proveedor').value
        };
        document.getElementById('espera').style.display='block';
        $.ajax({ async:true, method: 'POST', url: 'obras_subcontratos2_sql.php',  data: parametros, success:  function (response) {
            document.getElementById('espera').style.display='none';
            switch (response.substr(0, 1)) {
                case "0":
                    document.location.href='login.php';
                    break;
                default:
                    $("#aviso2").html(response);
                    break;
            }
        }});   
    }

    function buscar3(buscar, id, nombre, coste){
        switch (buscar) {
            case 1: //Por POF
                document.getElementById('d_id_pof').innerHTML=nombre;
                document.getElementById('id_pof').value=id;
                break;
            case 2: //por Proveedor
                document.getElementById('d_id_proveedor').innerHTML=nombre;
                document.getElementById('id_proveedor').value=id;
                break;
            case 3: //por Concepto
                document.getElementById('coste').innerHTML=coste;
                document.getElementById('d_ID_CONCEPTO').innerHTML=nombre;
                document.getElementById('ID_CONCEPTO').value=id;
                break;                
        } 
        document.getElementById('fondo2').classList.remove('mostrar');
        document.getElementById('ficha2').classList.remove('mostrar');
    }


    function cerrarVentana2() {
        document.getElementById('fondo2').classList.remove('mostrar');
        document.getElementById('ficha2').classList.remove('mostrar');
    }  


    //Unidad Subcontratada
    function ficha3(id){

        if (guardarFicha1(2)==0) {return 0;};

        var parametros = {
            "accion": "FICHA3",
            "id_obra": id_obra,
            "id_usc": id
        };
        document.getElementById('espera').style.display='block';
        $.ajax({ async:true, method: 'POST', url: 'obras_subcontratos2_sql.php',  data: parametros, success:  function (response) {
            document.getElementById('espera').style.display='none';
            switch (response.substr(0, 1)) {
                case "0":
                    document.location.href='login.php';
                    break;
                default:
                    $("#dataficha3").html(response);
                    document.getElementById('titulo3').innerHTML="Unidad Subcontratada id "+id;
                    document.getElementById('ficha3').classList.add('mostrar');
                    document.getElementById('fondo3').classList.add('mostrar');
                    break;
            }
        }});
    }


    function cerrarVentana3() {
        document.getElementById('fondo3').classList.remove('mostrar');
        document.getElementById('ficha3').classList.remove('mostrar');
    }  


    function guardarFicha3(){
        document.getElementById('aviso3').innerHTML='';
        document.getElementById('aviso3').classList.remove('avisoR');
        if (document.getElementById('ID_CONCEPTO').value==0 || document.getElementById('ID_CONCEPTO').value==''){
            document.getElementById('aviso3').innerHTML="Indique un concepto!";
            document.getElementById('aviso3').classList.add('avisoR');
            return 0;
        }
        if (document.getElementById('cantidad_max').value==0 || document.getElementById('cantidad_max').value==''){
            document.getElementById('aviso3').innerHTML="Indique la cantidad!";
            document.getElementById('aviso3').classList.add('avisoR');
            document.getElementById('cantidad_max').focus();
            return 0;
        }
        var parametros = {
            "accion": "GUARDAR3",
            "id_subcontrato": document.getElementById('id_subcontrato').value,
            "id_usc": document.getElementById('id_usc').value,
            "id_concepto": document.getElementById('ID_CONCEPTO').value,
            "cantidad_max": document.getElementById('cantidad_max').value,
            "precio_cobro": document.getElementById('precio_cobro').value,
            "Observaciones": document.getElementById('Observaciones').value
        };
        document.getElementById('espera').style.display='block';
        $.ajax({ async:true, method: 'POST', url: 'obras_subcontratos2_sql.php',  data: parametros, success:  function (response) {
            document.getElementById('espera').style.display='none';
            switch (response.substr(0, 1)) {
                case "0":
                    document.location.href='login.php';
                    break;
                default: 
                    if (response!="") {alert(response);}
                    cerrarVentana3();
                    ficha1(document.getElementById('id_subcontrato').value);
                    break;
             }
        }});
    }

    function eliminarPregunta3(){
        document.getElementById('eliminarSi3').style.display = 'inline';
        document.getElementById('eliminarNo3').style.display = 'inline';
        document.getElementById('guardar3').style.display = 'none';
        document.getElementById('eliminar3').style.display = 'none';
        document.getElementById('cerrar3').style.display = 'none';
        document.getElementById('aviso3').innerHTML = 'Desea eliminar esta Unidad Subcontratada?';
        document.getElementById('aviso3').classList.add('avisoR');
    }

    function eliNo3(){
        document.getElementById('aviso3').innerHTML = '';
        document.getElementById('aviso3').classList.remove('avisoR');
        document.getElementById('eliminarSi3').style.display = 'none';
        document.getElementById('eliminarNo3').style.display = 'none';
        document.getElementById('guardar3').style.display = 'inline';
        document.getElementById('eliminar3').style.display = 'inline';
        document.getElementById('cerrar3').style.display = 'inline';
    }

    function eliSi3(){
        document.getElementById('aviso3').innerHTML='';
        document.getElementById('aviso3').classList.remove('avisoR');
        var parametros = {
            "accion": "ELIMINAR3",
            "id_usc": document.getElementById('id_usc').value,
        };
        
        document.getElementById('espera').style.display='block';
        $.ajax({ async:true, method: 'POST', url: 'obras_subcontratos2_sql.php',  data: parametros, success:  function (response) {
            document.getElementById('espera').style.display='none';
            switch (response.substr(0, 1)) {
                case "0":
                    document.location.href='login.php';
                    break;
                default: 
                    if (response!="") {alert(response);}
                    cerrarVentana3();
                    ficha1(document.getElementById('id_subcontrato').value);
                    break;
             }
        }});
    }   

</script>

<?php include_once('../templates/_inc_privado3_footer.php'); ?>
