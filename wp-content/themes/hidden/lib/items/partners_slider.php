<div  id="afl-form-options">
<div id="afl-edit-composer-item-tabs" class="items slider">
<ul>
    <li><a href="#afl-edit-item-tabs-content0">Slides</a></li>
    <li><a href="#afl-edit-item-tabs-content1">Settings</a></li>
</ul>
<div>
<div id="afl-edit-item-tabs-content0">
    <div class="afl-options-page">
        <div class="afl-options-container">
            <?php
            $next_value = 0;
            if(isset($data[$_POST['itemtype'][$index]."_images"])) :
                foreach($data[$_POST['itemtype'][$index]."_images"] as $image) :
                    ?>
                    <div class="afl-single-set">
                        <div class="afl-section afl-text">
                            <div class="afl-control-container">
                                <div class="afl-description">
                                    <h4><?php print __('Partner logo', 'afl'); ?></h4>
                                    <div>
											<span class="afl-style-wrap">
												<?php print afl_render_theme_option("afl-slider-image-url{$next_value}", array('type' => 'text', 'default_value' => $image['url'], 'uploadable' => true, 'attributes' => array('class' => 'regular-text', 'name' => $_POST['itemtype'][$index]."_images[{$next_value}][url]"))); ?>
											</span>
                                    </div>
                                    <div class="afl-image-preview">
                                        <h4><?php print __('Preview', 'afl'); ?></h4>
                                        <a href="<?php print $image['url']; ?>" data-rel="prettyPhoto"><img src="<?php print $image['url']; ?>"  height="120" alt=""/></a>
                                    </div>
                                </div>
                                <h4><?php print __('Partner title', 'afl'); ?></h4>
                                <div class="afl-control">
										<span class="afl-style-wrap">
										<?php print afl_render_theme_option("afl-slider-image-title{$next_value}", array('type' => 'text', 'default_value' => $image['title'], 'attributes' => array('class' => 'regular-text', 'name' => $_POST['itemtype'][$index]."_images[{$next_value}][title]"))); ?>
										</span>
                                    <br/>
                                    <h4><?php print __('Partner link', 'afl'); ?></h4>
										<span class="afl-style-wrap">
										<?php print afl_render_theme_option("afl-slider-image-link{$next_value}", array('type' => 'textarea', 'default_value' => $image['link'], 'attributes' => array('class' => 'regular-text', 'name' => $_POST['itemtype'][$index]."_images[{$next_value}][link]"))); ?>
                                        </span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <a class="afl-slider-image-delete afl-remove-set" href="#">Remove Form Element</a>
                    </div>
                    <?php
                    $next_value++;
                endforeach;
            endif;
            ?>
            <div class="afl-single-set">
                <div class="afl-section afl-text afl-3columns afl-col-1">
                    <h4><?php print __('Partner title', 'afl'); ?></h4>
                    <div class="afl-control-container">
                        <div class="afl-description"></div>
                        <div class="afl-control">
										<span class="afl-style-wrap">
										<?php print afl_render_theme_option("afl-slider-image-title{$next_value}", array('type' => 'text', 'attributes' => array('class' => 'regular-text', 'name' => $_POST['itemtype'][$index]."_images[{$next_value}][title]"))); ?>
										</span>
                        </div>
                        <div class="afl-clear"></div>
                    </div>
                </div>
                <div class="afl-section afl-text afl-3columns afl-col-2">
                    <h4><?php print __('Partner link', 'afl'); ?></h4>
                    <div class="afl-control-container">
                        <div class="afl-description"></div>
                        <div class="afl-control">
										<span class="afl-style-wrap">
										<?php print afl_render_theme_option("afl-slider-image-link{$next_value}", array('type' => 'text', 'attributes' => array('class' => 'regular-text', 'name' => $_POST['itemtype'][$index]."_images[{$next_value}][link]"))); ?>
										</span>
                        </div>
                        <div class="afl-clear"></div>
                    </div>
                </div>
                <div class="afl-section afl-text afl-3columns afl-col-3">
                    <h4><?php print __('Partner logo', 'afl'); ?></h4>
                    <div class="afl-control-container">
                        <div class="afl-description"></div>
                        <div class="afl-control">
										<span class="afl-style-wrap">
										<?php print afl_render_theme_option("afl-slider-image-url{$next_value}", array('type' => 'text', 'uploadable' => true, 'attributes' => array('class' => 'regular-text', 'name' => $_POST['itemtype'][$index]."_images[{$next_value}][url]"))); ?>
										</span>
                        </div>
                        <div class="afl-clear"></div>
                    </div>
                </div>
                <a class="afl-slider-image-add afl-clone-set" href="#">Add Form Element</a>
            </div>
        </div>
    </div>
</div>
<div id="afl-edit-item-tabs-content1">
    <div class="afl-options-page">
        <div class="afl-options-container">
            <div class="afl-single-set">
                <div class="afl-section afl-text afl-3columns afl-col-1">
                    <h4><?php print __('Slideshow cycling speed', 'afl'); ?></h4>
                    <div class="afl-control-container">
                        <div class="afl-description"></div>
                        <div class="afl-control">
										<span class="afl-style-wrap">
										<?php
                                        if(!isset($data["{$type}_slideshowSpeed"]))$data["{$type}_slideshowSpeed"]='';
                                        print afl_render_theme_option("{$type}-slideshowSpeed", array('type' => 'text', 'default_value' => $data["{$type}_slideshowSpeed"], 'attributes' => array('class' => 'small-text', 'name' => "{$type}_slideshowSpeed"))); ?> milliseconds
										</span>
                        </div>
                        <div class="afl-clear"></div>
                    </div>
                </div>
                <div class="afl-section afl-text afl-3columns afl-col-2">
                    <h4><?php print __('Slides transition speed', 'afl'); ?></h4>
                    <div class="afl-control-container">
                        <div class="afl-description"></div>
                        <div class="afl-control">
										<span class="afl-style-wrap">
										<?php
                                        if(!isset($data["{$type}_slideSpeed"]))$data["{$type}_slideSpeed"]='';
                                        print afl_render_theme_option("{$type}-slideSpeed", array('type' => 'text', 'default_value' => $data["{$type}_slideSpeed"], 'attributes' => array('class' => 'small-text', 'name' => "{$type}_slideSpeed"))); ?> milliseconds
										</span>
                        </div>
                        <div class="afl-clear"></div>
                    </div>
                </div>
                <div class="afl-section afl-text afl-3columns afl-col-3">
                    <h4><?php print __('Loop Slides?', 'afl'); ?></h4>
                    <div class="afl-control-container">
                        <div class="afl-description"></div>
                        <div class="afl-control">
									<span class="afl-style-wrap">
									<?php
                                    if(!isset($data["{$type}_loop"]))$data["{$type}_loop"]='';
                                    print afl_render_theme_option("{$type}-loop", array('type' => 'checkbox', 'default_value' => $data["{$type}_loop"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_loop"))); ?>
									</span>
                        </div>
                        <div class="afl-clear"></div>
                    </div>
                </div>
            </div>
            <div class="afl-single-set">
                <div class="afl-section afl-text afl-3columns afl-col-1">
                    <h4><?php print __('Randomize Slides', 'afl'); ?></h4>
                    <div class="afl-control-container">
                        <div class="afl-description"></div>
                        <div class="afl-control">
									<span class="afl-style-wrap">
									<?php
                                    if(!isset($data["{$type}_randomize"]))$data["{$type}_randomize"]='';
                                    print afl_render_theme_option("{$type}-randomize", array('type' => 'checkbox', 'default_value' => $data["{$type}_randomize"], 'attributes' => array('class' => 'small-text', 'name' => "{$type}_randomize"))); ?>
									</span>
                        </div>
                        <div class="afl-clear"></div>
                    </div>
                </div>
                <div class="afl-section afl-text afl-3columns afl-col-2">
                    <h4><?php print __('Next & Prev, buttons navigation', 'afl'); ?></h4>
                    <div class="afl-control-container">
                        <div class="afl-description"></div>
                        <div class="afl-control">
									<span class="afl-style-wrap">
									<?php
                                    if(!isset($data["{$type}_navigation"]))$data["{$type}_navigation"]='';
                                    print afl_render_theme_option("{$type}-navigation", array('type' => 'checkbox', 'default_value' => $data["{$type}_navigation"], 'attributes' => array('class' => 'small-text', 'name' => "{$type}_navigation"))); ?>
									</span>
                        </div>
                        <div class="afl-clear"></div>
                    </div>
                </div>
                <div class="afl-section afl-text afl-3columns afl-col-3">
                </div>
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
