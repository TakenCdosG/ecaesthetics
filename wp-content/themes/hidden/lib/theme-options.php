<?php
// admin_menu hook
if ( ! function_exists( 'afl_theme_options_hook' ) ):
function afl_theme_options_hook() {
    if ( ! current_user_can('edit_theme_options') )
        return;
    $page = 'theme-options';
    if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'theme-options' && $_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['save_changes'])){
            check_admin_referer('theme-option');
        global $__OPTIONS;
        $option_keys = array_keys( $__OPTIONS );
        $changes = array();
        foreach($_POST as $k => $v){
            if(in_array($k, $option_keys)){
                $v = trim(stripslashes($v));
                update_option($k, $v);
                $changes[$k] = $v;
            }
        }
        //for each checkboxes
        foreach(array('default_comment_status','afl_readmore_enable','afl_breadcrumbs_enable','display_author_info','hide_post_categories','hide_post_comments_meta','show_post_featured') as $k){
            if(in_array($k, $option_keys)){
                if(isset($_POST[$k])&&$_POST[$k]=='open'){
                    $v = 'open';
                }
                else{
                    $v = 'closed';
                }
                update_option($k, $v);
                $changes[$k] = $v;
            }
        }
        if(isset($_POST['afl_social_url'])){
            $socials = array();
            foreach($_POST['afl_social_url'] as $k => $v){
                if( strlen($v)>0 && strlen($_POST['afl_social_image'][$k])>0 ){
                    $socials[] = array('url' => trim(stripslashes($v)), 'title'=> trim(stripslashes($_POST['afl_social_title'][$k])),'image' => trim(stripslashes($_POST['afl_social_image'][$k])));
                }
            }
            $changes['afl_social'] = serialize($socials);
            update_option('afl_social', $changes['afl_social']);
        }
        if(isset($_POST['afl_category_name'])){
            //var_export($_POST['category_id']); die();
            $cat_icons = array();
            foreach($_POST['afl_category_name'] as $k => $v){
                if( strlen($v)>0 && strlen($_POST['afl_category_icon'][$k])>0 ){
                    $cat_icons[$_POST['category_id'][$k]] = trim(stripslashes($_POST['afl_category_icon'][$k]));
                }
            }
            $changes['afl_cat_icons'] = serialize($cat_icons);
            update_option('afl_cat_icons', $changes['afl_cat_icons']);
        }
        if(isset($_POST['afl_font_selector'])){
            $fonts = array();
            foreach($_POST['afl_font_selector'] as $k => $v){
                $sel = trim(stripslashes($v));
                $font = trim(stripslashes($_POST['afl_font_name'][$k]));
                $color = trim(stripslashes($_POST['afl_font_color'][$k]));
                if(strlen($sel)>0 && strlen($font)>0){
                    $fonts[] = array('selector'=>$sel, 'font'=>$font, 'color'=>$color);
                }
            }
            $changes['afl_font'] = serialize($fonts);
            update_option('afl_font', $changes['afl_font']);
        }
		if(isset($_POST['afl_sidebar_name'])){
			$sidebars = array();
			foreach($_POST['afl_sidebar_name'] as $k => $v){
				if( strlen($v)>0 ){
					$slug = trim(stripslashes(strtolower(preg_replace("/[^A-Za-z0-9\-\_]/", "", $_POST['afl_sidebar_slug'][$k] != '' ? $_POST['afl_sidebar_slug'][$k] : $v ))));
					$desc = trim(stripslashes($_POST['afl_sidebar_description'][$k] != '' ? $_POST['afl_sidebar_description'][$k] : $v ));
					$sidebars[] = array('name' => trim(stripslashes($v)), 'slug'=> $slug,'description' => $desc);
				}
			}
			$changes['afl_sidebar'] = serialize($sidebars);
			update_option('afl_sidebar', $changes['afl_sidebar']);
		}
		if(isset($_POST['afl_counter_code'])){
			update_option('afl_counter_code', trim(stripslashes($_POST['afl_counter_code'])));
		}
		if(isset($_POST['afl_footer_copyright'])){
			update_option('afl_footer_copyright', trim(stripslashes($_POST['afl_footer_copyright'])));
		}
		if(isset($_POST['afl_footer_cols'])){
			update_option('afl_footer', $_POST['afl_footer_cols']);
		}
        afl_refresh_options($changes);
        }
    }

	$my_theme = wp_get_theme();

	//add_menu_page('Theme settings', $my_theme->Name , 'manage_options', $page, 'afl_theme_options_view','',58);
	//add_submenu_page($page,'Theme Options','Theme Options','manage_options',$page,'afl_theme_options_view');
    add_theme_page('Theme Options','Theme Options','manage_options',$page,'afl_theme_options_view');
}
endif;
add_action('admin_menu', 'afl_theme_options_hook');

if ( ! function_exists( 'afl_theme_options_load_hook' ) ):
function afl_theme_options_load_hook() {
    $fonts = array();
    foreach(afl_get_google_font_list() as $font){
        $fonts[] = str_replace(' ', '+', trim($font));
    }
    if (!empty($fonts)){
        wp_enqueue_style('afl-google-fonts-all', 'http://fonts.googleapis.com/css?family='.  implode('|', $fonts));
    }
}
endif;
add_action("admin_enqueue_scripts", 'afl_theme_options_load_hook');

if ( ! function_exists( 'get_socials_list' ) ):
function get_socials_list() {
	$url = get_template_directory();
	$url .= "/lib/css/images/social";
	$listDir = array();
	if($handler = opendir($url)) {
		while (($sub = readdir($handler)) !== FALSE) {
			if ($sub != "." && $sub != ".." && $sub != "Thumb.db" && $sub != "Thumbs.db") {
				if(is_file($url."/".$sub)) {
					$listDir[$sub] = $sub;
				}
			}
		}
		closedir($handler);
	}
	return $listDir;
}
endif;

if ( ! function_exists( 'afl_theme_options_view' ) ):
function afl_theme_options_view() {
    global $__OPTIONS, $__CUSTOM_COLORS;
    global $domain_key;

	$my_theme = wp_get_theme();?>

	<form enctype="multipart/form-data" method="POST" id="afl-form-options" action="#">
		<div class="afl-options-page afl-sidebar-active">
			<div class="afl-options-page-sidebar">
            	<div class="afl-options-header"></div>
                <div class="afl-sidebar-content">
					<div class="afl-section-header afl-active-nav" id="tab-general" style="display: block;"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/theme_settings.png);">Theme Settings </strong></div>
                    <div class="afl-section-header" id="tab-blog" style="display: block;"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/blog_settings.png);">Blog Settings </strong></div>
                    <div class="afl-section-header" id="tab-caticons" style="display: block;"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/social_networks.png);">Category Icons </strong></div>
                    <div class="afl-section-header" id="tab-social" style="display: block;"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/social_networks.png);">Social Networks </strong></div>
                    <div class="afl-section-header" id="tab-fonts" style="display: block;"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/font_settings.png);">Font Replace </strong></div>
                    <div class="afl-section-header" id="tab-sidebar" style="display: block;"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/sidebar_settings.png);">Custom Sidebars </strong></div>
                    <div class="afl-section-header" id="tab-footer" style="display: block;"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/footer_settings.png);">Footer </strong></div>
					<?php
					$additional_options_page_title = '';
					echo apply_filters('afl_additional_theme_options_page_title', $additional_options_page_title);
					?>
                    <div class="afl-section-header" id="tab-dummy" style="display: block;"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/dummy_settings.png);">Dummy Import </strong></div>
                </div>
			</div>
            <div class="afl-options-page-content">
                <div class="afl-options-header">
                    <h2 class="afl-logo"><?php echo $my_theme->Name; ?> Theme Settings</h2>
                    <span class="afl-loading"></span>
                    <span class="afl-style-wrap">
						<a class="afl-button afl-submit" href="#">Save all changes</a>
                    </span>
                </div>
                <div class="afl-options-container">
					<div id="afl-tab-general" class="afl-subpage-container afl-active-container">
                        <div class="afl-section-header"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/theme_settings.png);">Theme Options </strong></div>
						<?php foreach($__OPTIONS as $k => $v): ?>
                            <?php if( in_array($v['type'], array('social', 'blog', 'font', 'sidebar', 'footer', 'styling', 'cat_icons')) ) continue; ?>
                            <div id="<?php echo $k ?>" class="afl-section <?php if(isset($v['attributes']['class'])) { echo $v['attributes']['class']; } ?>">
							<h4><?php echo $v['label'] ?></h4>
							<div class="afl-control-container">
								<div class="afl-description"><?php echo $v['description'] ?></div>
								<div class="afl-control">
								<?php if(isset($v['uploadable']) && $v['uploadable']) {
									echo '<div class="afl-upload-container afl-upload-container_'.$k.'">
											<span class="afl-style-wrap afl-upload-style-wrap">'.afl_render_theme_option($k, $v).'</span>
											<div id="'.$k.'-div" class="afl-preview-pic"></div>
										</div>';
								} else { ?>
									<div class="afl-style-wrap"><?php print afl_render_theme_option($k, $v); ?></div>
								<?php } ?>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
                    </div>
                    <div id="afl-tab-blog" class="afl-subpage-container">
                        <div class="afl-section-header"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/blog_settings.png);">Blog Settings </strong></div>
                        <div class="afl-section afl-text">
							<h4><?php echo $__OPTIONS['afl_blog_sidebar_position']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['afl_blog_sidebar_position']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap afl-select-style-wrap">
										<span class="afl-select-unify">
											<?php
											$sidebar_position = get_option('afl_blog_sidebar_position');
											$sidebar_pos = 'Right';
											?>
                                            <select name="afl_blog_sidebar_position" id="afl_blog_sidebar_position">
                                                <option value="left" <?php if($sidebar_position == 'left') echo 'selected="selected"';?>>Right</option>
                                                <option value="right" <?php if($sidebar_position == 'right') { echo 'selected="selected"'; $sidebar_pos = 'Left'; } ?>>Left</option>
                                                <option value="none" <?php if($sidebar_position == 'none') { echo 'selected="selected"'; $sidebar_pos = 'No Sidebar'; } ?>>No Sidebar</option>
                                            </select>
                                            <span class="afl-select-fake-val"><?php echo $sidebar_pos;?></span>
										</span>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
						<div class="afl-section afl-text">
							<h4><?php echo $__OPTIONS['afl_blog_sidebar']['label']?></h4>
							<div class="afl-control-container">
								<div class="afl-description"><?php echo $__OPTIONS['afl_blog_sidebar']['description']?></div>
								<div class="afl-control">
								<span class="afl-style-wrap afl-select-style-wrap">
									<span class="afl-select-unify">
										<?php
											$sidebar_slug = get_option('afl_blog_sidebar');
											$sidebar_name = 'Default Sidebar';
										?>
										<select name="afl_blog_sidebar" id="afl_blog_sidebar">
											<option value="default" <?php if(in_array($sidebar_slug, array('default', ''))) echo 'selected="selected"'; ?>>Default Sidebar</option>
											<?php if ( $sidebars = unserialize($__OPTIONS['afl_sidebar']['default_value']) ) {
											foreach ($sidebars as $sidebar) { ?>
												<option value="<?php echo $sidebar['slug']; ?>" <?php if($sidebar['slug'] == $sidebar_slug) { echo 'selected="selected"'; $sidebar_name = $sidebar['name']; } ?>><?php echo $sidebar['name']; ?></option>
												<?php
											}
										} ?>

										</select>
										<span class="afl-select-fake-val"><?php echo $sidebar_name;?></span>
									</span>
								</span>
								</div>
								<div class="afl-clear"></div>
							</div>
						</div>
                        <div class="afl-section afl-text">
                            <h4><?php echo $__OPTIONS['default_comment_status']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['default_comment_status']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap">
									<?php print afl_render_theme_option("default_comment_status", array('type' => 'checkbox', 'default_value' => get_option('default_comment_status'),'attributes' => array('class' => 'regular-text', 'name' => "default_comment_status"))); ?>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-section afl-text">
                            <h4><?php echo $__OPTIONS['posts_per_page']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['posts_per_page']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap">
									<?php print afl_render_theme_option("posts_per_page", array('type' => 'text', 'default_value' => get_option('posts_per_page'),'attributes' => array('class' => 'regular-text', 'name' => "posts_per_page"))); ?>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-section afl-text">
                            <h4><?php echo $__OPTIONS['afl_excerpt']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['afl_excerpt']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap">
									<?php print afl_render_theme_option("afl_excerpt", array('type' => 'text', 'default_value' => get_option('afl_excerpt'),'attributes' => array('class' => 'regular-text', 'name' => "afl_excerpt"))); ?>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-section afl-text">
                            <h4><?php echo $__OPTIONS['afl_readmore']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['afl_readmore']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap">
									<?php print afl_render_theme_option("afl_readmore", array('type' => 'text', 'default_value' => get_option('afl_readmore'),'attributes' => array('class' => 'regular-text', 'name' => "afl_readmore"))); ?>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-section afl-text">
                            <h4><?php echo $__OPTIONS['afl_readmore_enable']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['afl_readmore_enable']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap">
									<?php print afl_render_theme_option("afl_readmore_enable", array('type' => 'checkbox', 'default_value' => get_option('afl_readmore_enable'),'attributes' => array('class' => 'regular-text', 'name' => "afl_readmore_enable"))); ?>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-section afl-text">
                            <h4><?php echo $__OPTIONS['hide_post_categories']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['hide_post_categories']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap">
									<?php print afl_render_theme_option("hide_post_categories", array('type' => 'checkbox', 'default_value' => get_option('hide_post_categories'),'attributes' => array('class' => 'regular-text', 'name' => "hide_post_categories"))); ?>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-section afl-text">
                            <h4><?php echo $__OPTIONS['hide_post_comments_meta']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['hide_post_comments_meta']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap">
									<?php print afl_render_theme_option("hide_post_comments_meta", array('type' => 'checkbox', 'default_value' => get_option('hide_post_comments_meta'),'attributes' => array('class' => 'regular-text', 'name' => "hide_post_comments_meta"))); ?>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-section afl-text">
                            <h4><?php echo $__OPTIONS['show_post_featured']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['show_post_featured']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap">
									<?php print afl_render_theme_option("show_post_featured", array('type' => 'checkbox', 'default_value' => get_option('show_post_featured'),'attributes' => array('class' => 'regular-text', 'name' => "show_post_featured"))); ?>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-section afl-text">
                            <h4><?php echo $__OPTIONS['display_author_info']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['display_author_info']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap">
									<?php print afl_render_theme_option("display_author_info", array('type' => 'checkbox', 'default_value' => get_option('display_author_info'),'attributes' => array('class' => 'regular-text', 'name' => "display_author_info"))); ?>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                    </div>
                    <div id="afl-tab-caticons" class="afl-subpage-container">
                        <div class="afl-section-header"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/social_networks.png);">Social Networks </strong></div>
                        <?php

                        $next_value = 0;
                        $categories = get_categories( array('hide_empty' => 0) );
                        $afl_cat_icons = (false===($afl_cat_icons = unserialize($__OPTIONS['afl_cat_icons']['default_value']))?unserialize($__OPTIONS['afl_cat_icons']['default_value']):$afl_cat_icons);
                        //var_export($categories);
                        global $categoryIcons;
                        if(is_array($categories)){
                            foreach ($categories as $cat) {
                                ?>
                                <div class="afl-single-set">
                                    <div class="afl-section afl-text afl-3columns afl-col-1">
                                        <h4>Category Name</h4>
                                        <div class="afl-control-container">
                                            <div class="afl-description"></div>
                                            <div class="afl-control">
													<span class="afl-style-wrap">
                                                        <input type="hidden" name="category_id[<?php echo $next_value; ?>]" value="<?php echo $cat->cat_ID; ?>"/>
													<?php print afl_render_theme_option("afl_category_name_{$next_value}", array('type' => 'text', 'default_value' => $cat->name, 'attributes' => array('class' => 'regular-text', 'name' => "afl_category_name[{$next_value}]"))); ?>
													</span>
                                            </div>
                                            <div class="afl-clear"></div>
                                        </div>
                                    </div>

                                    <div class="afl-section afl-text afl-3columns afl-col-2">
                                        <h4>Category icon</h4>
                                        <div class="afl-control-container">
                                            <div class="afl-description"></div>
                                            <div class="afl-control">
													<span class="afl-style-wrap afl-select-style-wrap">
														<span class="afl-select-unify">
															<?php print afl_render_theme_option("afl_category_icon_{$next_value}", array('type' => 'select', 'default_value' => (empty($afl_cat_icons[$cat->cat_ID]) ? '' : $afl_cat_icons[$cat->cat_ID]), 'options' => $categoryIcons,'attributes' => array('class' => 'regular-text', 'name' => "afl_category_icon[{$next_value}]"))); ?>
                                                            <span class="afl-select-fake-val"></span>
														</span>
													</span>
                                            </div>
                                            <div class="afl-clear"></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $next_value++;
                            }
                        }




                        ?>
                    </div>
                    <div id="afl-tab-social" class="afl-subpage-container">
                        <div class="afl-section-header"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/social_networks.png);">Social Networks </strong></div>
						<?php
						$next_value = 0;
						$listSocials = get_socials_list();
						$socials = (false===($socials = unserialize($__OPTIONS['afl_social']['default_value']))?unserialize($__OPTIONS['afl_social']['default_value']):$socials);
							if(is_array($socials)){
								foreach($socials as $social){
									?>
									<div class="afl-single-set">
										<div class="afl-section afl-text afl-3columns afl-col-1">
											<h4>Social url</h4>
											<div class="afl-control-container">
												<div class="afl-description"></div>
												<div class="afl-control">
													<span class="afl-style-wrap">
													<?php print afl_render_theme_option("afl_social_url_{$next_value}", array('type' => 'text', 'default_value' => $social['url'], 'attributes' => array('class' => 'regular-text', 'name' => "afl_social_url[{$next_value}]"))); ?>
													</span>
												</div>
												<div class="afl-clear"></div>
											</div>
										</div>
										<div class="afl-section afl-text afl-3columns afl-col-2">
											<h4>Social title</h4>
											<div class="afl-control-container">
												<div class="afl-description"></div>
												<div class="afl-control">
													<span class="afl-style-wrap">
													<?php print afl_render_theme_option("afl_social_title_{$next_value}", array('type' => 'text', 'default_value' => $social['title'], 'attributes' => array('class' => 'regular-text', 'name' => "afl_social_title[{$next_value}]"))); ?>
													</span>
												</div>
												<div class="afl-clear"></div>
											</div>
										</div>
										<div class="afl-section afl-text afl-3columns afl-col-3">
											<h4>Social image</h4>
											<div class="afl-control-container">
												<div class="afl-description"></div>
                                                <div class="afl-control">
													<span class="afl-style-wrap afl-select-style-wrap">
														<span class="afl-select-unify">
															<?php print afl_render_theme_option("afl_social_image_{$next_value}", array('type' => 'select', 'default_value' => $social['image'], 'options' => $listSocials,'attributes' => array('class' => 'regular-text', 'name' => "afl_social_image[{$next_value}]"))); ?>
															<span class="afl-select-fake-val"></span>
														</span>
													</span>
                                                </div>
												<div class="afl-clear"></div>
											</div>
										</div>
										<a class="afl-social-delete afl-remove-set" href="#">Delete</a>
									</div>
									<?php
									$next_value++;
								}
							}
						?>
									<div class="afl-single-set">
										<div class="afl-section afl-text afl-3columns afl-col-1">
											<h4>Social url</h4>
											<div class="afl-control-container">
												<div class="afl-description"></div>
												<div class="afl-control">
																<span class="afl-style-wrap">
																<?php print afl_render_theme_option("afl_social_url_{$next_value}", array('type' => 'text', 'attributes' => array('class' => 'regular-text', 'name' => "afl_social_url[{$next_value}]"))); ?>
																</span>
												</div>
												<div class="afl-clear"></div>
											</div>
										</div>
										<div class="afl-section afl-text afl-3columns afl-col-2">
											<h4>Social title</h4>
											<div class="afl-control-container">
												<div class="afl-description"></div>
												<div class="afl-control">
																<span class="afl-style-wrap">
																<?php print afl_render_theme_option("afl_social_title_{$next_value}", array('type' => 'text', 'attributes' => array('class' => 'regular-text', 'name' => "afl_social_title[{$next_value}]"))); ?>
																</span>
												</div>
												<div class="afl-clear"></div>
											</div>
										</div>
										<div class="afl-section afl-text afl-3columns afl-col-3">
											<h4>Social image</h4>
											<div class="afl-control-container">
												<div class="afl-description"></div>
                                                <div class="afl-control">
													<span class="afl-style-wrap afl-select-style-wrap">
														<span class="afl-select-unify">
															<?php print afl_render_theme_option("afl_social_image_{$next_value}", array('type' => 'select', 'options' => $listSocials,'attributes' => array('class' => 'regular-text', 'name' => "afl_social_image[{$next_value}]"))); ?>
                                                            <span class="afl-select-fake-val"></span>
														</span>
													</span>
                                                </div>
												<div class="afl-clear"></div>
											</div>
										</div>
                                        <a class="afl-social-add afl-clone-set" href="#">Add another Form Element</a>
									</div>
                    </div>
                    <div id="afl-tab-fonts" class="afl-subpage-container">
                        <div class="afl-section-header"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/font_settings.png);">Font Replace </strong></div>
						<?php
						//prepare select options
						$fonts = afl_get_google_font_list();
						$options = array();
						$tooltip = 'Meta tags'.implode(', ', array_keys(afl_get_meta_tag_list()));
						$options[""] = "--Select font--";
						foreach($fonts as $font){
							$options[str_replace(' ', '+', trim($font))] = $font;
						}

						?>
						<?php
						$next_value = 0;
						if(is_array($fonts = unserialize($__OPTIONS['afl_font']['default_value']))){
							foreach($fonts as $font){
								?>
								<div class="afl-single-set">
									<div class="afl-section afl-text afl-3columns afl-col-1">
										<h4>Tag name(Selector)</h4>
										<div class="afl-control-container">
											<div class="afl-description"></div>
											<div class="afl-control">
												<span class="afl-style-wrap">
												<?php print afl_render_theme_option("afl_font_selector_{$next_value}", array('type' => 'text', 'default_value' => $font['selector'], 'attributes' => array('title' => $tooltip, 'class' => 'regular-text', 'name' => "afl_font_selector[{$next_value}]"))); ?>
												</span>
											</div>
											<div class="afl-clear"></div>
										</div>
									</div>
									<div class="afl-section afl-text afl-3columns afl-col-2">
										<h4>Color</h4>
										<div class="afl-control-container">
											<div class="afl-description"></div>
											<div class="afl-control">
												<span class="afl-style-wrap afl-colorpicker-style-wrap">
													<?php print afl_render_theme_option("afl_font_color_{$next_value}", array('type' => 'text', 'default_value' => (!empty($font['color'])?$font['color']:'#'), 'attributes' => array('name' => "afl_font_color[{$next_value}]", 'class' => "afl-color-picker"))); ?>
													<span class="afl_color_picker_div" style="background-color: <?php echo (!empty($font['color'])?$font['color']:'#000000') ?>;"></span>
												</span>
											</div>
											<div class="afl-clear"></div>
										</div>
									</div>
									<div class="afl-section afl-text afl-3columns afl-col-3">
										<h4>Font</h4>
										<div class="afl-control-container">
											<div class="afl-description"></div>
											<div class="afl-control">
												<span class="afl-style-wrap afl-select-style-wrap">
													<span class="afl-select-unify font-select">
													<?php print afl_render_theme_option("afl_font_name_{$next_value}", array('type' => 'select', 'default_value' => $font['font'], 'options' => $options,'attributes' => array('class' => 'regular-text', 'name' => "afl_font_name[{$next_value}]"))); ?>
														<span class="afl-select-fake-val" <?php echo (!empty($font['color'])? 'style="color:'.$font['color'].';"':'') ?>></span>
													</span>
												</span>
											</div>
											<div class="afl-clear"></div>
										</div>
									</div>
                                    <a class="afl-font-delete afl-remove-set" href="#">Delete</a>
								</div>
								<?php
								$next_value++;
							}
						}
						?>
                        <div class="afl-single-set">
                            <div class="afl-section afl-text afl-3columns afl-col-1">
                                <h4>Tag name(Selector)</h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
										<span class="afl-style-wrap">
										<?php print afl_render_theme_option("afl_font_selector_{$next_value}", array('type' => 'text', 'attributes' => array('title' => $tooltip, 'class' => 'regular-text', 'name' => "afl_font_selector[{$next_value}]"))); ?>
										</span>
                                    </div>
                                    <div class="afl-clear"></div>
                                </div>
                            </div>
                            <div class="afl-section afl-text afl-3columns afl-col-2">
                                <h4>Color</h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
										<span class="afl-style-wrap afl-colorpicker-style-wrap">
											<?php print afl_render_theme_option("afl_font_color_{$next_value}", array('type' => 'text', 'default_value' => '#000000', 'attributes' => array('name' => "afl_font_color[{$next_value}]", 'class' => "afl-color-picker"))); ?>
											<span class="afl_color_picker_div" style="background-color: #000000;"></span>
										</span>
                                    </div>
                                    <div class="afl-clear"></div>
                                </div>
                            </div>
                            <div class="afl-section afl-text afl-3columns afl-col-3">
                                <h4>Font</h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
										<span class="afl-style-wrap afl-select-style-wrap">
											<span class="afl-select-unify font-select">
											<?php print afl_render_theme_option("afl_font_name_{$next_value}", array('type' => 'select', 'options' => $options,'attributes' => array('class' => 'regular-text', 'name' => "afl_font_name[{$next_value}]"))); ?>
                                            <span class="afl-select-fake-val"></span>
											</span>
										</span>
                                    </div>
                                    <div class="afl-clear"></div>
                                </div>
                            </div>
                            <a class="afl-font-add afl-clone-set" href="#">Add another Form Element</a>
                        </div>
                    </div>
                    <div id="afl-tab-sidebar" class="afl-subpage-container">
                        <div class="afl-section-header"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/sidebar_settings.png);">Custom Sidebars </strong></div>
						<?php
						$next_value = 0;
						$sidebars = (false===($sidebars = unserialize($__OPTIONS['afl_sidebar']['default_value']))?unserialize($__OPTIONS['afl_sidebar']['default_value']):$sidebars);
						if(is_array($sidebars)){
							foreach($sidebars as $sidebar){
								?>
                                <div class="afl-single-set">
                                    <div class="afl-section afl-text afl-3columns afl-col-1">
                                        <h4>Sidebar name</h4>
                                        <div class="afl-control-container">
                                            <div class="afl-description"></div>
                                            <div class="afl-control">
													<span class="afl-style-wrap">
													<?php print afl_render_theme_option("afl_sidebar_name_{$next_value}", array('type' => 'text', 'default_value' => $sidebar['name'], 'attributes' => array('class' => 'regular-text', 'name' => "afl_sidebar_name[{$next_value}]"))); ?>
													</span>
                                            </div>
                                            <div class="afl-clear"></div>
                                        </div>
                                    </div>
                                    <div class="afl-section afl-text afl-3columns afl-col-2">
                                        <h4>Slug</h4>
                                        <div class="afl-control-container">
                                            <div class="afl-description"></div>
                                            <div class="afl-control">
													<span class="afl-style-wrap">
													<?php print afl_render_theme_option("afl_sidebar_slug_{$next_value}", array('type' => 'text', 'default_value' => $sidebar['slug'], 'attributes' => array('class' => 'regular-text', 'name' => "afl_sidebar_slug[{$next_value}]"))); ?>
													</span>
                                            </div>
                                            <div class="afl-clear"></div>
                                        </div>
                                    </div>
                                    <div class="afl-section afl-text afl-3columns afl-col-3">
                                        <h4>Description</h4>
                                        <div class="afl-control-container">
                                            <div class="afl-description"></div>
                                            <div class="afl-control">
													<span class="afl-style-wrap">
													<?php print afl_render_theme_option("afl_sidebar_description_{$next_value}", array('type' => 'text', 'default_value' => $sidebar['description'], 'attributes' => array('class' => 'regular-text', 'name' => "afl_sidebar_description[{$next_value}]"))); ?>
													</span>
                                            </div>
                                            <div class="afl-clear"></div>
                                        </div>
                                    </div>
                                    <a class="afl-social-delete afl-remove-set" href="#">Delete</a>
                                </div>
								<?php
								$next_value++;
							}
						}
						?>
                        <div class="afl-single-set">
                            <div class="afl-section afl-text afl-3columns afl-col-1">
                                <h4>Sidebar name</h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
										<span class="afl-style-wrap">
										<?php print afl_render_theme_option("afl_sidebar_name_{$next_value}", array('type' => 'text', 'attributes' => array('class' => 'regular-text', 'name' => "afl_sidebar_name[{$next_value}]"))); ?>
										</span>
                                    </div>
                                    <div class="afl-clear"></div>
                                </div>
                            </div>
                            <div class="afl-section afl-text afl-3columns afl-col-2">
                                <h4>Slug</h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
										<span class="afl-style-wrap">
										<?php print afl_render_theme_option("afl_sidebar_slug_{$next_value}", array('type' => 'text', 'attributes' => array('class' => 'regular-text', 'name' => "afl_sidebar_slug[{$next_value}]"))); ?>
										</span>
                                    </div>
                                    <div class="afl-clear"></div>
                                </div>
                            </div>
                            <div class="afl-section afl-text afl-3columns afl-col-3">
                                <h4>Description</h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
										<span class="afl-style-wrap">
										<?php print afl_render_theme_option("afl_sidebar_description_{$next_value}", array('type' => 'text', 'attributes' => array('class' => 'regular-text', 'name' => "afl_sidebar_description[{$next_value}]"))); ?>
										</span>
                                    </div>
                                    <div class="afl-clear"></div>
                                </div>
                            </div>
                            <a class="afl-social-add afl-clone-set" href="#">Add another Form Element</a>
                        </div>
                    </div>
                    <div id="afl-tab-footer" class="afl-subpage-container">
                        <div class="afl-section-header"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/footer_settings.png);">Footer </strong></div>
                        <div class="afl-section afl-text">
                            <h4><?php echo $__OPTIONS['afl_footer']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['afl_footer']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap afl-select-style-wrap">
										<span class="afl-select-unify">
										<?php print afl_render_theme_option("afl_footer_cols", array('type' => 'select', 'options' => array(1,2,3,4), 'default_value' => get_option('afl_footer'),'attributes' => array('class' => 'regular-text', 'name' => "afl_footer_cols"))); ?>
                                            <span class="afl-select-fake-val"><?php $num_cols = get_option('afl_footer') + 1; echo "{$num_cols}";?></span>
										</span>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-section afl-text">
                            <h4><?php echo $__OPTIONS['afl_footer_copyright']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['afl_footer_copyright']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap">
									<?php print afl_render_theme_option("afl_footer_copyright", array('type' => 'textarea', 'default_value' => get_option('afl_footer_copyright'),'attributes' => array('class' => 'regular-text', 'name' => "afl_footer_copyright"))); ?>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-section afl-text">
                            <h4><?php echo $__OPTIONS['afl_counter_code']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['afl_counter_code']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap">
									<?php print afl_render_theme_option("afl_counter_code", array('type' => 'textarea', 'default_value' => get_option('afl_counter_code'),'attributes' => array('class' => 'regular-text', 'name' => "afl_counter_code"))); ?>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                    </div>
					<?php
						$additional_options_page = '';
						echo apply_filters('afl_additional_theme_options_page', $additional_options_page);
					?>
                    <div id="afl-tab-dummy" class="afl-subpage-container">
                        <div class="afl-section-header"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/dummy_settings.png);">Import Dummy Content </strong></div>
                        <div id="afl-import" class="afl-section afl-import">
                            <div id="dummy" style="text-align: right; width:8px; height:5px; cursor:pointer; float:right;"><img src="<?php echo get_template_directory_uri(); ?>/images/link-marker.gif" alt="Export Dummy"/></div>
                            <script type="text/javascript">
                                function perform_import(container, url, loading_text){
                                    jQuery(container).click(function(){
                                        jQuery(".afl-import-wait").css({'display':'block'}).html(loading_text);
                                        jQuery('#import_result').load(url, function(response, status, xhr){
                                            if (status == "error") {
                                                var msg = "Sorry but there was an error: ";
                                                jQuery(".afl-import-wait").html(msg + xhr.status + " " + xhr.statusText);
                                            } else {
                                                jQuery(".afl-import-wait").html('Success!');
                                            }
                                        });
                                    });
                                }

                                jQuery.ajaxSetup({
                                    cache:false,
                                    beforeSend: function() {
                                        jQuery('.afl-import-loading').css({'visibility':'visible'});
                                    },
                                    success: function() {
                                        jQuery('.afl-import-loading').css({'visibility':'hidden'});
                                    }
                                });
                                var ajax_load = 'Please wait for Export Complete message!<br/>It might take a couple of minutes.';
                                var loadUrl = "<?php echo get_template_directory_uri()."/lib/ajax.php"; ?>";
                                perform_import("#dummy", loadUrl, ajax_load);
                            </script>
                            <h4>Import Dummy Content: Posts, Pages, Categories</h4>
                            <div class="afl-control-container">
                                <div class="afl-description">Dummy Import provides you with pre-created content so you could see the abilities of this template. If you need such a help, go ahead and push the Button.<br/>Note: Dummy Import overwrites your settings(if there is any).</div>
								<span class="afl-style-wrap">
									<span class="afl-button afl-import-button" id="dummy_import">Import dummy data</span>
								</span>
                                <span class="afl-loading afl-import-loading"><img src="<?php echo get_template_directory_uri()."/lib/css/images/file-preloader.gif"; ?>" alt="Loading..."/></span>
								<span id="import_result" style="display:none;"></span>
                                <div class="afl-import-wait">
                                    <strong>Import started.</strong>
                                    <br>
                                    Please wait a few seconds and don't reload the page. You will be notified as soon as the import has finished! :)
                                </div>
                                <div class="afl-import-result"></div>
                                <script type="text/javascript">
                                    var ajax_import = 'Please wait for Import Complete message!<br/>It might take a couple of minutes.';
                                    var OutUrl = "<?php echo get_template_directory_uri().'/lib/inc/import.php'; ?>";
                                    perform_import("#dummy_import", OutUrl, ajax_import);
                                </script>
							</div>
                            <div class="afl-clear"></div>
						</div>
                    </div>
                </div>
                <div class="afl-options-footer">
					<?php wp_nonce_field('theme-option'); ?>
                    <input type="hidden" name="afl_theme_tab" id="afl-theme-tab" value="<?php print intval($_POST['afl_theme_tab']); ?>" />
                    <input type="hidden" name="save_changes" value="true" />
					<ul class="afl-footer-links">
                        <li class="afl-footer-save"><span class="afl-style-wrap"><a class="afl-button afl-submit" href="#">Save all changes</a></span></li>
					</ul>
                </div>
			</div>
            <div class="afl-clear"></div>
		</div>
	</form>
    <div class="afl-clear"></div>
    <script type="text/javascript">
		check();
	</script>
<?php
}
endif;

?>
