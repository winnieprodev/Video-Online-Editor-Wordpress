<?php
/*
Template Name: Video Template
*/

	if ( !(is_user_logged_in()) ) {
		wp_redirect(home_url().'/login', 301);
	}
		
	$video_edit_url = content_url('themes/sydney');
	$admin_url = admin_url();
	$home_url = home_url();

	get_header();

	global $current_user;
	wp_get_current_user();

	$templatetypes = get_terms( array( 'taxonomy' => 'templatetype' ) );
	$args = array(
		'orderby' => 'date',
		'order' => 'DESC',
	  	'post_type' => 'template',
	  	'posts_per_page' => -1,
	);
	$query = new WP_Query($args);
	$all_templates = $query->posts;

?>

    <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $video_edit_url; ?>/assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link rel="shortcut icon" href="favicon.ico" /> </head>

    <div id="cover-spin"></div>
	<style type="text/css">
		#cover-spin {
		    position:fixed;
		    width:100%;
		    left:0;right:0;top:0;bottom:0;
		    background-color: rgba(255,255,255,0.7);
		    z-index:9999;
		    display:none;
		}

		@-webkit-keyframes spin {
			from {-webkit-transform:rotate(0deg);}
			to {-webkit-transform:rotate(360deg);}
		}

		@keyframes spin {
			from {transform:rotate(0deg);}
			to {transform:rotate(360deg);}
		}

		#cover-spin::after {
		    content:'';
		    display:block;
		    position:absolute;
		    left:48%;top:40%;
		    width:40px;height:40px;
		    border-style:solid;
		    border-color:black;
		    border-top-color:transparent;
		    border-width: 4px;
		    border-radius:50%;
		    -webkit-animation: spin .8s linear infinite;
		    animation: spin .8s linear infinite;
		}
	</style>

    <input id="video_edit_url" type="hidden" value="<?php echo $video_edit_url; ?>"/>
    <input id="home_url" type="hidden" value="<?php echo $home_url; ?>" />
    <input id="admin_url" type="hidden" value="<?php echo $admin_url; ?>" />
    <input id="video_post_id" type="hidden" value="<?php echo $video_post_id; ?>"/>

    <style type="text/css">
    	#templates .thumbnail {
    		margin-bottom: 8px;
    	}

    	.mt-overlay img{
    		width: 100%;
    	}
    </style>

	<div id="content" class="page-wrap" style="padding-top: 0px; padding-bottom: 200px;">
		<div style="margin-left: 0px; margin-right: 0px; width: 100%;">
			<div class="row" style="padding: 0px; margin: 0px;">

				<div class="col-md-12" style="padding-top:30px; padding-bottom: 40px;">
			                	
	        		<div class="dropdown col-md-2" style="padding-left: 10px;">
					  	<button id="template_menu" class="btn green-jungle dropdown-toggle" type="button" data-toggle="dropdown" style="font-size: 16px; font-weight: bold; border-radius: 0px; width: 180px;">All Templates
					  		<span class="caret"></span>
					  	</button>
					  	<ul class="dropdown-menu">
					  		<li class="active category">
					  			<input type="hidden" value="0" />
					  			<a href="#">All Templates</a>
					  		</li>

					  		<?php
					  			if( $templatetypes ) {
					  				foreach( $templatetypes as $template ) {
					  		?>
					  					<li class="category">
					  						<a href="#">
					  							<input type="hidden" value="<?php echo $template->term_id; ?>" />
					  							<span><?php echo $template->name ;?></span> 
					  							<span>(<?php echo get_term($template->term_id)->count; ?>)</span>
					  						</a>
					  					</li>
							<?php
									}
					  			}
					  		?>
					  	</ul>
					</div>

					<div class="form-group col-md-3" style="padding: 0px;">
					  	<input type="text" class="form-control" id="template_search" placeholder="Search for a template..." style="height: 37px;" />
					  	<button class="btn green-jungle template_search" style="float: right; margin-top: -37px; border-radius: 0px; height: 37px;"><i class="fa fa-search"></i></button>
					</div>

					<div class="col-md-5 create_video">
						<span class="btn green-jungle btn-outline btn-circle create_template_submit" style="float: right; border-radius: 0px; height: 37px; margin-right: 15px; width: 200px; font-weight: bold;">Create your own Template</span>
					</div>

					<form class="col-md-2 create_video" action="<?php echo home_url()?>/video-edit-detail/" method='post'>
						<span class="btn blue btn-outline btn-circle create_video_submit" style="float: right; border-radius: 0px; height: 37px; margin-right: 15px; width: 200px; font-weight: bold;">Create Video</span>
						<input class="template_id" type="hidden" name="template_id" />
						<input class="template_guid" type="hidden" name="template_guid" />
					</form>

					<br>
					<div class="col-md-12">
						<span class="template_name" style="color: gray; font-size: 16px; font-weight:bold;">Showing all templates</span>
					</div>
					<div class="templates row col-md-12" style="padding-top: 10px;">
				  		<?php
						if ( $all_templates ) {
			        		foreach ( $all_templates as $post ) : 
			            ?>	
			            	<div class="col-md-3" style="padding-right: 7px; padding-right: 7px;">
				            	<div class="template_select thumbnail" style="border-radius: 0px;">
		                            <div class="row" style="padding: 15px;">
		                                <div class="col-md-12">
		                                    <div class="mt-overlay-4" style="height: 200px; overflow: hidden;">
		                                        <?php echo $post->post_content ?>
		                                        <div class="mt-overlay">
		                                            <input type="hidden" value="<?php echo $post->ID; ?>=<?php $media=get_attached_media( 'image', $post->ID ); foreach($media as $key => $value){ echo $value->to_array()['guid'];} ?>"/>
		                                        </div>
		                                    </div>
		                                </div>
		                            </div>		                                                       
		                        </div>
	                    	</div>
	                        
			        	<?php
			        		endforeach;
					    }
					    ?>
					</div>

					<style type="text/css">
						.row { display: flex;flex-wrap: wrap;padding: 0 10px 4px 10px;}
						/*.templates {max-height: 500px;overflow-y: hidden;}*/
						.templates:hover{/*overflow-y: scroll;*/}
						/* Create two equal columns that sits next to each other */
						.column {flex: 20%;padding: 0 4px;}
						.column img {margin-top: 8px;vertical-align: middle;}
					</style>			        
				</div>


	<!-- BEGIN CORE PLUGINS -->
    <script type="text/javascript" src="<?php echo $video_edit_url; ?>/assets/global/plugins/jquery.min.js"></script>
	<!-- <script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script> -->
    <script type="text/javascript" src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $video_edit_url; ?>/assets/global/scripts/app.min.js"></script>
    <script type="text/javascript" src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" ></script>
    <script type="text/javascript" src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript" src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-summernote/summernote.min.js"></script>
    <script type="text/javascript" src="<?php echo $video_edit_url; ?>/assets/pages/scripts/components-editors.min.js"></script>
    <script type="text/javascript" src="<?php echo $video_edit_url; ?>/js/ajaxfileupload.js"></script>    


	<script type="text/javascript">

    	var video_edit_url = $('#video_edit_url').val();
    	var admin_url = $('#admin_url').val();
    	var home_url = $('#home_url').val();

    	var TEMPLATE = '';
    	var GUID = '';
    	var template_temp = '';

    	$('.mt-overlay-4').find('img').removeAttr('width');
    	$('.mt-overlay-4').find('img').attr('width', '100%');

		/***************************  Tempaltes  *************************/

    	$('.category').click(function(){
    		var menu_html = $(this).html() + '<span class="caret"></span>';
    		$('#template_menu').html(menu_html);
    		var menu_span = $(this).find('span').eq(0).html();
    		if($(this).find('a').html() == 'All Templates'){
    			$('.template_name').html('Showing all templates');
    		} else{
    			$('.template_name').html('Showing ' + menu_span + ' templates');
    		}
    		
    		$('#template_menu').find('a').attr('style','color: white;');
			$('#template_search').val('');
			var term_id = $(this).find('input').val();
			var send_data = {
				'term_id' : term_id
			}
			var ajax_url = admin_url + 'admin-ajax.php';

			$.ajax({
				url:ajax_url + '?action=get_category_post',
				type:'post',
				data:send_data,
	          	dataType: 'json',
				success:function(data){
					if(data.success == 1){
						var html = '';
						$.each(data.data, function (key, value) {
							html +=
								'<div class="col-md-3" style="padding-right: 7px; padding-right: 7px;">' +
									'<div class="template_select thumbnail" style="border-radius: 0px;">' +
			                            '<div class="row" style="padding:15px;">' +
			                                '<div class="col-md-12">' +
			                                    '<div class="mt-overlay-4" style="height: 200px; overflow: hidden;">' +
			                                        value.post_content +
			                                        '<div class="mt-overlay">' +
		                                            	'<input type="hidden" value="'+value.ID+'='+value.guid+'" />' +
			                                        '</div>' +
			                                    '</div>' +
			                                '</div>' +
			                            '</div>' +
			                        '</div>' +
		                        '</div>';
						});

						$('.templates').html(html);
						$('.mt-overlay-4').find('img').removeAttr('width');
    					$('.mt-overlay-4').find('img').attr('width', '100%');
						template_select();
					}
				}
			});
		});

		$('#template_search').val('');
		$('.template_search').click(function(){
			var template_name = $('#template_search').val();
			var send_data = {
				'template_name' : template_name
			}
			if($('#template_search').val() != ''){
				$('.template_name').html('Search result for "' + template_name + '"');
			} else {
				$('.template_name').html('Showing all tempaltes');				
			}
			
			var ajax_url = admin_url + 'admin-ajax.php';

			$.ajax({
				url:ajax_url + '?action=get_category_post',
				type:'post',
				data:send_data,
	          	dataType: 'json',
				success:function(data){
					if(data.success == 1){
						var html = '';
						$.each(data.data, function (key, value) {
							html +=
								'<div class="col-md-3" style="padding-right: 7px; padding-right: 7px;">' +
									'<div class="template_select thumbnail" style="border-radius: 0px;">' +
			                            '<div class="row" style="padding:15px;">' +
			                                '<div class="col-md-12">' +
			                                    '<div class="mt-overlay-4" style="height: 200px; overflow: hidden;">' +
			                                        value['post_content'] +
			                                        '<div class="mt-overlay">' +
		                                            	'<input type="hidden" value="'+value['ID']+'='+value['guid']+'" />' +
			                                        '</div>' +
			                                    '</div>' +
			                                '</div>' +
			                            '</div>' +
			                        '</div>' +
		                        '</div>';
						});

						$('.templates').html(html);
						$('.mt-overlay-4').find('img').removeAttr('width');
    					$('.mt-overlay-4').find('img').attr('width', '100%');
						template_select();
					}
				}
			});
		});

		$( "#template_search" ).keypress(function( event ) {
		  	if ( event.which == 13 ) {
		     	$('.template_search').click();
		  	}
		});

		template_select();

		function template_select(){
			$('.template_select').click(function(){
				var value = $(this).parent().find('input').val();
				var value_array = value.split('=');
				var template_id = value_array[0];
				var guid = value_array[1];
				if(TEMPLATE != template_id){
					TEMPLATE = template_id;
					GUID = guid;
					if(template_temp == ''){
						template_temp = $(this);						
						$(this).attr('style', 'border:3px solid #26C281; border-radius: 0px;');
					} else {
						template_temp.attr('style', 'border: 1px solid #ddd; border-radius: 0px;');
						template_temp = $(this);
						$(this).attr('style', 'border:3px solid #26C281; border-radius: 0px;');
					}					
				}
			});
		}

		/**************************** Create Video ********************************/

		$('.create_video_submit').click(function(){
			if(TEMPLATE == ''){
				alert('Please select template.');
			} else {
				$('.template_id').val(TEMPLATE);
				$('.template_guid').val(GUID);
				$('.create_video').submit();
			}			
		});

		$('.create_template_submit').click(function(){
			document.location.href = home_url + '/creating-template';
		});

</script>

<!-- footer -->

<?php get_footer(); ?>