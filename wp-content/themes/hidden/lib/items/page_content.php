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
						<h4><?php print __('Select Page:', 'afl'); ?></h4>
						<div class="afl-control-container">
							<div class="afl-description"></div>
							<div class="afl-control">
								<span class="afl-style-wrap afl-select-style-wrap">
									<span class="afl-select-unify">
                                        <?php
										$selected_page = '--Empty--';
										$pages = get_pages();
										$pages_array = array();
										foreach($pages as $n => $page) {
											$pages_array["{$page->ID}"] = $page->post_title;
											if ( isset($data['page']) && $data['page'] == $page->ID ) $selected_page = $page->post_title;
										}
										$opts = array( '0' => __( '--Empty--', 'afl' ) ) + $pages_array;
                                        if(!isset($data['page']))$data['page']='';
										print afl_render_theme_option("afl-page", array('type' => 'select', 'options' => $opts, 'default_value'=>$data['page'], 'attributes' => array('name' => "page")));
										?>
										<span class="afl-select-fake-val"><?php echo $selected_page; ?></span>
									</span>
								</span>
							</div>
							<div class="afl-clear"></div>
						</div>
					</div>
				</div>
				<div class="afl-single-set">
					<div class="afl-section afl-text">
						<h4><?php print __('Container ID (e.g about):', 'afl'); ?></h4>
						<div class="afl-control-container">
							<div class="afl-description"></div>
							<div class="afl-control">
								<span class="afl-style-wrap">
									<?php
                                    if(!isset($values["{$type}_contid"]))$values["{$type}_contid"]='';
                                    print afl_render_theme_option("{$type}-contid{$col_id}", array('type' => 'text', 'default_value' => $values["{$type}_contid"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_contid"))); ?>
								</span>
							</div>
							<div class="afl-clear"></div>
						</div>
					</div>
				</div>
				<div class="afl-single-set">
					<div class="afl-section afl-text">
						<h4><?php print __('Custom class:', 'afl'); ?></h4>
						<div class="afl-control-container">
							<div class="afl-description"></div>
							<div class="afl-control">
								<span class="afl-style-wrap">
									<?php
                                    if(!isset($values["{$type}_class"]))$values["{$type}_class"]='';
                                    print afl_render_theme_option("{$type}-class{$col_id}", array('type' => 'text', 'default_value' => $values["{$type}_class"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_class"))); ?>
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
