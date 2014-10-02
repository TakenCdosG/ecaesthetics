<?php
//update_option('siteurl','http://localhost'); // only for dev testing
//update_option('home','http://localhost'); // only for dev testing

include_once get_template_directory() . '/lib/defaults.php';
include_once get_template_directory() . '/lib/init.php';
require_once( get_template_directory() . '/lib/afl/afl-object.php' );

// ZillaLikes: Add "like" functionality to your posts and pages
// require ZillaLikes plugin
if (!function_exists('zilla_likes_ret')):

    function zilla_likes_ret() {
        global $zilla_likes;
        return $zilla_likes->do_likes();
    }

endif;

define('DEMO', true);

add_action('after_setup_theme', 'afl_setup');
if (!function_exists('afl_setup')):

    function afl_setup() {
        global $domain, $afl_config;
        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();

        $afl_config['img_size']['portfolio'] = array('width' => 700, 'height' => 520);
        $afl_config['img_size']['recent-post-thumbnail'] = array('width' => 90, 'height' => 80);
        $afl_config['img_size']['popular-post-thumbnail'] = array('width' => 60, 'height' => 60);
        $afl_config['img_size']['blog_img'] = array('width' => 1170, 'height' => 9999);
        $afl_config['img_size']['single'] = array('width' => 1170, 'height' => 9999);
        $afl_config['img_size']['portfolio_big'] = array('width' => 1170, 'height' => 9999);

        afl_add_image_sizes($afl_config['img_size']);

        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');

        //add_theme_support('custom-header');
        //add_theme_support('custom-background');
        // Add WooCommerce support
        add_theme_support('woocommerce');

        // Make theme available for translation
        // Translations can be filed in the /languages/ directory
        load_theme_textdomain($domain, get_template_directory() . '/languages');

        $locale = get_locale();
        $locale_file = get_template_directory() . "/languages/$locale.php";
        if (is_readable($locale_file))
            require_once( $locale_file );

        add_theme_support('post-thumbnails');
        add_image_size('post-full', 1300, 410, array('left', 'top'));

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'top_menu' => __('Top Navigation', 'afl'),
            'primary' => __('Primary Navigation', 'afl'),
            'blog' => __('Blog Navigation', 'afl'),
            'footer' => __('Footer Menu', 'afl')
        ));
    }

endif;

if (!isset($content_width))
    $content_width = 600; // WP Theme Support

if (!function_exists('afl_add_image_sizes')):

    function afl_add_image_sizes($sizes) {
        // This theme uses post thumbnails
        if (function_exists('add_theme_support')) {
            add_theme_support('post-thumbnails');
            foreach ($sizes as $name => $size) {
                add_image_size($name, $size['width'], $size['height'], true);
            }
        }
    }

endif;

if (!function_exists('afl_top_right')):

    function afl_top_right() {
        $output = "";
        $cart = "";
        if (function_exists('afl_woocommerce_enabled') && afl_woocommerce_enabled()) {
            $cart = afl_woocommerce_cart_dropdown();
        }

        if ($cart)
            $output .= $cart;

        echo $output;

        return true;
    }

endif;

if (!function_exists('my_generate_attachment_metadata')):

    function my_generate_attachment_metadata($attachment_id, $file) {
        $attachment = get_post($attachment_id);

        $metadata = array();
        if (preg_match('!^image/!', get_post_mime_type($attachment)) && file_is_displayable_image($file)) {
            $imagesize = getimagesize($file);
            $metadata['width'] = $imagesize[0];
            $metadata['height'] = $imagesize[1];
            list($uwidth, $uheight) = wp_constrain_dimensions($metadata['width'], $metadata['height'], 128, 96);
            $metadata['hwstring_small'] = "height='$uheight' width='$uwidth'";

            // Make the file path relative to the upload dir
            $metadata['file'] = _wp_relative_upload_path($file);

            // make thumbnails and other intermediate sizes
            global $_wp_additional_image_sizes;

            foreach (get_intermediate_image_sizes() as $s) {
                $sizes[$s] = array('width' => '', 'height' => '', 'crop' => FALSE);
                if (isset($_wp_additional_image_sizes[$s]['width']))
                    $sizes[$s]['width'] = intval($_wp_additional_image_sizes[$s]['width']); // For theme-added sizes
                else
                    $sizes[$s]['width'] = get_option("{$s}_size_w"); // For default sizes set in options
                if (isset($_wp_additional_image_sizes[$s]['height']))
                    $sizes[$s]['height'] = intval($_wp_additional_image_sizes[$s]['height']); // For theme-added sizes
                else
                    $sizes[$s]['height'] = get_option("{$s}_size_h"); // For default sizes set in options
                if (isset($_wp_additional_image_sizes[$s]['crop']))
                    $sizes[$s]['crop'] = intval($_wp_additional_image_sizes[$s]['crop']); // For theme-added sizes
                else
                    $sizes[$s]['crop'] = get_option("{$s}_crop"); // For default sizes set in options
            }

            $sizes = apply_filters('intermediate_image_sizes_advanced', $sizes);

            // Only generate image if it does not already exist
            $attachment_meta = wp_get_attachment_metadata($attachment_id);

            foreach ($sizes as $size => $size_data) {
                if (isset($attachment_meta['sizes'][$size])) { // Size already exists
                    $metadata['sizes'][$size] = $attachment_meta['sizes'][$size];
                } else {
                    // Generate new image
                    $resized = image_make_intermediate_size($file, $size_data['width'], $size_data['height'], $size_data['crop']);
                    if ($resized)
                        $metadata['sizes'][$size] = $resized;
                }
            }

            if ($attachment_meta['image_meta'])
                $metadata['image_meta'] = $attachment_meta['image_meta'];
        }

        return apply_filters('wp_generate_attachment_metadata', $metadata, $attachment_id);
    }

endif;

if (!function_exists('regenerate_all_attachment_sizes')):

    function regenerate_all_attachment_sizes() {
        $args = array('post_type' => 'attachment', 'numberposts' => 20, 'post_status' => null, 'post_parent' => null, 'post_mime_type' => 'image');
        $attachments = get_posts($args);
        if ($attachments) {
            foreach ($attachments as $post) {
                $file = get_attached_file($post->ID);
                wp_update_attachment_metadata($post->ID, wp_generate_attachment_metadata($post->ID, $file));
            }
        }
    }

endif;

if (!function_exists('afl_wp_print_styles_hook')):
    add_action('wp_print_styles', 'afl_wp_print_styles_hook');

    function afl_wp_print_styles_hook() {
        wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
        wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
        wp_enqueue_style('main-style', get_template_directory_uri() . '/css/style.css');
        wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/custom.css');
        wp_enqueue_style('custom-responsive-style', get_template_directory_uri() . '/css/custom-responsive.css');
        wp_enqueue_style('animate-css', get_template_directory_uri() . '/css/animate.min.css');
        wp_enqueue_style('animations-css', get_template_directory_uri() . '/css/animations.css');
        wp_enqueue_style('prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css');
        wp_enqueue_style('owl-css1', get_template_directory_uri() . '/css/owl-carousel/owl.carousel.css');
        wp_enqueue_style('owl-css2', get_template_directory_uri() . '/css/owl-carousel/owl.theme.css');
        if (get_theme_mod("afl_page_use_slides", false) && !is_admin()) {
            wp_enqueue_style('supersized', get_template_directory_uri() . '/css/supersized/supersized.css');
            wp_enqueue_style('supersized-theme', get_template_directory_uri() . '/css/supersized/supersized.shutter.css');
        }
        $gfonts = array();
        $fonts = unserialize(get_option('afl_font', ''));
        if (is_array($fonts)) {
            foreach ($fonts as $font) {
                $gfonts[] = trim($font['font']);
            }
        }
        if (!empty($gfonts)) {
            wp_enqueue_style('afl-google-fonts', 'http://fonts.googleapis.com/css?family=' . implode('|', $gfonts));
        }
    }

endif;

add_action('wp_print_scripts', 'afl_wp_print_scripts_hook');
if (!function_exists('afl_wp_print_scripts_hook')):

    function afl_wp_print_scripts_hook() {
        if (!is_admin()) {
            wp_enqueue_script('jquery');
            wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', false, false, true);
            wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr.js', false, false, true);
            wp_enqueue_script('jquery-easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', false, false, true);
            wp_enqueue_script('isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', false, false, true);
            //wp_enqueue_script('isotope', get_template_directory_uri().'/js/isotope.pkgd.min.js', false, false , true);
            wp_enqueue_script('elastislide', get_template_directory_uri() . '/js/jquery.elastislide.js', false, false, true);
            wp_enqueue_script('owl', get_template_directory_uri() . '/js/owl-carousel/owl.carousel.min.js', false, false, true);
            wp_enqueue_script('flex-slider', get_template_directory_uri() . '/js/jquery.flexslider.js', false, false, true);
            wp_enqueue_script('hover-intent', get_template_directory_uri() . '/js/hoverIntent.js', false, false, true);
            wp_enqueue_script('superfish', get_template_directory_uri() . '/js/superfish.js', false, false, true);
            wp_enqueue_script('prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', false, false, true);
            wp_enqueue_script('smoothscroll', get_template_directory_uri() . '/js/smoothscroll.js', false, false, true);
            wp_enqueue_script('form', get_template_directory_uri() . '/js/jquery.form.js', false, false, true);
            wp_enqueue_script('validation', get_template_directory_uri() . '/js/jquery.validate.min.js', false, false, true);
            wp_enqueue_script('validation-methods', get_template_directory_uri() . '/js/additional-methods.min.js', false, false, true);
            wp_enqueue_script('parallax', get_template_directory_uri() . '/js/jquery.parallax-1.1.3.js', false, false, true);

            wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js', false, false, true);

            if (get_theme_mod("afl_page_use_slides", false)) {
                wp_enqueue_script('supersized', get_template_directory_uri() . '/js/supersized/supersized.3.2.5.min.js', false, false, true);
                wp_enqueue_script('supersized-theme', get_template_directory_uri() . '/js/supersized/supersized.shutter.min.js', false, false, true);
            }
            wp_enqueue_script('googlemaps', '//maps.googleapis.com/maps/api/js?sensor=false', false, false, true);
        }
    }

endif;

if (!function_exists('new_images_postic')):

    function new_images_postic($post_id, $postic2, $postic3, $postic4) {
        $imgq2 = split('src="', get_the_post_thumbnail($post_id));
        $imgq2 = split('" class', $imgq2[1]);
        if (!$postic2) {
            $postic2 = 100;
        }
        if (!$postic3) {
            $postic3 = 100;
        }
        if (!$postic4) {
            $postic4 = "thumbnail";
        }
        return'
	<img width="' . $postic2 . '" height="' . $postic3 . '" src="' . $imgq2[0] . '" alt="' . get_the_title() . '" class="' . $postic4 . '" />
	';
    }

endif;

if (!function_exists('afl_social_links')):

    function afl_social_links() {
        $output = "";
        $socials = "";
        if ($icons = unserialize(get_option('afl_social'))) {
            $socials .= '<ul class="list-inline social-links">';
            foreach ($icons as $icon) {
                $socials .= '<li><a href="' . $icon['url'] . '" title="' . $icon['title'] . '"><img src="' . get_template_directory_uri() . '/lib/css/images/social/' . $icon['image'] . '" alt="' . $icon['title'] . '" /></a></li>';
            }
            $socials .= '</ul>';
        }

        $output .= $socials;

        echo $output;

        return true;
    }

endif;

add_filter('wp_page_menu_args', 'afl_page_menu_args');
if (!function_exists('afl_page_menu_args')):

    function afl_page_menu_args($args) {
        $args['show_home'] = true;
        return $args;
    }

endif;


add_filter('widget_tag_cloud_args', 'my_widget_tag_cloud_args');
if (!function_exists('my_widget_tag_cloud_args')):

    function my_widget_tag_cloud_args($args) {
        $args['number'] = 20;
        $args['largest'] = 10;
        $args['smallest'] = 10;
        $args['unit'] = 'px';
        return $args;
    }

endif;

add_filter('wp_tag_cloud', 'afl_wp_tag_cloud_filter', 10, 2);
if (!function_exists('afl_wp_tag_cloud_filter')):

    function afl_wp_tag_cloud_filter($return, $args) {
        return preg_replace("#>(.*?)</a>#is", ">$1</a>", $return);
    }

endif;

if (!function_exists('afl_continue_reading_link')):

    function afl_continue_reading_link() {
        if (get_option('afl_readmore_enable', 'open') == 'open') {
            /* $text = get_option('afl_readmore');
              if($text == '') $text = 'Read More';
              return ' <a href="'. get_permalink() . '" class="readmore-link">' . $text  . '</a>'; */
            return '';
        }
        else
            return '';
    }

endif;

if (!function_exists('afl_print_continue_reading_link')):

    function afl_print_continue_reading_link() {
        if (get_option('afl_readmore_enable', 'open') == 'open') {
            $text = get_option('afl_readmore');
            if ($text == '')
                $text = 'Read More';
            echo '<span class="readmore-wrap"><a href="' . get_permalink() . '" class="readmore-link btn btn-info">' . $text . '</a></span>';
        }
        else
            echo '';
    }

endif;

add_filter('excerpt_more', 'afl_auto_excerpt_more');
if (!function_exists('afl_auto_excerpt_more')):

    function afl_auto_excerpt_more($more) {
        return ' &hellip;' . afl_continue_reading_link();
    }

endif;

add_filter('get_the_excerpt', 'afl_custom_excerpt_more');
if (!function_exists('afl_custom_excerpt_more')):

    function afl_custom_excerpt_more($output) {
        if (has_excerpt() && !is_attachment()) {
            $output .= afl_continue_reading_link();
        }
        return $output;
    }

endif;

add_filter('use_default_gallery_style', '__return_false');

if (!function_exists('afl_remove_gallery_css')):

    function afl_remove_gallery_css($css) {
        return preg_replace("#<style type='text/css'>(.*?)</style>#s", '', $css);
    }

endif;
// Backwards compatibility with WordPress 3.0.
if (version_compare($GLOBALS['wp_version'], '3.1', '<'))
    add_filter('gallery_style', 'afl_remove_gallery_css');

if (!function_exists('afl_comment')) :

    function afl_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case '' :
                ?>
                <li <?php comment_class('clearfix comments_li'); ?> id="li-comment-<?php comment_ID(); ?> comment-<?php comment_ID(); ?>">
                    <?php echo get_avatar($comment, 60); ?>
                    <div class="post-date">
                        <?php
                        $day = get_comment_date('d');
                        $month = get_comment_date('M');
                        $year = get_comment_date('Y');
                        $time = get_comment_date('g:i');
                        ?>
                        <div class="day"><?php echo $day; ?></div>
                        <div class="month"><?php echo $month; ?></div>
                        <div class="year"><?php echo $year; ?></div>
                        <div class="time"><?php echo $time; ?></div>
                    </div>
                    <div class="textarea">
                        <div class="meta">
                            <span class="span author"><?php echo get_comment_author_link(); ?></span>
                            <span class="pull-right edit-link"><?php edit_comment_link('<i class="fa fa-pencil"></i>', ' '); ?></span>
                        </div>
                        <?php if ($comment->comment_approved == '0') : ?>
                            <p class="comment-awaiting-moderation"><?php echo 'Your comment is awaiting moderation.'; ?></p>
                        <?php endif; ?>
                        <div class="comment-text"><?php comment_text(); ?></div>
                        <?php comment_reply_link(array_merge($args, array('reply_text' => '<i class="fa fa-reply"></i>', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                    </div>
                </li>
                <?php
                break;
            case 'pingback' :
            case 'trackback' :
                ?>
                <li class="post pingback">
                    <p><?php echo 'Pingback:'; ?> <?php comment_author_link(); ?><?php edit_comment_link('<i class="fa fa-pencil"></i>Edit &nbsp; ', ' '); ?></p>
                </li>
                <?php
                break;
        endswitch;
    }

endif;

add_filter('get_avatar', 'change_avatar_css');
if (!function_exists('change_avatar_css')) :

    function change_avatar_css($class) {
        $class = str_replace("class='avatar", "class='avatar ", $class);
        return $class;
    }

endif;

add_action('widgets_init', 'afl_widgets_init');
if (!function_exists('afl_widgets_init')) :

    /** Register sidebars by running afl_widgets_init() on the widgets_init hook. */
    function afl_widgets_init() {

        if ($sidebars = unserialize(get_option('afl_sidebar'))) {
            foreach ($sidebars as $sidebar) {
                register_sidebar(array(
                    'name' => $sidebar['name'],
                    'id' => $sidebar['slug'],
                    'description' => $sidebar['description'],
                    'before_widget' => '<section id="%1$s" class="widget %2$s">',
                    'after_widget' => '</section>',
                    'before_title' => '<h3 class="widget-title">',
                    'after_title' => '</h3>',
                        )
                );
            }
        }
    }

endif;

add_action('widgets_init', 'afl_remove_recent_comments_style');
if (!function_exists('afl_remove_recent_comments_style')) :

    function afl_remove_recent_comments_style() {
        add_filter('show_recent_comments_widget_style', '__return_false');
    }

endif;

if (!function_exists('afl_strEx')) :

    function afl_strEx($str, $length) {
        $str = explode(" ", $str);
        $nstr = array();
        for ($t = 0; $t < count($str); $t++) {
            $strl = strlen(implode($nstr));
            $strr = strlen(implode($nstr) . " " . $str[$t]);
            if ($strl < $length && $strr < $length) {
                array_push($nstr, " " . $str[$t]);
            } else {
                return trim(implode($nstr));
            }
        }
        return '';
    }

endif;

/* Featured Image Portfolio in Admin */

add_filter('manage_portfolio_posts_columns', 'my_columns_filter', 10, 1);
add_filter('manage_testimonials_posts_columns', 'my_columns_filter', 10, 1);
if (!function_exists('my_columns_filter')):

    function my_columns_filter($columns) {
        $column_thumbnail = array('post_thumb' => __('Thumb', 'afl'));
        $columns = array_slice($columns, 0, 1, true) + $column_thumbnail + array_slice($columns, 1, NULL, true);
        return $columns;
    }

endif;

add_action('manage_portfolio_posts_custom_column', 'my_column_action', 10, 1);
add_action('manage_testimonials_posts_custom_column', 'my_column_action', 5, 2);
if (!function_exists('my_column_action')):

    function my_column_action($column) {
        global $post;
        switch ($column) {
            case 'post_thumb':
                if (function_exists('the_post_thumbnail'))
                    echo the_post_thumbnail(array(55, 55));
                else
                    echo 'Not supported in theme';
                break;
        }
    }

endif;

add_action('admin_head', 'afl_admin_head');
if (!function_exists('afl_admin_head')):

    function afl_admin_head() {
        echo '<style type="text/css">';
        echo '.column-post_thumb { width:60px !important; overflow:hidden }';
        echo '</style>';
    }

endif;

/* End Featured Image Portfolio in Admin */

/* Testimonials Additional Info Field */
/**
 * Display the metabox
 */
if (!function_exists('url_custom_metabox')):

    function url_custom_metabox() {
        global $post;
        $urllink = get_post_meta($post->ID, 'urllink', true);
        $urldesc = get_post_meta($post->ID, 'urldesc', true);

        if (!preg_match("/http(s?):\/\//", $urllink)) {
            $errors = 'Url not valid';
            $urllink = 'http://';
        }

        // output invlid url message and add the http:// to the input field
        if (!empty($errors)) {
            echo $errors;
        }
        ?>

        <p><label for="siteurl">Url:<br />
                <input id="siteurl" size="37" name="siteurl" value="<?php
        if ($urllink) {
            echo $urllink;
        }
        ?>" /></label></p>
        <p><label for="urldesc">Description:<br />
                <textarea id="urldesc" name="urldesc" cols="45" rows="4"><?php
               if ($urldesc) {
                   echo $urldesc;
               }
        ?></textarea></label></p>
        <?php
    }

endif;

/**
 * Process the custom metabox fields
 */
if (!function_exists('save_custom_url')):
// Add action hooks. Without these we are lost
    add_action('save_post', 'save_custom_url');

    function save_custom_url($post_id) {
        global $post;

        if ($_POST && !empty($_POST['siteurl'])) {
            update_post_meta($post->ID, 'urllink', $_POST['siteurl']);
            if (!empty($_POST['urldesc'])) {
                update_post_meta($post->ID, 'urldesc', $_POST['urldesc']);
            }
        }
    }

endif;

/**
 * Add meta box
 */
if (!function_exists('add_custom_metabox')):
// Add action hooks. Without these we are lost
    add_action('admin_init', 'add_custom_metabox');

    function add_custom_metabox() {
        add_meta_box('custom-metabox', __('URL &amp; Description', 'afl'), 'url_custom_metabox', 'testimonials', 'normal', 'high');
    }

endif;
/**
 * Get and return the values for the URL and description
 */
if (!function_exists('get_url_desc_box')):

    function get_url_desc_box($id = null) {
        if ($id == null) {
            global $post;
            $id = $post->ID;
        }
        $urllink = get_post_meta($id, 'urllink', true);
        $urldesc = get_post_meta($id, 'urldesc', true);

        return array($urllink, $urldesc);
    }

endif;

/* End Testimonials Additional Info Field */

/* Page Portfolio Options Fields */
/**
 * Display the metabox
 */
if (!function_exists('portfolio_custom_metabox')):

    function portfolio_custom_metabox() {
        global $post;
        $num_cols = get_post_meta($post->ID, 'num_cols', true);
        $portfolio_type = get_post_meta($post->ID, 'portfolio_type', true);
        $portfolio_sort = get_post_meta($post->ID, 'portfolio_sort', 'none');
        $sort = array('None', 'Title ASC', 'Title DESC', 'Date ASC', 'Date DESC', 'Randomize');
        ?>

        <label for="num_cols">Columns:<br />
            <select name="num_cols" id="num_cols">
                <?php
                for ($i = 2; $i < 5; $i++) {
                    $selected = ($i == $num_cols) ? 'selected' : '';
                    echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                }
                ?>
            </select></label>
        <label for="portfolio_type">Description:<br />
            <select name="portfolio_type" id="portfolio_type">
                <?php
                for ($i = 0; $i < 2; $i++) {
                    $selected = ($i == $portfolio_type) ? 'selected' : '';
                    echo '<option value="' . $i . '" ' . $selected . '>' . (!$i ? 'no description' : 'with description') . '</option>';
                }
                ?>
            </select></label>
        <label for="portfolio_sort">Sort by:<br />
            <select name="portfolio_sort" id="portfolio_sort">
                <?php
                foreach ($sort as $field) {
                    $selected = ($field == $portfolio_sort) ? 'selected' : '';
                    echo '<option value="' . $field . '" ' . $selected . '>' . $field . '</option>';
                }
                ?>
            </select></label>
        <div class="afl-clear"></div>
        <?php
    }

endif;

/**
 * Process the custom metabox fields
 */
// Add action hooks. Without these we are lost
add_action('save_post', 'save_portfolio_settings');
if (!function_exists('save_portfolio_settings')):

    function save_portfolio_settings($post_id) {
        global $post;

        if ($_POST && !empty($_POST['num_cols'])) {
            update_post_meta($post->ID, 'num_cols', $_POST['num_cols']);
        }
        if ($_POST && !empty($_POST['portfolio_type'])) {
            update_post_meta($post->ID, 'portfolio_type', $_POST['portfolio_type']);
        }
        if ($_POST && !empty($_POST['portfolio_sort'])) {
            update_post_meta($post->ID, 'portfolio_sort', $_POST['portfolio_sort']);
        }
    }

endif;

/**
 * Add meta box
 */
// Add action hooks. Without these we are lost
add_action('admin_init', 'add_portfolio_metabox');
if (!function_exists('add_portfolio_metabox')):

    function add_portfolio_metabox() {
        add_meta_box('portfolio-metabox', __('Portfolio Cols &amp; Type (Affects "portfolio" type pages ONLY)'), 'portfolio_custom_metabox', 'page', 'normal', 'high');
    }

endif;
/**
 * Get and return the values for the Portfolio Settings
 */
if (!function_exists('get_portfolio_settings')):

    function get_portfolio_settings($id = null) {
        if ($id == null) {
            global $post;
            $id = $post->ID;
        }
        $num_cols = get_post_meta($id, 'num_cols', true);
        $portfolio_type = get_post_meta($id, 'portfolio_type', true);
        $portfolio_sort = get_post_meta($id, 'portfolio_sort', 'none');

        return array("num_cols" => $num_cols, "portfolio_type" => $portfolio_type, "portfolio_sort" => $portfolio_sort);
    }

endif;

/* End Page Portfolio Options Fields */

/* Page Sidebar Options Fields */
/**
 * Display the metabox
 */
if (!function_exists('page_sidebar_custom_metabox')):

    function page_sidebar_custom_metabox() {
        global $post;
        $sidebar_position = get_post_meta($post->ID, 'sidebar_position', 'none');
        $sidebar_slug = get_post_meta($post->ID, 'sidebar', 'default');
        ?>

        <label for="sidebar_position">Sidebar Position:<br />
            <select name="sidebar_position" id="sidebar_position">
                <option value="none" <?php if ($sidebar_position == 'none') echo 'selected="selected"'; ?>>No Sidebar</option>
                <option value="left" <?php if ($sidebar_position == 'left') echo 'selected="selected"'; ?>>Right</option>
                <option value="right" <?php if ($sidebar_position == 'right') echo 'selected="selected"'; ?>>Left</option>
            </select></label>

        <label for="sidebar_name">Sidebar:<br />
            <select name="sidebar" id="sidebar_name">
                <option value="default" <?php if ($sidebar_slug == 'default') echo 'selected="selected"'; ?>>Default Sidebar</option>
                <?php
                if ($sidebars = unserialize(get_option('afl_sidebar'))) {
                    foreach ($sidebars as $sidebar) {
                        ?>
                        <option value="<?php echo $sidebar['slug']; ?>" <?php if ($sidebar['slug'] == $sidebar_slug) echo 'selected="selected"'; ?>><?php echo $sidebar['name']; ?></option>
                        <?php
                    }
                }
                ?>

            </select></label>
        <div class="afl-clear"></div>
        <?php
    }

endif;

/**
 * Process the custom metabox fields
 */
// Add action hooks. Without these we are lost
add_action('save_post', 'save_page_sidebar_settings');
if (!function_exists('save_page_sidebar_settings')):

    function save_page_sidebar_settings($post_id) {
        global $post;

        if ($_POST && !empty($_POST['sidebar_position'])) {
            update_post_meta($post->ID, 'sidebar_position', $_POST['sidebar_position']);
        }
        if ($_POST && !empty($_POST['sidebar'])) {
            update_post_meta($post->ID, 'sidebar', $_POST['sidebar']);
        }
    }

endif;

/**
 * Add meta box
 */
// Add action hooks. Without these we are lost
add_action('admin_init', 'add_page_sidebar_metabox');
if (!function_exists('add_page_sidebar_metabox')):

    function add_page_sidebar_metabox() {
        add_meta_box('page-sidebar-metabox', __('Page Sidebar Settings (Affects "Page" type pages ONLY)'), 'page_sidebar_custom_metabox', 'page', 'normal', 'high');
    }

endif;
/**
 * Get and return the values for the Portfolio Settings
 */
if (!function_exists('get_page_sidebar_settings')):

    function get_page_sidebar_settings($id = null) {
        if ($id == null) {
            global $post;
            $id = $post->ID;
        }
        $sidebar_position = get_post_meta($id, 'sidebar_position', 'none');
        $sidebar = get_post_meta($id, 'sidebar', 'default');

        return array("sidebar_position" => $sidebar_position, "sidebar" => $sidebar);
    }

endif;

/* End Page Sidebar Options Fields */

if (!function_exists('excerpt')):

    function excerpt($limit = 0) {
        if ($limit > 0)
            $limit++;
        else {
            $limit = 1 + ($e = intval(get_option('afl_excerpt'))) > 0 ? $e : 40;
            $limit++;
        }

        $excerpt = explode(' ', get_the_excerpt(), $limit);
        if (count($excerpt) >= $limit) {
            array_pop($excerpt);
            $excerpt = implode(" ", $excerpt);
        } else {
            $excerpt = implode(" ", $excerpt);
        }
        $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);

        return $excerpt;
    }

endif;

if (!function_exists('content')):

    function content($limit = 0) {
        if ($limit > 0)
            $limit++;
        else {
            $limit = ($e = intval(get_option('afl_excerpt'))) > 0 ? $e : 40;
            $limit++;
        }

        $content = explode(' ', get_the_content(), $limit);
        if (count($content) >= $limit) {
            array_pop($content);
            $content = implode(" ", $content) . '...';
        } else {
            $content = implode(" ", $content);
        }
        $content = preg_replace('/\[.+\]/', '', $content);
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);
        return $content;
    }

endif;

// fix disappearing tinymce
add_filter('wp_default_editor', create_function('', 'return "tinymce";'));

// span for categories count
add_filter('wp_list_categories', 'cat_count_span');
if (!function_exists('cat_count_span')):

    function cat_count_span($links) {
        $links = str_replace('</a> (', ' <span class="count">(', $links);
        $links = str_replace(')', ')</span></a>', $links);
        return $links;
    }

endif;

// add slug class to wp_list_categories
add_filter('wp_list_categories', 'add_slug_class_wp_list_categories');
if (!function_exists('add_slug_class_wp_list_categories')):

    function add_slug_class_wp_list_categories($list) {

        $cats = get_categories('hide_empty=0');
        $get_icons = unserialize(get_option('afl_cat_icons', ''));
        global $categoryIcons;
        foreach ($cats as $cat) {
            $find = '<li class="cat-item cat-item-' . $cat->term_id . '">';
            if ($get_icon = $get_icons[$cat->term_id]) {
                $ico = 'cat-with-icon';
            } else {
                $ico = '';
            }
            $replace = '<li class="cat-item cat-item-' . $cat->term_id . ' ' . $cat->slug . ' ' . $ico . '">';
            if ($get_icon = $get_icons[$cat->term_id])
                $replace .= '<i class="cat-icon fa ' . $categoryIcons[$get_icon] . '"></i>';
            $list = str_replace($find, $replace, $list);
        }

        return $list;
    }

endif;
// add class to excerpt
add_filter("the_excerpt", "add_class_to_excerpt");
if (!function_exists('add_class_to_excerpt')):

    function add_class_to_excerpt($excerpt) {
        return str_replace('<p', '<p class="excerpt"', $excerpt);
    }

endif;

//
if (!function_exists('ajax_get_portfolio_content')):

    function ajax_get_portfolio_content($post_id) {

        $data = get_post($post_id);

        // get portfolio image
        $src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'portfolio');
        $src = '<img src="' . $src[0] . '" alt="" />';

        // get portfolio categories
        $post_category = get_the_term_list($post_id, 'portfoliocat', '<ul><li>', '</li> <li>', '</li><li><a id="close_extended_portfolio"><i class="fa fa-times"></i></a></li></ul>');

        // get portfolio author name
        $post_author = get_userdata($data->post_author);
        $post_author = $post_author->user_login;

        $extended_portfolio = array(
            "post_author" => $post_author,
            "post_content" => do_shortcode($data->post_content),
            "post_title" => $data->post_title,
            "post_category" => $post_category,
            "post_image" => $src
        );


        //$data = (array) $data;
        $data = $extended_portfolio;
        if (!$data)
            return false;
        //return $data->post_content;
        return $data;
    }

endif;

add_action('wp_ajax_orders_ajax', 'afl_ajax_orders_settings');
add_action('wp_ajax_nopriv_orders_ajax', 'afl_ajax_orders_settings');
if (!function_exists('afl_ajax_orders_settings')):

    function afl_ajax_orders_settings() {
        // the first part is a SWTICHBOARD that fires specific functions
        // according to the value of Query Var 'fn'

        switch ($_REQUEST['fn']) {
            case 'get_portfolio_content':
                $output = ajax_get_portfolio_content($_REQUEST['post_id']);
                break;
            default:
                $output = 'No function specified, check your jQuery.ajax() call';
                break;
        }

        // at this point, $output contains some sort of valuable data!
        // Now, convert $output to JSON and echo it to the browser
        // That way, we can recapture it with jQuery and run our success function

        $output = json_encode($output);
        if (is_array($output)) {
            print_r($output);
        } else {
            echo $output;
        }
        die;
    }

endif;
if (!function_exists('print_blog_info')):

    function print_blog_info() {
        global $post;
        echo '
    <div class="meta-block">
        <ul class="clearfix meta-list fa-ul">';

        echo '<li><i class="fa-li fa fa-lg fa-clock-o"></i>';
        //the_date('', ', ', '');
        $year = get_the_time('Y', $post->ID);
        $month = get_the_time('M', $post->ID);
        $day = get_the_time('j', $post->ID);
        echo $month . ' ' . $day . ', ' . $year;
        echo '</li>';

        echo '<li><i class="fa-li fa fa-lg fa-user"></i>';
        echo '<a href="' . get_author_posts_url($post->post_author) . '">' . get_the_author_meta('display_name', $post->post_author) . '</a>';
        echo '</li>';

        if (has_tag()) {
            echo '<li><i class="fa-li fa fa-lg fa-tag"></i>';
            the_tags('', ', ', '');
            echo '</li>';
        }

        if (get_option('hide_post_categories') != 'open') {
            echo '<li><i class="fa-li fa fa-lg fa-folder-open"></i>';
            the_category(', ');
            echo '</li>';
        }
        if (get_option('hide_post_comments_meta') != 'open') {
            echo '<li class="li-comments"><i class="fa-li fa fa-lg fa-comment"></i>';
            comments_popup_link('No Comments', '1 Comment', '% Comments');
            echo '</li>';
        }
        echo '</ul>
    </div>';
    }

endif;

if (!function_exists('print_post_date')):

    function print_post_date() {
        global $post;
        $year = get_the_time('Y', $post->ID);
        $month = get_the_time('M', $post->ID);
        $day = get_the_time('d', $post->ID);
        echo '
        <div class="post-date">
            <div class="day">' . $day . '</div><div class="month">' . $month . '</div><div class="year">' . $year . '</div>
        </div>';
    }

endif;

if (!function_exists('print_post_comments')):

    function print_post_comments() {
        if (get_option('hide_post_comments_meta') != 'open') {
            echo '<div class="post-comments">';
            comments_popup_link('0', '1', '%', 'post-comments-link', 'Off');
            echo '<i class="fa fa-comment"></i></div>';
        }
    }

endif;

if (!function_exists('print_author')):

    function print_author() {
        global $post;
        echo '<span class="post-author">by ';
        echo '<a href="' . get_author_posts_url($post->post_author) . '">' . get_the_author_meta('display_name', $post->post_author) . '</a>';
        echo '</span>';
    }

endif;

if (!function_exists('print_tags')):

    function print_tags() {
        if (has_tag()) {
            echo '<span class="post-tags"><i class="fa fa-tag"></i>';
            the_tags('', ', ', '');
            echo '</span>';
        }
    }

endif;

if (!function_exists('print_categories')):

    function print_categories() {
        if (get_option('hide_post_categories') != 'open') {
            echo '<span class="post-categories"><i class="fa fa-folder-open"></i>';
            the_category(', ');
            echo '</span>';
        }
    }

endif;

if (!function_exists('print_author_info')):

    function print_author_info() {
        if (get_the_author_meta('description')) {
            echo '<div id="authorinfo" class="clearfix">
                <div id="authorimg">';

            $id_or_email = get_the_author_meta('user_email');
            echo get_avatar($id_or_email, $size = '70');

            echo '</div>
                <div id="authordesc">
                <div class="authornms">
                    <span>About Author:&nbsp;</span><a href="' . get_the_author_meta('url') . '">' . get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name') . '</a>';
            echo '</div>
                <div class="authorbio">' . get_the_author_meta('description') . '</div>
            </div>
        </div>';
        }
    }

endif;

if (!function_exists('send_af_contact_form')):

    function send_af_contact_form() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && isset($_POST['af-form-submit'])) {
            $message = '<b>' . trim($_POST['name']) . '</b><br/>' . trim($_POST['email']) . '<br/><br/><b>Message:</b><br/>' . nl2br($_POST['message']);

            Email(get_option('admin_email', 'admin@' . home_url()), 'MCW Contact Form', trim($_POST['email']), trim($_POST['name']), null, null, trim($_POST['subject']), $message, array(), "", "text/html");
            die;
        }
    }

endif;
add_action('wp_head', 'send_af_contact_form');

if (!function_exists('Email')):

    function Email($remail, $rname, $semail, $sname, $cc, $bcc, $subject, $message, $attachments, $priority, $type) {

// Checks if carbon copy & blind carbon copy exist
        if ($cc != null) {
            $cc = "CC: " . $cc . "\r\n";
        } else {
            $cc = "";
        }
        if ($bcc != null) {
            $bcc = "BCC: " . $bcc . "\r\n";
        } else {
            $bcc = "";
        }

// Checks the importance of the email
        if ($priority == "high") {
            $priority = "X-Priority: 1\r\nX-MSMail-Priority: High\r\nImportance: High\r\n";
        } elseif ($priority == "low") {
            $priority = "X-Priority: 3\r\nX-MSMail-Priority: Low\r\nImportance: Low\r\n";
        } else {
            $priority = "";
        }

// Checks if it is plain text or HTML
        if ($type == "plain") {
            $type = "text/plain";
        } else {
            $type = "text/html";
        }

// The boundary is set up to separate the segments of the MIME email
        $boundary = md5(@date("Y-m-d-g:ia"));

// The header includes most of the message details, such as from, cc, bcc, priority etc.
        $header = "From: " . $sname . " <" . $semail . ">\r\nMIME-Version: 1.0\r\nX-Mailer: PHP\r\nReply-To: " . $sname . " <" . $semail . ">\r\nReturn-Path: " . $sname . " <" . $semail . ">\r\n" . $cc . $bcc . $priority . "Content-Type: multipart/mixed; boundary = " . $boundary . "\r\n\r\n";

// The full message takes the message and turns it into base 64, this basically makes it readable at the recipients end
        $fullmessage .= "--" . $boundary . "\r\nContent-Type: " . $type . "; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n" . chunk_split(base64_encode($message));

// A loop is set up for the attachments to be included.
        if ($attachments != null) {
            foreach ($attachments as $attachment) {
                $attachment = explode(":", $attachment);
                $fullmessage .= "--" . $boundary . "\r\nContent-Type: " . $attachment[1] . "; name=\"" . $attachment[2] . "\"\r\nContent-Transfer-Encoding: base64\r\nContent-Disposition: attachment\r\n\r\n" . chunk_split(base64_encode(file_get_contents($attachment[0])));
            }
        }

// And finally the end boundary to set the end of the message
        $fullmessage .= "--" . $boundary . "--";

        return mail($rname . "<" . $remail . ">", $subject, $fullmessage, $header);
    }

endif;

/* Gallery
  /*************************************************************** */
remove_shortcode('gallery');
add_shortcode('gallery', 'my_gallery_shortcode');

/**
 * The Gallery shortcode.
 *
 * This implements the functionality of the Gallery Shortcode for displaying
 * WordPress images on a post.
 *
 * @since 2.5.0
 *
 * @param array $attr Attributes of the shortcode.
 * @return string HTML content to display gallery.
 */
function my_gallery_shortcode($attr) {
    $post = get_post();

    static $instance = 0;
    $instance++;

    if (!empty($attr['ids'])) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if (empty($attr['orderby']))
            $attr['orderby'] = 'post__in';
        $attr['include'] = $attr['ids'];
    }

    // Allow plugins/themes to override the default gallery template.
    $output = apply_filters('post_gallery', '', $attr);
    if ($output != '')
        return $output;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }

    extract(shortcode_atts(array(
                'order' => 'ASC',
                'orderby' => 'menu_order ID',
                'id' => $post ? $post->ID : 0,
                'itemtag' => 'div',
                'icontag' => 'div',
                'captiontag' => 'div',
                'columns' => 3,
                'size' => 'thumbnail',
                'include' => '',
                'exclude' => ''
                    ), $attr, 'gallery'));

    $id = intval($id);
    if ('RAND' == $order)
        $orderby = 'none';

    if (!empty($include)) {
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif (!empty($exclude)) {
        $attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
    } else {
        $attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
    }

    if (empty($attachments))
        return '';

    if (is_feed()) {
        $output = "\n";
        foreach ($attachments as $att_id => $attachment)
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $icontag = tag_escape($icontag);
    $valid_tags = wp_kses_allowed_html('post');
    if (!isset($valid_tags[$itemtag]))
        $itemtag = 'div';
    if (!isset($valid_tags[$captiontag]))
        $captiontag = 'div';
    if (!isset($valid_tags[$icontag]))
        $icontag = 'div';

    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100 / $columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $gallery_style = $gallery_div = '';

    $size_class = sanitize_html_class($size);
    $gallery_div = "<div id='$selector' class='gallery row galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
    $output = apply_filters('gallery_style', $gallery_style . "\n\t\t" . $gallery_div);

    $i = 0;
    $nth = 1;
    foreach ($attachments as $id => $attachment) {
        if (!empty($attr['link']) && 'file' === $attr['link'])
            $image_output = wp_get_attachment_link($id, $size, false, false);
        elseif (!empty($attr['link']) && 'none' === $attr['link'])
            $image_output = wp_get_attachment_image($id, $size, false);
        else
            $image_output = wp_get_attachment_link($id, $size, true, false);

        $image_meta = wp_get_attachment_metadata($id);

        $orientation = '';
        if (isset($image_meta['height'], $image_meta['width']))
            $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

        $output .= "<{$itemtag} class='gallery-item nth-{$nth}'>";
        $output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
				$image_output
			</{$icontag}>";
        if ($captiontag && trim($attachment->post_excerpt)) {
            $output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
        if ($columns > 0 && ++$i % $columns == 0)
            $output .= '<div class="clear divider"></div>';
        $nth++;
        if ($nth > 2)
            $nth = 1;
    }

    $output .= "
			<br style='clear:both' />
		</div>\n";

    return $output;
}

// Change password form layout
add_filter('the_password_form', 'custom_password_form');

function custom_password_form() {
    global $post;
    $label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
    $o = '<form class="form-password" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post"><p>This content is password protected. To view it please enter your password below:</p><div class="form-group"><label class="pass-label sr-only" for="' . $label . '">Password:</label><input class="form-control" name="post_password" id="' . $label . '" type="password" placeholder="password"/><button type="submit" name="Submit" class="btn btn-info btn-sm">Submit</button></div></form>';
    return $o;
}

add_filter('widget_tag_cloud_args', 'tag_cloud_filter', 90);

function tag_cloud_filter($args = array()) {
    $args['smallest'] = 12;
    $args['largest'] = 16;
    $args['unit'] = 'px';
    return $args;
}

// Deregister Plugins CSS
add_action('wp_print_styles', 'afl_deregister_styles', 100);

function afl_deregister_styles() {
    wp_deregister_style('wptw-style'); // Remove WP Twitter Widget CSS http://wordpress.org/plugins/wp-twitter-widget-by-ryoking/
    //wp_deregister_style( 'simplyInstagram' ); // Remove Simply Instagram Widget CSS http://www.rollybueno.info/project/simply-instagram-wordpress-plugin/
    // deregister as many stylesheets as you need...
}

// filter to replace class on reply link
add_filter('comment_reply_link', 'replace_reply_link_class');

function replace_reply_link_class($class) {
    $class = str_replace("class='comment-reply-link", "class='comment-reply-link btn btn-info", $class);
    return $class;
}

// add class to posts links
add_filter('previous_post_link', 'posts_link_prev_class');

function posts_link_prev_class($format) {
    $format = str_replace('href=', 'class="btn btn-info previous-post" href=', $format);
    return $format;
}

add_filter('next_post_link', 'posts_link_next_class');

function posts_link_next_class($format) {
    $format = str_replace('href=', 'class="btn btn-info next-post" href=', $format);
    return $format;
}

// Change default text for comments_popup_link
add_action('loop_start', 'wpse_77028_switch_filter');
add_action('loop_end', 'wpse_77028_switch_filter');

/**
 * Turn comment text filter on or off depending on global $post object.
 *
 * @wp-hook loop_start
 * @wp-hook loop_end
 * @return  void
 */
function wpse_77028_switch_filter() {
    $func = 'loop_start' === current_filter() ? 'add_filter' : 'remove_filter';
    $func('gettext', 'wpse_77028_comment_num_text', 10, 3);
}

/**
 * Change default text for comments_popup_link()
 *
 * @wp-hook gettext
 * @param   string $translated
 * @param   string $original
 * @param   string $domain
 * @return  string
 */
function wpse_77028_comment_num_text($translated, $original, $domain) {
    if ('Enter your password to view comments.' === $original
            and 'default' === $domain
    )
        return '<i class="fa fa-lock tooltip-text" data-placement="left" data-original-title="Enter your password to view comments" rel="tooltip"></i> ';

    return $translated;
}

/* Page Custom Title/Slogan
  /*************************************************************** */

// Display the metabox
if (!function_exists('page_custom_title')):

    function page_custom_title() {
        global $post;

        $pageTitle = get_post_meta($post->ID, 'pageTitle', true);
        $pageSlogan = get_post_meta($post->ID, 'pageSlogan', true);
        ?>

        <div style="margin-bottom: 10px;">
            <label for="pageTitle" class="screen-reader-text">Page title</label>
            <input type="text" value="<?php
        if ($pageTitle) {
            echo $pageTitle;
        }
        ?>" id="pageTitle" size="20" name="pageTitle"/>
        </div>

        <div>
            <label for="pageSlogan" class="screen-reader-text">Page slogan</label>
            <textarea id="pageSlogan" cols="30" rows="2" name="pageSlogan"><?php
           if ($pageSlogan) {
               echo $pageSlogan;
           }
        ?></textarea>
        </div>

        <?php
    }

endif;

// Process the custom metabox fields
// Add action hooks. Without these we are lost
add_action('save_post', 'save_custom_title_main');
if (!function_exists('save_custom_title_main')):

    function save_custom_title_main($post_id) {
        global $post;

        if ($_POST) {
            update_post_meta($post->ID, 'pageTitle', $_POST['pageTitle']);
        }
        if ($_POST) {
            update_post_meta($post->ID, 'pageSlogan', $_POST['pageSlogan']);
        }
    }

endif;


// Add meta box
// Add action hooks. Without these we are lost
add_action('admin_init', 'add_page_custom_title_metabox');
if (!function_exists('add_page_custom_title_metabox')):

    function add_page_custom_title_metabox() {
        add_meta_box('custom-metabox', __('Custom Page Title &amp; Slogan', 'afl'), 'page_custom_title', 'page', 'normal', 'high');
    }

endif;

// Get and return the values for the Title Main and Title Sub
if (!function_exists('get_title_main_desc_box')):

    function get_title_main_desc_box($id = null) {
        if ($id == null) {
            global $post;
            $id = $post->ID;
        }
        $titlemain = get_post_meta($id, 'pageTitle', true);
        $pageSlogan = get_post_meta($id, 'pageSlogan', true);

        return array($titlemain, $pageSlogan);
    }

endif;

/* End Page Custom Title
  /*************************************************************** */

//[afl_social_links]
function afl_social_links_func($atts) {
    $result = afl_social_links();
}

add_shortcode('afl_social_links', 'afl_social_links_func');

## widgets
require_once get_template_directory() . '/lib/inc/register-widgets.php';
require_once get_template_directory() . '/lib/inc/sidebar-init.php';
require_once( get_template_directory() . '/lib/woocommerce-bridge/wooconfig.php' );
