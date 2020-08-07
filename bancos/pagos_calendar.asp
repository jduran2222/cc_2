<%@ Language=VBScript %>
<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Pagos Calendario';

//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');

?>

        <!-- Contenido principal -->
        <div class="container-fluid bg-light">
            <div class="row">
                <!--****************** ESPACIO LATERAL  *****************-->
                <div class="col-12 col-md-4 col-lg-3"></div>
                <!--****************** ESPACIO LATERAL  *****************-->

                <!--****************** BUSQUEDA GLOBAL  *****************-->
                <div class="col-12 col-md-4 col-lg-9">
<SCRIPT LANGUAGE=VBScript RUNAT=SERVER >

   Function iif(condicion,v1,v2)
     if condicion then
       iif=v1
      else
       iif=v2
     end if
   End Function
   
  Function chk(vCheckBox)
     chk = (vCheckBox="checked")
   End Function


</SCRIPT>
<%if session("logado") = "0" then
	Response.Redirect("cerrar_sesion.asp")
end if%>

<div align=center class="encabezadopagina2">Calendario de Pagos</div>
<FONT size=1><%= Request.ServerVariables("SCRIPT_NAME")%> --  <% =now %> </FONT>
<!-- #INCLUDE File="menu.inc" --> 
<HR  size="2" width="95%" color="#990000">

<% fecha0=CDate(Request.QueryString("fecha")) %>
<%
if Request.QueryString("fecha")="" then
   fecha0=CDate(date)    
end if

fecha=cdate("01-"& Month(fecha0)&"-"& Year(fecha0))

 fecha1=fecha-WeekDay(fecha,vbMonday)+1
 fecha2=cdate("01-"& Month(fecha+31)&"-"& Year(fecha+31))-1 
 fecha2=fecha2+7-WeekDay(fecha2,vbMonday)
 
 cFecha1="'" & fecha1 & "'"
 cFecha2="'" & fecha2 & "'"


%>
<!-- #INCLUDE File="conexion.inc" --> 
<%
'Conn.Open "Provider=SQLOLEDB;Data Source=ing0;Initial Catalog=multi4;User ID=sa;PassWord="


sQL="SELECT * FROM PAGOSC WHERE " &_
    "     [f_vto]>="& cFecha1 &_ 
    " AND [f_vto]<="& cFecha2 &_
    " ORDER BY [f_vto], [id_cta_banco]"

set rs=Conn.Execute( SQL )  %>

<% chkDetalles=Request.form("chkDetalles") %>
<% Detalles=iif( chk(chkDetalles) , 1 , 0) %>

<% chkDetallesC=Request.form("chkDetallesC") %>
<% DetallesC=iif( chk(chkDetallesC) , 1 , 0) %>

<font size=2>
<br>
<FORM action="pagos_calendar.asp?fecha=<% =fecha0 %>" method=POST id=form1 name=form1>

  <input type="checkbox" name="chkDetallesC" value="checked" <%=chkDetallesC%> >Bancos<br>
  <input type="checkbox" name="chkDetalles" value="checked" <%=chkDetalles%> >Movimientos<br>
  <INPUT type="submit" value="actualizar" id=submit1 name=submit1> 

</FORM>
</font>

<TABLE border=1 align=center width=93% cellpadding=3>
   <TR>
     <TD><font size=5><A HREF="pagos_calendar.asp?fecha=<% =fecha1-1 %>"> anterior </A></font> </TD>
     <TD  bgcolor=Silver nowrap colspan=5 align=center><font size=7><% =MonthName(Month(fecha))&"-"&Year(fecha) %></font>&nbsp;</TD>
     <TD align=right><font size=5><A HREF="pagos_calendar.asp?fecha=<% =fecha2+1 %>"> siguiente </A></font> </TD>
   </TR>
   <TR  height=50> 
	    <TD align=center width=17%>L</TD>
	    <TD align=center width=17%>M</TD>
	    <TD align=center width=17%>X</TD>
	    <TD align=center width=17%>J</TD>
	    <TD align=center width=17%>V</TD>
	    <TD align=center  color=red bgcolor=LightPink>S</TD>
	    <TD align=center  color=red bgcolor=LightPink>D</TD>
       </TR>

<TR> 
<%cont=0%>
<% f_hoy=date %>
<% mes=Month(fecha) %>
 <% For f = fecha1 to fecha2 %> 
   <% cont=cont+1 %>
   <% if f=f_hoy then
	      color_fondo="yellow"
      elseif Month(f)<>mes then
    	  color_fondo="Silver"
      else
	      color_fondo="white"
     end if
   %>
   <TD valign=top nowrap bgcolor=<% =color_fondo%> ><font face=Arial size=3><% =Day(f) %><br></font>
	<% if not rs.EOF then %>
       <% suma=0 %>
       <% sumaB=0 %>
       <% sumaRojo=0 %>
       <% sumapagado=0 %>
       <% sumapdte=0 %>
       <% sumaIngresos=0 %>
       <% sumaIngresosPdte=0 %>
       <% id_cta_banco=rs.Fields("id_cta_banco") %>
       <% banco=rs.Fields("banco") %>

       <% Do while rs.Fields("f_vto")=f  %>
          <% if id_cta_banco=rs.Fields("id_cta_banco") then %>
	        <% sumaB=sumaB+ rs.fields("importe") %>
    	  <% else 'Ponemos subtotal de banco si es <> 0 %>
        	  <% if sumaB<>0 and DetallesC then %>
                 <font face=Arial size=1 color=blue> <%=Banco%>: <%=formatcurrency(sumaB)%><br><br></font>   
	       	  <% end if %>
            <% id_cta_banco=rs.Fields("id_cta_banco") %>
            <% sumaB= rs.fields("importe") %>
            <% banco=rs.Fields("banco") %>
          <% end if %>
		  
		  <% if Isnull(rs.fields("id_mov_banco")) then %>
		  	<% sumapdte=sumapdte+ rs.fields("importe") %>
			<% sumaIngresosPdte=sumaIngresosPdte+ rs.fields("ingreso") %>
		   <% else %>
		  	<% sumapagado=sumapagado+ rs.fields("importe") %>
		    <% sumaIngresos=sumaIngresos+ rs.fields("ingreso") %>
          <% end if %>
		  
		  <% if Detalles then %>
                     <% noEsPago=(not rs.fields("tipo_pago")="P ") %> 
            <font face=Arial size=1 color=<%=iif(Isnull(rs.fields("id_mov_banco")),"black",iif(noEsPago, "green","red"))%>>
		    <% =iif( noEsPago,"............",formatcurrency(rs.fields("importe")))%> 
		    <A HREF="pagos_ficha.asp?id_pago=<% =rs.fields("ID_PAGO")%>"><%= rs.fields("OBSERVACIONES") %></A><% =iif( noEsPago,"..." + formatcurrency(rs.fields("ingreso")),"")%>  <br></font> 
          <% end if %> 
           <% suma=suma+ rs.fields("importe") %>

        <% rs.MoveNext %>
        <% if rs.EOF then 
              Exit Do 
            end if %>
    	<% Loop %>
       <% if suma<>0 then %>
        	  <% if sumaB<>0 and DetallesC then %>
                 <font face=Arial size=1 color=blue> <%=Banco%>: <%=formatcurrency(sumaB)%><br><br></font>   
	       	  <% end if %>
        	  <% if Detalles or DetallesC then %>
		        <font face=Arial size=1 color=blue>----------<br></font> 
	       	  <% end if %>
	    	  <% if sumapagado<>0 then %>
		        <font face=Arial size=1 color=red>Cargado cta: <%=formatcurrency(sumapagado)%></font> 
         	  <% end if %>
        	  <% if sumapdte<>0 then %>
                <font face=Arial size=1 color=black><br>pdte pago: <%=formatcurrency(sumapdte)%></font> 
	       	  <% end if %>
      <% end if %>
   	  <% if sumaIngresos<>0 then %>
              <font face=Arial size=1 color=green align=right><br>.................Ingresado: <%=formatcurrency(sumaIngresos)%></font> 
	  <% end if %>
   	  <% if sumaIngresosPdte<>0 then %>
              <font face=Arial size=1 color=magenta><br>.................Pdte Ingreso: <%=formatcurrency(sumaIngresosPdte)%></font> 
	  <% end if %>


    <% end if %>
   </TD>
   <%
    if cont=7 and f<>fecha2 then   'cambio de semana
       cont=0
       Response.Write "</TR><TR height=80>"
    end if
   %>  
   
 <% next %> 
  
</TABLE>

<%
rs.close
set rs=Nothing
Conn.close
set Conn=nothing
%>

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');