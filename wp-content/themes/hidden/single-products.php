<?php
/**
 * The Template for displaying all single products.

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
    <!-- Buckets -->
    <div class="fullwidth bg-buckets">
        <?php $post_home_id = 37; ?>
        <?php $first_bucket_post_id = get_field('first_bucket', $post_home_id); ?>
        <?php $first_bucket_post_id = isset($first_bucket_post_id[0]) ? $first_bucket_post_id[0] : $first_bucket_post_id; ?>
        <?php $second_bucket_post_id = get_field('second_bucket', $post_home_id); ?>
        <?php $second_bucket_post_id = isset($second_bucket_post_id[0]) ? $second_bucket_post_id[0] : $second_bucket_post_id; ?>
        <?php $third_bucket_post_id = get_field('third_bucket', $post_home_id); ?>
        <?php $third_bucket_post_id = isset($third_bucket_post_id[0]) ? $third_bucket_post_id[0] : $third_bucket_post_id; ?>
        <div class="container">
            <div class="row">
                <!-- First Bucket Data -->
                <?php $first_bucket_background_image = get_field('bucket_background_image', $first_bucket_post_id); ?>
                <?php $first_bucket_content = get_field('bucket_content', $first_bucket_post_id); ?>
                <?php $first_bucket_show_only_the_background_image = get_field('show_only_the_background_image', $first_bucket_post_id); ?>
                <?php $first_bucket_title = get_the_title($first_bucket_post_id); ?>
                <div class="col-xs-4 col-md-4 without-margin-right bucket_item without-margin-left-md">
                    <?php if ($first_bucket_show_only_the_background_image == 1): ?>
                        <img src="<?php echo $first_bucket_background_image ?>" alt="<?php echo $first_bucket_title; ?>" class="img-responsive img-full">
                    <?php else: ?>
                        <div class="widget_bgimage">
                            <div class="image">
                                <img src="<?php echo $first_bucket_background_image ?>" alt="<?php echo $first_bucket_title; ?>" class="img-responsive img-full">
                            </div>
                            <div class="content_widget_bgimage">
                                <div class="tile">
                                    <a href="#">   
                                        <?php echo $first_bucket_title ?>
                                    </a>
                                </div>
                                <div class="text">
                                    <?php echo $first_bucket_content ?>             
                                </div>
                            </div>
                        </div>   
                    <?php endif; ?>
                </div>
                <!-- End First Bucket Data -->
                <!-- Second Bucket Data -->
                <?php $second_bucket_background_image = get_field('bucket_background_image', $second_bucket_post_id); ?>
                <?php $second_bucket_content = get_field('bucket_content', $second_bucket_post_id); ?>
                <?php $second_bucket_show_only_the_background_image = get_field('show_only_the_background_image', $second_bucket_post_id); ?>
                <?php $second_bucket_title = get_the_title($second_bucket_post_id); ?>
                <div class="col-xs-4 col-md-4 without-margin-left without-margin-right bucket_item">
                    <?php if ($second_bucket_show_only_the_background_image == 1): ?>
                        <img src="<?php echo $second_bucket_background_image ?>" alt="<?php echo $second_bucket_title; ?>" class="img-responsive img-full">
                    <?php else: ?>
                        <div class="widget_bgimage">
                            <div class="image">
                                <img src="<?php echo $second_bucket_background_image ?>" alt="<?php echo $second_bucket_title; ?>" class="img-responsive img-full">
                            </div>
                            <div class="content_widget_bgimage">
                                <div class="tile">
                                    <a href="#">   
                                        <?php echo $second_bucket_title ?>
                                    </a>
                                </div>
                                <div class="text">
                                    <?php echo $second_bucket_content ?>             
                                </div>
                            </div>
                        </div>   
                    <?php endif; ?>
                </div>
                <!-- End Second Bucket Data -->
                <!-- Third Bucket Data -->
                <?php $third_bucket_background_image = get_field('bucket_background_image', $third_bucket_post_id); ?>
                <?php $third_bucket_content = get_field('bucket_content', $third_bucket_post_id); ?>
                <?php $third_bucket_show_only_the_background_image = get_field('show_only_the_background_image', $third_bucket_post_id); ?>
                <?php $third_bucket_title = get_the_title($third_bucket_post_id); ?>
                <div class="col-xs-4 col-md-4 without-margin-left without-margin-right bucket_item">
                    <?php if ($third_bucket_show_only_the_background_image == 1): ?>
                        <img src="<?php echo $third_bucket_background_image ?>" alt="<?php echo $third_bucket_title; ?>" class="img-responsive img-full">
                    <?php else: ?>
                        <div class="widget_bgimage">
                            <div class="image">
                                <img src="<?php echo $third_bucket_background_image ?>" alt="<?php echo $third_bucket_title; ?>" class="img-responsive img-full">
                            </div>
                            <div class="content_widget_bgimage">
                                <div class="tile">
                                    <a href="#">   
                                        <?php echo $third_bucket_title ?>
                                    </a>
                                </div>
                                <div class="text">
                                    <?php echo $third_bucket_content ?>             
                                </div>
                            </div>
                        </div>   
                    <?php endif; ?>
                </div>
                <!-- End Third Bucket Data -->
            </div>
        </div>
    </div>
    <!-- End Buckets -->
</section>
<?php get_footer(); ?>
