<table class="form-table items" border="0">
<tbody>
    <tr valign="top">
       <th><?php print __('Sidebar', 'afl'); ?></th>
       <?php
            $bars = afl_get_active_sitebars();
            $default = array_keys($bars);
            $default = (empty($data["{$type}_id"])?$default[0]:$data["{$type}_id"]);
       ?>
       <td><?php print afl_render_theme_option("{$type}-id", array('type' => 'select' ,
                                        'options' => $bars,
                                        'default_value' => $default,
                                        'attributes' => array('class' => 'regular-text', 'name' => "{$type}_id"))); ?></td>
    </tr>
</tbody>
</table>
