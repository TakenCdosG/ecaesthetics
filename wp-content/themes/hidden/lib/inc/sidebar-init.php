<?php

function afl_theme_widgets_init() {

    register_sidebar(array(
        'name' => 'Footer widget 1',
        'id' => 'footer-widget-1',
        'description' => 'Footer - 1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'Footer widget 2',
        'id' => 'footer-widget-2',
        'description' => 'Footer - 2',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'Footer widget 3',
        'id' => 'footer-widget-3',
        'description' => 'Footer - 3',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'Footer widget 4',
        'id' => 'footer-widget-4',
        'description' => 'Footer - 4',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'Side Menu',
        'id' => 'side-menu',
        'description' => 'Side Menu',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}

/** Register sidebars by running afl_theme_widgets_init() on the widgets_init hook. */
add_action('widgets_init', 'afl_theme_widgets_init');