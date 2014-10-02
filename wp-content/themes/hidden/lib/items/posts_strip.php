<table class="form-table items post-strip">
<tbody>
    <tr valign="top">
        <th><?php print __('Select content type', 'afl'); ?></th>
        <td><?php
			$opts = array_merge(array('' => __('--Select content type--','afl')), get_post_types(array('public' => true, 'show_ui' => true),'names','and'));
			print afl_render_theme_option("afl-content-type", array('type' => 'select', 'options' => $opts, 'default_value'=>$data['content_type'], 'attributes' => array('name' => "content_type")));
		?></td>
    </tr>
    <tr valign="top">
        <th><?php print __('Offset of contents:', 'afl'); ?></th>
        <td><?php print afl_render_theme_option("afl-content-offset", array('type' => 'text', 'default_value'=> intval($data['content_offset']), 'attributes' => array('name' => "content_offset"))); ?></td>
    </tr>
    <tr valign="top">
        <th><?php print __('Count of contents per page:', 'afl'); ?></th>
        <td><?php print afl_render_theme_option("afl-content-count", array('type' => 'text', 'default_value'=> (intval($data['count'])>0?intval($data['content_per_page']):get_option('posts_per_page')), 'attributes' => array('name' => "content_per_page"))); ?></td>
    </tr>

    <tr valign="top">
        <th><?php print __('Use pager:', 'afl'); ?></th>
        <td><?php print afl_render_theme_option("afl-use-pager", array('type' => 'checkbox', 'default_value'=> $data['content_use_pager'], 'attributes' => array('name' => "content_use_pager"))); ?></td>
    </tr>
</tbody>
</table>