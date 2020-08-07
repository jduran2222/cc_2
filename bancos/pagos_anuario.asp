<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Pagos anuarios';

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

<div align=center class="main"><h1>Anuario de Pagos e Ingresos</h1></div>


<?php	

/* VARIABLES

Dim MesTxt(11)

MesTxt(0)="Enero"
MesTxt(1)="Febrero"
MesTxt(2)="Marzo"
MesTxt(3)="Abril"
MesTxt(4)="Mayo"
MesTxt(5)="Junio"
MesTxt(6)="Julio"
MesTxt(7)="Agosto"
MesTxt(8)="Septiembre"
MesTxt(9)="Octubre"
MesTxt(10)="Noviembre"
MesTxt(11)="Diciembre"
*/




$fecha0= isset($_GET["fecha"]) ? $_GET["fecha"] :date("Y-m-d") ;



 fecha=cdate("01-"& Month(fecha0)&"-"& Year(fecha0))
 
 fecha1=cdate("01-01-" & Year(fecha))
 fecha2=cdate("01-01-" & Year(fecha)+1)-1
 
 
 cFecha1= "'" & fecha1 & "'"
 cFecha2= "'" & fecha2 & "'"


 Importe_min=Request.form("Importe_min") 
 Tipo_doc=Request.form("tipo_doc") 
 Importe_min=iif(importe_min="", 0.00, importe_min  + 0.00) 
 
 Tipo_cta = request("tipo_cta")


 if request("tipo_cta")<>"" then    tipo_cta = request("tipo_cta")

 if request("mostrar_detalles")="" then  
 	mostrar_detalles = false
 else
 	mostrar_detalles = true		'Por defecto se muestran los detalles.
 end if



 saldof = iif( request("saldof") <> "", request("saldof"), 0 )

 set rs=Conn.Execute("SELECT * FROM Bancos_saldos WHERE tipo LIKE '%" + tipo_cta + "%' ORDER BY tipo")

'  TABLA DE SALDOS

%>

<FORM action="pagos_anuario.asp?fecha=<% =fecha0 %>" method=POST id=form1 name=form1>

  Importe minimo:<input type="text" name="Importe_min" value=<%=Importe_min%> ><br>
  Tipo doc pago:<input type="text" name="tipo_doc" value=<%=tipo_doc%> ><br>
  Tipo cuenta:<input type="text" name="tipo_cta" value=<%=tipo_cta%> ><br>
  Saldo disponible en Enero:<input type="text" name="saldof" value=<%=saldof%> ><br>

  Mostrar detalles días:<input type="checkbox" name="mostrar_detalles" value="1" 
  <% if mostrar_detalles then response.write "checked" %>
  ><br>

   <INPUT type="submit" value="actualizar" id=submit1 name=submit1> 

</FORM>

<p align=center><font size=4 align=center color=silver>Saldos Bancos</font></p>
<TABLE border=1 align=center bordercolor=Silver cellspacing="0" style="border-collapse: collapse; font-size:10px; font-family:Arial" cellpadding="3">


<% suma_tipo=0 %>
<% suma_tipo_dto=0 %>

<% tipo0="" %>
<% title_banco="---------- Saldos ---------" %>
<% title_banco_dto="---------- Límite Crédito ----------" %>
<% title_disponible="------- Crédito Disponible -------" %>

<tr bgcolor=silver align=centar><td>Tipo Cuenta</td><td>Saldo</td><td>Límite Credito</td><td>Credito disponible</td></tr>

<% while not rs.EOF %> 
 <% tipo1=rs.fields("tipo") %>
 
   <% if tipo0<>tipo1 then %>
       <% if tipo0<>"" then %>
          <tr><td><% =tipo0 %></td><td align=right title='<%=title_banco%>'><% =formatoMoneda(suma_tipo) %>&nbsp;</td><td align=right title='<%=title_banco_dto%>'><% =formatoMoneda(suma_tipo_dto) %>&nbsp;</td><td align=right title='<%=title_disponible%>'><% =iif(suma_tipo_dto<>0,formatoMoneda(suma_tipo_dto+suma_tipo),"-") %>&nbsp;</td></tr>

          <% suma_tipo=0 %>
          <% suma_tipo_dto=0 %>
          <% title_banco="---------- Saldos ----------" %>
          <% title_banco_dto="---------- Límite Crédito ----------" %>
          <% title_disponible="------- Crédito Disponible -------" %>

       <% end if %>
      <% tipo0=tipo1 %>
     
   <% end if %>
   <% suma_tipo=suma_tipo+rs.fields("Saldo") %>
   <% suma_tipo_dto=suma_tipo_dto+rs.fields("limite_dto") %>
   <% title_banco=title_banco+chr(13)+rs.fields("banco")+formatoMoneda(rs.fields("Saldo")) %>
   <% title_banco_dto=title_banco_dto+chr(13)+rs.fields("banco")+formatoMoneda(rs.fields("limite_dto")) %>
   <% title_disponible=title_disponible+chr(13)+rs.fields("banco")+formatoMoneda(iif(rs.fields("limite_dto")<>0 and rs.fields("limite_dto")>rs.fields("saldo"),rs.fields("limite_dto")+rs.fields("saldo"),0) ) %>

 
  <% rs.movenext %>
 <% wend %> 
          <tr><td><% =tipo0 %></td><td align=right title='<%=title_banco%>'><% =formatoMoneda(suma_tipo) %>&nbsp;</td><td align=right title='<%=title_banco_dto%>'><% =formatoMoneda(suma_tipo_dto) %>&nbsp;</td><td align=right title='<%=title_disponible%>'><% =iif(suma_tipo_dto<>0,formatoMoneda(suma_tipo_dto+suma_tipo),"-") %>&nbsp;</td></tr>

</TABLE>


<%

rs.close
set rs=Nothing

sQL="SELECT * FROM PAGOSC WHERE " &_
    "      [f_vto]>="& cFecha1 &_ 
    " AND  [f_vto]<="& cFecha2 &_
    " AND tipo_doc LIKE '%" & tipo_doc & "%' " &_
	" AND tipo LIKE '%" & tipo_cta & "%' " &_
	" ORDER BY [f_vto]"

set rs=Conn.Execute( SQL )

dim sumadia(32)


 %>


<p align=center><font size=4 align=center>Calendario de Pagos e Ingresos</font></p>

<TABLE border="1" align="center" bordercolor="Silver" cellspacing="0" style="border-collapse: collapse; font-size:10px; font-family:Arial" cellpadding="0">   <TR>
     <TD colspan="2" align="center"><font size=5><A HREF="pagos_anuario.asp?fecha=<% =fecha1-1 %>&tipo_cta=<% =tipo_cta %>"> anterior </A></font> </TD>
     <TD colspan="2" bgcolor=Silver align=center><font size=7><% =Year(fecha) %></font>&nbsp;</TD>
     <TD colspan="2" align="center"><font size=5><A HREF="pagos_anuario.asp?fecha=<% =fecha2+1 %>&tipo_cta=<% =tipo_cta %>"> siguiente </A></font> </TD>
   </TR>
<TR> 
<%cont=0%>
<% mes_hoy=Month(date) %>
<% mes=Month(fecha) %>
 <% For m = 1 to 12  
    'Inicializo las sumas diarias de pagos
    for n=1 to 31
     sumadia(n)=0
    next 
    cont=cont+1 %>

	 <TD valign=top nowrap bgcolor=<% =iif(m=mes_hoy,"yellow","white")%> ><font face=Arial size=4><a href=<% ="pagos_calendar.asp?fecha=01/" & m &"/" & Year(fecha1)  %> title='Calendario mes'> <% =MesTxt(m-1) %></a> <br></font>
      <% if not rs.EOF then %>
        <% suma=0 %>
        <% suma_pdte=0 %>
        <% sumaI=0 %>
        <% sumaI_pdte=0 %>
		<% negociados=0 %>

       <%  Do while Month(rs.Fields("f_vto"))=m  %>

			<%	suma = suma + iif(Isnull(rs.fields("id_mov_banco")),0,rs.fields("importe")) 								'Pagos  %>
			<%	suma_pdte = suma_pdte + iif(Isnull(rs.fields("id_mov_banco")),formatoNumero(rs.fields("importe")),0) 	'Pagos_Pdtes  %>
			 
			<% 	sumaI = sumaI + iif(Isnull(rs.fields("id_mov_banco")),0,formatoNumero(rs.fields("ingreso"))) 			'Ingresos  %>
			<%  if rs.fields("negociado") then %>
			<%		negociados = negociados + iif(Isnull(rs.fields("id_mov_banco")),formatoNumero(rs.fields("ingreso")),0) 	'Ingresos_Negociados   %>
			<%	else %>
			<%		 sumaI_pdte = sumaI_pdte + iif(Isnull(rs.fields("id_mov_banco")),formatoNumero(rs.fields("ingreso")),0) 	'Ingresos_Pdtes  %>
			<%	end if %>

			<%	sumadia(Day(rs.Fields("f_vto"))) = sumadia(Day(rs.Fields("f_vto")))+ iif(Isnull(rs.fields("id_mov_banco")),formatoNumero(rs.fields("importe")),0) %>

          <% rs.MoveNext %>
           <% if rs.EOF then %>
             <% Exit Do %>
           <% end if %>
       <% Loop %>

	   <% if mostrar_detalles then %>
		   <% for n=1 to 31				'''''''''''''''''''	DÍAS %>
			   <% if sumadia(n)<>0 and sumadia(n) >= (Importe_min) then %>
				<% diaTxt= n & "-" & m & "-" & year(fecha1) %>            
				<a href=<% ="tabla.asp?tabla=PAGOSC&wherecond=f_vto='" & diaTxt &"'%20AND%20tipo%20LIKE%20'*"& tipo_cta & "*'%20AND%20conc=0"  %> target=_blank> <%="Dia " & n & "...  " & formatoMoneda(sumadia(n)) %></a><br> 
			   <% end if %>
		   <% next %>
	   <% end if %>
    

	   <br>Pagos_pdtes...
       <% if suma_pdte<>0 then 		'''''''''''''''''' PAGOS_PDTES %>
              <%=formatoMoneda(suma_pdte)%><a href=<% ="tabla.asp?tabla=PAGOSC&wherecond=mes_vto=" & m & "%20AND%20ano_vto=" & year(fecha1) & "%20AND%20tipo_pago='P'%20AND%20tipo%20LIKE%20'*"& tipo_cta & "*'%20AND%20conc=0" %> target=_blank >  ver</a>  
       <% end if %>
	   <font face=Arial size=1 color=red><br>Pagado....
       <% if suma<>0 then 			'''''''''''''''''' PAGOS %>
             <%= formatoMoneda(suma) %></font> <a href=<% ="tabla.asp?tabla=PAGOSC&wherecond=mes_vto=" & m & "%20AND%20ano_vto=" & year(fecha1) & "%20AND%20tipo_pago='P'%20AND%20tipo%20LIKE%20'*"& tipo_cta & "*'%20AND%20conc%3E0" %> target=_blank >  ver</a> 
       <% end if %>

	   <font color=blue><br><br>Ingresos_pdtes...  
       <% if sumaI_pdte<>0 then 	'''''''''''''''''' INGRESOS_PDTES %>
            <%=formatoMoneda(sumaI_pdte)%><a href=<% ="tabla.asp?tabla=PAGOSC&wherecond=mes_vto=" & m & "%20AND%20ano_vto=" & year(fecha1) & "%20AND%20tipo_pago='C'%20AND%20tipo%20LIKE%20'*"& tipo_cta & "*'%20AND%20conc=0%20AND%20negociado=0" %> target=_blank >  ver</a>  </font> 
		<% elseif isnull(sumaI_pdte) then %>
			<% sumaI_pdte = 0%>
       <% end if %>

	   <font color="#CC6699"><br>Negociados...  
       <% if negociados<>0 then 	'''''''''''''''''' NEGOCIADOS %>
            <%=formatoMoneda(negociados)%><a href=<% ="tabla.asp?tabla=PAGOSC&wherecond=mes_vto=" & m & "%20AND%20ano_vto=" & year(fecha1) & "%20AND%20tipo_pago='C'%20AND%20tipo%20LIKE%20'*"& tipo_cta & "*'%20AND%20conc=0%20AND%20negociado%3C%%3E%0" %> target=_blank >  ver</a>  </font> 
		<% elseif isnull(negociados) then %>
			<% negociados = 0%>
       <% end if %>

	   <font color=green><br>Ingresado...
       <% if sumaI<>0 then				'''''''''''''' INGRESOS %>
            <%= formatoMoneda(sumaI) %><a href=<% ="tabla.asp?tabla=PAGOSC&wherecond=mes_vto=" & m & "%20AND%20ano_vto=" & year(fecha1) & "%20AND%20tipo_pago='C'%20AND%20tipo%20LIKE%20'*"& tipo_cta & "*'%20AND%20conc%3E0" %> target=_blank >  ver</a> </font> 
       <% end if %>
	   
       <% if saldof<>0 then 			''''''''''''''''''' SALDOF %>
            <% saldof=saldof-suma_pdte+sumaI_pdte %>
            <font color=<% =iif(saldof<0,"magenta","black") %> ><br><br>_________________<br>Saldo.....<%= formatoMoneda(saldof) %></font> 
       <% end if %>
		<br>&nbsp;

    <% end if 'Fin rs.EOF %>
   </TD>
    <% if m=6 then %>
       </TR><TR>
    <% end if %>  

    <% if cont=30 then ' 3 columnas por tabla ****** ANULADO  *******
		  cont=0  %> </TR>
    <TR>
    <% end if %>  
 <% next  'For %> 
  
</TABLE>

<%	rs.close
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

