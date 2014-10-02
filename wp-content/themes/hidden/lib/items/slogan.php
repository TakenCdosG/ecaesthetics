<div  id="afl-form-options">
	<div class="te-form">
		<div class="afl-options-page">
			<div class="afl-options-container">
				<div class="afl-section afl-text">
					<h4><?php print __('Slogan title', 'afl'); ?></h4>
					<div class="afl-control-container">
						<div class="afl-description"></div>
						<div class="afl-control">
									<span class="afl-style-wrap">
									<?php
                                    if(!isset($data["{$type}_title"]))$data["{$type}_title"]='';
                                    print afl_render_theme_option("{$type}-title", array('type' => 'text', 'default_value' => $data["{$type}_title"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_title"))); ?>
									</span>
						</div>
						<div class="afl-clear"></div>
					</div>
				</div>
				<div class="afl-section afl-text">
					<h4><?php print __('Slogan text', 'afl'); ?></h4>
					<div class="afl-control-container">
						<div class="afl-description"></div>
						<div class="afl-control">
									<span class="afl-style-wrap">
									<?php
                                    if(!isset($data["{$type}_text"]))$data["{$type}_text"]='';
                                    print afl_render_theme_option("{$type}-text", array('type' => 'textarea', 'default_value' => $data["{$type}_text"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_text"))); ?>
									</span>
						</div>
						<div class="afl-clear"></div>
					</div>
				</div>
				<div class="afl-single-set">
					<div class="afl-section afl-text afl-2columns">
						<h4><?php print __('Slogan button text', 'afl'); ?></h4>
						<div class="afl-control-container">
							<div class="afl-description"></div>
							<div class="afl-control">
										<span class="afl-style-wrap">
										<?php
                                        if(!isset($data["{$type}_button_text"]))$data["{$type}_button_text"]='';
                                        print afl_render_theme_option("{$type}-button-text", array('type' => 'text', 'default_value' => $data["{$type}_button_text"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_button_text"))); ?>
										</span>
							</div>
							<div class="afl-clear"></div>
						</div>
					</div>
					<div class="afl-section afl-text afl-2columns">
						<h4><?php print __('Slogan button link', 'afl'); ?></h4>
						<div class="afl-control-container">
							<div class="afl-description"></div>
							<div class="afl-control">
										<span class="afl-style-wrap">
										<?php
                                        if(!isset($data["{$type}_button_link"]))$data["{$type}_button_link"]='';
                                        print afl_render_theme_option("{$type}-button-link", array('type' => 'text', 'default_value' => $data["{$type}_button_link"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_button_link"))); ?>
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
