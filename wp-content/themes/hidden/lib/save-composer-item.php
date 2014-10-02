<?php
    define('WP_USE_THEMES', false);
    require('../../../../wp-load.php');
    if (!current_user_can('edit_pages') && !current_user_can('edit_posts')){
	wp_die(__("You are not allowed to be here", 'afl'));
    }
    /*foreach ($_POST as $k => $v){

    }*/
    $index = $_POST['index'];
	$type = $_POST['type'];
    unset($_POST['index']);unset($_POST['type']);
    $_POST = stripslashes_deep($_POST);
	$images = array();
	if(isset($_POST["{$type}_images"])){
		foreach($_POST["{$type}_images"] as $image){
			if( !empty($image['url']) ){
				$images[] = array('title' => $image['title'], 'text' => $image['text'], 'url' => $image['url']);
			}
		}
		$_POST["{$type}_images"] = $images;
	}
	elseif(isset($_POST[$type])){
        $_POST[$type] = array_values($_POST[$type]);
    }
    print json_encode(array('index' => $index, 'data' => base64_encode(serialize($_POST))));
?>
