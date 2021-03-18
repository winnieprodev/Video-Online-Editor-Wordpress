<?php
/*
Template Name: Creating Template
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

	// if(isset($_POST['template_id'])){
	// 	$template_id = $_POST['template_id'];
	// 	$template_guid = $_POST['template_guid'];
	// } else {
	// 	wp_redirect(home_url().'/video-template', 301);
	// }

	$all_my_upload_videos = get_posts( 
		array( 
			'author' => $current_user->ID, 
			'post_parent' => 0, 
			'orderby' => 'date', 
			'order' => 'DESC', 
			'post_type' => 'attachment',
			'post_mime_type' => 'video',
			'posts_per_page' => -1,
		) 
	);

	$bg_header_editor_ID = $current_user->ID;
	$gif_image_editor_ID = $current_user->ID;

	$bg_header_editors = get_users( array( 'search' => 'bg_header_editor' ) );
	foreach ( $bg_header_editors as $user ) {
	    $bg_header_editor_ID = $user->ID;
	}

	$gif_image_editors = get_users( array( 'search' => 'gif_image_editor' ) );
	foreach ( $gif_image_editors as $user ) {
	    $gif_image_editor_ID = $user->ID;
	}

	$all_images = get_posts( 
		array(
			'author' => $current_user->ID,
			'post_parent' => 0, 
			'orderby' => 'date', 
			'order' => 'DESC', 
			'post_type' => 'attachment', 
			'post_mime_type' => 'image',
			'posts_per_page' => -1,
		)
	);

	$all_stock_images_bg = get_posts( 
		array(
			'author' => $bg_header_editor_ID,
			'post_parent' => 0, 
			'orderby' => 'date', 
			'order' => 'ASC', 
			'post_type' => 'attachment', 
			'post_mime_type' => 'image',
			'posts_per_page' => -1,
		)
	);

	$all_stock_images_gif = get_posts( 
		array(
			'author' => $gif_image_editor_ID,
			'post_parent' => 0, 
			'orderby' => 'date', 
			'order' => 'DESC', 
			'post_type' => 'attachment', 
			'post_mime_type' => 'image',
			'posts_per_page' => -1,
		)
	);

	function ellipse_str($str){

		if(strlen($str) > 20) {
			$result_str = substr($str, 0, 20) . '...';
		} else{
			$result_str = $str;
		}
		return $result_str;
	}

	function ellipse_str_image($str){

		if(strlen($str) > 13) {
			$result_str = substr($str, 0, 13) . '...';
		} else{
			$result_str = $str;
		}
		return $result_str;
	}

?>

    <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $video_edit_url; ?>/assets/global/css/components-rounded.min.css" rel="stylesheet"  type="text/css" />
    <link href="<?php echo $video_edit_url; ?>/font-customs/font-customs.css" rel="stylesheet"  type="text/css" />
    <link rel="shortcut icon" href="favicon.ico" />

    <!-- text animation -->
    <link href="<?php echo $video_edit_url; ?>/assets/textanimi/style.css" rel="stylesheet" id="style_components" type="text/css" />
    <!-- end text animation -->

    <!-- color-picker -->
    <link rel="stylesheet" type="text/css" href="<?php echo $video_edit_url; ?>/assets/colorpicker/spectrum.css" />
    <!-- <link rel="stylesheet" type="text/css" href="../docs/docs.css"> -->
    <!-- end -->

</head>

    <div id="cover-spin"></div>
    <div id="progress_div">
    	<div class="progress">
	        <div class="progress-bar progress-bar-success green-jungle" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 1%">
	        </div>
	    </div>
    </div>

    <div id="progress_span_div">
    	<div class="progress_span">
	        <p>Your video is being exported, this could take 1 or 2 mins. Please wait… </p>
	    </div>
    </div>

    <div id="progress_span_div_subtitle">
    	<div class="progress_span">
	        <p>We are adding subtitle into your video. This could take 1 or 2 mins. Please wait …</p>
	    </div>
    </div>
    
	<style type="text/css">
		#progress_div{
			position:fixed;
		    width:100%;
		    left:0;right:0;top:0;bottom:0;
		    background-color: rgba(215, 213, 213, 0.7);
		    z-index:9999;
		    display:none;
		}
		.progress{
			position: fixed;
			width: 30%;
			left: 35%;
			top: 45%;
			background-color: #fff;
		}


		#progress_span_div{
			text-align: center;
			position:fixed;
		    width:100%;
		    left:0;right:0;top:0;bottom:0;
		    background-color: rgba(215, 213, 213, 0.7);
		    z-index:99999;
		    display:none;
		}

		#progress_span_div_subtitle{
			text-align: center;
			position:fixed;
		    width:100%;
		    left:0;right:0;top:0;bottom:0;
		    background-color: rgba(215, 213, 213, 0.7);
		    z-index:99999;
		    display:none;
		}
		.progress_span{
			position: fixed;
			width: 60%;
			left: 20%;
			top: 45%;
		}


		#cover-spin {
		    position:fixed;
		    width:100%;
		    left:0;right:0;top:0;bottom:0;
		    background-color: rgba(255,255,255,0.7);
		    z-index:99999;
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
    <!-- <input id="video_post_id" type="hidden" value="<?php echo $video_post_id; ?>"/> -->

    <!-- <input id="template_id" type="hidden" value="<?php echo $template_id; ?>"/>
    <input id="template_guid" type="hidden" value="<?php echo $template_guid; ?>"/> -->

    <style type="text/css">
    	#templates .thumbnail {
    		margin-bottom: 8px;
    	}
    </style>

	<div id="content" class="page-wrap" style="padding-top: 0px; padding-bottom: 200px;">
		<div style="margin-left: 0px; margin-right: 0px; width: 100%;">
			<div class="row" style="padding: 0px; margin: 0px;">

				<div class="col-md-12" style="padding: 0px;">
					<div class="tabbable-line col-md-5" style="min-height: 400px; border:1px solid #ddd; padding: 0px;">
			            <ul class="nav nav-tabs" style="background-color: #ddd; border-top: 5px solid #ddd;">
			            	<li class="active template_background">
			                    <a href="#" style="font-size: 14px; font-weight: bold;"> Background </a>
			                </li>
			                <li class="video_upload_tab">
			                    <a href="#" style="font-size: 14px; font-weight: bold;"> Video </a>
			                </li>
			                <li class="template_image">
			                    <a href="#" style="font-size: 14px; font-weight: bold;"> Header & Footer </a>
			                </li>
			                
			                <li class="text_edit_tab">
			                    <a href="#" style="font-size: 14px; font-weight: bold;"> Text </a>
			                </li>
			                <li class="image_upload_tab">
			                    <a href="#" style="font-size: 14px; font-weight: bold;"> Gifs & Images </a>
			                </li>
			                <li class="subtitle_tab">
			                    <a href="#" style="font-size: 16px; font-weight: bold;"> Subtitle </a>
			                </li>
			            </ul>
			            <div class="tab-content col-md-12" style="padding-top: 0px; padding-bottom: 0px;">
			                <!-- Video Uploads -->
			                <div class="tab-pane active" id="template_background">
			     				<div class="col-md-12" style="padding-top: 20px; padding-left: 40px; padding-bottom: 10px; border-bottom: 1px solid lightgray;">
			     					<input type="radio" name="template_option" value="1" checked />&nbsp;&nbsp;<span style="font-size: 16px;"> Image Background</span>&nbsp;&nbsp;&nbsp;&nbsp;
			     					<input type="radio" name="template_option" value="2"/>&nbsp;&nbsp;<span style="font-size: 16px;"> Color Background </span>
			     				</div>
			                	<div class="col-md-12 template_bg" style="padding-top: 10px;">
			                		<input id="template_bg_browse" type="file" name="template_bg_browse" accept="image/*" />
			                		<div class="col-md-12 template_bg_upload_range" style="padding-bottom: 20px; padding-top: 10px;">
			                			<div class="col-md-12 col-sm-12 col-xs-12" style="border: 2px solid #aaa; border-radius: 5px; padding: 20px;">
					                		<div style="margin-top:-32px; padding-bottom: 10px;">
					                			<span style="font-size: 16px; background-color:white;">&nbsp;&nbsp;Background image&nbsp;&nbsp;</span>
					                		</div>
					                		<div class="col-md-2 col-sm-2 col-xs-2 text-center template_bg_upload" style="border-style: dashed; border-width: 2px; border-radius: 5px; height: 75px;">
						                		<span class="icon icon-cloud-upload" style="font-size: 40px; padding-top: 30px; color: blue;"> </span>
						                	</div>
						                	<div class="col-md-10 col-sm-10 col-xs-10" style="padding-left: 30px;">
						                		<h4 style="margin-top: 0px;">Upload Backround</h4>
						                		<span>Select a image</span><br>
						                		<a href="#" class="pre_template_bg_upload" data-toggle="modal" data-target="#pre_template_bg_upload">Stock images</a>
						                	</div>
					                	</div>
					                	<div class="col-md-12 template_bg_uploading" style="padding-top: 10px; padding-left: 21px;">
						                		
						            	</div>
			                		</div>			                		
			                		
			                		<style type="text/css">
			                			.template_bg_upload_range{ height: 316px; /*overflow-y: scroll;*/ }
			                			.template_bg_upload:hover{border-color: blue;}
			                		</style>
			                	</div>
			                	<div class="col-md-12 template_color" style="padding-top: 13px;">
			                		<div class="col-md-12 form-inline" style="padding-bottom: 20px;">
			                			<div class="col-md-6 form-group">
			                				<label>Width: </label>
			                				<input class="template_width" type="number" style="height: 30px; width: 120px;" /> px
			                			</div>
			                			<div class="col-md-6 form-group">
			                				<label>Height: </label>
			                				<input type="number" class="form-control template_height" style="height: 30px; width: 120px;" /> px
			                			</div>
			                		</div>
			                		<div class="col-md-12" style="padding-left: 30px; padding-bottom: 10px;">
			                			<input type='text' id="full"/>
			                		</div>                		
			                		
			                	</div>
			                	<div class="col-md-12" style="border-top: 1px solid #ddd; padding-top: 20px; padding-bottom: 20px;">
		                        	<button class="btn green-jungle btn-outline btn-circle template_bg_next_btn" style="width: 40%; float: right; font-weight: bold;">NEXT</button>
		                		</div>

		                			<div id="pre_template_bg_upload" class="modal container fade" tabindex="-1">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Select an image from stock images</h4>
                                        </div>
                                        <style type="text/css">
								    		.template_bg_modal{ height: 520px;overflow-y: scroll; }
								    	</style>
                                        <div class="modal-body template_bg_modal">
                                            <?php
												if ( $all_stock_images_bg ) {
									        		foreach ( $all_stock_images_bg as $post ) : 
									        			//if($post->post_mime_type != 'image/gif'){
									        ?>	
									            	<div class="col-md-2 text-center template_bg_select_div">
									            		<div class="thumbnail" style="border-radius: 0px;">
										            		<input type="hidden" value="<?php echo $post->ID; ?>"/>
										            		<img class="thumbnail" style="height: 100px; width: auto; margin-bottom: auto;" src="<?php echo $post->guid; ?>"/>
										            		<br>
										            		<span style="font-size: 10px; font-weight: bold;"><?php echo ellipse_str_image($post->post_title); ?></span>
										            		<br>
										            		<a class="pre_template_bg_select" href="#"><i class="fa fa-gear"></i> Select </a>&nbsp;&nbsp;&nbsp;&nbsp;
										            		<!-- <a class="pre_template_bg_delete"><i class="fa fa-trash"></i> Delete </a> -->
										            	</div>
									            	</div>
									       	<?php
									       				//}
									        		endforeach;
											    }
											?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">Close</button>
                                        </div>
                                    </div>
			                </div>

			                <div class="tab-pane" id="template_image">
			                	<div class="col-md-12" style="padding-top: 0px; height: 455px;">
						        	
						        	<input id="template_image_browse" type="file" name="template_image_browse" accept=".jpg, .png" />
			                		
			                		<div class="col-md-12 template_image_upload_range" style="padding-bottom: 20px; padding-top: 10px;">
			                			<div class="note note-success template_image_select_note" style="width: 100%;">
			                				<p style="margin: 0px;">If you don’t want to add any header/footer, just click "NEXT" button.</p>
			                			</div>

					                	<div class="col-md-12 col-sm-12 col-xs-12" style="border: 2px solid #aaa; border-radius: 5px; padding: 20px;">
					                		<div style="margin-top:-32px; padding-bottom: 10px;">
					                			<span style="font-size: 16px; background-color:white;">&nbsp;&nbsp;Your image&nbsp;&nbsp;</span>
					                		</div>
					                		<div class="col-md-2 col-sm-2 col-xs-2 text-center template_image_upload" style="border-style: dashed; border-width: 2px; border-radius: 5px; height: 75px;">
						                		<span class="icon icon-cloud-upload" style="font-size: 40px; padding-top: 30px; color: blue;"> </span>
						                	</div>
						                	<div class="col-md-10 col-sm-10 col-xs-10" style="padding-left: 30px;">
						                		<h4 style="margin-top: 0px;">Upload image</h4>
						                		<span>Select a image</span><br>
						                		<a href="#" class="pre_template_image_upload" data-toggle="modal" data-target="#pre_template_image_upload">Previous uploads</a>&nbsp;&nbsp;
						                		<a href="#" class="pre_stock_template_image_upload" data-toggle="modal" data-target="#pre_stock_template_image_upload">Stock Images</a>
						                	</div>
						                	<style type="text/css">
						                		.template_image_upload_range{ height: 380px;}
						                		.template_image_upload:hover{border-color: blue;}
						                	</style>
					                	</div>
					                	<div class="col-md-12 template_image_uploading" style="padding-top: 10px; padding-left: 0px; padding-right: 0px;">
						                		
						            	</div>					                	
			                		</div>
			                		<div class="col-md-12" style="border-top: 1px solid #ddd; padding-top: 20px; padding-bottom: 20px;">
			                			<button class="btn btn-circle green-jungle template_image_pre_btn"style="width: 40%; font-weight: bold;">PREVIOUS</button>
			                        	<button class="btn green-jungle btn-outline btn-circle template_image_next_btn" style="width: 50%; float: right; font-weight: bold;">Rendering template & NEXT</button>
			                		</div>

			                		<!-- pre image upload modal -->
									<div id="pre_template_image_upload" class="modal container fade" tabindex="-1">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Select an image</h4>
                                        </div>
                                        <style type="text/css">
								    		.template_image_modal{ height: 520px;overflow-y: scroll; }
								    	</style>
                                        <div class="modal-body template_image_modal">
                                            <?php
												if ( $all_images ) {
									        		foreach ( $all_images as $post ) : 
									        			if($post->post_mime_type != 'image/gif'){
									        ?>
									            	<div class="col-md-2 text-center template_image_select_div">
									            		<div class="thumbnail" style="border-radius: 0px;">
										            		<input type="hidden" value="<?php echo $post->ID; ?>"/>
										            		<img class="thumbnail" style="height: 100px; width: auto; margin-bottom: auto;" src="<?php echo $post->guid; ?>"/>
										            		<br>
										            		<span style="font-size: 10px; font-weight: bold;"><?php echo ellipse_str_image($post->post_title); ?></span>
										            		<br>
										            		<a class="pre_template_image_select" href="#"><i class="fa fa-gear"></i> Select </a>&nbsp;&nbsp;&nbsp;&nbsp;
										            		<a class="pre_template_image_delete"><i class="fa fa-trash"></i> Delete</a>
										            	</div>
									            	</div>
									       	<?php
									       				}
									        		endforeach;
											    }
											?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">Close</button>
                                        </div>
                                    </div>

                                    <!-- stock image select -->
                                    <div id="pre_stock_template_image_upload" class="modal container fade" tabindex="-1">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Select an image from stock images</h4>
                                        </div>
                                        <style type="text/css">
								    		.template_image_modal{ height: 520px;overflow-y: scroll; }
								    	</style>
                                        <div class="modal-body template_image_modal">
                                            <?php
												if ( $all_stock_images_bg ) {
									        		foreach ( $all_stock_images_bg as $post ) : 
									        			//if($post->post_mime_type != 'image/gif'){
									        ?>
									            	<div class="col-md-2 text-center template_image_select_div">
									            		<div class="thumbnail" style="border-radius: 0px;">
										            		<input type="hidden" value="<?php echo $post->ID; ?>"/>
										            		<img class="thumbnail" style="height: 100px; width: auto; margin-bottom: auto;" src="<?php echo $post->guid; ?>"/>
										            		<br>
										            		<span style="font-size: 10px; font-weight: bold;"><?php echo ellipse_str_image($post->post_title); ?></span>
										            		<br>
										            		<a class="pre_template_image_select" href="#"><i class="fa fa-gear"></i> Select </a>&nbsp;&nbsp;&nbsp;&nbsp;
										            		<!-- <a class="pre_template_image_delete"><i class="fa fa-trash"></i> Delete</a> -->
										            	</div>
									            	</div>
									       	<?php
									       				//}
									        		endforeach;
											    }
											?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">Close</button>
                                        </div>
                                    </div>

			                	</div>
			                </div>


			                <div class="tab-pane" id="video_upload_tab">
			                	<div class="col-md-12" style="padding-top: 30px;">
			                		<input id="video_browse" type="file" name="video_browse" accept="video/*" />
			                		<div class="col-md-12 video_upload_range" style="padding-bottom: 20px; padding-top: 10px;">
			                			<div class="col-md-12 col-sm-12 col-xs-12" style="border: 2px solid #aaa; border-radius: 5px; padding: 20px;">
					                		<div style="margin-top:-32px; padding-bottom: 10px;">
					                			<span style="font-size: 16px; background-color:white;">&nbsp;&nbsp;Your video&nbsp;&nbsp;</span>
					                		</div>
					                		<div class="col-md-2 col-sm-2 col-xs-2 text-center video_upload" style="border-style: dashed; border-width: 2px; border-radius: 5px; height: 75px;">
						                		<span class="icon icon-cloud-upload" style="font-size: 40px; padding-top: 30px; color: blue;"> </span>
						                	</div>
						                	<div class="col-md-10 col-sm-10 col-xs-10" style="padding-left: 30px;">
						                		<h4 style="margin-top: 0px;">Upload video</h4>
						                		<span>Select a video</span><br>
						                		<a href="#" class="pre_video_upload" data-toggle="modal" data-target="#pre_video_upload">Browse previous uploads</a>
						                	</div>
					                	</div>
					                	<div class="col-md-12 video_uploading" style="padding-top: 10px; padding-left: 21px;">
						                		
						            	</div>
			                		</div>			                		
			                		<div class="col-md-12" style="border-top: 1px solid #ddd; padding-top: 20px; padding-bottom: 20px;">
			                			<button class="btn btn-circle green-jungle video_pre_btn"style="width: 40%; font-weight: bold;">PREVIOUS</button>
			                        	<button class="btn green-jungle btn-outline btn-circle video_next_btn" style="width: 40%; float: right; font-weight: bold;">NEXT</button>
			                		</div>
			                		<style type="text/css">
			                			.video_upload_range{ height: 350px; /*overflow-y: scroll;*/ }
			                			.video_upload:hover{border-color: blue;}
			                		</style>

			                		<!-- pre video upload modal -->
									<div id="pre_video_upload" class="modal container fade" tabindex="-1">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Select a video</h4>
                                        </div>
                                        <style type="text/css">
								    		.video_modal{ height: 520px;overflow-y: scroll; }
								    	</style>
                                        <div class="modal-body video_modal">
                                            <?php
												if ( $all_my_upload_videos ) {
									        		foreach ( $all_my_upload_videos as $post ) :	        			
									        ?>
									            	<div class="col-md-3 text-center">
									            		<div class="thumbnail">
										            		<input type="hidden" value="<?php echo $post->ID; ?>"/>
										            		<video class="thumbnail" style="width: 100%; height: 200px; overflow: hidden; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); margin-bottom: auto;" src="<?php echo $post->guid; ?>#t=1.0" controls preload="metadata"></video>
										            		<span style="font-size: 16px; font-weight: bold;"><?php echo ellipse_str($post->post_title); ?></span><br>
										            		<a class="pre_video_select" href="#" style="float: left;"><i class="fa fa-gear"></i> Select </a>&nbsp;&nbsp;&nbsp;&nbsp;
										            		<a class="pre_video_delete" style="float: right;"><i class="fa fa-trash"></i> Delete </a>
										            	</div>
									            	</div>
									       	<?php
									        		endforeach;
											    }
											?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">Close</button>
                                        </div>
                                    </div>

			                	</div>			                	
			                </div>				              

			                <!-- Text Edit -->

			                <div class="tab-pane" id="text_edit_tab">
						        <div class="col-md-12" style="padding-top: 10px;">
						        	
			                		<div class="col-md-12 text_range form-horizontal" style="padding-bottom: 20px; padding-top: 0px; height: 400px;">

			                			<div class="note note-success text_select_note" style="width: 100%;">
			                				<p style="margin: 0px;">If you don’t want to add any text, just click "NEXT" button.</p>
			                			</div>

			                			<iframe id="text_edit" name="text_edit" src="<?php echo $video_edit_url; ?>/page-templates/text-edit.php?url=<?php echo $video_edit_url; ?>" style="width: 100%; height: 300px; border: 1px solid gray; border-radius: 5px;"></iframe>		                			

	                                    <div class="col-md-12 text-center">
											<a class="text_select"><span> <i class="fa fa-gear"> </i> </span><span>Add</span></a>&nbsp;&nbsp;&nbsp;&nbsp;
				            				<a class="text_remove"><span> <i class="fa fa-trash"> </i> </span><span>Remove</span></a>
	                                    </div>
			                		</div>

			                		<div class="col-md-12" style="border-top: 1px solid #ddd; padding-top: 20px; padding-bottom: 20px;">
			                			<button class="btn btn-circle green-jungle text_pre_btn"style="width: 40%; font-weight: bold;">PREVIOUS</button>
			                        	<button class="btn green-jungle btn-outline btn-circle text_next_btn" style="width: 40%; float: right; font-weight: bold;">NEXT</button>
			                		</div>
			                		<style type="text/css">
			                			/*.text_range{ height: 350px; }*/
			                			.text_range input {height: 34px;}
			                		</style>

			                	</div>
			                </div>

			                <!-- Upload image -->
			                <div class="tab-pane" id="image_upload_tab">

						        <div class="col-md-12" style="padding-top: 0px; height: 455px;">
						        	
						        	<input id="image_browse" type="file" name="image_browse" accept="image/*" />
			                		
			                		<div class="col-md-12 image_upload_range" style="padding-bottom: 20px; padding-top: 10px;">
			                			<div class="note note-success image_select_note" style="width: 100%;">
			                				<p style="margin: 0px;">If you don’t want to add any image/gif, just click "NEXT" button.</p>
			                			</div>

					                	<div class="col-md-12 col-sm-12 col-xs-12" style="border: 2px solid #aaa; border-radius: 5px; padding: 20px;">
					                		<div style="margin-top:-32px; padding-bottom: 10px;">
					                			<span style="font-size: 16px; background-color:white;">&nbsp;&nbsp;Your image&nbsp;&nbsp;</span>
					                		</div>
					                		<div class="col-md-2 col-sm-2 col-xs-2 text-center image_upload" style="border-style: dashed; border-width: 2px; border-radius: 5px; height: 75px;">
						                		<span class="icon icon-cloud-upload" style="font-size: 40px; padding-top: 30px; color: blue;"> </span>
						                	</div>
						                	<div class="col-md-10 col-sm-10 col-xs-10" style="padding-left: 30px;">
						                		<h4 style="margin-top: 0px;">Upload image</h4>
						                		<span>Select a image/gif</span><br>
						                		<a href="#" class="pre_image_upload" data-toggle="modal" data-target="#pre_image_upload">Previous uploads</a>&nbsp;&nbsp;
						                		<a href="#" class="pre_stock_image_upload" data-toggle="modal" data-target="#pre_stock_image_upload">Stock Images</a>
						                	</div>
						                	<style type="text/css">
						                		.image_upload_range{ height: 380px;}
						                		.image_upload:hover{border-color: blue;}
						                	</style>
					                	</div>
					                	<div class="col-md-12 image_uploading" style="padding-top: 10px; padding-left: 0px; padding-right: 0px;">
						                		
						            	</div>					                	
			                		</div>
			                		<div class="col-md-12" style="border-top: 1px solid #ddd; padding-top: 20px; padding-bottom: 20px;">
			                			<button class="btn btn-circle green-jungle image_pre_btn"style="width: 40%; font-weight: bold;">PREVIOUS</button>
			                        	<button class="btn green-jungle btn-outline btn-circle"  data-toggle="modal" data-target="#confirm_alert" style="width: 40%; float: right; font-weight: bold;">NEXT</button>
			                		</div>

			                		<!-- Confirm alert -->
									<div id="confirm_alert" class="modal fade" tabindex="-1">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Confirm</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Please check all edition. Once it's exported, you can't get earlier steps again.</p>
                                        </div>
                                        <div class="modal-footer">
                                        	<button type="button" data-dismiss="modal" class="btn green-jungle btn-outline btn-circle image_next_btn">Continue</button>
                                            <button type="button" data-dismiss="modal" class="btn btn-circle green-jungle">Review again</button>
                                        </div>
                                    </div>

			                		<!-- pre image upload modal -->
									<div id="pre_image_upload" class="modal container fade" tabindex="-1">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Select an image or a gif</h4>
                                        </div>
                                        <style type="text/css">
								    		.image_modal{ height: 520px;overflow-y: scroll; }
								    	</style>
                                        <div class="modal-body image_modal">
                                            <?php
												if ( $all_images ) {
									        		foreach ( $all_images as $post ) : 
									        ?>
									            	<div class="col-md-2 text-center image_select_div">
									            		<div class="thumbnail" style="border-radius: 0px;">
										            		<input type="hidden" value="<?php echo $post->ID; ?>"/>
										            		<img class="thumbnail" style="height: 100px; width: auto; margin-bottom: auto;" src="<?php echo $post->guid; ?>"/>
										            		<br>
										            		<span style="font-size: 10px; font-weight: bold;"><?php echo ellipse_str_image($post->post_title); ?></span>
										            		<br>
										            		<a class="pre_image_select" href="#"><i class="fa fa-gear"></i> Select </a>&nbsp;&nbsp;&nbsp;&nbsp;
										            		<a class="pre_image_delete"><i class="fa fa-trash"></i> Delete</a>
										            	</div>
									            	</div>
									       	<?php
									        		endforeach;
											    }
											?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">Close</button>
                                        </div>
                                    </div>

                                    <!-- stock image select -->
                                    <div id="pre_stock_image_upload" class="modal container fade" tabindex="-1">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Select an image or a gif from stock images</h4>
                                        </div>
                                        <style type="text/css">
								    		.image_modal{ height: 520px;overflow-y: scroll; }
								    	</style>
                                        <div class="modal-body image_modal">
                                            <?php
												if ( $all_stock_images_gif ) {
									        		foreach ( $all_stock_images_gif as $post ) : 
									        ?>
									            	<div class="col-md-2 text-center image_select_div">
									            		<div class="thumbnail" style="border-radius: 0px;">
										            		<input type="hidden" value="<?php echo $post->ID; ?>"/>
										            		<img class="thumbnail" style="height: 100px; width: auto; margin-bottom: auto;" src="<?php echo $post->guid; ?>"/>
										            		<br>
										            		<span style="font-size: 10px; font-weight: bold;"><?php echo ellipse_str_image($post->post_title); ?></span>
										            		<br>
										            		<a class="pre_image_select" href="#"><i class="fa fa-gear"></i> Select </a>&nbsp;&nbsp;&nbsp;&nbsp;
										            		<!-- <a class="pre_image_delete"><i class="fa fa-trash"></i> Delete</a> -->
										            	</div>
									            	</div>
									       	<?php
									        		endforeach;
											    }
											?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-outline dark">Close</button>
                                        </div>
                                    </div>

			                	</div>
			                </div>

			                <!-- Upload Subtitle -->
			                <div class="tab-pane" id="subtitle_tab">

						        <div class="col-md-12" style="padding-top: 0px; height: 504px;">
			                		
			                		<div class="col-md-12 subtitle_upload_range" style="padding-bottom: 20px; padding-top: 10px;">
			                			<div class="note note-success subtitle_select_note" style="width: 100%;">
			                				<p style="margin: 0px;">If you don’t want to add any subtitle, just click "SAVE & PREVIEW" button.</p>
			                			</div>

			                			<div id="subtitle_select_option" style="padding-top: 30px;">
			                				<h4>SELECT A METHOD</h4>
			                				<p>Choose how you want to add subtitles to this video.</p>
			                				<button class="btn green-jungle subtitle_upload_form" style="width: 200px; height: 50px;">Upload a file</button><br><br>
			                				<button class="btn green-jungle subtitle_edit_form" style="width: 200px; height: 50px;">Create new subtitles</button>
			                			</div>			     						

			     						<div class="col-md-12 subtitle_upload_div" style="padding: 0px;">
			     							<input id="subtitle_browse" class="subtitle_browse" type="file" name="subtitle_browse" accept=".srt" />			     						
				                			<div class="col-md-12 col-sm-12 col-xs-12" style="border: 2px solid #aaa; border-radius: 5px; padding: 20px;">
						                		<div style="margin-top:-32px; padding-bottom: 10px;">
						                			<span style="font-size: 16px; background-color:white;">&nbsp;&nbsp;Your Subtitle&nbsp;&nbsp;</span>
						                		</div>
						                		<div class="col-md-2 col-sm-2 col-xs-2 text-center subtitle_upload" style="border-style: dashed; border-width: 2px; border-radius: 5px; height: 75px;">
							                		<span class="icon icon-cloud-upload" style="font-size: 40px; padding-top: 30px; color: blue;"> </span>
							                	</div>
							                	<div class="col-md-10 col-sm-10 col-xs-10" style="padding-left: 30px;">
							                		<h4 style="margin-top: 0px;">Upload Subtitle</h4>
							                		<span>Select a SRT file</span><br>
							                	</div>
						                	</div>
						                	<div class="col-md-12 subtitle_uploading" style="padding-top: 10px; padding-left: 0px; padding-right: 0px; height: 190px;">
							                		
							            	</div>
											<br>
						            	</div>

						            	<div class="col-md-12 subtitle_edit_div" style="padding: 0px;">
						            		<div class="col-md-10" style="padding-right:0px; padding-left: 0px;">
						            			<textarea placeholder="Type subtitle here then press Enter" id="subtitle_part" rows="2" style="height: 60px; padding: 10px;"></textarea>
						            		</div>
						            		<div class="col-md-2" style="padding-left: 0px; padding-right: 0px;">
						            			<button id="subtitle_add" class="btn green-jungle" style="height: 60px; width: 100%; border-radius: 0px;">Add</button>
						            		</div>

						            		<div id="subtitle_content_form" class="col-md-12" style="max-height: 260px; overflow-y: scroll; margin-top: 10px; padding-left: 0px;">
						            			
						            		</div>
						            		<br>
						            	</div>

						            	<style type="text/css">
					                		.subtitle_upload_range{ height: 430px;}
					                		.subtitle_upload:hover{border-color: blue;}
					                	</style>
			                		</div>
			                		<div class="col-md-12" style="border-top: 1px solid #ddd; padding-top: 20px; padding-bottom: 20px;">
			                			<button class="btn btn-circle green-jungle subtitle_upload_prev"style="width: 40%; font-weight: bold;">PREVIOUS</button>
			                			<button class="btn btn-circle green-jungle subtitle_edit_prev"style="width: 40%; font-weight: bold;">PREVIOUS</button>
			                        	<button class="btn red-flamingo btn-outline btn-circle save_preview" style="width: 40%; float: right; font-weight: bold;">SAVE & PREVIEW</button>
			                        	<button class="btn open_render" data-toggle="modal" data-target="#rendering_name">open_render</button>
			                		</div>

			                	</div>
			                </div>
			            </div>
			        </div>

			        <!-- working panel -->
			        <div class="col-md-7 text-center" style="padding: 0px; background-color: #ccc;">
			        	<div class="col-md-12" style="height: 50px; background-color: #ddd; ">
			        		<h1 style="font-size: 18px;"> <i class="icon icon-clock"></i> &nbsp;&nbsp; <span class="duration">00:00:00</span> </h1>
			        	</div>
			        	<div id="working_panel_top" style="width: 640px; height: 360px; margin-top: 50px; margin-bottom: 42px; display: inline-block; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
			        		<div id="working_panel" class="col-md-12 working_panel resize-container" style="padding: 0px; width: 640px; height: 360px; background-color: white;">
			        			<img id="working_panel_template_bg" class="working_panel_template_bg" style="width: 640px; height: 360px; box-sizing: border-box;" src="<?php echo $video_edit_url; ?>/images/default.png"/>
			        			<!-- <img id="outimage" class="resize-drag-text" style="width: 500px; height: 80px; box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 1;border: 1px dashed red;" /> -->
			        		</div>

			        		<iframe id="subtitle_edit" name="subtitle_edit" src="<?php echo $video_edit_url; ?>/page-templates/subtitle.php?url=<?php echo $video_edit_url; ?>" style="width: 100%; height: 500px; border: none; overflow: hidden;" scrolling="no"></iframe>
                   			
                   		</div>
			        </div>
				</div>

				<!-- Rendering name Modal -->
				<div id="rendering_name" class="modal fade" tabindex="-1">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Save File Name</h4>
                    </div>
                    <div class="modal-body">
                        <p>Please Input Save File Name</p>
		        		<input class="rendering_file_name form-control" type="input" />
		        		<br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn red-flamingo btn-circle btn-outline save_preview_btn" style="width: 30%">Save</button>
		        		<button type="button" class="btn red-flamingo btn-circle btn-outline open_preview" style="width: 30%"  data-toggle="modal" data-target="#result_video">Open Preview</button>
		        		<button type="button" class="btn green-jungle btn-circle save_cancel" data-dismiss="modal"style="float: right; width: 30%;" >Close</button>
                    </div>
                </div>

				<!-- result video Modal -->
				<div id="result_video" class="modal container fade" tabindex="-1">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Result video</h4>
                    </div>
                    <div class="modal-body text-center">
                        <div class="result_video">
				      				
				      	</div>
                    </div>
                </div>


	<!-- BEGIN CORE PLUGINS -->
    <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
	<!-- <script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script> -->
    <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
    <script src="<?php echo $video_edit_url; ?>/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
    <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
    <!-- <script src="<?php echo $video_edit_url; ?>/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script> -->
    <!-- <script src="<?php echo $video_edit_url; ?>/assets/pages/scripts/components-editors.min.js" type="text/javascript"></script> -->
    <script src="<?php echo $video_edit_url; ?>/assets/pages/scripts/ui-extended-modals.min.js" type="text/javascript"></script>
    <script src="<?php echo $video_edit_url; ?>/js/ajaxfileupload.js" type="text/javascript"></script>
    <script src="<?php echo $video_edit_url; ?>/js/interact.min.js" type="text/javascript"></script>

    <!-- text animi -->
    <script src="<?php echo $video_edit_url; ?>/assets/textanimi/anime.js" type="text/javascript"></script>
    <script src="<?php echo $video_edit_url; ?>/assets/textanimi/html2canvas.js" type="text/javascript"></script>
    <script src="<?php echo $video_edit_url; ?>/assets/textanimi/textmain.js" type="text/javascript"></script>


    <script src="<?php echo $video_edit_url; ?>/assets/colorpicker/spectrum.js" type="text/javascript"></script>


	<script type="text/javascript">

    	var video_edit_url = $('#video_edit_url').val();
    	var admin_url = $('#admin_url').val();
    	var home_url = $('#home_url').val();

    	// var TEMPLATE = $('#template_id').val();
    	// var TEMPLATE_GUID = $('#template_guid').val();
    	var TEMPLATE = '';
    	var TEMPLATE_GUID = '';

    	var VIDEO = '';
    	var VIDEO_GUID = '';
    	var VIDEO_TOP = '';
    	var VIDEO_LEFT = '';

    	var IMAGE = '';
    	var TEXT = '';

    	var RATIO = 1;

    	var video_temp = '';
    	var image_temp = '';

    	var VIDEO_TEMP = '';

    	var BACKGROUND = 2; // If 1, image background and then if 0, color background.
    	var BACKGROUND_URL = '';


    	var WORKING_PANEL_TEMP = '';

    	var VIDEO_DURATION = 0;

    	$('#subtitle_edit').hide();


    	function ellipse_str(str){
    		if(str.length > 20){
    			return str.substr(0, 20) + '...';
    		} else {
    			return str;
    		}
    	}

    	function ellipse_str_image(str){
    		if(str.length > 13){
    			return str.substr(0, 13) + '...';
    		} else {
    			return str;
    		}
    	}

		/***************************  Tempaltes  *************************/

		// temlate background
		$('.template_bg').show();
		$('.template_color').hide();

		$('input[name=template_option').change(function(){
			
			var num = $('input[name=template_option]:checked').val();
			if(num == 1){
				initial_template_bg_0();
				$('.template_bg').show();
				$('.template_color').hide();
				BACKGROUND = 1;
			} else {
				initial_template_bg();
				$('.template_bg').hide();
				$('.template_color').show();
				BACKGROUND = 0;
			}
		});

		function initial_template_bg(){
			$('.template_width').val(640);
			$('.template_height').val(360);
			$('.template_bg_uploading').html('');
			$('.working_panel').html('');
			$('#working_panel_top').attr('style','width:640px; height:360px;margin-top: 50px; margin-bottom: 42px; display: inline-block; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);');
			$('#working_panel').attr('style','width:640px; height:360px; padding: 0px; background-color: white;');
		}

		function initial_template_bg_0(){
			$('.template_width').val(640);
			$('.template_height').val(360);
			$('.template_bg_uploading').html('');
			$('#working_panel').html('<img id="working_panel_template_bg" class="working_panel_template_bg" style="width: 640px; height: 360px; box-sizing: border-box;" src="<?php echo $video_edit_url; ?>/images/default.png"/>');
			$('#working_panel_top').attr('style','width:640px; height:360px;margin-top: 50px; margin-bottom: 42px; display: inline-block; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);');
			$('#working_panel').attr('style','width:640px; height:360px; padding: 0px; background-color: white;');
		}

		$('#template_bg_browse').hide();
		$('.template_bg_upload').click(function(){
			$('#template_bg_browse').click();
		});

		template_bg_browse();
		function template_bg_browse(){
			$('#template_bg_browse').change(function(){
				var template_bg_url = $('#template_bg_browse').val();
				var url_split = template_bg_url.split('\\');
				var file_name = url_split[url_split.length - 1];
				
				var template_bg_upload_html = 
					'<div class="col-md-2 text-center" style="border-style: solid; border-width: 1px; border-radius: 5px; border-color: #bbb; height: 75px;">' +
		                '<span class="fa fa-file-video-o" style="font-size: 40px; padding-top: 30px; color: gray;"> </span>' +
		            '</div>' +
		            '<div class="col-md-10" style="padding-left: 30px;">' +
		                '<h4>' + ellipse_str(file_name) + '</h4>' +
		                '<a href="#" class="template_bg_upload_now"><span> <i class="fa fa-cloud-upload"> </i> Upload </span></a>&nbsp;&nbsp;&nbsp;&nbsp;' +
		                '<a href="#" class="template_bg_upload_cancel"><span> <i class="fa fa-chain-broken"> </i> Cancel </span></a>' +
		            '</div>';

				$('.template_bg_uploading').html(template_bg_upload_html);
				//template_bg_upload();
				$('.template_bg_upload_cancel').click(function(){
					$('.template_bg_uploading').html('');
				});
			});
		}

		$(document).on('click', '.template_bg_upload_now', function(){
			var ajax_url = admin_url + 'admin-ajax.php';
			
	    	var file = $('#template_bg_browse');
            var file = file.get(0).files[0];
            var formData = new FormData();
            formData.append('template_bg_browse', file);

            $.ajax({
            	url : ajax_url+"?action=upload_template_bg",
            	type : 'POST',
            	contentType : false,
            	cache : false,
            	processData : false,
            	data : formData,
            	xhr : function(){
            		var jqXHR = null;
                    if ( window.ActiveXObject )
                    {
                        jqXHR = new window.ActiveXObject( "Microsoft.XMLHTTP" );
                    }
                    else
                    {
                        jqXHR = new window.XMLHttpRequest();
                    }
                    //Upload progress
                    jqXHR.upload.addEventListener( "progress", function ( evt )
                    {
                        if ( evt.lengthComputable )
                        {
                            var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                            //Do something with upload progress
                            console.log( 'Uploaded percent', percentComplete );
                            $('.progress-bar').attr('style','width:'+percentComplete+'%;');
                        }
                    }, false );
                    //Download progress
                    jqXHR.addEventListener( "progress", function ( evt )
                    {
                        if ( evt.lengthComputable )
                        {
                            var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                            //Do something with download progress
                            console.log( 'Downloaded percent', percentComplete );
                        }
                    }, false );
                    return jqXHR;
                },
                beforeSend: function () {
	        		// Show image container
	    			//$("#cover-spin").show();
	    			$("#progress_div").show();
		        },
                success : function ( data )
                {
                	var result_data = JSON.parse(data);
                	if(result_data.success == 1){
						var template_bg_url = result_data.msg;
						template_bg_url = template_bg_url.replace(/ /g, "%20");
						//console.log(template_bg_url);
						var attach_id = result_data.attach_id;
						var url_split = template_bg_url.split('/');
						var file_name = url_split[url_split.length - 1];
						file_name = file_name.replace(/%20/g, " ");

		                var template_bg_upload_html = 
			            	'<div class="col-md-12 text-center">'+
			            		'<img class="thumbnail" src="'+template_bg_url+'" style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); height: 130px; width: auto; display: initial; margin-bottom: 5px;"/><br>'+
			            		'<span>'+ ellipse_str(file_name) +'</span><br>'+
			            		'<a class="template_bg_select"><span> <i class="fa fa-gear"> </i> </span><span>Select</span></a>&nbsp;&nbsp;&nbsp;&nbsp;' +
			            		'<a class="template_bg_remove"><span> <i class="fa fa-trash"> </i> </span><span>Remove</span></a>' +
			            		'<input type="hidden" value="' + attach_id + '=' + template_bg_url + '"/>'
			            	'</div>';

						$('.template_bg_uploading').html(template_bg_upload_html);

						var pre_template_bg_add = 
							// '<div class="col-md-2 text-center">'+
			    //         		'<div class="thumbnail">'+
				   //          		'<input type="hidden" value="'+attach_id+'"/>'+
				   //          		'<img class="thumbnail" style="width: 100%; height: 100px; overflow: hidden; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); margin-bottom: auto;" src="'+template_bg_url+'" />'+
				   //          		'<span style="font-size: 16px; font-weight: bold;">'+ellipse_str(file_name)+'</span><br>'+
				   //          		'<a class="pre_template_bg_select" href="#" style="float: left;"><i class="fa fa-gear"></i> Add </a>&nbsp;&nbsp;&nbsp;&nbsp;'+
				   //          		'<a class="pre_template_bg_delete" style="float: right;"><i class="fa fa-trash"></i> Delete </a>'+
				   //          	'</div>'+
			    //         	'</div>';
			            	'<div class="col-md-2 text-center image_select_div">'+
			            		'<div class="thumbnail" style="border-radius: 0px;">'+
				            		'<input type="hidden" value="'+attach_id+'"/>'+
				            		'<img class="thumbnail" style="height: 100px; width: auto; margin-bottom: auto;" src="'+template_bg_url+'"/><br>'+
				            		'<span style="font-size: 10px; font-weight:bold;">'+ellipse_str(file_name)+'</span><br>'+
				            		'<a class="pre_template_bg_select" href="#"><i class="fa fa-gear"></i> Add </a>&nbsp;&nbsp;&nbsp;&nbsp;'+
				            		'<a class="pre_template_bg_delete"><i class="fa fa-trash"></i> Delete</a>'+
				            	'</div>'+
			            	'</div>';
			            $('.template_bg_modal').append(pre_template_bg_add);
			            //pre_template_bg_delete();
			            //pre_template_bg_select();
						//template_bg_select();
						$('.template_bg_remove').click(function(){
							$('.template_bg_uploading').html('');
							initial_template_bg_0();
						});

						$('#template_bg_browse').val('');
						//template_bg_browse();

						// Hide image container
				    	//$("#cover-spin").hide();
                	}
                },
                error: function (data, status, e)
                {                                       
                    ;
                },
		        complete:function(data){
				    // Hide image container
				    //$("#cover-spin").hide();
				    $("#progress_div").hide();
				    $('.progress-bar').attr('style','width:1%;');
			   	}
            });
		});
			
		$(document).on('click', '.template_bg_select', function(){
			//$('#working_panel_template_bg').remove();
			var value = $(this).parent().parent().find('input').val();
			var value_array = value.split('=');
			guid = value_array[1];

			BACKGROUND_URL = guid;
			BACKGROUND = 1;

			$('.working_panel_template_bg').attr('src', guid);
			var template = document.getElementById("working_panel_template_bg");
			$("#cover-spin").show();
			template.onload=function(){
				var naturalHeight = template.naturalHeight;
				var naturalWidth = template.naturalWidth;

			    var ratio = naturalHeight / 360;
				var height = 360;
				var width = naturalWidth / ratio;
				RATIO = ratio;

				$('#working_panel_top').attr('style','width:'+width+'px; height:'+height+'px;margin-top: 50px; margin-bottom: 42px; display: inline-block; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);');
				$('#working_panel_template_bg').attr('style','width:'+width+'px; height:'+height+'px;box-sizing: border-box; border:1px solid gray;');
				$('#working_panel').attr('style','width:'+width+'px; height:'+height+'px; padding: 0px;');
				$("#cover-spin").hide();
			};
			
		});

		secondsToTimeString = function (sec_num) {
		    var hours   = Math.floor(sec_num / 3600);
		    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
		    var seconds = sec_num - (hours * 3600) - (minutes * 60);

		    if (hours   < 10) {hours   = "0"+hours;}
		    if (minutes < 10) {minutes = "0"+minutes;}
		    if (seconds < 10) {seconds = "0"+seconds;}
		    return hours+':'+minutes+':'+seconds;
		}

		$(document).on('click', '.pre_template_bg_select', function(){
			var img_url = $(this).parent().find('img').attr('src');//wwwfsfd.com/fssd/a.mp4#1.0
			var img_url_a = img_url.split('#');
			var img_url_array = img_url_a[0].split('/');
			var file_name = img_url_array[img_url_array.length - 1];
			var img_id = $(this).parent().find('input').val();
            var template_bg_upload_html = 
            	'<div class="col-md-12 text-center">'+
            		'<img class="thumbnail" src="'+img_url+'" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); height: 130px; width: auto; display: initial; margin-bottom: 5px;"/><br>'+
            		'<span>'+ ellipse_str(file_name.replace(/%20/g, " ")) +'</span><br>'+
            		'<a class="template_bg_select"><span> <i class="fa fa-gear"> </i> </span><span>Add</span></a>&nbsp;&nbsp;&nbsp;&nbsp;' +
            		'<a class="template_bg_remove"><span> <i class="fa fa-trash"> </i> </span><span>Remove</span></a>' +
            		'<input type="hidden" value="' + img_id + '=' + img_url_a[0] + '"/>'
            	'</div>';

			$('.template_bg_uploading').html(template_bg_upload_html);
			//template_bg_select();
			$('.template_bg_remove').click(function(){
				
				initial_template_bg_0();
			});

			$('.close').click();
		});

		$(document).on('click','.pre_template_bg_delete',function(){
			var image_id = $(this).parent().find('input').val();
			var send_data = {
				'attachment_id' : image_id
			}

			var ajax_url = admin_url + 'admin-ajax.php';
			var self = this;
			$('#cover-spin').show();
			$.ajax({
				url:ajax_url + '?action=delete_attachment',
				type:'post',
				data:send_data,
	          	dataType: 'json',
				success:function(data){
					if(data.success == 1){
				    	$(self).parent().parent().remove();
				    	$('#cover-spin').hide();
					}
				}
			});
		});

		// color background
		$("#update").click (function() {
		    console.log($("#full").spectrum("option", "palette"));
		    $("#full").spectrum("option", "palette", [
		        ["red", "green", "blue"]    
		    ]);
		});

		$("#full").spectrum({
		    color: "#ECC",
		    flat: true,
		    showInput: true,
		    className: "full-spectrum",
		    showInitial: true,
		    showPalette: true,
		    showSelectionPalette: true,
		    maxPaletteSize: 10,
		    preferredFormat: "hex",
		    localStorageKey: "spectrum.demo",
		    move: function (color) {
		        
		    },
		    show: function () {
		    
		    },
		    beforeShow: function () {
		    
		    },
		    hide: function () {
		    
		    },
		    change: function() {
		        
		    },
		    palette: [
		        ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
		        "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
		        ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
		        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"], 
		        ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", 
		        "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", 
		        "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", 
		        "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", 
		        "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", 
		        "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
		        "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
		        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
		        "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", 
		        "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
		    ]
		});

		var BACKGROUND_COLOR = '#ffffff';
		var COLOR_BACKGROUND_WIDTH = 640;
		var COLOR_BACKGROUND_HEIGHT = 360;
		setTimeout(()=>{
		    $(document).find('.sp-choose').each(function(){
		        $(this).click(function(){
		            $(document).find('.sp-input').each(function(){
		                //alert($(this).val());
		                var height = $('.template_height').val();
						var width = $('.template_width').val();
						var ratio = height/360;
						width = width / ratio;
		                var color = $(this).val();
		                $('#working_panel').attr('style','width:'+width+'px; height:360px; padding: 0px; background-color:'+color+';');
		                BACKGROUND_COLOR = color;
		            })
		        })
		    })
		},100);

		$('.template_width').change(function(){
			var width = $('.template_width').val();
			var height = $('.template_height').val();

			if(width <= 0) {
				alert('Width must be bigger than 0.');
			} else {
				COLOR_BACKGROUND_HEIGHT = height;
				COLOR_BACKGROUND_WIDTH = width;

				var ratio = height/360;
				width = width / ratio;

				RATIO = ratio;
				
				$('#working_panel_top').attr('style','width:'+width+'px; height:360px;margin-top: 50px; margin-bottom: 42px; display: inline-block; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);');
				$('#working_panel_template_bg').attr('style','width:'+width+'px; height:360px;box-sizing: border-box; border:1px solid gray;');
				$('#working_panel').attr('style','width:'+width+'px; height:360px; padding: 0px; background-color:'+BACKGROUND_COLOR+';');
				$("#cover-spin").hide();
			}
		});

		$('.template_height').change(function(){
			var height = $('.template_height').val();
			var width = $('.template_width').val();

			if(height <= 0){
				alert('Height must be bigger than 0.');
			} else {

				COLOR_BACKGROUND_HEIGHT = height;
				COLOR_BACKGROUND_WIDTH = width;

				var ratio = height/360;
				width = width / ratio;

				RATIO = ratio;

				$('#working_panel_top').attr('style','width:'+width+'px; height:360px;margin-top: 50px; margin-bottom: 42px; display: inline-block; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);');
				$('#working_panel_template_bg').attr('style','width:'+width+'px; height:360px;box-sizing: border-box; border:1px solid gray;');
				$('#working_panel').attr('style','width:'+width+'px; height:360px; padding: 0px; background-color:'+BACKGROUND_COLOR+';');
				$("#cover-spin").hide();
			}
		});

		$('.template_bg_next_btn').click(function(){
			if(BACKGROUND == 2){
				alert('Please edit background.');
			} else {
				$('.template_background').removeClass('active');
				$('#template_background').removeClass('active');
				$('.video_upload_tab').addClass('active');
				$('#video_upload_tab').addClass('active');
			}    		
		});

/********************* temlate image ****************************/

		$('#template_image_browse').hide();
		$('.template_image_upload').click(function(){
			$('#template_image_browse').click();
		});

		var template_image_num = 0;

		var template_active = {};
		template_active['small_template_image_active_1'] = 0;
		template_active['small_template_image_active_2'] = 0;
		template_active['small_template_image_active_3'] = 0;

		template_image_browse();
		function template_image_browse(){
			$('#template_image_browse').change(function(){
				if(template_image_num < 3 ){
					var image_url = $('#template_image_browse').val();
					var url_split = image_url.split('\\');
					var file_name = url_split[url_split.length - 1];
					
					var image_upload_html = 
						'<div class="col-md-4 text-center" style="padding: 0px;">' +
			                '<span class="fa fa-file-image-o" style="font-size: 40px; padding: 30px; color: gray; border-style: solid; border-width: 1px; border-radius: 5px; border-color: #bbb;"> </span><br>' +
			                '<span style="font-size:12px;">' + ellipse_str(file_name) + '</span><br>' +
			                '<a style="font-size:12px;" href="#" class="template_image_upload_now"><span> <i class="fa fa-cloud-upload"> </i> Upload </span></a>&nbsp;&nbsp;' +
			                '<a style="font-size:12px;" href="#" class="template_image_upload_cancel"><span> <i class="fa fa-chain-broken"> </i> Cancel </span></a>' +
			            '</div>';
			        
					$('.template_image_uploading').append(image_upload_html);
					//template_image_upload();
					$('.template_image_upload_cancel').click(function(){
						$(this).parent().remove();
						$('#template_image_browse').val('');
					});
		        }
				
			});
		}		

		$(document).on('click', '.template_image_upload_now', function(){
			var self = this;
			var ajax_url = admin_url + 'admin-ajax.php';

            var file = $('#template_image_browse');
            var file = file.get(0).files[0];
            var formData = new FormData();
            formData.append('template_image_browse', file);

            $.ajax({
            	url : ajax_url+"?action=upload_template_image",
            	type : 'POST',
            	contentType : false,
            	cache : false,
            	processData : false,
            	data : formData,
            	xhr : function(){
            		var jqXHR = null;
                    if ( window.ActiveXObject )
                    {
                        jqXHR = new window.ActiveXObject( "Microsoft.XMLHTTP" );
                    }
                    else
                    {
                        jqXHR = new window.XMLHttpRequest();
                    }
                    //Upload progress
                    jqXHR.upload.addEventListener( "progress", function ( evt )
                    {
                        if ( evt.lengthComputable )
                        {
                            var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                            //Do something with upload progress
                            console.log( 'Uploaded percent', percentComplete );
                            $('.progress-bar').attr('style','width:'+percentComplete+'%;');
                        }
                    }, false );
                    //Download progress
                    jqXHR.addEventListener( "progress", function ( evt )
                    {
                        if ( evt.lengthComputable )
                        {
                            var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                            //Do something with download progress
                            console.log( 'Downloaded percent', percentComplete );
                        }
                    }, false );
                    return jqXHR;
                },
                beforeSend: function () {
	        		// Show image container
	    			//$("#cover-spin").show();
	    			$("#progress_div").show();
		        },
                success : function ( data )
                {
                	var result_data = JSON.parse(data);
                    if(result_data.success == 1){
						var image_url = result_data.msg;
						image_url = image_url.replace(/ /g, "%20");
						var attach_id = result_data.attach_id;
						var url_split = image_url.split('/');
						var file_name = url_split[url_split.length - 1];
						file_name = file_name.replace(/%20/g, " ");

						var class_array = [];
						$('.small_template_image').each(function(index){

							class_array.push($(this).attr('id'));
						});

						var enable = true; var id_exist = 1;
						while(enable)
						{
							if(class_array.indexOf('small_template_image_'+id_exist) == -1)
							{
								var image_upload_html = 
					            	'<div class="col-md-4 text-center small_template_image" id="small_template_image_'+id_exist+'" style="padding: 0px;">'+
					            		'<img class="thumbnail" src="'+image_url+'" style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); height: 100px; width: auto; display: initial; margin-bottom: 5px;"/><br>'+
					            		'<span style="font-size: 12px;">'+ ellipse_str(file_name) +'</span><br>'+
					            		'<a style="font-size: 12px;" class="template_image_select"><span> <i class="fa fa-gear"> </i> </span><span>Add</span></a>&nbsp;&nbsp;&nbsp;&nbsp;' +
					            		'<a style="font-size: 12px;" class="template_image_remove"><span> <i class="fa fa-trash"> </i> </span><span>Remove</span></a>' +
					            		'<input type="hidden" value="' + attach_id + '=' + image_url + '='+id_exist+'"/>'
					            	'</div>';
					            if(id_exist == 1 && class_array.length == 0){
					            	$('.template_image_uploading').append(image_upload_html);

					            } else if(id_exist == 1 && class_array.length != 0){
					            	if(class_array.indexOf('small_template_image_2') != -1){
					            		$(image_upload_html).insertBefore('#small_template_image_2');
					            	} else {
					            		$(image_upload_html).insertBefore('#small_template_image_3');
					            	}
					            } else {
					            	var pre_id = id_exist - 1;
					            	$(image_upload_html).insertAfter('#small_template_image_' + pre_id);
					            }

					            $('.template_image_remove').click(function(){
					            
									var id = $(this).parent().attr('id');
									var id_array = id.split('_');
									var id_index = id_array[id_array.length - 1];
									template_active['small_template_image_active_' + id_index] = 0;
									$('#working_panel_template_image_' + id_index).remove();
									$(this).parent().remove();
									template_image_num--;
								});
					            enable = false;
							}
							else
							{
								id_exist ++;
							}

							if(id_exist>3)
							{
								break;
							}
						}

			            $(self).parent().remove();
			            $('#template_image_browse').val('');

						//$('.image_uploading').append(image_upload_html);

						var pre_image_add = 
							'<div class="col-md-2 text-center template_image_select_div">'+
			            		'<div class="thumbnail" style="border-radius: 0px;">'+
				            		'<input type="hidden" value="'+attach_id+'"/>'+
				            		'<img class="thumbnail" style="height: 100px; width: auto; margin-bottom: auto;" src="'+image_url+'"/><br>'+
				            		'<span style="font-size: 14px; font-weight: bold;">'+ellipse_str(file_name)+'</span><br>'+
				            		'<a class="pre_template_image_select" href="#"><i class="fa fa-gear"></i> Add </a>&nbsp;&nbsp;&nbsp;&nbsp;'+
				            		'<a class="pre_template_image_delete"><i class="fa fa-trash"></i> Delete</a>'+
				            	'</div>'+
			            	'</div>';
			            $('.templte_image_modal').append(pre_image_add);
			            //pre_image_delete();
			            //pre_image_select();
						//image_select();
													
						//image_browse();
						template_image_num++;
                	}
                },
		        complete:function(data){
				    // Hide image container
				    //$("#cover-spin").hide();
				    $('#progress_div').hide();
				    $('.progress-bar').attr('style','width:1%;');
			   	}
            });

		});

		$(document).on('click','.template_image_select', function(){

			$(this).parent().attr('style','padding: 0px; border: 2px solid #26C281;');

			var value = $(this).parent().find('input').val();
			var value_array = value.split('=');
			IMAGE = value_array[0];
			guid = value_array[1];

			var id_exist = value_array[2];

			//active['small_image_active_' + id_exist] = 1;

			if(template_active['small_template_image_active_' + id_exist] == 0){

				$('#working_panel_template_image_' + id_exist).remove();

				var image = new Image();
				image.src = guid;
				var naturalHeight = image.naturalHeight;
				var naturalWidth = image.naturalWidth;

				if(naturalHeight > 360){
					var ratio = naturalHeight / 360;
					var height = 360;
					var width = naturalWidth / ratio;
					$('.working_panel').append('<img id="working_panel_template_image_'+id_exist+'" class="resize-drag-template-image" src="' + guid + '" />');
					$('#working_panel_template_image_'+id_exist).attr('style','width: '+width+'px; height:'+height+'px; box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 0.7;border: 1px dashed red; background-image: url("'+video_edit_url+'/images/outline.png"); background-repeat: none; background-size: 100% 100%;');
				} else {
					$('.working_panel').append('<img id="working_panel_template_image_'+id_exist+'" class="resize-drag-template-image" src="' + guid + '" />');
					$('#working_panel_template_image_'+id_exist).attr('style', 'width: '+naturalWidth+'px; height:'+naturalHeight+'px; box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 0.7;border: 1px dashed red; background-image: url("'+video_edit_url+'/images/outline.png"); background-repeat: none; background-size: 100% 100%;');

				}

				template_active['small_template_image_active_' + id_exist] = 1;
			}
			
		});
			
		$(document).on('click','.pre_template_image_select',function(){
			if(template_image_num < 3){
				var image_url = $(this).parent().find('img').attr('src');
				var image_url_array = image_url.split('/');
				var file_name = image_url_array[image_url_array.length - 1];
				var image_id = $(this).parent().find('input').val();

				var class_array = [];
				$('.small_template_image').each(function(index){

					class_array.push($(this).attr('id'));
				})

				var enable = true; var id_exist = 1;
				while(enable)
				{
					if(class_array.indexOf('small_template_image_'+id_exist) == -1)
					{
						var image_upload_html = 
			            	'<div class="col-md-4 text-center small_template_image" id="small_template_image_'+id_exist+'" style="padding: 0px;">'+
			            		'<img class="thumbnail" src="'+image_url+'" style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); height: 100px; width: auto; display: initial; margin-bottom: 5px;"/><br>'+
			            		'<span style="font-size: 12px;">'+ ellipse_str(file_name.replace(/%20/g, " ")) +'</span><br>'+
			            		'<a style="font-size: 12px;" class="template_image_select"><span> <i class="fa fa-gear"> </i> </span><span>Add</span></a>&nbsp;&nbsp;&nbsp;&nbsp;' +
			            		'<a style="font-size: 12px;" class="template_image_remove"><span> <i class="fa fa-trash"> </i> </span><span>Remove</span></a>' +
			            		'<input type="hidden" value="' + image_id + '=' + image_url + '=' + id_exist + '"/>'
			            	'</div>';
			            if(id_exist == 1 && class_array.length == 0){
			            	$('.template_image_uploading').append(image_upload_html);

			            } else if(id_exist == 1 && class_array.length != 0){
			            	if(class_array.indexOf('small_template_image_2') != -1){
			            		$(image_upload_html).insertBefore('#small_template_image_2');
			            	} else {
			            		$(image_upload_html).insertBefore('#small_template_image_3');
			            	}
			            } else {
			            	var pre_id = id_exist - 1;
			            	$(image_upload_html).insertAfter('#small_template_image_' + pre_id);
			            }

			            $('.template_image_remove').click(function(){
							var id = $(this).parent().attr('id');
							var id_array = id.split('_');
							var id_index = id_array[id_array.length - 1];
							template_active['small_template_image_active_' + id_index] = 0;
							$('#working_panel_template_image_' + id_index).remove();

							$(this).parent().remove();
							template_image_num--;
						});
			            enable = false;
					}
					else
					{
						id_exist ++;
					}

					if(id_exist>3)
					{
						break;
					}
				}

				//$('.image_uploading').append(image_upload_html);
				//image_select();
				$('.template_image_remove').click(function(){
					$(this).parent().remove();
					$('#working_panel_template_image').remove();
					//IMAGE = '';
					template_image_num--;
				});

				template_image_num++;
			}

			$('.close').click();

		});

		$(document).on('click','.pre_template_image_delete',function(){
			var image_id = $(this).parent().find('input').val();
			var send_data = {
				'attachment_id' : image_id
			}

			var ajax_url = admin_url + 'admin-ajax.php';
			var self = this;
			$('#cover-spin').show();
			$.ajax({
				url:ajax_url + '?action=delete_attachment',
				type:'post',
				data:send_data,
	          	dataType: 'json',
				success:function(data){
					if(data.success == 1){
				    	$(self).parent().parent().remove();
				    	$('#cover-spin').hide();
					}
				}
			});
		});

		$('.template_image_pre_btn').click(function(){
			$('.template_image').removeClass('active');
			$('#template_image').removeClass('active');
			$('.video_upload_tab').addClass('active');
			$('#video_upload_tab').addClass('active');

		});

		$('.template_image_next_btn').click(function(){
			//BACKGROUND;
			var working_panel_html = document.getElementById('working_panel');
			WORKING_PANEL_TEMP = working_panel_html.innerHTML;
			//console.log(WORKING_PANEL_TEMP);


			var send_data;

			var template_image = [];
	  		if(template_image_num != 0){
	  			
				$('.resize-drag-template-image').each(function(index){
					var image_url = $(this).attr('src');
			  		var image_url_array = image_url.split('.');
			  		var image_type = image_url_array[image_url_array.length - 1];
			  		var id = $(this).attr('id');
			  		var working_panel_image = document.getElementById(id);
			  		var image_h = working_panel_image.clientHeight;
			  		var image_w = working_panel_image.clientWidth;
			  		var image_y = $(this).attr('data-y');
			  		var image_x = $(this).attr('data-x');

					var image_json = {
						'image_url' : image_url,
						'image_type' : image_type,
						'image_h' : image_h * RATIO,
						'image_w' : image_w * RATIO,
						'image_y' : image_y * RATIO,
						'image_x' : image_x * RATIO
					}
					template_image.push(image_json);
				});

		  	}
			if(BACKGROUND == 1){

		  		//var template_id = TEMPLATE;
		  		var template_url = $('.working_panel_template_bg').attr('src');
		  		var working_panel_template = document.getElementById('working_panel_template_bg');
		  		var template_H = working_panel_template.clientHeight;
		  		var template_W = working_panel_template.clientWidth;

				send_data = {
					'background' : BACKGROUND,
					'background_url' : template_url,
					'bg_width' : template_W * RATIO,
					'bg_height' : template_H * RATIO,

					'template_image_num' : template_image_num,
					'template_image' : template_image
				}
			} else {

				send_data = {
					'background' : BACKGROUND,
					'background_color' : BACKGROUND_COLOR,
					'bg_width' : COLOR_BACKGROUND_WIDTH,
					'bg_height' : COLOR_BACKGROUND_HEIGHT,

					'template_image_num' : template_image_num,
					'template_image' : template_image
				}

			}


			var working_panel_video = document.getElementById('working_panel_video');
	  		var video_h = working_panel_video.clientHeight;
	  		var video_w = working_panel_video.clientWidth;
	  		var video_y = $('#working_panel_video').attr('data-y');
	  		var video_x = $('#working_panel_video').attr('data-x');

	  		VIDEO_TOP = video_y;
	  		VIDEO_LEFT = video_x;


			var ajax_url = admin_url + 'admin-ajax.php';
			$.ajax({
				url:ajax_url + '?action=template_rendering',
				type:'post',
				data:send_data,
	          	dataType: 'json',
				beforeSend: function () {
	        		// Show image container
	    			$("#cover-spin").show();
		        },
		        success: function (res) {
		        },
		        error: function (err) {
		        },
		        complete:function(data1){
				    
				    if(data1.responseJSON.success == 1){
	    				//console.log(data1.responseJSON.result_url);
	    				TEMPLATE_GUID = data1.responseJSON.result_url;
	    				TEMPLATE = 'true';

	    				$('#working_panel').html('<img id="working_panel_template" class="working_panel_template" style="width: 640px; height: 360px; box-sizing: border-box;" src="<?php echo $video_edit_url; ?>/images/default.png"/>');

	    				$('.working_panel_template').attr('src', TEMPLATE_GUID);

						var template = document.getElementById("working_panel_template");
						$("#cover-spin").show();
						template.onload=function(){
							var naturalHeight = template.naturalHeight;
							var naturalWidth = template.naturalWidth;
							var ratio = naturalHeight / 360;
							var height = 360;
							var width = naturalWidth / ratio;
							RATIO = ratio;

							$('#working_panel_top').attr('style','width:'+width+'px; height:'+height+'px;margin-top: 50px; margin-bottom: 42px; display: inline-block; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);');
							$('#working_panel_template').attr('style','width:'+width+'px; height:'+height+'px;box-sizing: border-box; border:1px solid gray;');
							$('#working_panel').attr('style','width:'+width+'px; height:'+height+'px; padding: 0px;');


							// video load
							$('.working_panel').append('<video id="working_panel_video" class="resize-drag-video" style="width:'+video_w+'px; height:'+video_h+'px; box-sizing: border-box; position: absolute; top: '+video_y+'px; left: '+video_x+'px; opacity: 0.7;" src="' + VIDEO_GUID + '#t=1.0" preload="metadata"></video>');

							var video = document.getElementById('working_panel_video');
							video.addEventListener( "loadedmetadata", function (e) {							    
								$('#working_panel_video').attr('style','width:'+video_w+'px; height:'+video_h+'px; box-sizing: border-box; position: absolute; top: '+video_y+'px; left: '+video_x+'px; opacity: 0.7; border: 1px dashed red; background-image: url("'+video_edit_url+'/images/outline.png"); background-repeat: none; background-size: 100% 100%;');
							}, false );							


							$('.working_panel').append('<img id="outimage_1" class="resize-drag-text" style=""/>');
							$('#outimage_1').attr('style', 'width: 500px; height: 80px; box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 1;border: 1px dashed red;  background-image: url("'+video_edit_url+'/images/outline.png"); background-repeat: none; background-size: 100% 100%;');
							$('#outimage_1').hide();

							$('.working_panel').append('<img id="outimage_2" class="resize-drag-text" style=""/>');
							$('#outimage_2').attr('style', 'width: 500px; height: 80px; box-sizing: border-box; position: absolute; top: 80px; left: 0px; opacity: 1;border: 1px dashed red;  background-image: url("'+video_edit_url+'/images/outline.png"); background-repeat: none; background-size: 100% 100%;');
							$('#outimage_2').hide();

							$('.working_panel').append('<img id="outimage_3" class="resize-drag-text" style=""/>');
							$('#outimage_3').attr('style', 'width: 500px; height: 80px; box-sizing: border-box; position: absolute; top: 160px; left: 0px; opacity: 1;border: 1px dashed red;  background-image: url("'+video_edit_url+'/images/outline.png"); background-repeat: none; background-size: 100% 100%;');
							$('#outimage_3').hide();


							$("#cover-spin").hide();



							$('.template_image').removeClass('active');
							$('#template_image').removeClass('active');
							$('.text_edit_tab').addClass('active');
							$('#text_edit_tab').addClass('active');
						}

				    }
			   	}
			});
		});

/************************** Video Upload ************************/

		$('#video_browse').hide();
		$('.video_upload').click(function(){
			$('#video_browse').click();
		});

		video_browse();
		function video_browse(){
			$('#video_browse').change(function(){
				var video_url = $('#video_browse').val();
				var url_split = video_url.split('\\');
				var file_name = url_split[url_split.length - 1];
				
				var video_upload_html = 
					'<div class="col-md-2 text-center" style="border-style: solid; border-width: 1px; border-radius: 5px; border-color: #bbb; height: 75px;">' +
		                '<span class="fa fa-file-video-o" style="font-size: 40px; padding-top: 30px; color: gray;"> </span>' +
		            '</div>' +
		            '<div class="col-md-10" style="padding-left: 30px;">' +
		                '<h4>' + ellipse_str(file_name) + '</h4>' +
		                '<a href="#" class="video_upload_now"><span> <i class="fa fa-cloud-upload"> </i> Upload </span></a>&nbsp;&nbsp;&nbsp;&nbsp;' +
		                '<a href="#" class="video_upload_cancel"><span> <i class="fa fa-chain-broken"> </i> Cancel </span></a>' +
		            '</div>';

				$('.video_uploading').html(video_upload_html);
				//video_upload();
				$('.video_upload_cancel').click(function(){
					$('.video_uploading').html('');
				});
			});
		}

		$(document).on('click', '.video_upload_now', function(){
			var ajax_url = admin_url + 'admin-ajax.php';
			
	    	var file = $('#video_browse');
            var file = file.get(0).files[0];
            var formData = new FormData();
            formData.append('video_browse', file);

            $.ajax({
            	url : ajax_url+"?action=upload_video",
            	type : 'POST',
            	contentType : false,
            	cache : false,
            	processData : false,
            	data : formData,
            	xhr : function(){
            		var jqXHR = null;
                    if ( window.ActiveXObject )
                    {
                        jqXHR = new window.ActiveXObject( "Microsoft.XMLHTTP" );
                    }
                    else
                    {
                        jqXHR = new window.XMLHttpRequest();
                    }
                    //Upload progress
                    jqXHR.upload.addEventListener( "progress", function ( evt )
                    {
                        if ( evt.lengthComputable )
                        {
                            var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                            //Do something with upload progress
                            console.log( 'Uploaded percent', percentComplete );
                            $('.progress-bar').attr('style','width:'+percentComplete+'%;');
                        }
                    }, false );
                    //Download progress
                    jqXHR.addEventListener( "progress", function ( evt )
                    {
                        if ( evt.lengthComputable )
                        {
                            var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                            //Do something with download progress
                            console.log( 'Downloaded percent', percentComplete );
                        }
                    }, false );
                    return jqXHR;
                },
                beforeSend: function () {
	        		// Show image container
	    			//$("#cover-spin").show();
	    			$("#progress_div").show();
		        },
                success : function ( data )
                {
                	var result_data = JSON.parse(data);
                	if(result_data.success == 1){
						var video_url = result_data.msg;
						video_url = video_url.replace(/ /g, "%20");
						//console.log(video_url);
						var attach_id = result_data.attach_id;
						var url_split = video_url.split('/');
						var file_name = url_split[url_split.length - 1];
						file_name = file_name.replace(/%20/g, " ");

		                var video_upload_html = 
			            	'<div class="col-md-12 text-center">'+
			            		'<video class="thumbnail" src="'+video_url+'#t=1.0" style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); height: 150px; width: auto; display: initial; margin-bottom: 5px;" controls preload="metadata"></video><br>'+
			            		'<span>'+ ellipse_str(file_name) +'</span><br>'+
			            		'<a class="video_select"><span> <i class="fa fa-gear"> </i> </span><span>Select</span></a>&nbsp;&nbsp;&nbsp;&nbsp;' +
			            		'<a class="video_remove"><span> <i class="fa fa-trash"> </i> </span><span>Remove</span></a>' +
			            		'<input type="hidden" value="' + attach_id + '=' + video_url + '"/>'
			            	'</div>';

						$('.video_uploading').html(video_upload_html);

						var pre_video_add = 
							'<div class="col-md-3 text-center">'+
			            		'<div class="thumbnail">'+
				            		'<input type="hidden" value="'+attach_id+'"/>'+
				            		'<video class="thumbnail" style="width: 100%; height: 200px; overflow: hidden; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); margin-bottom: auto;" src="'+video_url+'#t=1.0" controls preload="metadata"></video>'+
				            		'<span style="font-size: 16px; font-weight: bold;">'+ellipse_str(file_name)+'</span><br>'+
				            		'<a class="pre_video_select" href="#" style="float: left;"><i class="fa fa-gear"></i> Add </a>&nbsp;&nbsp;&nbsp;&nbsp;'+
				            		'<a class="pre_video_delete" style="float: right;"><i class="fa fa-trash"></i> Delete </a>'+
				            	'</div>'+
			            	'</div>';
			            $('.video_modal').append(pre_video_add);
			            //pre_video_delete();
			            //pre_video_select();
						//video_select();
						$('.video_remove').click(function(){
							$('.video_uploading').html('');
							$('#working_panel_video').remove();
							$('.duration').html('00:00:00');
							VIDEO = '';
							VIDEO_GUID = '';
							VIDEO_LEFT = '';
							VIDEO_TOP = '';
						});
						//video_browse();
						$('#video_browse').val('');

						// Hide image container
				    	//$("#cover-spin").hide();
                	}
                },
                error: function (data, status, e)
                {                                       
                    ;
                },
		        complete:function(data){
				    // Hide image container
				    //$("#cover-spin").hide();
				    $("#progress_div").hide();
				    $('.progress-bar').attr('style','width:1%;');
			   	}
            });
		});
			
		$(document).on('click', '.video_select', function(){
			$('#working_panel_video').remove();
			var value = $(this).parent().parent().find('input').val();
			var value_array = value.split('=');
			VIDEO = value_array[0];
			VIDEO_GUID = value_array[1];
			guid = value_array[1];
			$('.working_panel').append('<video id="working_panel_video" class="resize-drag-video" style=" box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 0.7; border: 1px dashed red;" src="' + guid + '#t=1.0" preload="metadata"></video>');

			var video = document.getElementById('working_panel_video');
			video.addEventListener( "loadedmetadata", function (e) {
			    var naturalWidth = this.videoWidth;
			    var naturalHeight = this.videoHeight;
			    var duration = Math.floor(this.duration);
			    VIDEO_DURATION = this.duration;
			    var duration_str = secondsToTimeString(duration);
			    $('.duration').html(duration_str);

			    if(naturalHeight > 360){

			    	var height = 360;
			    	var ratio = naturalHeight / 360;
			    	var width = naturalWidth / ratio;

			    	if(BACKGROUND == 1){
			    		var working_panel_template = document.getElementById('working_panel_template_bg');
			    	} else {
			    		var working_panel_template = document.getElementById('working_panel');
			    	}
			    	
	  				var template_H = working_panel_template.clientHeight;
	  				var template_W = working_panel_template.clientWidth;

			    	if(width > template_W){
			    		var width1 = template_W;
			    		var ratio1 = width / template_W;
			    		var height1 = 360 / ratio1;
			    		$('#working_panel_video').attr('style','width:'+width1+'px; height:'+height1+'px; box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 0.7; border: 1px dashed red; background-image: url("'+video_edit_url+'/images/outline.png"); background-repeat: none; background-size: 100% 100%;');
			    	} else{
			    		$('#working_panel_video').attr('style','width:'+width+'px; height:'+height+'px; box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 0.7; border: 1px dashed red; background-image: url("'+video_edit_url+'/images/outline.png"); background-repeat: none; background-size: 100% 100%;');
			    	}
			    	
			    } else {
			    	if(BACKGROUND == 1){
			    		var working_panel_template = document.getElementById('working_panel_template_bg');
			    	} else {
			    		var working_panel_template = document.getElementById('working_panel');
			    	}

	  				var template_H = working_panel_template.clientHeight;
	  				var template_W = working_panel_template.clientWidth;

			    	if(naturalWidth > template_W){
			    		var width1 = template_W;
			    		var ratio1 = naturalWidth / template_W;
			    		var height1 = naturalHeight / ratio1;
			    		$('#working_panel_video').attr('style','width:'+width1+'px; height:'+height1+'px; box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 0.7; border: 1px dashed red; background-image: url("'+video_edit_url+'/images/outline.png"); background-repeat: none; background-size: 100% 100%;');
			    	} else{
			    		$('#working_panel_video').attr('style','width:'+naturalWidth+'px; height:'+naturalHeight+'px; box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 0.7; border: 1px dashed red; background-image: url("'+video_edit_url+'/images/outline.png"); background-repeat: none; background-size: 100% 100%;');
			    	}
			    }

			}, false );
			
		});

		secondsToTimeString = function (sec_num) {
		    var hours   = Math.floor(sec_num / 3600);
		    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
		    var seconds = sec_num - (hours * 3600) - (minutes * 60);

		    if (hours   < 10) {hours   = "0"+hours;}
		    if (minutes < 10) {minutes = "0"+minutes;}
		    if (seconds < 10) {seconds = "0"+seconds;}
		    return hours+':'+minutes+':'+seconds;
		}

		secondsToTimeString_1 = function(sec_num) {
			var hours   = Math.floor(sec_num / 3600);
		    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
		    var seconds = Math.floor(sec_num - (hours * 3600) - (minutes * 60));
		    var miliseconds = sec_num - (hours * 3600) - (minutes * 60) - seconds;
		    miliseconds = Math.floor(miliseconds * 1000);

		    if (hours   < 10) {hours   = "0"+hours;}
		    if (minutes < 10) {minutes = "0"+minutes;}
		    if (seconds < 10) {seconds = "0"+seconds;}

		    return hours+':'+minutes+':'+seconds+','+miliseconds;
		}

		$(document).on('click', '.pre_video_select', function(){
			var video_url = $(this).parent().find('video').attr('src');//wwwfsfd.com/fssd/a.mp4#1.0
			var video_url_a = video_url.split('#');
			var video_url_array = video_url_a[0].split('/');
			var file_name = video_url_array[video_url_array.length - 1];
			var video_id = $(this).parent().find('input').val();
            var video_upload_html = 
            	'<div class="col-md-12 text-center">'+
            		'<video class="thumbnail" src="'+video_url+'" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); height: 150px; width: auto; display: initial; margin-bottom: 5px;" controls preload="metadata"></video><br>'+
            		'<span>'+ ellipse_str(file_name.replace(/%20/g, " ")) +'</span><br>'+
            		'<a class="video_select"><span> <i class="fa fa-gear"> </i> </span><span>Add</span></a>&nbsp;&nbsp;&nbsp;&nbsp;' +
            		'<a class="video_remove"><span> <i class="fa fa-trash"> </i> </span><span>Remove</span></a>' +
            		'<input type="hidden" value="' + video_id + '=' + video_url_a[0] + '"/>'
            	'</div>';

			$('.video_uploading').html(video_upload_html);
			//video_select();
			$('.video_remove').click(function(){
				$('.video_uploading').html('');
				$('#working_panel_video').remove();
				$('.duration').html('00:00:00');
				VIDEO = '';
				VIDEO_GUID = '';
				VIDEO_TOP = '';
				VIDEO_LEFT = '';
			});

			$('.close').click();
		});

		$(document).on('click', '.pre_video_delete', function(){
			var video_id = $(this).parent().find('input').val();
			var send_data = {
				'attachment_id' : video_id
			}

			var ajax_url = admin_url + 'admin-ajax.php';
			var self = this;
			$('#cover-spin').show();
			$.ajax({
				url:ajax_url + '?action=delete_attachment',
				type:'post',
				data:send_data,
	          	dataType: 'json',
				success:function(data){
					if(data.success == 1){
				    	$(self).parent().parent().remove();
				    	$('#cover-spin').hide();
					}
				}
			});
		});

		//var text_image_check = 0;

		$('.video_pre_btn').click(function(){
			$('.video_upload_tab').removeClass('active');
			$('#video_upload_tab').removeClass('active');
			$('.template_background').addClass('active');
			$('#template_background').addClass('active');
			//text_image_check = 1;			
		});

		$('.video_next_btn').click(function(){
			if( VIDEO != '' ){
				$('.video_upload_tab').removeClass('active');
				$('#video_upload_tab').removeClass('active');
				$('.template_image').addClass('active');
				$('#template_image').addClass('active');
				
			 } else {
			 	alert('Please insert your video.');
			 }
		});

/************************** Text edit ************************/
		
		$('#outimage_1').hide();
		$('#outimage_2').hide();
		$('#outimage_3').hide();

		var TEXT_1 = '';
		var TEXT_2 = '';
		var TEXT_3 = '';
		var text_num = 0;

		$('.text_select').click(function(){

			var edit_text = window.text_edit.document.querySelector('input[name=edit_text]:checked');
			var num = edit_text.value;
			var text_content = window.text_edit.document.getElementById('text_content_'+num);
			if(text_content.value == ''){
				alert('Plese insert text');
			} else{
				window.text_edit.text_select();
				$('#outimage_'+num).show();
				if(num == 1){
					TEXT_1 = 'true';
				} else if(num == 2){
					TEXT_2 = 'true';
				} else {
					TEXT_3 = 'true';
				}
			}		
		});

		$('.text_remove').click(function(){
			var edit_text = window.text_edit.document.querySelector('input[name=edit_text]:checked');
			var num = edit_text.value;
			$('#outimage_'+num).hide();
			if(num == 1){
				TEXT_1 = '';
			} else if(num == 2){
				TEXT_2 = '';
			} else {
				TEXT_3 = '';
			}
		});

		//text_image_check = 0;
		$('.text_pre_btn').click(function(){
			$('.text_edit_tab').removeClass('active');
			$('#text_edit_tab').removeClass('active');
			$('.template_image').addClass('active');
			$('#template_image').addClass('active');

			$('#working_panel').html(WORKING_PANEL_TEMP);
			//text_image_check = 1;			
		});

		$('.text_next_btn').click(function(){
			$("#cover-spin").show();
			setTimeout(function() {
        		$('.text_edit_tab').removeClass('active');
				$('#text_edit_tab').removeClass('active');
				$('.image_upload_tab').addClass('active');
				$('#image_upload_tab').addClass('active');
				$("#cover-spin").hide();
				var png = window.text_edit.iframe_png_array;
				//console.log(png.length);
				//console.log(png);
				//console.log(png[png.length - 2]);
				document.getElementById('outimage').src = png[png.length - 2];
			}, 4000);
			
		});

// ************************ image upload **********************
		$('#image_browse').hide();
		$('.image_upload').click(function(){
			$('#image_browse').click();
		});

		var image_num = 0;

		var active = {};
		active['small_image_active_1'] = 0;
		active['small_image_active_2'] = 0;
		active['small_image_active_3'] = 0;

		image_browse();
		function image_browse(){
			$('#image_browse').change(function(){
				if(image_num < 3 ){
					var image_url = $('#image_browse').val();
					var url_split = image_url.split('\\');
					var file_name = url_split[url_split.length - 1];
					
					var image_upload_html = 
						'<div class="col-md-4 text-center" style="padding: 0px;">' +
			                '<span class="fa fa-file-image-o" style="font-size: 40px; padding: 30px; color: gray; border-style: solid; border-width: 1px; border-radius: 5px; border-color: #bbb;"> </span><br>' +
			                '<span style="font-size:12px;">' + ellipse_str(file_name) + '</span><br>' +
			                '<a style="font-size:12px;" href="#" class="image_upload_now"><span> <i class="fa fa-cloud-upload"> </i> Upload </span></a>&nbsp;&nbsp;' +
			                '<a style="font-size:12px;" href="#" class="image_upload_cancel"><span> <i class="fa fa-chain-broken"> </i> Cancel </span></a>' +
			            '</div>';
			        
					$('.image_uploading').append(image_upload_html);
					//image_upload();
					$('.image_upload_cancel').click(function(){
						$(this).parent().remove();
						$('#image_browse').val('');
					});
		        }
				
			});
		}		

		$(document).on('click', '.image_upload_now', function(){
			var self = this;
			var ajax_url = admin_url + 'admin-ajax.php';

            var file = $('#image_browse');
            var file = file.get(0).files[0];
            var formData = new FormData();
            formData.append('image_browse', file);

            $.ajax({
            	url : ajax_url+"?action=upload_image",
            	type : 'POST',
            	contentType : false,
            	cache : false,
            	processData : false,
            	data : formData,
            	xhr : function(){
            		var jqXHR = null;
                    if ( window.ActiveXObject )
                    {
                        jqXHR = new window.ActiveXObject( "Microsoft.XMLHTTP" );
                    }
                    else
                    {
                        jqXHR = new window.XMLHttpRequest();
                    }
                    //Upload progress
                    jqXHR.upload.addEventListener( "progress", function ( evt )
                    {
                        if ( evt.lengthComputable )
                        {
                            var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                            //Do something with upload progress
                            console.log( 'Uploaded percent', percentComplete );
                            $('.progress-bar').attr('style','width:'+percentComplete+'%;');
                        }
                    }, false );
                    //Download progress
                    jqXHR.addEventListener( "progress", function ( evt )
                    {
                        if ( evt.lengthComputable )
                        {
                            var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                            //Do something with download progress
                            console.log( 'Downloaded percent', percentComplete );
                        }
                    }, false );
                    return jqXHR;
                },
                beforeSend: function () {
	        		// Show image container
	    			//$("#cover-spin").show();
	    			$("#progress_div").show();
		        },
                success : function ( data )
                {
                	var result_data = JSON.parse(data);
                    if(result_data.success == 1){
						var image_url = result_data.msg;
						image_url = image_url.replace(/ /g, "%20");
						var attach_id = result_data.attach_id;
						var url_split = image_url.split('/');
						var file_name = url_split[url_split.length - 1];
						file_name = file_name.replace(/%20/g, " ");



						var class_array = [];
						$('.small_image').each(function(index){

							class_array.push($(this).attr('id'));
						});

						var enable = true; var id_exist = 1;
						while(enable)
						{
							if(class_array.indexOf('small_image_'+id_exist) == -1)
							{
								var image_upload_html = 
					            	'<div class="col-md-4 text-center small_image" id="small_image_'+id_exist+'" style="padding: 0px;">'+
					            		'<img class="thumbnail" src="'+image_url+'" style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); height: 100px; width: auto; display: initial; margin-bottom: 5px;"/><br>'+
					            		'<span style="font-size: 12px;">'+ ellipse_str(file_name) +'</span><br>'+
					            		'<a style="font-size: 12px;" class="image_select"><span> <i class="fa fa-gear"> </i> </span><span>Add</span></a>&nbsp;&nbsp;&nbsp;&nbsp;' +
					            		'<a style="font-size: 12px;" class="image_remove"><span> <i class="fa fa-trash"> </i> </span><span>Remove</span></a>' +
					            		'<input type="hidden" value="' + attach_id + '=' + image_url + '='+id_exist+'"/>'
					            	'</div>';
					            if(id_exist == 1 && class_array.length == 0){
					            	$('.image_uploading').append(image_upload_html);

					            } else if(id_exist == 1 && class_array.length != 0){
					            	if(class_array.indexOf('small_image_2') != -1){
					            		$(image_upload_html).insertBefore('#small_image_2');
					            	} else {
					            		$(image_upload_html).insertBefore('#small_image_3');
					            	}
					            } else {
					            	var pre_id = id_exist - 1;
					            	$(image_upload_html).insertAfter('#small_image_' + pre_id);
					            }

					            $('.image_remove').click(function(){
									var id = $(this).parent().attr('id');
									var id_array = id.split('_');
									var id_index = id_array[id_array.length - 1];
									active['small_image_active_' + id_index] = 0;
									$('#working_panel_image_' + id_index).remove();
									$(this).parent().remove();
									image_num--;
								});
					            enable = false;
							}
							else
							{
								id_exist ++;
							}

							if(id_exist>3)
							{
								break;
							}
						}

			            $(self).parent().remove();
			            $('#image_browse').val('');

						//$('.image_uploading').append(image_upload_html);

						var pre_image_add = 
							'<div class="col-md-2 text-center image_select_div">'+
			            		'<div class="thumbnail" style="border-radius: 0px;">'+
				            		'<input type="hidden" value="'+attach_id+'"/>'+
				            		'<img class="thumbnail" style="height: 100px; width: auto; margin-bottom: auto;" src="'+image_url+'"/><br>'+
				            		'<span style="font-size: 14px; font-weight: bold;">'+ellipse_str(file_name)+'</span><br>'+
				            		'<a class="pre_image_select" href="#"><i class="fa fa-gear"></i> Add </a>&nbsp;&nbsp;&nbsp;&nbsp;'+
				            		'<a class="pre_image_delete"><i class="fa fa-trash"></i> Delete</a>'+
				            	'</div>'+
			            	'</div>';
			            $('.image_modal').append(pre_image_add);
			            //pre_image_delete();
			            //pre_image_select();
						//image_select();
													
						//image_browse();
						image_num++;
                	}
                },
		        complete:function(data){
				    // Hide image container
				    //$("#cover-spin").hide();
				    $('#progress_div').hide();
				    $('.progress-bar').attr('style','width:1%;');
			   	}
            });

		});

		$(document).on('click','.image_select', function(){

			$(this).parent().attr('style','padding: 0px; border: 2px solid #26C281;');

			var value = $(this).parent().find('input').val();
			var value_array = value.split('=');
			IMAGE = value_array[0];
			guid = value_array[1];

			var id_exist = value_array[2];

			//active['small_image_active_' + id_exist] = 1;

			if(active['small_image_active_' + id_exist] == 0){

				$('#working_panel_image_' + id_exist).remove();

				var image = new Image();
				image.src = guid;
				var naturalHeight = image.naturalHeight;
				var naturalWidth = image.naturalWidth;

				if(naturalHeight > 360){
					var ratio = naturalHeight / 360;
					var height = 360;
					var width = naturalWidth / ratio;
					$('.working_panel').append('<img id="working_panel_image_'+id_exist+'" class="resize-drag-image" src="' + guid + '" />');
					$('#working_panel_image_'+id_exist).attr('style','width: '+width+'px; height:'+height+'px; box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 0.7;border: 1px dashed red; background-image: url("'+video_edit_url+'/images/outline.png"); background-repeat: none; background-size: 100% 100%;');
				} else {
					$('.working_panel').append('<img id="working_panel_image_'+id_exist+'" class="resize-drag-image" src="' + guid + '" />');
					$('#working_panel_image_'+id_exist).attr('style', 'width: '+naturalWidth+'px; height:'+naturalHeight+'px; box-sizing: border-box; position: absolute; top: 0px; left: 0px; opacity: 0.7;border: 1px dashed red; background-image: url("'+video_edit_url+'/images/outline.png"); background-repeat: none; background-size: 100% 100%;');

				}

				active['small_image_active_' + id_exist] = 1;
			}
			
		});
			
		$(document).on('click','.pre_image_select',function(){
			if(image_num < 3){
				var image_url = $(this).parent().find('img').attr('src');
				var image_url_array = image_url.split('/');
				var file_name = image_url_array[image_url_array.length - 1];
				var image_id = $(this).parent().find('input').val();

				var class_array = [];
				$('.small_image').each(function(index){

					class_array.push($(this).attr('id'));
				})

				var enable = true; var id_exist = 1;
				while(enable)
				{
					if(class_array.indexOf('small_image_'+id_exist) == -1)
					{
						var image_upload_html = 
			            	'<div class="col-md-4 text-center small_image" id="small_image_'+id_exist+'" style="padding: 0px;">'+
			            		'<img class="thumbnail" src="'+image_url+'" style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); height: 100px; width: auto; display: initial; margin-bottom: 5px;"/><br>'+
			            		'<span style="font-size: 12px;">'+ ellipse_str(file_name.replace(/%20/g, " ")) +'</span><br>'+
			            		'<a style="font-size: 12px;" class="image_select"><span> <i class="fa fa-gear"> </i> </span><span>Add</span></a>&nbsp;&nbsp;&nbsp;&nbsp;' +
			            		'<a style="font-size: 12px;" class="image_remove"><span> <i class="fa fa-trash"> </i> </span><span>Remove</span></a>' +
			            		'<input type="hidden" value="' + image_id + '=' + image_url + '=' + id_exist + '"/>'
			            	'</div>';
			            if(id_exist == 1 && class_array.length == 0){
			            	$('.image_uploading').append(image_upload_html);

			            } else if(id_exist == 1 && class_array.length != 0){
			            	if(class_array.indexOf('small_image_2') != -1){
			            		$(image_upload_html).insertBefore('#small_image_2');
			            	} else {
			            		$(image_upload_html).insertBefore('#small_image_3');
			            	}
			            } else {
			            	var pre_id = id_exist - 1;
			            	$(image_upload_html).insertAfter('#small_image_' + pre_id);
			            }

			            $('.image_remove').click(function(){
							
							var id = $(this).parent().attr('id');
							var id_array = id.split('_');
							var id_index = id_array[id_array.length - 1];
							active['small_image_active_' + id_index] = 0;
							$('#working_panel_image_' + id_index).remove();

							$(this).parent().remove();
							image_num--;
						});
			            enable = false;

					}
					else
					{
						id_exist ++;
					}

					if(id_exist>3)
					{
						break;
					}
				}

				//$('.image_uploading').append(image_upload_html);
				//image_select();
				$('.image_remove').click(function(){
					$(this).parent().remove();
					$('#working_panel_image').remove();
					//IMAGE = '';
					image_num--;
				});

				image_num++;
			}

			$('.close').click();

		});

		$(document).on('click','.pre_image_delete',function(){
			var image_id = $(this).parent().find('input').val();
			var send_data = {
				'attachment_id' : image_id
			}

			var ajax_url = admin_url + 'admin-ajax.php';
			var self = this;
			$('#cover-spin').show();
			$.ajax({
				url:ajax_url + '?action=delete_attachment',
				type:'post',
				data:send_data,
	          	dataType: 'json',
				success:function(data){
					if(data.success == 1){
				    	$(self).parent().parent().remove();
				    	$('#cover-spin').hide();
					}
				}
			});
		});

		$('.image_pre_btn').click(function(){
			$('.image_upload_tab').removeClass('active');
			$('#image_upload_tab').removeClass('active');
			$('.text_edit_tab').addClass('active');
			$('#text_edit_tab').addClass('active');
		});

/************************  Resize  *************************/
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
			      min: { width: 50, height: 50 },
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
		interact('#working_panel_video')
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
			      min: { width: 50, height: 50 },
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
			      min: { width: 50, height: 50 },
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
			      min: { width: 50, height: 50 },
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
		 interact('.resize-drag-template-image')
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
			      min: { width: 50, height: 50 },
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

/**************************** Subtitle **********************/

		$('.image_next_btn').click(function(){
			var ajax_url = admin_url + 'admin-ajax.php';


			var working_panel = document.getElementById('working_panel');

	  		var template_id = TEMPLATE;
	  		var template_url = $('.working_panel_template').attr('src');
	  		var working_panel_template = document.getElementById('working_panel_template');
	  		var template_H = working_panel_template.clientHeight;
	  		var template_W = working_panel_template.clientWidth;

	  		var video_id = VIDEO;
	  		var video_url_a = $('#working_panel_video').attr('src');
	  		var video_url_ab = video_url_a.split('#');
	  		var video_url = video_url_ab[0];
	  		var working_panel_video = document.getElementById('working_panel_video');
	  		var video_h = working_panel_video.clientHeight;
	  		var video_w = working_panel_video.clientWidth;
	  		var video_y = $('#working_panel_video').attr('data-y');
	  		var video_x = $('#working_panel_video').attr('data-x');
	  		if(video_y == undefined) { video_y = 0; }
			if(video_x == undefined) { video_x = 0; }

	  		var image = [];
	  		if(image_num != 0){
	  			
				$('.resize-drag-image').each(function(index){
					var image_url = $(this).attr('src');
			  		var image_url_array = image_url.split('.');
			  		var image_type = image_url_array[image_url_array.length - 1];
			  		var id = $(this).attr('id');
			  		var working_panel_image = document.getElementById(id);
			  		var image_h = working_panel_image.clientHeight;
			  		var image_w = working_panel_image.clientWidth;
			  		var image_y = $(this).attr('data-y');
			  		var image_x = $(this).attr('data-x');

					var image_json = {
						'image_url' : image_url,
						'image_type' : image_type,
						'image_h' : image_h * RATIO,
						'image_w' : image_w * RATIO,
						'image_y' : image_y * RATIO,
						'image_x' : image_x * RATIO
					}
					image.push(image_json);
				});

		  	}

	  		/* Text */					  		
	  		//png_array = png_array.slice(png_array.length - 70, png_array.length-1);
	  		var text = [];
	  		if(TEXT_1 == 'true' || TEXT_2 == 'true' || TEXT_3 == 'true'){

	  			if(TEXT_1 == 'true'){
	  				text_num ++;
	  				var png_array = window.text_edit.iframe_png_array_1;
			  		var outimage = document.getElementById('outimage_1');
			  		var text_image_h = outimage.clientHeight;
			  		var text_image_w = outimage.clientWidth;
			  		var text_image_y = $('#outimage_1').attr('data-y');
			  		var text_image_x = $('#outimage_1').attr('data-x');
			  		var text_repeat = window.text_edit.repeat_1;
			  		var text_json = {
			  			'png_array' : png_array,
			  			'text_image_h' : text_image_h * RATIO,
			  			'text_image_w' : text_image_w * RATIO,
			  			'text_image_x' : text_image_x * RATIO,
			  			'text_image_y' : text_image_y * RATIO,
			  			'text_repeat' : text_repeat
			  		}

			  		text.push(text_json);

	  			}

	  			if(TEXT_2 == 'true'){
	  				text_num++;
	  				var png_array = window.text_edit.iframe_png_array_2;
			  		var outimage = document.getElementById('outimage_2');
			  		var text_image_h = outimage.clientHeight;
			  		var text_image_w = outimage.clientWidth;
			  		var text_image_y = $('#outimage_2').attr('data-y');
			  		var text_image_x = $('#outimage_2').attr('data-x');
			  		var text_repeat = window.text_edit.repeat_2;
			  		var text_json = {
			  			'png_array' : png_array,
			  			'text_image_h' : text_image_h * RATIO,
			  			'text_image_w' : text_image_w * RATIO,
			  			'text_image_x' : text_image_x * RATIO,
			  			'text_image_y' : (Number(text_image_y)+80) * RATIO,
			  			'text_repeat' : text_repeat
			  		}

			  		text.push(text_json);

	  			}

	  			if(TEXT_3 == 'true'){
	  				text_num++;
	  				var png_array = window.text_edit.iframe_png_array_3;
			  		var outimage = document.getElementById('outimage_3');
			  		var text_image_h = outimage.clientHeight;
			  		var text_image_w = outimage.clientWidth;
			  		var text_image_y = $('#outimage_3').attr('data-y');
			  		var text_image_x = $('#outimage_3').attr('data-x');
			  		var text_repeat = window.text_edit.repeat_3;
			  		var text_json = {
			  			'png_array' : png_array,
			  			'text_image_h' : text_image_h * RATIO,
			  			'text_image_w' : text_image_w * RATIO,
			  			'text_image_x' : text_image_x * RATIO,
			  			'text_image_y' : (Number(text_image_y)+160) * RATIO,
			  			'text_repeat' : text_repeat
			  		}

			  		text.push(text_json);

	  			}
	  			
		  	}

	  		var send_data = {

	  			'template_id' : template_id,
	  			'template_url' : template_url,
	  			'template_H' : template_H * RATIO,
	  			'template_W' : template_W * RATIO,

	  			'video_id' : video_id,
	  			'video_url' : video_url,
	  			'video_h' : video_h * RATIO,
	  			'video_w' : video_w * RATIO,
	  			// 'video_x' : video_x * RATIO,
	  			// 'video_y' : video_y * RATIO,
	  			'video_x' : (Number(video_x) + Number(VIDEO_LEFT)) * RATIO,
	  			'video_y' : (Number(video_y) + Number(VIDEO_TOP)) * RATIO,

	  			'image_num' : image_num,
	  			'image' : image,

	  			'text_num' : text_num,
	  			'text' : text,
	  		};

			$.ajax({
				url:ajax_url + '?action=rendering_1',
				type:'post',
				data:send_data,
	          	dataType: 'json',
				beforeSend: function () {
	        		// Show image container
	    			$("#cover-spin").show();
	    			$('#progress_span_div').show();
		        },
		        success: function (res) {
		        },
		        error: function (err) {
		        },
		        complete:function(data1){
				    
				    if(data1.responseJSON.success == 1){
				    	//var post_id = data1.responseJSON.post_id;
				    	var result_video = data1.responseJSON.result_video;
				    	var result_video_path = data1.responseJSON.result_video_path;
			        	setTimeout(function() {

			        		VIDEO_TEMP = result_video;

			        		//$('#working_panel').hide();

			        		var html = '<video id="project_result_video_0" class="project_result_video_0" src="' + result_video + '#t=0.3" controls style="height:360px; width:auto;"></video>';
							$('#working_panel').html(html);
							$('#working_panel_top').attr('style','height: 360px; margin-top: 70px; margin-bottom: 70px; display: inline-block;');



							$('#subtitle_edit').hide();
							//$('#working_panel_top').attr('style','width:100%;');
							window.subtitle_edit.video_show(result_video);
							window.subtitle_edit.append_subtitle_div();
							//window.subtitle_edit.timeline_style();
							

							$("#cover-spin").hide();
							$('#progress_span_div').hide();
						}, 7000);

						$('.image_upload_tab').removeClass('active');
						$('#image_upload_tab').removeClass('active');
						$('.subtitle_tab').addClass('active');
						$('#subtitle_tab').addClass('active');


						$('#subtitle_select_option').show();
						$('.subtitle_upload_div').hide();
						$('.subtitle_edit_div').hide();
						$('.subtitle_upload_prev').hide();
						$('.subtitle_edit_prev').hide();
				    }
			   	}
			});
		
		});

		$('.subtitle_upload_form').click(function(){
			SUBTITLE = 1;
			$('#subtitle_select_option').hide();
			$('.subtitle_upload_div').show();
			$('.subtitle_upload_prev').show();
			$('.subtitle_edit_div').hide();

			$('#working_panel').show();
			$('#subtitle_edit').hide();
			$('#working_panel_top').attr('style','height: 360px; margin-top: 70px; margin-bottom: 70px; display: inline-block;');
		});

		$('.subtitle_edit_form').click(function(){
			SUBTITLE = 0;
			$('#subtitle_select_option').hide();
			$('.subtitle_upload_div').hide();
			$('.subtitle_edit_div').show();
			$('.subtitle_edit_prev').show();

			$('#working_panel').hide();
			$('#subtitle_edit').show();
			$('#working_panel_top').attr('style','width:100%;');
		});


		$('.subtitle_upload_prev').click(function(){
			$('#subtitle_select_option').show();
			$('.subtitle_upload_div').hide();
			$(this).hide();
		});

		$('.subtitle_edit_prev').click(function(){
			$('#subtitle_select_option').show();
			$('.subtitle_edit_div').hide();
			$(this).hide();

			$('#working_panel').show();
			$('#subtitle_edit').hide();
			$('#working_panel_top').attr('style','height: 360px; margin-top: 70px; margin-bottom: 70px; display: inline-block;');

		});		


		var SUBTITLE = 1;
		var SUBTITLE_URL = '';

		$('#subtitle_browse').hide();
		$('.subtitle_upload').click(function(){
			$('#subtitle_browse').click();
		});

		$('.subtitle_upload_div').show();
		$('.subtitle_edit_div').hide();

		$('input[name=subtitle_option').change(function(){
			
			var num = $('input[name=subtitle_option]:checked').val();
			if(num == 1){
				$('.subtitle_upload_div').show();
				$('.subtitle_edit_div').hide();
				SUBTITLE = 1;
			} else {
				$('.subtitle_upload_div').hide();
				$('.subtitle_edit_div').show();
				SUBTITLE = 0;
			}
		});


		subtitle_browse();
		function subtitle_browse(){
			$('#subtitle_browse').change(function(){
				var subtitle_url = $('#subtitle_browse').val();
				var url_split = subtitle_url.split('\\');
				var file_name = url_split[url_split.length - 1];
				
				var subtitle_upload_html = 
					'<div class="col-md-2 text-center" style="border-style: solid; border-width: 1px; border-radius: 5px; border-color: #bbb; height: 75px;">' +
		                '<span class="fa fa-file-text-o" style="font-size: 40px; padding-top: 30px; color: gray;"> </span>' +
		            '</div>' +
		            '<div class="col-md-10" style="padding-left: 30px;">' +
		                '<h4>' + ellipse_str(file_name) + '</h4>' +
		                // '<a href="#" class="subtitle_upload_now"><span> <i class="fa fa-cloud-upload"> </i> Add </span></a>&nbsp;&nbsp;&nbsp;&nbsp;' +
		                '<a href="#" class="subtitle_upload_cancel"><span> <i class="fa fa-chain-broken"> </i> Remove </span></a>' +
		            '</div>';

				$('.subtitle_uploading').html(subtitle_upload_html);
				//video_upload();
				$('.subtitle_upload_cancel').click(function(){
					$('.subtitle_uploading').html('');
					$('#subtitle_browse').val('');
				});
			});
		}


		function subtitle_upload(){
			var ajax_url = admin_url + 'admin-ajax.php';
			
	    	var file = $('#subtitle_browse');
            var file = file.get(0).files[0];
            var formData = new FormData();
            formData.append('subtitle_browse', file);

            $.ajax({
            	url : ajax_url+"?action=upload_subtitle",
            	type : 'POST',
            	contentType : false,
            	cache : false,
            	processData : false,
            	data : formData,
            	xhr : function(){
            		var jqXHR = null;
                    if ( window.ActiveXObject )
                    {
                        jqXHR = new window.ActiveXObject( "Microsoft.XMLHTTP" );
                    }
                    else
                    {
                        jqXHR = new window.XMLHttpRequest();
                    }
                    //Upload progress
                    jqXHR.upload.addEventListener( "progress", function ( evt )
                    {
                        if ( evt.lengthComputable )
                        {
                            var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                            //Do something with upload progress
                            console.log( 'Uploaded percent', percentComplete );
                            $('.progress-bar').attr('style','width:'+percentComplete+'%;');
                        }
                    }, false );
                    //Download progress
                    jqXHR.addEventListener( "progress", function ( evt )
                    {
                        if ( evt.lengthComputable )
                        {
                            var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                            //Do something with download progress
                            console.log( 'Downloaded percent', percentComplete );
                        }
                    }, false );
                    return jqXHR;
                },
                beforeSend: function () {
		        },
                success : function ( data )
                {
                	var result_data = JSON.parse(data);
                	if(result_data.success == 1){
						var subtitle_url = result_data.msg;
						SUBTITLE_URL = subtitle_url;
						
                	}
                },
                error: function (data, status, e)
                {                                       
                    ;
                },
		        complete:function(data){
			   	}
            });
		}

		
		var subtitle_num = 0;
		var subtitle_total_content = '';
		subtitle_total_temp_content = '';
		$('#subtitle_add').click(function(){
			if($('#subtitle_part').val() == ''){
				alert('Please input subtitle content.');
			} else {
				var content = $('#subtitle_part').val();
				//window.subtitle_edit.remove_subtitle();
				//window.subtitle_edit.change_subtitle(content);
				var list_content = content.replace(/\n/g, '<br>');
				var content_html = 
					'<div id="subtitle_'+subtitle_num+'" class="subtitle col-md-12" style="padding:0px; border:1px solid lightgray; margin-bottom:10px; padding-top: 5px; padding-bottom: 5px;" attr_id="' + subtitle_num + '">'+
        				'<p class="col-md-3" id="subtitle_time_'+subtitle_num+'" style="margin: 0px;">00:00:00,000 00:00:00,000</p>'+
        				'<p class="col-md-8" subtitle_content" id="subtitle_content_'+subtitle_num+'" contenteditable="true" style="margin:0px;">'+list_content+'</p>'+
        				'<span class="col-md-1 subtitle_remove" style="float:right;"><i class="fa fa-trash"></i></span>'
        			'</div>';
        		$('#subtitle_content_form').append(content_html);

        		$('.subtitle_remove').click(function(){
        			var id = $(this).parent().attr('attr_id');
        			window.subtitle_edit.remove_subtitle_textarea(id);
        			$(this).parent().remove();
        		});


        		window.subtitle_edit.append_subtitle(list_content, subtitle_num);

        		subtitle_num++;

				$('#subtitle_part').val('');
			}
		});

		$("#subtitle_part").on("keypress", function(e) {
		    var key = e.keyCode;
		    // If the user has pressed enter
		    if (key == 13 && !e.shiftKey) {
		        $('#subtitle_add').click();
		        $('#subtitle_part').val('');
		        e.preventDefault();
				return false;
		    }
		});

		var num_temp = '';
		$(document).on('click','.subtitle', function(){
			if(num_temp != ''){
				$('#subtitle_'+num_temp).attr('style','padding:0px; border:1px solid lightgray; margin-bottom:10px; padding-top: 5px; padding-bottom: 5px;');
				window.subtitle_edit.bg_color_remove(num_temp);
			}
			$(this).attr('style','padding:0px; border:1px solid lightgray; margin-bottom:10px; padding-top: 5px; padding-bottom: 5px; background-color: #c0edf1;');
			window.subtitle_edit.bg_color_add($(this).attr('attr_id'));
			num_temp = $(this).attr('attr_id');
		});

		$('body').on('focus', '[contenteditable]', function() {
		    var $this = $(this);
		    $this.data('before', $this.html());
		    return $this;
		}).on('blur keyup paste input', '[contenteditable]', function() {
		    var $this = $(this);
		    if ($this.data('before') !== $this.html()) {
		        $this.data('before', $this.html());
		        $this.trigger('change');
		        var content = $(this).html();
		  		var num = $(this).parent().attr('attr_id');
		  		window.subtitle_edit.change_textarea(num, content);
		    }
		    return $this;
		});

		function subtitle_size_change(num, start, end ){
			var start_time = start * VIDEO_DURATION;
			var end_time = end * VIDEO_DURATION;

			var start_string = secondsToTimeString_1(start_time);
			var end_string = secondsToTimeString_1(end_time);
			var text = start_string + ' ' + end_string;

			$('#subtitle_time_'+num).text(text);
		}

/*************************** Rendering *********************/
		$('.open_preview').hide();
		$('.open_render').hide();
		$('.save_preview').click(function(){
				$('.open_render').click();
				subtitle_upload();
		});

		$(".rendering_file_name").on("keypress", function(e) {
		    var key = e.keyCode;
		    // If the user has pressed enter
		    if (key == 13) {
		        $('.save_preview_btn').click();
		    }
		});

	  	$('.save_preview_btn').click(function(){

	  		if($('.rendering_file_name').val() == ''){
	  			alert('Please Input Save File Name.');
	  		} else {
	  			var project_video_name = $('.rendering_file_name').val();
	  			var ajax_url = admin_url + 'admin-ajax.php';
	  			var video_name_checking = {
	  				'video_name' : project_video_name
	  			};

				$.ajax({
					url:ajax_url + '?action=video_name_checking',
					type:'post',
					data:video_name_checking,
		          	dataType: 'json',
					beforeSend: function () {
		        		// Show image container
		    			$("#cover-spin").show();
			        },
			        success: function (res) {
			        },
			        error: function (err) {
			        },
			        complete:function(data){
			        	$("#cover-spin").hide();
					    if( !(data.responseJSON.success) ){
					    	alert('The name "' + project_video_name + '" is already existed, please try with another one.');
					    	$('.rendering_file_name').val('');
					    } else {
					  		$('.rendering_file_name').val('');
					  		$('.save_cancel').click();

					  		// var video_url_a = $('#project_result_video_0').attr('src');
					  		// var video_url_ab = video_url_a.split('#');
					  		var video_url = VIDEO_TEMP;

					  		var subtitle_content = $('#subtitle_content').val();

						  	project_video_name = project_video_name.replace(/ /g, "_");
					  		project_video_name = project_video_name.replace(/\./g, "");


					  		if(SUBTITLE == 1){
					  			var send_data = {
						  			'video_url' : video_url,
						  			'subtitle' : SUBTITLE,
						  			'subtitle_url' : SUBTITLE_URL,
						  			'result_video_name' : project_video_name,
						  		};
					  		} else {
					  			var total_subtitle = '';
					  			var index_num = 0;
					  			$('.subtitle').each(function(index){
					  				var time = $(this).find('p').eq(0).text();
					  				time = time.replace(' ', ' --> ');
					  				var content = $(this).find('p').eq(1).html();
					  				content = content.replace(/<br>/g, '\n');
					  				content = content.replace(/<div>/g, '\n');
					  				content = content.replace(/<\/div>/g, '\n');

					  				total_subtitle += 
					  					index_num + '\n' + 
					  					time + '\n' +
					  					content + '\n\n';
					  				index_num++;
								});

					  			var send_data = {
						  			'video_url' : video_url,
						  			'subtitle' : SUBTITLE,
						  			'subtitle_content' : total_subtitle,
						  			'result_video_name' : project_video_name,
						  		};
					  		}

					  		
					  		//console.log(send_data);
					  		//console.log(window.text_edit.iframe_png_array);

							$.ajax({
								url:ajax_url + '?action=final_rendering',
								type:'post',
								data:send_data,
					          	dataType: 'json',
								beforeSend: function () {
					        		// Show image container
					    			$("#cover-spin").show();
					    			$('#progress_span_div_subtitle').show();
						        },
						        success: function (res) {
						        },
						        error: function (err) {
						        },
						        complete:function(data1){
								    
								    if(data1.responseJSON.success == 1){
								    	var post_id = data1.responseJSON.post_id;
								    	var result_video = data1.responseJSON.result_video;
							        	setTimeout(function() {
							        		var html = '<video id="project_result_video" class="project_result_video" src="' + result_video + '#t=0.3" controls style="width:60%; height:auto;"></video> <br> <br>' +		
								        		'<a type="button" class="download_video btn green-jungle btn-circle" style="width: 20%" href="'+ result_video +'" download>Download</a>&nbsp;&nbsp;' +
								        		'<a type="button" class="new_video_edit btn green-jungle btn-circle btn-outline " style="width: 20%">Create new</a>&nbsp;&nbsp;' +
								        		'<a type="button" class="go_working_panel btn green-jungle btn-circle btn-outline" data-dismiss="modal" style="width: 20%">Woking panel</a>';
										  	$('.result_video').html(html);
										  	$('.new_video_edit').click(function(){
										  		window.location.href =  home_url + '/video-template';
										  	});

											$('.open_preview').click();

											$("#cover-spin").hide();
											$('#progress_span_div_subtitle').hide();
										}, 7000);						    	
								    }
							   	}
							});
					    }
				   	}
				});
			}
	  	});	  		

	</script>
<!-- ****************************************************** -->

<?php get_footer(); ?>
