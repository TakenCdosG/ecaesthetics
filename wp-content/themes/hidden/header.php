<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
        <?php
        if ($favicon = get_option('afl_favicon')):
            $ext = pathinfo($favicon, PATHINFO_EXTENSION);
            switch ($ext) {
                case 'gif': $ext_type = 'x-gif';
                    break;
                case 'png': $ext_type = 'x-png';
                    break;
                default: $ext_type = 'x-icon';
            }
            ?>
            <link rel="icon" href="<?php print $favicon; ?>" type="image/<?php echo $ext_type ?>">
            <link rel="shortcut icon" href="<?php print $favicon; ?>" type="image/<?php echo $ext_type ?>" />
        <?php endif; ?>
        <script type="text/javascript">
            var myajaxurl = "<?php echo home_url() ?>/wp-admin/admin-ajax.php";
            var mythemerooturl = "<?php echo get_template_directory_uri() ?>";
            var mypageurl = "<?php echo home_url() ?>/";
        </script>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-47033733-1', 'auto');
            ga('send', 'pageview');

        </script>
        <title><?php
        /*
         * Print the <title> tag based on what is being viewed.
         */
        global $page, $paged;

        wp_title('|', true, 'right');

        // Add the blog name.
        bloginfo('name');

        // Add the blog description for the home/front page.
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && ( is_home() || is_front_page() ))
            echo " | $site_description";

        // Add a page number if necessary:
        if ($paged >= 2 || $page >= 2)
            echo ' | ' . sprintf(__('Page %s', 'afl'), max($paged, $page));
        ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <?php
        /* We add some JavaScript to pages with the comment form
         * to support sites with threaded comments (when in use).
         */
        if (is_singular() && get_option('thread_comments'))
            wp_enqueue_script('comment-reply');

        /* Always have wp_head() just before the closing </head>
         * tag of your theme, or you will break many plugins, which
         * generally use this hook to add elements to <head> such
         * as styles, scripts, and meta tags.
         */
        wp_head();
        ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <link href="css/ie.css" type="text/css" rel="stylesheet"/>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <?php
        echo afl_get_custom_style();
        echo "<style type='text/css'>@font-face{font-family:'FontAwesome';src:url('" . get_template_directory_uri() . "/fonts/fontawesome-webfont.eot?v=4.0.3');src:url('" . get_template_directory_uri() . "/fonts/fontawesome-webfont.eot?#iefix&v=4.0.3') format('embedded-opentype'),url('" . get_template_directory_uri() . "/fonts/fontawesome-webfont.woff?v=4.0.3') format('woff'),url('" . get_template_directory_uri() . "/fonts/fontawesome-webfont.ttf?v=4.0.3') format('truetype'),url('" . get_template_directory_uri() . "/fonts/fontawesome-webfont.svg#fontawesomeregular?v=4.0.3') format('svg');}</style>";
        ?>
    </head>
    <body <?php body_class(); ?> id="top">
        <?php if (get_theme_mod("afl_page_use_slides", false) && count($slides = get_theme_mod("afl_page_slides", array())) > 0): ?>
            <?php
            $js = array();
            foreach ($slides as $slide) {
                $js[] = "{image : '$slide[image]', title : '$slide[title]', thumb : '$slide[thumb]'}";
            }
            ?>
            <script type="text/javascript">
                jQuery(function($){
                    $.supersized.themeVars.image_path = '<?php print get_template_directory_uri() . '/images/supersized/' ?>';
                    $.supersized({

                        // Functionality
                        slideshow               :   1,			// Slideshow on/off
                        autoplay                :	1,			// Slideshow starts playing automatically
                        start_slide             :   1,			// Start slide (0 is random)
                        stop_loop               :	0,			// Pauses slideshow on last slide
                        random                  : 	0,			// Randomize slide order (Ignores start slide)
                        slide_interval          :   3000,		// Length between transitions
                        transition              :   6, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                        transition_speed        :	1000,		// Speed of transition
                        new_window              :	1,			// Image links open in new window/tab
                        pause_hover             :   0,			// Pause slideshow on hover
                        keyboard_nav            :   1,			// Keyboard navigation on/off
                        performance             :	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
                        image_protect           :	1,			// Disables image dragging and right click with Javascript

                        // Size & Position
                        min_width		    :   0,			// Min width allowed (in pixels)
                        min_height		    :   0,			// Min height allowed (in pixels)
                        vertical_center         :   1,			// Vertically center background
                        horizontal_center       :   1,			// Horizontally center background
                        fit_always              :	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
                        fit_portrait            :   1,			// Portrait images will not exceed browser height
                        fit_landscape           :   0,			// Landscape images will not exceed browser width

                        // Components
                        slide_links             :	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
                        thumb_links             :	1,			// Individual thumb links for each slide
                        thumbnail_navigation    :   0,			// Thumbnail navigation
                        slides                  :  	[			// Slideshow Images
    <?php print implode(',', $js); ?>
                ],
                // Theme Options
                progress_bar            :	1,			// Timer for each slide
                mouse_scrub             :	0
            });
        });

            </script>
        <?php endif; ?>

        <?php
        $page = $wp_query->get_queried_object();
        if (!empty($page->ID)) {
            $custom_fields = get_post_custom_values('_wp_page_template', $page->ID);
            $page_template = $custom_fields[0];
        }
        ?>
        <section id="side_menu" class="side_menu <?php
        if (is_admin_bar_showing()) {
            echo 'adminbar';
        }
        ?>" style="display: none;">
            <div class="side_menu_wrap">
                <a href="#" class="side_menu_close"><i class="fa fa-times"></i></a>
                <?php dynamic_sidebar('side-menu'); ?>
            </div>
        </section>
        <div class="wrapper">
            <div class="wrapper-inner">
                <header id="header" class="navbar <?php
                if (!is_active_sidebar('side-menu')) {
                    echo 'side-menu-off';
                }
                ?>">

                    <div class="container">

                        <div class="navbar-header">
                            <a class="navbar-brand" href="<?php echo home_url(); ?>"><?php if ($logo_img = get_option('afl_logo')) { ?><img src="<?php echo $logo_img ?>" alt="<?php echo get_bloginfo('name'); ?>" /><br />
                                    <?php if (get_option('tagline') !== '') { ?><span class="tag-line"><?php echo get_option('tagline') ?></span><?php } ?>
                                    <?php
                                } else {
                                    if (get_option('logo_text') !== '') {
                                        ?> <span class="logo-text"><?php echo get_option('logo_text') ?></span><?php } ?><br />
                                    <?php if (get_option('tagline') !== '') { ?><span class="tag-line"><?php echo get_option('tagline') ?></span><?php } ?>
                                <?php } ?>
                            </a>
                        </div>
                        <div class="navbar-top-menu">
                            <div class="navbar-primary-links">
                                <?php wp_nav_menu(array('theme_location' => 'primary', 'container' => 'nav', 'container_class' => 'clearfix', 'container_id' => 'navigation-primary-menu', 'menu_class' => 'nav navigation-primary-menu sf-menu clearfix')); ?>
                            </div>
                            <div class="navbar-social-links">
                                <?php afl_social_links(); ?>
                            </div>
                        </div>
                        <?php
                        if (has_nav_menu('top_menu')) {
                            wp_nav_menu(array('theme_location' => 'top_menu', 'container' => 'nav', 'container_class' => 'clearfix', 'container_id' => 'top-menu', 'menu_class' => 'nav top-menu sf-menu clearfix'));
                        } else {
                            echo 'Top Menu is not set! Please go to Admin Panel "Appearance => Menus" and set menu for "Top Navigation"';
                        }
                        ?>

                        <?php //afl_social_links();  ?>
                        <?php //echo "<div class='call_us'>".get_option('top_contact_text')."</div>"  ?>

                        <div class="clearfix visible-md visible-lg"></div>

                        <?php afl_top_right(); ?>

                        <span class="side_menu_button"><i class="fa fa-bars"></i></span>

                        <div id="res-menu"></div>

                        <?php
                        $cur_id = get_queried_object_id();
                        $blogPageID = get_option("page_for_posts");
                        ?>
                        <?php if ($cur_id == $blogPageID) { ?>

                            <div id="headersearch" class="headersearch">
                                <form id="headersearch-form" class="form-inline" role="form" action="#" method="get" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="sr-only" for="hs-search">Enter your search term...</label>
                                        <input class="hs-input form-control" placeholder="Enter your search term..." type="text" value="" name="s" id="hs-search">
                                        <button class="hs-submit btn btn-info" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>

                        <?php } else { ?>

                            <div id="headersearch" class="headersearch">
                                <form id="headersearch-form" class="form-inline" role="form" action="#" method="get" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="sr-only" for="hs-search">Search for products</label>
                                        <input class="hs-input form-control" placeholder="Search for products" type="text" value="" name="s" id="hs-search">
                                        <input type="hidden" value="product" name="post_type">
                                        <button class="hs-submit btn btn-info" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>

                        <?php } ?>

                        <script>

                            jQuery('#hs-icon').on('click', function(){
                                if (jQuery('#headersearch').hasClass('open')) {
                                    if (jQuery('#headersearch #hs-search').val() !== '') {
                                        jQuery('#headersearch-form').submit();
                                    }
                                    else {
                                        jQuery('#headersearch').removeClass('open');
                                    }
                                }
                                else {
                                    if (jQuery('#headersearch #hs-search').val() !== '') {
                                        jQuery('#headersearch-form').submit();
                                    }
                                    jQuery('#headersearch').addClass('open');
                                }
                            });
                            jQuery(document).on('click', function (e) {
                                var target = e.target;
                                if (!jQuery(target).is('#headersearch') && !jQuery(target).parents().is('#headersearch') && !jQuery(target).is('#hs-icon') && !jQuery(target).parents().is('#hs-icon')) {
                                    jQuery('#headersearch').removeClass('open');
                                }
                            });

                        </script>

                    </div>

                </header>
