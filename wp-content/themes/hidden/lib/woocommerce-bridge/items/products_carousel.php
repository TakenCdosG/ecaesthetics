<?php
/**
 * Created by DXThemes.com.
 * User: kuzen leibovitz
 * Date: 11.01.13
 * Time: 13:40
 * WooCommerce Products Carousel Settings Page for Turbo Editor
 */
$col_id = 0; $values = &$data; ?>
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
									<?php print afl_render_theme_option("{$type}-title{$col_id}", array('type' => 'text', 'default_value' => $values["{$type}_title"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_title"))); ?>
								</span>
                            </div>
                            <div class="afl-clear"></div>
                        </div>
                    </div>
                </div>
                <div class="afl-single-set">
                    <div class="afl-section afl-text afl-3columns afl-col-1">
                        <h4><?php print __('Products category: ', 'afl'); ?></h4>
                        <div class="afl-control-container">
                            <div class="afl-description"></div>
                            <div class="afl-control">
								<span class="afl-style-wrap afl-select-style-wrap">
									<span class="afl-select-unify">
                                        <?php
										$selected_cat = '--All Products--';
										$args = array(
											'number'     => null,
											'orderby'    => 'name',
											'order'      => 'ASC',
											'hide_empty' => 1
										);
										$cats = get_terms( 'product_cat', $args );
										//var_export($cats);
										$categories = array();

										foreach($cats as $n => $cat) {
											$categories["{$cat->slug}"] = $cat->name;
											if ( isset($data['category']) && $data['category'] == $cat->slug ) $selected_cat = $cat->name;
										}
										$opts = array( '0' => __( '--All Products--', 'afl' ) ) + $categories;
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
                        <h4><?php print __('How Many Columns: ', 'afl'); ?></h4>
                        <div class="afl-control-container">
                            <div class="afl-description"></div>
                            <div class="afl-control">
								<span class="afl-style-wrap afl-select-style-wrap">
									<span class="afl-select-unify">
                                        <?php print afl_render_theme_option("columns", array('type' => 'select' ,
										'options' => array('4' => '4', '3' => '3', '2' => '2'), 'default_value'=>$data['columns'],
										'attributes' => array('class' => 'regular-text', 'name' => "columns"))); ?>
                                        <span class="afl-select-fake-val"><?php echo isset( $data['columns'] ) ? $data['columns'] : '4'; ?></span>
									</span>
								</span>
                            </div>
                            <div class="afl-clear"></div>
                        </div>
                    </div>
                    <div class="afl-section afl-text afl-3columns afl-col-2">
                        <h4><?php print __('How Many Products: ', 'afl'); ?></h4>
                        <div class="afl-control-container">
                            <div class="afl-description"></div>
                            <div class="afl-control">
								<span class="afl-style-wrap afl-select-style-wrap">
									<span class="afl-select-unify">
                                        <?php print afl_render_theme_option("number", array('type' => 'select' ,
										'options' => array('12' => '12', '11' => '11', '10' => '10', '9' => '9', '8' => '8', '7' => '7', '6' => '6', '5' => '5', '4' => '4', '3' => '3', '2' => '2'), 'default_value'=>$data['number'],
										'attributes' => array('class' => 'regular-text', 'name' => "number"))); ?>
                                        <span class="afl-select-fake-val"><?php echo isset( $data['number'] ) ? $data['number'] : '12'; ?></span>
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