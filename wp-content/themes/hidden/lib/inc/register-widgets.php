<?php
/*
 * Loads up all the widgets defined by this theme. Note that this function will not work for versions of WordPress 2.7 or lower
 *
 */
include_once (get_template_directory().'/lib/inc/widgets/text_and_shortcodes.php');
include_once (get_template_directory().'/lib/inc/widgets/popular_posts.php');
include_once (get_template_directory().'/lib/inc/widgets/my_recent_posts.php');
include_once (get_template_directory().'/lib/inc/widgets/tabs.php');
add_action("widgets_init", "load_my_widgets");

function load_my_widgets() {
	register_widget("MY_Text_And_ShortcodesWidget");
	register_widget("MY_PopularPostsWidget");
	register_widget("MY_RecentPostsWidget");
	
}
