<?php $col_id = 0; $values = &$data; ?>
<div  id="afl-form-options">
    <div class="slider">
        <div class="afl-options-page">
            <div class="afl-options-container">
                <div class="afl-single-set">
                    <div class="afl-section afl-text">
                        <h4><?php print __('Title', 'afl'); ?></h4>
                        <div class="afl-control-container">
                            <div class="afl-description"></div>
                            <div class="afl-control">
								<span class="afl-style-wrap">
									<?php
                                    if(!isset($values["{$type}_title"]))$values["{$type}_title"]='';
                                    print afl_render_theme_option("{$type}-title{$col_id}", array('type' => 'text', 'default_value' => $values["{$type}_title"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_title"))); ?>
								</span>
                            </div>
                            <div class="afl-clear"></div>
                        </div>
                    </div>
                </div>
                <div class="afl-single-set">
                    <div class="afl-section afl-text">
                        <h4><?php print __('How Many Items?', 'afl'); ?></h4>
                        <div class="afl-control-container">
                            <div class="afl-description"></div>
                            <div class="afl-control">
								<span class="afl-style-wrap">
								<?php
                                if(!isset($values["{$type}_number"]))$values["{$type}_number"]='';
                                print afl_render_theme_option("{$type}-number{$col_id}", array('type' => 'text', 'default_value' => $values["{$type}_number"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_number"))); ?>
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
