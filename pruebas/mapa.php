<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=ISO-8859-1">
<title>Ejemplo de Google Maps API</title>
<script src="https://maps.google.com/maps?file=api&v=2&key=AIzaSyDb9oymjp0-wXYwc_MYnh-JE7vnXogJGio" type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[
function load() {
   if (GBrowserIsCompatible()) {
      var map = new GMap2(document.getElementById("map"));   
      map.setCenter(new GLatLng(40.41689826118782,-3.7034815549850464), 17);   
      map.addControl(new GLargeMapControl());
      map.setMapType(G_SATELLITE_MAP);
   
      var point = new GPoint (-3.7034815549850464, 40.41689826118782);
      var marker = new GMarker(point);
      map.addOverlay(marker);
   }
}
//]]>
</script>
</head>
<body onload="load()" onunload="GUnload()">
<div id="map" style="width: 615px; height: 400px"></div>
HOLA
</body>
</html>