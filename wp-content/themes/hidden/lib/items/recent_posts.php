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
					<div class="afl-section afl-text afl-3columns afl-col-1">
						<h4><?php print __('Select category: ', 'afl'); ?></h4>
						<div class="afl-control-container">
							<div class="afl-description"></div>
							<div class="afl-control">
								<span class="afl-style-wrap afl-select-style-wrap">
									<span class="afl-select-unify">
                                        <?php
										$selected_cat = '--All Posts--';
										$cats = get_categories();
										$categories = array();
										foreach($cats as $n => $cat) {
											$categories["{$cat->cat_ID}"] = $cat->name;
											if ( isset($data['category']) && $data['category'] == $cat->cat_ID ) $selected_cat = $cat->name;
										}
										$opts = array( '0' => __( '--All Posts--', 'afl' ) ) + $categories;
                                        if(!isset($data['category']))$data['category']='';
										print afl_render_theme_option("afl-category", array('type' => 'select', 'options' => $opts, 'default_value'=>$data['category'], 'attributes' => array('name' => "category")));
										?>
										<span class="afl-select-fake-val"><?php echo $selected_cat; ?></span>
									</span>
								</span>
							</div>
							<div class="afl-clear"></div>
						</div>
					</div>
					<div class="afl-section afl-text afl-3columns afl-col-2">
						<h4><?php print __('How Many to Show: ', 'afl'); ?></h4>
						<div class="afl-control-container">
							<div class="afl-description"></div>
							<div class="afl-control">
								<span class="afl-style-wrap afl-select-style-wrap">
									<span class="afl-select-unify">
                                        <?php
                                        if(!isset($data['number']))$data['number']='';
                                        print afl_render_theme_option("number", array('type' => 'select' ,
																							'options' => array('4' => '4', '3' => '3', '2' => '2'), 'default_value'=>$data['number'],
																							'attributes' => array('class' => 'regular-text', 'name' => "number"))); ?>
										<span class="afl-select-fake-val"><?php echo isset( $data['number'] ) ? $data['number'] : '4'; ?></span>
									</span>
								</span>
							</div>
							<div class="afl-clear"></div>
						</div>
					</div>
					<div class="afl-section afl-text afl-3columns afl-col-3">
						<h4><?php print __('Offset', 'afl'); ?></h4>
						<div class="afl-control-container">
							<div class="afl-description"></div>
							<div class="afl-control">
								<span class="afl-style-wrap">
									<?php
                                    if(!isset($values["offset"]))$values["offset"]='';
                                    print afl_render_theme_option("offset{$col_id}", array('type' => 'text', 'default_value' => $values["offset"], 'attributes' => array('class' => 'regular-text', 'name' => "offset"))); ?>
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
