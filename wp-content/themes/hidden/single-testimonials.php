<?php
/**
 * The Template for displaying all single testimonials.

 */
get_header();
?>
<!--container-->
<?php $header_image_product = get_field('header_image_product'); ?>
<section id="container">
    <?php if (!empty($header_image_product)): ?>
        <section class="container">
            <div id="" class="flexslider fullwidth no-sidebar ">
                <ul class="slides">
                    <li style="display: list-item;">
                        <?php $src = $header_image_product; ?>
                        <img src="<?php echo $src ?>" alt="">
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
</section>
<?php get_footer(); ?>
