<?php
get_header();
?>
<section id="container">
    <?php if (!is_home() && !is_front_page() && get_option('afl_breadcrumbs_enable') == 'open'): ?>

        <!--breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="breadcrumb-line">
                    <?php echo get_option('breadcrumbs_text'); ?> <a href="<?php echo home_url(); ?>"><?php echo BREADCRUMBS_HOME_TEXT ?></a><?php echo BREADCRUMBS_DIVIDER ?><?php the_title(); ?>
                </div>
            </div>
        </div>

    <?php endif; ?>
    <?php if (has_post_thumbnail()): ?>
        <section class="container">
            <div id="" class="flexslider fullwidth no-sidebar ">
                <ul class="slides">
                    <li style="display: list-item;">
                        <?php $src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID(), array(1300, 410)), 'full'); ?>
                        <?php the_post_thumbnail($size = "post-full"); ?>
                        <!--<img src="<?php echo $src[0]; ?>" alt="">-->
                    </li>
                </ul>
            </div>
        </section>
    <?php endif; ?> 
    <div class="container">
        <div class="row">
            <?php
            $cur_id = get_queried_object_id(); /* Title */
            $pageTitle = get_post_meta($cur_id, 'pageTitle', true);
            $pageSlogan = get_post_meta($cur_id, 'pageSlogan', true);
            ?>
            <div class="col-sm-12">
                <div class="title-divider clearfix">
                    <h1 class="page-title">
                        <?php
                        // title
                        if ($pageTitle): echo $pageTitle;
                        else: echo get_the_title($cur_id);
                        endif
                        ?>
                    </h1>
                    <div class="clearfix visible-xs"></div>
                    <?php
                    // slogan
                    if ($pageSlogan): echo '<small class="page-title-small">' . $pageSlogan . '</small>';
                    endif;
                    ?>
                </div>
                <hr class="after-title"/>
            </div>
        </div>
    </div>

    <?php
    $page_sidebar = get_page_sidebar_settings($post->ID);
    $sidebar = !empty($page_sidebar['sidebar_position']) && $page_sidebar['sidebar_position'] != 'none';
    if (have_posts()) : while (have_posts()) : the_post();
            if ($sidebar) {
                ?>
                <div class="container">
                    <div class="row sidebar-<?php echo $page_sidebar['sidebar_position']; ?>">
                        <section id="page-sidebar" class="align<?php echo $page_sidebar['sidebar_position']; ?> <?php echo CONTENT_SPAN ?>">
                        <?php } ?>

                        <?php
                        //if the post has a parent
                        if ($post->post_parent) {
                            //collect ancestor pages
                            $relations = get_post_ancestors($post->ID);
                            //get child pages
                            $result = $wpdb->get_results("SELECT ID FROM wp_posts WHERE post_parent = $post->ID AND post_type='page'");
                            if ($result) {
                                foreach ($result as $pageID) {
                                    array_push($relations, $pageID->ID);
                                }
                            }
                            //add current post to pages
                            array_push($relations, $post->ID);
                            //get comma delimited list of children and parents and self
                            $relations_string = implode(",", $relations);
                            //use include to list only the collected pages.
                            $sidelinks = wp_list_pages("title_li=&echo=0&include=" . $relations_string);
                        } else {
                            // display only main level and children
                            $sidelinks = wp_list_pages("title_li=&echo=0&depth=1&child_of=" . $post->ID);
                        }
                        if ($sidelinks) {
                            echo '<div class="container"><div class="row"><div class="col-sm-12"><ul class="parent">';
                            //links in <li> tags
                            echo $sidelinks;
                            echo '</ul><hr class="small"/></div></div></div>';
                        }

                        if (get_post_meta($post->ID, 'afl_composer', true) == 'on') {
                            $items = afl_get_te_data($post->ID);
                            print(do_shortcode(afl_to_shortcode($items)));
                            if (!$sidebar) {
                                echo '<div class="container">';
                            }

                            comments_template();
                            if (!$sidebar) {
                                echo '</div>';
                            }
                        } else {
                            ?>
                            <?php if (!$sidebar) { ?><div class="container page-content"><?php } ?>

                                <?php the_content(); ?><div class="clearfix"></div>
                                <?php wp_link_pages(array('before' => '<p class="post-pager"><strong>Pages: </strong> ', 'after' => '</p>', 'link_before' => '<span>', 'link_after' => '</span>', 'next_or_number' => 'number')); ?>
                                <?php comments_template(); ?>
                                <?php if (!$sidebar) { ?></div><?php } ?>
                        <?php } ?>
                        <?php if ($sidebar) { ?>
                        </section>
                        <?php get_sidebar(); ?>
                    </div>
                </div>
            <?php } ?>
        <?php endwhile; ?>
    <?php endif; ?>
</section>
<?php get_footer(); ?>
