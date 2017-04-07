<!DOCTYPE>
<html>
<head>

<script type="text/javascript" src="book/pdf.js"></script>

</head>
<body>
<canvas id="the-canvas" width="500" height="200"></canvas>
<script type="text/javascript">
 var url = 'http://www.mnerva.ca/uploads/L0d0WN2EIW.pdf';
 window.onload=function(){
	 PDFJS.disableWorker = true;
	 PDFJS.getDocument(url).then(function(pdf) {
		 pdf.getPage(1).then(function(page) {
            var scale = 1.5;
			var viewport = page.getViewport(scale);
			var canvas = document.getElementById('the-canvas');
			var context = canvas.getContext('2d');
			canvas.height = viewport.height;
			canvas.width = viewport.width;

			var renderContext = {
			  canvasContext: context,
			  viewport: viewport
			};
			page.render(renderContext);
		});
	 });
 }
</script>
</body>
</html>