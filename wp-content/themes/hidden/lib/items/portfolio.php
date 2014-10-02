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
                                    if(!isset($values["title"]))$values["title"]='';
                                    print afl_render_theme_option("title", array('type' => 'text', 'default_value' => $values["title"], 'attributes' => array('class' => 'regular-text', 'name' => "title"))); ?>
								</span>
							</div>
							<div class="afl-clear"></div>
						</div>
					</div>
				</div>
				<div class="afl-single-set">
                    <div class="afl-section afl-text afl-3columns afl-col-1">
                        <h4><?php print __('Show filters', 'afl'); ?></h4>
                        <div class="afl-control-container">
                            <div class="afl-description"></div>
                            <div class="afl-control">
									<span class="afl-style-wrap">
									<?php
                                    if(!isset($data["filters"]))$data["filters"]='';
                                    print afl_render_theme_option("filters", array('type' => 'checkbox', 'default_value' => $data["filters"], 'attributes' => array('class' => 'regular-text', 'name' => "filters"))); ?>
									</span>
                            </div>
                            <div class="afl-clear"></div>
                        </div>
                    </div>
					<div class="afl-section afl-text afl-3columns afl-col-2">
						<h4><?php print __('Columns: ', 'afl'); ?></h4>
						<div class="afl-control-container">
							<div class="afl-description"></div>
							<div class="afl-control">
								<span class="afl-style-wrap afl-select-style-wrap">
									<span class="afl-select-unify">
                                        <?php
                                        if(!isset($data['cols']))$data['cols']='';
                                        print afl_render_theme_option("cols", array('type' => 'select' ,
																							'options' => array('4' => '4', '3' => '3', '2' => '2'), 'default_value'=>$data['cols'],
																							'attributes' => array('class' => 'regular-text', 'name' => "cols"))); ?>
										<span class="afl-select-fake-val"><?php echo isset( $data['cols'] ) ? $data['cols'] : '3'; ?></span>
									</span>
								</span>
							</div>
							<div class="afl-clear"></div>
						</div>
					</div>
                    <div class="afl-section afl-text afl-3columns afl-col-3">
                        <h4><?php print __('Rows: ', 'afl'); ?></h4>
                        <div class="afl-control-container">
                            <div class="afl-description"></div>
                            <div class="afl-control">
								<span class="afl-style-wrap afl-select-style-wrap">
									<span class="afl-select-unify">
                                        <?php
                                        if(!isset($data['rows']))$data['rows']='';
                                        print afl_render_theme_option("rows", array('type' => 'select' ,
                                            'options' => array('4' => '4', '3' => '3', '2' => '2'), 'default_value'=>$data['rows'],
                                            'attributes' => array('class' => 'regular-text', 'name' => "rows"))); ?>
                                        <span class="afl-select-fake-val"><?php echo isset( $data['rows'] ) ? $data['rows'] : '2'; ?></span>
									</span>
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
