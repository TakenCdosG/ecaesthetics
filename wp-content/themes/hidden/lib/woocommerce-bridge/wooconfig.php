<?php

function afl_woocommerce_enabled()
{
	if ( class_exists( 'woocommerce' ) ){ return true; }
	return false;
}

// Hook in on activation
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'afl_woocommerce_image_dimensions', 1 );

// Define image sizes
function afl_woocommerce_image_dimensions() {
    $catalog = array(
        'width' => '300',
        'height'	=> '300',
        'crop'	=> 1 // true
    );
    $single = array(
        'width' => '600',
        'height'	=> '600',
        'crop'	=> 1 // true
    );
    $thumbnail = array(
        'width' => '150',
        'height'	=> '150',
        'crop'	=> 0 // false
    );
    // Image sizes
    update_option( 'shop_catalog_image_size', $catalog );       // Product category thumbs
    update_option( 'shop_single_image_size', $single );         // Single product image
    update_option( 'shop_thumbnail_image_size', $thumbnail );   // Image gallery thumbs
}

global $afl_config;
//product thumbnails
$afl_config['img_size']['shop_catalog'] 	= array('width'=>300, 'height'=>300);
$afl_config['img_size']['shop_single'] 		= array('width'=>600, 'height'=>600);
$afl_config['img_size']['shop_thumbnail'] 	= array('width'=>150, 'height'=>150);

afl_add_image_sizes($afl_config['img_size']);

include('admin-options.php');
include('admin-import.php');
include('wooshortcodes.php');
include('grid-list-toggle/grid-list-toggle.php');

//check if the plugin is enabled, otherwise stop the script
if(!afl_woocommerce_enabled()) { return false; }

//register my own styles, remove wootheme stylesheet
if(!is_admin()){
	add_action('init', 'afl_woocommerce_register_assets');
}

if ( ! function_exists( 'afl_woocommerce_register_assets' ) ):
function afl_woocommerce_register_assets(){
	wp_enqueue_style( 'afl-woocommerce-css', get_template_directory_uri() . '/lib/woocommerce-bridge/css/woo.css');
	wp_enqueue_script( 'afl-woocommerce-js', get_template_directory_uri() . '/lib/woocommerce-bridge/js/woo.js', array('jquery'), 1, true);
}
endif;

define('WOOCOMMERCE_USE_CSS', false);

######################################################################
# config
######################################################################

//add turbo framework config defaults

$afl_config['shop_overview_column']  = get_option('afl_woocommerce_column_count');  // columns for the overview page
$afl_config['shop_overview_products']= get_option('afl_woocommerce_product_count'); // products for the overview page

$afl_config['shop_single_column'] 	 = 4;			// columns for related products and upsells
$afl_config['shop_single_column_items'] 	 = 3;	// number of items for related products and upsells
$afl_config['shop_overview_excerpt'] = false;		// display excerpt

if(!$afl_config['shop_overview_column']) $afl_config['shop_overview_column'] = 3;



######################################################################
# Create the correct template html structure
######################################################################

add_filter( 'afl_additional_theme_options_page', 'afl_woocommerce_theme_options_page');
add_filter( 'afl_additional_theme_options_page_title', 'afl_woocommerce_theme_options_page_title');
add_action( 'admin_menu', 'afl_woocommerce_options_hook');

//remove woo defaults
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
remove_action( 'woocommerce_pagination', 'woocommerce_catalog_ordering', 20 );
remove_action( 'woocommerce_pagination', 'woocommerce_pagination', 10 );
//remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );


remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

//single page removes
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
remove_action( 'woocommerce_after_single_product', 'woocommerce_upsell_display');
//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10, 2);
//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20, 2);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_before_shop_loop_item', 20, 2);
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_after_shop_loop_item', 20, 2);
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

//add theme actions && filter
add_action( 'woocommerce_before_main_content', 'afl_woocommerce_before_main_content', 10);
add_action( 'woocommerce_after_main_content', 'afl_woocommerce_after_main_content', 10);
add_action( 'woocommerce_before_shop_loop', 'afl_woocommerce_before_shop_loop', 1);
add_action( 'woocommerce_after_shop_loop', 'afl_woocommerce_after_shop_loop', 10);
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 10 ); //
add_action( 'woocommerce_before_shop_loop_item', 'afl_woocommerce_thumbnail', 10); //
add_action( 'woocommerce_after_shop_loop_item', 'afl_product_price', 1); //

//add_action( 'woocommerce_before_product_price', 'afl_woocommerce_overview_excerpt', 10);
//add_action( 'woocommerce_after_shop_loop_item_title', 'afl_woocommerce_overview_excerpt', 10);
add_filter( 'loop_shop_columns', 'afl_woocommerce_loop_columns');
add_filter( 'loop_shop_per_page', 'afl_woocommerce_product_count' );

//add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
//add_action( 'afl_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
//add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
//add_action( 'woocommerce_after_shop_loop_item', 'afl_woocommerce_after_shop_loop_item', 20, 2);
add_action( 'woocommerce_before_shop_loop_item', 'afl_woocommerce_before_shop_loop_item', 20, 2);

//single page adds
add_action( 'woocommerce_after_single_product_summary', 'afl_woocommerce_output_related_products', 60);
add_action( 'woocommerce_after_single_product_summary', 'afl_woocommerce_output_upsells', 70);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30, 2 );
add_action( 'afl_add_to_cart', 'woocommerce_template_single_add_to_cart', 30, 2 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 20 );
add_filter( 'single_product_small_thumbnail_size', 'afl_woocommerce_thumb_size');
add_action( 'woocommerce_single_product_summary', 'afl_product_title', 1);
//add_action( 'woocommerce_before_single_product', 'afl_product_title', 1);

// added ordering and gridlist-toggle to title
add_action( 'woocommerce_archive_description', 'afl_do_gridlist_toggle_button', 1);
//add_filter( 'woocommerce_page_title', 'afl_woocommerce_page_title');

//additional fixes
add_action( 'widgets_init', 'afl_woocommerce_replace_widgets', 60);
add_filter( 'woocommerce_loop_add_to_cart_link', 'afl_woocommerce_loop_add_to_cart_link');

add_action( 'additional_turbo_theme_items', 'afl_additional_turbo_theme_items', 60);

/* add some color modifications to the forum table items */
if ( ! function_exists( 'afl_woocommerce_theme_options_page' ) ):
function afl_woocommerce_theme_options_page($content)
{
	global $__OPTIONS;

	$__OPTIONS['afl_shop_title'] = array(
		'weight' => 6,
		'type' => 'shop',
		'default_value' => get_option('afl_shop_title'),
		'description' => 'Title of your WooCommerce. Will be shown over breadcrumbs',
		'label' => 'Shop Title'
	);
	$__OPTIONS['afl_woocommerce_column_count'] = array(
		'weight' => 6,
		'type' => 'shop',
		'default_value' => get_option('afl_woocommerce_column_count'),
		'description' => 'Number of columns for products pages',
		'label' => 'How Many Columns on WooCommerce Products page?'
	);
	$__OPTIONS['afl_woocommerce_product_count'] = array(
		'weight' => 6,
		'type' => 'shop',
		'default_value' => get_option('afl_woocommerce_product_count'),
		'description' => 'Number of products will be shown on 1 products page',
		'label' => 'How Many Products to show on WooCommerce Products page?'
	);
	$__OPTIONS['afl_shop_sidebar_position'] = array(
		'weight' => 1,
		'type' => 'shop',
		'description' => 'Sidebar position on blog page.',
		'label' => 'Sidebar position',
		'default_value' => get_option('afl_shop_sidebar_position','right')
	);
	$__OPTIONS['afl_shop_sidebar'] = array(
		'weight' => 1,
		'type' => 'shop',
		'description' => 'Sidebar to display on WooCommerce Pages.<br/>Note: You need to create a custom sidebar first!',
		'label' => 'Sidebar',
		'default_value' => get_option('afl_shop_sidebar','default')
	);
	?>


	<div id="afl-tab-shop" class="afl-subpage-container">
		<div class="afl-section-header"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/blog_settings.png);">WooCommerce Settings </strong></div>
        <div class="afl-section afl-text">
            <h4><?php echo $__OPTIONS['afl_shop_title']['label']?></h4>
            <div class="afl-control-container">
                <div class="afl-description"><?php echo $__OPTIONS['afl_shop_title']['description']?></div>
                <div class="afl-control">
					<span class="afl-style-wrap">
					<?php print afl_render_theme_option("afl_shop_title", array('type' => 'text', 'default_value' => get_option('afl_shop_title'),'attributes' => array('class' => 'regular-text', 'name' => "afl_shop_title"))); ?>
					</span>
                </div>
                <div class="afl-clear"></div>
            </div>
        </div>
        <div class="afl-section afl-text">
            <h4><?php echo $__OPTIONS['afl_woocommerce_column_count']['label']?></h4>
            <div class="afl-control-container">
                <div class="afl-description"><?php echo $__OPTIONS['afl_woocommerce_column_count']['description']?></div>
                <div class="afl-control">
					<span class="afl-style-wrap afl-select-style-wrap">
						<span class="afl-select-unify">
						<?php print afl_render_theme_option("afl_woocommerce_column_count", array('type' => 'select', 'options' => array(1,2,3,4), 'default_value' => (get_option('afl_woocommerce_column_count')-1),'attributes' => array('class' => 'regular-text', 'name' => "afl_woocommerce_column_count"))); ?>
							<span class="afl-select-fake-val"><?php $num_cols = get_option('afl_woocommerce_column_count'); echo "{$num_cols}";?></span>
						</span>
					</span>
                </div>
                <div class="afl-clear"></div>
            </div>
        </div>
        <div class="afl-section afl-text">
            <h4><?php echo $__OPTIONS['afl_woocommerce_product_count']['label']?></h4>
            <div class="afl-control-container">
                <div class="afl-description"><?php echo $__OPTIONS['afl_woocommerce_product_count']['description']?></div>
                <div class="afl-control">
					<span class="afl-style-wrap">
					<?php print afl_render_theme_option("afl_woocommerce_product_count", array('type' => 'text', 'default_value' => get_option('afl_woocommerce_product_count'),'attributes' => array('class' => 'regular-text', 'name' => "afl_woocommerce_product_count"))); ?>
					</span>
                </div>
                <div class="afl-clear"></div>
            </div>
        </div>
		<div class="afl-section afl-text">
			<h4><?php echo $__OPTIONS['afl_shop_sidebar_position']['label']?></h4>
			<div class="afl-control-container">
				<div class="afl-description"><?php echo $__OPTIONS['afl_shop_sidebar_position']['description']?></div>
				<div class="afl-control">
					<span class="afl-style-wrap afl-select-style-wrap">
						<span class="afl-select-unify">
							<?php
							$sidebar_position = get_option('afl_shop_sidebar_position');
							$sidebar_pos = 'Right';
							?>
							<select name="afl_shop_sidebar_position" id="afl_shop_sidebar_position">
								<option value="left" <?php if($sidebar_position == 'left') echo 'selected="selected"';?>>Right</option>
								<option value="right" <?php if($sidebar_position == 'right') { echo 'selected="selected"'; $sidebar_pos = 'Left'; } ?>>Left</option>
								<option value="none" <?php if($sidebar_position == 'none') { echo 'selected="selected"'; $sidebar_pos = 'No Sidebar'; } ?>>No Sidebar</option>
							</select>
							<span class="afl-select-fake-val"><?php echo $sidebar_pos;?></span>
						</span>
					</span>
				</div>
				<div class="afl-clear"></div>
			</div>
		</div>
		<div class="afl-section afl-text">
			<h4><?php echo $__OPTIONS['afl_shop_sidebar']['label']?></h4>
			<div class="afl-control-container">
				<div class="afl-description"><?php echo $__OPTIONS['afl_shop_sidebar']['description']?></div>
				<div class="afl-control">
					<span class="afl-style-wrap afl-select-style-wrap">
						<span class="afl-select-unify">
							<?php
							$sidebar_slug = get_option('afl_shop_sidebar');
							$sidebar_name = 'Default Sidebar';
							?>
							<select name="afl_shop_sidebar" id="afl_shop_sidebar">
								<option value="default" <?php if(in_array($sidebar_slug, array('default', ''))) echo 'selected="selected"'; ?>>Default Sidebar</option>
								<?php if ( $sidebars = unserialize( get_option( 'afl_sidebar' ) ) ) {
									foreach ($sidebars as $sidebar) { ?>
										<option value="<?php echo $sidebar['slug']; ?>" <?php if($sidebar['slug'] == $sidebar_slug) { echo 'selected="selected"'; $sidebar_name = $sidebar['name']; } ?>><?php echo $sidebar['name']; ?></option>
									<?php
									}
								} ?>

							</select>
							<span class="afl-select-fake-val"><?php echo $sidebar_name;?></span>
						</span>
					</span>
				</div>
				<div class="afl-clear"></div>
			</div>
		</div>
	</div>
	<?php
	return $content;
}
endif;


/* add some color modifications to the forum table items */
if ( ! function_exists( 'afl_woocommerce_theme_options_page_title' ) ):
function afl_woocommerce_theme_options_page_title($content)
{
	$content = '<div class="afl-section-header" id="tab-shop" style="display: block;"><strong class="afl-page-title" style="background-Image:url('.get_template_directory_uri().'/lib/css/images/icons/blog_settings.png);">WooCommerce Settings </strong></div>';

	return $content;
}
endif;


/* check and save options for woocommerce on theme-options page */
if ( ! function_exists( 'afl_woocommerce_options_hook' ) ):
function afl_woocommerce_options_hook() {
	if ( ! current_user_can('edit_theme_options') )
		return;

	$changes = array();
	if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'theme-options' && $_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['save_changes'])){
			check_admin_referer('theme-option');

			if(isset($_POST['afl_shop_title'])){
				$changes['afl_shop_title'] = trim(stripslashes($_POST['afl_shop_title']));
				update_option('afl_shop_title', $changes['afl_shop_title']);
			} else {
				$changes['afl_shop_title'] = 'Shop';
				update_option('afl_shop_title', 'Shop');
			}
			if(isset($_POST['afl_woocommerce_column_count']) && intval($_POST['afl_woocommerce_column_count']) < 4 && intval($_POST['afl_woocommerce_column_count']) >= 0){
				$changes['afl_woocommerce_column_count'] = intval(trim(stripslashes($_POST['afl_woocommerce_column_count']))) + 1;
				update_option('afl_woocommerce_column_count', $changes['afl_woocommerce_column_count']);
			} else {
				$changes['afl_woocommerce_column_count'] = 3;
				update_option('afl_woocommerce_column_count', $changes['afl_woocommerce_column_count']);
			}
			if(isset($_POST['afl_woocommerce_product_count']) && intval($_POST['afl_woocommerce_product_count']) > 0){
				$changes['afl_woocommerce_product_count'] = intval(trim(stripslashes($_POST['afl_woocommerce_product_count'])));
				update_option('afl_woocommerce_product_count', $changes['afl_woocommerce_product_count']);
			} else {
				$changes['afl_woocommerce_product_count'] = 18;
				update_option('afl_woocommerce_product_count', $changes['afl_woocommerce_product_count']);
			}
			if(isset($_POST['afl_shop_sidebar_position'])){
				$changes['afl_shop_sidebar_position'] = $_POST['afl_shop_sidebar_position'];
				update_option('afl_shop_sidebar_position', trim(stripslashes($_POST['afl_shop_sidebar_position'])));
			}
			if(isset($_POST['afl_shop_sidebar'])){
				$changes['afl_shop_sidebar'] = $_POST['afl_shop_sidebar'];
				update_option('afl_shop_sidebar', trim(stripslashes($_POST['afl_shop_sidebar'])));
			}
		}
	}
	afl_refresh_options($changes);
}
endif;



#
# creates turbo framework container around the shop pages
#
if ( ! function_exists( 'afl_woocommerce_before_main_content' ) ):
function afl_woocommerce_before_main_content()
{ ?>
    <?php
    /*
       get_option('woocommerce_shop_page_id');
       get_option('woocommerce_cart_page_id');
       get_option('woocommerce_checkout_page_id');
       get_option('woocommerce_pay_page_id ');
       get_option('woocommerce_thanks_page_id ');
       get_option('woocommerce_myaccount_page_id ');
       get_option('woocommerce_edit_address_page_id ');
       get_option('woocommerce_view_order_page_id ');
       get_option('woocommerce_terms_page_id ');
   */

    // Print Shop page content if is first page of shop
    /*
    if (is_shop()) {
        global $paged;
        if ($paged < 2) {
            $shop_id = get_option('woocommerce_shop_page_id');
            if (get_post_meta($shop_id, 'afl_composer', true) == 'on') {
                $items = afl_get_te_data($shop_id);
                print(do_shortcode(afl_to_shortcode($items)));
            } else {
                the_content();
            }
        }
    } */?>

	<section id="container">
	<?php afl_woocommerce_breadcrumbs(); ?>

    <?php if(get_option('afl_shop_title') !== ''): ?>
    <!-- Shop Title -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php
                $cur_id = woocommerce_get_page_id('shop'); /* Title */
                $pageSlogan = get_post_meta($cur_id, 'pageSlogan', true);
                ?>
                <hr class="before-title"/>
                <div class="title-divider clearfix">
                    <h1 class="page-title">
                        <?php //echo get_option('afl_shop_title');
                        if (is_shop() && get_option('afl_shop_title') !== '') {
                            echo get_option('afl_shop_title');
                        } else {
                            woocommerce_page_title();
                        } ?>
                    </h1>
                    <div class="clearfix visible-xs"></div>
                    <?php // slogan
                    if ($pageSlogan): echo '<small class="page-title-small">' . $pageSlogan . '</small>'; endif; ?>
                </div>
                <hr class="after-title"/>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php

    $sidebar_pos = get_option('afl_shop_sidebar_position', 'right');

	if($sidebar_pos != 'none' && $sidebar_pos != '') { ?>
	<div class="container page-sidebar">
        <div class="row <?php echo $sidebar_pos; ?>">
        <?php
            if (is_product()) { ?>
                <section id="page-sidebar" class="col-sm-12">
        <?php } else { ?>
                <section id="page-sidebar" class="align<?php echo $sidebar_pos; ?> <?php echo CONTENT_SPAN ?>">
        <?php } ?>

	<?php
	} else {
		echo '<div class="container">';
	}
}
endif;

#
# creates the turbo framework content container around the shop loop
#
if ( ! function_exists( 'afl_woocommerce_before_shop_loop' ) ):
function afl_woocommerce_before_shop_loop()
{
	global $afl_config;

	echo '<div class="template-shop content shop_columns_'.$afl_config['shop_overview_column'].'">';
	ob_start();
	$content = ob_get_clean();
	echo $content;
	ob_start();
}
endif;

#
# closes the turbo framework content container around the shop loop
#
if ( ! function_exists( 'afl_woocommerce_after_shop_loop' ) ):
function afl_woocommerce_after_shop_loop()
{
    echo "<div class='clear'></div>";
	echo afl_pager();
	echo '</div>';
}
endif;


#
# closes turbo framework container around the shop pages
#
if ( ! function_exists( 'afl_woocommerce_after_main_content' ) ):
function afl_woocommerce_after_main_content()
{
	$sidebar_pos = get_option('afl_shop_sidebar_position', 'right');
	$sidebar = !empty($sidebar_pos) && $sidebar_pos != 'none' && !is_product();
	//reset all previous queries
	wp_reset_query();

	if($sidebar) { ?>
            </section>
			<?php get_sidebar(); ?>
        </div>
    </div>
	<?php } else {
		echo '</div>';
	}
	echo "</section>"; // end template-shop content
}
endif;

#
# modifying breadcrumbs display
#
if ( ! function_exists( 'afl_woocommerce_breadcrumbs' ) ):
function afl_woocommerce_breadcrumbs( $args = array() ) {

	$defaults = array(
		'delimiter'  => BREADCRUMBS_DIVIDER,
		'wrap_before'  => '',
		'wrap_after' => '',
		'before'   => '',
		'after'   => '',
		'home'    => BREADCRUMBS_HOME_TEXT
	);

	$args = wp_parse_args( $args, $defaults  );

	if(get_option('afl_breadcrumbs_enable') == 'open'):?>

        <!--breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="breadcrumb-line">
                    <?php echo get_option('breadcrumbs_text') . ' '; woocommerce_get_template( 'shop/breadcrumb.php', $args ); ?>
                </div>
            </div>
        </div>

        <?php if(get_option('afl_shop_title') == ''): ?>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <hr class="before-title"/>
                    </div>
                </div>
            </div>
        <?php endif; ?>

	<?php else: ?>
        <?php if(get_option('afl_shop_title') == ''): ?>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <hr class="mini"/>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif;

}
endif;

#
# showing the price of product
#
if ( ! function_exists( 'afl_product_price' ) ):
    function afl_product_price()
    {

        echo '<div class="overflowed">';
        echo '<div class="price-wrapper pull-left">';
        woocommerce_template_loop_price();
        echo '</div>';
        echo '<div class="add-to-cart-wrapper pull-right">';
        afl_product_add_to_cart();
        echo '</div>';
        echo '</div>';

    }
endif;

#
# creates the post image for each post
#
if ( ! function_exists( 'afl_woocommerce_thumbnail' ) ):
function afl_woocommerce_thumbnail()
{
	//circumvent the missing post and product parameter in the loop_shop template
	global $post;
	$product = get_product( $post->ID );
	$rating = $product->get_rating_html(); //rating is removed for now since the current implementation requires wordpress to do 2 queries for each post which is not that cool on overview pages

    $attachments = get_posts( array(
        'post_type' 	=> 'attachment',
        'numberposts' 	=> -1,
        'post_status' 	=> null,
        'post_parent' 	=> $post->ID,
        'post__not_in'	=> array( get_post_thumbnail_id() ),
        'post_mime_type'=> 'image',
        'orderby'		=> 'menu_order',
        'order'			=> 'ASC'
    ) );

	/*ob_start();
	woocommerce_template_loop_add_to_cart($post, $product);
	$link = ob_get_clean();
	$extraClass  = empty($link) ? "single_button" :  "" ;*/

	echo "<div class='thumbnail_container'>";
    /*if ($product->is_on_sale()) :
        echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.__('Sale!', 'woocommerce').'</span>', $post, $product);
    endif;*/
    echo "<div class='thumbnail_container_inner do-media'>";
    //echo "<a href='".get_permalink($post->ID)."'>";
    echo get_the_post_thumbnail(get_the_ID(), 'shop_single');

    // Create two images hover effect
    if ($attachments):
        $loop = 0;
        $imageUrl = '';
        foreach ($attachments as $key => $attachment) {
            if (get_post_meta($attachment->ID, '_woocommerce_exclude_image', true) == 1):
                continue;
            endif;
            if ($loop == 0):
                //printf('%s', wp_get_attachment_image($attachment->ID, 'shop_catalog'));
                $imageUrl = wp_get_attachment_image_src($attachment->ID, 'shop_single');
                echo '<img class="hover-image" src="' . $imageUrl[0] . '" alt="' . $post->post_title . '"/> ';
            endif;
            $loop++;
        }
    endif;

    //echo "</a>";
    //echo $link;
    //echo "<a class='button show_details_button $extraClass' href='".get_permalink($post->ID)."'>Show Details</a>";
    if (!empty($rating)) echo "<span class='rating_container'>" . $rating . "</span>";

    // get link to first image src
    $imageZoomUrl = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');

    echo '<div class="do-hover">';
    echo '<a href="' . $imageZoomUrl[0] . '" class="do-img-link" data-rel="prettyPhoto"><i class="fa fa-search"></i></a>';
    echo '<a href="' . get_permalink($post->ID) . '" class="do-url-link"><i class="fa fa-link"></i></a>';
    echo '</div>';

    echo "</div>";
    echo "</div>";
}
endif;

if ( ! function_exists( 'afl_woocommerce_before_shop_loop_item' ) ):
function afl_woocommerce_before_shop_loop_item()
{

    //echo "";

}
endif;

if ( ! function_exists( 'afl_woocommerce_after_shop_loop_item' ) ):
function afl_woocommerce_after_shop_loop_item()
{

    global $post;
    $product = get_product( $post->ID );
    ob_start();
    woocommerce_template_loop_add_to_cart($post, $product);
    $link = ob_get_clean();

    afl_woocommerce_overview_excerpt();
    echo "<div class='afl_add_to_cart'>";
    echo $link;
    echo "</div>";

}
endif;

if (!function_exists('afl_product_add_to_cart')):
    function afl_product_add_to_cart()
    {

        global $post;
        $product = get_product($post->ID);
        ob_start();
        woocommerce_template_loop_add_to_cart($post, $product);
        $link = ob_get_clean();

        echo $link;

    }
endif;

#
# echo the excerpt
#
if ( ! function_exists( 'afl_woocommerce_overview_excerpt' ) ):
function afl_woocommerce_overview_excerpt()
{
	if(!empty($afl_config['shop_overview_excerpt']))
	{
		echo "<div class='product_excerpt'>";
		the_excerpt();
		echo "</div>";
	}
}
endif;

#
# check which page is displayed and if the sidebar menu should be prevented
#
if ( ! function_exists( 'afl_woocommerce_sidebar_filter' ) ):
function afl_woocommerce_sidebar_filter($menu)
{
	$id = get_the_ID();
	if(is_cart() || is_checkout() || get_option('woocommerce_thanks_page_id') == $id){$menu = "";}
	return $menu;
}
endif;

if ( ! function_exists( 'afl_add_to_cart' ) ):
function afl_add_to_cart($post, $product )
{
	echo "<div class='afl_cart afl_cart_".$product->product_type."'>";
	do_action( 'afl_add_to_cart', $post, $product );
	echo "</div>";
}
endif;

if ( ! function_exists( 'afl_woocommerce_thumb_size' ) ):
function afl_woocommerce_thumb_size()
{
	//return 'shop_single';
	return 'shop_thumbnail';
}
endif;


#
# shopping cart dropdown in the main menu
#
if ( ! function_exists( 'afl_woocommerce_cart_dropdown' ) ):
function afl_woocommerce_cart_dropdown()
{
	global $woocommerce;
	$cart_subtotal = $woocommerce->cart->get_cart_subtotal();
	$link = $woocommerce->cart->get_cart_url();

	ob_start();
	the_widget('WC_Widget_Cart', '', array('widget_id'=>'cart-dropdown',
													'before_widget' => '',
													'after_widget' => '',
													'before_title' => '<span class="hidden">',
													'after_title' => '</span>'
											  ));
	$widget = ob_get_clean();

	$output = "";
	$output .= "<div class = 'cart_dropdown' data-success='Product added'>";
    $output .= "<div class='cart_dropdown_first'>";
	$output .= "<span class='cart_subtotal'>".$cart_subtotal." <i class='fa fa-shopping-cart'></i></span>";
	$output .= "<div class='dropdown_widget dropdown_widget_cart'>";
	$output .= $widget;
	$output .= "</div>";
	$output .= "</div>";
	$output .= "</div>";

	return $output;
}
endif;

#
# custom sorting params for products loop
#

if ( ! function_exists( 'custom_woocommerce_get_catalog_ordering_args' ) ):
add_filter('woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args');
function custom_woocommerce_get_catalog_ordering_args( $args ) {
	if (isset($_SESSION['orderby'])) {
		switch ($_SESSION['orderby']) :
			case 'date_asc' :
				$args['orderby'] = 'date';
				$args['order'] = 'asc';
				$args['meta_key'] = '';
				break;
			case 'price_desc' :
				$args['orderby'] = 'meta_value_num';
				$args['order'] = 'desc';
				$args['meta_key'] = '_price';
				break;
			case 'title_desc' :
				$args['orderby'] = 'title';
				$args['order'] = 'desc';
				$args['meta_key'] = '';
				break;
		endswitch;
	}
	return $args;
}
endif;

if ( ! function_exists( 'custom_woocommerce_catalog_orderby' ) ):
add_filter('woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby');
function custom_woocommerce_catalog_orderby( $sortby ) {
	$sortby = array();
	$sortby['menu_order'] = 'Default sorting';
	$sortby['title'] = 'Alphabet ( ASC )';
	$sortby['title_desc'] = 'Alphabet ( DESC )';
	$sortby['price'] = 'Price (lowest to highest)';
	$sortby['price_desc'] = 'Price (highest to lowest)';
	$sortby['date'] = 'Date (newest first)';
	$sortby['date_asc'] = 'Date (oldest to newest)';
	return $sortby;
}
endif;



#
# modify shop overview column count
#
if ( ! function_exists( 'afl_woocommerce_loop_columns' ) ):
function afl_woocommerce_loop_columns()
{
	global $afl_config;
	return $afl_config['shop_overview_column'];
}
endif;

#
# modify shop overview product count
#
if ( ! function_exists( 'afl_woocommerce_product_count' ) ):
function afl_woocommerce_product_count()
{
	global $afl_config;
	return $afl_config['shop_overview_products'];
}
endif;


#
# create the shop navigation with account links, as well as cart and checkout
#
if ( ! function_exists( 'afl_woocommerce_template_single_excerpt' ) ):
function afl_woocommerce_template_single_excerpt($post)
{
	global $product;

	if(is_singular())
	{
		echo "<div class='hero-text entry-content'>";
		the_excerpt();
		echo "<span class='seperator extralight-border'></span>";
		echo "</div>";
	}

	echo "<div class='summary-main-content entry-content'>";
	the_content();
	echo "</div>";
}
endif;

if ( ! function_exists( 'afl_add_summary_div' ) ):
function afl_add_summary_div()
{
	global $afl_config;
	$span = "col-sm-8";

	echo "<div class='$span'>";
}
endif;

if ( ! function_exists( 'afl_close_summary_div' ) ):
function afl_close_summary_div()
{
	echo "</div>";
	echo "</div>"; // close row-fluid
}
endif;

if ( ! function_exists( 'afl_shop_nav' ) ):
function afl_shop_nav($args)
{
	$output = "";
	$url = afl_collect_shop_urls();

	$output .= "<ul>";

	if( is_user_logged_in() )
	{
		$output .= "<li class='account_overview_link'><a href='".$url['account_overview']."'>My Account</a>";
		$output .= "<ul>";
		$output .= "<li class='account_change_pw_link'><a href='".$url['account_change_pw']."'>Change Password</a></li>";
		$output .= "<li class='account_edit_adress_link'><a href='".$url['account_edit_adress']."'>Edit Address</a></li>";
		$output .= "<li class='account_view_order_link'><a href='".$url['account_view_order']."'>View Order</a></li>";
		$output .= "<li class='account_logout_link'><a href='".$url['logout']."'>Log Out</a></li>";
		$output .= "</ul>";
		$output .= "</li>";
	}
	else
	{
		if(get_option('users_can_register'))
		{
			$output .= "<li class='register_link'><a href='".$url['register']."'>Register</a></li>";
		}

		$output .= "<li class='login_link'><a href='".$url['account_overview']."'>Log In</a></li>";
	}

	$output .= "<li class='shopping_cart_link'><a href='".$url['cart']."'>Cart</a></li>";
	$output .= "<li class='checkout_link'><a href='".$url['checkout']."'>Checkout</a></li>";
	$output .= "</ul>";

	if($args['echo'] == true)
	{
		echo $output;
	}
	else
	{
		return $output;
	}
}
endif;

#
# helper function that collects all the necessary urls for the shop navigation
#
if ( ! function_exists( 'afl_collect_shop_urls' ) ):
function afl_collect_shop_urls()
{
	global $woocommerce;

	$url['cart']				= $woocommerce->cart->get_cart_url();
	$url['checkout']			= $woocommerce->cart->get_checkout_url();
	$url['account_overview'] 	= get_permalink(get_option('woocommerce_myaccount_page_id'));
	$url['account_edit_adress']	= get_permalink(get_option('woocommerce_edit_address_page_id'));
	$url['account_view_order']	= get_permalink(get_option('woocommerce_view_order_page_id'));
	$url['account_change_pw'] 	= get_permalink(get_option('woocommerce_change_password_page_id'));
	$url['logout'] 				= wp_logout_url(home_url('/'));
	$url['register'] 			= site_url('wp-login.php?action=register', 'login');

	return $url;
}
endif;

#
# single page thumbnail and preview image modifications
#
if ( ! function_exists( 'afl_woocommerceproduct_prev_image' ) ):
function afl_woocommerceproduct_prev_image($post)
{
	global $afl_config, $product;

	$span = "col-sm-4";

	echo '<div class="row">'; // open row-fluid
	echo "<div class='alpha $span prev_image_container'>";

	afl_add_to_cart($post, $product );
	echo "<h1 class='post-title portfolio-single-post-title'>".get_the_title()."</h1>";

	//price
	if(is_object($product) && is_singular())
	{
		echo "<div class='price_container'>";
		woocommerce_template_single_price($post, $product);
		echo "</div>";
	}

	afl_add_to_cart($post, $product );

	$afl_config['currently_viewing'] = 'shop_single';
	wp_reset_query();

	echo "</div>";
}
endif;

#
# display upsells and related products
#
if ( ! function_exists( 'afl_woocommerce_output_related_products' ) ):
function afl_woocommerce_output_related_products()
{
	global $afl_config;

	echo "<div class='clear'></div>";
	echo "<div class='product_column product_column_".$afl_config['shop_single_column']."'>";
	ob_start();
	woocommerce_related_products($afl_config['shop_single_column_items'],$afl_config['shop_single_column']); // 4 products, 4 columns
	$content = ob_get_clean();
	if($content)
	{
		//echo '<h4 class="related_product_title">Related Products</h4>';
		echo $content;
	}


	echo "</div>";
}
endif;

if ( ! function_exists( 'afl_woocommerce_output_upsells' ) ):
function afl_woocommerce_output_upsells()
{
	global $afl_config;

    echo "<div class='clear'></div>";
	echo "<div class='product_column product_column_".$afl_config['shop_single_column']."'>";
	ob_start();
	woocommerce_upsell_display($afl_config['shop_single_column_items'],$afl_config['shop_single_column']); // 4 products, 4 columns
	$content = ob_get_clean();
	if($content)
	{
		//echo '<h4 class="related_product_title">You may also like</h4>';
		echo $content;
	}
	echo "</div>";
}
endif;

if ( ! function_exists( 'afl_woocommerce_replace_widgets' ) ):
function afl_woocommerce_replace_widgets() {
    global $woocommerce;
    if(!isset($woocommerce->query)) {
        require_once ABSPATH.'wp-content/plugins/woocommerce/classes/class-wc-query.php';
        $woocommerce->query			= new WC_Query();
    }
}
endif;

if (!function_exists('afl_do_gridlist_toggle_button')) {
    function afl_do_gridlist_toggle_button() {
        ?>
        <div class="clearfix">
            <?php woocommerce_result_count(); ?>
            <?php woocommerce_catalog_ordering(); ?>
            <?php do_action('woocommerce_gridlist_toggle_button'); ?>
        </div>
        <hr class="small"/>
        <?php
    }
}

add_filter('woocommerce_show_page_title', 'override_page_title');
if (!function_exists('override_page_title')) {
    function override_page_title() {
        return false;
    }
}

if ( ! function_exists( 'afl_woocommerce_page_title' ) ) {

    function afl_woocommerce_page_title($title) {
        ob_start();
        echo '<span class="pull-right">';
        woocommerce_catalog_ordering();
        echo '</span><span class="pull-right">';
        do_action('woocommerce_gridlist_toggle_button');
        woocommerce_result_count();
        echo '</span>';
        $title .= ob_get_clean();

        return $title;
    }
}

if ( ! function_exists( 'afl_woocommerce_loop_add_to_cart_link' ) ) {

    function afl_woocommerce_loop_add_to_cart_link($link_to_cart) {
        $link_to_cart = preg_replace("/ button /", " btn btn-danger ", $link_to_cart);

        return $link_to_cart;
    }
}
if ( ! function_exists( 'afl_product_title' ) ) {
    function afl_product_title() {
        echo '<h3 class="post-heading">'.get_the_title().'</h3>';
    }
}

//add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {

    global $product, $post;

    echo '<div class="woocommerce-tabs">';

    // Description tab - shows product content
    if ( $post->post_content ) {
        echo '<div class="product-description-tab">';
        woocommerce_product_description_tab(); //tab-description
        echo '</div>';
    }

    // Reviews tab - shows comments
    if ( comments_open() ) {
        echo '<div class="product-reviews-tab">';
        comments_template(); //tab-reviews
        echo '</div>';
    }

    // Additional information tab - shows attributes
    if ( $product->has_attributes() || ( get_option( 'woocommerce_enable_dimension_product_attributes' ) == 'yes' && ( $product->has_dimensions() || $product->has_weight() ) ) ) {
        echo '<div class="product-additional-information-tab">';
        woocommerce_product_additional_information_tab(); //tab-additional_information
        echo '</div>';
    }

    echo '</div>';

    unset( $tabs['description'] ); // Remove the description tab
    unset( $tabs['reviews'] ); // Remove the reviews tab
    unset( $tabs['additional_information'] ); // Remove the additional information tab

    return $tabs;

}

// Additional turbo theme items action
if (!function_exists('afl_additional_turbo_theme_items')) {
    function afl_additional_turbo_theme_items($item_name) {
        switch ($item_name) {
            case 'woo_products_carousel':
                require_once 'items/products_carousel.php';
                break;
        }
    }
}

// woocommerce custom cart button text
add_filter('woocommerce_loop_add_to_cart_link', 'woo_custom_button_text_add_to_cart');
function woo_custom_button_text_add_to_cart($val) {
    $tmp = preg_replace('/Add to cart/','<i class="fa fa-shopping-cart"></i>', $val);
    $tmp = preg_replace('/Select options/','<i class="fa fa-gear"></i>', $tmp);
    return $tmp;
}
