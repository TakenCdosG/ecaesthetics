<table class="form-table items post-strip">
<tbody>
    <tr valign="top">
        <th><?php print __('Select Category', 'afl'); ?></th>
        <td><?php
		$cats = get_categories();
		$categories = array('' => __('--Select category--', 'afl'));
		foreach ($cats as $cat=>$cat_val){
			
			$categories[(string)$cat_val->term_id] .= $cat_val->name;
		}
			$opts = $categories;
			print afl_render_theme_option("afl-category", array('type' => 'select', 'options' => $opts, 'default_value'=>$data['category'], 'attributes' => array('name' => "category")));
		?></td>
    </tr>
    <tr valign="top">
        <th><?php print __('Offset of contents:', 'afl'); ?></th>
        <td><?php print afl_render_theme_option("afl-content-offset", array('type' => 'text', 'default_value'=> intval($data['content_offset']), 'attributes' => array('name' => "content_offset"))); ?></td>
    </tr>
</tbody>
</table>