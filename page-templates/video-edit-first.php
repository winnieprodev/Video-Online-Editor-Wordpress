<?php

/*

Template Name: Video Edit First

*/

	if ( is_user_logged_in() ) {

	    global $current_user;
	    wp_get_current_user();

	    $args = array( 
	    	'orderby' => 'date', 
	    	'order' => 'DESC', 
	    	'post_type' => 'workingvideo', 
	    	'author' => $current_user->ID ,
	    	'posts_per_page' => -1,
	    );

	    $query = new WP_Query($args);
	    $result_videos =$query->posts;

	} else {
		wp_redirect(home_url().'/login', 301);
	}

	$video_edit_url = content_url('themes/sydney');
	$home_url = home_url();
	$admin_url = admin_url();

	get_header();	
	
?>
	<!-- ******************************  URL ************************************* -->
	<input id="video_edit_url" type="hidden" value="<?php echo $video_edit_url; ?>"/>
    <input id="admin_url" type="hidden" value="<?php echo $admin_url; ?>" />
    <input id="home_url" type="hidden" value="<?php echo $home_url; ?>" />
    <!-- ******************************  URL ************************************* -->

    <div id="cover-spin"></div>
    
	<style type="text/css">
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

    <div id="content" class="page-wrap" style="padding-top: 30px;">
		<div class="container content-wrapper" style="margin-left: 0px; margin-right: 0px; width: 100%;">
			<div class="row">

				<div class="container-fluid col-md-12" style="min-height: 500px;">
					<div class="col-md-12">
						<h4>ALL VIDEOS</h4>
					</div>
					<div class="col-md-12">
						<div class="col-md-3 text-center" style="border-radius: 15px; height: 210px;">
							<div class="col-md-1"></div>
			        		<div class="create_video" style="border-style: dashed; border-radius: 15px; margin-top: 10px;">
			        			<h1 style="padding-top: 10px;"><i class="fa fa-plus-circle"></i></h1>
			                	<h5 style="padding-bottom: 10px;"> Create a New Video </h5>
			        		</div>
			        		<div class="col-md-1"></div>
			        	</div>
						<?php
						if ( $result_videos ) {
			        		foreach ( $result_videos as $post ) : 
			            ?>
			            	<div class="col-md-3 text-center" style="border-radius: 15px; height: 230px;">
			            		<form action="" method="post" id="video_post_<?php echo $post->ID; ?>">
			            			<input type="hidden" value="<?php echo $post->ID; ?>" name="video_post_id" id="video_post_id"/>
			            		</form>           		
								<video style="width: auto; height: 160px; border: 1px solid gray; border-radius: 5px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); margin-top: 10px;" src="<?php echo $post->guid; ?>#t=0.3" controls preload="metadata"></video><br>
								<span style="font-size: 14px; font-weight: bold;"><?php echo $post->post_title; ?></span><br>
								<span><!-- <a href="#" class="video_edit"> Edit </a> &nbsp;&nbsp; --><a href="<?php echo $post->guid; ?>" class="video_download" download><i class="fa fa-cloud-download"></i> Download </a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="video_delete"><i class="fa fa-trash"></i> Delete </a><span>
							</div>
			        	<?php
			        		endforeach;
					    }
					    ?>
					</div>
				</div>


	<?php get_footer(); ?>

	<script src="<?php echo $video_edit_url; ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">

		var video_edit_url = $('#video_edit_url').val();
    	var admin_url = $('#admin_url').val();
    	var home_url = $('#home_url').val();

		$('.create_video').click(function(){
			var url = home_url + '/video-template';
			//alert(url);
			window.location.href =  url; 
		});

		
		$('.video_edit').click(function(){
			var id = $(this).parent().parent().find('input').val();
			//alert(id);
			$('#video_post_' + id).attr('action', home_url + '/video-edit-detail');
			$('#video_post_' + id).submit();
		});

		$('.video_delete').click(function(){
			var video_post_id = $(this).parent().parent().find('input').val();
			var send_data = {
				'video_post_id' : video_post_id
			}

			var ajax_url = admin_url + 'admin-ajax.php';
			var self = this;
			$('#cover-spin').show();
			$.ajax({
				url:ajax_url + '?action=delete_video_post',
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

	</script>

