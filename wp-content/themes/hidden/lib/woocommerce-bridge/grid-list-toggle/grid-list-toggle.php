<?php
/*
Plugin Name: WooCommerce Grid / List toggle
Plugin URI: http://jameskoster.co.uk/tag/grid-list-toggle/
Description: Adds a grid/list view toggle to product archives
Version: 0.3
Author: jameskoster
Author URI: http://jameskoster.co.uk
Requires at least: 3.1
Tested up to: 3.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/**
 * Check if WooCommerce is active
 **/
if ( function_exists('afl_woocommerce_enabled') && afl_woocommerce_enabled()  ) {

	/**
	 * WC_List_Grid class
	 **/
	if (!class_exists('WC_List_Grid')) {

		class WC_List_Grid {

			public function __construct() {
				// Hooks
  				add_action( 'wp' , array(&$this, 'setup_gridlist' ) , 20);

  				// Init settings
				$this->settings = array(
					array(
						'name' => __( 'Default catalog view', 'wc_list_grid_toggle' ),
						'type' => 'title',
						'id' => 'wc_glt_options'
					),
					array(
						'name' 		=> __( 'Default catalog view', 'wc_list_grid_toggle' ),
						'desc_tip' 	=> __( 'Display products in grid or list view by default', 'wc_list_grid_toggle' ),
						'id' 		=> 'wc_glt_default',
						'type' 		=> 'select',
						'options' 	=> array(
							'grid'  => __('Grid', 'wc_list_grid_toggle'),
							'list' 	=> __('List', 'wc_list_grid_toggle')
						)
					),
					array( 'type' => 'sectionend', 'id' => 'wc_glt_options' ),
				);

				// Default options
				add_option( 'wc_glt_default', 'grid' );
				add_option( 'wc_apm_google', 'no' );
				add_option( 'wc_apm_mastercard', 'no' );
				add_option( 'wc_apm_paypal', 'no' );
				add_option( 'wc_apm_visa', 'no' );

				// Admin
				add_action( 'woocommerce_settings_image_options_after', array( &$this, 'admin_settings' ), 20);
				add_action( 'woocommerce_update_options_catalog', array( &$this, 'save_admin_settings' ) );
			}

			/*-----------------------------------------------------------------------------------*/
			/* Class Functions */
			/*-----------------------------------------------------------------------------------*/

			function admin_settings() {
				woocommerce_admin_fields( $this->settings );
			}

			function save_admin_settings() {
				woocommerce_update_options( $this->settings );
			}

			// Setup
			function setup_gridlist() {
				if ( is_shop() || is_product_category() || is_product_tag() ) {
					add_action( 'wp_enqueue_scripts', array(&$this, 'setup_scripts_styles'), 20);
					add_action( 'wp_enqueue_scripts', array(&$this, 'setup_scripts_script'), 20);
					//add_action( 'woocommerce_before_shop_loop', array(&$this, 'gridlist_toggle_button'), 30);
					add_action( 'woocommerce_gridlist_toggle_button', array(&$this, 'gridlist_toggle_button'), 30);
					add_action( 'woocommerce_after_shop_loop_item', array(&$this, 'gridlist_buttonwrap_open'), 9);
					add_action( 'woocommerce_after_shop_loop_item', array(&$this, 'gridlist_buttonwrap_close'), 11);
					//add_action( 'woocommerce_after_shop_loop_item', array(&$this, 'gridlist_hr'), 30);
					add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 5);
				}
			}

			// Scripts & styles
			function setup_scripts_styles() {
				if ( is_shop() || is_product_category() || is_product_tag() ) {
					wp_enqueue_style( 'grid-list-layout', get_template_directory_uri().'/lib/woocommerce-bridge/grid-list-toggle/assets/css/style.css');
				}
			}
			function setup_scripts_script() {
				if ( is_shop() || is_product_category() || is_product_tag() ) {
					wp_enqueue_script( 'cookie', get_template_directory_uri().'/lib/woocommerce-bridge/grid-list-toggle/assets/js/jquery.cookie.min.js', array( 'jquery' ) );
					wp_enqueue_script( 'grid-list-scripts', get_template_directory_uri().'/lib/woocommerce-bridge/grid-list-toggle/assets/js/jquery.gridlistview.min.js', array( 'jquery' ) );
					add_action( 'wp_footer', array(&$this, 'gridlist_set_default_view') );
				}
			}

			// Toggle button
			function gridlist_toggle_button() {
				?>
					<nav class="gridlist-toggle">
						<a href="#" id="grid" title="<?php _e('Grid view', 'wc_list_grid_toggle'); ?>"> <i class="fa fa-th-large"></i> <span><?php _e('Grid view', 'wc_list_grid_toggle'); ?></span></a>
                        <a href="#" id="list" title="<?php _e('List view', 'wc_list_grid_toggle'); ?>"> <i class="fa fa-th-list"></i> <span><?php _e('List view', 'wc_list_grid_toggle'); ?></span></a>
                        <a href="#" id="simple" title="<?php _e('Simple view', 'wc_list_grid_toggle'); ?>"> <i class="fa fa-align-justify"></i> <span><?php _e('Simple view', 'wc_list_grid_toggle'); ?></span></a>
					</nav>
				<?php
			}

			// Button wrap
			function gridlist_buttonwrap_open() {
				?>

				<?php
			}
			function gridlist_buttonwrap_close() {
				?>

				<?php
			}

			// hr
			function gridlist_hr() {
				?>
					<hr />
				<?php
			}

			function gridlist_set_default_view() {
				$default = get_option( 'wc_glt_default' );
				?>
					<script>
						if (jQuery.cookie('gridcookie') == null) {
					    	jQuery('ul.products').addClass('<?php echo $default; ?>');
					    	jQuery('.gridlist-toggle #<?php echo $default; ?>').addClass('active');
					    }
					</script>
				<?php
			}
		}
		$WC_List_Grid = new WC_List_Grid();
	}
}
