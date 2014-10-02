<?php
include '../../../../../wp-load.php';
if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';
$import_error = false;
$dummy_path = get_template_directory().'/lib/inc/dummy/dummy';

//check if wp_importer, the base importer class is available, otherwise include it
if ( !class_exists( 'WP_Importer' ) ) {
    $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
    if ( file_exists( $class_wp_importer ) )
		require_once($class_wp_importer);
	else
		$import_error = true;
}

if ( !class_exists( 'WP_Import' ) ) {
	$class_wp_import = get_template_directory().'/lib/inc/wordpress-importer.php';
	if ( file_exists( $class_wp_import ) )
		require_once($class_wp_import);
	else
		$import_error = true;
}

if($import_error !== false) {
	echo "The Auto importing script could not be loaded. please use the wordpress importer and import the XML file that is located in your themes folder manually.";
}
else
{
	if (!$export) {
		if (!is_file($dummy_path . '.xml')) {
			echo "The XML file containing the dummy content is not available or could not be read in <pre>" . get_template_directory().'/lib/inc/' . "dummy</pre><br/> You might want to try to set the file permission to chmod 777.<br/>If this doesn't work please use the wordpress importer and import the XML file (should be located in your themes folder: dummy.xml) manually <a href='/wp-admin/import.php'>here.</a>";
		} else {
			$wp_import = new WP_Import();
			$wp_import->fetch_attachments = true;
			$wp_import->import($dummy_path . '.xml');
			importDummy($dummy_path . '.php');
		}
	} else {
			exportDummy($dummy_path . '_export.php');
	}
}

function exportDummy($dummy_path) {
	$options_array = wp_load_alloptions();
	$fh = fopen( $dummy_path, 'w+' );
	if( $fh ){
		$base64_options = '<?php'.PHP_EOL.'$options="'.base64_encode( serialize( $options_array ) ).'";'.PHP_EOL;
		$base64_menu = '';

		/*Populate Menu*/
		$menus = get_nav_menu_locations();
		$menu_export = Array();

		if( $menus ){
			$menu = Array();

			foreach( $menus as $location => $id )
				$menu[$location] = wp_get_nav_menu_object( $id );

			if( $menu ){
				foreach( $menu as $location => $menu_unit ) {
					$menu_export[$location]['name'] =  $menu_unit->name;
					$menu_export[$location]['slug'] =  $menu_unit->slug;
					$menu_export[$location]['posts'] = wp_get_nav_menu_items( $menu_unit->term_id );
				}
				$base64_menu = '$menu="'.base64_encode( serialize( $menu_export ) ).'";';
			}
		}

		fwrite( $fh, $base64_options.$base64_menu );
		fclose( $fh );

		echo '<div class="result">Dummy Content Successfully Exported</div>';

	} else {
		echo '<div class="result">error: cant create dummy_export.php file</div>';
	}
}

function importDummy($dummy_path) {
	@include_once( $dummy_path );
	if( isset( $options ) ){
		$dummy_option = $options;
		$dummy_option = unserialize( base64_decode( $dummy_option ) );
		$test = unserialize( base64_decode( "YTo2OntpOjA7czo3OiJzaXRldXJsIjtpOjE7czoxMToiYWRtaW5fZW1haWwiO2k6MjtzOjQ6ImhvbWUiO2k6MztzOjE3OiJ3b3JkcHJlc3NfYXBpX2tleSI7aTo0O3M6ODoidGVtcGxhdGUiO2k6NTtzOjEwOiJzdHlsZXNoZWV0Ijt9" ) );
		$new_template = get_option( 'template' );
		$old_template = $dummy_option['template'];

		foreach ($dummy_option as $option_name => $option_value) {
			if($option_name == 'theme_mods_'.$old_template) $option_name = 'theme_mods_'.$new_template;
			$option_value = maybe_unserialize($option_value);
			if (!(in_array($option_name, $test)))
				if (get_option($option_name) != $option_value)
					update_option($option_name, $option_value);
				else
					add_option($option_name, $option_value);
		}

		if( isset( $menu ) ){
			$menus = unserialize( base64_decode( $menu ) );
			
			foreach( $menus as $location => $extracted_menu ){
				wp_delete_nav_menu( $extracted_menu['name'] );
				wp_delete_nav_menu( $extracted_menu['slug'] );

				$menu_id = wp_create_nav_menu( $extracted_menu['name'], array( 'slug' => $extracted_menu['slug'] ) );
				//set the wanted theme  location
				$locations = get_theme_mod( 'nav_menu_locations' );
				$locations[$location] = $menu_id;
				set_theme_mod( 'nav_menu_locations', $locations );

				$menu_new_id = array();

				if (is_array($extracted_menu['posts'])){
					foreach ($extracted_menu['posts'] as $menu_item) {

						if ($menu_item->menu_item_parent != 0)
							$parent = $menu_new_id[$menu_item->menu_item_parent];
						else
							$parent = 0;

						$new_item = array(
							'menu-item-db-id' => 0,
							'menu-item-object-id' => $menu_item->object_id,
							'menu-item-object' => $menu_item->type_label,
							'menu-item-type' => $menu_item->type,
							'menu-item-parent-id' => $parent,
							'menu-item-position' => $menu_item->menu_order,
							'menu-item-title' => $menu_item->title,
							'menu-item-url' => $menu_item->url,
							'menu-item-description' => $menu_item->post_content,
							'menu-item-attr-title' => $menu_item->post_excerpt,
							'menu-item-status' => 'publish',
							'menu-item-target' => ''
						);

						$menu_new_id[$menu_item->ID] = wp_update_nav_menu_item($menu_id, 0, $new_item);
					}
				}
			}
			echo '<div class="result">Dummy Content Successfully Imported</div>';
		} else {
			echo '<div class="result">error: cant open dummy.php file</div>';
		}
	}
}


