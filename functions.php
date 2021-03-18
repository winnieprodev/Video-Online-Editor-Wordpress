<?php
/**
 * Sydney functions and definitions
 *
 * @package Sydney
 */


if ( ! function_exists( 'sydney_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function sydney_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Sydney, use a find and replace
	 * to change 'sydney' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'sydney', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Content width
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 1170; /* pixels */
	}

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size('sydney-large-thumb', 830);
	add_image_size('sydney-medium-thumb', 550, 400, true);
	add_image_size('sydney-small-thumb', 230);
	add_image_size('sydney-service-thumb', 350);
	add_image_size('sydney-mas-thumb', 480);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'sydney' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'sydney_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // sydney_setup
add_action( 'after_setup_theme', 'sydney_setup' );


/********************************* video upload *******************************/
add_action('wp_ajax_upload_video','upload_video');
add_action('wp_ajax_nopriv_upload_video','upload_video');

function upload_video(){
	$error = "";
    $msg = "";

    $fileElementName = 'video_browse';

    if(!empty($_FILES[$fileElementName]['error']))
    {
        switch($_FILES[$fileElementName]['error'])
        {
            case '1':
                $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                break;
            case '2':
                $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                break;
            case '3':
                $error = 'The uploaded file was only partially uploaded';
                break;
            case '4':
                $error = 'No file was uploaded.';
                break;

            case '6':
                $error = 'Missing a temporary folder';
                break;
            case '7':
                $error = 'Failed to write file to disk';
                break;
            case '8':
                $error = 'File upload stopped by extension';
                break;
            case '999':
            default:
                $error = 'No error code avaiable';
        }
    } else if(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == null)
    {
        $error = 'No file was uploaded..';
    }else 
    {
    	$wp_upload_dir = wp_upload_dir();

    	/* file name checking */
    	$video_name = $_FILES[$fileElementName]['name'];

    	function checking_video_name($str){
    		$check = true;

			$all_videos = get_posts( 
				array( 
					'post_parent' => 0, 
					'post_type' => 'attachment', 
					'post_mime_type' => 'video',
					'posts_per_page' => -1,
				)
			);

			$all_working_videos = get_posts( 
				array(
					'post_type' => 'workingvideo', 
					'post_mime_type' => 'video',
					'posts_per_page' => -1,
				)
			);
			
			foreach ($all_videos as $value) {
				$guid = $value->guid;
				$attachment_name_array = explode('/', $guid);
				$attachment_name = $attachment_name_array[count($attachment_name_array)-1];
				$attachment_name = str_replace('%20', ' ', $attachment_name);

				if( $attachment_name == $str){
					$check = false;
					break;
				}
			}

			if($check){
				foreach ($all_working_videos as $value) {
					$guid = $value->guid;
					$attachment_name_array = explode('/', $guid);
					$attachment_name = $attachment_name_array[strlen($attachment_name_array)-1];
					$attachment_name = str_replace('%20', ' ', $attachment_name);

					if( $attachment_name == $str){
						$check = false;
						break;
					}
				}
			}
			return $check;
    	}

    	$index = 1;
    	while(!(checking_video_name($video_name))){
    		$video_name_array = explode('.', $video_name);
    		$video_name = $video_name_array[0] . '_' . $index . '.' . $video_name_array[1];
    		$index++;
    	}
		
        move_uploaded_file($_FILES[$fileElementName]['tmp_name'], $wp_upload_dir['path'] . '/' . $video_name);
        $msg .= $wp_upload_dir['url'] . '/' . $video_name;

        // -------------------------------------------------------
        $filename = $wp_upload_dir['path'] . '/' . $video_name;
		$parent_post_id = 0;
		$filetype = wp_check_filetype( basename( $filename ), null);
		

		$attachment = array(
			'post_author' => get_current_user_id(),
			'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ),
			'post_mime_type' => $filetype['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename( $filename )),
			'post_content' => '',
			'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		set_post_thumbnail( $parent_post_id, $attach_id );

        // -------------------------------------------------------
        //for security reason, we force to remove all uploaded file
        @unlink($_FILES[$fileElementName]);     
    }       

    $a = array(
    	'success' => 1,
    	'error' => $error,
    	'msg' => $msg,
    	'attach_id' => $attach_id
    );

    $a = json_encode($a);
    echo $a;
    wp_die();
}


/*************************** image upload **********************************/
add_action('wp_ajax_upload_image','upload_image');
add_action('wp_ajax_nopriv_upload_image','upload_image');

function upload_image(){
	$error = "";
    $msg = "";

    $fileElementName = 'image_browse';

    if(!empty($_FILES[$fileElementName]['error']))
    {
        switch($_FILES[$fileElementName]['error'])
        {
            case '1':
                $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                break;
            case '2':
                $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                break;
            case '3':
                $error = 'The uploaded file was only partially uploaded';
                break;
            case '4':
                $error = 'No file was uploaded.';
                break;

            case '6':
                $error = 'Missing a temporary folder';
                break;
            case '7':
                $error = 'Failed to write file to disk';
                break;
            case '8':
                $error = 'File upload stopped by extension';
                break;
            case '999':
            default:
                $error = 'No error code avaiable';
        }
    } else if(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == null)
    {
        $error = 'No file was uploaded..';
    }else 
    {
    	$wp_upload_dir = wp_upload_dir();

    	/* file name checking */
    	$image_name = $_FILES[$fileElementName]['name'];

    	function checking_image_name($str){
    		$check = true;

			$all_images = get_posts( 
				array( 
					'post_parent' => 0, 
					'post_type' => 'attachment', 
					'post_mime_type' => 'image',
					'posts_per_page' => -1,
				)
			);

			$args = array(
			  	'post_type' => 'template',
			  	'posts_per_page' => -1,
			);
			$query = new WP_Query($args);
			$all_templates = $query->posts;
			
			foreach ($all_images as $value) {
				$guid = $value->guid;
				$attachment_name_array = explode('/', $guid);
				$attachment_name = $attachment_name_array[count($attachment_name_array)-1];
				$attachment_name = str_replace('%20', ' ', $attachment_name);

				if( $attachment_name == $str){
					$check = false;
					break;
				}
			}

			if($check){
				foreach ($all_templates as $value) {
					$media = get_attached_media( 'image' , $value->ID );
					$guid = $media[0]->guid;
					$attachment_name_array = explode('/', $guid);
					$attachment_name = $attachment_name_array[strlen($attachment_name_array)-1];
					$attachment_name = str_replace('%20', ' ', $attachment_name);

					if( $attachment_name == $str){
						$check = false;
						break;
					}
				}
			}
			return $check;
    	}

    	$index = 1;
    	while(!(checking_image_name($image_name))){
    		$image_name_array = explode('.', $image_name);
    		$image_name = $image_name_array[0] . '_' . $index . '.' . $image_name_array[1];
    		$index++;
    	}

        move_uploaded_file($_FILES[$fileElementName]['tmp_name'], $wp_upload_dir['path'] . '/' . $image_name);
        $msg .= $wp_upload_dir['url'] . '/' . $image_name;

        // -------------------------------------------------------
        $filename = $wp_upload_dir['path'] . '/' . $image_name;
		$parent_post_id = 0;
		$filetype = wp_check_filetype( basename( $filename ), null);
		

		$attachment = array(
			'post_author' => get_current_user_id(),
			'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ),
			'post_mime_type' => $filetype['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename( $filename )),
			'post_content' => '',
			'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		set_post_thumbnail( $parent_post_id, $attach_id );

        // -------------------------------------------------------
        //for security reason, we force to remove all uploaded file
        @unlink($_FILES[$fileElementName]);     
    }       

    $a = array(
    	'success' => 1,
    	'error' => $error,
    	'msg' => $msg,
    	'attach_id' => $attach_id
    );

    $a = json_encode($a);
    echo $a;
    wp_die();
}


/*************************** template image upload **********************************/
add_action('wp_ajax_upload_template_image','upload_template_image');
add_action('wp_ajax_nopriv_upload_template_image','upload_template_image');

function upload_template_image(){
	$error = "";
    $msg = "";

    $fileElementName = 'template_image_browse';

    if(!empty($_FILES[$fileElementName]['error']))
    {
        switch($_FILES[$fileElementName]['error'])
        {
            case '1':
                $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                break;
            case '2':
                $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                break;
            case '3':
                $error = 'The uploaded file was only partially uploaded';
                break;
            case '4':
                $error = 'No file was uploaded.';
                break;

            case '6':
                $error = 'Missing a temporary folder';
                break;
            case '7':
                $error = 'Failed to write file to disk';
                break;
            case '8':
                $error = 'File upload stopped by extension';
                break;
            case '999':
            default:
                $error = 'No error code avaiable';
        }
    } else if(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == null)
    {
        $error = 'No file was uploaded..';
    }else 
    {
    	$wp_upload_dir = wp_upload_dir();

    	/* file name checking */
    	$image_name = $_FILES[$fileElementName]['name'];

    	function checking_image_name($str){
    		$check = true;

			$all_images = get_posts( 
				array( 
					'post_parent' => 0, 
					'post_type' => 'attachment', 
					'post_mime_type' => 'image',
					'posts_per_page' => -1,
				)
			);

			$args = array(
			  	'post_type' => 'template',
			  	'posts_per_page' => -1,
			);
			$query = new WP_Query($args);
			$all_templates = $query->posts;
			
			foreach ($all_images as $value) {
				$guid = $value->guid;
				$attachment_name_array = explode('/', $guid);
				$attachment_name = $attachment_name_array[count($attachment_name_array)-1];
				$attachment_name = str_replace('%20', ' ', $attachment_name);

				if( $attachment_name == $str){
					$check = false;
					break;
				}
			}

			if($check){
				foreach ($all_templates as $value) {
					$media = get_attached_media( 'image' , $value->ID );
					$guid = $media[0]->guid;
					$attachment_name_array = explode('/', $guid);
					$attachment_name = $attachment_name_array[strlen($attachment_name_array)-1];
					$attachment_name = str_replace('%20', ' ', $attachment_name);

					if( $attachment_name == $str){
						$check = false;
						break;
					}
				}
			}
			return $check;
    	}

    	$index = 1;
    	while(!(checking_image_name($image_name))){
    		$image_name_array = explode('.', $image_name);
    		$image_name = $image_name_array[0] . '_' . $index . '.' . $image_name_array[1];
    		$index++;
    	}

        move_uploaded_file($_FILES[$fileElementName]['tmp_name'], $wp_upload_dir['path'] . '/' . $image_name);
        $msg .= $wp_upload_dir['url'] . '/' . $image_name;

        // -------------------------------------------------------
        $filename = $wp_upload_dir['path'] . '/' . $image_name;
		$parent_post_id = 0;
		$filetype = wp_check_filetype( basename( $filename ), null);
		

		$attachment = array(
			'post_author' => get_current_user_id(),
			'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ),
			'post_mime_type' => $filetype['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename( $filename )),
			'post_content' => '',
			'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		set_post_thumbnail( $parent_post_id, $attach_id );

        // -------------------------------------------------------
        //for security reason, we force to remove all uploaded file
        @unlink($_FILES[$fileElementName]);     
    }       

    $a = array(
    	'success' => 1,
    	'error' => $error,
    	'msg' => $msg,
    	'attach_id' => $attach_id
    );

    $a = json_encode($a);
    echo $a;
    wp_die();
}


/*************************** image upload **********************************/
add_action('wp_ajax_upload_template_bg','upload_template_bg');
add_action('wp_ajax_nopriv_upload_template_bg','upload_template_bg');

function upload_template_bg(){
	$error = "";
    $msg = "";

    $fileElementName = 'template_bg_browse';

    if(!empty($_FILES[$fileElementName]['error']))
    {
        switch($_FILES[$fileElementName]['error'])
        {
            case '1':
                $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                break;
            case '2':
                $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                break;
            case '3':
                $error = 'The uploaded file was only partially uploaded';
                break;
            case '4':
                $error = 'No file was uploaded.';
                break;

            case '6':
                $error = 'Missing a temporary folder';
                break;
            case '7':
                $error = 'Failed to write file to disk';
                break;
            case '8':
                $error = 'File upload stopped by extension';
                break;
            case '999':
            default:
                $error = 'No error code avaiable';
        }
    } else if(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == null)
    {
        $error = 'No file was uploaded..';
    }else 
    {
    	$wp_upload_dir = wp_upload_dir();

    	/* file name checking */
    	$image_name = $_FILES[$fileElementName]['name'];

    	function checking_image_name($str){
    		$check = true;

			$all_images = get_posts( 
				array( 
					'post_parent' => 0, 
					'post_type' => 'attachment', 
					'post_mime_type' => 'image',
					'posts_per_page' => -1,
				)
			);

			$args = array(
			  	'post_type' => 'template',
			  	'posts_per_page' => -1,
			);
			$query = new WP_Query($args);
			$all_templates = $query->posts;
			
			foreach ($all_images as $value) {
				$guid = $value->guid;
				$attachment_name_array = explode('/', $guid);
				$attachment_name = $attachment_name_array[count($attachment_name_array)-1];
				$attachment_name = str_replace('%20', ' ', $attachment_name);

				if( $attachment_name == $str){
					$check = false;
					break;
				}
			}

			if($check){
				foreach ($all_templates as $value) {
					$media = get_attached_media( 'image' , $value->ID );
					$guid = $media[0]->guid;
					$attachment_name_array = explode('/', $guid);
					$attachment_name = $attachment_name_array[strlen($attachment_name_array)-1];
					$attachment_name = str_replace('%20', ' ', $attachment_name);

					if( $attachment_name == $str){
						$check = false;
						break;
					}
				}
			}
			return $check;
    	}

    	$index = 1;
    	while(!(checking_image_name($image_name))){
    		$image_name_array = explode('.', $image_name);
    		$image_name = $image_name_array[0] . '_' . $index . '.' . $image_name_array[1];
    		$index++;
    	}

        move_uploaded_file($_FILES[$fileElementName]['tmp_name'], $wp_upload_dir['path'] . '/' . $image_name);
        $msg .= $wp_upload_dir['url'] . '/' . $image_name;

        // -------------------------------------------------------
        $filename = $wp_upload_dir['path'] . '/' . $image_name;
		$parent_post_id = 0;
		$filetype = wp_check_filetype( basename( $filename ), null);
		

		$attachment = array(
			'post_author' => get_current_user_id(),
			'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ),
			'post_mime_type' => $filetype['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename( $filename )),
			'post_content' => '',
			'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		set_post_thumbnail( $parent_post_id, $attach_id );

        // -------------------------------------------------------
        //for security reason, we force to remove all uploaded file
        @unlink($_FILES[$fileElementName]);     
    }       

    $a = array(
    	'success' => 1,
    	'error' => $error,
    	'msg' => $msg,
    	'attach_id' => $attach_id
    );

    $a = json_encode($a);
    echo $a;
    wp_die();
}

/*************************** srt upload **********************************/
add_action('wp_ajax_upload_subtitle','upload_subtitle');
add_action('wp_ajax_nopriv_upload_subtitle','upload_subtitle');

function upload_subtitle(){
	$error = "";
    $msg = "";

    $fileElementName = 'subtitle_browse';

    if(!empty($_FILES[$fileElementName]['error']))
    {
        switch($_FILES[$fileElementName]['error'])
        {
            case '1':
                $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                break;
            case '2':
                $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                break;
            case '3':
                $error = 'The uploaded file was only partially uploaded';
                break;
            case '4':
                $error = 'No file was uploaded.';
                break;

            case '6':
                $error = 'Missing a temporary folder';
                break;
            case '7':
                $error = 'Failed to write file to disk';
                break;
            case '8':
                $error = 'File upload stopped by extension';
                break;
            case '999':
            default:
                $error = 'No error code avaiable';
        }
    } else if(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == null)
    {
        $error = 'No file was uploaded..';
    }else 
    {
    	$wp_upload_dir = wp_upload_dir();

    	/* file name checking */
    	$srt_name = $_FILES[$fileElementName]['name'];

    	function checking_srt_name($str){
    		$check = true;

			$all_srts = get_posts( 
				array( 
					'post_parent' => 0, 
					'post_type' => 'attachment', 
					'post_mime_type' => 'text/plain',
					'posts_per_page' => -1,
				)
			);
			
			foreach ($all_srts as $value) {
				$guid = $value->guid;
				$attachment_name_array = explode('/', $guid);
				$attachment_name = $attachment_name_array[count($attachment_name_array)-1];
				$attachment_name = str_replace('%20', ' ', $attachment_name);

				if( $attachment_name == $str){

					wp_delete_attachment( $value->ID, true );
					//$check = false;

					break;
				}
			}

			return $check;
    	}

    	$index = 1;
    	while(!(checking_srt_name($srt_name))){
    		$srt_name_array = explode('.', $srt_name);
    		$srt_name = $srt_name_array[0] . '_' . $index . '.' . $srt_name_array[1];
    		$index++;
    	}

        move_uploaded_file($_FILES[$fileElementName]['tmp_name'], $wp_upload_dir['path'] . '/' . $srt_name);
        $msg .= $wp_upload_dir['url'] . '/' . $srt_name;

        // -------------------------------------------------------
        $filename = $wp_upload_dir['path'] . '/' . $srt_name;
		$parent_post_id = 0;
		$filetype = wp_check_filetype( basename( $filename ), null);
		

		$attachment = array(
			'post_author' => get_current_user_id(),
			'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ),
			'post_mime_type' => $filetype['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename( $filename )),
			'post_content' => '',
			'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		set_post_thumbnail( $parent_post_id, $attach_id );

        // -------------------------------------------------------
        //for security reason, we force to remove all uploaded file
        @unlink($_FILES[$fileElementName]);     
    }       

    $a = array(
    	'success' => 1,
    	'error' => $error,
    	'msg' => $msg,
    	'attach_id' => $attach_id
    );

    $a = json_encode($a);
    echo $a;
    wp_die();
}

/**************************** get posts with category ***********************************/
add_action('wp_ajax_get_category_post','get_category_post');
add_action('wp_ajax_nopriv_category_post','get_category_post');

function get_category_post(){
	if(isset($_POST['term_id'])){
		$term_id = $_POST['term_id'];
		if($term_id == 0){
			//$all_posts = get_posts( array( 'orderby' => 'date', 'order' => 'DESC', 'post_type' => 'template') );
			$args = array(
				'orderby' => 'date',
				'order' => 'DESC',
			  	'post_type' => 'template',
			  	'posts_per_page' => -1,
			);
			$query = new WP_Query($args);
			$all_posts = $query->posts;

		} else {
			//$all_posts = get_posts( array( 'templatetype' => $term_id, 'orderby' => 'date', 'order' => 'DESC', 'post_type' => 'template') );
			$args = array(
				'orderby' => 'date',
				'order' => 'DESC',
		        'post_type' => 'template',
		        'posts_per_page' => -1,
		        'tax_query' => array(
		            array(
		                'taxonomy' => 'templatetype',
		                'field' => 'term_id',
		                'terms' => $term_id,
		            )
		        )
		    );
			$query = new WP_Query($args);
			$all_posts = $query->posts;
		}
	} else {
		$template_name = $_POST['template_name'];

		if($template_name == ''){
			//$all_posts = get_posts( array( 'orderby' => 'date', 'order' => 'DESC', 'post_type' => 'template') );
			$args = array(
				'orderby' => 'date',
				'order' => 'DESC',
			  	'post_type' => 'template',
			  	'posts_per_page' => -1
			);
			$query = new WP_Query($args);
			$all_posts = $query->posts;

		} else {		
			$args = array(
				'orderby' => 'date',
				'order' => 'DESC',
			  	'post_type' => 'template',
			  	'posts_per_page' => -1,
			  	's' => $template_name,
			);

			$query = new WP_Query($args);
			$all_posts = $query->posts;
		}
	}

	$result_array = array();

	foreach ($all_posts as $value) {
		$media=get_attached_media( 'image', $value->ID );
    	foreach($media as $key => $value1)
    	{
    		$guid = $value1->to_array()['guid'];	
    	}

		$result = array(
			'post_content' => $value->post_content,
			'post_title' => $value->post_title,
			'ID' => $value->ID,
			'guid' => $guid,
		);

		array_push($result_array, $result);
	}

    $a = array(
    	'success' => 1,
    	'data' => $result_array,
    );

    $a = json_encode($a);
    echo $a;
    wp_die();
}

/***********************************************************************/
add_action('wp_ajax_video_name_checking','video_name_checking');
add_action('wp_ajax_nopriv_video_name_checking','video_name_checking');

function video_name_checking(){
	$video_name = $_POST['video_name'];

	$check = true;

	$all_videos = get_posts( 
		array( 
			'post_parent' => 0, 
			'post_type' => 'attachment', 
			'post_mime_type' => 'video/mp4',
			'posts_per_page' => -1,
		)
	);

	$all_working_videos = get_posts( 
		array( 
			'orderby' => 'date', 
			'order' => 'DESC', 
			'post_type' => 'workingvideo', 
			'post_mime_type' => 'video/mp4',
			'posts_per_page' => -1,
		)
	);
	
	foreach ($all_working_videos as $value) {
		if( $value->post_name == $video_name){
			$check = false;
			break;
		}
	}

	if($check){
		foreach ($all_videos as $value) {
			if( $value->post_name == $video_name){
				$check = false;
				break;
			}
		}
	}	

    $a = array(
    	'success' => $check
    );

    $a = json_encode($a);
    echo $a;
    wp_die();
}

/*****************************************************************************/
add_action('wp_ajax_get_my_post','get_my_post');
add_action('wp_ajax_nopriv_get_my_post','get_my_post');

function get_my_post(){

	if(isset($_POST['template_id'])){
		$post_id = $_POST['template_id'];		
		$my_post = get_attached_media( 'image', $post_id );

	} else if ( isset($_POST['video_id'])){
		$post_id = $_POST['video_id'];		
		$my_post = get_post( $post_id );
	} else {
		$post_id = $_POST['image_id'];		
		$my_post = get_post( $post_id );
	}	

    $a = array(
    	'success' => 1,
    	'data' => $my_post
    );

    $a = json_encode($a);
    echo $a;
    wp_die();
}

/*******************************************************************************/
add_action('wp_ajax_get_video_post_data','get_video_post_data');
add_action('wp_ajax_nopriv_get_video_post_data','get_video_post_data');

function get_video_post_data(){

	$video_post_id = $_POST['video_post_id'];

	$video_post = get_post( $video_post_id );

	$video_post_meta = get_post_meta( $video_post_id );
	$video_template = $video_post_meta['template'];
	$video_video = $video_post_meta['video'];
	$video_image = $video_post_meta['image'];
	$video_result_video = $video_post_meta['result_video'];

    $a = array(
    	'success' => 1,
    	'video_post' => $video_post,
    	'video_template' => unserialize($video_template[0]),
    	'video_video' => unserialize($video_video[0]),
    	'video_image' => unserialize($video_image[0]),
    	'video_result_video' => $video_result_video[0],
    );

    $a = json_encode($a);
    echo $a;
    wp_die();
}

/****************************************************************************/
add_action('wp_ajax_delete_video_post','delete_video_post');
add_action('wp_ajax_nopriv_delete_video_post','delete_video_post');

function delete_video_post(){

	$post_id = $_POST['video_post_id'];
	$video_post = get_post( $post_id );
	$guid = $video_post->guid;
	$guid_array = explode('/', $guid);
	$file_path = ABSPATH . 
			$guid_array[count($guid_array)-5] . '/' . 
			$guid_array[count($guid_array)-4] . '/' .
			$guid_array[count($guid_array)-3] . '/' .
			$guid_array[count($guid_array)-2] . '/' .
			$guid_array[count($guid_array)-1];

	wp_delete_file($file_path);	
	
	wp_delete_post( $post_id, true);

    $a = array(
    	'success' => 1,
    	'post_id' => $post_id,
    );

    $a = json_encode($a);
    echo $a;
    wp_die();
}
/****************************************************************************/
add_action('wp_ajax_delete_attachment','delete_attachment');
add_action('wp_ajax_nopriv_delete_attachment','delete_attachment');

function delete_attachment(){

	$attachment_id = $_POST['attachment_id'];
	wp_delete_attachment( $attachment_id, true );

    $a = array(
    	'success' => 1,
    	'post_id' => $attachment_id,
    );

    $a = json_encode($a);
    echo $a;
    wp_die();
}

add_action('wp_ajax_template_rendering','template_rendering');
add_action('wp_ajax_nopriv_template_rendering','template_rendering');

function template_rendering(){

	$wp_upload_dir = wp_upload_dir();


	$background = $_POST['background'];
	if($background == 1){
		$background_url = $_POST['background_url'];
		$background_path = $_SERVER['DOCUMENT_ROOT'] . parse_url($background_url, PHP_URL_PATH);
	} else {
		$background_color = $_POST['background_color'];
	}

	$bg_width = $_POST['bg_width'];
	$bg_height = $_POST['bg_height'];

	$template_image_num = $_POST['template_image_num'];
	$template_image = $_POST['template_image'];

	$exec = '';
	if($background == 1){
		$exec = 'convert ' . 
			' -size ' . $bg_width . 'x' . $bg_height . ' xc:skyblue ' .
			' -draw "image over 0,0 ' . $bg_width . ',' . $bg_height . ' \'' . $background_path . '\'"';
	} else {
		$exec = 'convert ' . 
			' -size ' . $bg_width . 'x' . $bg_height . ' xc:' . $background_color;
	}

	foreach ($template_image as $value) { 
		$image_url = $value['image_url'];
		$image_path = $_SERVER['DOCUMENT_ROOT'] . parse_url($image_url, PHP_URL_PATH);
		$image_type = $value['image_type'];
		$image_h = $value['image_h'];
		$image_w = $value['image_w'];
		if($value['image_x'] != NaN){ $image_x = $value['image_x']; } else { $image_x = 0;}
		if($value['image_y'] != NaN){ $image_y = $value['image_y']; } else { $image_y = 0;}

		$exec .= ' -draw "image over ' . $image_x . ',' . $image_y . ' ' . $image_w . ',' . $image_h . ' \'' . $image_path . '\'"';
	}

	$result = $wp_upload_dir['path'] . '/tpl-' . get_current_user_id() . '-' . date("Y-m-d") . '.png';
	$result_url = $wp_upload_dir['url'] . '/tpl-' . get_current_user_id() . '-' . date("Y-m-d") . '.png';

	$exec .= ' ' . $result;
	
	echo shell_exec($exec);

	$a = array(
    	'success' => 1,
    	'result_url' => $result_url,
    );

    $a = json_encode($a);
    echo $a;
	wp_die();
}

/*****************************************************************************/
add_action('wp_ajax_rendering','rendering');
add_action('wp_ajax_nopriv_rendering','rendering');

function rendering(){

	$wp_upload_dir = wp_upload_dir();
	mkdir($wp_upload_dir['path'] . '/' . get_current_user_id(), 0777);

	$png_array_path =  $wp_upload_dir['path'] . '/' . get_current_user_id() . '/';
	$png_array_url = $wp_upload_dir['url'] . '/' . get_current_user_id() . '/';


	$template_id = $_POST['template_id'];
	$template_url = $_POST['template_url'];
	$template_H = $_POST['template_H'];
	$template_W = $_POST['template_W'];

	$ratio = 1;
	while($template_H > 1500 || $template_W > 1500){
		$template_H = $template_H / 2;
		$template_W = $template_W / 2;
		$ratio = $ratio * 2;
	}

	$video_id = $_POST['video_id'];
	$video_url = $_POST['video_url'];
	$video_h = $_POST['video_h'] / $ratio;
	$video_w = $_POST['video_w'] / $ratio;
	if($_POST['video_x'] != NaN){ $video_x = $_POST['video_x'] / $ratio; } else { $video_x = 0;}
	if($_POST['video_y'] != NaN){ $video_y = $_POST['video_y'] / $ratio; } else { $video_y = 0;}


	$image_num = $_POST['image_num'];
	$image = $_POST['image'];

	$image_input = '';
	$image_scale = '';
	$image_position = '';

	if($image_num != 0){
		$image_index = 1;
		foreach ($image as $value) {
			$image_url = $value['image_url'];
			$image_type = $value['image_type'];
			$image_h = $value['image_h'] / $ratio;
			$image_w = $value['image_w'] /$ratio;
			if($value['image_x'] != NaN){ $image_x = $value['image_x'] / $ratio; } else { $image_x = 0;}
			if($value['image_y'] != NaN){ $image_y = $value['image_y'] / $ratio; } else { $image_y = 0;}

			if($image_type == 'gif' || $image_type == 'GIF'){
				$image_path = $_SERVER['DOCUMENT_ROOT'] . parse_url($image_url, PHP_URL_PATH);

				$image_exec = 'convert ' .
							$image_path .
							' -loop 0 ' .
							' -dispose Background ' .
							$png_array_path . 'image_out_'.$image_index.'.gif';
				echo shell_exec($image_exec);

				$loop = ' -ignore_loop 0 -i ';
				$image_url = $png_array_url . 'image_out_'.$image_index.'.gif';
			} else{
				$loop = ' -loop 1 -i ';
			}

			$image_input .= $loop . $image_url;
			$image_scale .= '['.($image_index+1).':v]scale=' . round($image_w) . ':' . round($image_h) . '[over'.($image_index+2).'];';
			$image_position .= '[temp'.($image_index+1).'][over'.($image_index+2).']overlay=x=' . round($image_x) . ':y=' . round($image_y) . ':shortest=1[temp'.($image_index+2).'];';

			$image_index++;
		}
	}
	

	if($template_x < 0 ) { $template_x = 0; }
	if($template_y < 0 ) { $template_y = 0; }
	if($video_x < 0 ) { $video_x = 0; }
	if($video_y < 0 ) { $video_y = 0; }
	if($image_x < 0 ) { $image_x = 0; }
	if($image_y < 0 ) { $image_y = 0; }
	if($text_image_x < 0 ) { $text_image_x = 0; }
	if($text_image_y < 0 ) { $text_image_y = 0; }

	//$result_video_name = $_POST['result_video_name'];
	$result_video_name = 'video-' . get_current_user_id() . '-' . date("Y-m-d");

	/* png to gif */
	function base64_to_jpeg($base64_string, $output_file) {
	    $ifp = fopen( $output_file, 'wb' );
	    $data = explode( ',', $base64_string );
	    fwrite( $ifp, base64_decode( $data[ 1 ] ) );
	    fclose( $ifp );
	    return $output_file; 
	}

	$text_num = $_POST['text_num'];
	$text = $_POST['text'];

	$text_input_repeat = '';
	$text_scale_repeat = '';
	$text_position_repeat = '';

	$text_non_repeat_array = [];

	if($text_num != 0){
		$text_index = 1;
		foreach ($text as $value) {
			$png_array = $value['png_array'];
			$text_repeat = $value['text_repeat'];
			$text_image_h = $value['text_image_h'] / $ratio;
			$text_image_w = $value['text_image_w'] / $ratio;
			if($value['text_image_x'] != NaN){ $text_image_x = $value['text_image_x'] / $ratio; } else { $text_image_x = 0;}
			if($value['text_image_y'] != NaN){ $text_image_y = $value['text_image_y'] / $ratio; } else { $text_image_y = 0;}

			mkdir($png_array_path . $text_index, 0777);

			$png_array_path_temp =  $png_array_path . $text_index . '/';
			$png_array_url_temp = $png_array_url . $text_index . '/';

			$index = 100;
			foreach ($png_array as $value1) {
				$png_temp = base64_to_jpeg($value1, $png_array_path_temp . $index . '.png' );
				$index++;
			}

			// pngs to gif
			$png_exec = 'convert ' .
						' -delay 1x40 ' .
						' -loop 0 ' .
						' -dispose Background ' .
						$png_array_path_temp . '*.png ' . 
						$png_array_path_temp . 'out.gif';
			echo shell_exec($png_exec);

			if($text_repeat == 'yes'){
				$text_input_repeat .= ' -ignore_loop 0 -i ' . $png_array_url_temp . 'out.gif ';
				$text_scale_repeat .='['.($image_num+$text_index+1).':v]scale=' . round($text_image_w) . ':' . round($text_image_h) . '[over'.($image_num+$text_index+2).'];';
				$text_position_repeat .= '[temp'.($image_num+$text_index+1).'][over'.($image_num+$text_index+2).']overlay=x=' . round($text_image_x) . ':y=' . round($text_image_y) . ':shortest=1[temp'.($image_num+$text_index+2).'];';
			} else {
				$text_non_repeat = array(
					'text_path' => $png_array_path_temp . 'out.gif ',
					'text_image_h' => $text_image_h,
					'text_image_w' => $text_image_w,
					'text_image_y' => $text_image_y,
					'text_image_x' => $text_image_x
				);
				array_push($text_non_repeat_array, $text_non_repeat);
			}
			$text_index++;
			
		}
	}

	$template_W = round($template_W);
	if ($template_W % 2 != 0) {
		$template_W = $template_W - 1;
	}
	$template_H = round($template_H);
	if($template_H % 2 != 0) {
		$template_H = $template_H - 1;
	}

	function rmrf($dir) {
	    foreach (glob($dir) as $file) {
	        if (is_dir($file)) { 
	            rmrf("$file/*");
	            rmdir($file);
	        } else {
	            unlink($file);
	        }
	    }
	}
	 

	$result = $wp_upload_dir['path'] . '/' . $result_video_name . '.mp4';
	$result_url = $wp_upload_dir['url'] . '/' . $result_video_name . '.mp4';


	//start rendering

	if($image_num != 0 && $text_num != 0){
		if($text_input_repeat != '' && count($text_non_repeat_array) == 0){
			$exec = 'ffmpeg' . 
				' -i ' .  $video_url . 
				' -loop 1 -i ' . $template_url . 
				$image_input . 
				$text_input_repeat . 
				' -c:a aac -strict -2 ' .
				' -filter_complex "' . 
					'color=s=' . $template_W . 'x' . $template_H . ':c=black[base];' . 
					'[0:v]scale=' . round($video_w) . ':' . round($video_h) . '[over1];' . 
					'[1:v]scale=' . $template_W . ':' . $template_H . '[over2];' . 
					$image_scale . 
					$text_scale_repeat .
					'[base][over1]overlay=x=' . round($video_x) . ':y=' . round($video_y) . ':shortest=1[temp1];' . 
					'[temp1][over2]overlay=x=0:y=0:shortest=1[temp2];' . 
					$image_position . 
					substr($text_position_repeat, 0, -8) . '" ' .
					'-y ' . $result;
			//echo $exec;
			echo shell_exec($exec);
		} else {
			if($text_input_repeat == ''){
				$image_position = substr($image_position, 0, -8);
			} else {
				$text_position_repeat = substr($text_position_repeat, 0, -8);
			}
			
			$exec = 'ffmpeg' . 
				' -i ' .  $video_url . 
				' -loop 1 -i ' . $template_url . 
				$image_input.
				$text_input_repeat . 
				' -c:a aac -strict -2 ' .
				' -filter_complex "' . 
					'color=s=' . $template_W . 'x' . $template_H . ':c=black[base];' . 
					'[0:v]scale=' . round($video_w) . ':' . round($video_h) . '[over1];' . 
					'[1:v]scale=' . $template_W . ':' . $template_H . '[over2];' . 
					$image_scale .
					$text_scale_repeat . 
					'[base][over1]overlay=x=' . round($video_x) . ':y=' . round($video_y) . ':shortest=1[temp1];' . 
					'[temp1][over2]overlay=x=0:y=0:shortest=1[temp2];' . 
					$image_position . 
					$text_position_repeat . '"' . 
					' -y ' . $png_array_path . 'temp.mp4';
			//echo $exec;
			echo shell_exec($exec);

			$rendering_index = 1;
			foreach ($text_non_repeat_array as $text_non_repeat) {
				if($rendering_index == 1 && count($text_non_repeat_array) == 1){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $result;
					//echo $exec_final;
					echo shell_exec($exec_final);
				} else if($rendering_index == 1 && count($text_non_repeat_array) > 1){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $png_array_path . 'temp_1.mp4';
					//echo $exec_final;
					echo shell_exec($exec_final);
				} else if($rendering_index > 1 && $rendering_index < count($text_non_repeat_array)){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp_' . ($rendering_index-1) . '.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $png_array_path . 'temp_' . $rendering_index . '.mp4';
					//echo $exec_final;
					echo shell_exec($exec_final);
				} else {//if($rendering_index == count($text_non_repeat_array)){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp_' . ($rendering_index-1) . '.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $result;
					//echo $exec_final;
					echo shell_exec($exec_final);
				}

				$rendering_index++;
				
			}
		}

		$dir_path = $wp_upload_dir['path'] . '/' . get_current_user_id();

		rmrf($dir_path);

	} else if ($text_num == 0 && $image_num != 0) {
		$image_position = substr($image_position, 0, -8);
		$exec = 'ffmpeg' . 
			' -i ' .  $video_url . 
			' -loop 1 -i ' . $template_url . 
			$image_input .
			' -c:a aac -strict -2 ' .
			' -filter_complex "' . 
				'color=s=' . $template_W . 'x' . $template_H . ':c=black[base];' . 
				'[0:v]scale=' . round($video_w) . ':' . round($video_h) . '[over1];' . 
				'[1:v]scale=' . $template_W . ':' . $template_H . '[over2];' . 
				$image_scale . 
				'[base][over1]overlay=x=' . round($video_x) . ':y=' . round($video_y) . ':shortest=1[temp1];' . 
				'[temp1][over2]overlay=x=0:y=0:shortest=1[temp2];' . 
				$image_position . '"' .
				' -y ' . $result;

		echo shell_exec($exec);
		//echo $exec;

		$dir_path = $wp_upload_dir['path'] . '/' . get_current_user_id();

		rmrf($dir_path);

	} else if( $text_num != 0 && $image_num == 0 ){
		if($text_input_repeat != '' && count($text_non_repeat_array) == 0){
			$exec = 'ffmpeg' . 
				' -i ' .  $video_url . 
				' -loop 1 -i ' . $template_url . 
				$text_input_repeat . 
				' -c:a aac -strict -2 ' .
				' -filter_complex "' . 
					'color=s=' . $template_W . 'x' . $template_H . ':c=black[base];' . 
					'[0:v]scale=' . round($video_w) . ':' . round($video_h) . '[over1];' . 
					'[1:v]scale=' . $template_W . ':' . $template_H . '[over2];' .
					$text_scale_repeat .
					'[base][over1]overlay=x=' . round($video_x) . ':y=' . round($video_y) . ':shortest=1[temp1];' . 
					'[temp1][over2]overlay=x=0:y=0:shortest=1[temp2];' .  
					substr($text_position_repeat, 0, -8) . '" ' .
					'-y ' . $result;
			//echo $exec;
			echo shell_exec($exec);
		} else {
			if($text_input_repeat == ''){
				$pre_temp = '[temp1][over2]overlay=x=0:y=0:shortest=1';
			} else {
				$pre_temp = '[temp1][over2]overlay=x=0:y=0:shortest=1[temp2];';
				$text_position_repeat = substr($text_position_repeat, 0, -8);
			}
			
			$exec = 'ffmpeg' . 
				' -i ' .  $video_url . 
				' -loop 1 -i ' . $template_url . 
				$text_input_repeat . 
				' -c:a aac -strict -2 ' .
				' -filter_complex "' . 
					'color=s=' . $template_W . 'x' . $template_H . ':c=black[base];' . 
					'[0:v]scale=' . round($video_w) . ':' . round($video_h) . '[over1];' . 
					'[1:v]scale=' . $template_W . ':' . $template_H . '[over2];' .
					$text_scale_repeat . 
					'[base][over1]overlay=x=' . round($video_x) . ':y=' . round($video_y) . ':shortest=1[temp1];' . 
					$pre_temp .
					$text_position_repeat . '"' . 
					' -y ' . $png_array_path . 'temp.mp4';
			//echo $exec;
			echo shell_exec($exec);

			$rendering_index = 1;
			foreach ($text_non_repeat_array as $text_non_repeat) {
				if($rendering_index == 1 && count($text_non_repeat_array) == 1){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $result;
					echo shell_exec($exec_final);
				} else if($rendering_index == 1 && count($text_non_repeat_array) > 1){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $png_array_path . 'temp_1.mp4';
					echo shell_exec($exec_final);
				} else if($rendering_index > 1 && $rendering_index < count($text_non_repeat_array)){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp_' . ($rendering_index-1) . '.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $png_array_path . 'temp_' . $rendering_index . '.mp4';
					echo shell_exec($exec_final);
				} else {//if($rendering_index == count($text_non_repeat_array)){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp_' . ($rendering_index-1) . '.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $result;
					echo shell_exec($exec_final);
				}

				$rendering_index++;
				
			}
		}

		$dir_path = $wp_upload_dir['path'] . '/' . get_current_user_id();

		rmrf($dir_path);

	} else {
		$exec = 'ffmpeg' . 
			' -i ' .  $video_url . 
			' -loop 1 -i ' . $template_url .
			' -c:a aac -strict -2 ' .
			' -filter_complex "' . 
				'color=s=' . $template_W . 'x' . $template_H . ':c=black[base];' . 
				'[0:v]scale=' . round($video_w) . ':' . round($video_h) . '[over1];' . 
				'[1:v]scale=' . $template_W . ':' . $template_H . '[over2];' . 
				'[base][over1]overlay=x=' . round($video_x) . ':y=' . round($video_y) . ':shortest=1[temp1];' . 
				'[temp1][over2]overlay=x=0:y=0:shortest=1" ' . 
				' -y ' . $result;

		echo shell_exec($exec);

		$dir_path = $wp_upload_dir['path'] . '/' . get_current_user_id();

		rmrf($dir_path);
	}

	// insert post into table
	// $project_post = array(
	// 	'post_title' => $result_video_name,
	// 	'post_author'  => get_current_user_id(),
	// 	'post_content' => $result_url,
	// 	'guid' => $result_url,
	// 	'post_status' => 'publish',
	// 	'post_type' => 'workingvideo',
	// 	'post_mime_type' => 'video/mp4',
	// 	'meta_input' => array(
	// 		'template' => array(
	// 			'template_id' => $template_id,
	// 			'template_width' => $template_W,
	// 			'template_height' => $template_H,
	// 		),
	// 		'video' => array(
	// 			'video_id' => $video_id,
	// 			'video_url' => $video_url,
	// 			'video_width' => $video_w,
	// 			'video_height' => $video_h,
	// 			'video_x' => $video_x,
	// 			'video_y' => $video_y,
	// 		),
	// 		'image' => array(
	// 			'image_num' => $image_num,
	// 			'image' => $image,
	// 		),
	// 		'text' => array(
	// 			'text_num' => $text_num,
	// 			'text' => $text,
	// 		),
	// 		'result_video' => $result_url,
	// 	),
	// );
	
	// $post_id = wp_insert_post( $project_post );

    $a = array(
    	'success' => 1,
    	//'post_id' => $post_id,
    	'result_video' => $result_url,
    	'result_video_path' => $result
    );

    $a = json_encode($a);
    echo $a;
    wp_die();
}


/*****************************************************************************/
add_action('wp_ajax_rendering_1','rendering_1');
add_action('wp_ajax_nopriv_rendering_1','rendering_1');

function rendering_1(){

	$wp_upload_dir = wp_upload_dir();
	mkdir($wp_upload_dir['path'] . '/' . get_current_user_id(), 0777);

	$png_array_path =  $wp_upload_dir['path'] . '/' . get_current_user_id() . '/';
	$png_array_url = $wp_upload_dir['url'] . '/' . get_current_user_id() . '/';


	$template_id = $_POST['template_id'];
	$template_url = $_POST['template_url'];
	$template_H = $_POST['template_H'];
	$template_W = $_POST['template_W'];

	$ratio = 1;
	while($template_H > 1500 || $template_W > 1500){
		$template_H = $template_H / 2;
		$template_W = $template_W / 2;
		$ratio = $ratio * 2;
	}

	$video_id = $_POST['video_id'];
	$video_url = $_POST['video_url'];
	$video_h = $_POST['video_h'] / $ratio;
	$video_w = $_POST['video_w'] / $ratio;
	if($_POST['video_x'] != NaN){ $video_x = $_POST['video_x'] / $ratio; } else { $video_x = 0;}
	if($_POST['video_y'] != NaN){ $video_y = $_POST['video_y'] / $ratio; } else { $video_y = 0;}


	$image_num = $_POST['image_num'];
	$image = $_POST['image'];

	$image_input = '';
	$image_scale = '';
	$image_position = '';

	if($image_num != 0){
		$image_index = 1;
		foreach ($image as $value) {
			$image_url = $value['image_url'];
			$image_type = $value['image_type'];
			$image_h = $value['image_h'] / $ratio;
			$image_w = $value['image_w'] /$ratio;
			if($value['image_x'] != NaN){ $image_x = $value['image_x'] / $ratio; } else { $image_x = 0;}
			if($value['image_y'] != NaN){ $image_y = $value['image_y'] / $ratio; } else { $image_y = 0;}

			if($image_type == 'gif' || $image_type == 'GIF'){
				$image_path = $_SERVER['DOCUMENT_ROOT'] . parse_url($image_url, PHP_URL_PATH);

				$image_exec = 'convert ' .
							$image_path .
							' -loop 0 ' .
							' -dispose Background ' .
							$png_array_path . 'image_out_'.$image_index.'.gif';
				echo shell_exec($image_exec);

				$loop = ' -ignore_loop 0 -i ';
				$image_url = $png_array_url . 'image_out_'.$image_index.'.gif';
			} else{
				$loop = ' -loop 1 -i ';
			}

			$image_input .= $loop . $image_url;
			$image_scale .= '['.($image_index+1).':v]scale=' . round($image_w) . ':' . round($image_h) . '[over'.($image_index+2).'];';
			$image_position .= '[temp'.($image_index+1).'][over'.($image_index+2).']overlay=x=' . round($image_x) . ':y=' . round($image_y) . ':shortest=1[temp'.($image_index+2).'];';

			$image_index++;
		}
	}
	

	if($template_x < 0 ) { $template_x = 0; }
	if($template_y < 0 ) { $template_y = 0; }
	if($video_x < 0 ) { $video_x = 0; }
	if($video_y < 0 ) { $video_y = 0; }
	if($image_x < 0 ) { $image_x = 0; }
	if($image_y < 0 ) { $image_y = 0; }
	if($text_image_x < 0 ) { $text_image_x = 0; }
	if($text_image_y < 0 ) { $text_image_y = 0; }

	//$result_video_name = $_POST['result_video_name'];
	$result_video_name = 'video-' . get_current_user_id() . '-' . date("Y-m-d");
	/* png to gif */
	function base64_to_jpeg($base64_string, $output_file) {
	    $ifp = fopen( $output_file, 'wb' );
	    $data = explode( ',', $base64_string );
	    fwrite( $ifp, base64_decode( $data[ 1 ] ) );
	    fclose( $ifp );
	    return $output_file; 
	}

	$text_num = $_POST['text_num'];
	$text = $_POST['text'];

	$text_input_repeat = '';
	$text_scale_repeat = '';
	$text_position_repeat = '';

	$text_non_repeat_array = [];

	if($text_num != 0){
		$text_index = 1;
		foreach ($text as $value) {
			$png_array = $value['png_array'];
			$text_repeat = $value['text_repeat'];
			$text_image_h = $value['text_image_h'] / $ratio;
			$text_image_w = $value['text_image_w'] / $ratio;
			if($value['text_image_x'] != NaN){ $text_image_x = $value['text_image_x'] / $ratio; } else { $text_image_x = 0;}
			if($value['text_image_y'] != NaN){ $text_image_y = $value['text_image_y'] / $ratio; } else { $text_image_y = 0;}

			mkdir($png_array_path . $text_index, 0777);

			$png_array_path_temp =  $png_array_path . $text_index . '/';
			$png_array_url_temp = $png_array_url . $text_index . '/';

			$index = 100;
			foreach ($png_array as $value1) {
				$png_temp = base64_to_jpeg($value1, $png_array_path_temp . $index . '.png' );
				$index++;
			}

			// pngs to gif
			$png_exec = 'convert ' .
						' -delay 1x40 ' .
						' -loop 0 ' .
						' -dispose Background ' .
						$png_array_path_temp . '*.png ' . 
						$png_array_path_temp . 'out.gif';
			echo shell_exec($png_exec);

			if($text_repeat == 'yes'){
				$text_input_repeat .= ' -ignore_loop 0 -i ' . $png_array_url_temp . 'out.gif ';
				$text_scale_repeat .='['.($image_num+$text_index+1).':v]scale=' . round($text_image_w) . ':' . round($text_image_h) . '[over'.($image_num+$text_index+2).'];';
				$text_position_repeat .= '[temp'.($image_num+$text_index+1).'][over'.($image_num+$text_index+2).']overlay=x=' . round($text_image_x) . ':y=' . round($text_image_y) . ':shortest=1[temp'.($image_num+$text_index+2).'];';
			} else {
				$text_non_repeat = array(
					'text_path' => $png_array_path_temp . 'out.gif ',
					'text_image_h' => $text_image_h,
					'text_image_w' => $text_image_w,
					'text_image_y' => $text_image_y,
					'text_image_x' => $text_image_x
				);
				array_push($text_non_repeat_array, $text_non_repeat);
			}
			$text_index++;
			
		}
	}

	$template_W = round($template_W);
	if ($template_W % 2 != 0) {
		$template_W = $template_W - 1;
	}
	$template_H = round($template_H);
	if($template_H % 2 != 0) {
		$template_H = $template_H - 1;
	}

	function rmrf($dir) {
	    foreach (glob($dir) as $file) {
	        if (is_dir($file)) { 
	            rmrf("$file/*");
	            rmdir($file);
	        } else {
	            unlink($file);
	        }
	    }
	}
	 

	$result = $wp_upload_dir['path'] . '/' . $result_video_name . '.mp4';
	$result_url = $wp_upload_dir['url'] . '/' . $result_video_name . '.mp4';


	//start rendering

	if($image_num != 0 && $text_num != 0){
		if($text_input_repeat != '' && count($text_non_repeat_array) == 0){
			$exec = 'ffmpeg' . 				 
				' -loop 1 -i ' . $template_url . 
				' -i ' .  $video_url .
				$image_input . 
				$text_input_repeat . 
				' -c:a aac -strict -2 ' .
				' -filter_complex "' . 
					'color=s=' . $template_W . 'x' . $template_H . ':c=black[base];' . 
					'[0:v]scale=' . $template_W . ':' . $template_H . '[over1];' .
					'[1:v]scale=' . round($video_w) . ':' . round($video_h) . '[over2];' . 					 
					$image_scale . 
					$text_scale_repeat .
					'[base][over1]overlay=x=0:y=0:shortest=1[temp1];' .
					'[temp1][over2]overlay=x=' . round($video_x) . ':y=' . round($video_y) . ':shortest=1[temp2];' . 					 
					$image_position . 
					substr($text_position_repeat, 0, -8) . '" ' .
					'-y ' . $result;
			//echo $exec;
			echo shell_exec($exec);
		} else {
			if($text_input_repeat == ''){
				$image_position = substr($image_position, 0, -8);
			} else {
				$text_position_repeat = substr($text_position_repeat, 0, -8);
			}
			
			$exec = 'ffmpeg' . 
				' -loop 1 -i ' . $template_url .
				' -i ' .  $video_url . 				 
				$image_input.
				$text_input_repeat . 
				' -c:a aac -strict -2 ' .
				' -filter_complex "' . 
					'color=s=' . $template_W . 'x' . $template_H . ':c=black[base];' . 
					'[0:v]scale=' . $template_W . ':' . $template_H . '[over1];' . 
					'[1:v]scale=' . round($video_w) . ':' . round($video_h) . '[over2];' . 					
					$image_scale .
					$text_scale_repeat . 
					'[base][over1]overlay=x=0:y=0:shortest=1[temp1];' . 
					'[temp1][over2]overlay=x=' . round($video_x) . ':y=' . round($video_y) . ':shortest=1[temp2];' . 					
					$image_position . 
					$text_position_repeat . '"' . 
					' -y ' . $png_array_path . 'temp.mp4';
			//echo $exec;
			echo shell_exec($exec);

			$rendering_index = 1;
			foreach ($text_non_repeat_array as $text_non_repeat) {
				if($rendering_index == 1 && count($text_non_repeat_array) == 1){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $result;
					//echo $exec_final;
					echo shell_exec($exec_final);
				} else if($rendering_index == 1 && count($text_non_repeat_array) > 1){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $png_array_path . 'temp_1.mp4';
					//echo $exec_final;
					echo shell_exec($exec_final);
				} else if($rendering_index > 1 && $rendering_index < count($text_non_repeat_array)){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp_' . ($rendering_index-1) . '.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $png_array_path . 'temp_' . $rendering_index . '.mp4';
					//echo $exec_final;
					echo shell_exec($exec_final);
				} else {//if($rendering_index == count($text_non_repeat_array)){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp_' . ($rendering_index-1) . '.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $result;
					//echo $exec_final;
					echo shell_exec($exec_final);
				}

				$rendering_index++;
				
			}
		}

		$dir_path = $wp_upload_dir['path'] . '/' . get_current_user_id();

		rmrf($dir_path);

	} else if ($text_num == 0 && $image_num != 0) {
		$image_position = substr($image_position, 0, -8);
		$exec = 'ffmpeg' . 			 
			' -loop 1 -i ' . $template_url . 
			' -i ' .  $video_url .
			$image_input .
			' -c:a aac -strict -2 ' .
			' -filter_complex "' . 
				'color=s=' . $template_W . 'x' . $template_H . ':c=black[base];' . 
				'[0:v]scale=' . $template_W . ':' . $template_H . '[over1];' .
				'[1:v]scale=' . round($video_w) . ':' . round($video_h) . '[over2];' . 				 
				$image_scale . 				 
				'[base][over1]overlay=x=0:y=0:shortest=1[temp1];' . 
				'[temp1][over2]overlay=x=' . round($video_x) . ':y=' . round($video_y) . ':shortest=1[temp2];' .
				$image_position . '"' .
				' -y ' . $result;

		echo shell_exec($exec);
		//echo $exec;

		$dir_path = $wp_upload_dir['path'] . '/' . get_current_user_id();

		rmrf($dir_path);

	} else if( $text_num != 0 && $image_num == 0 ){
		if($text_input_repeat != '' && count($text_non_repeat_array) == 0){
			$exec = 'ffmpeg' . 				
				' -loop 1 -i ' . $template_url . 
				' -i ' .  $video_url . 
				$text_input_repeat . 
				' -c:a aac -strict -2 ' .
				' -filter_complex "' . 
					'color=s=' . $template_W . 'x' . $template_H . ':c=black[base];' . 
					'[0:v]scale=' . $template_W . ':' . $template_H . '[over1];' .
					'[1:v]scale=' . round($video_w) . ':' . round($video_h) . '[over2];' .					
					$text_scale_repeat .					 
					'[base][over1]overlay=x=0:y=0:shortest=1[temp1];' . 
					'[temp1][over2]overlay=x=' . round($video_x) . ':y=' . round($video_y) . ':shortest=1[temp2];' . 
					substr($text_position_repeat, 0, -8) . '" ' .
					'-y ' . $result;
			//echo $exec;
			echo shell_exec($exec);
		} else {
			if($text_input_repeat == ''){
				$pre_temp = '[temp1][over2]overlay=x=' . round($video_x) . ':y=' . round($video_y) . ':shortest=1';
			} else {
				$pre_temp = '[temp1][over2]overlay=x=' . round($video_x) . ':y=' . round($video_y) . ':shortest=1[temp2];';
				$text_position_repeat = substr($text_position_repeat, 0, -8);
			}
			
			$exec = 'ffmpeg' . 				 
				' -loop 1 -i ' . $template_url . 
				' -i ' .  $video_url .
				$text_input_repeat . 
				' -c:a aac -strict -2 ' .
				' -filter_complex "' . 
					'color=s=' . $template_W . 'x' . $template_H . ':c=black[base];' . 
					'[0:v]scale=' . $template_W . ':' . $template_H . '[over1];' .
					'[1:v]scale=' . round($video_w) . ':' . round($video_h) . '[over2];' . 					
					$text_scale_repeat . 
					'[base][over1]overlay=x=0:y=0:shortest=1[temp1];' . 
					$pre_temp .
					$text_position_repeat . '"' . 
					' -y ' . $png_array_path . 'temp.mp4';
			//echo $exec;
			echo shell_exec($exec);

			$rendering_index = 1;
			foreach ($text_non_repeat_array as $text_non_repeat) {
				if($rendering_index == 1 && count($text_non_repeat_array) == 1){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $result;
					echo shell_exec($exec_final);
				} else if($rendering_index == 1 && count($text_non_repeat_array) > 1){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $png_array_path . 'temp_1.mp4';
					echo shell_exec($exec_final);
				} else if($rendering_index > 1 && $rendering_index < count($text_non_repeat_array)){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp_' . ($rendering_index-1) . '.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $png_array_path . 'temp_' . $rendering_index . '.mp4';
					echo shell_exec($exec_final);
				} else {//if($rendering_index == count($text_non_repeat_array)){
					$exec_final = 'ffmpeg '.
						' -i ' . $png_array_url . 'temp_' . ($rendering_index-1) . '.mp4 ' . 
						' -vf "movie=' . $text_non_repeat['text_path'] . ' [watermark]; [watermark]scale=' . round($text_non_repeat['text_image_w']) . ':' . round($text_non_repeat['text_image_h']) . ' [scale]; [in][scale]overlay=' . round($text_non_repeat['text_image_x']) . ':' . round($text_non_repeat['text_image_y']) . ' [out]" ' . 
						' -y ' . $result;
					echo shell_exec($exec_final);
				}

				$rendering_index++;
				
			}
		}

		$dir_path = $wp_upload_dir['path'] . '/' . get_current_user_id();

		rmrf($dir_path);

	} else {
		$exec = 'ffmpeg' . 			 
			' -loop 1 -i ' . $template_url .
			' -i ' .  $video_url .
			' -c:a aac -strict -2 ' .
			' -filter_complex "' . 
				'color=s=' . $template_W . 'x' . $template_H . ':c=black[base];' . 				 
				'[0:v]scale=' . $template_W . ':' . $template_H . '[over1];' . 
				'[1:v]scale=' . round($video_w) . ':' . round($video_h) . '[over2];' .
				'[base][over1]overlay=x=0:y=0:shortest=1[temp1];' . 
				'[temp1][over2]overlay=x=' . round($video_x) . ':y=' . round($video_y) . ':shortest=1" ' . 
				
				' -y ' . $result;

		echo shell_exec($exec);

		$dir_path = $wp_upload_dir['path'] . '/' . get_current_user_id();

		rmrf($dir_path);
	}

	//insert post into table
	// $project_post = array(
	// 	'post_title' => $result_video_name,
	// 	'post_author'  => get_current_user_id(),
	// 	'post_content' => $result_url,
	// 	'guid' => $result_url,
	// 	'post_status' => 'publish',
	// 	'post_type' => 'workingvideo',
	// 	'post_mime_type' => 'video/mp4',
	// 	'meta_input' => array(
	// 		'template' => array(
	// 			'template_id' => $template_id,
	// 			'template_width' => $template_W,
	// 			'template_height' => $template_H,
	// 		),
	// 		'video' => array(
	// 			'video_id' => $video_id,
	// 			'video_url' => $video_url,
	// 			'video_width' => $video_w,
	// 			'video_height' => $video_h,
	// 			'video_x' => $video_x,
	// 			'video_y' => $video_y,
	// 		),
	// 		'image' => array(
	// 			'image_num' => $image_num,
	// 			'image' => $image,
	// 		),
	// 		'text' => array(
	// 			'text_num' => $text_num,
	// 			'text' => $text,
	// 		),
	// 		'result_video' => $result_url,
	// 	),
	// );
	
	//$post_id = wp_insert_post( $project_post );

    $a = array(
    	'success' => 1,
    	//'post_id' => $post_id,
    	'result_video' => $result_url,
    	'result_video_path' => $result
    );

    $a = json_encode($a);
    echo $a;
    wp_die();
}

/*****************************************************************************/
add_action('wp_ajax_final_rendering','final_rendering');
add_action('wp_ajax_nopriv_final_rendering','final_rendering');

function final_rendering(){

	$wp_upload_dir = wp_upload_dir();

	$video_url = $_POST['video_url'];
	$result_video_name = $_POST['result_video_name'];

	$video_path = $_SERVER['DOCUMENT_ROOT'] . parse_url($video_url, PHP_URL_PATH);

	$result_path = $wp_upload_dir['path'] . '/' . $result_video_name . '.mp4';
	$result_url = $wp_upload_dir['url'] . '/' . $result_video_name . '.mp4';

	$subtitle = $_POST['subtitle'];

	$subtitle_url = '';
	$subtitle_content = '';

	$check = true;

	if($subtitle == 1){
		$subtitle_url = $_POST['subtitle_url'];
		$subtitle_path = $_SERVER['DOCUMENT_ROOT'] . parse_url($subtitle_url, PHP_URL_PATH);
		if($subtitle_url == ''  ){
			rename($video_path, $result_path);
			$check = false;
		}
	} else {
		$subtitle_content = $_POST['subtitle_content'];

		if($subtitle_content == ''){
			rename($video_path, $result_path);
			$check = false;
		} else {
			$srt_file_name = 'srt-' . get_current_user_id() . '-' . date("Y-m-d") . '.srt';
			$srt_file_path = $wp_upload_dir['path'] . '/' . $srt_file_name;

			$myfile = fopen($srt_file_path, "w") or die("Unable to open file!");
			fwrite($myfile, $subtitle_content);
			fclose($myfile);

			$subtitle_path = $srt_file_path;
		}
	}
	
	if($check){
		$exec = 'ffmpeg -i ' . $video_url . ' -vf subtitles=' . $subtitle_path . ' ' . $result_path;
		//echo $exec;
		echo shell_exec($exec);
		//unlink($video_path);

		// if($subtitle == 0 && $subtitle_content != ''){
		// 	unlink($subtitle_path);
		// }
	}

	// insert post into table
	$project_post = array(
		'post_title' => $result_video_name,
		'post_author'  => get_current_user_id(),
		'post_content' => $result_url,
		'guid' => $result_url,
		'post_status' => 'publish',
		'post_type' => 'workingvideo',
		'post_mime_type' => 'video/mp4',
	);
	
	$post_id = wp_insert_post( $project_post );

    $a = array(
    	'success' => 1,
    	'post_id' => $post_id,
    	'result_video' => $result_url
    );

    $a = json_encode($a);
    echo $a;
    wp_die();
}
// ****************************************************************************

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function sydney_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'sydney' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	//Footer widget areas
	$widget_areas = get_theme_mod('footer_widget_areas', '3');
	for ($i=1; $i<=$widget_areas; $i++) {
		register_sidebar( array(
			'name'          => __( 'Footer ', 'sydney' ) . $i,
			'id'            => 'footer-' . $i,
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

	//Register the front page widgets
	if ( defined( 'SITEORIGIN_PANELS_VERSION' ) ) {
		register_widget( 'Sydney_List' );
		register_widget( 'Sydney_Services_Type_A' );
		register_widget( 'Sydney_Services_Type_B' );
		register_widget( 'Sydney_Facts' );
		register_widget( 'Sydney_Clients' );
		register_widget( 'Sydney_Testimonials' );
		register_widget( 'Sydney_Skills' );
		register_widget( 'Sydney_Action' );
		register_widget( 'Sydney_Video_Widget' );
		register_widget( 'Sydney_Social_Profile' );
		register_widget( 'Sydney_Employees' );
		register_widget( 'Sydney_Latest_News' );
		register_widget( 'Sydney_Contact_Info' );
		register_widget( 'Sydney_Portfolio' );
	}

}
add_action( 'widgets_init', 'sydney_widgets_init' );

/**
 * Load the front page widgets.
 */
if ( defined( 'SITEORIGIN_PANELS_VERSION' ) ) {
	require get_template_directory() . "/widgets/fp-list.php";
	require get_template_directory() . "/widgets/fp-services-type-a.php";
	require get_template_directory() . "/widgets/fp-services-type-b.php";
	require get_template_directory() . "/widgets/fp-facts.php";
	require get_template_directory() . "/widgets/fp-clients.php";
	require get_template_directory() . "/widgets/fp-testimonials.php";
	require get_template_directory() . "/widgets/fp-skills.php";
	require get_template_directory() . "/widgets/fp-call-to-action.php";
	require get_template_directory() . "/widgets/video-widget.php";
	require get_template_directory() . "/widgets/fp-social.php";
	require get_template_directory() . "/widgets/fp-employees.php";
	require get_template_directory() . "/widgets/fp-latest-news.php";
	require get_template_directory() . "/widgets/fp-portfolio.php";
	require get_template_directory() . "/widgets/contact-info.php";
}

/**
 * Enqueue scripts and styles.
 */
function sydney_scripts() {

	wp_enqueue_style( 'sydney-fonts', esc_url( sydney_google_fonts() ), array(), null );

	wp_enqueue_style( 'sydney-style', get_stylesheet_uri(), '', '20170504' );

	wp_enqueue_style( 'sydney-font-awesome', get_template_directory_uri() . '/fonts/font-awesome.min.css' );

	wp_enqueue_style( 'sydney-ie9', get_template_directory_uri() . '/css/ie9.css', array( 'sydney-style' ) );
	wp_style_add_data( 'sydney-ie9', 'conditional', 'lte IE 9' );

	wp_enqueue_script( 'sydney-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'),'', true );

	wp_enqueue_script( 'sydney-main', get_template_directory_uri() . '/js/main.min.js', array('jquery'),'20170504', true );

	wp_enqueue_script( 'sydney-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( get_theme_mod('blog_layout') == 'masonry-layout' && (is_home() || is_archive()) ) {

		wp_enqueue_script( 'sydney-masonry-init', get_template_directory_uri() . '/js/masonry-init.js', array('masonry'),'', true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sydney_scripts' );

/**
 * Fonts
 */
if ( !function_exists('sydney_google_fonts') ) :
function sydney_google_fonts() {
	$body_font 		= get_theme_mod('body_font_name', 'Source+Sans+Pro:400,400italic,600');
	$headings_font 	= get_theme_mod('headings_font_name', 'Raleway:400,500,600');

	$fonts     		= array();
	$fonts[] 		= esc_attr( str_replace( '+', ' ', $body_font ) );
	$fonts[] 		= esc_attr( str_replace( '+', ' ', $headings_font ) );

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) )
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;	
}
endif;

/**
 * Enqueue Bootstrap
 */
function sydney_enqueue_bootstrap() {
	wp_enqueue_style( 'sydney-bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css', array(), true );
}
add_action( 'wp_enqueue_scripts', 'sydney_enqueue_bootstrap', 9 );

/**
 * Change the excerpt length
 */
function sydney_excerpt_length( $length ) {

  $excerpt = get_theme_mod('exc_lenght', '55');
  return $excerpt;

}
add_filter( 'excerpt_length', 'sydney_excerpt_length', 999 );

/**
 * Blog layout
 */
function sydney_blog_layout() {
	$layout = get_theme_mod('blog_layout','classic');
	return $layout;
}

/**
 * Menu fallback
 */
function sydney_menu_fallback() {
	if ( current_user_can('edit_theme_options') ) {
		echo '<a class="menu-fallback" href="' . admin_url('nav-menus.php') . '">' . __( 'Create your menu here', 'sydney' ) . '</a>';
	}
}

/**
 * Header image overlay
 */
function sydney_header_overlay() {
	$overlay = get_theme_mod( 'hide_overlay', 0);
	if ( !$overlay ) {
		echo '<div class="overlay"></div>';
	}
}

/**
 * Header video
 */
function sydney_header_video() {

	if ( !function_exists('the_custom_header_markup') ) {
		return;
	}

	$front_header_type 	= get_theme_mod( 'front_header_type' );
	$site_header_type 	= get_theme_mod( 'site_header_type' );

	if ( ( get_theme_mod('front_header_type') == 'core-video' && is_front_page() || get_theme_mod('site_header_type') == 'core-video' && !is_front_page() ) ) {
		the_custom_header_markup();
	}
}

/**
 * Polylang compatibility
 */
if ( function_exists('pll_register_string') ) :
function sydney_polylang() {
	for ( $i=1; $i<=5; $i++) {
		pll_register_string('Slide title ' . $i, get_theme_mod('slider_title_' . $i), 'Sydney');
		pll_register_string('Slide subtitle ' . $i, get_theme_mod('slider_subtitle_' . $i), 'Sydney');
	}
	pll_register_string('Slider button text', get_theme_mod('slider_button_text'), 'Sydney');
	pll_register_string('Slider button URL', get_theme_mod('slider_button_url'), 'Sydney');
}
add_action( 'admin_init', 'sydney_polylang' );
endif;

/**
 * Preloader
 */
function sydney_preloader() {
	?>
	<div class="preloader">
	    <div class="spinner">
	        <div class="pre-bounce1"></div>
	        <div class="pre-bounce2"></div>
	    </div>
	</div>
	<?php
}
add_action('sydney_before_site', 'sydney_preloader');

/**
 * Header clone
 */
function sydney_header_clone() {

	$front_header_type 	= get_theme_mod('front_header_type','slider');
	$site_header_type 	=get_theme_mod('site_header_type');

	if ( ( $front_header_type == 'nothing' && is_front_page() ) || ( $site_header_type == 'nothing' && !is_front_page() ) ) { ?>
	
	<div class="header-clone"></div>

	<?php }
}
add_action('sydney_before_header', 'sydney_header_clone');

/**
 * Get image alt
 */
function sydney_get_image_alt( $image ) {
    global $wpdb;

    if( empty( $image ) ) {
        return false;
    }

    $attachment  = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE guid='%s';", strtolower( $image ) ) );
    $id   = ( ! empty( $attachment ) ) ? $attachment[0] : 0;

    $alt = get_post_meta( $id, '_wp_attachment_image_alt', true );

    return $alt;
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Page builder support
 */
require get_template_directory() . '/inc/page-builder.php';

/**
 * Slider
 */
require get_template_directory() . '/inc/slider.php';

/**
 * Styles
 */
require get_template_directory() . '/inc/styles.php';

/**
 * Theme info
 */
require get_template_directory() . '/inc/theme-info.php';

/**
 * Woocommerce basic integration
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Upsell
 */
require get_template_directory() . '/inc/upsell/class-customize.php';

/**
 * Demo content
 */
require_once dirname( __FILE__ ) . '/demo-content/setup.php';

/**
 *TGM Plugin activation.
 */
require_once dirname( __FILE__ ) . '/plugins/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'sydney_recommend_plugin' );
function sydney_recommend_plugin() {

    $plugins[] = array(
            'name'               => 'Page Builder by SiteOrigin',
            'slug'               => 'siteorigin-panels',
            'required'           => false,
    );

	if ( !function_exists('wpcf_init') ) {
	    $plugins[] = array(
		        'name'               => 'Sydney Toolbox - custom posts and fields for the Sydney theme',
		        'slug'               => 'sydney-toolbox',
		        'required'           => false,
		);
	}

    tgmpa( $plugins);

}

/**
 * Admin notice
 */
require get_template_directory() . '/inc/notices/persist-admin-notices-dismissal.php';

function sydney_welcome_admin_notice() {
	if ( ! PAnD::is_admin_notice_active( 'sydney-welcome-forever' ) ) {
		return;
	}
	
	?>
	<div data-dismissible="sydney-welcome-forever" class="sydney-admin-notice updated notice notice-success is-dismissible">

		<p><?php echo sprintf( __( 'Welcome to Our Video Editor. To get started please make sure to visit our <a href="%s">welcome page</a>.', 'sydney' ), admin_url( 'themes.php?page=sydney-info.php' ) ); ?></p>
		<a class="button" href="<?php echo admin_url( 'themes.php?page=sydney-info.php' ); ?>"><?php esc_html_e( 'Get started with our Editor', 'sydney' ); ?></a>

	</div>
	<?php
}
add_action( 'admin_init', array( 'PAnD', 'init' ) );
add_action( 'admin_notices', 'sydney_welcome_admin_notice' );


add_filter( 'wp_nav_menu_items', 'add_login_item', 10, 2 );

function add_login_item( $items, $args ) {

    if( $args->theme_location == 'primary' ){

    	if( is_user_logged_in() ){
    		$items .= '<li class="menu-item">'
               			. '<a href="' . home_url() . '/video-edit">My Videos</a>'
               		. '</li>'.
               		  '<li class="menu-item">'
               			. '<a href="' . home_url() . '/video-template">Create</a>'
               		. '</li>'.
               		  '<li class="menu-item">'
               			. '<a href="' . home_url() . '/logout">Logout</a>'
               		. '</li>';
       	} else {
       		$items .= '<li class="menu-item">'
               			. '<a href="' . home_url() . '/login">Login</a>'
               		. '</li>'
               		. '<li class="menu-item">'
               			. '<a href="' . home_url() . '/register">Register</a>'
               		. '</li>';
       	}
        
    }

    return $items;
}


add_action( 'init', 'custom_blockusers_init' );

function custom_blockusers_init() {
  if ( is_user_logged_in() && is_admin() && !current_user_can( 'administrator' ) && !defined('DOING_AJAX') ) {
    wp_redirect( home_url('video-template') );
  }
}


