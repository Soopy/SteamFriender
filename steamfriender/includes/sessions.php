<?php
session_start();
if (isset($_REQUEST['_SESSION'])) die("Haha");
if(!isset($_SESSION['steamid']) && !isset($_COOKIE['steamid'])){
	header("location:index.php");
}

if (isset($_SESSION['steamid'])){
	$steamid = $_SESSION['steamid'];
}
else if (isset($_COOKIE['steamid'])){
	$steamid = $_COOKIE['steamid'];
}
?>