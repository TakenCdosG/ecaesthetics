<?php
if (!function_exists('afl_do_shortcode')):

    function afl_do_shortcode($content) {
        $content = do_shortcode(shortcode_unautop($content));
        $content = preg_replace('#^<\/p>|^<br\s?\/?>|<p>$|<p>\s*(&nbsp;)?\s*<\/p>#', '', $content);
        return $content;
    }

endif;

if (!function_exists('afl_container_wrap')):

    function afl_container_wrap($atts, $content) {
        if (!isset($atts['custom_class']))
            $atts['custom_class'] = '';
        return '<div class="container ' . $atts['custom_class'] . '"><div class="row">' . afl_do_shortcode($content) . '</div></div>';
    }

endif;

if (!function_exists('afl_columns_wrap')):

    function afl_columns_wrap($atts, $content) {
        if (!isset($atts['custom_class']))
            $atts['custom_class'] = '';
        if (!isset($atts['containerstyle']))
            $atts['containerstyle'] = '';
        if (!isset($atts['containerbgcolor']))
            $atts['containerbgcolor'] = '';
        if (!isset($atts['customcssclass']))
            $atts['customcssclass'] = '';

        if ($atts['containerstyle'] !== '' || $atts['customcssclass'] !== '' || $atts['containerbgcolor'] !== '') {
            if ($atts['containerbgcolor'] !== '') {
                $fullwidth = 'full-width';
            } else {
                $fullwidth = '';
            }
            return '<div class="' . $fullwidth . ' ' . $atts['containerstyle'] . ' ' . $atts['containerbgcolor'] . ' ' . $atts['customcssclass'] . '"><div class="container ' . $atts['custom_class'] . '">' . afl_do_shortcode($content) . '</div></div>';
        } else {
            return '<div class="container ' . $atts['custom_class'] . '">' . afl_do_shortcode($content) . '</div>';
        }
    }

endif;

if (!function_exists('afl_to_shortcode')):

    function afl_to_shortcode($sc_array) {
        $out = '';

        if (count($sc_array) == 0)
            return;
        foreach ($sc_array as $sc) {
            $type = $sc['type'];
            $out .= "$sc[prefix][$sc[type]";
            $data = $sc['data'];
            switch ($sc['type']) {
                case 'flex-slider':
                    $images = array();
                    if (isset($data["$sc[type]_images"])) {
                        $images = $data["$sc[type]_images"];
                        unset($data["$sc[type]_images"]);
                    }
                    $data["$sc[type]_navigation"] = (!empty($data["$sc[type]_navigation"]) ? 'true' : 'false');
                    $data["$sc[type]_links"] = (!empty($data["$sc[type]_links"]) ? 'true' : 'false');
                    $data["$sc[type]_hoverPause"] = (!empty($data["$sc[type]_hoverPause"]) ? 'true' : 'false');

                    $out .= ' ' . afl_render_shortcode_attributes($sc['type'], $data) . ']';
                    if (count($images) > 0) {
                        $out .= '<ul class="slides">';
                        foreach ($images as $image) {
                            $image['title'] = trim($image['title']);

                            if (isset($image['text'])) {
                                $image['text'] = trim($image['text']);
                            } else {
                                $image['text'] = '';
                            }

                            $out .= '<li><img src="' . esc_attr($image['url']) . '" alt="' . $image['title'] . '"/>';
                            if (!empty($image['title']) || !empty($image['text']))
                                $out .= '<div class="slide-caption">';
                            if (!empty($image['title']))
                                $out .= '<div class="slide-title">' . $image['title'] . '</div>';
                            if (!empty($image['text']))
                                $out .= '<div class="slide-subtitle">' . $image['text'] . '</div>';
                            if (!empty($image['title']) || !empty($image['text']))
                                $out .= '</div>';
                            $out .= '</li>';
                        }
                        $out .= '</ul>';
                    }
                    else {
                        $out .= ' ';
                    }
                    break;
                case 'text_slider':
                    if (!empty($data['content_types'])) {
                        $out .= ' content_count="' . $data['content_count'] . '" content_types="' . $data['content_types'] . '"] ';
                    } else {
                        $out .= '] ';
                        if (!empty($data[$type])) {
                            foreach ($data[$type] as $slide) {
                                if (isset($slide['content'])) {
                                    $content = $slide['content'];
                                    unset($slide['content']);
                                }
                                $out .= ' [text_slide ' . afl_render_shortcode_attributes($type, $slide) . '] ' . $content . ' [/text_slide] ';
                            }
                        }
                    }
                    break;
                case 'partners_slider':
                    $images = array();
                    if (isset($data["$sc[type]_images"])) {
                        $images = $data["$sc[type]_images"];
                        unset($data["$sc[type]_images"]);
                    }
                    $data["$sc[type]_navigation"] = (!empty($data["$sc[type]_navigation"]) ? 'true' : 'false');
                    $data["$sc[type]_links"] = (!empty($data["$sc[type]_links"]) ? 'true' : 'false');
                    $data["$sc[type]_hoverPause"] = (!empty($data["$sc[type]_hoverPause"]) ? 'true' : 'false');

                    $out .= ' ' . afl_render_shortcode_attributes($sc['type'], $data) . ']';
                    if (count($images) > 0) {
                        $out .= '<ul class="slides">';
                        for ($i = 0; $i < count($images); $i++) {
                            $out .= '<li>';
                            $images[$i]['title'] = trim($images[$i]['title']);

                            if (isset($images[$i]['link'])) {
                                $images[$i]['link'] = trim($images[$i]['link']);
                            } else {
                                $images[$i]['link'] = '';
                            }

                            //if($i && !($i%5)) $out .= '</li><li>';
                            if (!empty($images[$i]['link'])) {
                                $out .= '<a href="' . $images[$i]['link'] . '"';
                                if (!empty($images[$i]['title']))
                                    $out .= ' title="' . $images[$i]['title'] . '"';
                                $out .= '>';
                            }
                            $out .= '<img src="' . esc_attr($images[$i]['url']) . '" alt="' . $images[$i]['title'] . '"/>';
                            if (!empty($images[$i]['link']))
                                $out .= '</a>';
                            $out .= '</li>';
                        }
                        $out .= '</ul>';
                    }
                    else {
                        $out .= ' ';
                    }
                    break;
                case 'full_screen':
                case 'full_width':
                case 'parallax':
                case 'advanced_recent_projects':
                case 'advanced_recent_posts':
                    $content = $data["$sc[type]_content"];
                    if (isset($data["$sc[type]_content"])) {
                        unset($data["$sc[type]_content"]);
                    }
                    $out .= ' ' . afl_render_shortcode_attributes($sc['type'], $data) . '] ' . $content;
                    break;
                case 'slogan':
                    $content = $data["$sc[type]_text"];
                    unset($data["$sc[type]_text"]);
                    $out .= ' ' . afl_render_shortcode_attributes($sc['type'], $data) . '] ' . $content;
                    break;
                case 'divider':
                    $out .= ' ' . afl_render_shortcode_attributes($sc['type'], $data) . ' ' . $data["$sc[type]_dividertype"] . '] ';
                    break;
                case 'recent_projects':
                case 'recent_posts':
                case 'page_content':
                case 'contact_form':
                case 'portfolio':
                    $out .= ' ' . afl_render_shortcode_attributes($sc['type'], $data) . '] ';
                    break;
                case '2_columns':
                    $out .= ' containerstyle="' . $data["$sc[type]_containerstyle"] . '"';
                    $out .= ' containerbgcolor="' . $data["$sc[type]_containerbgcolor"] . '"';
                    $out .= ' customcssclass="' . $data["$sc[type]_customcssclass"] . '"';
                    $out .= '] ';
                    for ($i = 0; $i < 2; $i++) {
                        $out .= '[one_half';
                        if ($i == 0)
                            $out .= ' first'; else if ($i == 1)
                            $out .= ' last';
                        if (is_array($data)) {
                            $out .= ' title="' . $data["$sc[type]_title"][$i] . '" icon="' . $data["$sc[type]_icon"][$i];
                            $out .= '" button_text="' . $data["$sc[type]_button_text"][$i] . '" button_link="' . $data["$sc[type]_button_link"][$i] . '"]';

                            $out .= (empty($data["$sc[type]_content"][$i]) ? ' ' : $data["$sc[type]_content"][$i]);
                        } else {
                            $out .= ']';
                        }
                        $out .= ' [/one_half] ';
                    }
                    break;
                case 'one_third_block':
                    $out .= '] ';
                    for ($i = 0; $i < 2; $i++) {
                        if ($i == 1)
                            $out .= '[two_third'; else
                            $out .= '[one_third';
                        if ($i == 0)
                            $out .= ' first'; else if ($i == 1)
                            $out .= ' last';
                        if (is_array($data)) {
                            $out .= ' title="' . $data["$sc[type]_title"][$i] . '" icon="' . $data["$sc[type]_icon"][$i];
                            $out .= '" button_text="' . $data["$sc[type]_button_text"][$i] . '" button_link="' . $data["$sc[type]_button_link"][$i] . '"]';
                            $out .= (empty($data["$sc[type]_content"][$i]) ? ' ' : $data["$sc[type]_content"][$i]);
                        } else {
                            $out .= '] ';
                        }
                        if ($i == 1)
                            $out .= ' [/two_third] '; else
                            $out .= ' [/one_third] ';
                    }
                    break;

                case 'one_third_last_block':
                    $out .= '] ';
                    for ($i = 0; $i < 2; $i++) {
                        if ($i == 1)
                            $out .= '[one_third'; else
                            $out .= '[two_third';
                        if ($i == 0)
                            $out .= ' first'; else if ($i == 1)
                            $out .= ' last';
                        if (is_array($data)) {
                            $out .= ' title="' . $data["$sc[type]_title"][$i] . '" icon="' . $data["$sc[type]_icon"][$i];
                            $out .= '" button_text="' . $data["$sc[type]_button_text"][$i] . '" button_link="' . $data["$sc[type]_button_link"][$i] . '"]';
                            $out .= (empty($data["$sc[type]_content"][$i]) ? ' ' : $data["$sc[type]_content"][$i]);
                        } else {
                            $out .= '] ';
                        }
                        if ($i == 1)
                            $out .= ' [/one_third] '; else
                            $out .= ' [/two_third] ';
                    }
                    break;

                case '3_columns':
                    $out .= ' containerstyle="' . $data["$sc[type]_containerstyle"] . '"';
                    $out .= ' containerbgcolor="' . $data["$sc[type]_containerbgcolor"] . '"';
                    $out .= ' customcssclass="' . $data["$sc[type]_customcssclass"] . '"';
                    $out .= '] ';
                    for ($i = 0; $i < 3; $i++) {
                        $out .= '[one_third';
                        if ($i == 0)
                            $out .= ' first'; else if ($i == 2)
                            $out .= ' last';
                        if (is_array($data)) {
                            $out .= ' title="' . $data["$sc[type]_title"][$i] . '" icon="' . $data["$sc[type]_icon"][$i];
                            $out .= '" button_text="' . $data["$sc[type]_button_text"][$i] . '" button_link="' . $data["$sc[type]_button_link"][$i] . '"]';
                            if (!empty($data["$sc[type]_content"][$i])) {
                                $out .= $data["$sc[type]_content"][$i];
                            } else {
                                $out .= ' ';
                            }
                        } else {
                            $out .= ']';
                        }
                        $out .= ' [/one_third] ';
                    }
                    break;
                case '4_columns':
                    $out .= ' containerstyle="' . $data["$sc[type]_containerstyle"] . '"';
                    $out .= ' containerbgcolor="' . $data["$sc[type]_containerbgcolor"] . '"';
                    $out .= ' customcssclass="' . $data["$sc[type]_customcssclass"] . '"';
                    $out .= '] ';
                    for ($i = 0; $i < 4; $i++) {
                        $out .= '[one_fourth';
                        if ($i == 0)
                            $out .= ' first'; else if ($i == 3)
                            $out .= ' last';
                        if (is_array($data)) {
                            $out .= ' title="' . $data["$sc[type]_title"][$i] . '" icon="' . $data["$sc[type]_icon"][$i];
                            $out .= '" button_text="' . $data["$sc[type]_button_text"][$i] . '" button_link="' . $data["$sc[type]_button_link"][$i] . '"]';
                            $out .= (empty($data["$sc[type]_content"][$i]) ? ' ' : $data["$sc[type]_content"][$i]);
                        } else {
                            $out .= ']';
                        }
                        $out .= ' [/one_fourth] ';
                    }
                    break;
                default:
                    $out .= "] ";
            }
            $out .= "[/$sc[type]]$sc[suffix] ";
        }
        return $out;
    }

endif;

if (!function_exists('afl_render_shortcode_attributes')):

    function afl_render_shortcode_attributes($type, $attrs = array()) {
        $out = array();
        //var_export($attrs);
        if (is_array($attrs)) {
            foreach ($attrs as $k => $v) {
                if (is_array($v))
                    $v = $v[0];
                $k = str_replace("{$type}_", '', $k);
                $v = esc_attr($v);
                $out[] = "{$k}=\"{$v}\"";
            }
        }
        return implode(' ', $out);
    }

endif;

if (!function_exists('afl_render_theme_option')):

    function afl_render_theme_option($id, $option) {
        $out = '';
        if ($option && isset($option['type'])) {
            switch ($option['type']) {
                case 'checkbox':
                    $option['value'] = 'open';
                    if ($option['default_value'] == 'open') {
                        $option['attributes']['checked'] = 'checked';
                    }
                    $out = __afl_input($id, $option);
                    break;
                case 'text':
                    if (!isset($option['default_value']))
                        $option['default_value'] = '';
                    $option['value'] = esc_attr($option['default_value']);
                    $out = __afl_input($id, $option);
                    if (isset($option['uploadable']) && $option['uploadable']) {
                        (isset($option['button_class'])) ? $class = $option['button_class'] : $class = '';
                        $out .= __afl_upload_button($id . '_uploader', $class);
                    }
                    break;
                case 'textarea':
                    $option['value'] = esc_attr($option['default_value']);
                    $out = __afl_textarea($id, $option);
                    break;
                case 'select':
                    if (!isset($option['default_value']))
                        $option['default_value'] = '';
                    $option['value'] = esc_attr($option['default_value']);
                    $out = __afl_select($id, $option);
                    break;
            }
        }
        return $out;
    }

endif;

if (!function_exists('afl_render_attributes')):

    function afl_render_attributes($attributes) {
        $out = array();
        if (is_array($attributes)) {
            foreach ($attributes as $k => $v) {
                //ignoring such attributes
                if (in_array($k, array('value', 'id', 'type')))
                    continue;
                $v = esc_attr($v);
                $out[] = "{$k}=\"{$v}\"";
            }
        }
        return implode(' ', $out);
    }

endif;

if (!function_exists('afl_refresh_options')):

    function afl_refresh_options($options) {
        global $__OPTIONS;
        if (is_array($options)) {
            foreach ($options as $k => $v) {
                if (isset($__OPTIONS[$k])) {
                    $__OPTIONS[$k]['default_value'] = $v;
                    //var_export($__OPTIONS[$k]['default_value']);
                }
            }
        }
    }

endif;

if (!function_exists('__afl_input')):

    function __afl_input($id, $option) {
        if (!isset($option['attributes']['name'])) {
            $option['attributes']['name'] = $id;
        }
        $out = "<input id='{$id}' type='{$option['type']}' ";
        if ($option['type'] == 'checkbox')
            $out.="class='niceCheck0' ";
        $out .= "value='{$option['value']}' " .
                afl_render_attributes($option['attributes']) . " />";
        return $out;
    }

endif;

if (!function_exists('__afl_textarea')):

    function __afl_textarea($id, $option) {
        if (!isset($option['attributes']['name'])) {
            $option['attributes']['name'] = $id;
        }
        return "<textarea id='{$id}' " . afl_render_attributes($option['attributes']) . ">" .
                $option['value'] . "</textarea>";
    }

endif;

if (!function_exists('__afl_select')):

    function __afl_select($id, $option) {
        if (!isset($option['attributes']['name'])) {
            $option['attributes']['name'] = $id;
        }
        $out = '';
        if (is_array($option['options'])) {
            $out = "<select id='{$id}' " . afl_render_attributes($option['attributes']) . ">";
            foreach ($option['options'] as $k => $v) {
                if (isset($option['background']) && $option['background'])
                    $k = $v;
                $out .= "<option value='{$k}'" . ($k == $option['default_value'] ? 'selected' : '') . ">{$v}</option>";
            }
            $out .= "</select>";
        }
        return $out;
    }

endif;

if (!function_exists('__afl_upload_button')):

    function __afl_upload_button($id, $class = '') {
        return "<a href='#' id='{$id}' class=\"afl-button afl-uploader {$class}\">Upload</a>";
    }

endif;

if (!function_exists('__afl_composer_toolbox')):

    function __afl_composer_toolbox() {
        global $__SHORTCODES;
        ?>
        <div id="afl-composer-toolbox-items" class="maxheight">
            <div class="toolbox-logo"></div>
            <div class="toolbox-inner">
                <?php
                $i = 0;
                $j = 0;
                $n = 0;
                foreach ($__SHORTCODES as $k => $tool) {
                    $type = str_replace('afl_', '', $k);
                    switch ($k) {
                        case 'afl_flex-slider':
                        case 'afl_text_slider':
                        case 'afl_partners_slider':
                            if ($i == 0)
                                echo '<strong><a href="javascript:void(0)">Sliders</a></strong><div>';
                            __afl_composer_toolbox_item($k, $tool, $type);
                            $i++;
                            break;

                        case 'afl_full_screen':
                        case 'afl_full_width':
                        case 'afl_2_columns':
                        case 'afl_3_columns':
                        case 'afl_4_columns':
                        case 'afl_one_third_block':
                        case 'afl_one_third_last_block':
                            if ($j == 0)
                                echo '</div><strong><a href="javascript:void(0)">Layouts</a></strong><div>';
                            $j++;
                            __afl_composer_toolbox_item($k, $tool, $type);
                            break;
                        default:
                            if ($n == 0)
                                echo ' </div>';
                            $n++;
                            __afl_composer_toolbox_item($k, $tool, $type);
                    }
                }
                ?>
            </div>
        </div>
        <?php
    }

endif;

if (!function_exists('__afl_composer_toolbox_item')):

    function __afl_composer_toolbox_item($key, $tool, $type) {
        ?>
        <?php $suf = rand(100000, 999999); ?>
        <div id="<?php print $key ?>" class="toolbox-inner-item">
            <a href="javascript:void(0)" title="<?php echo $tool['description'] ?>" id="tooltip-link-<?php print $suf ?>" class="<?php print $type ?>"><?php print $tool['name'] ?></a>
            <script>
                simple_tooltip("a#tooltip-link-<?php print $suf ?>", "<?php print get_template_directory_uri() . '/lib/' . $tool['image'] ?>");
            </script>
        <!-- <div><?php //print $tool['description']  ?></div> -->
        </div>
        <?php
    }

endif;

if (!function_exists('__afl_cloner')):

    function __afl_cloner($post, $metabox) {
        print '<div style="padding:6px 0 6px;"><p style="float:left;margin:0;line-height:23px;">Clone this post and data</p><input name="afl_clone" style="float:right;display:inline-block;" type="submit" class="button-primary" id="clone" value="Clone" /><div class="clear"></div></div>';
    }

endif;

if (!function_exists('afl_pager')):

    function afl_pager($pages = '') {

        global $paged;

        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        $output = "";
        $prev = $paged - 1;
        $next = $paged + 1;
        $range = 2; // how many numbers to show around current page number
        $showitems = ($range * 2) + 1;

        if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        }

        $method = "get_pagenum_link";
        if (is_single()) {
            $method = "afl_pager_post_link";
        }

        if (1 != $pages) {
            $output .= '<!--pagination-->';
            $output .= '<div class="pagination_wrap text-center">';
            $output .= '<ul class="pagination">';
            $output .= '<li><span class="pagination-meta">' . sprintf("Page %d of %d", $paged, $pages) . '</span></li>';
            $output .= ($paged > 2 && $paged > $range + 1 && $showitems < $pages) ? "<li><a href='" . $method(1) . "'><i class=\"fa fa-angle-double-left\"></i></a></li>" : "";
            $output .= ($paged > 1 && $showitems < $pages) ? "<li><a href='" . $method($prev) . "'><i class=\"fa fa-angle-left\"></i></a></li>" : "";


            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                    $output .= '<li' . ( $paged == $i ? ' class="active"' : '' ) . '><a href="' . $method($i) . '">' . $i . '</a></li>';
                }
            }

            $output .= ($paged < $pages && $showitems < $pages) ? "<li><a href='" . $method($next) . "'><i class=\"fa fa-angle-right\"></i></a></li>" : "";
            $output .= ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages) ? "<li><a href='" . $method($pages) . "'><i class=\"fa fa-angle-double-right\"></i></a></li>" : "";
            $output .= '</ul>';
            $output .= "</div>\n";
        }

        return $output;
    }

endif;

if (!function_exists('afl_pager_post_link')):

    function afl_pager_post_link($link) {
        $url = preg_replace('!">$!', '', _wp_link_page($link));
        $url = preg_replace('!^<a href="!', '', $url);
        return $url;
    }

endif;

if (!function_exists('__afl_composer_base')):

    function __afl_composer_base($post, $metabox) {
        //print_r($post);
        ?>	
        <div class="logo-container">
            <span class="logo"></span>
            <div class="swich-button-container">
                <?php if (get_post_meta($post->ID, 'afl_composer', true) == 'on') echo '<strong>Turbo Editor enabled. You can switch to classic editor</strong>';else echo '<strong>Turbo Editor disabled. You can switch to it</strong>'; ?>
            </div>
        </div>
        <div class="item-container">

            <input type="hidden" name="afl_composer"
                   value="<?php print ($afl_composer = get_post_meta($post->ID, 'afl_composer', true)) ? $afl_composer : 'off'; ?>" />
            <input type="hidden" name="afl_theme_base" value="<?php print get_template_directory_uri(); ?>" />

            <div id="afl-loader" style="display:none;"></div>
            <?php if (current_user_can('upload_files')): ?>
                <div id="composer-media-buttons" style="display:none">
                    <?php do_action('media_buttons'); ?>
                </div>
            <?php endif; ?>
            <div id="afl-composer-base-data">
                <table width="100%" class="conainer-table" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="80%" class="left-side-cell">
                            <ul id="afl-composer-base-items">
                                <?php
                                $items = afl_get_te_data($post->ID);
                                if ($items) {
                                    $i = 0;
                                    foreach ($items as $item) {
                                        __afl_composer_base_item($i, $item);
                                    }
                                }
                                ?>
                            </ul>
                        </td>
                        <td width="20%" class="right-side-cell">
                            <?php __afl_composer_toolbox(); ?>
                        </td>
                    </tr>
                </table>
                <div class="clear"></div>
            </div>
        </div>
        <?php
    }

endif;

if (!function_exists('__afl_composer_base_item')):

    function __afl_composer_base_item(&$i, $item, $attached = '') {
        global $__SHORTCODES;
        ?>
        <li class="editor-item <?php echo $item['type'] ?>">
            <span></span>
            <div class="left-side">
                <strong><?php print $__SHORTCODES["afl_{$item['type']}"]['name'] ?> <a href="#" class="text-name"><?php print (isset($item['name']) && ($item['name'] != "Type element name...")) ? $item['name'] : 'Block Name'; ?></a></strong>
            </div>
            <input type="hidden" name="itemattached[<?php print $i ?>]" value="<?php print $attached; ?>"/>
            <input type="hidden" name="itemdata[<?php print $i ?>]" value="<?php print base64_encode(serialize($item['data'])) ?>"/>
            <input type="hidden" name="itemtype[<?php print $i ?>]" value="<?php print $item['type'] ?>"/>
            <input type="text" name="itemname[<?php print $i ?>]" style="display:none" value="<?php print isset($item['name']) ? $item['name'] : 'Type element name...'; ?>"/>
            <a class="name-apply" style="display:none;">Yes</a>
            <div class="item-wrapper" style="display:none;">
                <textarea name="itemprefix[<?php print $i ?>]" cols="50" rows="5"><?php print $item['prefix'] ?></textarea>
                <textarea name="itemsuffix[<?php print $i ?>]" cols="50" rows="5"><?php print $item['suffix'] ?></textarea>
            </div>
            <div class="right-side"><a href="#" class="wrapit afl-advance" title="Wrap It">Your Code</a><a href="#" title="Edit" class="edit afl-with-ipencil"></a><a href="#" class="delete afl-with-itrash" title="Delete"></a></div>
            <?php if ($item['type'] == 'sidebar'): ?>
                <ul class="composer-sidebar-items">
                    <?php
                    $i++;
                    foreach ($item['attached'] as $a) {
                        __afl_composer_base_item($i, $a, 'true');
                    }
                    $i--;
                    ?>
                </ul>
            <?php endif; ?>
        </li>
        <?php
        $i++;
    }

endif;

if (!function_exists('__afl_composer_edit_content_part')):

    function __afl_composer_edit_content_part($col_id, $type, $values = array()) {
        if (in_array($type, array('2_columns', '3_columns', '4_columns', 'one_third_block', 'one_third_last_block'))) {
            $title = isset($values["{$type}_title"][$col_id]) ? $values["{$type}_title"][$col_id] : '';
            $icon = isset($values["{$type}_icon"][$col_id]) ? $values["{$type}_icon"][$col_id] : '';
            $content = isset($values["{$type}_content"][$col_id]) ? $values["{$type}_content"][$col_id] : '';
            $button_text = isset($values["{$type}_button_text"][$col_id]) ? $values["{$type}_button_text"][$col_id] : '';
            $button_link = isset($values["{$type}_button_link"][$col_id]) ? $values["{$type}_button_link"][$col_id] : '';
            $id = "[$col_id]";
        } else {
            $title = isset($values["{$type}_title"]) ? $values["{$type}_title"] : '';
            $icon = isset($values["{$type}_icon"]) ? $values["{$type}_icon"] : '';
            $content = isset($values["{$type}_content"]) ? $values["{$type}_content"] : '';
            $button_text = isset($values["{$type}_button_text"]) ? $values["{$type}_button_text"] : '';
            $button_link = isset($values["{$type}_button_link"]) ? $values["{$type}_button_link"] : '';
            $id = '';
        }
        ?>
        <?php if ($type != 'full_screen') { ?>
            <div class="afl-single-set">
                <div class="afl-section afl-text afl-2columns title-icon-list">
                    <h4>Icon</h4>
                    <div class="afl-control-container">
                        <div class="afl-description"></div>
                        <div class="afl-control">
                            <span class="afl-style-wrap">
                                <?php
                                $awesome_list = array(
                                    "",
                                    "adjust",
                                    "anchor",
                                    "archive",
                                    "arrows",
                                    "arrows-h",
                                    "arrows-v",
                                    "asterisk",
                                    "ban",
                                    "bar-chart-o",
                                    "barcode",
                                    "bars",
                                    "beer",
                                    "bell",
                                    "bell-o",
                                    "bolt",
                                    "book",
                                    "bookmark",
                                    "bookmark-o",
                                    "briefcase",
                                    "bug",
                                    "building-o",
                                    "bullhorn",
                                    "bullseye",
                                    "calendar",
                                    "calendar-o",
                                    "camera",
                                    "camera-retro",
                                    "caret-square-o-down",
                                    "caret-square-o-left",
                                    "caret-square-o-right",
                                    "caret-square-o-up",
                                    "certificate",
                                    "check",
                                    "check-circle",
                                    "check-circle-o",
                                    "check-square",
                                    "check-square-o",
                                    "circle",
                                    "circle-o",
                                    "clock-o",
                                    "cloud",
                                    "cloud-download",
                                    "cloud-upload",
                                    "code",
                                    "code-fork",
                                    "coffee",
                                    "cog",
                                    "cogs",
                                    "comment",
                                    "comment-o",
                                    "comments",
                                    "comments-o",
                                    "compass",
                                    "credit-card",
                                    "crop",
                                    "crosshairs",
                                    "cutlery",
                                    "desktop",
                                    "dot-circle-o",
                                    "download",
                                    "ellipsis-h",
                                    "ellipsis-v",
                                    "envelope",
                                    "envelope-o",
                                    "eraser",
                                    "exchange",
                                    "exclamation",
                                    "exclamation-circle",
                                    "exclamation-triangle",
                                    "external-link",
                                    "external-link-square",
                                    "eye",
                                    "eye-slash",
                                    "female",
                                    "fighter-jet",
                                    "film",
                                    "filter",
                                    "fire",
                                    "fire-extinguisher",
                                    "flag",
                                    "flag-checkered",
                                    "flag-o",
                                    "flask",
                                    "folder",
                                    "folder-o",
                                    "folder-open",
                                    "folder-open-o",
                                    "frown-o",
                                    "gamepad",
                                    "gavel",
                                    "gift",
                                    "glass",
                                    "globe",
                                    "hdd-o",
                                    "headphones",
                                    "heart",
                                    "heart-o",
                                    "home",
                                    "inbox",
                                    "info",
                                    "info-circle",
                                    "key",
                                    "keyboard-o",
                                    "laptop",
                                    "leaf",
                                    "lemon-o",
                                    "level-down",
                                    "level-up",
                                    "lightbulb-o",
                                    "location-arrow",
                                    "lock",
                                    "magic",
                                    "magnet",
                                    "mail-reply-all",
                                    "male",
                                    "map-marker",
                                    "meh-o",
                                    "microphone",
                                    "microphone-slash",
                                    "minus",
                                    "minus-circle",
                                    "minus-square",
                                    "minus-square-o",
                                    "mobile",
                                    "money",
                                    "moon-o",
                                    "music",
                                    "pencil",
                                    "pencil-square",
                                    "pencil-square-o",
                                    "phone",
                                    "phone-square",
                                    "picture-o",
                                    "plane",
                                    "plus",
                                    "plus-circle",
                                    "plus-square",
                                    "plus-square-o",
                                    "power-off",
                                    "print",
                                    "puzzle-piece",
                                    "qrcode",
                                    "question",
                                    "question-circle",
                                    "quote-left",
                                    "quote-right",
                                    "random",
                                    "refresh",
                                    "reply",
                                    "reply-all",
                                    "retweet",
                                    "road",
                                    "rocket",
                                    "rss",
                                    "rss-square",
                                    "search",
                                    "search-minus",
                                    "search-plus",
                                    "share",
                                    "share-square",
                                    "share-square-o",
                                    "shield",
                                    "shopping-cart",
                                    "sign-in",
                                    "sign-out",
                                    "signal",
                                    "sitemap",
                                    "smile-o",
                                    "sort",
                                    "sort-alpha-asc",
                                    "sort-alpha-desc",
                                    "sort-amount-asc",
                                    "sort-amount-desc",
                                    "sort-asc",
                                    "sort-desc",
                                    "sort-numeric-asc",
                                    "sort-numeric-desc",
                                    "spinner",
                                    "square",
                                    "square-o",
                                    "star",
                                    "star-half",
                                    "star-half-o",
                                    "star-o",
                                    "subscript",
                                    "suitcase",
                                    "sun-o",
                                    "superscript",
                                    "tablet",
                                    "tachometer",
                                    "tag",
                                    "tags",
                                    "tasks",
                                    "terminal",
                                    "thumb-tack",
                                    "thumbs-down",
                                    "thumbs-o-down",
                                    "thumbs-o-up",
                                    "thumbs-up",
                                    "ticket",
                                    "times",
                                    "times-circle",
                                    "times-circle-o",
                                    "tint",
                                    "trash-o",
                                    "trophy",
                                    "truck",
                                    "umbrella",
                                    "unlock",
                                    "unlock-alt",
                                    "upload",
                                    "user",
                                    "users",
                                    "video-camera",
                                    "volume-down",
                                    "volume-off",
                                    "volume-up",
                                    "wheelchair",
                                    "wrench",
                                    "check-square",
                                    "check-square-o",
                                    "circle",
                                    "circle-o",
                                    "dot-circle-o",
                                    "minus-square",
                                    "minus-square-o",
                                    "plus-square",
                                    "plus-square-o",
                                    "square",
                                    "square-o",
                                    "btc",
                                    "eur",
                                    "gbp",
                                    "inr",
                                    "jpy",
                                    "krw",
                                    "money",
                                    "rub",
                                    "try",
                                    "usd",
                                    "align-center",
                                    "align-justify",
                                    "align-left",
                                    "align-right",
                                    "bold",
                                    "chain-broken",
                                    "clipboard",
                                    "columns",
                                    "eraser",
                                    "file",
                                    "file-o",
                                    "file-text",
                                    "file-text-o",
                                    "files-o",
                                    "floppy-o",
                                    "font",
                                    "indent",
                                    "italic",
                                    "link",
                                    "list",
                                    "list-alt",
                                    "list-ol",
                                    "list-ul",
                                    "outdent",
                                    "paperclip",
                                    "repeat",
                                    "scissors",
                                    "strikethrough",
                                    "table",
                                    "text-height",
                                    "text-width",
                                    "th",
                                    "th-large",
                                    "th-list",
                                    "underline",
                                    "undo",
                                    "angle-double-down",
                                    "angle-double-left",
                                    "angle-double-right",
                                    "angle-double-up",
                                    "angle-down",
                                    "angle-left",
                                    "angle-right",
                                    "angle-up",
                                    "arrow-circle-down",
                                    "arrow-circle-left",
                                    "arrow-circle-o-down",
                                    "arrow-circle-o-left",
                                    "arrow-circle-o-right",
                                    "arrow-circle-o-up",
                                    "arrow-circle-right",
                                    "arrow-circle-up",
                                    "arrow-down",
                                    "arrow-left",
                                    "arrow-right",
                                    "arrow-up",
                                    "arrows",
                                    "arrows-alt",
                                    "arrows-h",
                                    "arrows-v",
                                    "caret-down",
                                    "caret-left",
                                    "caret-right",
                                    "caret-square-o-down",
                                    "caret-square-o-left",
                                    "caret-square-o-right",
                                    "caret-square-o-up",
                                    "caret-up",
                                    "chevron-circle-down",
                                    "chevron-circle-left",
                                    "chevron-circle-right",
                                    "chevron-circle-up",
                                    "chevron-down",
                                    "chevron-left",
                                    "chevron-right",
                                    "chevron-up",
                                    "hand-o-down",
                                    "hand-o-left",
                                    "hand-o-right",
                                    "hand-o-up",
                                    "long-arrow-down",
                                    "long-arrow-left",
                                    "long-arrow-right",
                                    "long-arrow-up",
                                    "arrows-alt",
                                    "backward",
                                    "compress",
                                    "eject",
                                    "expand",
                                    "fast-backward",
                                    "fast-forward",
                                    "forward",
                                    "pause",
                                    "play",
                                    "play-circle",
                                    "play-circle-o",
                                    "step-backward",
                                    "step-forward",
                                    "stop",
                                    "youtube-play",
                                    "adn",
                                    "android",
                                    "apple",
                                    "bitbucket",
                                    "bitbucket-square",
                                    "btc",
                                    "css3",
                                    "dribbble",
                                    "dropbox",
                                    "facebook",
                                    "facebook-square",
                                    "flickr",
                                    "foursquare",
                                    "github",
                                    "github-alt",
                                    "github-square",
                                    "gittip",
                                    "google-plus",
                                    "google-plus-square",
                                    "html5",
                                    "instagram",
                                    "linkedin",
                                    "linkedin-square",
                                    "linux",
                                    "maxcdn",
                                    "pagelines",
                                    "pinterest",
                                    "pinterest-square",
                                    "renren",
                                    "skype",
                                    "stack-exchange",
                                    "stack-overflow",
                                    "trello",
                                    "tumblr",
                                    "tumblr-square",
                                    "twitter",
                                    "twitter-square",
                                    "vimeo-square",
                                    "vk",
                                    "weibo",
                                    "windows",
                                    "xing",
                                    "xing-square",
                                    "youtube",
                                    "youtube-play",
                                    "youtube-square",
                                    "ambulance",
                                    "h-square",
                                    "hospital-o",
                                    "medkit",
                                    "plus-square",
                                    "stethoscope",
                                    "user-md",
                                    "wheelchair"
                                );
                                ?>
                                <?php print afl_render_theme_option("{$type}-icon{$col_id}", array('type' => 'select', 'default_value' => $icon, 'options' => $awesome_list, 'background' => true, 'attributes' => array('name' => "{$type}_title_icon" . $id))); ?>
                                <script type="text/javascript">
                                    jQuery(document).ready(function () {
                                        jQuery("#<?php echo $type . '-icon' . $col_id ?>").ddslick({
                                            name: "<?php echo $type . '_icon' . $id ?>",
                                            onSelected: function (selectedData) {
                                                //callback function: do something with selectedData;
                                            }
                                        });
                                    });
                                </script>
                            </span>
                        </div>
                        <div class="afl-clear"></div>
                    </div>
                </div>
                <div class="afl-section afl-text afl-2columns">
                    <h4>Title</h4>
                    <div class="afl-control-container">
                        <div class="afl-description"></div>
                        <div class="afl-control">
                            <span class="afl-style-wrap">
                                <?php print afl_render_theme_option("{$type}-title{$col_id}", array('type' => 'text', 'default_value' => $title, 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_title" . $id))); ?>
                            </span>
                        </div>
                        <div class="afl-clear"></div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="afl-section afl-text te-editor">
            <div class="afl-control-container">
                <div class="afl-description"></div>
                <div class="afl-control">
                    <span class="afl-style-wrap">
                        <?php
                        $richedit = user_can_richedit();
                        global $post;
                        $class = ( $richedit ? 'afl-wysiwyg' : '' );
                        if ($richedit) :
                            ?>
                            <a class="alignright" id="edSideButtonHTML" onclick="switchSpecialEditors.go('<?php print "{$type}-content-{$col_id}" ?>', 'html');">HTML</a>
                            <a class="active alignright" id="edSideButtonPreview"  onclick="switchSpecialEditors.go('<?php print "{$type}-content-{$col_id}" ?>', 'tinymce');">Visual</a>
                        <?php endif; ?>
                        <?php print afl_render_theme_option("{$type}-content-{$col_id}", array('type' => 'textarea', 'default_value' => wp_richedit_pre($content), 'attributes' => array('class' => "regular-text $class", 'name' => "{$type}_content" . $id))); ?>
                    </span>
                </div>
                <div class="afl-clear"></div>
            </div>
        </div>
        <?php if ($type != 'full_screen') { ?>
            <div class="afl-single-set">
                <div class="afl-section afl-text afl-2columns">
                    <h4>Button text</h4>
                    <div class="afl-control-container">
                        <div class="afl-description"></div>
                        <div class="afl-control">
                            <span class="afl-style-wrap">
                                <?php print afl_render_theme_option("{$type}-button-text{$col_id}", array('type' => 'text', 'default_value' => $button_text, 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_button_text" . $id))); ?>
                            </span>
                        </div>
                        <div class="afl-clear"></div>
                    </div>
                </div>
                <div class="afl-section afl-text afl-2columns">
                    <h4>Button link</h4>
                    <div class="afl-control-container">
                        <div class="afl-description"></div>
                        <div class="afl-control">
                            <span class="afl-style-wrap">
                                <?php print afl_render_theme_option("{$type}-button-link{$col_id}", array('type' => 'text', 'default_value' => $button_link, 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_button_link" . $id))); ?>
                            </span>
                        </div>
                        <div class="afl-clear"></div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php
    }

endif;

if (!function_exists('__afl_composer_edit_item_custom_style')) :

    function __afl_composer_edit_item_custom_style($col_id, $type, $data, $values = array()) {
        ?>
        <div id="afl-form-options">
            <div class="te-form">
                <div class="afl-options-page">
                    <div class="afl-options-container">
                        <div class="afl-single-set">
                            <div class="afl-section afl-text afl-3columns afl-col-1">
                                <h4><?php print __('Content type', 'afl'); ?></h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
                                        <span class="afl-style-wrap afl-select-style-wrap">
                                            <span class="afl-select-unify">
                                                <?php
                                                print afl_render_theme_option("{$type}-containerstyle", array('type' => 'select',
                                                            'options' => array(
                                                                '' => '',
                                                                'services' => 'services',
                                                                'our-team' => 'our-team'
                                                            ),
                                                            'default_value' => (isset($data["{$type}_containerstyle"]) ? $data["{$type}_containerstyle"] : ''),
                                                            'attributes' => array('class' => 'regular-text', 'name' => "{$type}_containerstyle")));
                                                ?>
                                                <span class="afl-select-fake-val"><?php echo isset($data["{$type}_containerstyle"]) ? $data["{$type}_containerstyle"] : ''; ?></span>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="afl-clear"></div>
                                </div>
                            </div>
                            <div class="afl-section afl-text afl-3columns afl-col-2">
                                <h4><?php print __('Background color', 'afl'); ?></h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
                                        <span class="afl-style-wrap afl-select-style-wrap">
                                            <span class="afl-select-unify">
                                                <?php
                                                print afl_render_theme_option("{$type}-containerbgcolor", array('type' => 'select',
                                                            'options' => array(
                                                                '' => '',
                                                                'grey' => 'grey',
                                                                'bg-color-1' => 'bg-color-1',
                                                                'bg-color-2' => 'bg-color-2',
                                                                'bg-color-3' => 'bg-color-3',
                                                                'bg-color-4' => 'bg-color-4',
                                                                'bg-color-5' => 'bg-color-5',
                                                                'bg-color-6' => 'bg-color-6',
                                                                'bg-color-7' => 'bg-color-7',
                                                                'bg-color-8' => 'bg-color-8',
                                                                'bg-color-9' => 'bg-color-9'
                                                            ),
                                                            'default_value' => (isset($data["{$type}_containerbgcolor"]) ? $data["{$type}_containerbgcolor"] : ''),
                                                            'attributes' => array('class' => 'regular-text', 'name' => "{$type}_containerbgcolor")));
                                                ?>
                                                <span class="afl-select-fake-val"><?php echo isset($data["{$type}_containerbgcolor"]) ? $data["{$type}_containerbgcolor"] : ''; ?></span>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="afl-clear"></div>
                                </div>
                            </div>
                            <div class="afl-section afl-text afl-3columns afl-col-3">
                                <h4><?php print __('CSS class', 'afl'); ?></h4>

                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
                                        <span class="afl-style-wrap">
                                            <?php
                                            if (!isset($data["{$type}_customcssclass"]))
                                                $data["{$type}_customcssclass"] = '';
                                            print afl_render_theme_option("{$type}-customcssclass", array('type' => 'text', 'default_value' => $data["{$type}_customcssclass"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_customcssclass")));
                                            ?>
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
        <?php
    }

endif;


if (!function_exists('__afl_composer_edit_item_divider')) :

    function __afl_composer_edit_item_divider($col_id, $type, $data, $values = array()) {
        ?>
        <div id="afl-edit-item-tabs-content<?php print $col_id; ?>">
            <div  id="afl-form-options">
                <div class="te-form">
                    <div class="afl-options-page">
                        <div class="afl-options-container">
                            <div class="afl-section afl-text">
                                <h4><?php print __('Divider type', 'afl'); ?></h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
                                        <span class="afl-style-wrap afl-select-style-wrap">
                                            <span class="afl-select-unify">
                                                <?php
                                                print afl_render_theme_option("{$type}-dividertype", array('type' => 'select',
                                                            'options' => array(
                                                                '' => '',
                                                                'bold' => 'bold',
                                                                'small' => 'small',
                                                                'mini' => 'mini',
                                                                'bottom' => 'bottom',
                                                                'top' => 'top',
                                                                'invisible' => 'invisible'
                                                            ),
                                                            'default_value' => (isset($data["{$type}_dividertype"]) ? $data["{$type}_dividertype"] : ''),
                                                            'attributes' => array('class' => 'regular-text', 'name' => "{$type}_dividertype")));
                                                ?>
                                                <span class="afl-select-fake-val"><?php echo isset($data["{$type}_dividertype"]) ? $data["{$type}_dividertype"] : ''; ?></span>
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
        <?php
    }

endif;


if (!function_exists('__afl_composer_edit_item_tab')):

    function __afl_composer_edit_item_tab($col_id, $type, $values = array()) {
        ?>
        <div id="afl-edit-item-tabs-content<?php print $col_id; ?>">
            <div  id="afl-form-options">
                <div class="te-form">
                    <div class="afl-options-page">
                        <div class="afl-options-container">
                            <?php __afl_composer_edit_content_part($col_id, $type, $values); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

endif;

if (!function_exists('__afl_composer_edit_text_slider_item')):

    function __afl_composer_edit_text_slider_item($col_id, $type, $values = array()) {
        ?>
        <div id="afl-edit-item-tabs-content<?php print $col_id; ?>" class="text-slide">
            <div class="te-form">
                <div class="afl-options-page">
                    <div class="afl-options-container">
                        <div class="afl-single-set">
                            <div class="afl-section afl-text afl-2columns">
                                <h4>Title</h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
                                        <span class="afl-style-wrap">
                                            <?php print afl_render_theme_option("{$type}-title{$col_id}", array('type' => 'text', 'default_value' => $values[$type][$col_id]['title'], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}[$col_id][title]"))); ?>
                                        </span>
                                    </div>
                                    <div class="afl-clear"></div>
                                </div>
                            </div>
                            <div class="afl-section afl-text afl-2columns te-upload">
                                <h4>Icon</h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
                                        <span class="afl-style-wrap">
                                            <?php print afl_render_theme_option("{$type}-icon{$col_id}", array('type' => 'text', 'uploadable' => true, 'default_value' => $values[$type][$col_id]['icon'], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}[$col_id][icon]"))); ?>
                                        </span>
                                    </div>
                                    <div class="afl-clear"></div>
                                </div>
                            </div>
                        </div>
                        <div class="afl-section afl-text te-editor">
                            <div class="afl-control-container">
                                <div class="afl-description"></div>
                                <div class="afl-control">
                                    <span class="afl-style-wrap">
                                        <?php
                                        $richedit = user_can_richedit();
                                        global $post;
                                        $class = ( $richedit ? 'afl-wysiwyg' : '' );
                                        if ($richedit) :
                                            ?>
                                            <a class="alignright" id="edSideButtonHTML" onclick="switchSpecialEditors.go('<?php print "{$type}-content-{$col_id}" ?>', 'html');">HTML</a>
                                            <a class="active alignright" id="edSideButtonPreview"  onclick="switchSpecialEditors.go('<?php print "{$type}-content-{$col_id}" ?>', 'tinymce');">Visual</a>
                                        <?php endif; ?>
                                        <?php print afl_render_theme_option("{$type}-content-{$col_id}", array('type' => 'textarea', 'default_value' => wp_richedit_pre($values[$type][$col_id]['content']), 'attributes' => array('class' => "regular-text $class", 'name' => "{$type}[$col_id][content]"))); ?>
                                    </span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-single-set">
                            <div class="afl-section afl-text afl-2columns">
                                <h4>Button text</h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
                                        <span class="afl-style-wrap">
                                            <?php print afl_render_theme_option("{$type}-button-text{$col_id}", array('type' => 'text', 'default_value' => $values[$type][$col_id]['button_text'], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}[$col_id][button_text]"))); ?>
                                        </span>
                                    </div>
                                    <div class="afl-clear"></div>
                                </div>
                            </div>
                            <div class="afl-section afl-text afl-2columns">
                                <h4>Button link</h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
                                        <span class="afl-style-wrap">
                                            <?php print afl_render_theme_option("{$type}-button-link{$col_id}", array('type' => 'text', 'default_value' => $values[$type][$col_id]['button_link'], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}[$col_id][button_link]"))); ?>
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
        <?php
    }

endif;

if (!function_exists('afl_get_post_meta_original')):

    function afl_get_post_meta_original($post_id, $key) {
        global $wpdb;
        $res = $wpdb->get_results($wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE post_id=%d AND meta_key='%s'", $post_id, $key));
        return ($res[0]->meta_value);
    }

endif;

if (!function_exists('afl_get_te_data')):

    function afl_get_te_data($post_id, $key = 'afl_composer_data') {
        $meta = get_post_meta($post_id, $key);
        if (!empty($meta)) {
            $meta = $meta[0];
        }
        if (is_string($meta)) {

            //trying json decode
            $tmp = json_decode($meta, true);
            if ((!$tmp && function_exists('json_last_error') && json_last_error() !== JSON_ERROR_NONE) || ($tmp == NULL && !function_exists('json_last_error'))) {
                //trying base64_decode
                $tmp = base64_decode($meta);
                $tmp = json_decode($tmp, true);
            }

            $meta = $tmp;
        }
        return $meta;
    }

endif;

if (!function_exists('afl_set_te_data')):

    function afl_set_te_data($post_id, $data, $key = 'afl_composer_data') {
        if (intval($post_id) > 0) {
            $data = json_encode($data);
            $data = base64_encode($data);
            global $wpdb;
            if (($meta_id = $wpdb->get_var($wpdb->prepare("SELECT meta_id FROM $wpdb->postmeta WHERE post_id=%d AND meta_key='%s'", $post_id, $key))) > 0) {
                $wpdb->update($wpdb->postmeta, array('meta_value' => $data), array('meta_id' => $meta_id), array('%s'), array('%d'));
            } else {
                $wpdb->insert($wpdb->postmeta, array('post_id' => $post_id, 'meta_key' => $key, 'meta_value' => $data), array('%d', '%s', '%s'));
            }
        }
    }

endif;

if (!function_exists('afl_get_active_sitebars')):

    function afl_get_active_sitebars() {
        global $wp_registered_sidebars;
        $opts = array();
        foreach ($wp_registered_sidebars as $k => $v) {
            if (is_active_sidebar($k)) {
                $opts[$k] = $v['name'];
            }
        }
        return $opts;
    }

endif;

if (!function_exists('afl_get_cufon_font_list')):

    function afl_get_cufon_font_list() {
        static $fonts;
        if (!$fonts) {
            $fonts = array();
            if ($handle = opendir(TEMPLATEPATH . '/js/fonts')) {
                while (false !== ($file = readdir($handle))) {
                    if (preg_match('/(\w+)_(\d+)\.font\.js/', $file, $matches)) {
                        $fonts[] = array('name' => str_replace('_', ' ', $matches[1]), 'weight' => $matches[2]);
                    }
                }
                closedir($handle);
            }
        }
        return $fonts;
    }

endif;

if (!function_exists('afl_get_google_font_list')):

    function afl_get_google_font_list() {
        return array(
            'Alice', 'Allerta', 'Arvo', 'Antic',
            'Bangers', 'Bitter',
            'Cabin', 'Cardo', 'Carme', 'Coda', 'Coustard',
            'Gruppo',
            'Damion', 'Dancing Script', 'Droid Sans', 'Droid Serif',
            'EB Garamond',
            'Fjord One',
            'Inconsolata',
            'Josefin Sans', 'Josefin Slab',
            'Kameron', 'Kreon',
            'Lobster', 'League Script',
            'Mate SC', 'Mako', 'Merriweather', 'Metrophobic', 'Molengo', 'Muli',
            'Nobile', 'News Cycle',
            'Open Sans', 'Orbitron', 'Oswald',
            'Pacifico', 'Philosopher', 'Poly', 'Podkova',
            'Quattrocento', 'Questrial', 'Quicksand',
            'Raleway',
            'Salsa', 'Sunshiney', 'Signika Negative',
            'Tangerine', 'Terminal Dosis', 'Tenor Sans',
            'Varela Round',
            'Yellowtail',
        );
    }

endif;

if (!function_exists('afl_get_background_parts')):

    function afl_get_background_parts() {
        return array('page', 'header', 'fullwidth', 'content', 'footer');
    }

endif;

if (!function_exists('afl_get_meta_tag_list')):

    function afl_get_meta_tag_list() {
        return array(
            '[logo part1]' => 'header .logo a strong',
            '[logo part2]' => 'header .logo a b',
            '[tagline]' => 'header .logo i',
            '[menu items]' => 'ul#menu-main-menu li a',
            '[menu items hover]' => 'ul#menu-main-menu li a:hover, ul#menu-main-menu li.current_page_item>a, ul#menu-main-menu li li.current_page_item>a, ul#menu-main-menu li.current_page_parent>a, ul#menu-main-menu li.sfHover>a',
            '[content text]' => 'section#content'
        );
    }

endif;

if (!function_exists('afl_background_settings')):

    function afl_background_settings() {
        $styles = array();
        foreach (afl_get_background_parts() as $part) {
            $background = get_theme_mod("afl_{$part}_background_image", '');
            if (!get_theme_mod("afl-{$part}-color-transparent", false))
                $color = '#' . get_theme_mod("afl_{$part}_background_color", '');
            else
                $color = 'transparent';
            if (!$background && !$color)
                continue;
            $style = "background-color: $color;";
            if ($background) {
                $image = " background-image: url('$background');";

                $repeat = get_theme_mod("afl_{$part}_background_repeat", 'repeat');
                if (!in_array($repeat, array('no-repeat', 'repeat-x', 'repeat-y', 'repeat')))
                    $repeat = 'repeat';
                $repeat = " background-repeat: $repeat;";

                $position = get_theme_mod("afl_{$part}_background_position_x", 'left');
                if (!in_array($position, array('center', 'right', 'left')))
                    $position = 'left';
                $position = " background-position: top $position;";

                $attachment = get_theme_mod("afl_{$part}_background_attachment", 'scroll');
                if (!in_array($attachment, array('fixed', 'scroll')))
                    $attachment = 'scroll';
                $attachment = " background-attachment: $attachment;";

                $style .= $image . $repeat . $position . $attachment;
            } else {
                $style .= 'background-image:none; ';
            }
            $styles[$part] = $style;
        }

        return $styles;
    }

endif;

if (!function_exists('afl_get_active_fonts')):

    function afl_get_active_fonts() {
        static $fonts;
        if (!$fonts) {
            $fonts = array();
            if (is_array($option_fonts = unserialize(get_option('afl_font')))) {
                foreach ($option_fonts as $font) {
                    $font_parts = explode(';', $font['font']);
                    $font['filename'] = 'js/fonts/' . str_replace(' ', '_', $font_parts[0]) . "_{$font_parts[1]}.font.js";
                    $font['name'] = $font_parts[0];
                    $font['weight'] = $font_parts[1];
                    unset($font['font']);
                    if (file_exists(TEMPLATEPATH . '/' . $font['filename'])) {
                        $fonts[] = $font;
                    }
                }
            }
        }
        return $fonts;
    }

endif;

if (!function_exists('afl_import_google_fonts')):

    function afl_import_google_fonts() {
        global $__OPTIONS;
        $font_list = array();
        if (is_array($fonts = unserialize($__OPTIONS['afl_font']['default_value']))) {
            foreach ($fonts as $font) {
                if (!in_array($font['font'], $font_list))
                    $font_list[] = $font['font'];
            }
        }
        $out = '';
        if (!empty($font_list)) {
            $out = '<style type="text/css"> ';
            $out .= '@import url("' . 'http://fonts.googleapis.com/css?family=' . implode('|', $font_list) . '");';
            $out .= ' </style>';
        }
        return $out;
    }

endif;

if (!function_exists('afl_get_custom_style')):

    function afl_get_custom_style() {
        //global $__OPTIONS, $__CUSTOM_COLORS;

        $styles = afl_background_settings();

        $out = '';
        if (count($styles) > 0) {
            $out .= '<style type="text/css"> ';
            if (isset($styles['page'])) {
                $out .= 'body { ' . trim($styles['page']) . ' } ';
            }
            if (isset($styles['header'])) {
                $out .= 'header { ' . trim($styles['header']) . ' } ';
            }
            if (isset($styles['fullwidth'])) {
                $out .= 'section.container { ' . trim($styles['fullwidth']) . ' } ';
            }
            if (isset($styles['content'])) {
                $out .= 'section#container { ' . trim($styles['content']) . ' } ';
            }
            if (isset($styles['footer'])) {
                $out .= 'footer { ' . trim($styles['footer']) . ' } ';
            }
            $out .= ' </style>';
        }
        $fonts = unserialize(get_option('afl_font', ''));
        if (is_array($fonts)) {
            $metatags = afl_get_meta_tag_list();
            $metatags_keys = array_keys($metatags);
            if (count($fonts) > 0) {
                $out .= '<style type="text/css"> ';
                $loads = array();
                foreach ($fonts as $font) {
                    $font['selector'] = trim(strtolower($font['selector']));
                    if (in_array($font['selector'], $metatags_keys)) {
                        $font['selector'] = $metatags[$font['selector']];
                    }
                    if (!empty($font['color'])) {
                        $style = "color: $font[color];";
                    }
                    if (!empty($font['font'])) {
                        $loads[] = $font['font'];
                        $font['font'] = str_replace('+', ' ', $font['font']);
                        $style .= "font-family: '$font[font]';";
                    }
                    $out .= "$font[selector] { {$style} } ";
                }

                $out .= ' </style>';
            }
            $out .= afl_import_google_fonts();
        }

        // Apply Color Scheme
        //var_export($__CUSTOM_COLORS[$__OPTIONS['afl_scheme']['default_value']]);
        /* $settings = $__CUSTOM_COLORS[$__OPTIONS['afl_scheme']['default_value']];
          $out .= '<style type="text/css"> ';
          foreach($settings as $name => $value){
          if(!empty($value))
          switch($name){
          case 'google_webfont':
          $out .= '@import url("'.'http://fonts.googleapis.com/css?family='.str_replace(' ', '+', trim($value)).'"); ';
          $out .= 'h1,h2,h3,h4,h5,h6{font-family: "'.$value.'"}';
          break;
          }
          }
          $out .= ' </style>'; */

        return $out;
    }

endif;

if (!function_exists('afl_get_option')):

    function afl_get_option($key, $default = "", $echo = false) {
        global $afl;
        $result = $afl->options;

        if (is_array($key)) {
            $result = $result[$key[0]];
        } else {
            $result = $result['afl'];
        }

        if (isset($result[$key])) {
            $result = $result[$key];
        } else {
            $result = $default;
        }

        if ($result == "") {
            $result = $default;
        }
        if ($echo)
            echo $result;

        return $result;
    }

endif;

if (!function_exists('afl_merge_colors')):

    function afl_merge_colors($color1, $color2) {
        if (empty($color1))
            return $color2;
        if (empty($color2))
            return $color1;

        $prepend = array("", "");
        $colors = array(afl_hex_to_rgb_array($color1), afl_hex_to_rgb_array($color2));

        $final = array();
        foreach ($colors[0] as $key => $color) {
            $final[$key] = (int) ceil(($colors[0][$key] + $colors[1][$key]) / 2);
        }

        return afl_get_hex_from_rgb($final[0], $final[1], $final[2]);
    }

endif;

if (!function_exists('afl_get_hex_from_rgb')):

    function afl_get_hex_from_rgb($r = FALSE, $g = FALSE, $b = FALSE) {
        $x = 255;
        $y = 0;

        $r = (is_int($r) && $r >= $y && $r <= $x) ? $r : 0;
        $g = (is_int($g) && $g >= $y && $g <= $x) ? $g : 0;
        $b = (is_int($b) && $b >= $y && $b <= $x) ? $b : 0;


        return sprintf('#%02X%02X%02X', $r, $g, $b);
    }

endif;

if (!function_exists('afl_hex_to_rgb_array')):

    function afl_hex_to_rgb_array($color) {
        if (strpos($color, '#') !== false) {
            $color = substr($color, 1, strlen($color));
        }

        $color = str_split($color, 2);
        foreach ($color as $key => $c)
            $color[$key] = hexdec($c);

        return $color;
    }

endif;

if (!function_exists('afl_counter_color')):

    function afl_counter_color($color) {
        $color = afl_hex_to_rgb_array($color);

        foreach ($color as $key => $value) {
            $color[$key] = (int) (255 - $value);
        }

        return afl_get_hex_from_rgb($color[0], $color[1], $color[2]);
    }

endif;

if (!function_exists('get_color')):

    function get_color($el) {
        global $__COLORS;
        if (empty($el))
            return '';

        if (!($color = get_option('afl_' . $el)))
            $color = $__COLORS[$el];

        return $color;
    }

endif;
?>
