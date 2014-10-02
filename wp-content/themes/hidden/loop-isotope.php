<section id="page-sidebar" class="isotope">
    <?php

    $temp = $wp_query;
    $wp_query = null;
    $paged = isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 1;
    $args = array(
        //'posts_per_page' => 3,
        'post_type' => 'post',
        'paged' => $paged
    );
    $wp_query = new WP_Query($args);

    if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); /* excluded products from search results */
        $i = 0;
        $i++; ?>
        <article <?php post_class('blog-post col-sm-4 isotope-item'); ?> id="post-<?php the_ID(); ?>">
            <div class="post-wrapper">
                <div class="post-title-wrapper clearfix">
                    <?php print_post_date(); ?>
                    <?php print_post_comments(); ?>
                    <div class="overflowed">
                        <h3 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                        <?php print_author(); ?>
                    </div>
                </div>
                <?php $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                <?php if (has_post_thumbnail()) { ?>
                    <div class="post-img-wrapper do-media">
                        <?php
                        $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                        if (has_post_thumbnail()):
                            $imgurl = $src[0];
                            the_post_thumbnail('blog_img', array('class' => 'img-responsive'));
                        else:
                            $imgurl = $blogimageurl;
                            echo '<img src="' . $imgurl . '"  alt="' . $post->post_title . '" />';
                        endif
                        ?>
                        <div class="do-hover">
                            <a href="<?php echo $imgurl ?>" class="do-img-link" data-rel="prettyPhoto"><i class="fa fa-search"></i></a>
                            <a href="<?php the_permalink() ?>" class="do-url-link"><i class="fa fa-link"></i></a>
                        </div>
                    </div>
                <?php } ?>
                <?php the_excerpt(); ?>
                <div class="clearfix"></div>
                <div class="post-bottom-meta clearfix">
                    <?php
                    afl_print_continue_reading_link();
                    print_tags();
                    print_categories();
                    ?>
                </div>
                <?php
                if ('portfolio' == get_post_type()) {
                    if (function_exists('zilla_likes')) zilla_likes();
                }
                ?>
            </div>
            <?php
            if (($wp_query->current_post + 1) != $wp_query->post_count)
                echo '<hr class="post-divider" />';
            else
                echo '<hr class="invisible" />';?>
        </article>
    <?php endwhile; ?>
    <?php else : ?>
        <h2 class="blog-title">Not Found</h2>
    <?php endif; ?>

</section>

<?php
if (have_posts()) {
    if (function_exists('afl_pager')) {
        echo afl_pager();
    } else {
        echo '<div id="posts_navigation"><span id="nextlink">';
        next_posts_link('&laquo; prev ' . get_option('wp_olderentries'));
        echo '</span><span id="previouslink">';
        previous_posts_link(get_option('wp_newerentries') . ' next &raquo;');
        echo '</span></div>';
    }
}
?>

<?php
$wp_query = null;
$wp_query = $temp;
wp_reset_query();
?>

<div class="clear"></div>
