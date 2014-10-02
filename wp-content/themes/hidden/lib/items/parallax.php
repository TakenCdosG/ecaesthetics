<div  id="afl-form-options">
<div id="afl-edit-item-tabs-content0">
    <div class="afl-options-page  te-form">
        <div class="afl-options-container">

            <?php
            __afl_composer_edit_content_part( 0, $type, $data );
            if (empty($data['thumb'])) {
                $data['thumb'] = get_template_directory_uri().'/lib/css/images/noimage.png';
            }
                    ?>
                    <div class="afl-single-set">
                        <div class="afl-section  afl-2columns te-upload">
                            <div class="afl-control-container">

                                    <h4><?php print __('Image', 'afl'); ?></h4>
                                    <div>
											<span class="afl-style-wrap">
												<?php
                                                if(!isset($data['parallax_image_url']))$data['parallax_image_url']='';
                                                print afl_render_theme_option("parallax_image_url", array('type' => 'text', 'default_value' => $data['parallax_image_url'], 'uploadable' => true, 'button_class' => 'with_thumbs', 'attributes' => array('class' => 'regular-text', 'name' => "parallax_image_url"))); ?>
											</span>
                                    </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-section afl-2columns">
                            <h4>Preview</h4>
                            <div class="afl-control-container">
                                <div class="afl-description"></div>
                                <div class="afl-control">
                                    <span class="afl-style-wrap">
                                    <input type="hidden" name="thumb" value="" />
                                    <a href="<?php print $data['parallax_image_url']; ?>" data-rel="prettyPhoto"><img src="<?php print $data['thumb']; ?>" height="70" alt="parallax"/></a>
                                    </span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>



                    </div>
        </div>
    </div>
</div>

</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
        jQuery("a[rel^='prettyPhoto']").prettyPhoto();
    });
</script>
