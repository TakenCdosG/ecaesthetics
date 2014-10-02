<!--sidebar-->
<aside id="sidebar" class="alignright <?php echo SIDEBAR_SPAN ?>">
    <?php
    $sidebar = get_option('afl_blog_sidebar');
    if (!in_array($sidebar, array('default', ''))) { dynamic_sidebar($sidebar); } else {
        ?>
        <section class="widget">
            <h3 class="widget-title">Pages</h3>
            <ul class="ul-list clearfix">
                <?php wp_list_pages($args = array(
                    'depth' => 0,
                    'show_date' => '',
                    'date_format' => get_option('date_format'),
                    'child_of' => 0,
                    'exclude' => '',
                    'include' => '',
                    'title_li' => '',
                    'echo' => 1,
                    'authors' => '',
                    'sort_column' => 'menu_order, post_title',
                    'link_before' => '',
                    'link_after' => '',
                    'walker' => '',
                    'post_type' => 'page',
                    'post_status' => 'publish'
                )); ?>
            </ul>
        </section>
        <section class="widget">
            <h3 class="widget-title">Archives</h3>
            <ul class="ul-list clearfix">
                <?php wp_get_archives('type=monthly'); ?>
            </ul>
        </section>
        <section class="widget">
            <h3 class="widget-title">Categories</h3>
            <ul class="ul-list clearfix">
                <?php wp_list_categories($args = array(
                    'show_option_all' => '',
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'style' => 'list',
                    'show_count' => 0,
                    'hide_empty' => 1,
                    'use_desc_for_title' => 1,
                    'child_of' => 0,
                    'feed' => '',
                    'feed_type' => '',
                    'feed_image' => '',
                    'exclude' => '',
                    'exclude_tree' => '',
                    'include' => '',
                    'hierarchical' => 1,
                    'title_li' => '',
                    'show_option_none' => __('No categories'),
                    'number' => null,
                    'echo' => 1,
                    'depth' => 0,
                    'current_category' => 0,
                    'pad_counts' => 0,
                    'taxonomy' => 'category',
                    'walker' => null
                )); ?>
            </ul>
        </section>
        <section class="widget">
            <h3 class="widget-title">Meta</h3>
            <ul class="ul-list clearfix">
                <?php wp_register(); ?>
                <li><?php wp_loginout(); ?></li>
                <li><a href="http://wordpress.org/"
                       title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a>
                </li>
                <?php wp_meta(); ?>
            </ul>
        </section>
        <section class="widget">
            <h3 class="widget-title">Subscribe</h3>
            <ul class="ul-list clearfix">
                <li><a href="<?php bloginfo('rss2_url'); ?>">Entries (RSS)</a></li>
                <li><a href="<?php bloginfo('comments_rss2_url'); ?>">Comments (RSS)</a></li>
            </ul>
        </section>
    <?php } ?>
</aside>
