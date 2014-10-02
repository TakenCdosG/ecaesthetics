<?php
#YOUR E-MAIL
define('WP_USE_THEMES', false);
require('../../../../wp-load.php');
define('TO', get_option('admin_email'));
header('Content-Type: text/html; charset=utf-8');
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
##E-MAIL SUBJECT
define('SUBJECT', 'Contact Form!');
function sendEmail($to, $from, $subj, $body)
{
	$date = date( 'r' );
	$phpversion = phpversion();
	$boundary = md5( time() );
	$headers = "From: $from\n"."Date: $date\n"."Content-Type: text/html; charset=\"UTF-8\"\n";
	mail(trim($to), trim($subj), $body, $headers );
}
sendEmail(TO, trim($_POST['email']), SUBJECT, 'E-Mail from: '.$_POST['name'].'<br/>'.'Website: '.trim($_POST['site']).'<br /><br/>Message: '.nl2br($_POST['message']));
}
?>