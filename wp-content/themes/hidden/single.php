<?php
/**
 * The Template for displaying all single posts.

 */
get_header();
?>
<!--container-->
<section id="container">
    <?php if (get_option('afl_breadcrumbs_enable') == 'open'): ?>

        <!--breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="breadcrumb-line">
                    <?php echo get_option('breadcrumbs_text'); ?> <a href="<?php echo home_url(); ?>"><?php echo BREADCRUMBS_HOME_TEXT ?></a><?php echo BREADCRUMBS_DIVIDER ?><a href="<?php if (get_option('show_on_front') == 'page') echo get_permalink(get_option('page_for_posts')); else echo home_url(); ?>"><?php echo BREADCRUMBS_BLOG_TEXT ?></a><?php echo BREADCRUMBS_DIVIDER ?><?php the_title(); ?>
                </div>
            </div>
        </div>

    <?php endif; ?>
    <?php
    $sidebar_pos = get_option('afl_blog_sidebar_position', 'right');
    if ($sidebar_pos != 'none') {
        ?>

        <div class="container">
            <hr class="before-title"/>
        </div>

        <div class="container">
            <div class="row">
                <section id="page-sidebar" class="align<?php echo $sidebar_pos; ?> <?php echo CONTENT_SPAN ?>">
                <?php } ?>
                <?php if ($sidebar_pos == 'none') { ?><div class="container"><?php } ?>
                    <article <?php post_class('blog-post'); ?>>
                        <?php if (get_post_type($post->ID) != 'portfolio') ; //print_blog_info();  ?>
                        <div class="post-wrapper">
                            <div class="post-title-wrapper clearfix">
                                <?php print_post_date(); ?>
                                <?php
                                // Enter your password to view comments.
                                if (!post_password_required()) {
                                    print_post_comments();
                                }
                                ?>
                                <div class="overflowed">
                                    <h3 class="post-title"><?php echo get_the_title(); ?></h3>
                                    <?php print_author(); ?>
                                </div>
                            </div>
                            <?php the_post(); ?>
                            <?php if (has_post_thumbnail() && get_option('show_post_featured') == 'open') { ?>
                                <?php $src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
                                <div class="post-img-wrapper do-media">
                                    <!--                            <a href="--><?php //echo $src[0]        ?><!--" rel="prettyPhoto" title="--><?php //echo $post->post_title        ?><!--">--><?php //the_post_thumbnail('single', array('class' => "attachment-single img-responsive"));        ?><!--</a>-->
                                    <?php the_post_thumbnail('single', array('class' => "attachment-single img-responsive")); ?>
                                    <div class="do-hover">
                                        <a href="<?php echo $src[0] ?>" class="do-img-link-single" data-rel="prettyPhoto" title="<?php echo $post->post_title ?>"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php the_content(); ?><div class="clear"></div>
                            <div class="post-bottom-meta clearfix">
                                <?php
                                print_tags();
                                print_categories();
                                //print_blog_info();
                                edit_post_link('Edit this entry', '', '');
                                ?>
                            </div>

                            <?php wp_link_pages(array('before' => '<p class="post-pager"><strong>Pages:</strong> ', 'after' => '</p>', 'link_before' => '<span>', 'link_after' => '</span>', 'next_or_number' => 'number')); ?>

                            <?php if (get_post_type($post->ID) == 'post' && get_the_author_meta('description') && get_option('display_author_info') == 'open') print_author_info(); ?>
                        </div>
                    </article>
                    <div class="clear"></div>
                    <?php // echo '<hr class="post-divider"/>'; ?>
                    <?php
                    if (!post_password_required()) {
                        comments_template();
                    }
                    ?>
                    <?php if ($sidebar_pos == 'none') { ?></div><?php } ?>
                <?php if ($sidebar_pos != 'none') { ?>
                </section>
                <?php get_sidebar('blog'); ?>
            </div>
            <hr class="small invisible" />
        </div>
    <?php } ?>
</section>

<?php get_footer(); ?>
