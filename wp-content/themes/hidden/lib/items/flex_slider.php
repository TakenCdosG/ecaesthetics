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
										<h4><?php print __('Image', 'afl'); ?></h4>
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
									<h4><?php print __('Slide title', 'afl'); ?></h4>
									<div class="afl-control">
										<span class="afl-style-wrap">
										<?php print afl_render_theme_option("afl-slider-image-title{$next_value}", array('type' => 'text', 'default_value' => $image['title'], 'attributes' => array('class' => 'regular-text', 'name' => $_POST['itemtype'][$index]."_images[{$next_value}][title]"))); ?>
										</span>
                                        <br/>
                                        <h4><?php print __('Slide text', 'afl'); ?></h4>
										<span class="afl-style-wrap">
										<?php print afl_render_theme_option("afl-slider-image-text{$next_value}", array('type' => 'textarea', 'default_value' => $image['text'], 'attributes' => array('class' => 'regular-text', 'name' => $_POST['itemtype'][$index]."_images[{$next_value}][text]"))); ?>
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
								<h4><?php print __('Slide title', 'afl'); ?></h4>
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
								<h4><?php print __('Slide text', 'afl'); ?></h4>
								<div class="afl-control-container">
									<div class="afl-description"></div>
									<div class="afl-control">
										<span class="afl-style-wrap">
										<?php print afl_render_theme_option("afl-slider-image-text{$next_value}", array('type' => 'text', 'attributes' => array('class' => 'regular-text', 'name' => $_POST['itemtype'][$index]."_images[{$next_value}][text]"))); ?>
										</span>
									</div>
									<div class="afl-clear"></div>
								</div>
							</div>
							<div class="afl-section afl-text afl-3columns afl-col-3">
								<h4><?php print __('Image', 'afl'); ?></h4>
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
                            <h4><?php print __('Fade or Slide?', 'afl'); ?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"></div>
								<div class="afl-control">
								<span class="afl-style-wrap afl-select-style-wrap">
									<span class="afl-select-unify">
                                        <?php print afl_render_theme_option("{$type}-animation", array('type' => 'select' ,
																									   'options' => array('slide' => 'slide', 'fade' => 'fade'),
																									   'default_value' => (isset($data["{$type}_animation"])?$data["{$type}_animation"]:'slide'),
																									   'attributes' => array('class' => 'regular-text', 'name' => "{$type}_animation"))); ?>
										<span class="afl-select-fake-val"><?php echo isset( $data["{$type}_animation"] ) ? $data["{$type}_animation"] : 'slide'; ?></span>
									</span>
								</span>
								</div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-section afl-text afl-3columns afl-col-2">
                            <h4><?php print __('Choose effect', 'afl'); ?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"></div>
								<div class="afl-control">
								<span class="afl-style-wrap afl-select-style-wrap">
									<span class="afl-select-unify">
                                        <?php print afl_render_theme_option("{$type}-effect", array('type' => 'select' ,
																									'options' => array('swing' => 'swing', 'easeInQuad' => 'easeInQuad', 'easeOutQuad' => 'easeOutQuad', 'easeInOutQuad' => 'easeInOutQuad', 'easeInCubic' => 'easeInCubic', 'easeOutCubic' => 'easeOutCubic', 'easeInOutCubic' => 'easeInOutCubic', 'easeInQuart' => 'easeInQuart', 'easeOutQuart' => 'easeOutQuart', 'easeInOutQuart' => 'easeInOutQuart', 'easeInSine' => 'easeInSine', 'easeOutSine' => 'easeOutSine', 'easeInOutSine' => 'easeInOutSine', 'easeInExpo' => 'easeInExpo', 'easeOutExpo' => 'easeOutExpo', 'easeInOutExpo' => 'easeInOutExpo', 'easeInQuint' => 'easeInQuint', 'easeOutQuint' => 'easeOutQuint', 'easeInOutQuint' => 'easeInOutQuint', 'easeInCirc' => 'easeInCirc', 'easeOutCirc' => 'easeOutCirc', 'easeInOutCirc' => 'easeInOutCirc', 'easeInElastic' => 'easeInElastic', 'easeOutElastic' => 'easeOutElastic', 'easeInOutElastic' => 'easeInOutElastic', 'easeInBack' => 'easeInBack', 'easeOutBack' => 'easeOutBack',
																													   'easeInOutBack' => 'easeInOutBack', 'easeInBounce' => 'easeInBounce', 'easeOutBounce' => 'easeOutBounce', 'easeInOutBounce' => 'easeInOutBounce'),
																									'default_value' => (isset($data["{$type}_effect"])?$data["{$type}_effect"]:'jswing'),
																									'attributes' => array('class' => 'regular-text', 'name' => "{$type}_effect"))); ?>
										<span class="afl-select-fake-val"><?php echo isset( $data["{$type}_effect"] ) ? $data["{$type}_effect"] : 'jswing'; ?></span>
									</span>
								</span>
								</div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-section afl-text afl-3columns afl-col-3">
                            <h4><?php print __('Direction', 'afl'); ?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"></div>
                                <div class="afl-control">
									<span class="afl-style-wrap afl-select-style-wrap">
										<span class="afl-select-unify">
											<?php print afl_render_theme_option("{$type}-direction", array('type' => 'select' ,
																										   'options' => array('horizontal' => 'horizontal', 'vertical' => 'vertical'),
																										   'default_value' => (isset($data["{$type}_direction"])?$data["{$type}_direction"]:'horizontal'),
																										   'attributes' => array('class' => 'regular-text', 'name' => "{$type}_direction"))); ?>
                                            <span class="afl-select-fake-val"><?php echo isset( $data["{$type}_direction"] ) ? $data["{$type}_direction"] : 'horizontal'; ?></span>
										</span>
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
							<h4><?php print __('Pause on hover', 'afl'); ?></h4>
							<div class="afl-control-container">
								<div class="afl-description"></div>
								<div class="afl-control">
									<span class="afl-style-wrap">
									<?php
                                    if(!isset($data["{$type}_hoverPause"]))$data["{$type}_hoverPause"]="";
                                    print afl_render_theme_option("{$type}-hoverPause", array('type' => 'checkbox', 'default_value' => $data["{$type}_hoverPause"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_hoverPause"))); ?>
									</span>
								</div>
								<div class="afl-clear"></div>
							</div>
						</div>
					</div>
					<div class="afl-single-set">
						<div class="afl-section afl-text afl-3columns afl-col-1">
							<h4><?php print __('Make It Full Width', 'afl'); ?></h4>
							<div class="afl-control-container">
								<div class="afl-description"></div>
								<div class="afl-control">
									<span class="afl-style-wrap">
									<?php
                                    if(!isset($data["{$type}_fullwidth"]))$data["{$type}_fullwidth"]='';
                                    print afl_render_theme_option("{$type}-fullwidth", array('type' => 'checkbox', 'default_value' => $data["{$type}_fullwidth"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_fullwidth"))); ?>
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
</div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
        jQuery("a[rel^='prettyPhoto']").prettyPhoto();
	});
</script>
