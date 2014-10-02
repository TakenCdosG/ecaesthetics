<?php
/**
 * The main template file.
 * Template Name: Locations Page
 *
 */
get_header();
?>
<!--container-->
<section id="container">
    <section class="container">
        <div id="" class="fullwidth no-sidebar ">
            <?php $str = '[google-map-v3 shortcodeid="TO_BE_GENERATED_NEW" width="100%" height="350" zoom="16" maptype="roadmap" mapalign="center" directionhint="false" language="default" poweredby="false" maptypecontrol="true" pancontrol="true" zoomcontrol="true" scalecontrol="true" streetviewcontrol="true" scrollwheelcontrol="false" draggable="true" tiltfourtyfive="false" enablegeolocationmarker="false" enablemarkerclustering="false" addmarkermashup="false" addmarkermashupbubble="false" addmarkerlist="261 E 78th Street #2 New York, NY 10075{}1-default.png" bubbleautopan="true" distanceunits="miles" showbike="false" showtraffic="false" showpanoramio="false"]'; ?>
            <?php echo do_shortcode($str); ?>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <?php $cur_id = get_queried_object_id(); /* Title */ ?>
            <?php $pageTitle = get_post_meta($cur_id, 'pageTitle', true); ?>
            <?php $pageSlogan = get_post_meta($cur_id, 'pageSlogan', true); ?>
            <div class="col-sm-12">
                <div class="before-title"></div>
                <div class="title-divider clearfix">
                    <h1 class="page-title">
                        <?php // title ?>
                        <?php if ($pageTitle): ?>
                            <?php echo $pageTitle; ?>
                        <?php else: ?>
                            <?php echo get_the_title($cur_id); ?>
                        <?php endif ?>
                    </h1>
                    <div class="clearfix visible-xs"></div>
                    <?php // slogan ?>
                    <?php if ($pageSlogan): ?> 
                        <small class="page-title-small"> <?php echo $pageSlogan; ?> </small>
                    <?php endif; ?> 
                </div>
                <div class="after-title"></div>
            </div>
        </div>
    </div>
    <div class="container page-content">
        <?php the_post(); ?>
        <?php the_content(); ?>
        <div class="clearfix"></div>
    </div>
    <div class="container page-testimonials">
        <div class="testimonials-content-excerpt">
            <?php $orderby = 'menu_order'; ?>
            <?php $order = 'ASC'; ?>
            <?php $wp_query = null; ?>
            <?php $args = array('post_type' => 'testimonials', 'posts_per_page' => -1, 'orderby' => $orderby, 'order' => $order); ?>
            <?php $wp_query = new WP_Query($args); ?>
            <?php $lenght = $wp_query->post_count; ?>
            <?php $key = rand(0, $lenght - 1); ?>
            <?php $post_rand = $wp_query->posts[$key]; ?>
            <?php $post_id = $post_rand->ID; ?>
            <?php $post_excerpt = $post_rand->post_excerpt; ?>
            <?php $post_content = $post_rand->post_content; ?>
            <?php if (!empty($post_content)): ?>
                <?php echo '"' ?> <?php echo wp_trim_words($post_content, 28, '...'); ?> <?php echo '"' ?>
            <?php else: ?>
                <?php echo wp_trim_words($post_excerpt, 28, '...'); ?>
            <?php endif; ?>

            <a class="read-full" href="<?php echo get_permalink($post_id) ?>">Read full testimonial</a>
        </div>
        <?php $author = get_field('testimonial_author', $post_id); ?>
        <?php if (!empty($author)): ?>
            <div class="testimonials-content-author">
                -<?php echo $author; ?>
            </div>
        <?php endif; ?>
        <div class="clearfix"></div>
    </div>
</section>
<?php get_footer(); ?>
