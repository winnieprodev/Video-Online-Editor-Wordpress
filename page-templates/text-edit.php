<?php
	$content_url = $_GET['url'];
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
<body>
	<style type="text/css">

		@font-face {
			font-family: 'CopyDoodles_Adam';
    		src: url('../font-customs/CopyDoodles_Adam.ttf');
		}
		@font-face {
			font-family: 'CopyDoodles_AlanS';
    		src: url('../font-customs/CopyDoodles_AlanS.ttf');
		}
		@font-face {
			font-family: 'CopyDoodles_Becky_Bold';
    		src: url('../font-customs/CopyDoodles_Becky_Bold.ttf');
		}
		@font-face {
			font-family: 'CopyDoodles_Block1';
    		src: url('../font-customs/CopyDoodles_Block1.ttf');
		}
		@font-face {
			font-family: 'CopyDoodles_Carly';
    		src: url('../font-customs/CopyDoodles_Carly.ttf');
		}
		@font-face {
			font-family: 'CopyDoodles_Dan';
    		src: url('../font-customs/CopyDoodles_Dan.ttf');
		}
		@font-face {
			font-family: 'CopyDoodles_Donna';
    		src: url('../font-customs/CopyDoodles_Donna.ttf');
		}
		@font-face {
			font-family: 'CopyDoodles_Kid1';
    		src: url('../font-customs/CopyDoodles_Kid1.ttf');
		}
		@font-face {
			font-family: 'CopyDoodles_Lisa_Bold';
    		src: url('../font-customs/CopyDoodles_Lisa_Bold.ttf');
		}
		@font-face {
			font-family: 'CopyDoodles_Mike';
    		src: url('../font-customs/CopyDoodles_Mike.ttf');
		}
		@font-face {
			font-family: 'CopyDoodles_Phil';
    		src: url('../font-customs/CopyDoodles_Phil.ttf');
		}
		@font-face {
			font-family: 'CopyDoodles_Polly';
    		src: url('../font-customs/CopyDoodles_Polly.ttf');
		}
		@font-face {
			font-family: 'CopyDoodles_Scratchy';
    		src: url('../font-customs/CopyDoodles_Scratchy.ttf');
		}
		@font-face {
			font-family: 'CopyDoodles_Skipper_Bold';
    		src: url('../font-customs/CopyDoodles_Skipper_Bold.ttf');
		}
		@font-face {
			font-family: 'CopyDoodles_Tish';
    		src: url('../font-customs/CopyDoodles_Tish.ttf');
		}
		@font-face {
			font-family: 'CopyDoodles_Tom';
    		src: url('../font-customs/CopyDoodles_Tom.ttf');
		}

		span {
			margin: 0px;
		}
		.ml2 .letter {
		  display: inline-block;		  
		}

		/* animi_2 */
		.ml1 .letter {
		  display: inline-block;
		  line-height: 1em;
		}

		.ml1 .text-wrapper {
		  position: relative;
		  display: inline-block;
		  /*padding-top: 0.1em;*/
		  padding-right: 0.05em;
		  padding-bottom: 0.15em;
		}

		.ml1 .line {
		  opacity: 0;
		  position: absolute;
		  left: 0;
		  height: 3px;
		  width: 100%;
		  background-color: #ff00ff;
		  transform-origin: 0 0;
		}

		.ml1 .line1 { top: 0; }
		.ml1 .line2 { bottom: 0; }

		/* animi_4 */
		.ml4 {
		  position: relative;
		}
		.ml4 .letters {
		  position: absolute;
		  margin: auto;
		  left: 0;
		  top: 0.3em;
		  right: 0;
		  opacity: 0; 
		}

		/* animi_5 */

		.ml5 {
		  position: relative;
		}

		.ml5 .text-wrapper {
		  position: relative;
		  display: inline-block;
		  /*padding-top: 0.1em;*/
		  padding-right: 0.05em;
		  padding-bottom: 0.15em;
		  line-height: 1em;
		}

		.ml5 .line {
		  position: absolute;
		  left: 0;
		  top: 0;
		  bottom: 0;
		  margin: auto;
		  height: 3px;
		  width: 100%;
		  background-color: #402d2d;
		  transform-origin: 0.5 0;
		}

		.ml5 .ampersand {
		  font-family: Baskerville, "EB Garamond", serif;
		  font-style: italic;
		  font-weight: 400;
		  width: 1em;
		  margin-right: -0.1em;
		  margin-left: -0.1em;
		}

		.ml5 .letters {
		  display: inline-block;
		  opacity: 0;
		}

		/* animi_6 */
		.ml6 {
		  position: relative;
		}

		.ml6 .text-wrapper {
		  position: relative;
		  display: inline-block;
		  /*padding-top: 0.2em;*/
		  padding-right: 0.05em;
		  padding-bottom: 0.1em;
		  overflow: hidden;
		}

		.ml6 .letter {
		  display: inline-block;
		  line-height: 1em;
		}


		/* animi_7 */
		.ml7 {
		  position: relative;
		}
		.ml7 .text-wrapper {
		  position: relative;
		  display: inline-block;
		  /*padding-top: 0.2em;*/
		  padding-right: 0.05em;
		  padding-bottom: 0.1em;
		  overflow: hidden;
		}
		.ml7 .letter {
		  transform-origin: 0 100%;
		  display: inline-block;
		  line-height: 1em;
		}

		/* animi_8 */

		.ml10 {
		  position: relative;
		}

		.ml10 .text-wrapper {
		  position: relative;
		  display: inline-block;
		  /*padding-top: 0.2em;*/
		  padding-right: 0.05em;
		  padding-bottom: 0.1em;
		  overflow: hidden;
		}

		.ml10 .letter {
		  display: inline-block;
		  line-height: 1em;
		  transform-origin: 0 0;
		}

		/* animi_10 */
		span.ml8 {
		  font-weight: 900;
		  font-size: 4.5em;
		  color: #ff00ff;
		  width: 3em;
		  height: 3em;
		}

		.ml8 .letters-container {
		  position: absolute;
		  left: 0;
		  right: 0;
		  margin: auto;
		  top: 0;
		  bottom: 0;
		  height: 1em;
		}

		.ml8 .letters {
		  position: relative;
		  z-index: 2;
		  display: inline-block;
		  line-height: 0.7em;
		  right: -0.12em;
		  top: -0.2em;
		}

		.ml8 .bang {
		  font-size: 1.4em;
		  top: auto;
		  left: -0.06em;
		}

		.ml8 .circle {
		  position: absolute;
		  left: 0;
		  right: 0;
		  margin: auto;
		  top: 0;
		  bottom: 0;
		}

		.ml8 .circle-white {
		  width: 3em;
		  height: 3em;
		  border: 2px dashed white;
		  border-radius: 2em;
		}

		.ml8 .circle-dark {
		  width: 2.2em;
		  height: 2.2em;
		  background-color: #4f7b86;
		  border-radius: 3em;
		  z-index: 1;
		}

		.ml8 .circle-dark-dashed {
		  border-radius: 2.4em;
		  background-color: transparent;
		  border: 2px dashed #4f7b86;
		  width: 2.3em;
		  height: 2.3em;
		}

		/* animi_11 */
		.ml9 {
		  position: relative;
		}

		.ml9 .text-wrapper {
		  position: relative;
		  display: inline-block;
		  /*padding-top: 0.2em;*/
		  padding-right: 0.05em;
		  padding-bottom: 0.1em;
		  overflow: hidden;
		}

		.ml9 .letter {
		  transform-origin: 50% 100%;
		  display: inline-block;
		  line-height: 1em;
		}

		/* animi_12 */

		.ml11 .text-wrapper {
		  position: relative;
		  display: inline-block;
		  /*padding-top: 0.1em;*/
		  padding-right: 0.05em;
		  padding-bottom: 0.15em;
		}

		.ml11 .line {
		  opacity: 0;
		  position: absolute;
		  left: 0;
		  height: 100%;
		  width: 3px;
		  background-color: #fff;
		  transform-origin: 0 50%;
		}

		.ml11 .line1 { 
		  top: 0; 
		  left: 0;
		}

		.ml11 .letter {
		  display: inline-block;
		  line-height: 1em;
		}


		/* animi_13 */
		.ml12 {
		  text-transform: uppercase;
		  /*letter-spacing: 0.5em;*/
		}

		.ml12 .letter {
		  display: inline-block;
		  line-height: 1em;
		}

		/* animi_14 */
		.ml13 {
		  text-transform: uppercase;
		  /*letter-spacing: 0.5em;*/
		}

		.ml13 .letter {
		  display: inline-block;
		  line-height: 1em;
		}


		/* animi_15 */

		.ml14 .text-wrapper {
		  position: relative;
		  display: inline-block;
		  /*padding-top: 0.1em;*/
		  padding-right: 0.05em;
		  padding-bottom: 0.15em;
		}

		.ml14 .line {
		  opacity: 0;
		  position: absolute;
		  left: 0;
		  height: 2px;
		  width: 100%;
		  background-color: #ff00ff;
		  transform-origin: 100% 100%;
		  bottom: 0;
		}

		.ml14 .letter {
		  display: inline-block;
		  line-height: 1em;
		}


		/* animi_16 */
		.ml15 {
		  text-transform: uppercase;
		  /*letter-spacing: 0.5em;*/
		}

		.ml15 .word {
		  display: inline-block;
		  line-height: 1em;
		}


		/* animi_17 */
		.ml16 {
		  padding: 40px 0;
		  font-weight: 800;
		  text-transform: uppercase;
		  /*letter-spacing: 0.5em;*/
		  overflow: hidden;
		}

		.ml16 .letter {
		  display: inline-block;
		  line-height: 1em;
		}

		#text_style input {
			font-size: 16px;
		}
		#text_style span {
			font-size: 20px;
		}
		#text_style select {
			font-size: 16px;
		}

	</style>

	<div id="container" style="height:80px; width:480px; background-color: rgba(255, 255, 255, 0); text-align: center;">
        <div id="animation">

        </div>
    </div>

	<canvas id="canvas" style="width: 500px; height: 100px;" hidden></canvas>
	<br>
	
	<div id="text_style" style="font-size: 8px;">
		<span style="font-size: 16px; width: 20%;">Text 1 &nbsp;&nbsp;</span>
		<input id="text_content_1" class='text_content' type="text" placeholder=" Please input text here." style="width: 60%; font-size: 16px; padding-right: 0px; border: 1px solid gray; border-radius: 3px;" />
		<input type="radio" name="edit_text" value="1" checked /><span style="font-size: 16px;">Edit</span><br><br>

		<span style="font-size: 16px; width: 20%;">Text 2 &nbsp;&nbsp;</span>
		<input id="text_content_2" class='text_content' type="text" placeholder=" Please input text here." style="width: 60%; font-size: 16px; padding-right: 0px; border: 1px solid gray; border-radius: 3px;" />
		<input type="radio" name="edit_text" value="2" /><span style="font-size: 16px;">Edit</span><br><br>

		<span style="font-size: 16px; width: 20%;">Text 3 &nbsp;&nbsp;</span>
		<input id="text_content_3" class='text_content' type="text" placeholder=" Please input text here." style="width: 60%; font-size: 16px; padding-right: 0px; border: 1px solid gray; border-radius: 3px;" />
		<input type="radio" name="edit_text" value="3" /><span style="font-size: 16px;">Edit</span><br><br>

		<table>
			<tr>
				<td style="width: 20%;">
					<span style="font-size: 16px;">Font Family:</span>
				</td>
				<td  style="width: 30%;">
					<select id="font_family" style="font-size: 12px; width: 120px; border: 1px solid gray; border-radius: 3px;">
				        <option value = "CopyDoodles_Adam" style="font-family: CopyDoodles_Adam;">Font One</option>
				        <option value = "CopyDoodles_AlanS" style="font-family: CopyDoodles_AlanS;">Font Two</option>
				        <option value = "CopyDoodles_Becky_Bold" style="font-family: CopyDoodles_Becky_Bold;">Font Three</option>
				        <option value = "CopyDoodles_Block1" style="font-family: CopyDoodles_Block1;">Font Four</option>
				        <option value = "CopyDoodles_Carly" style="font-family: CopyDoodles_Carly;">Font Five</option>
				        <option value = "CopyDoodles_Dan" style="font-family: CopyDoodles_Dan;">Font Six</option>
				        <option value = "CopyDoodles_Donna" style="font-family: CopyDoodles_Donna;">Font Seven</option>
				        <option value = "CopyDoodles_Kid1" style="font-family: CopyDoodles_Kid1;">Font Eight</option>
				        <option value = "CopyDoodles_Lisa_Bold" style="font-family: CopyDoodles_Lisa_Bold;">Font Nine</option>
				        <option value = "CopyDoodles_Mike" style="font-family: CopyDoodles_Mike;">Font Ten</option>
				        <option value = "CopyDoodles_Phil" style="font-family: CopyDoodles_Phil;">Font Eleven</option>

				        <option value = "CopyDoodles_Polly" style="font-family: CopyDoodles_Polly;">Font Twelve</option>
				        <option value = "CopyDoodles_Scratchy" style="font-family: CopyDoodles_Scratchy;">Font Thirteen</option>
				        <option value = "CopyDoodles_Skipper_Bold" style="font-family: CopyDoodles_Skipper_Bold;">Font Forteen</option>
				        <option value = "CopyDoodles_Tish" style="font-family: CopyDoodles_Tish;">Font Fifteen</option>
				        <option value = "CopyDoodles_Tom" style="font-family: CopyDoodles_Tom;">Font Sixteen</option>
				    </select>
				</td>
				<td style="width: 20%; padding-left: 10px;">
					<span style="font-size: 16px;">Font Size:</span>
				</td>
				<td style="width: 25%;">
					<div style="width: 118px; border: 1px solid gray; border-radius: 4px;">
						<input id="font_size" type="text" value="40" style="border: none; width: 110px; margin-left:4px; font-size: 13px;" />
					</div>
					
				</td>
			</tr>
			<tr>
				<td style="width: 20%;">
					<span style="font-size: 16px;">Font Color:</span>
				</td>
				<td style="width: 30%;">
					<button style="width: 120px; height: 20px; border-radius: 4px;" class="jscolor { width:240, height:140, valueElement:'chosen-value', onFineChange:'setTextColor(this)'}"></button>
					<!-- <select class="form-control" id="font_color" style="font-size: 12px; width: 120px; border: 1px solid gray; border-radius: 3px;">
				        <option value = "#000">Black</option>
				        <option value = "#666">Gray</option>
				        <option value = "#CCC">Light Gray</option>
				        <option value = "#FFF">White</option>
				        <option value = "#00D699">Green</option>
				        <option selected="true" value = "#4DA6FF">Blue</option>
				        <option value = "none">None</option>
				    </select> -->
				</td>
				<td style="width: 20%; padding-left: 10px;">
					<span style="font-size: 16px;">Animation:</span>
				</td>
				<td style="width: 25%;">
					<select id="font_animation" style="font-size: 12px; width: 120px; border: 1px solid gray; border-radius: 3px;">
				    	<option value="0">Static Text</option>
				        <option value="1">Zoom flow</option>
				        <option value="2">Line flow</option>
				        <option value="3">Smooth flow</option>
				        <!-- <option value="4">4</option> -->
				        <option value="5">Line split</option>
				        <option value="6">Wave flow</option>
				        <option value="7">Rotate flow</option>
				        <option value="8">Rolling flow</option>
				        <!-- <option value="10">10</option> -->
				        <option value="11">Vibrate flow</option>
				        <option value="12">Text flow</option>
				        <option value="13">Text slid</option>
				        <option value="14">Delay drawing(D)</option>
				        <option value="15">Underline text</option>
				        <option value="16">Alert text</option>
				        <option value="17">Delay drawing(U)</option>
				    </select>
				</td>
			</tr>
			<tr>
				<td style="width: 20%;"></td>
				<td style="width: 30%;"></td>
				<td style="width: 20%; padding-left: 10px;">
					<span style="font-size: 16px;">Repeat:</span>				    
				</td>
				<td style="width: 25%;">
					<input style="font-size: 16px;" type="radio" name="repeat_check" checked value="yes" /><span style="font-size: 16px;">Yes</span>
				    <input style="font-size: 16px;" type="radio" name="repeat_check" value="no" /><span style="font-size: 16px;">No</span>
				</td>
			</tr>
		</table>
	    
	    

	    
	</div>
    
	
	<!-- <script src="jquery.min.js"></script> -->
	<script src="<?php echo $content_url; ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo $content_url; ?>/assets/textanimi/anime.min.js"></script>
    <script src="<?php echo $content_url; ?>/assets/textanimi/html2canvas.js"></script>
    <script src="<?php echo $content_url; ?>/assets/textanimi/jscolor.js" type="text/javascript"></script>
    <script>
    	var font_color = '#A7EDFF';
    	function setTextColor(picker) {

    		var num = $('input[name=edit_text]:checked').val();

			font_color = '#' + picker.toString();
			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();
            //var font_color = $('#font_color').val();
            $('#animation').html('<span style="font-family: '+font_family+'; font-size: '+font_size+'px; color: '+font_color+'; font-weight: 900;">'+ text +'</span>');
		}
    	var iframe_png_array_1 = [];
    	var iframe_png_array_2 = [];
    	var iframe_png_array_3 = [];

    	var repeat_1 = 'yes';
    	var repeat_2 = 'yes';
    	var repeat_3 = 'yes';
        // Wrap every letter in a span
        $('.text_content').change(function(){
        	var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();

            $('#animation').html('<span style="font-family: '+font_family+'; font-size: '+font_size+'px; color: '+font_color+'; font-weight: 900;">'+ text +'</span>');            
        });

        $('#font_family').change(function(){
            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();
           // var font_color = $('#font_color').val();
            $('#animation').html('<span style="font-family: '+font_family+'; font-size: '+font_size+'px; color: '+font_color+'; font-weight: 900;">'+ text +'</span>');           
        });

        $('#font_size').change(function(){
            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();
            //var font_color = $('#font_color').val();
            $('#animation').html('<span style="font-family: '+font_family+'; font-size: '+font_size+'px; color: '+font_color+'; font-weight: 900;">'+ text +'</span>');           
        });

        $('#font_animation').change(function(){
        	var num = $('input[name=edit_text]:checked').val();
        	if(num == 1){
				iframe_png_array_1 = [];
			} else if(num == 2){
				iframe_png_array_2 = [];
			} else {
				iframe_png_array_3 = [];
			}
        	
            switch($('#font_animation').val()){
            	case '0': 
                    animi_0();
                    break;
                case '1': 
                    animi_1();
                    break;
                case '2': 
                    animi_2();
                    break;
                case '3': 
                    animi_3();
                    break;
                case '4': 
                    animi_4();
                    break;
                case '5':
                    animi_5();
                    break;
                case '6': 
                    animi_6();
                    break;
                case '7': 
                    animi_7();
                    break;
                case '8': 
                    animi_8();
                    break;
                case '10': 
                    animi_10();
                    break;
                case '11': 
                    animi_11();
                    break;
                case '12': 
                    animi_12();
                    break;
                case '13': 
                    animi_13();
                    break;
                case '14': 
                    animi_14();
                    break;
                case '15': 
                    animi_15();
                    break;
                case '16': 
                    animi_16();
                    break;
                case '17': 
                    animi_17();
                    break;
            }
        });


        function text_select(){
        	var num = $('input[name=edit_text]:checked').val();
        	if(num == 1){
				iframe_png_array_1 = [];
				repeat_1 = $('input[name=repeat_check]:checked').val();

			} else if(num == 2){
				iframe_png_array_2 = [];
				repeat_2 = $('input[name=repeat_check]:checked').val();
			} else {
				iframe_png_array_3 = [];
				repeat_3 = $('input[name=repeat_check]:checked').val();
			}
            switch($('#font_animation').val()){
            	case '0': 
                    animi_0();
                    break;
                case '1': 
                    animi_1();
                    break;
                case '2': 
                    animi_2();
                    break;
                case '3': 
                    animi_3();
                    break;
                case '4': 
                    animi_4();
                    break;
                case '5':
                    animi_5();
                    break;
                case '6': 
                    animi_6();
                    break;
                case '7': 
                    animi_7();
                    break;
                case '8': 
                    animi_8();
                    break;
                case '10': 
                    animi_10();
                    break;
                case '11': 
                    animi_11();
                    break;
                case '12': 
                    animi_12();
                    break;
                case '13': 
                    animi_13();
                    break;
                case '14': 
                    animi_14();
                    break;
                case '15': 
                    animi_15();
                    break;
                case '16': 
                    animi_16();
                    break;
                case '17': 
                    animi_17();
                    break;
            }
        };

        function get_repeat_value(){
        	var value = $('input[name=repeat_check]:checked').val();
        	return value;
        }

        function animi_0() {
        	var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();
            //var font_color = $('#font_color').val();

            $('#animation').html('<span class="ml3">'+text+'</span>');
            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');

            $('.ml3').each(function(){
            $(this).html($(this).text().replace(/([^\x00-\x127]|\w)/g, "<span class='letter'>$&</span>"));
            });

            anime.timeline({loop: false})
            	.add({
                    targets: '.ml3',
                    opacity: 1,
                    duration: 2000,
                    easing: "easeInOutQuad",
                    delay: 1000,
                    update: function( ){
                        
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
							ctx.webkitImageSmoothingEnabled = false;
							ctx.mozImageSmoothingEnabled = false;
							ctx.imageSmoothingEnabled = false; 
							var png = canvas.toDataURL('image/png', 1.0);
							if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            
                            parent.document.getElementById('outimage_'+num).src = png;

                        });
                        
                    }                       
                });
        }

        function animi_1(){

            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();
            //var font_color = $('#font_color').val();

            $('#animation').html('<span class="ml2">'+text+'</span>');
            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');


            $('.ml2').each(function(){
              $(this).html($(this).text().replace(/([^\x00-\x127]|\w)/g, "<span class='letter'>$&</span>"));
            });           

            anime.timeline({loop: false})
                .add({
                    targets: '.ml2 .letter',
                    scale: [4,1],
                    opacity: [0,1],
                    translateZ: 0,
                    easing: "easeOutExpo",
                    duration: 1000,
                    delay: function(el, i) {
                        return 70*i;
                    }                     
                }).add({
                    targets: '.ml2',
                    opacity: 1,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1000,
                    update: function( ){
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
							ctx.webkitImageSmoothingEnabled = false;
							ctx.mozImageSmoothingEnabled = false;
							ctx.imageSmoothingEnabled = false; 
							var png = canvas.toDataURL('image/png', 1.0);
                            if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            parent.document.getElementById('outimage_'+num).src = png;
                        });
                    }                       
               });


        };

        function animi_2(){
            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();
            //var font_color = $('#font_color').val();

            $('#animation').html(
                '<span class="ml1">'+
                  '<span class="text-wrapper">'+
                    '<span class="line line1"></span>'+
                    '<span class="letters">'+text+'</span>'+
                    '<span class="line line2"></span>'+
                  '</span>'+
                '</span>');
            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');
            $('.line').attr('style', 'opacity: 0;position: absolute;left: 0;height: 4px;width: 100%;background-color: '+font_color+';transform-origin: 0 0;');

            // Wrap every letter in a span
            $('.ml1 .letters').each(function(){
                $(this).html($(this).text().replace(/([^\x00-\x127]|\w)/g, "<span class='letter'>$&</span>"));
            });

            anime.timeline({loop: false})
                .add({
                    targets: '.ml1 .letter',
                    scale: [0.3,1],
                    opacity: [0,1],
                    translateZ: 0,
                    easing: "easeOutExpo",
                    duration: 1200,
                    delay: function(el, i) {
                    return 70 * (i+1)
                    },
                    update: function( ){
                   }                       
                }).add({
                    targets: '.ml1 .line',
                    scaleX: [0,1],
                    opacity: [0.5,1],
                    easing: "easeOutExpo",
                    duration: 1000,
                    offset: '-=875',
                    delay: function(el, i, l) {
                    return 80 * (l - i);
                    },
                    update: function( ){
                   }                       
                }).add({
                    targets: '.ml1',
                    opacity: 1,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1000,
                    update: function( ){
                        
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
							ctx.webkitImageSmoothingEnabled = false;
							ctx.mozImageSmoothingEnabled = false;
							ctx.imageSmoothingEnabled = false; 
							var png = canvas.toDataURL('image/png', 1.0);
                            if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            parent.document.getElementById('outimage_'+num).src = png;
                        });
                        
                    }                       
                });
        };

        // Wrap every letter in a span
        function animi_3(){
            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();
            //var font_color = $('#font_color').val();

            $('#animation').html('<span class="ml3">'+text+'</span>');
            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');

            $('.ml3').each(function(){
            $(this).html($(this).text().replace(/([^\x00-\x127]|\w)/g, "<span class='letter'>$&</span>"));
            });

            anime.timeline({loop: false})
                .add({
                    targets: '.ml3 .letter',
                    opacity: [0,1],
                    easing: "easeInOutQuad",
                    duration: 1000,
                    delay: function(el, i) {
                    return 150 * (i+1)
                    },
                    update: function( ){
                   }                       
                }).add({
                    targets: '.ml3',
                    opacity: 1,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1000,
                    update: function( ){
                        
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
ctx.webkitImageSmoothingEnabled = false;
ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false; var png = canvas.toDataURL('image/png', 1.0);
                            if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            parent.document.getElementById('outimage_'+num).src = png;
                        });
                        
                    }                       
                });
        };

        function animi_4(){
            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();
            //var font_color = $('#font_color').val();

            $('#animation').html(
                '<span class="ml4">'+
                    '<span class="letters letters-1">Ready</span>'+
                    '<span class="letters letters-2">Set</span>'+
                    '<span class="letters letters-3">Go!</span>'+
                '</span>');
            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');

            var ml4 = {};
            ml4.opacityIn = [0,1];
            ml4.scaleIn = [0.2, 1];
            ml4.scaleOut = 3;
            ml4.durationIn = 800;
            ml4.durationOut = 600;
            ml4.delay = 500;

            anime.timeline({loop: false})
                .add({
                    targets: '.ml4 .letters-1',
                    opacity: ml4.opacityIn,
                    scale: ml4.scaleIn,
                    duration: ml4.durationIn,
                    update: function( ){
                   }                       

                }).add({
                    targets: '.ml4 .letters-1',
                    opacity: 0,
                    scale: ml4.scaleOut,
                    duration: ml4.durationOut,
                    easing: "easeInExpo",
                    delay: ml4.delay,
                    update: function( ){
                   }                       

                }).add({
                    targets: '.ml4 .letters-2',
                    opacity: ml4.opacityIn,
                    scale: ml4.scaleIn,
                    duration: ml4.durationIn,
                    update: function( ){
                   }                       

                }).add({
                    targets: '.ml4 .letters-2',
                    opacity: 0,
                    scale: ml4.scaleOut,
                    duration: ml4.durationOut,
                    easing: "easeInExpo",
                    delay: ml4.delay,
                    update: function( ){
                   }                       

                }).add({
                    targets: '.ml4 .letters-3',
                    opacity: ml4.opacityIn,
                    scale: ml4.scaleIn,
                    duration: ml4.durationIn,
                    update: function( ){
                   }                       

                }).add({
                    targets: '.ml4 .letters-3',
                    opacity: 0,
                    scale: ml4.scaleOut,
                    duration: ml4.durationOut,
                    easing: "easeInExpo",
                    delay: ml4.delay,
                    update: function( ){
                   }                       

                }).add({
                    targets: '.ml4',
                    opacity: 1,
                    duration: 500,
                    delay: 500,
                    update: function( ){
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
ctx.webkitImageSmoothingEnabled = false;
ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false; var png = canvas.toDataURL('image/png', 1.0);
                            if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            parent.document.getElementById('outimage_'+num).src = png;
                        });
                   }                       

                });
        };

        function animi_5(){
            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();

            $('#animation').html(
                '<span class="ml5">'+
                    '<span class="text-wrapper">'+
                        '<span class="line line1"></span>'+
                        // '<span class="letters letters-left">Signal</span>&nbsp;&nbsp;'+
                        // '<span class="letters ampersand">&amp;</span>&nbsp;&nbsp;'+
                        '<span class="letters letters-right">'+text+'</span>'+
                        '<span class="line line2"></span>'+
                    '</span>'+
                '</span>');
            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');
            $('.line').attr('style', 'opacity: 0;position: absolute; left: 0; top:0; bottom: 0; magin: auto; height: 4px;width: 100%; background-color: '+font_color+';transform-origin: 0.5 0;');

            anime.timeline({loop: false})
                .add({
                    targets: '.ml5 .line',
                    opacity: [0.5,1],
                    scaleX: [0, 1],
                    easing: "easeInOutExpo",
                    duration: 700
                    }).add({
                    targets: '.ml5 .line',
                    duration: 600,
                    easing: "easeOutExpo",
                    translateY: function(e, i, l) {
                        var offset = -0.625 + 0.625*2*i;
                        return offset + "em";
                    },
                    update: function( ){
                   }
                }).add({
                    targets: '.ml5 .ampersand',
                    opacity: [0,1],
                    scaleY: [0.5, 1],
                    easing: "easeOutExpo",
                    duration: 600,
                    offset: '-=600',
                    update: function( ){
                   }
                }).add({
                    targets: '.ml5 .letters-left',
                    opacity: [0,1],
                    translateX: ["0.5em", 0],
                    easing: "easeOutExpo",
                    duration: 600,
                    offset: '-=300',
                    update: function( ){
                   }
                }).add({
                    targets: '.ml5 .letters-right',
                    opacity: [0,1],
                    translateX: ["-0.5em", 0],
                    easing: "easeOutExpo",
                    duration: 600,
                    offset: '-=600',
                    update: function( ){
                   }
                }).add({
                    targets: '.ml5',
                    opacity: 1,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1000,
                    update: function( ){
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
ctx.webkitImageSmoothingEnabled = false;
ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false; var png = canvas.toDataURL('image/png', 1.0);
                            if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            parent.document.getElementById('outimage_'+num).src = png;
                        });
                    }
                });
        };

        function animi_6(){
            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();

            $('#animation').html(
                '<span class="ml6">'+
                    '<span class="text-wrapper">'+
                        '<span class="letters">'+text+'</span>'+
                    '</span>'+
                '</span>');
            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');

            // Wrap every letter in a span
            $('.ml6 .letters').each(function(){
              $(this).html($(this).text().replace(/([^\x00-\x127]|\w)/g, "<span class='letter'>$&</span>"));
            });

            anime.timeline({loop: false})
                .add({
                targets: '.ml6 .letter',
                translateY: ["1.1em", 0],
                translateZ: 0,
                duration: 750,
                delay: function(el, i) {
                return 50 * i;
                },
                update: function( ){
                }
            }).add({
                targets: '.ml6',
                opacity: 1,
                duration: 1000,
                easing: "easeOutExpo",
                delay: 1000,
                update: function( ){
                    html2canvas(container).then(function(canvas) {
                        var ctx = canvas.getContext('2d');
ctx.webkitImageSmoothingEnabled = false;
ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false; var png = canvas.toDataURL('image/png', 1.0);
                        if(num == 1){
							iframe_png_array_1.push(png);
						} else if(num == 2){
							iframe_png_array_2.push(png);
						} else {
							iframe_png_array_3.push(png);
						}
                        parent.document.getElementById('outimage_'+num).src = png;
                    });
                }
            });
        };

        function animi_7(){
            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();

            $('#animation').html(
                '<span class="ml7">'+
                    '<span class="text-wrapper">'+
                        '<span class="letters">'+text+'</span>'+
                    '</span>'+
                '</span>');
            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');

            // Wrap every letter in a span
            $('.ml7 .letters').each(function(){
            $(this).html($(this).text().replace(/([^\x00-\x127]|\w)/g, "<span class='letter'>$&</span>"));
            });

            anime.timeline({loop: false})
                .add({
                    targets: '.ml7 .letter',
                    translateY: ["1.1em", 0],
                    translateX: ["0.55em", 0],
                    translateZ: 0,
                    rotateZ: [180, 0],
                    duration: 750,
                    easing: "easeOutExpo",
                    delay: function(el, i) {
                    return 50 * i;
                    },
                    update: function( ){
                    }
                }).add({
                    targets: '.ml7',
                    opacity: 1,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1000,
                    update: function( ){
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
ctx.webkitImageSmoothingEnabled = false;
ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false; var png = canvas.toDataURL('image/png', 1.0);
                            if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            parent.document.getElementById('outimage_'+num).src = png;
                        });
                    }
                });
        }

        function animi_8(){
            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();

            $('#animation').html(
                '<span class="ml10">'+
                    '<span class="text-wrapper">'+
                        '<span class="letters">'+text+'</span>'+
                    '</span>'+
                '</span>');
            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');
            // Wrap every letter in a span
            $('.ml10 .letters').each(function(){
            $(this).html($(this).text().replace(/([^\x00-\x127]|\w)/g, "<span class='letter'>$&</span>"));
            });

            anime.timeline({loop: false})
                .add({
                    targets: '.ml10 .letter',
                    rotateY: [-90, 0],
                    duration: 1300,
                    delay: function(el, i) {
                    return 45 * i;
                    },
                    update: function( ){
                    }
                }).add({
                    targets: '.ml10',
                    opacity: 1,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1000,
                    update: function( ){
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
ctx.webkitImageSmoothingEnabled = false;
ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false; var png = canvas.toDataURL('image/png', 1.0);
                            if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            parent.document.getElementById('outimage_'+num).src = png;
                        });
                    }
                });
        }

        function animi_10(){
            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');


            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();

            $('#animation').html(
                '<span class="ml8">'+
                '<span class="letters-container">'+
                    '<span class="letters letters-left">'+text+'</span>'+
                    '<span class="letters bang">!</span>'+
                '</span>'+
                '<span class="circle circle-white"></span>'+
                    '<span class="circle circle-dark"></span>'+
                    '<span class="circle circle-container"><span class="circle circle-dark-dashed"></span>'+
                '</span>'+
            '</span>');

            

            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');

            anime.timeline({loop: false})
                .add({
                    targets: '.ml8 .circle-white',
                    scale: [0, 3],
                    opacity: [1, 0],
                    easing: "easeInOutExpo",
                    rotateZ: 360,
                    duration: 1100,
                    update: function( ){
                    }
                }).add({
                    targets: '.ml8 .circle-container',
                    scale: [0, 1],
                    duration: 1100,
                    easing: "easeInOutExpo",
                    offset: '-=1000',
                    update: function( ){
                    }
                }).add({
                    targets: '.ml8 .circle-dark',
                    scale: [0, 1],
                    duration: 1100,
                    easing: "easeOutExpo",
                    offset: '-=600',
                    update: function( ){
                    }
                }).add({
                    targets: '.ml8 .letters-left',
                    scale: [0, 1],
                    duration: 1200,
                    offset: '-=550',
                    update: function( ){
                    }
                }).add({
                    targets: '.ml8 .bang',
                    scale: [0, 1],
                    rotateZ: [45, 15],
                    duration: 1200,
                    offset: '-=1000',
                    update: function( ){
                    }
                }).add({
                    targets: '.ml8',
                    opacity: 0,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1400,
                    update: function( ){
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
ctx.webkitImageSmoothingEnabled = false;
ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false; var png = canvas.toDataURL('image/png', 1.0);
                            if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            parent.document.getElementById('outimage_'+num).src = png;
                        });
                    }
                });

            anime({
                targets: '.ml8 .circle-dark-dashed',
                rotateZ: 360,
                duration: 8000,
                easing: "linear",
                loop: true,
                update: function( ){
                    html2canvas(container).then(function(canvas) {
                        var ctx = canvas.getContext('2d');
ctx.webkitImageSmoothingEnabled = false;
ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false; var png = canvas.toDataURL('image/png', 1.0);
                        if(num == 1){
							iframe_png_array_1.push(png);
						} else if(num == 2){
							iframe_png_array_2.push(png);
						} else {
							iframe_png_array_3.push(png);
						}
                        parent.document.getElementById('outimage_'+num).src = png;
                    });
                }
            });
        }

        function animi_11(){
            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();

            $('#animation').html(
                '<span class="ml9">'+
                    '<span class="text-wrapper">'+
                        '<span class="letters">'+text+'</span>'+
                    '</span>'+
                '</span>');
            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');

            // Wrap every letter in a span
            $('.ml9 .letters').each(function(){
            $(this).html($(this).text().replace(/([^\x00-\x127]|\w)/g, "<span class='letter'>$&</span>"));
            });

            anime.timeline({loop: false})
                .add({
                    targets: '.ml9 .letter',
                    scale: [0, 1],
                    duration: 1500,
                    elasticity: 600,
                    delay: function(el, i) {
                    return 45 * (i+1)
                    },
                    update: function( ){
                    }
                }).add({
                    targets: '.ml9',
                    opacity: 1,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1000,
                    update: function( ){
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
ctx.webkitImageSmoothingEnabled = false;
ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false; var png = canvas.toDataURL('image/png', 1.0);
                            if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            parent.document.getElementById('outimage_'+num).src = png;
                        });
                    }
                });
        }

        function animi_12(){
            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();

            $('#animation').html(
                '<span class="ml11">'+
                    '<span class="text-wrapper">'+
                        '<span class="line line1"></span>'+
                        '<span class="letters">'+text+'</span>'+
                    '</span>'+
                '</span>');
            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');

            // Wrap every letter in a span
            $('.ml11 .letters').each(function(){
            $(this).html($(this).text().replace(/([^\x00-\x127]|\w)/g, "<span class='letter'>$&</span>"));
            });

            anime.timeline({loop: false})
                .add({
                    targets: '.ml11 .line',
                    scaleY: [0,1],
                    opacity: [0.5,1],
                    easing: "easeOutExpo",
                    duration: 700,
                    update: function( ){
                    }
                })
                .add({
                    targets: '.ml11 .line',
                    translateX: [0,$(".ml11 .letters").width()],
                    easing: "easeOutExpo",
                    duration: 700,
                    delay: 100,
                    update: function( ){
                    }
                }).add({
                    targets: '.ml11 .letter',
                    opacity: [0,1],
                    easing: "easeOutExpo",
                    duration: 600,
                    offset: '-=775',
                    delay: function(el, i) {
                    return 34 * (i+1)
                    },
                    update: function( ){
                    }
                }).add({
                    targets: '.ml11',
                    opacity: 1,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1000,
                    update: function( ){
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
ctx.webkitImageSmoothingEnabled = false;
ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false; var png = canvas.toDataURL('image/png', 1.0);
                            if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            parent.document.getElementById('outimage_'+num).src = png;
                        });
                    }
                });
        }

        function animi_13(){
            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();

            $('#animation').html('<span class="ml12">'+text+'</span>');
            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');

            // Wrap every letter in a span
            $('.ml12').each(function(){
            $(this).html($(this).text().replace(/([^\x00-\x127]|\w)/g, "<span class='letter'>$&</span>"));
            });

            anime.timeline({loop: false})
                .add({
                    targets: '.ml12 .letter',
                    translateX: [40,0],
                    translateZ: 0,
                    opacity: [0,1],
                    easing: "easeOutExpo",
                    duration: 2000,
                    delay: function(el, i) {
                    return 500 + 30 * i;
                    },
                    update: function( ){
                    }
                }).add({
                    targets: '.ml12 .letter',
                    translateX: [0,-30],
                    opacity: [1,0],
                    easing: "easeInExpo",
                    duration: 2000,
                    delay: function(el, i) {
                    return 100 + 30 * i;
                    },
                    update: function( ){
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
ctx.webkitImageSmoothingEnabled = false;
ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false; var png = canvas.toDataURL('image/png', 1.0);
                            if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            parent.document.getElementById('outimage_'+num).src = png;
                        });
                    }
                });
        }

        function animi_14(){
            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();

            $('#animation').html('<span class="ml13">'+text+'</span>');
            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');

            // Wrap every letter in a span
            $('.ml13').each(function(){
            $(this).html($(this).text().replace(/([^\x00-\x127]|\w)/g, "<span class='letter'>$&</span>"));
            });

            anime.timeline({loop: false})
                .add({
                    targets: '.ml13 .letter',
                    translateY: [100,0],
                    translateZ: 0,
                    opacity: [0,1],
                    easing: "easeOutExpo",
                    duration: 1400,
                    delay: function(el, i) {
                    return 300 + 30 * i;
                    },
                    update: function( ){
                    }
                }).add({
                    targets: '.ml13 .letter',
                    translateY: [0,-100],
                    opacity: [1,0],
                    easing: "easeInExpo",
                    duration: 1200,
                    delay: function(el, i) {
                    return 100 + 30 * i;
                    },
                    update: function( ){
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
ctx.webkitImageSmoothingEnabled = false;
ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false; var png = canvas.toDataURL('image/png', 1.0);
                            if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            parent.document.getElementById('outimage_'+num).src = png;
                        });
                    }
                });
        }

        function animi_15(){
            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();

            $('#animation').html(
                '<span class="ml14">'+
                    '<span class="text-wrapper">'+
                        '<span class="letters">'+text+'</span>'+
                        '<span class="line"></span>'+
                    '</span>'+
                '</span>');
            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');
            $('.line').attr('style', 'opacity: 0; position: absolute;left: 0; bottom: 0; height: 4px; width: 100%;background-color: '+font_color+';transform-origin: 100% 100%;');

            // Wrap every letter in a span
            $('.ml14 .letters').each(function(){
            $(this).html($(this).text().replace(/([^\x00-\x127]|\w)/g, "<span class='letter'>$&</span>"));
            });

            anime.timeline({loop: false})
                .add({
                    targets: '.ml14 .line',
                    scaleX: [0,1],
                    opacity: [0.5,1],
                    easing: "easeInOutExpo",
                    duration: 900,
                    update: function( ){
                    }
                }).add({
                    targets: '.ml14 .letter',
                    opacity: [0,1],
                    translateX: [40,0],
                    translateZ: 0,
                    scaleX: [0.3, 1],
                    easing: "easeOutExpo",
                    duration: 800,
                    offset: '-=600',
                    delay: function(el, i) {
                    return 150 + 25 * i;
                    },
                    update: function( ){
                    }
                }).add({
                    targets: '.ml14',
                    opacity: 1,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1000,
                    update: function( ){
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
ctx.webkitImageSmoothingEnabled = false;
ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false; var png = canvas.toDataURL('image/png', 1.0);
                            if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            parent.document.getElementById('outimage_'+num).src = png;
                        });
                    }
                });
        }

        function animi_16(){
            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();

            var text_array = text.split(' ');
            var text1 = '';
            var text2 = '';
            if(text_array.length == 2){
            	html = 
	            	'<span class="ml15">'+
	                    '<span class="word">'+text_array[0]+'</span>&nbsp;&nbsp;'+
	                    '<span class="word">'+text_array[1]+'</span>'+
	                '</span>';                
            } else if(text_array.length == 1){

	            var length = text.length;
	            var text1_length = Math.floor(length/2);
	            var text2_length = length - text1_length;
            	text1 = text.substring(0, text1_length);
            	text2 = text.substring(text1_length, length);
            	html = 
	            	'<span class="ml15">'+
	                    '<span class="word">'+text1+'</span>'+
	                    '<span class="word">'+text2+'</span>'+
	                '</span>';
            } else {
            	html = 
	            	'<span class="ml15">'+
	                    '<span class="word">'+text_array[0]+'</span>&nbsp;&nbsp;'+
	                    '<span class="word">'+text_array[1]+'</span>'+
	                '</span>';
            }

            $('#animation').html(html);

            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');
            anime.timeline({loop: false})
                .add({
                    targets: '.ml15 .word',
                    scale: [14,1],
                    opacity: [0,1],
                    easing: "easeOutCirc",
                    duration: 800,
                    delay: function(el, i) {
                    return 800 * i;
                    },
                    update: function( ){
                    }
                }).add({
                    targets: '.ml15',
                    opacity: 1,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1000,
                    update: function( ){
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
ctx.webkitImageSmoothingEnabled = false;
ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false; var png = canvas.toDataURL('image/png', 1.0);
                            if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            parent.document.getElementById('outimage_'+num).src = png;
                        });
                    }
                });
        }

        function animi_17(){
            var container = document.getElementById('container');
            var canvas = document.querySelector('canvas');

            var num = $('input[name=edit_text]:checked').val();

			var text = $('#text_content_'+num).val();
            var font_family = $('#font_family').val();
            var font_size = $('#font_size').val();

            $('#animation').html(
                '<span class="ml16">'+text+'</span>');

            $('#animation').attr('style', 'font-family:'+font_family+'; font-size:' +font_size+'px; color: '+font_color+'; font-weight: 900;');

            // Wrap every letter in a span
            $('.ml16').each(function(){
            $(this).html($(this).text().replace(/([^\x00-\x127]|\w)/g, "<span class='letter'>$&</span>"));
            });

            anime.timeline({loop: false})
                .add({
                    targets: '.ml16 .letter',
                    translateY: [-100,0],
                    easing: "easeOutExpo",
                    duration: 1400,
                    delay: function(el, i) {
                    return 30 * i;
                    },
                    update: function( ){
                    }
                }).add({
                    targets: '.ml16',
                    opacity: 1,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1000,
                    update: function( ){
                        html2canvas(container).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
ctx.webkitImageSmoothingEnabled = false;
ctx.mozImageSmoothingEnabled = false;
ctx.imageSmoothingEnabled = false; var png = canvas.toDataURL('image/png', 1.0);
                            if(num == 1){
								iframe_png_array_1.push(png);
							} else if(num == 2){
								iframe_png_array_2.push(png);
							} else {
								iframe_png_array_3.push(png);
							}
                            parent.document.getElementById('outimage_'+num).src = png;
                        });
                    }
                });
        }

    </script>

</body>
</html>                             