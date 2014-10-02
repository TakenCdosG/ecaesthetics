<?php
class MY_RecentPostsWidget extends WP_Widget
{
    /** constructor */
    function MY_RecentPostsWidget()
    {
        parent::WP_Widget(false, $name = 'Recent Posts with thumbnails');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $number = apply_filters('widget_post_number', $instance['number']);
        $excerpt_length = apply_filters('widget_post_excerpt_length', (isset($instance['excerpt_length'])) ? $instance['excerpt_length'] : 130);
        ?>
        <?php echo $before_widget; ?>
        <section class="post-widget">
            <?php echo $before_title . $title . $after_title; ?>
            <?php
            global $wpdb;
            $request = "SELECT * FROM $wpdb->posts";
            $request .= " WHERE post_status = 'publish' and post_type = 'post'";
            $request .= "ORDER BY post_date*(-1)  LIMIT $number";
            $posts = $wpdb->get_results($request); ?>
            <ul class="clearfix post-widget">
                <?php

                if ($posts) {
                    foreach ($posts as $post) {
                        $post_title = stripslashes($post->post_title);
                        $post_content = afl_strEx(stripslashes($post->post_excerpt), $excerpt_length);
                        $comment_count = $post->comment_count;
                        $permalink = get_permalink($post->ID);
                        $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                        ?>

                        <li class="clearfix">
                            <?php
                            $image = wp_get_attachment_image(get_post_thumbnail_id($post->ID), 'recent-post-thumbnail');
                            if ($image == null) { /* check if image exists */
                                echo '<span class="pimg"><img src="' . get_template_directory_uri() . '/images/blank-sidebar-90x80.jpg" alt="no image" /><span>';
                            } else {
                                echo '<a href="' . $src[0] . '" data-rel="prettyPhoto" class="pimg">' . $image . '</a>';
                            }
                            ?>
                            <a class="ptitle" href="<?php echo $permalink ?>" title="<?php echo $post_title ?>"><?php echo $post_title ?></a>
                            <span class="pdate"><?php the_time('M j, Y'); ?></span>
                            <?php //echo '<span class="ptxt">'.$post_content.'</span>'; ?>
                            <a class="pcomm" href="<?php echo $permalink; ?>#comments"><i class="fa fa-comment"></i> <?php echo $comment_count; ?></a>

                            <div class="clear"></div>
                        </li>
                    <?php
                    }
                } else {
                    ?>
                    <li> "None found"</li>
                <?php } ?>
            </ul>
            <?php wp_reset_query(); ?>
        </section>
        <?php echo $after_widget; ?>

    <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance)
    {
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance)
    {
        if(!empty($instance['title'])){
            $title = esc_attr($instance['title']);
        } else {
            $title = "";
        }
        if(!empty($instance['number'])){
            $number = esc_attr($instance['number']);
        } else {
            $number = "";
        }
        if(!empty($instance['excerpt_lenght'])){
            $excerpt_lenght = esc_attr($instance['excerpt_lenght']);
        } else {
            $excerpt_lenght = "";
        }

        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'afl'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/></label>
        </p>
        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:', 'afl'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>"/></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('excerpt_lenght'); ?>"><?php _e('Post excerpt length(symbols):', 'afl'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('excerpt_lenght'); ?>" name="<?php echo $this->get_field_name('excerpt_lenght'); ?>" type="text" value="<?php echo $excerpt_lenght; ?>"/></label>
        </p>

    <?php
    }

} // class  Widget
?>
