<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.0//EN"
"http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">

<html>
<title>Materials Map</title>
<meta charset="utf-8"></meta>
<head>
	<script src="https://code.jquery.com/jquery-3.1.1.js" type="text/javascript"></script>
  <script src="https://api.longdo.com/map/?key=xxxxxxxxxxxxxx" type="text/javascript"></script>
  <script src="html2canvas.js" type="text/javascript"></script>
	<!--<link type="text/css" href="<?php print $css; ?>" rel="stylesheet">-->
	<script type="text/javascript">
		var longdomap;
		$(document).ready(function() {
			longdomap = new longdo.Map({							// init map
					placeholder: document.getElementById("map")
			});

      /*
       * Uncomment if you want to hide all these controls

			longdomap.Ui.Fullscreen.visible(false);	// hide fullscreen mode
			longdomap.Ui.LayerSelector.visible(false);
			longdomap.Ui.Geolocation.visible(false);

			longdomap.Ui.Zoombar.visible(false);
			if (longdomap.Ui.Toolbar != null) {
				longdomap.Ui.Toolbar.visible(false);
			}
			if (longdomap.Ui.DPad != null) {
				longdomap.Ui.DPad.visible(false);
			}
			longdomap.Ui.Crosshair.visible(false);
      */

			//longdomap.Ui.Mouse.enableWheel(false);
			longdomap.Ui.Keyboard.enable(false);
				
		});
		
		function capture() {
      var contentToCapture = $("#map");
			var elementToHidden = contentToCapture.find(".ldmap_navigation, .ldmap_topleft");
			
			if (elementToHidden.length > 0) {
				elementToHidden.hide();
			}
			
			$("#capture-progress").show();
			
			html2canvas($(contentToCapture), {
				onrendered: function(canvas) {
					var imageBase64 = canvas.toDataURL("image/png");
					$.ajax({
							url: "captureImage.php",
							type: "POST",
							async: false,
							data: { image: imageBase64 },
							dataType: "json",
							success: function(data) {
								if (elementToHidden.length > 0) {
									elementToHidden.show();
								}

								if (data.status == "SUCCESS") {
                  $("#download").attr("href", data.filename)[0].click();
                } else {
									$("#download").attr("href", "#");
								}
								
								$("#capture-progress").hide();
								
								console.log(data);
							}
					});
				},
				logging: true,
				proxy: "proxy.php"	//,
				//useCORS: true
			});
    }
	</script>
</head>
<body>
  <div>
    <button id="export" onclick="capture();">Export map to image</button>
		<a id="download" href="#" style="display:none;" download></a>
    <p>
		<span style="margin-left: 10px; display: none; font-size: 11px;" class="loading" id="capture-progress">กำลังแนบภาพแผนที่</span>
  </div>
	<div id="map" style="height:97%;"></div>
</body>
</html>
