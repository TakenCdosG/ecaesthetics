<?php
// theme options
$__OPTIONS = array(
	'blogname' => array(
        'weight' => 0,
        'type' => 'text', //input text
        'default_value' =>get_option('blogname'),
        'attributes' => array(
            'class' => 'regular-text'
        ),
		'description' => 'Site Title is used inside &lt;title&gt;&lt;/title&gt; tags and usually showed on the top of the browser',
        'label' => 'Site Title'
    ),
    'afl_logo' => array(
        'weight' => 0,
        'type' => 'text', //input text
        'default_value' => get_option('afl_logo'),
        'attributes' => array(
            'class' => 'regular-text'
        ),
		'description' => 'Select the logo image for your site. Note: when you select logo image "Logo text" is not shown',
        'label' => 'Logo image',
        'uploadable' => true
    ),
    'logo_text' => array(
        'weight' => 1,
        'type' => 'text',
        'label' => 'Logo text',
		'description' => 'The first part of Logo text. Shown if no Logo image selected',
        'default_value' => get_option('logo_text', get_option('blogname')),
    ),
	'tagline' => array(
		'weight' => 0,
		'type' => 'text', //input text
		'default_value' => get_option('tagline'),
		'attributes' => array(
			'class' => 'regular-text'
		),
		'description' => 'Shown under the logo',
		'label' => 'Tagline'
	),
    'top_contact_text' => array(
        'weight' => 0,
        'type' => 'text', //input text
        'default_value' => get_option('top_contact_text', 'Call Us: +1 101 23 45 678'),
        'attributes' => array(
            'class' => 'regular-text'
        ),
        'description' => 'Your contacts to be displayed in header.',
        'label' => 'Header contact text'
    ),
    'afl_favicon' => array(
        'weight' => 2,
        'type' => 'text', //input text
        'default_value' => get_option('afl_favicon'),
        'attributes' => array(
            'class' => 'regular-text'
        ),
		'description' => '.ico/.gif/.png file to be used as favicon for your site',
        'label' => 'Favicon',
        'uploadable' => true
    ),
    'admin_email' => array(
        'weight' => 4,
        'type' => 'text',
        'default_value' => get_option('admin_email'),
        'attributes' => array(
            'class' => 'regular-text'
        ),
		'description' => 'Email address to be used for all the Contact Form letters',
        'label' => 'Admin email'
    ),
	'afl_breadcrumbs_enable' => array(
		'weight' => 1,
		'type' => 'checkbox',
		'description' => 'Show Breadcrumbs',
		'label' => 'Show Breadcrumbs',
		'default_value' => get_option('afl_breadcrumbs_enable','open')
	),
	'breadcrumbs_text' => array(
		'weight' => 0,
		'type' => 'text', //input text
		'default_value' => get_option('breadcrumbs_text', 'You are here: '),
		'attributes' => array(
			'class' => 'regular-text'
		),
		'description' => 'Breadcrumbs Text shown before the navigation line.',
		'label' => 'Breadcrumbs Text'
	),
    'wp_newerentries' => array(
        'weight' => 0,
        'type' => 'text', //input text
        'default_value' => get_option('wp_newerentries', 'next '),
        'attributes' => array(
            'class' => 'regular-text'
        ),
        'description' => 'Newer entries link text shown under posts loop.',
        'label' => 'Newer entries link text'
    ),
    'wp_olderentries' => array(
        'weight' => 0,
        'type' => 'text', //input text
        'default_value' => get_option('wp_olderentries', 'prev '),
        'attributes' => array(
            'class' => 'regular-text'
        ),
        'description' => 'Older entries link text shown under posts loop.',
        'label' => 'Older entries link text'
    ),
	'default_comment_status' => array(
		'weight' => 3,
		'type' => 'blog',
		'default_value' => get_option('default_comment_status', 'open'),
		'description' => 'Enable or Disable commenting throughout your site',
		'label' => 'Comment on/off'
	),
    'posts_per_page' => array(
        'weight' => 7,
		'type' => 'blog',
        'default_value' => get_option('posts_per_page'),
        'attributes' => array(
            'class' => 'small-text'
        ),
		'description' => 'How many posts per page to show (blog, search, categories)?',
        'label' => 'Post per page'
    ),
    'afl_excerpt' => array(
        'weight' => 1,
        'type' => 'blog',
		'description' => 'How long an Excerpt should be?',
        'label' => 'Excerpt',
        'default_value' => get_option('afl_excerpt','40'),
    ),
	'afl_readmore' => array(
		'weight' => 0,
		'type' => 'blog', //input text
		'default_value' => get_option('afl_readmore'),
		'attributes' => array(
			'class' => 'regular-text'
		),
		'description' => 'Customize the Read More link',
		'label' => 'Readmore Text'
	),
    'afl_readmore_enable' => array(
        'weight' => 1,
        'type' => 'blog',
		'description' => 'Show Read More link?',
        'label' => 'Enable Readmore',
        'default_value' => get_option('afl_readmore_enable','open')
    ),
	'hide_post_categories' => array(
		'weight' => 3,
		'type' => 'blog',
		'default_value' => get_option('hide_post_categories', 'open'),
		'description' => 'Hide list of categories from blog meta info',
		'label' => 'Hide post categories'
	),
    'hide_post_comments_meta' => array(
        'weight' => 3,
        'type' => 'blog',
        'default_value' => get_option('hide_post_comments_num', 'open'),
        'description' => 'Hide post comments from blog meta info',
        'label' => 'Hide post comments meta'
    ),
	'show_post_featured' => array(
		'weight' => 3,
		'type' => 'blog',
		'default_value' => get_option('show_post_featured', 'open'),
		'description' => 'Show post featured image on the top of single post page',
		'label' => 'Display featured image in post'
	),
	'display_author_info' => array(
		'weight' => 3,
		'type' => 'blog',
		'default_value' => get_option('display_author_info', 'open'),
		'description' => 'Display author info block on the bottom of the post on single post page.',
		'label' => 'Display author info'
	),
	'afl_blog_sidebar_position' => array(
		'weight' => 1,
		'type' => 'blog',
		'description' => 'Sidebar position on blog page.',
		'label' => 'Sidebar position',
		'default_value' => get_option('afl_blog_sidebar_position','right')
	),
	'afl_blog_sidebar' => array(
		'weight' => 1,
		'type' => 'blog',
		'description' => 'Sidebar to display on blog.<br/>Note: You need to create a custom sidebar first!',
		'label' => 'Sidebar',
		'default_value' => get_option('afl_blog_sidebar','default')
	),
    'afl_social' => array(
        'weight' => 8,
        'type' => 'social',
		'description' => 'Select which page to display on your Frontpage. If left blank the Blog will be displayed',
        'label' => 'Social networks',
        'default_value' => get_option('afl_social')
    ),
    'afl_font' => array(
        'weight' => 10,
        'type' => 'font',
		'description' => 'Select which page to display on your Frontpage. If left blank the Blog will be displayed',
        'label' => 'Font replace',
        'default_value' => get_option('afl_font')
    ),
	'afl_sidebar' => array(
		'weight' => 10,
		'type' => 'sidebar',
		'description' => 'Select which page to display on your Frontpage. If left blank the Blog will be displayed',
		'label' => 'Custom Sidebars',
		'default_value' => get_option('afl_sidebar')
	),
	'afl_counter_code' => array(
		'weight' => 5,
		'type' => 'footer',
		'default_value' => get_option('afl_counter_code'),
		'description' => 'Put here your counter code (e.g. Google Analytics or StatCounter)',
		'label' => 'Counter code'
	),
	'afl_footer_copyright' => array(
		'weight' => 6,
		'type' => 'footer',
		'default_value' => get_option('afl_footer_copyright'),
		'description' => 'Copyright text to display in the footer',
		'label' => 'Footer copyright'
	),
	'afl_footer' => array(
		'weight' => 10,
		'type' => 'footer',
		'description' => 'How many columns should be displayed in your footer',
		'label' => 'Footer Columns',
		'default_value' => get_option('afl_footer')
	),
    'afl_cat_icons' => array(
        'weight' => 10,
        'type' => 'cat_icons',
        'description' => '',
        'label' => 'Category Icons',
        'default_value' => get_option('afl_cat_icons', '')
    )
);


$__CUSTOM_COLORS =	array(
		'Orange' => array(
			'style'=>'background-color:#f0b70c;',
			'google_webfont' => 'Questrial',
			'color_scheme'	=>'Orange',
			'bg_color'		=>'#ffffff',
			'bg_highlight'	=>'#f8f8f8',
			'body_font'		=>'#777777',
			'border'		=>'#e1e1e1',
			'primary'		=>'#f0b70c',
			'highlight'		=>'#edc756',
			'footer_bg'		=>'#333333',
			'footer_font'	=>'#ffffff',
			'socket_bg'		=>'#222222',
			'socket_font'	=>'#aaaaaa',
			'portfolio_bg'	=>'#ffffff',
			'portfolio_font'=>'#222222',
			'bg_image'		=>'',
			'bg_image_custom' => '',
			'bg_image_position' => 'left',
			'bg_image_repeat'=>'repeat',
			'bg_image_attachment'=>'fixed',
			'boxed'			=>'stretched',
			'bg_color_boxed'=>'',
		),

);

include_once get_template_directory() . '/lib/theme-options.php';

?>
