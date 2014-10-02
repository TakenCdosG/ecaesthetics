<?php 

$paths = array(
    "../../..",
    "../../../..",
    "../../../../..",
    "../../../../../..",
    "../../../../../../..",
    "../../../../../../../..",
    "../../../../../../../../..",
    "../../../../../../../../../..",
    "../../../../../../../../../../..",
    "../../../../../../../../../../../..",
    "../../../../../../../../../../../../.."
);


#include wordpress, make sure its available in one of the higher folders
foreach ($paths as $path) 
{
   if(@include_once($path.'/wp-load.php')) break;
}

$bootstrap = get_template_directory_uri().'/css/bootstrap.min.css';
$mainstyle = get_template_directory_uri().'/css/style.css';
$shortcodes = get_template_directory_uri().'/css/shortcodes.css';
$fontawesome = get_template_directory_uri().'/css/font-awesome.min.css';
?>

<html>

<head>


<script type="text/javascript" src="<?php echo TEMPLATEURL.'/js/jquery.min.js' ?>" ></script>
<script type="text/javascript" src="<?php echo TEMPLATEURL.'/js/bootstrap.min.js' ?>" ></script>

<link rel="stylesheet" href="<?php echo $bootstrap; ?>">
<link rel="stylesheet" href="<?php echo $mainstyle; ?>">
<link rel="stylesheet" href="<?php echo $shortcodes; ?>">
<link rel="stylesheet" href="<?php echo $fontawesome; ?>">

</head>
<body class='shortcode_prev'>
<div class="tooltip-fix">
<?php

$shortcode = isset($_REQUEST['shortcode']) ? $_REQUEST['shortcode'] : '';

// WordPress automatically adds slashes to quotes
// http://stackoverflow.com/questions/3812128/although-magic-quotes-are-turned-off-still-escaped-strings
$shortcode = stripslashes($shortcode);

echo do_shortcode($shortcode);

?>
</div>
<script type="text/javascript">

    jQuery('#scn-preview h3:first', window.parent.document).removeClass('scn-loading');
    jQuery(document).ready(function(){
		if (jQuery("[rel=tooltip]").length) {
			jQuery("[rel=tooltip]").tooltip();
		} else {
            jQuery("div.tooltip-fix").removeClass("tooltip-fix");
		}
	});
</script>
</body>
</html>
