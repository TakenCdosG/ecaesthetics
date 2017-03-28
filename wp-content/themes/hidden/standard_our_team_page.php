<?php
/**
 * The main template file.
 * Template Name: Standard Our Team Page
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
    <div class="fullwidth bg-header">
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
        <!-- Page-Content -->
        <div class="container page-content radikal_light_small">
            <?php the_post(); ?>
            <?php the_content(); ?>
            <div class="clearfix"></div>
        </div>
        <!-- End Page-Content -->
    </div>
    <!-- Team Members -->
    <!-- US -->
    <?php $orderby = 'menu_order'; ?>
    <?php $order = 'ASC'; ?>
    <?php $wp_query = null; ?>
    <?php $args = array('post_type' => 'team_members', 'posts_per_page' => -1, 'orderby' => $orderby, 'order' => $order, 'meta_key' => 'team_member_location', 'meta_value' => 'US'); ?>
    <?php $wp_query = new WP_Query($args); ?>
    <?php $lenght = $wp_query->post_count; ?>
    <?php $bg = array("bg-shuffle-first", "bg-shuffle-second"); ?>
    <?php $bg_iter = 0; ?>
    <?php $init = 0; ?>
    <?php while ($wp_query->have_posts()): ?>
        <?php $wp_query->the_post(); ?>
        <?php $team_member_qualifications = get_field('team_member_qualifications'); ?>
        <?php $team_member_email = get_field('team_member_email'); ?>
        <?php $team_member_location = get_field('team_member_location'); ?>
        <div class="fullwidth <?php echo $bg[$bg_iter]; ?>">
            <div class="container">
                <div class="row">
                    <?php if ($init == 0): ?>
                        <div class="col-sm-12">
                            <!-- <p class="location"><?php// if ($team_member_location == "US"): ?> United States <?php// else: ?> <?php// echo $team_member_location; ?> <?php// endif; ?></p> -->
                        </div>
                    <?php endif; ?>
                    <div class="col-sm-3">
                        <?php $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                        <?php $imgurl = $src[0]; ?>
                        <div class="post-img-wrapper-details img-thumbnail-detail">
                            <img class="img-responsive" src="<?php echo $imgurl; ?>"  alt="<?php echo $post->post_title ?>" />
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div id="team_rigth">
                            <div class="title_article"> <a href="<?php the_permalink() ?>"><?php echo $post->post_title ?> <?php if (!empty($team_member_qualifications)): ?> <span class="team_member_location"><?php echo $team_member_qualifications; ?> <?php endif; ?></span> </a> </div>
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
        <?php if ($bg_iter == 0): ?>
            <?php $bg_iter = 1; ?>
        <?php else: ?>
            <?php $bg_iter = 0; ?>
        <?php endif; ?>
        <?php $init = $init + 1; ?>
    <?php endwhile; ?>
    <!-- End US -->
    <!-- United Kingdom -->
    <?php $orderby = 'menu_order'; ?>
    <?php $order = 'ASC'; ?>
    <?php $wp_query = null; ?>
    <?php $args = array('post_type' => 'team_members', 'posts_per_page' => -1, 'orderby' => $orderby, 'order' => $order, 'meta_key' => 'team_member_location', 'meta_value' => 'United Kingdom'); ?>
    <?php $wp_query = new WP_Query($args); ?>
    <?php $lenght = $wp_query->post_count; ?>
    <?php $init = 0; ?>
    <?php while ($wp_query->have_posts()): ?>
        <?php $wp_query->the_post(); ?>
        <?php $team_member_qualifications = get_field('team_member_qualifications'); ?>
        <?php $team_member_email = get_field('team_member_email'); ?>
        <?php $team_member_location = get_field('team_member_location'); ?>
        <div class="fullwidth <?php echo $bg[$bg_iter]; ?>">
            <div class="container">
                <div class="row">
                    <?php if ($init == 0): ?>
                        <div class="col-sm-12">
                            <!-- <p class="location"><?php // if ($team_member_location == "US"): ?> United States <?php // else: ?> <?php // echo $team_member_location; ?> <?php // endif; ?></p> -->
                        </div>
                    <?php endif; ?>
                    <div class="col-sm-3">
                        <?php $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                        <?php $imgurl = $src[0]; ?>
                        <div class="post-img-wrapper-details img-thumbnail-detail">
                            <img class="img-responsive" src="<?php echo $imgurl; ?>"  alt="<?php echo $post->post_title ?>" />
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div id="team_rigth">
                            <div class="title_article"> <a href="<?php the_permalink() ?>"><?php echo $post->post_title ?> <?php if (!empty($team_member_qualifications)): ?> <span class="team_member_location"><?php echo $team_member_qualifications; ?> <?php endif; ?></span> </a> </div>
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
        <?php if ($bg_iter == 0): ?>
            <?php $bg_iter = 1; ?>
        <?php else: ?>
            <?php $bg_iter = 0; ?>
        <?php endif; ?>
        <?php $init = $init + 1; ?>
    <?php endwhile; ?>
    <!-- End United Kingdom -->
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
