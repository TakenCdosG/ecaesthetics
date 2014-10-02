<?php
/*
Plugin Name: Tabbed Widgets
Plugin URI: http://konstruktors.com/projects/wordpress-plugins/tabbed-accordion-widgets/
Description: Place widgets into tabbed and accordion type interface.
Version: 1.3.1
Author: Kaspars Dambis
Author URI: http://konstruktors.com/blog/

Thanks for suggestions to Ronald Huereca.
*/

// Option row where we store widget copies, as other plugins (such as widget context) might take them over
define('ORIGINAL_WIDGETS', 'tabbed_widgets_originals');

new tabbedWidgets();

class tabbedWidgets {
	var $tabbed_widget_content = array();
	var $stored_widgets = array();
	var $plugin_path = '';
	
	function tabbedWidgets() {			
		$this->plugin_path = get_template_directory_uri().'/lib/inc/widgets/';
		
		add_action('widgets_init', array($this, 'initSidebarAndWidget'), 1);
		add_action('sidebar_admin_setup', array($this, 'saveWidgets'), 1); // Save it in our own row, as other plugins might take it over when we need it. Like widget context plugin, for example.
		add_action('admin_enqueue_scripts', array($this, 'addAdminCSS'));
	}
	
	function initSidebarAndWidget() {
		// Init tabbed widgets
		register_widget('tabbedWidgetWidget');
	}
	
	function saveWidgets() {
		global $wp_registered_widgets;
		
		//$sidebars_widgets = wp_get_sidebars_widgets(false);
        $sidebars_widgets = get_option('sidebars_widgets', array());
        //$sidebars_widgets = wp_get_sidebars_widgets($deprecated = true);

		// Stored widgets include all default widget settings and function calls
		if (is_array($sidebars_widgets) && !empty($sidebars_widgets)) {
			foreach ($sidebars_widgets as $sidebar_id => $widgets) {
				if (is_array($widgets) && !empty($widgets)) {
                    //var_export($widgets);
					foreach ($widgets as $widget_id) {
						// Save original widgets, except the self
						if (!empty($wp_registered_widgets[$widget_id]) && strpos($widget_id, 'tabbed-widget') === false) {
							$this->stored_widgets[$widget_id] = $wp_registered_widgets[$widget_id];
							$this->stored_widgets[$widget_id]['titles'] = $this->get_widget_titles($wp_registered_widgets[$widget_id]);
						}
					}
				}
			}
			update_option(ORIGINAL_WIDGETS, $this->stored_widgets);
		}
	}
	
	function get_widget_titles($widget_data) {
		$widget_name = $widget_data['name'];
		$widget_params = $widget_data['params'];
		$widget_callback = $widget_data['callback'];
		
		// if parameter is a string
		if (isset($widget_params[0]) && !is_array($widget_params[0]))
			$widget_params = $widget_params[0];
		
		//$sidebar_params['before_title'] = '[%';
		//$sidebar_params['after_title'] = '%]';
		$all_params = '';//array_merge(array($sidebar_params), (array)$widget_params);
			
		if (is_callable($widget_callback)) {
			// Call widget to see its title
			ob_start();
				//call_user_func_array($widget_callback, $all_params);
				$widget_title = ob_get_contents();
			ob_end_clean();
			
			// Extract only title of the widget
			$find_fn_pattern = '/\[\%(.*?)\%\]/';
			preg_match_all($find_fn_pattern, $widget_title, $result);
			if(!empty($result[1][0])) {
                $given_title = strip_tags(trim((string)$result[1][0]));
            } else {
                $given_title = '';
            }
		} else {

			$widget_title = $widget_name;
			$given_title = '';
		}

		return array('original_title' => $widget_name, 'given_title' => $given_title);
	}		

	function addAdminCSS() {
		wp_enqueue_style('tabbed-widgets-admin', $this->plugin_path . 'css/admin-style.css');
	}

}




class tabbedWidgetWidget extends WP_Widget {
	var $tw_options = array();
	var $active_widgets = array();
	
	function tabbedWidgetWidget() {
		$widget_ops = array('classname' => 'tabbed-widget', 'description' => 'Place widgets inside a tabbed type interface');
		$control_ops = array('width' => 390, 'id_base' => 'tabbed-widget');
		$this->WP_Widget('tabbed-widget', 'Tabbed Widget', $widget_ops, $control_ops);
		
		if (empty($this->active_widgets))
			$this->active_widgets = get_option(ORIGINAL_WIDGETS);
	}
	
	function update($new_instance, $old_instance) {		
		return $new_instance;
	}
	
	function form($instance) {
		$options = '<div class="widget-wrapper">';
        $value = "";
        if(!empty($instance['widget_title'])){
            $value = esc_attr($instance['widget_title']);
        }
		$options .= '<p class="tw-title">' . $this->makeTitleOption($instance, 'show_title', 'Show Title') . '<input type="text" name="' . $this->get_field_name('widget_title') . '" class="tw-widget-title" value="'. $value .'" /></p>';
		
		for ($count = 0; $count < 5; $count++) {
			$count_out = $count + 1;
			$tab_title = __('Tab', 'afl') . ' ' . $count_out . ':';
			
			$options .= '<div class="tw-each-tab">' 
				. $this->makeSimpleRadio($instance, 'start_tab', $count, $tab_title)
				. $this->makeSingleWidgetsList($instance, 'inside_' . $count . '_widget') . ' '
				. $this->makeSingleWidgetsTitleField($instance, 'inside_' . $count . '_title') 
				. '</div>';
		}
		$options .= '</div>';
				
		print $options;	
	}
	
	function widget($args, $instance) {
		global $wp_registered_sidebars, $wp_registered_widgets;

		$widgetdata = $this->get_widgetdata($instance);
		$widget_no = str_replace('tabbed-widget-', '', $args['widget_id']);

		if (!empty($instance['show_title'])) {
			$widget_title = $args['before_title'] . $instance['widget_title'] . $args['after_title'];
        } else {
            $widget_title = '';
        }

		$result = $args['before_widget'];
		$result .= $widget_title;

		$result .= '<ul id="tabs-'.$widget_no.'" class="nav nav-tabs"></ul>';
		$result .= '<div class="tab-content" data-parent="#tabs-'.$widget_no.'" data-open="'.(isset($instance['start_tab']) && intval($instance['start_tab']) > 0 ? $instance['start_tab']+1 : 1).'">';

		foreach ($widgetdata['inside'] as $id => $inside) {
			$callback = $wp_registered_widgets[$inside['widget']]['callback'];
			$params = array_merge(array($args), (array)$wp_registered_widgets[$inside['widget']]['params']);

			if (is_callable($callback)) {
				$widget_title = trim($inside['title']);
				if (empty($widget_title))
					$widget_title = $this->active_widgets[$inside['widget']]['titles']['original_title'];

				$params[0]['before_widget'] = '<li class="tab"><a href="#tab-'.$id.'" data-toggle="tab">'.$widget_title.'</a></li><div class="tab-pane fade in" id="tab-'.$id.'">';
				$params[0]['before_title'] = '<span style="display:none;">';
				$params[0]['after_title'] =  '</span>';
				$params[0]['after_widget'] = '</div>';

				$result .= $this->callMe($callback, $params);
			} else {
				$result .= '<!-- t-error: Callback not possible. -->';
			}
		}

		$result .= '</div>';
		$result .= $args['after_widget'];

		print $result;
	}	

	// ------------------------------------ Helpers
	
	function get_widgetdata($instance) {
		$widgetdata = array();
		
		// Turn the list of tab widgets into an array
		foreach ($instance as $id => $value) {
            list($kaka, $which, $what) = array_pad(preg_split('/[_]/', $id), 3, null);
			if ($kaka == 'inside') {
				if ($what == 'title')
					$widgetdata['inside'][$which]['title'] = $value;
				if ($what == 'widget')
					$widgetdata['inside'][$which]['widget'] = $value;
			} else {
				$widgetdata[$id] = $value;
			}
		}
		
		// check if widget content is not empty
		foreach ($widgetdata['inside'] as $id => $data) {
			$widget_inside = trim($data['widget']);
			if (empty($widget_inside) || $widget_inside == '')
				unset($widgetdata['inside'][$id]);
		}
		
		return $widgetdata;
	}
	
	function callMe($callback, $params) {		
		ob_start();
			call_user_func_array($callback, $params);	
			$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}
	
	
	// ------------------------------------ Design
	function makeSingleWidgetsList($instance, $inst_name) {
		$list = ' <label class="tw-in-widget-list">'
			. '<select name="' . $this->get_field_name($inst_name) . '" id="'. $this->get_field_id($inst_name) .'">'
			. '<option></option>';
			
		if (!empty($this->active_widgets)) {
			foreach ($this->active_widgets as $widget_id => $widget_data) {
				$value = $widget_data['titles']['original_title'];
				if (!empty($widget_data['titles']['given_title']))
					$value .= ': ' . $widget_data['titles']['given_title'];
					
				if (!empty($instance[$inst_name]) && $instance[$inst_name] == $widget_id) {
					$selected = 'selected="selected"';
				} else {
					$selected = '';
				}
				
				if (strpos($widget_id, 'tabbed-widget') === false) {
					$list .= '<option value="' . $widget_id . '" ' . $selected . '>' . esc_attr($value) . '</option>';
				}
			}
		} else {
			$list .= '<option value="error" selected="selected">Place widgets in the "Inactive Widgets" to make them available here.</option>';
		}
		
		$list .= '</select></label>';
		
		return $list;
	}
	
	function makeSingleWidgetsTitleField($instance, $inst_name) {
        $value = "";
        if(!empty($instance[$inst_name])){
            $value = esc_attr($instance[$inst_name]);
        }
		return '<label class="tw-in-widget-title">' . __('Title', 'afl') . ': '
			. '<input type="text" name="'. $this->get_field_name($inst_name) .'" id="'. $this->get_field_id($inst_name) .'" value="'. $value .'" /></label>';
	}

	function makeSimpleRadio($instance, $inst_name, $id, $label = null) {
		if (!empty($instance[$inst_name]) && $instance[$inst_name] == $id) {
			$checked = 'checked="checked"';
			$classname = 'active';
		} else {
			$checked = '';
			$classname = '';
		}
		
		return '<label class="' . $classname . '">'
			. '<input type="radio" id="'. $this->get_field_id($inst_name) .'" name="'. $this->get_field_name($inst_name) . '" value="'. $id .'" '. $checked .' /> ' 
			. $label . '</label>';
	}	

	function makeTitleOption($instance, $inst_name, $label = '') {
        if (!isset($instance[$inst_name])){
            $instance[$inst_name] = '';
        }
		if ($instance[$inst_name] == 1 || $instance[$inst_name] == 'on')
			$checked = 'checked="checked"';
		else
			$checked = '';
		
		return '<input type="checkbox" value="1" id="' . $this->get_field_id($inst_name) . '" name="' . $this->get_field_name($inst_name) . '" '. $checked .' /> ' 
			. '<label for="' . $this->get_field_id($inst_name) . '">' . $label . '</label> ';
	}

}



?>