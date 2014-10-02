<?php
/**
 * Custom background
 */

/**
 * Adding new page to admin menu
 */
if ( ! function_exists( 'afl_backgrounds_admin_menu_hook' ) ):
function afl_backgrounds_admin_menu_hook(){
    if ( ! current_user_can('edit_theme_options') )
        return;
	//$page = add_submenu_page( "theme-options", "Backgrounds", "Backgrounds", 'edit_theme_options', 'custom-backgrounds', 'afl_backgrounds_page_hook' );
    $page = add_theme_page( "Backgrounds", "Backgrounds", 'edit_theme_options', 'custom-backgrounds', 'afl_backgrounds_page_hook' );
	add_action("load-$page", 'afl_backgrounds_handle_upload_hook', 49);
    add_action("load-$page", 'afl_backgrounds_action_hook', 49);
}
endif;
add_action('admin_menu', 'afl_backgrounds_admin_menu_hook');
/**
 * Backgrounds page view
 */
if ( ! function_exists( 'afl_backgrounds_page_hook' ) ):
function afl_backgrounds_page_hook(){
    $parts = afl_get_background_parts();
?>
<?php
	global $afl_bgupdated;
	if ( !empty($afl_bgupdated) ) { ?>
    <div id="message" class="updated">
        <p><?php printf( __( 'Background updated. <a href="%s">Visit your site</a> to see how it looks.' ), home_url( '/' ) ); ?></p>
    </div>
	<?php } ?>
	<div id="afl-form-options">
		<div class="afl-options-page afl-sidebar-active">
			<div class="afl-options-page-sidebar">
                <div class="afl-options-header"></div>
                <div class="afl-sidebar-content">
					<?php
					$i = 0;
					foreach($parts as $part){ ?>
                    <div class="afl-section-header <?php if(!$i) echo "afl-active-nav"; ?>" id="<?php print $part ?>-background-tab" style="display: block;"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/bg_<?php echo $part; ?>.png);"><?php echo ucfirst($part).' background'; ?> </strong></div>
					<?php $i++; } ?>
                </div>
            </div>
			<div class="afl-options-page-content">
				<div class="afl-options-header">
					<h2 class="afl-logo"><?php screen_icon(); ?> Custom Backgrounds</h2>
				</div>
				<div class="afl-options-container" id="afl-background-options">
					<?php
					$i = 0;
					foreach($parts as $part){ ?>
					<div id="afl-<?php print $part ?>-background-tab" class="afl-subpage-container <?php if(!$i) echo "afl-active-container"; ?>"><?php _afl_render_background_page($part); ?></div>
					<?php $i++; } ?>
				</div>
			</div>
            <div class="afl-clear"></div>
		</div>
    </div>
	<script type="text/javascript">
		check();
	</script>
<?php
}
endif;

/**
 * Backgrounds actions catcher
 */
if ( ! function_exists( 'afl_backgrounds_action_hook' ) ):
function afl_backgrounds_action_hook(){
    if ( empty($_POST) || !isset($_POST['afl_bgpart'])){
        return;
    }

    global $afl_bgupdated;

    $part = $_POST['afl_bgpart'];

    if ( isset($_POST['reset-background']) ) {
        check_admin_referer("custom-$part-background-reset", "_wpnonce-custom-$part-background-reset");
		set_theme_mod("afl_{$part}_background_image", constant(strtoupper($part).'_BACKGROUND_IMAGE'));
		set_theme_mod("afl_{$part}_background_image_thumb", constant(strtoupper($part).'_BACKGROUND_IMAGE'));
	$afl_bgupdated = true;
	return;
    }

    if ( isset($_POST['remove-background']) ) {
        // @TODO: Uploaded files are not removed here.
        check_admin_referer("custom-$part-background-remove", "_wpnonce-custom-$part-background-remove");
        set_theme_mod("afl_{$part}_background_image", '');
        set_theme_mod("afl_{$part}_background_image_thumb", '');
		$afl_bgupdated = true;
	return;
    }

    if ( isset($_POST['background-repeat']) ) {
        check_admin_referer("custom-$part-background", "_wpnonce-custom-$part-background");
        if ( in_array($_POST['background-repeat'], array('repeat', 'no-repeat', 'repeat-x', 'repeat-y')) )
            $repeat = $_POST['background-repeat'];
	else
            $repeat = 'repeat';
	set_theme_mod("afl_{$part}_background_repeat", $repeat);
        $afl_bgupdated = true;
    }

    if ( isset($_POST['background-position-x']) ) {
        check_admin_referer("custom-$part-background", "_wpnonce-custom-$part-background");
	if ( in_array($_POST['background-position-x'], array('center', 'right', 'left')) )
            $position = $_POST['background-position-x'];
	else
            $position = 'left';
	set_theme_mod("afl_{$part}_background_position_x", $position);
        $afl_bgupdated = true;
    }

    if ( isset($_POST['background-attachment']) ) {
        check_admin_referer("custom-$part-background", "_wpnonce-custom-$part-background");
        if ( in_array($_POST['background-attachment'], array('fixed', 'scroll')) )
            $attachment = $_POST['background-attachment'];
        else
            $attachment = 'fixed';
        set_theme_mod("afl_{$part}_background_attachment", $attachment);
        $afl_bgupdated = true;
    }

    if ( isset($_POST['background-color']) ) {
        check_admin_referer("custom-$part-background", "_wpnonce-custom-$part-background");
        $color = preg_replace('/[^0-9a-fA-F]/', '', $_POST['background-color']);
        if ( strlen($color) == 6 || strlen($color) == 3 )
            set_theme_mod("afl_{$part}_background_color", $color);
	else
            set_theme_mod("afl_{$part}_background_color", '');
        $afl_bgupdated = true;
    }

	if( isset($_POST['color_transparent']) ) {
		check_admin_referer("custom-$part-background", "_wpnonce-custom-$part-background");
		set_theme_mod("afl-{$part}-color-transparent", true);
	} else {
		check_admin_referer("custom-$part-background", "_wpnonce-custom-$part-background");
		set_theme_mod("afl-{$part}-color-transparent", false);
	}

    if($part=='page'){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            check_admin_referer("custom-$part-background", "_wpnonce-custom-$part-background");
            if ( isset($_POST["use_slides"]) ) {
                set_theme_mod("afl_{$part}_use_slides", true);
            }
            else{
                set_theme_mod("afl_{$part}_use_slides", false);
            }
        }
        if ( isset($_POST["slides"]) && is_array($_POST["slides"])) {
            check_admin_referer("custom-$part-background", "_wpnonce-custom-$part-background");
            $slides = array();
            foreach($_POST["slides"] as $slide){
                if(trim($slide['image'])!=''){
                    $slides[] = array(
                        'title' => $slide['title'],
                        'image' => esc_url($slide['image']),
                        'thumb' => esc_url($slide['thumb'])
                    );
                }
            }
            set_theme_mod("afl_{$part}_slides", $slides);
        }
    }
}
endif;

/**
 * Backgrounds handle image uploads
 */
if ( ! function_exists( 'afl_backgrounds_handle_upload_hook' ) ):
function afl_backgrounds_handle_upload_hook(){
    if ( empty($_FILES) || !isset($_POST['afl_bgpart_upload']) )
        return;

    $part = $_POST['afl_bgpart_upload'];

    check_admin_referer("custom-$part-background-upload", "_wpnonce-custom-$part-background-upload");
    $overrides = array('test_form' => false);
    $file = wp_handle_upload($_FILES['import'], $overrides);

    if ( isset($file['error']) )
        wp_die( $file['error'] );

    $url = $file['url'];
    $type = $file['type'];
    $file = $file['file'];
    $filename = basename($file);

    // Construct the object array
    $object = array(
	'post_title' => $filename,
	'post_content' => $url,
	'post_mime_type' => $type,
	'guid' => $url
    );

    // Save the data
    $id = wp_insert_attachment($object, $file);

    // Add the meta-data
    wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file ) );

    set_theme_mod("afl_{$part}_background_image", esc_url($url));

    $thumbnail = wp_get_attachment_image_src( $id, 'thumbnail' );
    set_theme_mod("afl_{$part}_background_image_thumb", esc_url( $thumbnail[0] ) );

    do_action('wp_create_file_in_uploads', $file, $id); // For replication
    global $afl_bgupdated;
    $afl_bgupdated = true;
}
endif;

/**
 * Backgrounds render separate page
 * @param String $part
 */

if ( ! function_exists( '_afl_render_background_page' ) ):
function _afl_render_background_page($part = 'page'){
    $part = htmlentities($part);
?>
<div class="afl-section-header"><strong class="afl-page-title" style="background-Image:url(<?php echo get_template_directory_uri(); ?>/lib/css/images/icons/hammer_screwdriver.png);"><?php echo ucfirst($part)." Background"; ?> </strong></div>
<h3>Background Image</h3>
<div class="afl-section">
    <h4>Preview</h4>
    <div class="afl-control-container">
    <div class="afl-description"></div>
<?php
$background_styles = '';
if(!get_theme_mod("afl-{$part}-color-transparent", false))
	$bgcolor = '#'.get_theme_mod("afl_{$part}_background_color", '');
else
	$bgcolor = 'transparent';

	$background_styles .= 'background-color: ' . $bgcolor . ';';

if ( $bg_image = get_theme_mod("afl_{$part}_background_image", '') ) {
	// background-image URL must be single quote, see below
	$background_styles .= ' background-image: url(\'' . get_theme_mod("afl_{$part}_background_image_thumb", '') . '\');'
		. ' background-repeat: ' . get_theme_mod("afl_{$part}_background_repeat", 'repeat') . ';'
		. ' background-position: top ' . get_theme_mod("afl_{$part}_background_position_x", 'left');
}
?>
	<div id="custom-<?php print $part; ?>-background-image" class="custom-part-background-image" style="<?php echo $background_styles; ?>"><?php // must be double quote, see above ?>
        <img class="custom-background-image" src="<?php echo get_theme_mod("afl_{$part}_background_image_thumb", ''); ?>" style="visibility:hidden;" alt="" /><br />
        <img class="custom-background-image" src="<?php echo get_theme_mod("afl_{$part}_background_image_thumb", ''); ?>" style="visibility:hidden;" alt="" />
	</div>
	</div>
<?php if ( $bg_image ) : ?>
	<br/>
    <h4>Remove Image</h4>
    <div class="afl-control-container">
    <div class="afl-description">This will remove the background image. You will not be able to get back to uploaded image if any.</div>
	<form method="post" action="">
    <input type="hidden" name="remove-background" value="true" />
	<input type="hidden" name="afl_bgpart" value="<?php print $part ?>" />
	<?php wp_nonce_field("custom-$part-background-remove", "_wpnonce-custom-$part-background-remove"); ?>
    <span class="afl-style-wrap"><span class="afl-button afl-button-red afl-remove-background">Remove Background Image</span></span>
	</form>
	</div>
<?php endif; ?>

<?php if ( defined( strtoupper($part).'_BACKGROUND_IMAGE' ) ) : // Show only if a default background image exists ?>
    <br/>
    <h4>Restore Original Image</h4>
    <div class="afl-control-container">
    <div class="afl-description">This will restore the original background image. You will not be able to get back to uploaded image if any.</div>
    <form method="post" action="">
        <input type="hidden" name="reset-background" value="true" />
        <input type="hidden" name="afl_bgpart" value="<?php print $part ?>" />
		<?php wp_nonce_field("custom-$part-background-reset", "_wpnonce-custom-$part-background-reset"); ?>
        <span class="afl-style-wrap"><span class="afl-button afl-button-grey afl-reset-background">Restore Original Image</span></span>
	</form>
	</div>
<?php endif; ?>
    <br/>
	<h4>Upload Image</h4>
    <div class="afl-control-container">
    <div class="afl-description">Upload an image from your computer.</div>
	<form enctype="multipart/form-data" id="upload-form-<?php print $part ?>" method="post" action="">
	<input type="file" id="upload-<?php print $part ?>" name="import" />
	<input type="hidden" name="action" value="save" />
	<input type="hidden" name="afl_bgpart_upload" value="<?php print $part ?>" />
	<?php wp_nonce_field("custom-$part-background-upload", "_wpnonce-custom-$part-background-upload") ?>
	<?php submit_button( __( 'Upload', 'afl' ), 'button', 'submit', false ); ?>
	</form>
	</div>
</div>

<div class="afl-clear"></div>
<h3>Display Options</h3>
<form method="post" action="">
	<?php if ( $bg_image ) : ?>
		<div class="afl-single-set display-options">
        	<div class="afl-section afl-text afl-3columns afl-col-1">
            <h4>Position</h4>
            <div class="afl-control-container">
                <div class="afl-description"></div>
                <div class="afl-control">
					<span class="afl-style-wrap afl-select-style-wrap">
						<span class="afl-select-unify">
						<?php print afl_render_theme_option("{$part}-background-position-x", array('type' => 'select', 'options' => array("left", "right", "center"),'default_value' => get_theme_mod("afl_{$part}_background_position_x", 'left'), 'background' => true, 'attributes' => array('class' => 'regular-text', 'name' => "background-position-x"))); ?>
                            <span class="afl-select-fake-val"><?php get_theme_mod("afl_{$part}_background_position_x", 'left'); ?></span>
						</span>
					</span>
                </div>
                <div class="afl-clear"></div>
            </div>
            </div>
        	<div class="afl-section afl-text afl-3columns afl-col-2">
			<h4>Repeat</h4>
			<div class="afl-control-container">
				<div class="afl-description"></div>
				<div class="afl-control">
					<span class="afl-style-wrap afl-select-style-wrap">
						<span class="afl-select-unify">
						<?php print afl_render_theme_option("{$part}-background-repeat", array('type' => 'select', 'options' => array("repeat", "no-repeat", "repeat-x", "repeat-y"),'default_value' => get_theme_mod("afl_{$part}_background_repeat", 'repeat'), 'background' => true, 'attributes' => array('class' => 'regular-text', 'name' => "background-repeat"))); ?>
                            <span class="afl-select-fake-val"><?php get_theme_mod("afl_{$part}_background_repeat", 'repeat'); ?></span>
						</span>
					</span>
				</div>
				<div class="afl-clear"></div>
			</div>
            </div>
        	<div class="afl-section afl-text afl-3columns afl-col-3">
			<h4>Attachment</h4>
			<div class="afl-control-container">
				<div class="afl-description"></div>
				<div class="afl-control">
					<span class="afl-style-wrap afl-select-style-wrap">
						<span class="afl-select-unify">
						<?php print afl_render_theme_option("{$part}-background-attachment", array('type' => 'select', 'options' => array("scroll", "fixed"),'default_value' => get_theme_mod("afl_{$part}_background_attachment", 'scroll'), 'background' => true, 'attributes' => array('class' => 'regular-text', 'name' => "background-attachment"))); ?>
							<span class="afl-select-fake-val"><?php get_theme_mod("afl_{$part}_background_attachment", 'scroll'); ?></span>
						</span>
					</span>
				</div>
				<div class="afl-clear"></div>
			</div>
			</div>
		</div>
<?php endif; // get_background_image() ?>
		<div class="afl-section afl-text">
			<h4>Color</h4>
			<div class="afl-control-container">
				<div class="afl-description" style="padding-top:8px;">
					OR &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="afl-style-wrap">
						<?php print afl_render_theme_option("afl-{$part}-color-transparent", array('type' => 'checkbox', 'default_value' => get_theme_mod("afl-{$part}-color-transparent", false), 'attributes' => array('name' => "color_transparent"))); ?>
					</span>
                    Make it Transparent
				</div>
				<div class="afl-control"><span>
					<span class="afl-style-wrap afl-colorpicker-style-wrap">
					<?php $cur_color = esc_attr(get_theme_mod("afl_{$part}_background_color", '')); ?>
					<?php print afl_render_theme_option("{$part}-background-color", array('type' => 'text', 'default_value' => (!empty($cur_color)? '#'.$cur_color:'#ffffff'), 'attributes' => array('name' => "background-color", 'class' => "afl-color-picker"))); ?>
                    <span class="afl_color_picker_div" style="background-color: <?php echo (!empty($cur_color)? '#'.$cur_color:'#ffffff') ?>;"></span>
					</span>
				</span></div>
				<div class="afl-clear"></div>
			</div>
		</div>
<?php if($part == 'page'): ?>
		<div class="afl-section afl-text">
			<h4>Use background slider instead</h4>
			<div class="afl-control-container">
				<div class="afl-description"></div>
				<div class="afl-control">
                    <div class="afl-style-wrap">
					<?php print afl_render_theme_option("afl_{$part}_use_slides", array('type' => 'checkbox', 'default_value' => get_theme_mod("afl_{$part}_use_slides", false), 'attributes' => array('class' => 'regular-text', 'name' => "use_slides"))); ?>
					</span></div>
				</div>
				<div class="afl-clear"></div>
			</div>
		</div>
<?php endif;?>






<?php if($part == 'page'): ?>
<div class="afl-clear"></div>
<h3>Background Slides</h3>
<div id="afl-background-slides">
<div id="custom-<?php print $part; ?>-slides">
    <?php
        $next_value = 0;
        $slides = get_theme_mod("afl_{$part}_slides", array());
        if(is_array($slides)){
            foreach($slides as $slide){
    ?>
	<div class="afl-single-set">
		<div class="afl-section afl-text afl-3columns afl-col-1">
			<h4>Image title</h4>
			<div class="afl-control-container">
				<div class="afl-description"></div>
				<div class="afl-control">
					<span class="afl-style-wrap">
					<?php print afl_render_theme_option("afl_{$part}_slide_title_{$next_value}", array('type' => 'text', 'default_value' => $slide['title'], 'attributes' => array('class' => 'regular-text', 'name' => "slides[{$next_value}][title]"))); ?>
					</span>
				</div>
				<div class="afl-clear"></div>
			</div>
		</div>
		<div class="afl-section afl-text afl-3columns afl-col-2">
			<h4>Image src</h4>
			<div class="afl-control-container">
				<div class="afl-description"></div>
				<div class="afl-control">
					<span class="afl-style-wrap">
					<?php print afl_render_theme_option("afl_{$part}_slide_image_{$next_value}", array('type' => 'text', 'default_value' => $slide['image'], 'uploadable' => true, 'button_class' => 'with_thumbs', 'attributes' => array('class' => 'regular-text', 'name' => "slides[{$next_value}][image]"))); ?>
					</span>
				</div>
				<div class="afl-clear"></div>
			</div>
		</div>
		<div class="afl-section afl-text afl-3columns afl-col-3">
			<h4>Preview</h4>
			<div class="afl-control-container">
				<div class="afl-description"></div>
				<div class="afl-control">
					<span class="afl-style-wrap">
					<input type="hidden" name="<?php print "slides[{$next_value}][thumb]" ?>" value="<?php print $slide['thumb']; ?>" />
            		<a href="<?php print $slide['image']; ?>" data-rel="prettyPhoto"><img src="<?php print $slide['thumb']; ?>"  height="35" alt=""/></a>
					</span>
				</div>
				<div class="afl-clear"></div>
			</div>
		</div>
		<a class="afl-social-delete afl-remove-set" href="#">Remove Form Element</a>
	</div>
    <?php
                $next_value++;
            }
        }
    ?>
    <div class="afl-single-set">
        <div class="afl-section afl-text afl-3columns afl-col-1">
            <h4>Image title</h4>
            <div class="afl-control-container">
                <div class="afl-description"></div>
                <div class="afl-control">
					<span class="afl-style-wrap">
					<?php print afl_render_theme_option("afl_{$part}_slide_title_{$next_value}", array('type' => 'text', 'default_value' => '', 'attributes' => array('class' => 'regular-text', 'name' => "slides[{$next_value}][title]"))); ?>
					</span>
                </div>
                <div class="afl-clear"></div>
            </div>
        </div>
        <div class="afl-section afl-text afl-3columns afl-col-2">
            <h4>Image src</h4>
            <div class="afl-control-container">
                <div class="afl-description"></div>
                <div class="afl-control">
					<span class="afl-style-wrap">
					<?php print afl_render_theme_option("afl_{$part}_slide_image_{$next_value}", array('type' => 'text', 'default_value' => '', 'uploadable' => true, 'button_class' => 'with_thumbs', 'attributes' => array('class' => 'regular-text', 'name' => "slides[{$next_value}][image]"))); ?>
					</span>
                </div>
                <div class="afl-clear"></div>
            </div>
        </div>
        <div class="afl-section afl-text afl-3columns afl-col-3">
            <h4>Preview</h4>
            <div class="afl-control-container">
                <div class="afl-description"></div>
                <div class="afl-control">
					<span class="afl-style-wrap">
					<input type="hidden" name="<?php print "slides[{$next_value}][thumb]" ?>" value="" />
					<a href="<?php print get_template_directory_uri(); ?>/lib/css/images/noimage.png" rel="prettyPhoto"><img src="<?php print get_template_directory_uri(); ?>/lib/css/images/noimage.png" height="35" alt=""/></a>
					</span>
                </div>
                <div class="afl-clear"></div>
            </div>
        </div>
        <a class="afl-social-add afl-clone-set" href="#">Add another Form Element</a>
    </div>
</div>
</div>
<?php endif; ?>






<div class="afl-section">
<input type="hidden" name="afl_bgpart" value="<?php print $part ?>" />
<?php wp_nonce_field("custom-$part-background", "_wpnonce-custom-$part-background"); ?>
        <div class="afl-footer-save">
            <span class="afl-style-wrap"><a class="afl-button afl-background-submit" href="#">Save <?php echo ucfirst($part).' Background Settings'; ?></a></span>
		</div>
</div>
</form>
<?php
}
endif;