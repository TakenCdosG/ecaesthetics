<?php
/**
 * The Template for displaying all single portfolio posts.
 */

get_header(); ?>
<!--container-->
<section id="container">

    <?php if (get_option('afl_breadcrumbs_enable') == 'open'): ?>

        <!--breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="breadcrumb-line">
                    <?php echo get_option('breadcrumbs_text'); ?>
                    <a href="<?php echo home_url(); ?>"><?php echo BREADCRUMBS_HOME_TEXT ?></a><?php echo BREADCRUMBS_DIVIDER ?>
                    <a href="<?php if (get_option('show_on_front') == 'page') echo get_permalink(get_option('page_for_posts')); else echo home_url(); ?>"><?php echo BREADCRUMBS_BLOG_TEXT ?></a><?php echo BREADCRUMBS_DIVIDER ?><?php the_title(); ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <div class="container">
        <hr class="before-title"/>
    </div>

    <div class="container">
        <div class="row">
            <section id="page-sidebar" class="col-sm-12">
                <article <?php post_class('blog-post'); ?>>
                    <div class="post-wrapper">
                        <div class="row">
                            <div class="col-sm-6 col-md-8">
                                <h3 class="post-heading"><?php echo get_the_title(); ?></h3>
                                <?php $src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
                                <div class="post-img-wrapper single-portfolio do-media">
                                    <?php the_post_thumbnail('single', array('class' => "attachment-single img-responsive")); ?>
                                    <div class="do-hover">
                                        <a href="<?php echo $src[0] ?>" class="do-img-link-single" data-rel="prettyPhoto" title="<?php echo $post->post_title ?>"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <?php // previous/next link
                                if (have_posts()) {
                                    while (have_posts()) {
                                        the_post();
                                        //previous_post_link();
                                        previous_post_link('%link', 'Previous');
                                        next_post_link('%link', 'Next');
                                    } // end while
                                } // end if
                                ?>
                                <hr class="mini invisible"/>
                                <?php the_post(); ?>
                                <?php the_content(); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="clear"></div>
                                <?php edit_post_link('Edit this entry', '', '.'); ?>
                                <?php wp_link_pages(array('before' => '<p class="post-pager"><strong>Pages:</strong> ', 'after' => '</p>', 'link_before' => '<span>', 'link_after' => '</span>', 'next_or_number' => 'number')); ?>
                            </div>
                        </div>
                    </div>
                </article>
                <div class="clear"></div>
                <?php
                //comments_template();
                $clonePost = $post;
                ?>
            </section>
        </div>
        <hr class="small invisible"/>
    </div>

    <?php // latest portfolio
    $atts['number'] = 8;
    echo afl_recent_projects($atts);
    ?>

    <?php  $post = $clonePost; ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php
                comments_template();
                if (
                    (!have_comments() && comments_open() && get_option('default_comment_status') == 'open') ||
                    (!have_comments() && !comments_open() && get_option('default_comment_status') == 'open') ||
                    (have_comments() && comments_open() && get_option('default_comment_status') == 'open')
                ) {
                    echo '<hr class="small invisible"/>';
                } else {
                    if (!have_comments()) {
                        echo '<hr class="small invisible"/>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

</section>

<?php get_footer(); ?>
