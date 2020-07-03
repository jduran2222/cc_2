<br><br>
<br>
<br>
<br>
<br>
<br><br>
<!--<div class='noprint'>footer</div>-->


<?php 
// ANULADO LOS IF, LO HACEMOS SIEMPRE, JUNIO2020
if  (1 or isset($_SESSION["is_desarrollo"]))    // lo hacemos para evitar unn ERROR que aparece en el LOGS de plesk
{
    if  (1 or !($_SESSION["is_desarrollo"]))    // solo pintamos el footer si somos VERSION EN PRODUCCION
{
?>    
    

<!--<div class="mainc noprint nomobile" style='position: fixed;  left: 0;  bottom: 0; height:40px; width: 100%;background-color: grey; color:white;align-content: center;width:100%;overflow:visible'>-->
<div class="mainc noprint " style='  background-color: grey; color:white;align-content: center;width:100%;overflow:visible'>
    <h5 align='center'><img width="32"  src="../img/logo_cc_blanco.svg"> &nbsp; &nbsp; ConstruCloud.es  &nbsp;&nbsp;&nbsp;
           <span class='c_text'>No dude en consultar cuestiones, realizar sugerencias o notificar errores. Se lo agradeceremos.&nbsp;&nbsp;&nbsp;
           </span>
          
           <button style='color:white' class='btn btn-link btn-xs noprint'  onclick="window.open('../menu/contactar.php')">
            <i class="far fa-envelope"></i>
            <span class='c_text'> contactar </span>
           </button>    
        email : <a style='color:white'   href="mailto:soporte@construcloud.es?Subject=Notificación ConstruCloud.es" target="_top">soporte@construcloud.es</a>
       </h5> 
</div> 
             
<?php  
 }
}

if (isset($_SESSION["adminlte"]) AND $_SESSION["adminlte"]) {require_once("../adminlte/adminlte_footer.php");}

//require_once("../adminlte/adminlte_footer.php");

?>     
    