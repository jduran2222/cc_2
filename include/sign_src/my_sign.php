<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>jQuery Signature Pad & Canvas Image</title>
		<link href="./css/jquery.signaturepad.css" rel="stylesheet">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="./js/numeric-1.2.6.min.js"></script> 
		<script src="./js/bezier.js"></script>
		<script src="./js/jquery.signaturepad.js"></script> 
		
		<script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
		<script src="./js/json2.min.js"></script>
		
		
		<style type="text/css">
			
			
			#signArea{
				width:608px;
				margin: 50px auto;
			}
			.sign-container {
				width: 60%;
				margin: auto;
			}
			.sign-preview {
				width: 150px;
				height: 50px;
				border: solid 1px #CFCFCF;
				margin: 10px 5px;
			}
			
		</style>
	</head>
	<body>

		<h2>Learn Infinity | jQuery Signature Pad & Canvas Image</h2>
		
		<div id="signArea" >
			<h2 >Put signature below,</h2>
			<div class="sig sigWrapper" style="height:auto;"> 
				<div class="typed"></div>
				<canvas class="sign-pad" id="sign-pad" width="600" height="300"></canvas>
			</div>
		</div>
		
        <center><button  id="btnSaveSign">Save Signature</button></center>
		
		<div class="sign-container">
		<?php
		$image_list = glob("./doc_signs/*.png");
		foreach($image_list as $image){
//			echo $image;
		
		echo "<img src='$image' class='sign-preview' />" ;
		
		
		}
		?>
		</div>
		
		
		<script>
			$(document).ready(function() {
				$('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:0});
			});
			
			$("#btnSaveSign").click(function(e){
				html2canvas([document.getElementById('sign-pad')], {
					onrendered: function (canvas) {
						var canvas_img_data = canvas.toDataURL('image/png');
						var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
						//ajax call to save image inside folder
						$.ajax({
							url: 'save_sign.php',
							data: { img_data:img_data },
							type: 'post',
							dataType: 'json',
							success: function (response) {
							   window.location.reload();
							}
						});
					}
				});
			});
		  </script> 
		

	</body>
</html>
