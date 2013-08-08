<?php
include 'includes/config.php';
include 'includes/sessions.php';
include 'includes/functions.php';

if (@$_POST['remove'] == "yes"){
	mysql_query("UPDATE users SET lookingtoplay=0 WHERE steamid='$steamid'") or die();
}

include 'includes/footer.php';
exit();