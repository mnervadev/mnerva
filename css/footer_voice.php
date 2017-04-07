  <script src="https://code.responsivevoice.org/1.5/responsivevoice.js"></script>
  <script src="jquery.js"></script>

  <script src="../js/slick.js" type="text/javascript" charset="utf-8"></script>
  <script src='../js/lightsoff.js'></script>
  <script src="../js/slider.min.js"></script>
  <script src="../js/quill.core.js"></script>
  <script src="../js/quill.min.js"></script>
  <!--script src="https://rawgithub.com/mozilla/pdf.js/gh-pages/build/pdf.js"></script-->
  <script src="../js/pdf-js/build/pdf.js"></script>
  <script src="../js/main.min.js"></script>
  <script src="../js/functions.js"></script>

 <script type='text/javascript'>
	$(document).ready(function() {
	});
	 
    //for auto resizing full_screen iframe
    $(function(){
    
        var iFrames = $('iframe');
      
    	function iResize() {
    	
    		for (var i = 0, j = iFrames.length; i < j; i++) {
    		  iFrames[i].style.height = iFrames[i].contentWindow.document.body.offsetHeight + 'px';}
    	    }
    	    
        	if ($.browser.safari || $.browser.opera) { 
        	
        	   iFrames.load(function(){
        	       setTimeout(iResize, 0);
               });
            
        	   for (var i = 0, j = iFrames.length; i < j; i++) {
        			var iSource = iFrames[i].src;
        			iFrames[i].src = '';
        			iFrames[i].src = iSource;
               }
               
        	} else {
        	   iFrames.load(function() { 
        	       this.style.height = this.contentWindow.document.body.offsetHeight + 'px';
        	   });
        	}
        
        });
  </script> 

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script src="http://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <script src="../js/sticky.js"></script>
  <script src="../js/highlight.js"></script>

  <script src="turn.js"></script>
  <script src="ion.rangeSlider.js"></script>
  
	<!--  scripts for new pdf viewer   -->
 <script>
	function load_storage(){
	  // var aaa = localStorage.length;
	var retrievedObject = localStorage.getItem('page__num');
	console.log('page__num: ', JSON.parse(retrievedObject));

	for(var i=1;i<retrievedObject;i++){
		console.log(i);
		$('.fa-chevron-right').trigger('click')

	}
}

</script>

<script>
	 var adcounter = 1;
  var night_counter = 1;
  var page_counter = 1;
  var start=1;
  var flip_counter = 1;

	var show = 1;

	$('.btn_1').click(function(){
		if(show%2!==0){
		    $('.nav-bar').addClass('go-away');
			$('#slidepdf').addClass('go-away');
			$('#pdf').removeClass('go-away');
			show++
		$('#go-small').css('visibility','visible');

		}
	});
	$('#go-small').click(function(){
		$('#pdf').addClass('go-away');
		$('#slidepdf').removeClass('go-away');
		$('.nav-bar').removeClass('go-away');
		$('#go-small').css('visibility','hidden');
		show++
	})
</script>

<?php
function count_pages($pdfname) {
      $pdftext = file_get_contents($pdfname);
      $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
      return $num;
    }


 ?>


<script type="text/javascript">
$(document).ready(function() {
        $('#stop').hide();

        $('#play').click(function() {
        $('#play').hide();
        $('#stop').show();
    });

    $('#stop').click(function() {
        $('#play').show();
        $('#stop').hide();
    });
});
</script>

<script id="my_script" type="text/javascript">

	// Sample using dynamic pages with turn.js

	var numberOfPages = 0;
    var url = '../' + document.location.href.split("?q=")[1];
	var rendered = [];
	var firstPagesRendered = false;
	var num_of_pages;

    var pdf = null,
        pageNum = 1,
        global_scale = 0.6;

    function renderPage(num) {

	    pdf.getPage(num).then(function(page) {
			var scale = global_scale;
			var viewport = page.getViewport(scale);
			// console.log(page);
			//
			// Prepare canvas using PDF page dimensions
			//
			var canvasID = 'canv' + num;
			var canvas = document.getElementById(canvasID);
			if (canvas == null) return;
			var context = canvas.getContext('2d');
			canvas.height = viewport.height;
			canvas.width = viewport.width;

			//
			// Render PDF page into canvas context
			//
			var renderContext = {
			  canvasContext: context,
			  viewport: viewport
			};
			page.render(renderContext);

			// Update page counters
			document.getElementById('page-number').textContent = pageNum;
			document.getElementById('number-pages').textContent = pdf.numPages;
			num_of_pages = <?php echo count_pages("../".$_GET['q']); ?>;
			// console.log(num_of_pages);
			load_page_slider();
			
			//page.getTextContent().then( onGetText );
        }
	)}

	// Adds the pages that the book will need
	function addPage(page, book) {
		// 	First check if the page is already in the book
		if (!book.turn('hasPage', page)) {

		    /*
   			var element = $('<div />', {'class': 'page '+((page%2==0) ? 'odd' : 'even'), 'id': 'page-'+page}).html('<i class="loader"></i>');
			// If not then add the page
			book.turn('addPage', element, page);
			// Let's assum that the data is comming from the server and the request takes 1s.
			setTimeout(function(){
					element.html('<div class="data">Data for page '+page+'</div>');
			}, 1000);
			*/
            ///*
			// Create an element for this page
			var element = $('<div />', {'class': 'page '+((page%2==0) ? 'odd' : 'even'), 'id': 'page-'+page})
			element.html('<div class="data"><canvas id="canv' + page + '"></canvas></div>');
			// element.html('<div><i>test</i></div>');
			// If not then add the page
			book.turn('addPage', element, page);
			// renderPage(page);
			//*/
		}
	}

	$(window).ready(function(){
		$('#outputText').hide();
		
		var	pitch = 1.2;
		var	rate  = 1;
		var langs_voice = [
			{"voice":"UK English Female","active":true},
			{"voice":"UK English Male","active":true},
			{"voice":"US English Female","active":true},
			{"voice":"US English Male","active":true},
			{"voice":"Arabic Male","active":false},
			{"voice":"Arabic Female","active":false},
			{"voice":"Armenian Male","active":false},
			{"voice":"Australian Female","active":false},
			{"voice":"Brazilian Portuguese Female","active":false},
			{"voice":"Chinese Female","active":false},
			{"voice":"Chinese (Hong Kong) Female","active":false},
			{"voice":"Chinese Taiwan Female","active":false},
			{"voice":"Czech Female","active":false},
			{"voice":"Danish Female","active":false},
			{"voice":"Deutsch Female","active":false},
			{"voice":"Dutch Female","active":false},
			{"voice":"Finnish Female","active":false},
			{"voice":"French Female","active":false},
			{"voice":"Greek Female","active":false},
			{"voice":"Hatian Creole Female","active":false},
			{"voice":"Hindi Female","active":false},
			{"voice":"Hungarian Female","active":false},
			{"voice":"Indonesian Female","active":false},
			{"voice":"Italian Female","active":false},
			{"voice":"Japanese Female","active":false},
			{"voice":"Korean Female","active":false},
			{"voice":"Latin Female","active":false},
			{"voice":"Norwegian Female","active":false},
			{"voice":"Polish Female","active":false},
			{"voice":"Portuguese Female","active":false},
			{"voice":"Romanian Male","active":false},
			{"voice":"Russian Female","active":false},
			{"voice":"Slovak Female","active":false},
			{"voice":"Spanish Female","active":false},
			{"voice":"Spanish Latin American Female","active":true},
			{"voice":"Swedish Female","active":false},
			{"voice":"Tamil Male","active":false},
			{"voice":"Thai Female","active":false},
			{"voice":"Turkish Female","active":false},
			{"voice":"Afrikaans Male","active":false},
			{"voice":"Albanian Male","active":false},
			{"voice":"Bosnian Male","active":false},
			{"voice":"Catalan Male","active":false},
			{"voice":"Croatian Male","active":false},
			{"voice":"Czech Male","active":false},
			{"voice":"Danish Male","active":false},
			{"voice":"Esperanto Male","active":false},
			{"voice":"Finnish Male","active":false},
			{"voice":"Greek Male","active":false},
			{"voice":"Hungarian Male","active":false},
			{"voice":"Icelandic Male","active":false},
			{"voice":"Latin Male","active":false},
			{"voice":"Latvian Male","active":false},
			{"voice":"Macedonian Male","active":false},
			{"voice":"Moldavian Male","active":false},
			{"voice":"Montenegrin Male","active":false},
			{"voice":"Norwegian Male","active":false},
			{"voice":"Serbian Male","active":false},
			{"voice":"Serbo-Croatian Male","active":false},
			{"voice":"Slovak Male","active":false},
			{"voice":"Swahili Male","active":false},
			{"voice":"Swedish Male","active":false},
			{"voice":"Vietnamese Male","active":false},
			{"voice":"Welsh Male","active":false},
			{"voice":"Fallback UK Female","active":false}
		];
		
		$('.menu-langs').html('');

		$(langs_voice).each(function(i){
			if(this.active){
				$('.menu-langs').append('<li class="'+ (i == 0 ? 'active' : '') +'"><a href="#">'+ this.voice +'</a></li>');
			}
		});
		
		$('.menu-langs li a').on('click', function(e){
			e.preventDefault();
			
			$('.menu-langs li').removeClass('active');
			$(this).parent().addClass('active');
		});

		var pdfToText = function(data, num_page) {
			PDFJS.workerSrc = '../js/pdf-js/build/pdf.worker.js';
			PDFJS.cMapUrl   = '../js/pdf-js/web/cmaps/';
			PDFJS.cMapPacked= true;
			
			return PDFJS.getDocument(data).then(function(pdf) {
				return pdf.getPage(num_page).then(function(page) {
					return page.getTextContent().then(function(textContent) {
						var pdfText = textContent.items.map(function(item) {
							return $.trim(item.str);
						}).join('<br>');
						
						localStorage.setItem('textPage'+ num_page, pdfText);

						return pdfText;
					});
				});
			});
		};
		
		var recursive = function (lines, index, total){
			if(index < total){
				var text = $.trim(lines[index]);

				if(text != '' && text != undefined){
					var voice = $.trim($('.menu-langs li.active a').text());
					var text  = text + '.';

console.log(text);

					responsiveVoice.speak(
						text.replace('<br>', ','),
						voice, 
						{
							pitch: pitch, 
							rate: rate,
							onstart: function(){
								$('#btn-play, #msg-send').hide();
								$('#btn-pause, #btn-cancel').show();
								
								$("#outputText").animate({ 
								  	scrollTop: $( $('span.line' + index) ).offset().top 
								}, 600);
								$("#outputText").removeHighlight();
								$("#outputText").highlight( text );
							},
							onend: function(){
								$('#btn-play').show();
								$('#btn-pause, #btn-resume, #btn-cancel, #msg-send').hide();
								
								setTimeout(function(){
									recursive(lines, index+1, total);
								}, 200);
							}
						}
					);
				};
			}else{
				$('#btn-cancel').trigger('click');
			};
			
			return false;
		};

		var playVoice = function(text_page){
			if (text_page) {
				var lines = text_page.split("<br>").filter(function (e) {
					return e
				});

				$("#outputText").html('');

				$(lines).each(function(i){
					$("#outputText").append( '<span class="line'+ i +'">'+ this +'.</span>' );
				});

				$('#outputText').fadeIn('2000');
				
				recursive(lines, 0, lines.length);
			}else{
				$('#msg-send').hide();
				$('#btn-play').show();
			};
		};
		
		$('#btn-pause, #btn-resume, #btn-cancel, #msg-send').hide();
		$('#btn-play').show();
		
		$('#btn-play').on('click', function(e){
			e.preventDefault();
			
			if(responsiveVoice.voiceSupport()) {
				$('#msg-send').show();
				$(this).hide();
				
				var num_page  = (localStorage.getItem('page__num') * 2) - 1;

				if(num_page == 1){
					pdfToText(url, num_page).then(function(result) {
						playVoice(result);
					});
				}else{
					var text_page = '';

					pdfToText(url, num_page - 1).then(function(result) {
						text_page = result;
						
						pdfToText(url, num_page).then(function(result) {
							text_page = text_page +' '+ result;

							playVoice(text_page);
						});
					});
				};
			}else{
				alert('Voice support NOT ready');	
			};
		});

		$('#btn-pause').on('click', function(e){
			e.preventDefault();
			
			responsiveVoice.pause();

			$('#btn-resume').show();

			$(this).hide();
		});

		$('#btn-resume').on('click', function(e){
			e.preventDefault();
			
			responsiveVoice.resume();

			$('#btn-pause').show();

			$(this).hide();
		});

		$('#btn-cancel').on('click', function(e){
			e.preventDefault();
			
			responsiveVoice.cancel();

			$('#btn-play').show();

			$('#btn-pause, #btn-resume, #btn-cancel, #msg-send').hide();
			
			$('#outputText').fadeOut('2000');
		});

		PDFJS.disableWorker = true;

		PDFJS.getDocument(url).then(function(pdfDoc) {
			numberOfPages = pdfDoc.numPages;
			pdf = pdfDoc;
			
			$('#book').turn.pages = numberOfPages;

			$('#book').turn({acceleration: false,
				pages: numberOfPages,
				elevation: 50,
				gradients: !$.isTouch,
				// display: 'single',
				when: {
					turning: function(e, page, view) {

						// Gets the range of pages that the book needs right now
						var range = $(this).turn('range', page);

						// Check if each page is within the book
						for (page = range[0]; page<=range[1]; page++) {
							addPage(page, $(this));
							//renderPage(page);
						};

					},

					turned: function(e, page) {
						$('#page-number').val(page);

						if (firstPagesRendered) {
							var range = $(this).turn('range', page);
							for (page = range[0]; page<=range[1]; page++) {
								if (!rendered[page]) {
									renderPage(page);
									rendered[page] = true;
								}
							};
						}

					}
				}
			});

			$('#number-pages').html(numberOfPages);

			$('#page-number').keydown(function(e){

			var p = $('#page-number').val();
				if (e.keyCode==13) {
					$('#book').turn('page', p);
					renderPage(p);
				}
			});

			var n = numberOfPages;
			if (n > 6 ) n = 6;

			for (page = 1; page <= n; page++) {
				renderPage(page);
				rendered[page] = true;
			};

			firstPagesRendered = true;
		});
	});

	$(window).bind('keydown', function(e){

		if (e.target && e.target.tagName.toLowerCase()!='input')
			if (e.keyCode==37){
				// $('#book').turn('previous');
				// flip_counter--;
				$('.fa-chevron-left').trigger('click')
  		// update_slider(flip_counter);
			}
			else if (e.keyCode==39){
				// $('#book').turn('next');
				$('.fa-chevron-right').trigger('click')
  		// update_slider(flip_counter);
			}

	});




  function load_page_slider(){
  	    // console.log(num_of_pages);


		$("#range").ionRangeSlider({
			type: "single",
		    min: 1,
		    max: <?php echo count_pages("../".$_GET['q']); ?>/2 +1,
		    keyboard: true,
		    from:1,
		    onStart: function (data) {
		        // console.log("onStart");
		    },
		    onChange: function (data) {
		        // console.log("onChange");
		    },
		    onFinish: function (data) {
		        // console.log("onFinish");
		    },
		    onUpdate: function (data) {
		        // console.log("onUpdate");
		    }
		});
	}


	// var slider = $("#range").data("ionRangeSlider");

	function flip_page(){

		var other = parseInt($('.irs-single').text());

		if(start<other){
			$('#book').turn('next');
			start = parseInt($('.irs-single').text());
			renderPage(start);

		}else{
			$('#book').turn('previous');
			start = parseInt($('.irs-single').text());

		}

	}

	function advert(){
		populateStorage();
		if(adcounter%10===0){
			$('.ad').css('opacity','1');
			$('.ad').css('display','block');
			$('.ad').css('visibility','visible');
		} else{
			$('.ad').css('opacity','0');
			$('.ad').css('display','none');
			$('.ad').css('visibility','hidden');
		}
		adcounter++;
	};

	function update_slider(value){
		if(value%2===0){
			$("#range").data("ionRangeSlider").update({from:value});
		}
		else{
			$("#range").data("ionRangeSlider").update({from:value});
		};

		$('#btn-cancel').trigger('click');
	};

  	$('.fa-chevron-right').click(function(){
  		flip_counter++;
  		update_slider(flip_counter);
  		advert();
  		// $('#book').turn('next');
  	});
  	$('.fa-chevron-left').click(function(){
  		flip_counter--;
  		update_slider(flip_counter);
  		advert();
  		// $('#book').turn('previous');
  	});

  	$('.fa-moon-o').click(function(){
  		advert();
	night_counter++;
	if(night_counter%2===0){
		$('body').css('background-color', '#f0f0f0');
		$('.data-1').css('background-color', 'rgba(0,0,0,1)');
		$('body,.fa-chevron-left,.fa-chevron-right').css('color','#fff');
		$('.fa').css('color','#fff');
		$('.box').css('background-color','black');
		$('#slidepdf').css('background','black');
		$('.box').css('color','#fff');
		$('.row_2').css('background','black');
		$('.btn_1').css('color','white');
	}
	else{
		// $('body').css('color','#000');
		// $('body').css('background-color', '#4b4b4b');
		// $('.data-1').css('background-color', '#f0f0f0');
		$('.row_2').css('background','#f0f0f0');
		$('.box').css('color','#000');
		$('.box').css('background','#fff');
		$('#slidepdf').css('background','black');
		$('.btn_1,.fa-chevron-left,.fa-chevron-right').css('color','white');
		$('.fa').css('color','#fff');
	}
  	});
  	$('.ad').click(function(){
		$(this).css('opacity','0');
	});
	$( "body" ).keypress(function() {
		// console.log('pre');
  	advert();
	});
	$( "body" ).click(function() {
  	advert();
	});

	$('.fa-search-plus').click(function(){
		global_scale += 0.05;
		// var c = document.getElementById("canv"+$('#page-number').val());
		// var ctx=c.getContext("2d");
		// ctx.scale(2,2);
		renderPage($('#page-number').val());
	});

	$('.fa-search-minus').click(function(){
		global_scale -= 0.05;
		renderPage($('#page-number').val());
	});


</script>

<script>
function populateStorage() {
  localStorage.setItem('page__num',parseInt($('.irs-single').text()));
}
</script>
  <!---  end of book page scripts --->
  
   <script>
   
        function _cre(e){return document.createElement(e)};
        function _cll(e){return document.getElementsByClassName(e)};
	    function _cl(e){return document.getElementsByClassName(e)[0]};
		function _id(e){return document.getElementById(e)};
		window.onload=function(){
			PDFJS.disableWorker = true;
			var x=0,buff=true,tim;
			tim=setInterval(function(){
			if(buff){
				buff=false; 
				if(x === _cll('canvas2').length){
					clearInterval(tim);
					buff=false;
					return false;
				}
			    var url = 'http://mnerva.ca/uploads/'+_cll('canvas2')[x].getAttribute('data-cover');
				PDFJS.getDocument(url).then(function(pdf) {
					pdf.getPage(1).then(function(page) {
						var scale = 1;
						var viewport = page.getViewport(scale);
						var canvas = _cre('canvas');
						var context = canvas.getContext('2d');
						canvas.height = viewport.height;
						canvas.width = viewport.width;
						canvas.onclick=function(){
							var s = this;
							window.location.assign('http://mnerva.ca/book/?q=uploads/'+s.parentNode.getAttribute('data-cover'));
						}
						var renderContext = {
						  canvasContext: context,
						  viewport: viewport
						};
						page.render(renderContext);
						_cll('canvas2')[x].insertBefore(canvas,_cll('canvas2')[x].childNodes[0]);
						x++;
						buff=true;
						
						//page.getTextContent().then( onGetText );
					});
				});
			}
			},500);
			
		}
		
    </script>
  
	<script type="text/javascript">
		$(document).ready(function() {
			$('#dropdownLangs').dropdown();
			
			$("#openIframePdf").click(function(){
				
				filedata = $(this).attr("href").split("&pdffile=");

				$("#nav-bar").hide();
				$("#side-bar").hide();
				$("#main-container").css({"margin-top": "0px"});
				
				$( ".main-content" ).before( '<iframe src="http://mnerva.ca/book/turn/full_screen.php?pdf='+ filedata[1] +'" style="width:100%;height:100%;position:absolute;border:none" class="iframe" scrolling="no">' );
				$( ".main-content" ).remove();

				return false;
			});
		});
	</script>
   
    <div class="footer"></div>
</div><!-- end of site-wrap -->
</body>
</html>