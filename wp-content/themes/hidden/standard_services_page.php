<?php
/**
 * The main template file.
 * Template Name: Standard Services Page
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
    <?php $args = array('post_type' => 'services', 'posts_per_page' => -1, 'orderby' => $orderby, 'order' => $order); ?>
    <?php $wp_query = new WP_Query($args); ?>
    <?php $lenght = $wp_query->post_count; ?>
    <?php $bg = array() ?>
    <?php $bg["#849da3"] = "#f3f3f3"; ?>
    <?php $bg["#a9babe"] = "#ffffff"; ?>
    <?php $bg["#cbd6d8"] = "#7d979d"; ?>
    <?php $bg["#7b736b"] = "#f3f3f3"; ?>
    <?php $bg["#d0cac5"] = "#7b736b"; ?>
    <?php $bg["#dfdbd9"] = "#7b736b"; ?>
    <?php $bg["#f8f8f8"] = "#9aacb0"; ?>
    <?php $bg_iter = 0; ?>
    <?php $init = 0; ?>
    <?php while ($wp_query->have_posts()): ?>
        <?php $wp_query->the_post(); ?>
        <?php $color_associated = get_field('color_associated'); ?>
        <div class="fullwidth <?php echo $bg[$bg_iter]; ?>" style="background:<?php echo $color_associated; ?>">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="service_title">
                            <div class="title_article">
                                <a href="<?php the_permalink() ?>" style="color:<?php if (isset($bg["$color_associated"])): ?><?php echo $bg["$color_associated"]; ?><?php else: ?>#fff<?php endif; ?>;"> <?php echo $post->post_title ?> 
                                </a> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    <!-- End Team Members --> 
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
