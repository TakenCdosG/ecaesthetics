<?php
/**
 * The main template file.
 * Template Name: Blog Isotope
 */

get_header(); ?>

<!--container-->
<section id="container">

    <?php if (!is_front_page() && get_option('afl_breadcrumbs_enable') == 'open'): ?>
        <!--breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="breadcrumb-line">
                    <?php echo get_option('breadcrumbs_text'); ?>
                    <a href="<?php echo home_url(); ?>"><?php echo BREADCRUMBS_HOME_TEXT ?></a><?php echo BREADCRUMBS_DIVIDER . BREADCRUMBS_BLOG_TEXT ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="container">
        <div class="row">
            <?php
            $cur_id = get_queried_object_id(); /* Title */
            $pageTitle = get_post_meta($cur_id, 'pageTitle', true);
            $pageSlogan = get_post_meta($cur_id, 'pageSlogan', true);
            ?>
            <div class="col-sm-12">
                <hr class="before-title"/>
                <div class="title-divider clearfix">
                    <h1 class="page-title">
                        <?php // title
                        if ($pageTitle): echo $pageTitle;
                        else: echo get_the_title($cur_id); endif ?>
                    </h1>
                    <div class="clearfix visible-xs"></div>
                    <?php // slogan
                    if ($pageSlogan): echo '<small class="page-title-small">' . $pageSlogan . '</small>'; endif; ?>
                </div>
                <hr class="after-title"/>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <?php get_template_part('loop', 'isotope'); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
