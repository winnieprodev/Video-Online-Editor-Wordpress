<?php
    $content_url = $_GET['url'];
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script src="<?php echo $content_url; ?>/assets/subtitle/jquery.js"></script>
        <script src="<?php echo $content_url; ?>/assets/subtitle/jquery-ui.min.js"></script>        
        <script src="<?php echo $content_url; ?>/assets/subtitle/raphael.js"></script>
        <!-- style-player -->        
        <link href="<?php echo $content_url; ?>/assets/subtitle/amalia.js.min.css" rel="stylesheet">
        <!-- /style-player -->        
        <!-- script-player -->        
        <script src="<?php echo $content_url; ?>/assets/subtitle/amalia.js.min.js"></script>
        <script src="<?php echo $content_url; ?>/assets/subtitle/amalia.js-plugin-timeline.min.js"></script>
        <script src="<?php echo $content_url; ?>/js/interact.min.js" type="text/javascript"></script>
        <!-- <script src="../build/js/player-message-en.js" type="text/javascript" ></script>       -->
        <!-- /script-player -->
    </head>
    <body>
        <div class="container" style="width: 100%;">
            <div class="content">
                <div class="demo">
                    <div style="height: 350px;">
                        <div id="defaultPlayer"></div>
                    </div>
                    <div id="timeline" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <script>
            function video_show(video){           

                $( "#defaultPlayer" ).mediaPlayer( {
                    autoplay : false,
                    src : video,
                    controlBar :
                        {
                            sticky : true
                        },
                    plugins : {
                        list : [
                            {
                                'className' : 'fr.ina.amalia.player.plugins.TimelinePlugin',
                                'container' : '#timeline'
                            }
                        ]
                    }
                });

                setTimeout(function() {
                    //$('#timeline').attr('style','height: 140px;');
                    $('.toolsbar').attr('style', 'display: none;');
                }, 1000);

            }


            function append_subtitle_div(){
                var html = 
                    '<div id="working_panel_subtitle" class="working_panel_subtitle resize-container" style="width: 100%; height: 63px;">'+
                        // '<p id="subtitle_textarea" class="resize-drag" rows="3" style="width: 200px; height: 63px; max-height: 63px; padding:0px;">'+content+'</p>'+
                    '</div>';
                $('#timeline').append(html);
            }

            function append_subtitle(content, num){
                var html = '<div id="subtitle_textarea_'+num+'" class="resize-drag" style="box-sizing: border-box; width: 200px; height: 63px; max-height: 63px; padding: 5px; background-color: white; color: black; position: absolute; border-left: 3px solid #1b7fcc; border-right: 3px solid #1b7fcc;" attr_id="'+num+'">'+content+'</div>';

                $('#working_panel_subtitle').append(html);

                if(num == 0){
                    var prev_x = 0;
                    var prev_width = 0;
                    var prev_left = 0;
                } else {
                    var prev_x = $('#subtitle_textarea_'+num).prev().attr('data-x');
                    if(prev_x == undefined){
                        prev_x = 0;
                    }
                    var prev_left = $('#subtitle_textarea_'+num).prev().css('left');
                    if(prev_left == undefined){
                        prev_left = 0;
                    } else{
                        prev_left = prev_left.substring(0, prev_left.length-2);
                    }
                    
                    var prev_width = $('#subtitle_textarea_'+num).prev().css('width');
                    if(prev_width == undefined){
                        prev_width = 0;
                    } else{
                        prev_width = prev_width.substring(0, prev_width.length-2);
                        prev_width = Number(prev_width);
                        prev_width = prev_width;
                    }
                }
                

                var working_panel_subtitle = document.getElementById('working_panel_subtitle');
                var total_w = working_panel_subtitle.offsetWidth;

                total_w = Number(total_w);
                prev_x = Number(prev_x);
                prev_width = Number(prev_width);
                prev_left = Number(prev_left);

                var cur_time = current_time();
                var total_time = parent.VIDEO_DURATION;
                var calc_x = (cur_time / total_time) * total_w;

                var left = prev_x + prev_width + prev_left;
                if(calc_x > left){
                    var width = calc_x - left;
                } else {
                    var width = 150;
                }


                $('#subtitle_textarea_'+num).attr('style','box-sizing: border-box; left: '+left+'px; width: '+width+'px; height: 63px; max-height: 63px; padding: 5px; background-color: white; color: black; position: absolute; border-left: 3px solid #1b7fcc; border-right: 3px solid #1b7fcc;');  

                parent.subtitle_size_change( num, left / total_w, (left + width) / total_w );             

            }

            function bg_color_remove(num){
                // var width = $('#subtitle_textarea_'+num).css('width');
                // var left = $('#subtitle_textarea_'+num).css('left');
                // $('#subtitle_textarea_'+num).attr('style','left: '+left+'; width: '+width+'; height: 63px; max-height: 63px; padding: 5px; background-color: white; color: black; position: absolute; border-left: 3px solid #1b7fcc; border-right: 3px solid #1b7fcc;');
                $('#subtitle_textarea_'+num).css('background-color', 'white');
            }

            function bg_color_add(num){
                // var width = $('#subtitle_textarea_'+num).css('width');
                // var left = $('#subtitle_textarea_'+num).css('left');
                // var data_x = $('#subtitle_textarea_'+num).css('')
                // $('#subtitle_textarea_'+num).attr('style','left: '+left+'; width: '+width+'; height: 63px; max-height: 63px; padding: 5px; background-color: #c0edf1; color: black; position: absolute; border-left: 3px solid #1b7fcc; border-right: 3px solid #1b7fcc;');
                $('#subtitle_textarea_'+num).css('background-color', '#c0edf1');
            }

            function change_textarea(num, content){
                $('#subtitle_textarea_'+num).html(content);
            }

            function remove_subtitle_textarea(num){
                $('#subtitle_textarea_'+num).remove();
            }

            function change_subtitle(content){
                $('#subtitle_textarea').val(content);
            }

            function current_time(){
                var cur_time = $('.time-current').text();
                var cur_time_array = cur_time.split(':');
                var h = Number(cur_time_array[0]);
                var m = Number(cur_time_array[1]);
                var s = Number(cur_time_array[2]);
                var time = h * 3600 + m * 60 + s;
                return time;
            }




            function remove_subtitle(){
                $('#working_panel_subtitle').remove();
            }

            $(document).on('change', '#subtitle_textarea', function(){
                //console.log($(this).val());

                var working_panel_subtitle = document.getElementById('working_panel_subtitle');
                var total_w = working_panel_subtitle.offsetWidth;
                //total_w = total_w.substring(0, total_w.length-2);
                total_w = Number(total_w);

                //console.log(total_w);

                var x = $('#subtitle_textarea').attr('data-x');
                if(x < 0 || x == undefined){ x = 0;}
                x = Number(x);

                var subtitle_textarea = document.getElementById('subtitle_textarea');
                var w = subtitle_textarea.offsetWidth;
                //w = w.substring(0, w.length-2);
                w = Number(w);
                //console.log(w);
                //console.log(x);

                var content = $(this).val();
                parent.subtitle_content_change(content, x / total_w, (x + w) / total_w );
            });

            function get_start(){
                var working_panel_subtitle = document.getElementById('working_panel_subtitle');
                var total_w = working_panel_subtitle.offsetWidth;
                //total_w = total_w.substring(0, total_w.length-2);
                total_w = Number(total_w);

                var x = $('#subtitle_textarea').attr('data-x');
                if(x < 0 || x == undefined){ x = 0;}
                x = Number(x);

                return x / total_w;
            }

            function get_end(){
                var working_panel_subtitle = document.getElementById('working_panel_subtitle');
                var total_w = working_panel_subtitle.offsetWidth;
                //total_w = total_w.substring(0, total_w.length-2);
                total_w = Number(total_w);

                //console.log(total_w);

                var x = $('#subtitle_textarea').attr('data-x');
                if(x < 0 || x == undefined){ x = 0;}
                x = Number(x);

                var subtitle_textarea = document.getElementById('subtitle_textarea');
                var w = subtitle_textarea.offsetWidth;
                //w = w.substring(0, w.length-2);
                w = Number(w);

                return (x + w) / total_w;
            }

            // function timeline_style(){
            //     $('#timeline').css('height', '140px');
            //     $('.toolsbar').css('display', 'none');
            // }

            interact('.resize-drag')
                .draggable({
                    // enable inertial throwing
                    //inertia: true,
                    // keep the element within the area of it's parent
                    onmove: dragMoveListener,

                    restrict: {
                      restriction: "parent",
                      //endOnly: true,
                      elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
                    },
                    // enable autoScroll
                    //autoScroll: true,

                    // call this function on every dragmove event
                    
                    // call this function on every dragend event
                    // onend: function (event) {
                    //   var textEl = event.target.querySelector('p');

                    //   textEl && (textEl.textContent =
                    //     'moved a distance of '
                    //     + (Math.sqrt(Math.pow(event.pageX - event.x0, 2) +
                    //                  Math.pow(event.pageY - event.y0, 2) | 0))
                    //         .toFixed(2) + 'px');
                    // }
                })
                .resizable({
                    // resize from all edges and corners
                    edges: { left: true, right: true, bottom: false, top: false },

                    // keep the edges inside the parent
                    restrictEdges: {
                      outer: 'parent',
                      endOnly: true,
                    },

                    // minimum size
                    restrictSize: {
                      min: { width: 1, height: 50 },
                    },

                    inertia: true,
                })
                .on('resizemove', function (event) {
                    var target = event.target,
                        x = (parseFloat(target.getAttribute('data-x')) || 0),
                        y = (parseFloat(target.getAttribute('data-y')) || 0);

                    // update the element's style
                    target.style.width  = event.rect.width + 'px';
                    target.style.height = event.rect.height + 'px';

                    // translate when resizing from top or left edges
                    x += event.deltaRect.left;
                    y += event.deltaRect.top;

                    
                    target.style.webkitTransform = target.style.transform =
                        'translate(' + x + 'px,' + y + 'px)';

                    target.setAttribute('data-x', x);
                    target.setAttribute('data-y', y);
                    //target.textContent = Math.round(event.rect.width) + '\u00D7' + Math.round(event.rect.height);

                    var num = target.getAttribute('attr_id');

                    var working_panel_subtitle = document.getElementById('working_panel_subtitle');
                    var total_w = working_panel_subtitle.offsetWidth;
                    total_w = Number(total_w);

                    var left = target.style.left;
                    if(left == undefined){
                        left = 0;
                    } else {
                        left = left.substring(0, left.length-2);
                    }
                    left = Number(left);

                    x = Number(x);

                    var width = target.offsetWidth;
                    //width = width.substring(0, width.length-2);
                    width = Number(width);                

                    var start = left + x;
                    if(start < 0){
                        start = 0;
                    }

                    var end = left + x + width;

                    parent.subtitle_size_change( num, start / total_w, end / total_w );
                });

            function dragMoveListener (event) {
                var target = event.target,
                    // keep the dragged position in the data-x/data-y attributes
                    x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
                    y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

                // translate the element
                target.style.webkitTransform =
                target.style.transform =
                  'translate(' + x + 'px, ' + y + 'px)';

                // update the posiion attributes
                target.setAttribute('data-x', x);
                target.setAttribute('data-y', y);

                //console.log($(this).val());

                var num = target.getAttribute('attr_id');

                var working_panel_subtitle = document.getElementById('working_panel_subtitle');
                var total_w = working_panel_subtitle.offsetWidth;
                total_w = Number(total_w);

                var left = target.style.left;
                if(left == undefined){
                    left = 0;
                } else {
                    left = left.substring(0, left.length-2);
                }
                left = Number(left);

                x = Number(x);

                var width = target.offsetWidth;
                //width = width.substring(0, width.length-2);
                width = Number(width);                

                var start = left + x;
                if(start < 0){
                    start = 0;
                }

                var end = left + x + width;

                parent.subtitle_size_change( num, start / total_w, end / total_w );


            }

            // this is used later in the resizing and gesture demos
            window.dragMoveListener = dragMoveListener;


        </script>


    </body>
</html>
