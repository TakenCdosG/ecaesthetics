<table class="form-table" class="items">
<tbody>
    <tr valign="top">
        <th><?php print __('Twitter title', 'afl'); ?></th>
        <td><?php print afl_render_theme_option("{$type}-title", array('type' => 'text', 'default_value' => $data["{$type}_title"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_title"))); ?></td>

    </tr>
    
     <tr valign="top">
        <th><?php print __('Twitter name', 'afl'); ?></th>
        <td><?php print afl_render_theme_option("{$type}-name", array('type' => 'text', 'default_value' => $data["{$type}_name"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_name"))); ?></td>
    </tr>
    
    <tr valign="top">
        <th><?php print __('Number of twitts', 'afl'); ?></th>
        <td><?php print afl_render_theme_option("{$type}-amount", array('type' => 'text', 'default_value' => $data["{$type}_amount"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_amount"))); ?></td>
    </tr>
   
</tbody>
</table>
