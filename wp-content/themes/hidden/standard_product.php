<?php
/**
 * The main template file.
 * Template Name: Standard Product Page
 *
 */
get_header();
?>
<!--container-->
<section id="container">
    <?php if (has_post_thumbnail()): ?>
        <section class="container">
            <div id="" class="flexslider fullwidth no-sidebar ">
                <ul class="slides">
                    <li style="display: list-item;">
                        <?php $src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
                        <img src="<?php echo $src[0] ?>" alt="">
                    </li>
                </ul>
            </div>
        </section>
    <?php endif; ?> 
    <div class="fullwidth">
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
        <div class="container page-content radikal_light_small">
            <?php the_post(); ?>
            <?php the_content(); ?>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- Team Members -->
    <?php $orderby = 'menu_order'; ?>
    <?php $order = 'ASC'; ?>
    <?php $wp_query = null; ?>
    <?php $args = array('post_type' => 'products', 'posts_per_page' => -1, 'orderby' => $orderby, 'order' => $order); ?>
    <?php $wp_query = new WP_Query($args); ?>
    <?php $lenght = $wp_query->post_count; ?>
    <?php $bg = array("#e3dbd5", "#cec9c4", "#a9babe", "#cbd6d8"); ?>
    <?php $bg_iter = 0; ?>
    <?php while ($wp_query->have_posts()): ?>
        <?php $wp_query->the_post(); ?>
        <?php $location_product = get_field('location_product'); ?>
        <div class="fullwidth" style="background:<?php echo $bg[$bg_iter]; ?>">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="product-location"><?php echo $team_member_location; ?> </p>
                    </div>
                    <div class="col-sm-3">
                        <?php $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                        <?php $imgurl = $src[0]; ?>
                        <div class="post-img-wrapper-details img-thumbnail-detail">
                            <img class="img-responsive" src="<?php echo $imgurl; ?>"  alt="<?php echo $post->post_title ?>" />
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="product_rigth">
                            <div class="title_article"> 
                                <a class="title_product" href="<?php the_permalink() ?>"><?php echo $post->post_title ?>  </a>
                                <?php if (!empty($location_product)): ?><span class="product_location"><?php echo $location_product; ?> <?php endif; ?></span>
                            </div>
                            <div class="description_article" class="radikal_light_team"> 
                                <?php $post_excerpt = $post->post_excerpt; ?>
                                <?php if (!empty($post_excerpt)): ?>
                                    <?php echo $post_excerpt; ?>
                                <?php else: ?>
                                    <?php the_content(); ?>
                                <?php endif; ?>
                            </div>
                            <div class="read-more">
                                <a href="<?php the_permalink() ?>">Learn more <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php $bg_iter = $bg_iter + 1; ?>
        <?php if ($bg_iter > 3): ?>
            <?php $bg_iter = 0; ?>
        <?php endif; ?>
    <?php endwhile; ?>
    <!-- End Team Members -->
</section>
<?php get_footer(); ?>
