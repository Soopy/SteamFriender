<html>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="utf-8">
<head>
	<link type="text/css" rel="stylesheet" href="css/main.css" />
	<link type="text/css" rel="stylesheet" href="css/jquery.qtip.css" />
	<link type="text/css" rel="javascript" href="js/blockui.css" />
	<meta name="description" content="Find friends on steam" />
	<meta name="keywords" content="steam, games, friends" /> 
	<title>Steam Friender</title>
</head>
<body>
<?php
$url = curPageURL();
//if (!(strpos('index.php',$url))){
	echo '<div id="nav_bar">';
	echo '<a align="left" href="index.php" style="position:relative;font-size:24px;font-weight:bold;margin-left:10px;top:15px;z-index:4;">Steam Friender</a>';
	if (@$steamid){
		$row = sql("SELECT avatar,personaname,profileurl,lookingtoplay FROM users WHERE steamid='$steamid'");
		if ($row['lookingtoplay'] != 0){
			$game = sql("SELECT name FROM games WHERE appID='$row[lookingtoplay]'");
			echo "<p id=lookingtoplay align=center style='position:relative;margin:auto;top:-20px;z-index:3;'>Looking to play:</br><b>[" . $game['name'] . "]</b></br><a href=# style='font-size:10px;' id='rm'>Remove</a></p>";
		}
		echo "<img id=avatar src=" . $row['avatar'] . " />";
		echo "<a id=personaname href=" . $row['profileurl'] . ">" . $row['personaname'] . "</a>";
	}
//}
?>
</div>