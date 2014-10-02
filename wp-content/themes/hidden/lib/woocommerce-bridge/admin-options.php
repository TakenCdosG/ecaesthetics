<?php

######################################################################
# remove backend options by removing them from the config array
######################################################################
add_filter('woocommerce_general_settings','afl_woocommerce_general_settings_filter');
add_filter('woocommerce_page_settings','afl_woocommerce_general_settings_filter');
add_filter('woocommerce_catalog_settings','afl_woocommerce_general_settings_filter');
add_filter('woocommerce_inventory_settings','afl_woocommerce_general_settings_filter');
add_filter('woocommerce_shipping_settings','afl_woocommerce_general_settings_filter');
add_filter('woocommerce_tax_settings','afl_woocommerce_general_settings_filter');

if ( ! function_exists( 'afl_woocommerce_general_settings_filter' ) ):
function afl_woocommerce_general_settings_filter($options)
{  
	$remove   = array('woocommerce_enable_lightbox', 'woocommerce_frontend_css');
	//$remove = array('image_options', 'woocommerce_enable_lightbox', 'woocommerce_catalog_image', 'woocommerce_single_image', 'woocommerce_thumbnail_image', 'woocommerce_frontend_css');

	foreach ($options as $key => $option)
	{
		if( isset($option['id']) && in_array($option['id'], $remove) ) 
		{  
			unset($options[$key]); 
		}
	}

	return $options;
}
endif;

if ( ! function_exists( 'afl_woocommerce_set_defaults' ) ):
//on theme activation set default image size, disable woo lightbox and woo stylesheet. options are already hidden by previous filter function
function afl_woocommerce_set_defaults()
{
	global $afl_config;

	//catalog
	update_option('woocommerce_catalog_image_width', $afl_config['img_size']['shop_catalog']['width']);
	update_option('woocommerce_catalog_image_height',$afl_config['img_size']['shop_catalog']['height']);
	update_option('woocommerce_catalog_image_crop','1');

	//thumbnail
	update_option('woocommerce_single_image_width', $afl_config['img_size']['shop_single']['width']);
	update_option('woocommerce_single_image_height',$afl_config['img_size']['shop_single']['height']);
	update_option('woocommerce_single_image_crop','1');
	
	//single
	update_option('woocommerce_thumbnail_image_width', $afl_config['img_size']['shop_thumbnail']['width']);
	update_option('woocommerce_thumbnail_image_height',$afl_config['img_size']['shop_thumbnail']['height']);
	update_option('woocommerce_thumbnail_image_crop','1');
	
	//set custom
	
	update_option('afl_woocommerce_column_count', 3);
	update_option('afl_woocommerce_product_count', 24);
	
	//set blank
	$set_false = array('woocommerce_enable_lightbox', 'woocommerce_frontend_css');
	foreach ($set_false as $option) { update_option($option, false); }

}
endif;
add_action( 'afl_backend_theme_activation', 'afl_woocommerce_set_defaults', 10);




//add new options to the page settings
add_filter('woocommerce_page_settings','afl_woocommerce_page_settings_filter');
if ( ! function_exists( 'afl_woocommerce_page_settings_filter' ) ):
function afl_woocommerce_page_settings_filter($options)
{
    $theme = wp_get_theme();

	$options[] = array(
		'name' => 'Column and Product Count',
        'type' => 'title',
        'desc' => 'The following settings allow you to choose how many columns and items should appear on your default blog overview page and your product archive pages.<br/><small>Notice: These options are added by the <strong>'.$theme->get( 'Name' ).' Theme</strong> and wont appear on other themes</small>',
        'id'   => 'column_options'
	);
	
	$options[] = array(
			'name' => 'Column Count',
            'desc' => 'This controls how many columns should appear on overview pages.',
            'id' => 'afl_woocommerce_column_count',
            'css' => 'min-width:175px;',
            'std' => '3',
            'type' => 'select',
            'options' => array
                (
                    '3' => '3',
                    '4' => '4',
                    '5' => '5'
                )
	);
	
	$itemcount = array('-1'=>'All');
	for($i = 3; $i<101; $i++) $itemcount[$i] = $i;	
	
		$options[] = array(
			'name' => 'Product Count',
            'desc' => 'This controls how many products should appear on overview pages.',
            'id' => 'avia_woocommerce_product_count',
            'css' => 'min-width:175px;',
            'std' => '24',
            'type' => 'select',
            'options' => $itemcount
	);
	
	$options[] = array(
        
            'type' => 'sectionend',
            'id' => 'column_options'
        );
	
	
	return $options;
}
endif;