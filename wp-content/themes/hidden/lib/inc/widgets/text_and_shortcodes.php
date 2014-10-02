<?php
class MY_Text_And_ShortcodesWidget extends WP_Widget {
    /** constructor */
    function MY_Text_And_ShortcodesWidget() {
        parent::WP_Widget(false, $name = 'Text and shortcodes');
    }

  /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		$content = apply_filters('widget_content', $instance['content']);
				
        ?>
              <?php echo $before_widget; ?>
              	<?php if (!empty($title)) {?><?php echo $before_title.$title.$after_title; ?><?php } ?>
                <?php echo do_shortcode($content); ?>

                        <?php wp_reset_query(); ?>

              <?php echo $after_widget; ?>

        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        if(!empty($instance['title'])){
            $title = esc_attr($instance['title']);
        } else {
            $title = "";
        }
        if(!empty($instance['content'])){
            $content = esc_attr($instance['content']);
        } else {
            $content = "";
        }
			
        ?>
      <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'afl'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

      <p><label for="<?php echo $this->get_field_id('content'); ?>"><?php _e('Content:', 'afl'); ?> <textarea class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" ><?php echo $content; ?></textarea></label></p>
			
			
        <?php 
    }

} // class  Widget
?>