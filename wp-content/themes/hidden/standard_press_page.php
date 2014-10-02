<?php
/**
 * The main template file.
 * Template Name: Standard Press Page
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
        <!-- Hide -->
        <div class="container page-content radikal_light_small">
            <?php the_post(); ?>
            <?php the_content(); ?>
            <div class="clearfix"></div>
        </div>
        <!-- End Hide -->
    </div>
    <?php //$paged = isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 1; ?>
    <?php
    if (get_query_var('paged')) {
        $paged = get_query_var('paged');
    } elseif (get_query_var('page')) {
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }
    ?>
    <?php query_posts('post_type=press&paged=' . $paged); ?>
    <?php if (have_posts()) : ?>
        <?php /* Start the Loop */ ?>
        <?php get_template_part('loop', 'blog'); ?>
        <?php if (function_exists('afl_pager')): ?>
            <?php echo afl_pager(); ?>
        <?php else: ?>
            <div id="posts_navigation">
                <span id="nextlink">
                    <?php next_posts_link('&laquo; prev ' . get_option('wp_olderentries')); ?>
                </span>
                <span id="previouslink">
                    <?php previous_posts_link(get_option('wp_newerentries') . ' next &raquo;'); ?>
                </span></div>';
        <?php endif; ?>
    <?php endif; // end have_posts() check   ?>
</section>
<?php get_footer(); ?>
