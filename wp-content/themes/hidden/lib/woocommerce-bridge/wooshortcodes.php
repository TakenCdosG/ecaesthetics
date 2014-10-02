<?php
/**
 * Created by DXThemes.com
 * User: Kuzen Leibovitz
 * Date: 11.01.13
 * Time: 11:10
 * Shortcodes to be used with woocommerce enabled themes only
 */
require_once get_template_directory() . '/lib/shortcodes.php';
global $__SHORTCODES;

$__SHORTCODES['afl_woo_products_carousel'] = array(
	'name' => 'Products Carousel',
	'description' => 'Woocommerce Products Carousel',
	'image' => 'css/images/recent-posts-tip.png'
);

/*********************** Begin Products Strip *************************/
if ( ! function_exists( 'afl_woo_products_carousel' ) ):
function afl_woo_products_carousel($atts, $content = null){
	global $woocommerce;

	$suf = rand(100000,999999);

	if(!isset($atts['number']) || $atts['number'] < 1 || $atts['number'] > 12) $atts['number'] = 12;
	if(!isset($atts['columns']) || $atts['columns'] < 2 || $atts['columns'] > 4) $atts['columns'] = 4;
	switch($atts['columns']){
		case 2:$span='col-sm-6';break;
		case 3:$span='col-sm-4';break;
		default:$span='col-sm-3';break;
	}

	$title=( isset($atts['title'])? $atts['title'] : "Featured Products" );
	$featured=( isset($atts['featured']) && $atts['featured'] == "yes" ? true : false );
	$columns=$atts['columns'];
	$number=$atts['number'];
	$category=( isset($atts['category'])? $atts['category'] : '0' );
//var_export($category);
	$content = '<div class="container products_carousel"><div class="row"><div class="col-sm-12">';
	$content .= '<div class="title-divider"><h3 class="afl-title">'.$title.'</h3></div>';
	$content .= '<div id="woo-products-'.$suf.'" class="carousel btleft"><div class="carousel-wrapper">';

	if(isset($atts['category']) && $category != '0' )
		$content .= do_shortcode('[product_category category="'.$category.'" per_page="'.$number.'" columns="'.$columns.'"][/product_category]');
	else
		if($featured)
			$content .= do_shortcode('[featured_products per_page="'.$number.'" columns="'.$columns.'"][/featured_products]');
		else
			$content .= do_shortcode('[recent_products per_page="'.$number.'" columns="'.$columns.'"][/recent_products]');

	$content .= '<script type="text/javascript">
            jQuery(window).load(function(){
                jQuery("#woo-products-'.$suf.'").elastislide({
                    imageW  : 270,
                    margin  : 20
                });
			});
			</script>
			</div></div></div></div></div>';

	return $content;
}
endif;
add_shortcode('woo_products_carousel', 'afl_woo_products_carousel');
/************************* End Recent Posts ************************/

if ( ! function_exists( 'afl_woocommerce_product_add_to_cart' ) ):
function afl_woocommerce_product_add_to_cart( $atts ) {
    if (empty($atts)) return;

    global $wpdb, $woocommerce;

    if (!isset($atts['style'])) $atts['style'] = 'border:1px solid #d6d6d6; padding: 10px;';

    if ($atts['id']) :
        $product_data = get_post( $atts['id'] );
    elseif ($atts['sku']) :
        $product_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $atts['sku']));
        $product_data = get_post( $product_id );
    else :
        return;
    endif;

    if ($product_data->post_type=='product') {

        $product = $woocommerce->setup_product_data( $product_data );

        ob_start();
        ?>
    <p class="product clearfix afl_shortcode_product_by_sku">

        <?php echo $product->get_price_html(); ?>

        <?php woocommerce_template_loop_add_to_cart(); ?>

        </p><?php

        return ob_get_clean();

    } elseif ($product_data->post_type=='product_variation') {

        $product = new WC_Product( $product_data->post_parent );

        $GLOBALS['product'] = $product;

        $variation = new WC_Product_Variation( $product_data->ID );

        ob_start();
        ?>
    <p class="product product-variation" style="<?php echo $atts['style']; ?>">

        <?php echo $product->get_price_html(); ?>

        <?php

        $link 	= $product->add_to_cart_url();

        $label 	= apply_filters('add_to_cart_text', __('Add to cart', 'woocommerce'));

        $link = add_query_arg( 'variation_id', $variation->variation_id, $link );

        foreach ($variation->variation_data as $key => $data) {
            if ($data) $link = add_query_arg( $key, $data, $link );
        }

        printf('<a href="%s" rel="nofollow" data-product_id="%s" class="btn add_to_cart_button product_type_%s">%s</a>', esc_url( $link ), $product->id, $product->product_type, $label);

        ?>

        </p><?php

        return ob_get_clean();

    }
}
endif;
remove_shortcode('add_to_cart');
add_shortcode('add_to_cart', 'afl_woocommerce_product_add_to_cart');
