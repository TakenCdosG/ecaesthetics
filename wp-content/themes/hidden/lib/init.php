<?php

require_once get_template_directory() . '/lib/defaults.php';
require_once get_template_directory() . '/lib/utillity.php';
require_once get_template_directory() . '/lib/options.php';
require_once get_template_directory() . '/lib/shortcodes.php';

if ( ! function_exists( 'afl_admin_print_styles_hook' ) ):
function afl_admin_print_styles_hook(){

    wp_enqueue_style('font-awesome', get_template_directory_uri().'/css/font-awesome.min.css');
    wp_enqueue_style('admin-custom-style', get_template_directory_uri().'/lib/css/admin-style.css');
	wp_enqueue_style('new-admin-style', get_template_directory_uri().'/lib/css/new-admin-style.css');
	wp_enqueue_style('colorpicker', get_template_directory_uri().'/lib/css/colorpicker.css');
	wp_enqueue_style('prettyPhoto', get_template_directory_uri().'/css/prettyPhoto.css');
	wp_enqueue_style('checkbox', get_template_directory_uri().'/lib/css/ch-but.css');
	wp_enqueue_style('Droid+Sans', "http://fonts.googleapis.com/css?family=Droid+Sans");
}
endif;
add_action("admin_print_styles", 'afl_admin_print_styles_hook');

if ( ! function_exists( 'afl_admin_print_scripts_hook' ) ):
function afl_admin_print_scripts_hook(){
    wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-accordion');
    wp_enqueue_script('ajaxupload', get_template_directory_uri().'/lib/js/ajaxupload.js', array('jquery'));
    wp_enqueue_script('admin-custom-script', get_template_directory_uri().'/lib/js/admin-script.js');
	wp_enqueue_script('admin-color-settings', get_template_directory_uri().'/lib/js/color-settings.js');
	wp_enqueue_script('tooltip-admin', get_template_directory_uri().'/lib/js/tooltip.js');
	wp_enqueue_script('color-picker', get_template_directory_uri().'/lib/js/colorpicker.js');
	wp_enqueue_script('prettyPhoto', get_template_directory_uri().'/js/jquery.prettyPhoto.js');
	wp_enqueue_script('checkbox', get_template_directory_uri().'/lib/js/ch-script.js');
	wp_enqueue_script('imagepreloader', get_template_directory_uri().'/lib/js/imagepreloader.js');
    wp_enqueue_script('faselect', get_template_directory_uri().'/lib/js/faselect.js', false, false , true);

    echo "\n <script type='text/javascript'>\n /* <![CDATA[ */  \n";
	echo "var afl_paths = {\n \tlibPath: '".get_template_directory_uri().'/lib/'."', \n \tbasePath: '".get_template_directory_uri()."', \n \t}; \n /* ]]> */ \n ";
	echo "</script>\n \n ";
    echo "<style type='text/css'>@font-face{font-family:'FontAwesome';src:url('".get_template_directory_uri()."/fonts/fontawesome-webfont.eot?v=4.0.3');src:url('".get_template_directory_uri()."/fonts/fontawesome-webfont.eot?#iefix&v=4.0.3') format('embedded-opentype'),url('".get_template_directory_uri()."/fonts/fontawesome-webfont.woff?v=4.0.3') format('woff'),url('".get_template_directory_uri()."/fonts/fontawesome-webfont.ttf?v=4.0.3') format('truetype'),url('".get_template_directory_uri()."/fonts/fontawesome-webfont.svg#fontawesomeregular?v=4.0.3') format('svg');}</style>";

}
endif;
add_action("admin_print_scripts", 'afl_admin_print_scripts_hook');

if ( ! function_exists( 'afl_ajax_upload_action_hook' ) ):
function afl_ajax_upload_action_hook() {
    if($_POST['type'] == 'image_upload'){
        $file = $_FILES[$_POST['id']];
        if($file){
            $file['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $file['name']);
            $uploaded_file = wp_handle_upload($file,array('test_form'=>false, 'action'=>'wp_handle_upload'));
            $json = null;
            if(count($uploaded_file['error'])){
                $json = array('status'=>0,'data'=>$uploaded_file['error']);
            }
            else{

                $json = array('status'=>1,'data'=>$uploaded_file['url']);
                if(filter_var($_POST['dothumbs'], FILTER_VALIDATE_BOOLEAN)){
                    $pi = pathinfo($uploaded_file['file']);
                    $thumb_path = wp_get_image_editor($uploaded_file['file'],200,150,true,'bgthumb');
                    if(is_string($thumb_path)){
                    	$json['thumb'] = get_option('siteurl').'/'.str_replace(ABSPATH, '', $thumb_path);
                    }
                }
            }
            print json_encode($json);
        }
        exit;
    }
    elseif($_POST['type'] == 'get_composer_data'){
        $items = afl_get_te_data($_POST['post_ID'], 'afl_composer_data');
        if(isset($items)){
             print(json_encode(afl_to_shortcode($items)));
        }
        exit;
    }
}
endif;
add_action('wp_ajax_afl_ajax_upload_action', 'afl_ajax_upload_action_hook');

if ( ! function_exists( 'afl_media_upload_library_hook' ) ):
function afl_media_upload_library_hook(){
    if(isset($_REQUEST[send])){
        //put scripts
        print '<script language="javascript" type="text/javascript" src="'.get_option('siteurl').'/wp-includes/js/tinymce/tiny_mce_popup.js"></script>';
	print '<script language="javascript" type="text/javascript" src="'.get_option('siteurl').'/wp-includes/js/tinymce/utils/form_utils.js"></script>';
        echo '<script type="text/javascript">
    /* <![CDATA[ */
    window.onload = function(){tinyMCEPopup.close();};
    /* ]]> */  
    </script>';
    }
    
}
endif;
add_action('media_upload_library', 'afl_media_upload_library_hook', 10);

if(!function_exists('afl_backend_theme_activation')):
	/**
	 *  This function gets executed if the theme just got activated. It resets the global frontpage setting
	 *  and then redirects the user to the turbo framework main options page
	 */
	function afl_backend_theme_activation()
	{
		global $pagenow;
		if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
		{
			#set frontpage to display_posts
			update_option('show_on_front', 'posts');

			#provide hook so themes can execute theme specific functions on activation
			do_action('afl_backend_theme_activation');

			#redirect to options page
			header( 'Location: '.admin_url().'admin.php?page=theme-options' ) ;
		}
	}
endif;
add_action('admin_init','afl_backend_theme_activation');

require_once get_template_directory() . '/lib/metaboxes.php';
require_once get_template_directory() . '/lib/post-types.php';
require_once get_template_directory() . '/lib/tinymceInsertImage/init.php';
//including custom background
require_once get_template_directory() . '/lib/theme-backgrounds.php';
require_once get_template_directory() . '/lib/shortcodes/shortcodes.php';
//require_once TEMPLATEPATH . '/lib/pricetables/pricetable.php';
