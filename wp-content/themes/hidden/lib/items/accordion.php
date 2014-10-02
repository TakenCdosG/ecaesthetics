<?php
if(!defined('WP_USE_THEMES')){
    define('WP_USE_THEMES', false);
    require_once('../../../../../wp-load.php');
    if (!current_user_can('edit_pages') && !current_user_can('edit_posts')){
	wp_die(__("You are not allowed to be here", 'afl'));
    }
}
?>
<?php if(!isset($_GET['col_id'])): ?>
<?php $count = count($data[$type]); ?>
<script type="text/javascript">
    var aflLastSlideId = <?php print $count==0?1:$count; ?>;

    function onChangeContentType(s){
        if(jQuery('#afl-content-types').val()==''){
            jQuery('#afl-edit-composer-item-slides ul.ui-tabs-nav li').show();
			jQuery('#afl-edit-composer-item-slides ul.ui-tabs-nav a.afl-add-slide').show();
			jQuery('#afl-edit-composer-item-slides').removeClass('no-tabs');
        }
        else{
			jQuery('#afl-edit-composer-item-slides ul.ui-tabs-nav li').hide();
			jQuery('#afl-edit-composer-item-slides ul.ui-tabs-nav a.afl-add-slide').hide();
			jQuery('#afl-edit-composer-item-slides ul.ui-tabs-nav li.settings').show();
			jQuery('#afl-edit-composer-item-slides').addClass('no-tabs');
        }
    }
</script>

<div id="afl-edit-composer-item-slides" class="slider text-slider items<?php print (!empty($data['content_types'])?' no-tabs':'')?>">
	<ul>
        
    	<?php if($count == 0): ?>
    		<li><a href="#afl-edit-item-tabs-content0"><span>Slide</span></a></li>
         <?php else: for($i = 0; $i < $count; $i++): ?>
        	<li><a href="#afl-edit-item-tabs-content<?php print $i; ?>"><span>Slide</span></a></li>
        <?php endfor;
		 endif; ?>
        <a href="#" class="afl-add-slide"><span><?php print __('Add slide','afl'); ?></span></a>
        <li class="settings"><a href="#afl-edit-item-tabs-content999"><span>Settings</span></a></li>
    </ul>
    <div>
    <?php if($count == 0):
			__afl_composer_edit_text_slider_item( 0, $type, $data );
          else: for($i = 0; $i < $count; $i++):
                __afl_composer_edit_text_slider_item( $i, $type, $data );
        endfor;?>
    <?php endif; ?>
    	<div id="afl-edit-item-tabs-dummy"></div>
    </div>
    <div class="add-del-butts">
        <span><a href="#" class="button afl-delete-slide<?php print $count>1?'':' button-disabled'; ?>"><?php print __('Delete slide','afl'); ?></a></span>
    </div>
</div>
<?php elseif($col_id = intval($_GET['col_id'])): ?>
    <?php __afl_composer_edit_text_slider_item( $col_id, 'text_slider', null ); ?>
<?php endif; ?>