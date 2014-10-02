<?php
/*==========================================================================================

shortcodes.php
This file contains custom shortcodes for the theme

==========================================================================================

- Flex Slider
- Text Slider
- Slogan
- Divider
- Full Width
- 2,3,4-Column Structures
- Contact Form
- User Map
- User Button
- User Quote
- User Boxes
- Custom Image
- Tooltip
- Vimeo
- Youtube
- Posts Strip
- User Posts Strip
- Testimonials
- User Recents
- Accordions
- Recent Posts
- Advanced Recent Posts
- Parallax
- Portfolio

*/
/******************** Shortcodes Initialization ******************/
    $__SHORTCODES = array(
		'afl_flex-slider' => array(
			'name' => 'Flex slider',
			'description' => 'Flex slider',
			'image' => 'css/images/nivo-tip.png'
		),
		'afl_text_slider' => array(
            'name' => 'Text slider',
            'description' => 'Text slider - no images just text carousel ',
			'image' => 'css/images/text-tip.png'
        ),
        'afl_partners_slider' => array(
            'name' => 'Partners slider',
            'description' => 'Partners slider - logos only slider ',
            'image' => 'css/images/text-tip.png'
        ),
        'afl_full_screen' => array(
            'name' => 'Full screen',
            'description' => 'Full screen block for content ',
            'image' => 'css/images/full-width-tip.png'
        ),
        'afl_full_width' => array(
            'name' => 'Full width',
            'description' => 'Full width block for content ',
			'image' => 'css/images/full-width-tip.png'
        ),
        'afl_2_columns' => array(
            'name' => '2 columns',
            'description' => '2 column content ',
			'image' => 'css/images/2-columns-tip.png'
        ),
        'afl_3_columns' => array(
            'name' => '3 columns',
            'description' => '3 column content ',
			'image' => 'css/images/3-columns-tip.png'
        ),
        'afl_4_columns' => array(
            'name' => '4 columns',
            'description' => '4 column content ',
			'image' => 'css/images/4-columns-tip.png'
        ),
		'afl_one_third_block' => array(
            'name' => 'One third',
            'description' => 'One third and two third columns content',
			'image' => 'css/images/one-third-tip.png'
        ),
		'afl_one_third_last_block' => array(
            'name' => 'One third last',
            'description' => 'Two third and one third columns content',
			'image' => 'css/images/one-third-last-tip.png'
        ),
        'afl_slogan' => array(
            'name' => 'Slogan',
            'description' => 'Slogan shortcode ',
			'image' => 'css/images/slogan-tip.png'
        ),
		'afl_divider' => array(
            'name' => 'Divider',
            'description' => 'Divider with text',
			'image' => 'css/images/divider-tip.png'
        ),
		'afl_recent_projects' => array(
			'name' => 'Recent Projects',
			'description' => 'Recent projects',
			'image' => 'css/images/recent-posts-tip.png'
		),
		'afl_advanced_recent_projects' => array(
			'name' => 'Advanced Recent Projects',
			'description' => 'Recent projects with Intro and Title',
			'image' => 'css/images/recent-posts-tip.png'
		),
		'afl_recent_posts' => array(
            'name' => 'Recent Posts',
            'description' => 'Recent posts',
			'image' => 'css/images/recent-posts-tip.png'
        ),
		'afl_advanced_recent_posts' => array(
            'name' => 'Advanced Recent Posts',
            'description' => 'Recent posts with Intro and Title',
			'image' => 'css/images/recent-posts-tip.png'
        ),
        'afl_page_content' => array(
            'name' => 'Page Content',
            'description' => 'Show page content from another page inside this one',
            'image' => ''
        ),
        'afl_contact_form' => array(
            'name' => 'Contact Form',
            'description' => 'Insert contact form',
            'image' => ''
        ),
        'afl_parallax' => array(
            'name' => 'Parallax block',
            'description' => 'Parallax block with content ',
            'image' => 'css/images/full-width-tip.png'
        ),
        'afl_portfolio' => array(
            'name' => 'Portfolio',
            'description' => 'Portfolio block',
            'image' => 'css/images/full-width-tip.png'
        ),
    );

/******************** Begin Flex Slider ******************/
if ( ! function_exists( 'afl_flex_slider_shortcode' ) ):
function afl_flex_slider_shortcode($atts, $content = null){
	global $post;
	setup_postdata( $post );
	$suf = rand(100000,999999);
	$out = '';

	$page_sidebar = get_page_sidebar_settings($post->ID);
	$sidebar_pos = $page_sidebar['sidebar_position'];
	if ($atts['fullwidth'] == 'open' && $sidebar_pos == 'none' ) $out .= '<section class="container">';
    if ($atts['fullwidth'] !== 'open' && $sidebar_pos == 'none' ) $out .= '<div class="col-sm-12 no-sidebar">';
    $out .= '<div id="flexslider-'.$suf.'" class="flexslider ';
    if ($atts['fullwidth'] == 'open') $out .= 'fullwidth ';
    if ($sidebar_pos == 'none') $out .= 'no-sidebar ';
    if ($sidebar_pos !== 'none') $out .= 'with-sidebar ';
    $out .= '">';
    $out .= afl_do_shortcode($content).'
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery("#flexslider-'.$suf.'").flexslider({';
							if (isset($atts['animation']) && ($atts['animation'])) $out .= 'animation: "'.$atts['animation'].'",';
							$out .= 'useCSS: false,
							easing: "'.(isset($atts['effect']) ? $atts['effect'] : 'swing').'",';
							$out .= 'direction: "'. ($atts['direction'] == 'vertical' ?  'vertical' : 'horizontal') .'",
							reverse: false,
							controlNav: '. ($atts['navigation'] == 'true' ?  'true' : 'false') .',
							animationLoop: '. ($atts['loop'] == 'open' ?  'true' : 'false') .',
							smoothHeight: true,
							prevText: "<i class=\" fa fa-angle-left\"></i>",
                            nextText: "<i class=\" fa fa-angle-right\"></i>",
							slideshow: true,
							slideshowSpeed: '. (intval($atts['slideshowspeed']) > 0 ?  intval($atts['slideshowspeed']) : '7000') .',
							animationSpeed: '. (intval($atts['slidespeed']) > 0 ?  intval($atts['slidespeed']) : '600') .',
							randomize: '. (isset($atts['randomize']) && $atts['randomize'] == 'open' ?  'true' : 'false') .',
							pauseOnHover: '. ($atts['hoverpause'] == 'true' ?  'true' : 'false') .',';
						$out .= '});
					});
					</script>
                </div>';
    if ($atts['fullwidth'] !== 'open' && $sidebar_pos == 'none') $out .= '</div>';
	if ($atts['fullwidth'] == 'open' && $sidebar_pos == 'none') $out .= '</section>';
	else {
		$atts['custom_class'] = 'flex_slider';
		$out = afl_container_wrap($atts, $out);
	}

	return $out;
}
endif;
add_shortcode('flex-slider', 'afl_flex_slider_shortcode');
/******************** End Flex Slider ******************/

/******************** Begin Text Slider ******************/
if ( ! function_exists( 'afl_text_slider_shortcode' ) ):
	function afl_text_slider_shortcode($atts, $content = null){
        $suf = rand(100000,999999);
		$testimonials = '';
		$top = '-13px';
		$margin = '30';
		if(!empty($atts['content_types'])){
			$data = array();
			$contents = get_posts( array( 'posts_per_page' => isset($atts['content_count'])? $atts['content_count'] : 5, 'offset' => 0, 'post_type' => $atts['content_types'] ) );
			foreach( $contents as $post ){
				setup_postdata($post);
				$post_title = get_the_title($post->ID);
				$post_content = $post->post_excerpt;
				$author_name = '';
				$author_desc = '';
				$button_text = (get_option('afl_readmore') == '') ?  'Read More ...' : get_option('afl_readmore');
				$button_link = get_permalink();
				switch($atts['content_types']){
					case 'testimonials':
						$post_content = $post->post_content;
						$testimonials = ' testimonials';
						$author_desc = get_url_desc_box($post->ID);
						$author_name = $post_title;
						$post_title = $button_text = $button_link = '';
					    $top = '0';
						break;
					default: break;
				}
				$data[] = array('post_id' => $post->ID,'title' => $post_title, 'content' => $post_content, 'author_name' => $author_name, 'author_desc' => $author_desc, 'button_text' => $button_text, 'button_link' => $button_link);
			}
			$contents = '';
			if(!empty($data)){
				foreach($data as $slide){
					if(isset($slide['content'])){
						$content = $slide['content'];
						unset($slide['content']);
					}
					$contents .= ' [text_slide '.afl_render_shortcode_attributes('text_slider',$slide).'] '.$content.' [/text_slide] ';
				}
			}
		} else {
			$contents = $content;
		}

        $out = '<!--text-slider-->
        <div id="text-slider-'.$suf.'" class="carousel bttop">
            <div class="carousel-wrapper">
                <ul class="text-slider'.$testimonials.'">'.afl_do_shortcode($contents).'</ul>
            </div>
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function(){
            	logit = jQuery("#text-slider-'.$suf.'").parent().parent().find(".title-divider h4.afl-title");
                jQuery("#text-slider-'.$suf.'").elastislide({
                	imageW: 1200,
                    margin  : 30
                });
                if(logit.length > 0)
                	jQuery("#text-slider-'.$suf.' .es-nav").css({"top": "-13px"});
                else {
                	jQuery("#text-slider-'.$suf.' .es-nav").css({"top": "'.$top.'"});
                	if("'.$top.'" == "0") {
                		jQuery("#text-slider-'.$suf.'").css({"padding-top": "33px"});
                		jQuery("#text-slider-'.$suf.' h4").css({"padding-top": "0"});
                	}
                }
			});
		</script>';
		$atts['custom_class'] = 'text_slider_block';
		if(!isset($atts['level'])) $out = afl_container_wrap($atts, $out);
        return $out;
    }
endif;
add_shortcode('text_slider', 'afl_text_slider_shortcode');


if ( ! function_exists( 'afl_text_slide_shortcode' ) ):
    function afl_text_slide_shortcode($atts, $content = null){
        extract($atts);
		$class = '';
        if(!empty($post_id) && has_post_thumbnail($post_id))
			$thumbnail = get_the_post_thumbnail($post_id, 'popular-post-thumbnail');
		else {
			$thumbnail = '';
			$class = ' class="no-thumb"';
		}
		$navfix = '';
        $out = '<li'.$class.'>';
					if (!empty($title)) {
                        $out.='<h3>';
					    if (!empty($icon)) $out.='<img alt="'.$title.'" src="'.$icon.'"/>';
					    $out.= $title.'</h3>';
                    }
					if (!empty($author_name)) $out .= $thumbnail;
                    if (!empty($author_name)) {
                        $out .= '<h3 class="author-name">'.$author_name;
                        if(!empty($author_desc)) $out.='<small>'.$author_desc.'</small>';
                        $out .= '</h3>';
                    }
					if (!empty($content))  $out.='<p>'.afl_do_shortcode($content).'</p>';
					if (!empty($button_link) || !empty($button_text)) $out.='<a href="'.$button_link.'">'.$button_text.'</a>';
				$out.='</li>';
        return $out;
    }
endif;
add_shortcode('text_slide', 'afl_text_slide_shortcode');
/******************** End Text Slider ******************/

/******************** Begin Partners Slider ******************/
if ( ! function_exists( 'afl_partners_slider' ) ):
    function afl_partners_slider($atts, $content = null){
        $suf = rand(100000,999999);
        $out = '<div class="container partners_slider"><div class="row">';
        $out .= '<!--partners-slider-->
        <div id="partners-slider-'.$suf.'" class="carousel bttop">
            <div class="carousel-wrapper">
                '.afl_do_shortcode($content).'
            </div>
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function(){
                $("#partners-slider-'.$suf.'").flexslider({';
                //if (isset($atts['animation']) && ($atts['animation'])) $out .= 'animation: "'.$atts['animation'].'",';
							$out .= 'useCSS: false,
							animation: "slide",
							//easing: "'.(isset($atts['effect']) ? $atts['effect'] : 'swing').'",
							direction: "horizontal",
							reverse: false,
							directionNav: '. ($atts['navigation'] == 'true' ?  'true' : 'false') .',
							animationLoop: '. ($atts['loop'] == 'open' ?  'true' : 'false') .',
							smoothHeight: false,
							prevText: "<i class=\" fa fa-angle-left\"></i>",
                            nextText: "<i class=\" fa fa-angle-right\"></i>",
							slideshow: true,
							itemWidth: 1,
                            itemMargin: 1,
                            minItems: 2,
                            maxItems: 5,
                            controlNav: false,
                            move: 2,
							slideshowSpeed: '. (intval($atts['slideshowspeed']) > 0 ?  intval($atts['slideshowspeed']) : '7000') .',
							animationSpeed: '. (intval($atts['slidespeed']) > 0 ?  intval($atts['slidespeed']) : '600') .',
							randomize: '. (isset($atts['randomize']) && $atts['randomize'] == 'open' ?  'true' : 'false') .',
							pauseOnHover: false
                });
			});
		</script>';
        $out .= '</div></div>';
        return $out;
    }
endif;
add_shortcode('partners_slider', 'afl_partners_slider');
/******************** End Partners Slider ******************/

/******************** Begin Slogan ******************/
if ( ! function_exists( 'afl_slogan' ) ):
    function afl_slogan($atts, $content = null){
        $out = '<div class="container slogan">
            <section class="welcome clearfix">';
        $out .= '<div class="row">';
        $out .= '<div class="col-sm-10">';
            if (!empty($atts['title'])) $out.='<h1>'.$atts['title'].'</h1>';
			if ($content && $content != ' ' && $content != '') $out.='<p>'.afl_do_shortcode($content).'</p>';
        $out .= '</div>';
        $out .= '<div class="col-sm-2">';
            if (!empty($atts['button_link']) && !empty($atts['button_text'])){ $out.='<a href="'.$atts['button_link'].'" class="btn btn-info">'.$atts['button_text'].' <i class="fa fa-angle-right"></i></a>';}
        $out .= '</div>';
        $out .= '</div>';
            $out .= '</section>
            </div>';
        return $out;
    }
endif;
add_shortcode('slogan', 'afl_slogan');
/******************** End Slogan ******************/

/******************** Begin Full Screen ******************/
if ( ! function_exists( 'afl_full_screen' ) ):
function afl_full_screen($atts, $content = null){
	return '<section class="container afl_full_screen">'.afl_do_shortcode(apply_filters('the_content',$content)).'</section>';
}
endif;
add_shortcode('full_screen', 'afl_full_screen');
/******************** End Full Screen ******************/

/******************** Begin Full Width ******************/
if ( ! function_exists( 'afl_full_width' ) ):
function afl_full_width($atts, $content = null){
    $out = '<div class="container full_width"><div class="row">
                <div class="col-sm-12">';
				if (isset($atts['title']) && !empty($atts['title'])) {
					$out.= '<div class="title-divider"><h3 class="afl-title">';
                    if (!empty($atts['icon'])) {$out.='<i class="fa fa-'.$atts['icon'].'"></i> ';}
					$out .= '<span>'.$atts['title'].'</span></h3></div>';
				}

				if ($content)  {$out.= '<div class="text">'.afl_do_shortcode(apply_filters('the_content',$content)).'</div>';}
				if ((isset($atts['button_link']) || isset($atts['button_text'])) && !empty($atts['button_text']) ) {$out.='<p class="afl-btn-wrapper"><a href="'.$atts['button_link'].'" class="link btn btn-info">'.$atts['button_text'].'</a></p>';}
				$out.= '</div>
        </div></div>';
    return $out;
}
endif;
add_shortcode('full_width', 'afl_full_width');
/******************** End Full Width ******************/

/******************** Begin 2,3,4-Column Structures ******************/
if ( ! function_exists( 'afl_2_columns' ) ):
    function afl_2_columns($atts, $content = null){
		$atts['custom_class'] = 'two_columns';
        return afl_columns_wrap($atts, $content);
    }
endif;
add_shortcode('2_columns', 'afl_2_columns');
if ( ! function_exists( 'afl_one_third_block' ) ):
	function afl_one_third_block($atts, $content = null){
		$atts['custom_class'] = 'one_third_columns';
        return afl_columns_wrap($atts, $content);
    }
endif;
add_shortcode('one_third_block', 'afl_one_third_block');
if ( ! function_exists( 'afl_one_third_last_block' ) ):
	function afl_one_third_last_block($atts, $content = null){
		$atts['custom_class'] = 'one_third_last_columns';
        return afl_columns_wrap($atts, $content);
    }
endif;
add_shortcode('one_third_last_block', 'afl_one_third_last_block');
if ( ! function_exists( 'afl_3_columns' ) ):
    function afl_3_columns($atts, $content = null){
		$atts['custom_class'] = 'three_columns';
        return afl_columns_wrap($atts, $content);
    }
endif;
add_shortcode('3_columns', 'afl_3_columns');
if ( ! function_exists( 'afl_4_columns' ) ):
    function afl_4_columns($atts, $content = null){
		$atts['custom_class'] = 'four_columns';
        return afl_columns_wrap($atts, $content);
    }
endif;
add_shortcode('4_columns', 'afl_4_columns');
if ( ! function_exists( 'afl_one_half' ) ):
	function afl_one_half($atts, $content = null){
		$atts['container'] = 'col-sm-6';
		$out = afl_column($atts, $content);
		return $out;
	}
endif;
add_shortcode('one_half', 'afl_one_half');
if ( ! function_exists( 'afl_one_third' ) ):
	function afl_one_third($atts, $content = null){
		$atts['container'] = 'col-sm-4';
		$out = afl_column($atts, $content);
        return $out;
    }
endif;
add_shortcode('one_third', 'afl_one_third');
if ( ! function_exists( 'afl_two_third' ) ):
	function afl_two_third($atts, $content = null){
		$atts['container'] = 'col-sm-8';
		$out = afl_column($atts, $content);
        return $out;
    }
endif;
add_shortcode('two_third', 'afl_two_third');
if ( ! function_exists( 'afl_one_fourth' ) ):
	function afl_one_fourth($atts, $content = null){
		$atts['container'] = 'col-sm-3';
		$out = afl_column($atts, $content);
		return $out;
	}
endif;
add_shortcode('one_fourth', 'afl_one_fourth');
if ( ! function_exists( 'afl_three_fourth' ) ):
	function afl_three_fourth($atts, $content = null){
		$atts['container'] = 'col-sm-9';
		$out = afl_column($atts, $content);
		return $out;
	}
endif;
add_shortcode('three_fourth', 'afl_three_fourth');
if ( ! function_exists( 'afl_column' ) ):
	function afl_column($atts, $content = null){
		$out = '';
		if(isset($atts[0]) && $atts[0] == 'first') $out .= '<div class="row">';
		$out .= '<div class="'.$atts['container'].'"><div class="col-wrap">';
		if (isset($atts['title']) && !empty($atts['title'])) {
			$out.= '<div class="title-divider"><h3 class="afl-title">';
            if (!empty($atts['icon'])) {$out.='<i class="fa fa-'.$atts['icon'].'"></i> ';}
            $out .= '<span>'.$atts['title'].'</span></h3></div>';
		}

		if ($content)  {$out.= '<div class="text">'.afl_do_shortcode(apply_filters('the_content',$content)).'</div>';}
		if ((isset($atts['button_link']) || isset($atts['button_text'])) && !empty($atts['button_text']) ) {$out.='<p class="afl-btn-wrapper"><a href="'.$atts['button_link'].'" class="link btn btn-info">'.$atts['button_text'].'</a></p>';}
		$out.= '</div>';
		if(isset($atts[0]) && $atts[0] == 'last') $out .= '</div>';
        $out.= '</div>';
		return $out;
	}
endif;
/******************** End 2,3,4-Column Structures ******************/

/******************** Begin Contact Form ******************/
if ( ! function_exists( 'afl_contact_form' ) ):
function afl_contact_form($atts, $content = null){
    $suf = rand(100000,999999);
    $baseurl = get_template_directory_uri();
    $form = '<div id="af-form-result-'.$suf.'"></div>
    <div class="container af-form-shortcode">
        <form name="contact" method="post" action="#" class="af-form" id="af-form-'.$suf.'" novalidate="novalidate">
        <div class="row">
   <div class="col-sm-6 af-form-author">
   <div class="af-outer af-required">
    <div class="af-inner form-group">
     <label class="sr-only" for="name-'.$suf.'" id="name_label">Your Name:</label>
     <input type="text" name="name" id="name-'.$suf.'" size="30" placeholder="Your Name" value="" class="text-input form-control required" />
    </div>
   </div>
   </div>
   <div class="col-sm-6 af-form-email">
   <div class="af-outer af-required">
    <div class="af-inner form-group">
     <label class="sr-only" for="email-'.$suf.'" id="email_label">Your Email:</label>
     <input type="text" name="email" id="email-'.$suf.'" size="30" placeholder="Your Email" value="" class="text-input form-control required" />
    </div>
   </div>
   </div>
  </div>
  <div class="row">
   <div class="col-sm-12">
   <div class="af-outer af-required">
    <div class="af-inner form-group">
     <label class="sr-only" for="input-subject-'.$suf.'" id="subject_label">Subject:</label>
     <input type="text" name="subject" id="input-subject-'.$suf.'" placeholder="Subject" class="text-input form-control required"/>
    </div>
   </div>
   </div>
  </div>
  <div class="row">
   <div class="col-sm-12">
   <div class="af-outer af-required">
    <div class="af-inner form-group">
     <label class="sr-only" for="input-message-'.$suf.'" id="message_label">Your Message:</label>
     <textarea name="message" id="input-message-'.$suf.'" cols="30" placeholder="Your Message" class="text-input form-control required"></textarea>
    </div>
   </div>
   </div>
  </div>
   <div class="af-outer">
    <div class="af-inner">
     <input type="submit" name="af-form-submit" class="form-button btn btn-large btn-info" id="submit_btn" value="Send Message!" />
    </div>
   </div>
  </form>
  </div>
  <script type="text/javascript">
    jQuery(document).ready(function(){
   jQuery("#af-form-'.$suf.'").validate({
    submitHandler: function(form) {
     jQuery(form).ajaxSubmit().clearForm();
     jQuery("#af-form-result-'.$suf.'").html("<div class=\"alert alert-success fade in\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button><strong>Contact Form Submitted!</strong> We will be in touch soon.</div>");
      },
    rules: {
     name: "required",
     email: {
       required: true,
       email: true
     },
     subject: "required",
     message: "required"
      },
      messages: {
     name: "Please specify your name",
     email: {
       required: "We need your email address to contact you",
       email: "Your email address must be in the format of name@domain.com"
     },
     subject: "Please specify your subject",
     message: "Enter your message!"
      }
   });
    });
  </script>
  ';
    return $form;
}
endif;
add_shortcode('contact_form', 'afl_contact_form');
/******************** End Contact Form ******************/

/******************** Begin Contact Form ******************/
if ( ! function_exists( 'afl_contact_form1' ) ):
function afl_contact_form1($atts = null, $content = null){
    return do_shortcode('[contact_form][/contact_form]');
}
endif;
add_shortcode('afl_contact_form', 'afl_contact_form1');
/******************** End Testimonials ******************/

/******************** Begin User Button ******************/
if ( ! function_exists( 'user_button' ) ):
	function user_button($atts, $content = null){
        $button = '';
		$content_empty = !isset($content) || trim($content) == false;
		$icons_array = array('adjust', 'align-center', 'align-justify', 'align-left', 'align-right', 'arrow-down', 'arrow-left', 'arrow-right', 'arrow-up', 'asterisk', 'backward', 'ban-circle', 'barcode', 'bell', 'bold', 'book', 'bookmark', 'briefcase', 'bullhorn', 'calendar', 'camera', 'certificate', 'check', 'chevron-down', 'chevron-left', 'chevron-right', 'chevron-up', 'circle-arrow-down', 'circle-arrow-left', 'circle-arrow-right', 'circle-arrow-up', 'cog', 'comment', 'download', 'download-alt', 'edit', 'eject', 'envelope', 'exclamation-sign', 'eye-close', 'eye-open', 'facetime-video', 'fast-backward', 'fast-forward', 'file', 'film', 'filter', 'fire', 'flag', 'folder-close', 'folder-open', 'font', 'forward', 'fullscreen', 'gift', 'glass', 'globe', 'hand-down', 'hand-left', 'hand-right', 'hand-up', 'hdd', 'headphones', 'heart', 'home', 'inbox', 'indent-left', 'indent-right', 'info-sign', 'italic', 'leaf', 'list', 'list-alt', 'lock', 'magnet', 'map-marker', 'minus', 'minus-sign', 'move', 'music', 'off', 'ok', 'ok-circle', 'ok-sign', 'pause', 'pencil', 'picture', 'plane', 'play', 'play-circle', 'plus', 'plus-sign', 'print', 'qrcode', 'question-sign', 'random', 'refresh', 'remove', 'remove-circle', 'remove-sign', 'repeat', 'resize-full', 'resize-horizontal', 'resize-small', 'resize-vertical', 'retweet', 'road', 'screenshot', 'search', 'share', 'share-alt', 'shopping-cart', 'signal', 'star', 'star-empty', 'step-backward', 'step-forward', 'stop', 'tag', 'tags', 'tasks', 'text-height', 'text-width', 'th', 'th-large', 'th-list', 'thumbs-down', 'thumbs-up', 'time', 'tint', 'trash', 'upload', 'user', 'volume-down', 'volume-off', 'volume-up', 'warning-sign', 'wrench', 'zoom-in', 'zoom-out');
		$icon_active = isset($atts['icon']) && in_array($atts['icon'], $icons_array);
        if(!$content_empty || $icon_active){
            $button = '<a href="'.(isset($atts['link']) ? $atts['link'] : '').'"
             				class="btn'.
										(isset($atts['size']) && in_array($atts['size'], array('xs','sm','lg')) ? ' btn-'.$atts['size'] : '' ).
										(isset($atts['style']) && in_array($atts['style'], array('primary', 'info', 'success', 'warning', 'danger', 'inverse', 'link')) ? ' btn-'.$atts['style'] : ' btn-default' ).
										(isset($atts['text']) && in_array($atts['text'], array('light','grey','dark')) ? ' btn-'.$atts['text'] : '' ).
										(isset($atts['class']) ? ' '.$atts['class'] : '' ).
										'"'.
							(isset($atts['window']) && $atts['window'] == 'yes' ? ' target="_blank"' : '' ).'>'.
                            ($icon_active ? '<i class="fa fa-'.$atts['icon'].(isset($atts['iconstyle']) && $atts['iconstyle'] == 'white' ? ' icon-white' : '' ).'"'.($content_empty ? 'style="margin-right:0;"' : '').'></i>' : '').
							$content.'</a>';
        }
        return $button;
    }
endif;
add_shortcode('button', 'user_button');
/******************** End User Button ******************/

/******************** Begin Social Link ******************/
if ( ! function_exists( 'afl_social_link' ) ):
    function afl_social_link($atts, $content = null){

        $out = "";
        if(isset($atts['network'])){
            $out .= '<span class="afl-social"><a href="'.$atts['url'].'"';
            if(isset($atts['title']))
                $out .= ' title="'.$atts['title'].'"';
            $out .= '><i class="fa fa-'.$atts['network'].' size'.$atts['size'].'"></i></a></span>';
        }

        return $out;

    }
endif;
add_shortcode('social', 'afl_social_link');
/******************** End Social Link ******************/

/******************** Begin Icon Link ******************/
if ( ! function_exists( 'afl_icon_link' ) ):
function afl_icon_link($atts, $content = null){
	$out = '';
	if(isset($content)){
		$out .= '<span class="afl-ilink"><a ';
		if(isset($atts['icon']))
			$out .= 'style="background-image:url('.$atts['icon'].');"';
		elseif(isset($atts['style']))
			$out .= 'style="background-image:url('.get_template_directory_uri().'/images/icons/'.$atts['style'].'.png);"';
		$out .= ' href="'.(isset($atts['url']) ? $atts['url'] : '').'">'.$content.'</a></span>';
	}
	return $out;
}
endif;
add_shortcode('ilink', 'afl_icon_link');
/******************** End Icon Link ******************/

/******************** Begin Icon Box ******************/
if ( ! function_exists( 'afl_icon_box' ) ):
function afl_icon_box($atts, $content = null){
	$out = '';
	if(isset($content) || isset($atts['title'])){
		$out .= '<div class="iconbox">';
		$out .= '<span class="iconbox_icon"><img alt="iconbox" src="'.get_template_directory_uri().'/images/icons/iconbox/'.(isset($atts['icon']) ? $atts['icon'] : 'accessories-calculator.png').'"></span>';
		$out .= '<div class="iconbox_content">';
		if(isset($atts['title'])) $out .= '<h3 class="iconbox_content_title">'.$atts['title'].'</h3>';
		$out .= '<p>'.(isset($content) ? do_shortcode($content) : '').'</p>';
		$out .= '</div></div>';
	}
	return $out;
}
endif;
add_shortcode('iconbox', 'afl_icon_box');
/******************** End Icon Box ******************/

/******************** Begin Alert Boxes ******************/
if ( ! function_exists( 'afl_box' ) ):
function afl_box($atts, $content = null){
	$out = '';
	if(isset($content)){
		if(!isset($atts['size']) || $atts['size'] == '')
			$atts['size'] = '';
		else
			$atts['size'] = ' alert-block';
		if(!isset($atts['type']) || $atts['type'] == '' || $atts['type'] == 'warning')
			$atts['type'] = '';
		else
			$atts['type'] = ' alert-'.$atts['type'];
		$out .= '<div class="alert'.$atts['size'].$atts['type'].'">';
		if(isset($atts['close']) && $atts['close'] == 'yes') $out .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
		if(isset($atts['title']))
			if($atts['size'] == '')
				$out .= '<strong>'.$atts['title'].'</strong> ';
			else
				$out .= '<h3>'.$atts['title'].'</h3> ';
		$out .= do_shortcode($content);
		$out .= '</div>';
	}
	return $out;
}
endif;
add_shortcode('box', 'afl_box');
/******************** End Alert Boxes ******************/

/******************** Begin Tooltip ******************/
if ( ! function_exists( 'afl_tooltip' ) ):
function afl_tooltip($atts, $content = null) {
	if(isset($content)){
		if (!empty($atts['text'])) {
			$out = '<span class="tooltip-text" rel="tooltip" data-original-title="'.$atts['text'].'" data-placement="';
			$out .= (isset($atts['placement']) && in_array($atts['placement'], array('right','bottom','left')) ? $atts['placement'] : 'top' ).'">'.$content.'</span>';
			return $out;
		}
	}
	return '';
}
endif;
add_shortcode('tooltip', 'afl_tooltip');
/******************** End Tooltip ******************/

/******************** Begin Quote ******************/
if ( ! function_exists( 'afl_quote' ) ):
	function afl_quote($atts, $content = null){
        $quote = '';
        if(isset($content)){
			$placement = isset($atts['placement']) && in_array($atts['placement'], array('right','left'));
			if($placement) {
				$quote .= '<div class="pull-'.$atts['placement'].'"';
				if(isset($atts['placement'])) $quote .= ' style="width:'.$atts['width'].'"';
				$quote .= '>';
			}
            $quote .= '<blockquote>';
			if(isset($atts['title'])) $quote .= '<h4 class="quote-title">'.$atts['title'].'</h4>';
			$quote .= '<p>'.$content.'</p>';
			if(isset($atts['small'])) $quote .= '<small>'.$atts['small'].'</small>';
			$quote .= '</blockquote>';
			if($placement) $quote .= '</div>';
        }
        return $quote;
    }
endif;
add_shortcode('quote', 'afl_quote');
/******************** End Quote ******************/

/******************** Begin Video ******************/
if ( ! function_exists( 'afl_video' ) ):
function afl_video($atts, $content = null) {
	if(isset($atts['id'])) {
		if(isset($atts['type']) && $atts['type'] = "vimeo")
			$url = 'http://vimeo.com/moogaloop.swf?clip_id='.$atts['id'];
		else
			$url = 'http://www.youtube.com/v/'.$atts['id'];
		if(isset($atts['width'])) $width = $atts['width']; else $width="100%";
		if(isset($atts['height'])) $height = $atts['height']; else $height="200";
		$videoString = "";
		$videoString .= '<div class="video-wrap">';
		$videoString .= '<object type="application/x-shockwave-flash" data="'.$url.'" width="'.$width.'" height="'.$height.'">';
		$videoString .= '<param name="allowScriptAccess" value="always" />';
		$videoString .= '<param name="allowFullScreen" value="true" />';
		$videoString .= '<param name="movie" value="'.$url.'" />';
		$videoString .= '<param name="quality" value="high" />';
		$videoString .= '<param name="wmode" value="transparent" />';
		$videoString .= '<param name="bgcolor" value="#ffffff" />';
		$videoString .= '</object>';
		$videoString .= '</div>';
		return $videoString;
	}
	return '';
}
endif;
add_shortcode('video', 'afl_video');
/******************** End Video ******************/

/******************** Begin Accordion ******************/
if ( ! function_exists( 'afl_accordion_shortcode' ) ):
function afl_accordion_shortcode($atts, $content = null){
	$suf = rand(100000,999999);
	$keep = (isset($atts['keep_open']) && $atts['keep_open'] == 'false' ? false : true);
	$open = (isset($atts['initial_open']) && intval($atts['initial_open']) > 0 ? intval($atts['initial_open'])-1 : 0);
	$out = '<div id="accordion-'.$suf.'" class="accordion"'.( $keep ? ' data-collapse-type="manual"' : '').'>'.afl_do_shortcode($content).'</div>

        <script type="text/javascript">
        	jQuery(window).load(function(){
				jQuery.each($("#accordion-'.$suf.' a.accordion-toggle"), function(i, link){
					var $collapsible = jQuery(this.getAttribute("href"));

					i == '.$open.' ? $toggle = true : $toggle = false;

					$collapsible.collapse({
						parent : "#accordion-'.$suf.'",
						toggle : $toggle
					});

					jQuery(link).on("click",
						function(){
							$collapsible.collapse("toggle"); // Here is the magic trick
						}
					);

				});
			});
		</script>';
	return $out;
}
endif;
add_shortcode('accordion', 'afl_accordion_shortcode');

if ( ! function_exists( 'afl_accordion_unit_shortcode' ) ):
function afl_accordion_unit_shortcode($atts, $content = null){
	$suf = rand(100000,999999);
	extract($atts);

	$out = '<div class="panel panel-default accordion-group">';
	if (!empty($title)) {
        $out.='<div class="panel-heading accordion-heading"><a href="#collapse'.$suf.'" data-toggle="collapse" class="accordion-toggle"><i class="fa fa-plus icon-white"></i>'.$title.'</a></div>';
	}
	if (!empty($content)) {
		$out .= '<div class="panel-collapse accordion-body collapse" id="collapse'.$suf.'" style="height: 0"><div class="panel-body accordion-inner">';
		$out.='<p>'.afl_do_shortcode($content).'</p>';
		if (!empty($url) || !empty($link_text)) $out.='<a href="'.$url.'" class="read-more">'.$link_text.'</a>';
		$out .= '</div></div>';
	}

	$out.='</div>';
	return $out;
}
endif;
add_shortcode('accordion_unit', 'afl_accordion_unit_shortcode');
/******************** End Accordion ******************/

/******************** Begin Tabs ******************/
if ( ! function_exists( 'afl_tabs_shortcode' ) ):
function afl_tabs_shortcode($atts, $content = null){
	$suf = rand(100000,999999);
	$out = '<ul class="nav nav-tabs" id="tabs-'.$suf.'"></ul>';
	$out .= '<div class="tab-content" data-parent="#tabs-'.$suf.'" data-open="'.(isset($atts['initial_open']) && intval($atts['initial_open']) > 0 ? $atts['initial_open'] : 1).'">'.afl_do_shortcode($content).'</div>';

	return $out;
}
endif;
add_shortcode('tabs', 'afl_tabs_shortcode');

if ( ! function_exists( 'afl_tab_shortcode' ) ):
function afl_tab_shortcode($atts, $content = null){
	$suf = rand(100000,999999);
	extract($atts);

	$out = '';
	if (!empty($title) && !empty($content)) {
		$out .= '<li class="tab"><a href="#tab-'.$suf.'" data-toggle="tab">'.$title.'</a></li>';
		$out .= '<div class="tab-pane fade in" id="tab-'.$suf.'"><p>'.afl_do_shortcode($content).'</p></div>';
	}

	return $out;
}
endif;
add_shortcode('tab', 'afl_tab_shortcode');
/******************** End Tabs ******************/

/******************** Begin Divider ******************/
if ( ! function_exists( 'afl_divider' ) ):
function afl_divider($atts){
	$out = '';
	$inv = '';
	if(isset($atts[0])){
		if($atts[0] == 'top') $out .= '<div class="divider-title"><a href="#top" class="top pull-right">To top &uarr;</a></div>';
		if($atts[0] == 'invisible') $inv .= 'class="invisible"';
		if($atts[0] == 'bold') $inv .= 'class="bold"';
		if($atts[0] == 'small') $inv .= 'class="small"';
		if($atts[0] == 'mini') $inv .= 'class="mini"';
		if($atts[0] == 'bottom') $inv .= 'class="bottom"';
	}
	$out .= '<div class="col-sm-12"><hr '.$inv.'/></div>';
	$atts['custom_class'] = 'divider_block';
	return afl_container_wrap($atts, $out);
}
endif;
add_shortcode('divider', 'afl_divider');
/******************** End Divider ******************/

/******************** Begin DropCap ******************/
if ( ! function_exists( 'afl_dropcap1' ) ):
function afl_dropcap1($atts, $content=null){
	return '<span class="dropcap1">'.mb_substr($content, 0, 1).'</span>';
}
endif;
add_shortcode('dropcap1', 'afl_dropcap1');

if ( ! function_exists( 'afl_dropcap2' ) ):
function afl_dropcap2($atts, $content=null){
	return '<span class="dropcap2">'.mb_substr($content, 0, 1).'</span>';
}
endif;
add_shortcode('dropcap2', 'afl_dropcap2');

if ( ! function_exists( 'afl_dropcap3' ) ):
function afl_dropcap3($atts, $content=null){
	return '<span class="dropcap3">'.mb_substr($content, 0, 1).'</span>';
}
endif;
add_shortcode('dropcap3', 'afl_dropcap3');
/******************** End DropCap ******************/

/******************** Begin Google Map ******************/
if ( ! function_exists( 'afl_map' ) ):
function afl_map($atts, $content = null){
	$map = '';
	if(isset($atts['src'])){
		$atts['width'] = (intval($atts['width'])>0?$atts['width']:300);
		$atts['height'] = (intval($atts['height'])>0?$atts['height']:300);

		$map = '<iframe width="'.$atts['width'].'" height="'.$atts['height'].'" class="map-container" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$atts['src'].'&amp;output=embed'.'"></iframe>';
	}
	return $map;
}
endif;
add_shortcode('map', 'afl_map');
/******************** End Google Map ******************/

/******************** Begin Contact Form ******************/
if ( ! function_exists( 'afl_map1' ) ):
    function afl_map1($atts = null, $content = null){
        return do_shortcode('<div class="map_wrapper">[map src="'.$atts['src'].'" height="'.$atts['height'].'" width="'.$atts['width'].'"] [/map]</div>');
    }
endif;
add_shortcode('afl_map', 'afl_map1');
/******************** End Testimonials ******************/

/******************** Begin Posts Strip ******************/
if ( ! function_exists( 'afl_posts_strip' ) ):
        function afl_posts_strip($atts, $content = null){
            //$title = $atts['title'];
            $title = isset($atts['title']) ? $atts['title'] : '';
            $amount = intval($atts['amount']);
			$category = isset($atts['cat']) ? $atts['cat'] : '';
            $offset = intval($atts['offset']);

            $posts = get_posts( array( 'posts_per_page' => $amount, 'offset'=> $offset, 'category' => $category ) );
            $content = '<div class="our-news">';
            if ($title !== '') {
                $content .= '<h3 class="news-header">'.$title.'</h3>';
            }


            $articlespan = $amount;
            switch ($articlespan) {
                case 1:
                    $articlespan = 'col-md-12';
                    break;
                case 2:
                    $articlespan = 'col-md-6';
                    break;
                case 3:
                    $articlespan = 'col-md-4';
                    break;
                default:
                    $articlespan = 'col-md-3';
            }

            if ($posts){
                foreach ($posts as $post){
                    setup_postdata($post);
                    $content .= '<article class="' . join( ' ', get_post_class('',$post->ID) ) . ' ' . $articlespan . ' col-sm-6 clearfix" id="post-'.$post->ID.'">';
					$content .= '<div class="post-date">
                                    <div class="day">' . get_the_time('d', $post->ID) . '</div>
                                    <div class="month">' . get_the_time('M', $post->ID) . '</div>
                                    <div class="year">' . get_the_time('Y', $post->ID) . '</div>
                                </div>';
					$content .= '<h3 class="news-title"><a href="'.get_permalink($post->ID).'">'.get_the_title($post->ID).'</a></h3>';
					$content .= '<div class="news-text">'. excerpt() .'</div>';
					$content .= '</article>';
                }
            }
            else{
                $content .= 'None Found';
            }
            $content .= '</div>';
			$atts['custom_class'] = 'posts_strip';
			if(!isset($atts['level']))
				return $content = afl_container_wrap($atts, $content);
			else
				return do_shortcode($content);
        }
endif;
add_shortcode('posts_strip', 'afl_posts_strip');
/******************** End Posts Strip ******************/

/******************** Begin User Posts Strip ******************/
if ( ! function_exists( 'user_posts_strip' ) ):
		function user_posts_strip($atts, $content = null){
            return do_shortcode('[posts_strip type="'.$atts['type'].'" offset="'.$atts['offset'].'" amount="'.$atts['amount'].'" level="inside"] [/posts_strip]');
        }
endif;
add_shortcode('user_posts_strip', 'user_posts_strip');
/******************** End User Posts Strip ******************/

/******************** Begin Testimonials ******************/
if ( ! function_exists( 'user_testimonials' ) ):
       function user_testimonials($atts = null, $content = null){
            return do_shortcode('[text_slider content_types="testimonials" level="inside"] [/text_slider]');
        }
endif;
add_shortcode('testimonials', 'user_testimonials');
/******************** End Testimonials ******************/

/******************** Begin Recent Projects ******************/
if (!function_exists('afl_recent_projects')):
    function afl_recent_projects($atts, $content = null)
    {
        global $post;
        $number = (isset($atts['number']) && $atts['number'] > 0) ? $atts['number'] : 4;
        $args = array('posts_per_page' => $number, 'post_type' => 'portfolio');
        $myposts = get_posts($args);
        $suf = rand(100000, 999999);
        // Recent Projects container
        $res = '<div class="container recent_projects"><div class="row"><div class="col-sm-12">';
        // Title Block
        if ($atts['title']) {
            $res .= '<div class="title-divider"><h3 class="afl-title">';
            if (!empty($atts['icon'])) {
                $res .= '<i class="fa fa-' . $atts['icon'] . '"></i> ';
            }
            $res .= '<span>'.$atts['title'] . '</span></h3></div>';
        }
        // Owl Carousel wrapper
        $res .= '<div class="afl-owl-carousel"><div class="afl-owl-carousel-wrapper">';
        $res .= '<div id="our-projects-' . $suf . '" class="do-thumbs owl-carousel">';
        foreach ($myposts as $post) : setup_postdata($post);
            if (has_post_thumbnail()) {
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'portfolio');
                $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                // Recent Project image/hover
                $res .= '
                <div class="do-media ">
                    <img class="img-responsive" src="' . $image[0] . '" alt="' . $post->post_title . '"/>
                    <div class="do-hover">
                        <a class="do-img-link" href="' . $src[0] . '" data-rel="prettyPhoto"><i class="fa fa-search"></i></a>
                        <a class="do-url-link" href="' . get_permalink($post->ID) . '"><i class="fa fa-link"></i></a>
                    </div>
                </div>
                ';
            }
        endforeach;
        $res .= '</div>'; // close our-projects div
        $res .= '
            <script type="text/javascript">
            jQuery(document).ready(function(){
                 jQuery("#our-projects-' . $suf . '").owlCarousel({items: 4, autoPlay: true, pagination: false });
			});
            </script>';
        $res .= '</div></div>'; // close afl-owl-carousel-wrapper, afl-owl-carousel
        $res .= '</div></div></div>'; // close col-sm-12, row, container recent_projects

        return $res;
    }
endif;
add_shortcode('recent_projects', 'afl_recent_projects');
/******************** End Recent Projects ******************/

/******************** Begin Advanced Recent Projects ******************/
if (!function_exists('afl_advanced_recent_projects')):
    function afl_advanced_recent_projects($atts, $content = null)
    {
        $suf = rand(100000, 999999);
        // Advanced Recent Projects container
        $out = '<div class="container adv_recent_projects"><div class="row">';
        // Text block
        $out .= '<div class="col-sm-4 col-md-3"><div class="text-block">';
        if ($atts['title']) {
            $out .= '<h3 class="afl-title">';
            if ($atts['icon']) {
                $out .= '<i class="fa fa-' . $atts['icon'] . '"></i> ';
            }
            $out .= '<span>'.$atts['title'] . '</span></h3>';
        }
        if ($content) {
            $out .= afl_do_shortcode(apply_filters('the_content', $content));
        }
        if ($atts['button_link'] || $atts['button_text']) {
            $out .= '<a href="' . $atts['button_link'] . '" class="btn btn-info">' . $atts['button_text'] . '</a>';
        }
        $out .= '</div></div>'; // close div.text-block, div.(col-sm-4 col-md-3)
        // End Text Block
        // Recent projects
        $out .= '<div class="col-sm-8 col-md-9">';
        $out .= '<div class="afl-owl-carousel"><div class="afl-owl-carousel-wrapper">';
        $out .= '<div id="our-projects-' . $suf . '" class="do-thumbs owl-carousel">';
        $number = (isset($atts['number']) && $atts['number'] > 0) ? $atts['number'] : 4;
        $myposts = get_posts(array('posts_per_page' => $number, 'post_type' => 'portfolio'));
        foreach ($myposts as $post) : setup_postdata($post);
            if (has_post_thumbnail($post->ID)) {
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'portfolio');
                $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                $out .= '
                <div class="do-media">
                    <img class="img-responsive" src="' . $image[0] . '" alt="' . $post->post_title . '"/>
                    <div class="do-hover">
						<a class="do-img-link" href="' . $src[0] . '" data-rel="prettyPhoto"><i class="fa fa-search"></i></a>
						<a class="do-url-link" href="' . get_permalink($post->ID) . '" ><i class="fa fa-link"></i></a>
					</div>
                </div>
                ';
            }
        endforeach;
        $out .= '</div>'; // close our-projects div
        $out .= '
            <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery("#our-projects-' . $suf . '").owlCarousel({
                    items: 3,
                    itemsDesktop : [1200,3],
                    itemsDesktopSmall: [991,2],
                    itemsTablet: [767,2],
                    autoPlay: true,
                    pagination: false
                });
			});
			</script>';
        $out .= '</div></div>'; // close div.afl-owl-carousel-wrapper, div.afl-owl-carousel
        $out .= '</div>'; // close div.(col-sm-8 col-md-9)
        $out .= '</div></div>'; // close div.row div.(container adv_recent_projects)
        return $out;
    }
endif;
add_shortcode('advanced_recent_projects', 'afl_advanced_recent_projects');
/******************** End Advanced Recent Projects ******************/

/*********************** Begin Recent Posts *************************/
if ( ! function_exists( 'afl_recent_posts' ) ):
function afl_recent_posts($atts, $content = null){
    global $post;
	if(!isset($atts['number'])) $atts['number'] = 4;
	switch($atts['number']){
		case 2:$span='col-sm-6';break;
		case 3:$span='col-sm-4';break;
		default:$span='col-sm-3';break;
	}
    $args = array(
					'numberposts'=>$atts['number'],
					'offset' => (isset($atts['offset']) && intval($atts['offset']) > 0) ? intval($atts['offset']) : '',
					'category' => (isset($atts['category']) && intval($atts['category']) > 0) ? intval($atts['category']) : ''
	);
    $myposts = get_posts( $args );
    $res = '<div class="container recent_posts">';
	if ($atts['title']) {
		$res.= '<div class="title-divider"><h3 class="afl-title">';
        if (!empty($atts['icon'])) {$res.='<i class="fa fa-'.$atts['icon'].'"></i> ';}
		$res .= '<span>'.$atts['title'].'</span></h3></div>';
	}
	$res .= '<div class="row our-blog">';
    foreach( $myposts as $post ) : setup_postdata($post);
        $res .= '<article class="'.$span.'"><div class="blog-post">';
        $num_comments = get_comments_number($post->ID);
        if($num_comments == 0){
            $comments = __('No Comments', 'afl');
        }
        elseif($num_comments > 1){
            $comments = $num_comments. __('Comments', 'afl');
        }
        else{
            $comments ="1 Comment";
        }
        $write_comments = ' <a href="' . get_comments_link() .'">'. $comments.'</a>';

        if (has_post_thumbnail()) {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio' );
            $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');

            $res .= '<div class="post-img-wrapper do-media">';
			$res .= '<a href="'.$src[0].'" data-rel="prettyPhoto"><img class="img-responsive" src="'.$image[0].'" alt="'.$post->post_title.'"/></a>';
            $res .= '<div class="do-hover">
                        <a class="do-img-link" href="'.$src[0].'" data-rel="prettyPhoto"><i class="fa fa-search"></i></a>
						<a class="do-url-link" href="'.get_permalink($post->ID).'"><i class="fa fa-link"></i></a>
                    </div>';
            $res .= '</div>';
        }

		$year = get_the_time( 'Y', $post->ID );$month = get_the_time( 'm', $post->ID );$day = get_the_time( 'd', $post->ID );

		$post_categories = wp_get_post_categories( $post->ID );
		$cat = get_category( $post_categories[0] );

		$res .= '<p class="post-meta"><span><i class="fa fa-user"></i> <a href="'. get_author_posts_url(get_the_author_meta("ID")).'">'.get_the_author().'</a></span>  <span><i class="fa fa-clock-o"></i> <a href="'.get_day_link( $year, $month, $day ).'">'.get_the_time('F j, Y', $post->ID).'</a></span> <span><i class="fa fa-folder-open"></i> <a href="'.get_category_link( $cat->cat_ID ).'">'.$cat->name.'</a></span></p>';

		$res .= '<h3 class="title"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></h3>';

		$res .= '<p>'.((!empty($post->post_excerpt)) ? $post->post_excerpt : content()).'</p>';
		$readmore = (get_option('afl_readmore') == '') ?  'Read More ...' : get_option('afl_readmore');
		$res .= '<a class="btn btn-info readmore" href="'.get_permalink($post->ID).'">'.$readmore.'</a>
				 </div></article>';
    endforeach;
    $res.='</div>
    </div>';
    return $res;
}
endif;
add_shortcode('recent_posts', 'afl_recent_posts');
/************************* End Recent Posts ************************/

/******************** Begin Advanced Recent Posts ******************/
if ( ! function_exists( 'afl_advanced_recent_posts' ) ):
        function afl_advanced_recent_posts($atts, $content = null){
			if(!isset($atts['number'])) $atts['number'] = 3;
			switch($atts['number']){
				case 1:$span='col-sm-6';break;
				case 2:$span='col-sm-4';break;
				default:$span='col-sm-3';break;
			}
			$args = array(
				'numberposts'=>$atts['number'],
				'offset' => (isset($atts['offset']) && intval($atts['offset']) > 0) ? intval($atts['offset']) : '',
				'category' => (isset($atts['category']) && intval($atts['category']) > 0) ? intval($atts['category']) : ''
			);
            $out = '<div class="container adv_recent_posts"><div class="row our-blog">';
			    $out .= '<div class="'.$span.'"><div class="text-block">';
			if($atts['title']){
				$out.='<h3 class="afl-title">';
                if ($atts['icon']) {$out.='<i class="fa fa-'.$atts['icon'].'"></i> ';}
				$out.='<span>'.$atts['title'].'</span></h3>';
			}
				
				if ($content)  {$out.= '<p>'.afl_do_shortcode(apply_filters('the_content',$content)).'</p>';}
				if ($atts['button_link'] || $atts['button_text'] ) {$out.='<a href="'.$atts['button_link'].'" class="btn btn-info">'.$atts['button_text'].'</a>';}
						$out.= '</div></div>';
            //recent posts
            $myposts = get_posts( $args );

            foreach( $myposts as $post ) : setup_postdata($post);
              $out .= '	<article class="'.$span.'"><div class="blog-post">';

	      if (get_post_thumbnail_id( $post->ID )) {
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio' );
                $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');

              $out .= '<div class="post-img-wrapper do-media">';
                $out .= '<a href="'.$src[0].'" data-rel="prettyPhoto"><img class="img-responsive" src="'.$image[0].'" alt="'.$post->post_title.'"/></a>';
              $out .= '<div class="do-hover">
                        <a class="do-img-link" href="'.$src[0].'" data-rel="prettyPhoto"><i class="fa fa-search"></i></a>
						<a class="do-url-link" href="'.get_permalink($post->ID).'"><i class="fa fa-link"></i></a>
                    </div>';
              $out .= '</div>';
		  }

			  $year = get_the_time( 'Y', $post->ID );$month = get_the_time( 'm', $post->ID );$day = get_the_time( 'd', $post->ID );

				$post_categories = wp_get_post_categories( $post->ID );
				$cat = get_category( $post_categories[0] );

			  //$out .= '<p class="post-meta"><span>By <a href="'. get_author_posts_url(get_the_author_meta("ID")).'">'.get_the_author().'</a>  | On <a href="'.get_day_link( $year, $month, $day ).'">'.get_the_time('F j, Y', $post->ID).'</a> | In <a href="'.get_category_link( $cat->cat_ID ).'">'.$cat->name.'</a></span></p>';
              $out .= '<p class="post-meta"><span><i class="fa fa-user"></i> <a href="'. get_author_posts_url(get_the_author_meta("ID")).'">'.get_the_author().'</a></span>  <span><i class="fa fa-clock-o"></i> <a href="'.get_day_link( $year, $month, $day ).'">'.get_the_time('F j, Y', $post->ID).'</a></span> <span><i class="fa fa-folder-open"></i> <a href="'.get_category_link( $cat->cat_ID ).'">'.$cat->name.'</a></span></p>';

			  $out .= '<h3 class="title"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></h3>';
			  
              $out .= '<p class="post-excerpt">'.((!empty($post->post_excerpt)) ? $post->post_excerpt : content()).'</p>';
			  $readmore = (get_option('afl_readmore') == '') ?  'Read More ...' : get_option('afl_readmore');
			  $out .= '<a class="btn btn-info readmore" href="'.get_permalink($post->ID).'">'.$readmore.'</a>';
              $out .= '</div></article>';
 	    endforeach;
            $out .= '</div></div>';
            return $out;
        }
endif;
add_shortcode('advanced_recent_posts', 'afl_advanced_recent_posts');
/******************** End Advanced Recent Posts *******************/

/*********************** Begin Page Content *************************/
if ( ! function_exists( 'afl_page_content' ) ):
function afl_page_content($atts, $content = null){
    $title = isset($atts['title']) ? trim($atts['title']) : '';
    $page_id = isset($atts['page']) ? intval($atts['page']) : 0;
    $cont_id = isset($atts['contid']) ? trim($atts['contid']) : 0;
    $custom_class = isset($atts['class']) ? ' '.trim($atts['class']) : '';

    if(empty($page_id) && $page_id > 0) return '';

    $addmap = '';

    $container_id = '';
    if(!empty($cont_id)) $container_id = ' id="'.$cont_id.'"';

    $content = '<section'.$container_id.' class="container page_content page page-wrapper'.$custom_class.'">'.$addmap;

    if (!empty($title)) {
        $content .= '<div class="container"><div class="row"><div class="col-sm-12"><div class="title-divider"><h1 class="page-content-title">'.$title.'</h1></div></div></div></div>';
    }

    $post = get_page($page_id);

    if($post){
        if(get_post_meta($post->ID, 'afl_composer', true)=='on') {
            $items = afl_get_te_data($post->ID);
            $content .= do_shortcode(afl_to_shortcode($items));
        } else {
            $content .= '<div class="container">';
            $content .= apply_filters('the_content', $post->post_content);
            $content .= '</div>';
        }
    }

    $content .= '</section>';

    return $content;
}
endif;
add_shortcode('page_content', 'afl_page_content');
/************************* End Page Content ************************/

/******************** Parallax Block ******************/
if ( ! function_exists( 'afl_parallax' ) ):
function afl_parallax($atts, $content = null){
    $suf = rand(100000,999999);
    if (isset($atts['image_url'])) {
        $bg_image = $atts['image_url'];
    } else {
        $bg_image = '';
    }
    $out = '<section id="parallax'.$suf.'" class="parallax">
                <div class="parallax-bg" style="background: url(\''.$bg_image.'\') repeat-y 50% 0 fixed;"></div>
                <div class="overlay"></div>
                <div class="container full_width">
                    <div class="row">
                        <div class="col-sm-12">';
    if (isset($atts['title']) && !empty($atts['title'])) {
        $out.= '<div class="title-divider"><h3 class="afl-title">';
        if (!empty($atts['icon'])) {$out.='<i class="fa fa-'.$atts['icon'].'"></i> ';}
        $out .= '<span>'.$atts['title'].'</span></h3></div>';
    }

    if ($content)  {$out.= '<div class="text">'.afl_do_shortcode(apply_filters('the_content',$content)).'</div>';}
    if ((isset($atts['button_link']) || isset($atts['button_text'])) && !empty($atts['button_text']) ) {$out.='<p><a href="'.$atts['button_link'].'" class="btn btn-info btn-lg link">'.$atts['button_text'].'</a></p>';}
    $out.= '
        <script type="text/javascript">
        jQuery(document).ready(function(){
            if ( ! /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
                jQuery("#parallax'.$suf.' .parallax-bg").parallax("50%", 0.3);
            } else {
                jQuery("#parallax'.$suf.' .parallax-bg").addClass("mobile");
            }
        });
        </script>
</div>
        </div></div></section>';
    return $out;
}
endif;
add_shortcode('parallax', 'afl_parallax');
/******************** End Parallax Block ******************/

/*********************** Begin Portfolio *************************/
if ( ! function_exists( 'afl_portfolio' ) ):
function afl_portfolio($atts, $content = null){

    global $wp_query;

    //var_export($atts);die;
    extract($atts);

    /**/

    //$portfolio_settings = get_portfolio_settings($post->ID);
    switch($cols){
        case 2: $col_width = 'col-sm-6';break;
        case 4: $col_width = 'col-sm-3';break;
        default: $col_width = 'col-sm-4';break;
    }
    $orderby = 'date';
    $order = 'DESC';
    /*
    switch($portfolio_settings['portfolio_sort']){
        case 'Randomize': $orderby = 'rand'; $order = ''; break;
        case 'None':
        case '':break;
        default:
            $params = explode(' ', $portfolio_settings['portfolio_sort']);
            $orderby = strtolower($params[0]);
            $order = $params[1];
            break;
    }
    */
    $args=array(
        'post_type' => 'portfolio',
        'posts_per_page' => $rows * $cols,
        'orderby' => $orderby,
        'order' => $order
    );
    $temp = $wp_query;
    $wp_query = null;
    $wp_query = new WP_Query($args);
    $terms = get_terms('portfoliocat');

    $out = '';

    if ($wp_query->have_posts()) {

        // open portfolio shortcode block
        $out.='<div class="container portfolio_sc"><div class="row">';
            // Title
            if (strlen($title) < 1) {}
            else {
                $out.='<div class="col-sm-6"><h3 class="afl-title portfolio-heading">' . $title . '</h3></div>';
            }
            //
            if (strlen($title) < 1) {
                $out.='<div class="col-sm-12">';
            }
            else {
                $out.='<div class="col-sm-6">';
            }
                //filter -->
                if ($filters=='open') {

                    $out.='<ul id="filtrable" class="clearfix">';
                        $out.='<li class="current all"><a href="#" data-filter="*">All</a></li>';
                            foreach ($terms as $term) {
                                $filter_last_item = end($terms);
                                $out.='<li class="' . strtolower(str_replace(" ", "-", $term->name)) . '"><a href="#" data-filter=".' . strtolower(str_replace(" ", "-", $term->name)) . '">' . $term->name . '</a></li>';
                            }
                        $out.='</ul>';
                }
                else {}

                //filter -->
            $out.='</div>';
        $out.='</div>';
        $out.='</div>';
        $out.='<div class="clear"></div>';

        //filter <--/

        $out.='<div class="container">';
        $out.='<section class="row do-thumbs portfolio filtrable isotope">';

     global $post;
	 $tmp_post = $post;
	 $per_page = get_option('posts_per_page');
	 $posts_count = wp_count_posts('post')->publish;
	 $paged = intval(get_query_var('paged'));
	 if(empty($paged) || $paged == 0) $paged = 1;
	 $i = 0;


    $i=0;
    while ( $wp_query->have_posts() ) : $wp_query->the_post();
        $i++;
        $custom = get_post_custom($post->ID);
        $foliocatlist = get_the_term_list( $post->ID, 'portfoliocat', '', ', ', '' );
        $entrycategory = get_the_term_list( $post->ID, 'portfoliocat', '', '_', '' );
        $entrycategory_sc = get_the_term_list( $post->ID, 'portfoliocat', '', ', ', '' );
        $entrycategory = strip_tags($entrycategory);
        $entrycategory = strtolower($entrycategory);
        $entrycategory = str_replace(' ', '-', $entrycategory);
        $entrycategory = str_replace('_', ' ', $entrycategory);
        $entrytitle = get_the_title();
        $blogimageurl = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
        if($blogimageurl==""){
            $blogimageurl = get_template_directory_uri().'/images/blank.jpg';
        }
        ?>
        <?php
        $out.='
        <article data-id="id-'.$post->ID.'" data-type="'.$entrycategory .'" class="'. $col_width . ' ' . $entrycategory . ' isotope-item">
            <div class="do-img do-media">';
                $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                if (has_post_thumbnail()) {
                    $imgurl = $src[0];
                    //the_post_thumbnail('portfolio');
                    $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'portfolio');
                    $out.='<img src="'.$src[0].'" class="img-responsive" alt="'.$post->post_title.'" />';
                } else {
                    $imgurl = $blogimageurl;
                    $out.='<img src="'.$imgurl.'" class="img-responsive" alt="'.$post->post_title.'" />';
                }
                $out.='
                <div class="do-hover">
                    <a href="'.$imgurl.'" class="do-img-link"  data-rel="prettyPhoto"><i class="fa fa-search"></i></a>
                    <a href="'.get_permalink().'" class="do-url-link btn-details" data-id="'.$post->ID.'"><i class="fa fa-info"></i></a>
                </div>
            </div>
            <div class="do-caption">
                <h3 class="portfolio-title">'.$post->post_title.'</h3>
            </div>
            ';
            if(isset($portfolio_settings['portfolio_type'])&&$portfolio_settings['portfolio_type']==1) {
                $out.='
                <h3><a href="'.get_permalink() .'">'.$post->post_title.'</a></h3>
                <p>'.((!empty($post->post_excerpt)) ? $post->post_excerpt : content()) .'</p>
                <a href="'.get_permalink() .'" class="read-more btn btn-info">'.(get_option('afl_readmore') == '') ?  'Read More ...' : get_option('afl_readmore') .'</a>';
            }
        $out.='<p class="portfolio-cat">'.$entrycategory_sc;
        if( function_exists('zilla_likes') ) {
            $out.='<span class="pull-right">';
            $out.= zilla_likes_ret();
            $out.='</span>';
        }
        $out.='</p>';
        $out.='</article>';
    endwhile;
    } else {
        $out.='<h3>Oops, we could not find what you were looking for...</h3>';
    }

    $wp_query = null;
    $wp_query = $temp;
    wp_reset_query();
    $out.='</section>';
    $out.='</div><div class="clear"></div>';
    // start extended portfolio block
    $out.='<div id="extended_portfolio_page" class="container">';
        $out.='<div class="row"><div class="col-sm-12"><hr class="extended_portfolio_divider" /></div></div>';
        $out.='<div class="row">';
            $out.='<div class="col-sm-6"><h3 id="portfolio_title"></h3></div>';
            $out.='<div id="portfolio_category" class="col-sm-6"></div>';
        $out.='</div>';
        $out.='<div class="row">';
            $out.='<div class="col-sm-4"><p>Posted by <strong id="portfolio_author"></strong></p><div id="portfolio_info"></div></div>';
            $out.='<div class="col-sm-8"><div id="portfolio_image"></div></div>';
        $out.='</div>';
    $out.='</div>';
    // end extended portfolio block
    $out.='<div class="clear"></div>';
    ?>
    <?php

    return $out;

    /**/

}
endif;
add_shortcode('portfolio', 'afl_portfolio');
/************************* End Portfolio ************************/

/******************** Begin Skill Bars ******************/
if ( ! function_exists( 'afl_skillbars_shortcode' ) ):
function afl_skillbars_shortcode($atts, $content = null){
    $suf = rand(100000,999999);
    $out = '<div id="skillbars-'.$suf.'" class="skill-bars">'.afl_do_shortcode($content).'</div>';
    return $out;
}
endif;
add_shortcode('skillbars', 'afl_skillbars_shortcode');

if ( ! function_exists( 'afl_skillbar_unit_shortcode' ) ):
function afl_skillbar_unit_shortcode($atts, $content = null){
    $suf = rand(100000,999999);
    extract($atts);

    $out = '<div class="skill-bar">';
    $out.= '<div data-percentage="'.$datapercentage.'" class="skill-bar-content" style="width: '.$datapercentage.'%;"><span>'.$datapercentage.'%</span></div>';
    $out.= '<div class="skill-title"><span>'.$title.'</span></div>';
    $out.= '</div>';

    return $out;
}
endif;
add_shortcode('skillbar_unit', 'afl_skillbar_unit_shortcode');
/******************** End Skill Bars ******************/

