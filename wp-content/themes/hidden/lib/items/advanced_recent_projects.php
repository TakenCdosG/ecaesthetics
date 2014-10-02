<?php $col_id = 0; $values = &$data; ?>
<div  id="afl-form-options">
    <div class="te-form">
        <div class="afl-options-page">
            <div class="afl-options-container">
                <?php __afl_composer_edit_content_part($col_id, $type, $values); ?>
                <div class="afl-single-set">
                    <div class="afl-section afl-text afl-2columns">
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
