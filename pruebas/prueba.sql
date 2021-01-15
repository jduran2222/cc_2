<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Select X.ID_OBRA, X.id_produccion_obra, X.activa, X.NOMBRE_OBRA, X.GRUPOS,
  ' ' As ID_TH_COLOR, Sum(X.importe_prod) As importe_prod, Sum(X.gasto_real) As
  gasto_real, Sum(X.importe_prod) - Sum(X.gasto_real) As benef_real, 1 -
  Sum(X.gasto_real) / Sum(X.importe_prod) As margen_real, ' ' As ID_TH_COLOR1,
  ' ' As ID_TH_COLOR2, Sum(X.gasto_est) As gasto_est, Sum(X.benef_est)
  As benef_est, 1 - Sum(X.gasto_est) / Sum(X.importe_prod) As margen_est,
  ' ' As ID_TH_COLOR3, Sum(X.PLAN) As PLAN, Sum(X.VENTAS) As VENTAS,
  Sum(X.GASTOS_EX) As GASTOS_EX, Sum(X.VENTAS) - Sum(X.GASTOS_EX) As Beneficio,
  (Sum(X.VENTAS) - Sum(X.GASTOS_EX)) / Sum(X.VENTAS) As Margen, Sum(X.Facturado)
  As Facturado, Sum(X.Facturado_iva) As Facturado_iva, Sum(X.Pdte_Cobro) As
  Pdte_Cobro
From ((Select ConsultaProd.ID_OBRA, ConsultaProd.id_produccion_obra,
      ConsultaProd.activa, ConsultaProd.NOMBRE_OBRA, ConsultaProd.GRUPOS,
      Sum(ConsultaProd.importe) * ConsultaProd.COEF_BAJA * (1 +
      ConsultaProd.GG_BI) As importe_prod, Sum(ConsultaProd.gasto_est)
      As gasto_est, Sum(ConsultaProd.importe) * ConsultaProd.COEF_BAJA * (1 +
      ConsultaProd.GG_BI) - Sum(ConsultaProd.gasto_est) As benef_est, 1 -
      Sum(ConsultaProd.gasto_est) / (Sum(ConsultaProd.importe) *
      ConsultaProd.COEF_BAJA * (1 + ConsultaProd.GG_BI)) As margen_est,
      0 As gasto_real, 0 As PLAN, 0 As VENTAS, 0 As GASTOS_EX, 0 As Facturado,
      0 As Facturado_iva, 0 As Pdte_Cobro
    From ConsultaProd
    Where ConsultaProd.activa = 1 And ConsultaProd.GRUPOS Like '%prueba%' And
      ConsultaProd.id_c_coste = 1 And
      'O' Like Concat('%', ConsultaProd.tipo_subcentro, '%') And 1 = 1
      And Date_Format(ConsultaProd.Fecha, '%Y-%m') = '2020-05' And
      ConsultaProd.ID_PRODUCCION = ConsultaProd.id_produccion_obra
    Group By ConsultaProd.ID_OBRA
    Order By )
    UNION All
    (Select ConsultaGastos_View.ID_OBRA, ConsultaGastos_View.id_produccion_obra,
      ConsultaGastos_View.activa, ConsultaGastos_View.NOMBRE_OBRA,
      ConsultaGastos_View.GRUPOS, 0 As importe_prod, 0 As gasto_est,
      0 As benef_est, 0 As margen_est, Sum(ConsultaGastos_View.IMPORTE) As
      gasto_real, 0 As PLAN, 0 As VENTAS, 0 As GASTOS_EX, 0 As Facturado,
      0 As Facturado_iva, 0 As Pdte_Cobro
    From ConsultaGastos_View
    Where ConsultaGastos_View.activa = 1 And ConsultaGastos_View.GRUPOS Like
      '%prueba%' And ConsultaGastos_View.id_c_coste = 1 And 'O' Like Concat('%',
      ConsultaGastos_View.tipo_subcentro, '%') And 1 = 1 And
      Date_Format(ConsultaGastos_View.FECHA, '%Y-%m') = '2020-05'
    Group By ConsultaGastos_View.ID_OBRA
    Order By ConsultaGastos_View.NOMBRE_OBRA)
    UNION All
    (Select Ventas_View.ID_OBRA, Ventas_View.id_produccion_obra,
      Ventas_View.activa, Ventas_View.NOMBRE_OBRA, Ventas_View.GRUPOS,
      0 As importe_prod, 0 As gasto_est, 0 As benef_est, 0 As margen_est,
      0 As gasto_real, Sum(Ventas_View.PLAN) As PLAN, Sum(Ventas_View.IMPORTE)
      As VENTAS, Sum(Ventas_View.GASTOS_EX) As GASTOS_EX, 0 As Facturado,
      0 As Facturado_iva, 0 As Pdte_Cobro
    From Ventas_View
    Where Ventas_View.activa = 1 And Ventas_View.GRUPOS Like '%prueba%' And
      Ventas_View.id_c_coste = 1 And
      'O' Like Concat('%', Ventas_View.tipo_subcentro, '%') And 1 = 1 And
      Date_Format(Ventas_View.Fecha, '%Y-%m') = '2020-05'
    Group By Ventas_View.ID_OBRA
    Order By Ventas_View.NOMBRE_OBRA)
    Order By ConsultaProd.NOMBRE_OBRA) X
Group By X.ID_OBRA
Order By X.NOMBRE_OBRA