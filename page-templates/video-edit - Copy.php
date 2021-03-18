<?php

/*

Template Name: Video Edit coppy

*/

	if ( !is_user_logged_in() ) {
		wp_redirect(home_url().'/login', 301);
	}
	
	$video_edit_url = content_url('themes/sydney');
	$admin_url = admin_url();
	$home_url = home_url();

	get_header();

	global $current_user;
	wp_get_current_user();

	if(isset($_POST['video_post_id'])){
		$video_post_id = $_POST['video_post_id'];
	} else {
		$video_post_id = 0;
	}

	$templatetypes = get_terms( array( 'taxonomy' => 'templatetype' ) );
	$args = array(
		'orderby' => 'date',
		'order' => 'DESC',
	  	'post_type' => 'template'
	);
	$query = new WP_Query($args);
	$all_templates = $query->posts;

	$all_my_upload_videos = get_posts( 
		array( 
			'author' => $current_user->ID, 
			'post_parent' => 0, 
			'orderby' => 'date', 
			'order' => 'DESC', 
			'post_type' => 'attachment',
			'post_mime_type' => 'video'
		) 
	);

	$all_images = get_posts( 
		array( 
			'post_parent' => 0, 
			'orderby' => 'date', 
			'order' => 'DESC', 
			'post_type' => 'attachment', 
			'post_mime_type' => 'image'
		)
	);

?>


	<!-- BEGIN GLOBAL MANDATORY STYLES -->
    <!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" /> -->
    <!-- <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" /> -->
    <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- <link href="<?php echo $video_edit_url; ?>/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/cubeportfolio/css/cubeportfolio.css" rel="stylesheet" type="text/css" /> -->
    <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
    <!-- <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css" /> -->
    <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $video_edit_url; ?>/assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <!-- <link href="<?php echo $video_edit_url; ?>/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- <link href="<?php echo $video_edit_url; ?>/assets/pages/css/portfolio.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- <link href="<?php echo $video_edit_url; ?>/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- <link href="<?php echo $video_edit_url; ?>/assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" /> -->
    <!-- <link href="<?php echo $video_edit_url; ?>/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" /> -->
    <link href="<?php echo $video_edit_url; ?>/assets/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" id="style_components" type="text/css" />
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
    </style>

	<div id="content" class="page-wrap" style="padding-top: 30px;">
		<div class="container content-wrapper" style="margin-left: 0px; margin-right: 0px; width: 100%;">
			<div class="row">

				<div class="container-fluid col-md-12">
					<div class="tabbable-line col-md-12" style=" min-height: 500px;">
			            <ul class="nav nav-tabs">
			                <li class="active template_tab">
			                    <a href="#templates" data-toggle="tab" style="font-size: 16px; font-weight: bold;"> TEMPLATES
			                    </a>
			                </li>
			                <li>
			                    <a href="#video_upload" data-toggle="tab" style="font-size: 16px; font-weight: bold;"> VIDEO UPLOAD </a>
			                </li>
			                <li>
			                    <a href="#text" data-toggle="tab" style="font-size: 16px; font-weight: bold;"> TEXT </a>
			                </li>
			                <li>
			                    <a href="#images" data-toggle="tab" style="font-size: 16px; font-weight: bold;"> IMAGES </a>
			                </li>
			                <li class="working_pane">
			                    <a href="#working_pane" data-toggle="tab" style="font-size: 16px; font-weight: bold;"> WORKING PANE </a>
			                </li>
			            </ul>
			            <div class="tab-content col-md-12">
			                <div class="tab-pane active" id="templates">
			                	<div class="dropdown col-md-2" style="padding: 0px;">
								  	<button id="template_menu" class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" style="font-size: 16px; font-weight: bold; border-radius: 0px;">TEMPLATES   
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
								  	<input type="text" class="form-control" id="template_search" placeholder="Search..." style="height: 35px;" />
								  	<button class="btn btn-success template_search" style="float: right; margin-top: -35px; border-radius: 0px;"><i class="fa fa-search"></i></button>
								</div>

								<div class="col-md-7"></div>
								<br>

								<div class="templates row col-md-12">
							  		<?php
									if ( $all_templates ) {
						        		foreach ( $all_templates as $post ) : 
						            ?>	
						            	<div class="col-md-3">
							            	<div class="mt-element-overlay thumbnail">
					                            <div class="row">
					                                <div class="col-md-12">
					                                    <div class="mt-overlay-4" style="height: 200px; overflow: hidden;">
					                                        <?php echo $post->post_content ?>
					                                        <div class="mt-overlay">
					                                            <h2><?php echo $post->post_title; ?></h2>
					                                            
					                                            <a class="mt-info btn default btn-outline template_select" href="#"> Select </a>
					                                            <input type="hidden" value="<?php echo $post->ID; ?>" />
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
									.row {
									  display: flex;
									  flex-wrap: wrap;
									  padding: 0 10px 4px 10px;
									}

									.templates {
										max-height: 500px;
										overflow-y: hidden;
									}
									.templates:hover{
										/*overflow-y: scroll;*/
									}

									/* Create two equal columns that sits next to each other */
									.column {
									  flex: 20%;
									  padding: 0 4px;
									}

									.column img {
									  margin-top: 8px;
									  vertical-align: middle;
									}
								</style>
			                </div>
			                <div class="tab-pane" id="video_upload">
			                	<input id="video_browse" type="file" name="video_browse" accept="video/*">
			                	<div class="col-md-3 text-center" style="border-style: dashed;">
			                		<div class="browse">
			                			<h1 style="padding-top: 0px;"><i class="fa fa-plus-circle"></i></h1>
				                    	<h3> UPLOAD VIDEO </h3>
			                		</div>                		
				                    <span class="file_name font-blue"></span><br><br>
				                    <button class="btn btn-success change" style="font-size: 10px;"> CHANGE </button>
				                    <button class="btn btn-success upload" style="font-size: 10px;"> UPLOAD </button><br><br>
			                	</div>
			                	<?php
									if ( $all_my_upload_videos ) {
						        		foreach ( $all_my_upload_videos as $post ) : 
						        			// $array = preg_split('/', $post->guid);
						        			// $post_name = $array[count($array) - 1];
						        			// var_dump($post_name); exit;
						        ?>
						            	<div class="col-md-3">
						            		<input type="hidden" value="<?php echo $post->ID; ?>"/>
						            		<video class="thumbnail" style="width: 100%; height: 200px; overflow: hidden;" src="<?php echo $post->guid; ?>" controls></video>
						            		<span style="font-size: 16px; font-weight: bold;"><?php echo $post->post_title; ?></span>
						            		<a class="video_select" href="#" style="float: right;"> Select </a>
						            		<!-- <span><i class="fa fa-check"></i></span> -->
						            	</div>
						       	<?php
						        		endforeach;
								    }
								?>
			                </div>
			                <div class="tab-pane" id="text">
			                    <div class="col-md-12">
			                        <div name="summernote" id="summernote_1"> </div>
			                    </div>
			                    <div class="col-md-12">
			                    	<span id="summernote_result"></span>
			                    </div>
			                </div>
			                <div class="tab-pane" id="images">
			                	<?php
									if ( $all_images ) {
						        		foreach ( $all_images as $post ) : 
						        ?>
						            	<div class="col-md-1 text-center thumbnail image_select_div">
						            		<input type="hidden" value="<?php echo $post->ID; ?>"/>
						            		<img style="height: 60px;" src="<?php echo $post->guid; ?>"/>

						            		<span style="font-size: 14px; font-weight: bold;"><?php echo $post->post_title; ?></span>
						            		<a class="image_select" href="#"> Select </a>
						            		<!-- <span><i class="fa fa-check"></i></span> -->
						            	</div>
						       	<?php
						        		endforeach;
								    }
								?>
			                    <!-- <img class="thumbnail" src="<?php echo $video_edit_url; ?>/image/AGNEW.GIF">
			                    <img class="thumbnail" src="<?php echo $video_edit_url; ?>/image/AWARDS.GIF">
			                    <img class="thumbnail" src="<?php echo $video_edit_url; ?>/image/SPINWB32.GIF"> -->
			                </div>
			                <div class="tab-pane" id="working_pane">
			                   	<div class="col-md-3" style="padding-left: 0px;">
			                   		<div class="panel-group accordion scrollable" id="accordion2">
			                            <div class="panel panel-default">
			                                <div class="panel-heading">
			                                    <h4 class="panel-title">
			                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_1"> Template </a>
			                                    </h4>
			                                </div>
			                                <div id="collapse_2_1" class="panel-collapse in">
			                                    <div class="panel-body">
			                                    	<div class="working_template" >
			                                    		<img id="drag_template" class="thumbnail"  draggable="true" ondragstart="drag(event)" src="<?php echo $video_edit_url; ?>/images/default.png"/>
			                                    	</div>
			                                        
			                                        <!-- <button class="btn btn-success" style="border-radius: 30px;"> <i class="fa fa-plus-circle"></i> Add </button> -->
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="panel panel-default">
			                                <div class="panel-heading">
			                                    <h4 class="panel-title">
			                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_2"> Upload Video </a>
			                                    </h4>
			                                </div>
			                                <div id="collapse_2_2" class="panel-collapse collapse">
			                                    <div class="panel-body">
			                                    	<div class="working_video">
			                                    		<!-- <img width="100%" src="<?php echo $video_edit_url; ?>/images/video_default.jpg" /> -->
			                                    		<video width="100%"  draggable="true" ondragstart="drag(event)"  src="<?php echo $video_edit_url; ?>/video/test.mp4"></video>
			                                    	</div>
			                                    	<!-- <button class="btn btn-success" style="border-radius: 30px;"> <i class="fa fa-plus-circle"></i> Add </button> -->                                    
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="panel panel-default">
			                                <div class="panel-heading">
			                                    <h4 class="panel-title">
			                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_3"> Text </a>
			                                    </h4>
			                                </div>
			                                <div id="collapse_2_3" class="panel-collapse collapse">
			                                    <div class="panel-body">
			                                        <div draggable="true" ondragstart="drag(event)">
			                                        	<span class="summernote_result"></span>
			                                        </div>
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="panel panel-default">
			                                <div class="panel-heading">
			                                    <h4 class="panel-title">
			                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_4"> Image </a>
			                                    </h4>
			                                </div>
			                                <div id="collapse_2_4" class="panel-collapse collapse">
			                                    <div class="panel-body">
			                                    	<div class="working_image">
			                                    		<!-- <img class="thumbnail" style="width: 70px; height: 70px;" draggable="true" ondragstart="drag(event)" src="<?php echo $video_edit_url; ?>/image/AWARDS.GIF"> -->
			                                    	</div>
			                                        
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="panel panel-default">
			                                <div class="panel-heading">
			                                    <h4 class="panel-title">
			                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_5"> Setting </a>
			                                    </h4>
			                                </div>
			                                <div id="collapse_2_5" class="panel-collapse collapse">
			                                    <div class="panel-body">
			                                        <div class="form-group">
													  	<label for="display_setting">Display Setting</label>
													  	<select class="form-control" id="display_setting">
													    	<option value="800x450">800 X 450 (16:9)</option>
													    	<option value="640x480">640 X 480 (4:3)</option>
													    	<option value="640x360">640 X 360 (16:9)</option>
													    	<option value="480x360">480 X 360 (4:3)</option>
													    	<option value="480x270">480 X 270 (16:9)</option>
													    	<option value='320x240'>320 X 240 (4:3)</option>
													    	<option value='320x180'>320 X 180 (16:9)</option>
													  	</select>
													</div>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>

			                        <div>
			                        	<button class="btn btn-success" data-toggle="modal" data-target="#rendering_name" style="border-radius: 30px;">SAVE & PREVIEW</button>
			                        	<button class="btn btn-success next_button" style="border-radius: 30px;">NEXT</button>
			                        </div>
			                   	</div>
			                   	<div class="col-md-9" style="border: 1px solid #ddd; padding:0px; min-height: 500px;">
			                   		<div id="working_project" class="working_project resize-container" style="width: 800px; height: 450px; border: 1px solid blue; display: inline-block; overflow: hidden;">
			                   			<img id="working_project_template" class="thumbnail resize-drag" style="box-sizing: border-box;" src="<?php echo $video_edit_url; ?>/images/default.png"/>
			                   		</div>
			                   		<span id="display_setting_value">800x450</span>            		              		  
			                   		
			                   	</div>


			                   	<!-- <div class="col-md-12 time_line" style="padding: 0px;">
					            	<div class="col-md-12" style="padding: 0px;">
					            		<div class="btn-group">
					            			<br>
										  	<button type="button" class="btn btn-primary"><i class="fa fa-photo"></i></button>
										  	<button type="button" class="btn btn-primary"><i class="fa fa-video-camera"></i></button>
										  	<button type="button" class="btn btn-primary"><i class="fa fa-font"></i></button>
										  	<button type="button" class="btn btn-primary"><i class="fa fa-meh-o"></i></button>
										  	<br><br>
										</div>
					            	</div>
					            	<div class="col-md-12" style="padding: 0px;">
					            		<div class="col-md-1" style="padding: 0px; width: 8%">
					            			<div style=" border: 1px solid #aaaaaa; width: 100%; height: 50px; padding-top: 2px; padding-left: 30px;">
					            				<span style="font-size: 30px;"><i class="fa fa-photo"></i></span>
					            			</div>
					            			
					            		</div>
					            		<div class="col-md-11" style="padding: 0px;">
					            			<div style="width: 100%; height: 50px; padding: 10px 0px 10px 0px; border: 1px solid #aaaaaa;" id="drop_template" draggable = "true" ondrop="drop(event)" ondragover="allowDrop(event)">		            			
					            			</div>
					            		</div>
					            	</div>
					            	<div class="col-md-12" style="padding: 0px;">
					            		<div class="col-md-1" style="padding: 0px; width: 8%">
					            			<div style=" border: 1px solid #aaaaaa; width: 100%; height: 50px; padding-top: 2px; padding-left: 30px;">
					            				<span style="font-size: 30px;"><i class="fa fa-video-camera"></i></span>
					            			</div>
					            			
					            		</div>
					            		<div class="col-md-11" style="padding: 0px;">
					            			<div style="width: 100%; height: 50px; padding: 10px 0px 10px 0px; border: 1px solid #aaaaaa;" id="drop_video" ondrop="drop(event)" ondragover="allowDrop(event)">		            			
					            			</div>
					            		</div>
					            	</div>
					            	<div class="col-md-12" style="padding: 0px;">
					            		<div class="col-md-1" style="padding: 0px; width: 8%">
					            			<div style=" border: 1px solid #aaaaaa; width: 100%; height: 50px; padding-top: 2px; padding-left: 30px;">
					            				<span style="font-size: 30px;"><i class="fa fa-font"></i></span>
					            			</div>
					            			
					            		</div>
					            		<div class="col-md-11" style="padding: 0px;">
					            			<div style="width: 100%; height: 50px; padding: 10px 0px 10px 0px; border: 1px solid #aaaaaa;" id="drop_text" ondrop="drop(event)" ondragover="allowDrop(event)">		            			
					            			</div>
					            		</div>
					            	</div>
					            	<div class="col-md-12" style="padding: 0px;">
					            		<div class="col-md-1" style="padding: 0px; width: 8%">
					            			<div style=" border: 1px solid #aaaaaa; width: 100%; height: 50px; padding-top: 2px; padding-left: 30px;">
					            				<span style="font-size: 30px;"><i class="fa fa-meh-o"></i></span>
					            			</div>
					            			
					            		</div>
					            		<div class="col-md-11" style="padding: 0px;">
					            			<div style="width: 100%; height: 50px; padding: 10px 0px 10px 0px; border: 1px solid #aaaaaa;" id="drop_image" ondrop="drop(event)" ondragover="allowDrop(event)">		            			
					            			</div>
					            		</div>
					            	</div>		            	
					            </div> -->
			                </div>
			            </div>
			        </div>
				</div>

				<!-- Modal -->
				<div id="rendering_name" class="modal fade" role="dialog">
				 	<div class="modal-dialog">

				    	<!-- Modal content-->
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<button type="button" class="close" data-dismiss="modal">&times;</button>
				        		<h4 class="modal-title">Save File Name</h4>
				      		</div>
				      		<div class="modal-body">
				        		<p>Please Input Save File Name</p>
				        		<input class="rendering_file_name form-control" type="input" />
				      		</div>
				      		<div class="modal-footer">
				      			<button type="button" class="btn btn-default save_preview_btn">Save</button>
				        		<button type="button" class="btn btn-default save_cancel" data-dismiss="modal">Close</button>
				      		</div>
				    	</div>

				  	</div>
				</div>


	<!-- BEGIN CORE PLUGINS -->
    <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <!-- <script src="http://code.jquery.com/jquery-latest.js"></script> -->
	<script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
    <script src="<?php echo $video_edit_url; ?>/assets/fancybox/jquery.fancybox-1.3.4.js" type="text/javascript"></script>
    <script src="<?php echo $video_edit_url; ?>/assets/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
    <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script> -->
    <!-- <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script> -->
    <!-- <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script> -->
    <!-- <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script> -->
    <!-- <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script> -->
    <script src="<?php echo $video_edit_url; ?>/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- <script src="<?php echo $video_edit_url; ?>/assets/pages/scripts/form-dropzone.min.js" type="text/javascript"></script> -->
    <!-- <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js" type="text/javascript"></script> -->
    <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
    <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
    <!-- <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript"></script> -->
    <!-- <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script> -->
    <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
    <script src="<?php echo $video_edit_url; ?>/assets/pages/scripts/components-editors.min.js" type="text/javascript"></script>
    <!-- <script src="<?php echo $video_edit_url; ?>/assets/pages/scripts/portfolio-2.min.js" type="text/javascript"></script> -->

    <script src="<?php echo $video_edit_url; ?>/js/ajaxfileupload.js" type="text/javascript"></script>
    <script src="<?php echo $video_edit_url; ?>/js/interact.min.js" type="text/javascript"></script>

    


	<script type="text/javascript">

    	var video_edit_url = $('#video_edit_url').val();
    	var admin_url = $('#admin_url').val();
    	var home_url = $('#home_url').val();

    	var TEMPLATE = '';
    	var VIDEO = '';
    	var IMAGE = '';
    	var TEXT = '';

    	var VIDEO_NUM = 0;
    	var IMAGE_NUM = 0;

    	var TEMPLATE_TEMP = '';
    	var VIDEO_TEMP = '';
    	var IMAGE_TEMP = '';

    	var video_temp = '';
    	var template_temp = '';
    	var image_temp = '';

    	$('#display_setting').val('800x450');


    	// ***************************  Working Upload  *************************

    	var video_post_id = $('#video_post_id').val();

    	var video_post_id_temp = video_post_id;
    	var video_post_id_temp_video = true;
    	var video_post_id_temp_image = true;

    	if( video_post_id != 0 ){
    		var ajax_url = admin_url + 'admin-ajax.php';
    		var send_data = {
    			'video_post_id' : video_post_id
    		}

			$.ajax({
				url:ajax_url + '?action=get_video_post_data',
				type:'post',
				data:send_data,
	          	dataType: 'json',
				success:function(data){
					if(data.success == 1){

						var video_post = data.video_post;

						var video_template = data.video_template;
						var video_video = data.video_video;
						var video_image = data.video_image;
						var video_result_video = data.video_result_video;

						var video_guid = video_post.guid;
						var video_post_tile = video_post.post_title;

						TEMPLATE = video_template.template_id;
						VIDEO = video_video.video_id;
						IMAGE = video_image.image_id;

						VIDEO_NUM = 1;
				    	IMAGE_NUM = 1;

				    	//TEMPLATE_TEMP = video_template.template_id;
				    	VIDEO_TEMP = '';
				    	IMAGE_TEMP = '';

				    	// video_temp = '';
				    	// template_temp = '';
				    	// image_temp = '';

						$('.template_tab').removeClass('active');
						$('#templates').removeClass('active');
						$('.working_pane').click();
						$('.working_pane').addClass('active');
						$('#working_pane').addClass('active');

						$('.working_project').attr('style', 'width: ' + video_template.display_width + 'px; height: ' + video_template.display_height + 'px; border: 1px solid blue; display: inline-block; overflow: hidden;' );

						var setting = video_template.display_width + 'x' + video_template.display_height;
						$('#display_setting').val(setting);
						$('#display_setting_value').html(setting);

						//$('#working_project_template').attr('style', 'width: '+video_template.template_width+'px; height: '+video_template.template_height+'px;');

						$('#working_project_template').attr('style', 'box-sizing: border-box; position: absolute; top: '+video_template.template_y+'px; left: '+video_template.template_x+'px; width:'+video_template.template_width+'px; height:'+video_template.template_height+'px;');

						$('.working_project').append('<video id="working_project_video" class="resize-drag-video" style="box-sizing: border-box; position: absolute; opacity: 0.8; width:'+video_video.video_width+'px; height:'+video_video.video_height+'px; transform: translate('+video_video.video_x+'px, '+video_video.video_y+'px);" data-y="'+video_video.video_y+'" data-x="'+video_video.video_x+'" src="' + video_video.video_url + '" ></video>');

						$('.working_project').append('<img id="working_project_image" class="resize-drag-video" style="box-sizing: border-box; position: absolute; opacity: 0.8; width:'+video_image.image_width+'px; height:'+video_image.image_height+'px; transform: translate('+video_image.image_x+'px, '+video_image.image_y+'px);" data-y="'+video_image.image_y+'" data-x="'+video_image.image_x+'" src="' + video_image.image_url + '"/>');
					}
				}
			});
    	}

		// ***************************  Tempaltes  *************************
		$('a#template_view_more').fancybox();

    	$('.category').click(function(){
    		var menu_html = $(this).html() + '<span class="caret"></span>';
    		$('#template_menu').html(menu_html);
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
								'<div class="col-md-3">' +
									'<div class="mt-element-overlay thumbnail">' +
			                            '<div class="row">' +
			                                '<div class="col-md-12">' +
			                                    '<div class="mt-overlay-4" style="height: 200px; overflow: hidden;">' +
			                                        value.post_content +
			                                        '<div class="mt-overlay">' +
			                                            '<h2>' + value.post_title + '</h2>' +
			                                            //'<a id="template_view_more" class="mt-info btn default btn-outline" href="'+value.guid+'">More</a>&nbsp;' +
		                                            	'<a class="mt-info btn default btn-outline template_select" href="#">Select</a>' +
		                                            	'<input type="hidden" value="'+value.ID+'" />' +
			                                        '</div>' +
			                                    '</div>' +
			                                '</div>' +
			                            '</div>' +
			                        '</div>' +
		                        '</div>';
						});

						$('.templates').html(html);
						$('a#template_view_more').fancybox();
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
								'<div class="col-md-3">' +
									'<div class="mt-element-overlay thumbnail">' +
			                            '<div class="row">' +
			                                '<div class="col-md-12">' +
			                                    '<div class="mt-overlay-4" style="height: 200px; overflow: hidden;">' +
			                                        value['post_content'] +
			                                        '<div class="mt-overlay">' +
			                                            '<h2>' + value['post_title'] + '</h2>' +
			                                            //'<a id="template_view_more" class="mt-info btn default btn-outline" href="'+value['guid']+'">More</a>&nbsp;' +
		                                            	'<a class="mt-info btn default btn-outline template_select" href="#">Select</a>' +
		                                            	'<input type="hidden" value="'+value['ID']+'" />' +
			                                        '</div>' +
			                                    '</div>' +
			                                '</div>' +
			                            '</div>' +
			                        '</div>' +
		                        '</div>';
						});

						$('.templates').html(html);
						$('a#template_view_more').fancybox();
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
				var template_id = $(this).parent().find('input').val();
				if(TEMPLATE != template_id){
					if(template_temp == ''){
						template_temp = $(this);
						TEMPLATE = $(this).parent().find('input').val();
						$(this).parent().parent().parent().parent().parent().attr('style', 'border:3px solid green');
					} else {
						template_temp.parent().parent().parent().parent().parent().attr('style', 'border: 1px solid #ddd; border-radius: 4px;');
						template_temp = $(this);
						TEMPLATE = $(this).parent().find('input').val();
						$(this).parent().parent().parent().parent().parent().attr('style', 'border:3px solid green');
					}
					
				}
			});
		}
		
// ****************************************************************

// **************************** Text Edit *************************


// ************************** Video Upload ************************
		$('#video_browse').hide();
		$('.browse').click(function(){
			$('#video_browse').click();
		});

		$('.upload').hide();
		$('.change').hide();

		$('#video_browse').change(function(){
			var video_url = $('#video_browse').val();
			var url_split = video_url.split('\\');
			$('.file_name').html(url_split[url_split.length - 1]);
			if($('#video_browse').val() != ''){
				$('.upload').show();
				$('.change').show();
			} else {
				$('.upload').hide();
				$('.change').hide();
			}
		});

		$('.change').click(function(){
			$('#video_browse').click();
		});

		$('.video_select').click(function(){
			var video_id = $(this).parent().find('input').val();
			if(VIDEO != video_id){
				if(video_temp == ''){
					video_temp = $(this);
					VIDEO = $(this).parent().find('input').val();
					VIDEO_NUM ++;
					$(this).append('<i class="fa fa-check"></i>');
				} else {
					video_temp.html(' Select ');
					video_temp = $(this);
					VIDEO = $(this).parent().find('input').val();
					VIDEO_NUM ++;
					$(this).append('<i class="fa fa-check"></i>');
				}
				
			}
		});

		// $('.image_select').click(function(){
		// 	var image_id = $(this).parent().find('input').val();
		// 	if(IMAGE != image_id){
		// 		if(image_temp == ''){
		// 			image_temp = $(this);
		// 			IMAGE = $(this).parent().find('input').val();
		// 			$(this).append('<i class="fa fa-check"></i>');
		// 		} else {
		// 			image_temp.html(' Select ');
		// 			image_temp = $(this);
		// 			IMAGE = $(this).parent().find('input').val();
		// 			$(this).append('<i class="fa fa-check"></i>');
		// 		}
				
		// 	}
		// });

		$('.image_select_div').click(function(){
			var image_id = $(this).find('input').val();
			if(IMAGE != image_id){
				if(image_temp == ''){
					image_temp = $(this);
					IMAGE = $(this).find('input').val();
					IMAGE_NUM ++;
					$(this).find('a').append('<i class="fa fa-check"></i>');
				} else {
					image_temp.find('a').html(' Select ');
					image_temp = $(this);
					IMAGE = $(this).find('input').val();
					IMAGE_NUM ++;
					$(this).find('a').append('<i class="fa fa-check"></i>');
				}
				
			}
		});

		$('.upload').click(function(){

			var ajax_url = admin_url + 'admin-ajax.php';

            $.ajaxFileUpload({
                url : ajax_url+"?action=upload_file",
                secureuri : false,
                fileElementId:'video_browse',
                dataType: 'json',
                beforeSend: function () {
	        		// Show image container
	    			$("#cover-spin").show();
		        },
                success: function (data, status)
                {   
                	if(data.success == 1){
						var video_url = data.msg;
						var attach_id = data.attach_id;
						var url_split = video_url.split('/');
						var file_name = url_split[url_split.length - 1];

						$('.upload').hide();
						$('.change').hide();
						$('.file_name').html('');
						var html = '<div class="col-md-3">' + 
										'<input type="hidden" value="' + attach_id + '" />' +
										'<video class="thumbnail" style="width: 100%; height: 200px; overflow: hidden;" src="' + video_url + '" controls></video>' +
										'<span style="font-size: 16px; font-weight: bold;">' + file_name + '</span>' +
										'<a class="video_select" href="#" style="float: right;"> Select </a>' +
									'</div>';

						$('#video_upload').append(html);

						$('#video_browse').change(function(){
							var video_url = $('#video_browse').val();
							var url_split = video_url.split('\\');
							$('.file_name').html(url_split[url_split.length - 1]);
							if($('#video_browse').val() != ''){
								$('.upload').show();
								$('.change').show();
							} else {
								$('.upload').hide();
								$('.change').hide();
							}
						});

						$('.change').click(function(){
							$('#video_browse').click();
						});

						$('.video_select').click(function(){
							var video_id = $(this).parent().find('input').val();
							if(VIDEO != video_id){
								if(video_temp == ''){
									video_temp = $(this);
									VIDEO = $(this).parent().find('input').val();
									$(this).append('<i class="fa fa-check"></i>');
								} else {
									video_temp.html(' Select ');
									video_temp = $(this);
									VIDEO = $(this).parent().find('input').val();
									$(this).append('<i class="fa fa-check"></i>');
								}
								
							}
						});
                	}
                },
                error: function (data, status, e)
                {                                       
                    ;
                },
		        complete:function(data){
				    // Hide image container
				    $("#cover-spin").hide();
			   	}
            });
		});
// ************************************************************

// ************************* Woking Pane **********************
		$('.working_pane').click(function(){		

			/* Get template details */
			if( TEMPLATE != '' ){
				if( TEMPLATE != TEMPLATE_TEMP ){
					TEMPLATE_TEMP = TEMPLATE;
					var send_data = {
						'template_id' : TEMPLATE
					}
					var ajax_url = admin_url + 'admin-ajax.php';

					$.ajax({
						url:ajax_url + '?action=get_my_post',
						type:'post',
						data:send_data,
			          	dataType: 'json',
						success:function(data){
							if(data.success == 1){

								$.each(data.data, function (key, value) {
									var array_guid = value.guid.split('/');
									var name = array_guid[array_guid.length - 1];

									$('.working_template').html(
										'<div class="col-md-12" style="padding:0px;">' + 
											'<div class="col-md-4" style="padding:0px;">' + 
												'<img class="thumbnail" draggable="true" ondragstart="drag(event)" src="' + value.guid + '"/>' + 
											'</div>' + 
											'<div class="col-md-8">' + 
												'<span>' + name + '</span><br>' + 
												//'<a href="#">Remove</a>' + 
											'</div>' + 
										'</div>'
									);

									//if(video_post_id_temp == 0){
										$('#working_project_template').attr('src', value.guid);
									//}
									
									
									$('#drop_template').html('<div class="text-center" style="width: 300px; height: 25px; background-color: #ccc;"><span>' + name + '</span>&nbsp;<span class="drop_template_close"><i class="fa fa-close"></i></span>');
									$('.drop_template_close').click(function(){
										$('#drop_template').html('');
										$('#working_project_template').attr('src', video_edit_url + '/images/default.png');
									});
								});
							}
						}
					});
				}
			}

			if( VIDEO != '' ){
				if( VIDEO != VIDEO_TEMP ){
					VIDEO_TEMP = VIDEO;
					var send_data = {
						'video_id' : VIDEO
					}
					var ajax_url = admin_url + 'admin-ajax.php';

					$.ajax({
						url:ajax_url + '?action=get_my_post',
						type:'post',
						data:send_data,
			          	dataType: 'json',
						success:function(data){
							if(data.success == 1){
								var array_guid = data.data.guid.split('/');
								var name = array_guid[array_guid.length - 1];
								$('.working_video').html(
									'<div class="col-md-12" style="padding:0px;">' + 
										'<div class="col-md-4" style="padding:0px;">' + 
											'<video class="thumbnail" draggable="true" ondragstart="drag(event)" style="width:100%;" src="' + data.data.guid + '" ></video>' + 
										'</div>' + 
										'<div class="col-md-8">' + 
											'<span>' + name + '</span><br>' + 
											//'<a href="#">Remove</a>' + 
										'</div>' + 
									'</div>'
								);

								if(video_post_id_temp == 0){
									if(VIDEO_NUM == 1){
										$('.working_project').append('<video id="working_project_video" class="resize-drag-video" style="box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 0.8;" src="' + data.data.guid + '" ></video>');
									} else {
										$('#working_project_video').attr('src', data.data.guid);
									}
									
								}

								var html = '<div class="text-center" style="width: 300px; height: 25px; background-color: #ccc;"><span>' + name + '</span>&nbsp;<span class="drop_video_close"><i class="fa fa-close"></i></span></div>';
					    		$('#drop_video').append(html);
					    		$('.drop_video_close').click(function(){
									$('#drop_video').html('');
									$('#working_project_video').attr('src', '');
								});

								video_post_id_temp_video = false;

								if(video_post_id_temp_image){
									;
								} else {
									video_post_id_temp = 0;
								}
							}
						}
					});
				}
			}

			if( IMAGE != '' ){
				if( IMAGE != IMAGE_TEMP ){
					IMAGE_TEMP = IMAGE;
					var send_data = {
						'image_id' : IMAGE
					}
					var ajax_url = admin_url + 'admin-ajax.php';

					$.ajax({
						url:ajax_url + '?action=get_my_post',
						type:'post',
						data:send_data,
			          	dataType: 'json',
						success:function(data){
							if(data.success == 1){
								$('.working_image').html('<img class="thumbnail" draggable="true" ondragstart="drag(event)" style="width:70px; height: 70px;" src="' + data.data.guid + '" />');

								if(video_post_id_temp == 0){
									// $('.working_project').append('<img id="working_project_image" class="resize-drag-video" style="box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 0.8;" src="' + data.data.guid + '" />');
									if( IMAGE_NUM == 1 ){
										$('.working_project').append('<img id="working_project_image" class="resize-drag-video" style="box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 0.8;" src="' + data.data.guid + '" />');
									} else {
										$('#working_project_image').attr('src', data.data.guid);
									}									
								}

								var array_guid = data.data.guid.split('/');
								var name = array_guid[array_guid.length - 1];
					    		var html = '<div class="text-center" style="width: 300px; height: 25px; background-color: #ccc;"><span>' + name + '</span>&nbsp;<span class="drop_image_close"><i class="fa fa-close"></i></span></div>';
					    		$('#drop_image').append(html);
					    		$('.drop_image_close').click(function(){
									$('#drop_image').html('');
									$('#working_project_image').attr('src', '');
								});

								video_post_id_temp_image = false;

								if(video_post_id_temp_video){
									;
								} else {
									video_post_id_temp = 0;
								}
							}
						}
					});
				}
			}


			/* Get text info */

			var htmlContent = $('#summernote_1').summernote('code');
			if(htmlContent != '') {
				TEXT = htmlContent;
				$('.summernote_result').html(htmlContent);
				console.log(htmlContent);
			}

			if( TEXT != ''){
				$('.working_project').append('<div id="working_project_text" class="resize-drag-text" style="box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 0.8;">' + TEXT +'</div>');
			}

			/* */
		
		});


		function allowDrop(ev) {
		    ev.preventDefault();
		}

		function drag(ev) {
		    ev.dataTransfer.setData("text", ev.target.id);							    
		    drag_element = ev.target.src;;
		}

		function drop(ev) {

		    ev.preventDefault();
		    var data = ev.dataTransfer.getData("text");

		    var url = drag_element;
		    var array_url = url.split('/');
		    var name = array_url[(array_url.length - 1)];
		    var array_name = name.split('.');
		    var type = array_name[(array_name.length - 1)];
		    if( type == 'mp4' || type == 'avi' || type == 'mov' ){
		    	if($(ev.target)[0].id == 'drop_video'){
		    		$('.working_project').append('<video id="working_project_video" class="resize-drag-video" style="box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 0.8;" src="' + url + '" ></video>');
		    		var html = '<div class="text-center" style="width: 300px; height: 25px; background-color: #ccc;"><span>' + name + '</span>&nbsp;<span class="drop_video_close"><i class="fa fa-close"></i></span></div>';
		    		$(ev.target).append(html);
		    		$('.drop_video_close').click(function(){
						$('#drop_video').html('');
						$('#working_project_video').attr('src', '');
					});
		    	}	    	
		    } else if( type == 'jpg' || type == 'png' || type == 'bmp' ) {
		    	if($(ev.target)[0].id == 'drop_template'){
		    		$('#working_project_template').attr('src', url);
		    		var html = '<div class="text-center" style="width: 300px; height: 25px; background-color: #ccc;"><span>' + name + '</span>&nbsp;<span class="drop_template_close"><i class="fa fa-close"></i></span></div>';
		    		$(ev.target).append(html);
		    		$('.drop_template_close').click(function(){
						$('#drop_template').html('');
						$('#working_project_template').attr('src', video_edit_url + '/images/default.png');
					});
		    	}
		    } else if( type == 'gif' ) {
		    	if($(ev.target)[0].id == 'drop_image'){
		    		$('.working_project').append('<img id="working_project_image" class="resize-drag-image" style="box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 0.8;" src="' + url + '" />');
		    		var html = '<div class="text-center" style="width: 300px; height: 25px; background-color: #ccc;"><span>' + name + '</span>&nbsp;<span class="drop_image_close"><i class="fa fa-close"></i></span></div>';
		    		$(ev.target).append(html);
		    		$('.drop_image_close').click(function(){
						$('#drop_image').html('');
						$('#working_project_image').attr('src', '');
					});
		    	}
		    }  
		}

// ************************************************************

// ************************  Resize  *************************
		interact('.resize-drag')
		  	.draggable({
			    // enable inertial throwing
			    inertia: true,
			    // keep the element within the area of it's parent
			    restrict: {
			      restriction: "parent",
			      endOnly: true,
			      elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
			    },
			    // enable autoScroll
			    autoScroll: true,

			    // call this function on every dragmove event
			    onmove: dragMoveListener,
			    // call this function on every dragend event
			    onend: function (event) {
			      var textEl = event.target.querySelector('p');

			      textEl && (textEl.textContent =
			        'moved a distance of '
			        + (Math.sqrt(Math.pow(event.pageX - event.x0, 2) +
			                     Math.pow(event.pageY - event.y0, 2) | 0))
			            .toFixed(2) + 'px');
			    }
		  	})
		  	.resizable({
			    // resize from all edges and corners
			    edges: { left: true, right: true, bottom: true, top: true },

			    // keep the edges inside the parent
			    restrictEdges: {
			      outer: 'parent',
			      endOnly: true,
			    },

			    // minimum size
			    restrictSize: {
			      min: { width: 100, height: 50 },
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
			    target.textContent = Math.round(event.rect.width) + '\u00D7' + Math.round(event.rect.height);
		  	});
		interact('.resize-drag-video')
		  	.draggable({
			    // enable inertial throwing
			    inertia: true,
			    // keep the element within the area of it's parent
			    restrict: {
			      restriction: "parent",
			      endOnly: true,
			      elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
			    },
			    // enable autoScroll
			    autoScroll: true,

			    // call this function on every dragmove event
			    onmove: dragMoveListener,
			    // call this function on every dragend event
			    onend: function (event) {
			      var textEl = event.target.querySelector('p');

			      textEl && (textEl.textContent =
			        'moved a distance of '
			        + (Math.sqrt(Math.pow(event.pageX - event.x0, 2) +
			                     Math.pow(event.pageY - event.y0, 2) | 0))
			            .toFixed(2) + 'px');
			    }
		  	})
		  	.resizable({
			    // resize from all edges and corners
			    edges: { left: true, right: true, bottom: true, top: true },

			    // keep the edges inside the parent
			    restrictEdges: {
			      outer: 'parent',
			      endOnly: true,
			    },

			    // minimum size
			    restrictSize: {
			      min: { width: 100, height: 50 },
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
			    target.textContent = Math.round(event.rect.width) + '\u00D7' + Math.round(event.rect.height);
		  	});

		interact('.resize-drag-text')
		  	.draggable({
			    // enable inertial throwing
			    inertia: true,
			    // keep the element within the area of it's parent
			    restrict: {
			      restriction: "parent",
			      endOnly: true,
			      elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
			    },
			    // enable autoScroll
			    autoScroll: true,

			    // call this function on every dragmove event
			    onmove: dragMoveListener,
			    // call this function on every dragend event
			    onend: function (event) {
			      var textEl = event.target.querySelector('p');

			      textEl && (textEl.textContent =
			        'moved a distance of '
			        + (Math.sqrt(Math.pow(event.pageX - event.x0, 2) +
			                     Math.pow(event.pageY - event.y0, 2) | 0))
			            .toFixed(2) + 'px');
			    }
		  	})
		  	// .resizable({
			  //   // resize from all edges and corners
			  //   edges: { left: true, right: true, bottom: true, top: true },

			  //   // keep the edges inside the parent
			  //   restrictEdges: {
			  //     outer: 'parent',
			  //     endOnly: true,
			  //   },

			  //   // minimum size
			  //   restrictSize: {
			  //     min: { width: 100, height: 50 },
			  //   },

			  //   inertia: true,
		  	// })
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
		  	});

		interact('.resize-drag-image')
		  	.draggable({
			    // enable inertial throwing
			    inertia: true,
			    // keep the element within the area of it's parent
			    restrict: {
			      restriction: "parent",
			      endOnly: true,
			      elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
			    },
			    // enable autoScroll
			    autoScroll: true,

			    // call this function on every dragmove event
			    onmove: dragMoveListener,
			    // call this function on every dragend event
			    onend: function (event) {
			      var textEl = event.target.querySelector('p');

			      textEl && (textEl.textContent =
			        'moved a distance of '
			        + (Math.sqrt(Math.pow(event.pageX - event.x0, 2) +
			                     Math.pow(event.pageY - event.y0, 2) | 0))
			            .toFixed(2) + 'px');
			    }
		  	})
		  	.resizable({
			    // resize from all edges and corners
			    edges: { left: true, right: true, bottom: true, top: true },

			    // keep the edges inside the parent
			    restrictEdges: {
			      outer: 'parent',
			      endOnly: true,
			    },

			    // minimum size
			    restrictSize: {
			      min: { width: 100, height: 50 },
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
			    target.textContent = Math.round(event.rect.width) + '\u00D7' + Math.round(event.rect.height);
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
		 }

	  	// this is used later in the resizing and gesture demos
	  	window.dragMoveListener = dragMoveListener;

	  	// ********************* Display Setting *********************
	  	$('#display_setting').change(function(){
	  		var setting = $('#display_setting').val();
	  		$('#display_setting_value').html(setting);
	  		var setting_array = setting.split('x');
	  		var width = setting_array[0];
	  		var height = setting_array[1];

	  		$('.working_project').attr('style', 'width: ' + width + 'px; height: ' + height + 'px; border: 1px solid blue; display: inline-block; overflow: hidden;' );

	  	})

	  	// *************************** Rendering *********************
	  	$('.save_preview_btn').click(function(){
	  		if($('.rendering_file_name').val() == ''){
	  			alert('Please Input Save File Name.');
	  		} else {
		  		var project_video_name = $('.rendering_file_name').val();
		  		$('.rendering_file_name').val('');
		  		$('.save_cancel').click();


		  		var working_project = document.getElementById('working_project');

		  		var setting = $('#display_setting').val();
		  		var setting_array = setting.split('x');
		  		var width = setting_array[0];
		  		var height = setting_array[1];


		  		// var display_width = working_project.clientWidth;
		  		// var display_height = working_project.clientHeight;

		  		var display_width = width;
		  		var display_height = height;

		  		var template_id = TEMPLATE;
		  		var template_url = $('#working_project_template').attr('src');
		  		var working_project_template = document.getElementById('working_project_template');
		  		var template_H = working_project_template.clientHeight;
		  		var template_W = working_project_template.clientWidth;
		  		var template_y = $('#working_project_template').attr('data-y');
		  		var template_x = $('#working_project_template').attr('data-x');

		  		var video_id = VIDEO;
		  		var video_url = $('#working_project_video').attr('src');
		  		var working_project_video = document.getElementById('working_project_video');
		  		var video_h = working_project_video.clientHeight;
		  		var video_w = working_project_video.clientWidth;
		  		var video_y = $('#working_project_video').attr('data-y');
		  		var video_x = $('#working_project_video').attr('data-x');

		  		var image_id = IMAGE;
		  		var image_url = $('#working_project_image').attr('src');
		  		var working_project_image = document.getElementById('working_project_image');
		  		var image_h = working_project_image.clientHeight;
		  		var image_w = working_project_image.clientWidth;
		  		var image_y = $('#working_project_image').attr('data-y');
		  		var image_x = $('#working_project_image').attr('data-x');


		  		project_video_name = project_video_name.replace(" ", "_");
		  		project_video_name = project_video_name.replace(".", "");
		  		var send_data = {
		  			'display_h' : display_height,
		  			'display_w' : display_width,

		  			'template_id' : template_id,
		  			'template_url' : template_url,
		  			'template_H' : template_H,
		  			'template_W' : template_W,
		  			'template_x' : template_x,
		  			'template_y' : template_y,

		  			'video_id' : video_id,
		  			'video_url' : video_url,
		  			'video_h' : video_h,
		  			'video_w' : video_w,
		  			'video_x' : video_x,
		  			'video_y' : video_y,

		  			'image_id' : IMAGE,
		  			'image_url' : image_url,
		  			'image_h' : image_h,
		  			'image_w' : image_w,
		  			'image_x' : image_x,
		  			'image_y' : image_y,
		  			'result_video_name' : project_video_name
		  		};

		  		var ajax_url = admin_url + 'admin-ajax.php';

				$.ajax({
					url:ajax_url + '?action=rendering',
					type:'post',
					data:send_data,
		          	dataType: 'json',
					beforeSend: function () {
		        		// Show image container
		    			$("#cover-spin").show();
			        },
			        success: function (res) {
			        	console.log(res);
			        },
			        error: function (err) {
			        },
			        complete:function(data){
			        	console.log(data);
					    // Hide image container
					    $("#cover-spin").hide();
					    if(data.responseJSON.success == 1){
					    	var post_id = data.responseJSON.post_id;
					    	var result_video = data.responseJSON.result_video;
					    	var html = '<video class="project_result_video" src="' + result_video + '" controls></video>';
					    	$('.working_project').html(html);

					    }
				   	}
				});
			}
	  	});

	  	$('.next_button').click(function(){
	  		window.location.href =  home_url + '/video-edit';
	  	});
	  		

	</script>
<!-- ****************************************************** -->


<?php get_footer(); ?>

