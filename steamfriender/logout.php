<?php
session_start();
$steamid = $_SESSION['steamid'];
setcookie('steamid', $steamid, time()-(60*60*24*365),'/', 'deadwar.comze.com', false, true);
unset($_COOKIE['steamid']);
session_destroy();
header("location:index.php");
?>