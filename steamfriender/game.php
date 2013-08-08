<?php
include 'includes/config.php';
include 'includes/sessions.php';
include 'includes/functions.php';
include 'includes/header.php';

if (!(@$_GET['appID']))
	header("location:gamelist.php");
else
	$game = sql("SELECT * FROM games WHERE appID='$_GET[appID]'");

$game_background = 'http://cdn.steampowered.com/v/gfx/apps/' . $game['appID'] . '/page_bg_generated.jpg';
$game_image = 'http://cdn.steampowered.com/v/gfx/apps/' . $game['appID'] . '/header_292x136.jpg';

echo '<div id="game_background" style="background-image: url(' . $game_background . '); "/>';
echo "<div id='view_game'>";
echo "<h1 id=game_txt style='position:absolute;top:-50px;' align='center'>" . $game['name'] . "</h1>";
echo "<img id='view_game_logo' align='center' src=" . $game_image . " />";
echo "<a id=playnow href='steam://run/" . $game['appID'] . "'>Play Now</a>";
echo "<div id=type_group>";
echo "<p class=type align='center'>Multiplayer "; if ($game['isMultiplayer']){ echo "<img class=yes src=images/yes.png />"; } else { echo "<img class=no src=images/no.png />"; }" />";
echo "<p class=type align='center'>Co-op "; if ($game['isCoop']){ echo "<img class=yes src=images/yes.png />"; } else { echo "<img class=no src=images/no.png />"; }" />";
echo "<p class=type align='center'>Local Co-op "; if ($game['isLocalCoop']){ echo "<img class=yes src=images/yes.png />"; } else { echo "<img class=no src=images/no.png />"; }" />";
echo "</div>";
//echo "<a href='search.php?appID=" . $game['appID'] . "'><img id='friend_image' src='images/friend.png' title='Find someone to play with!'></img></br></a>";
echo "</div>";
echo "<div id=search_result align=center>";
include_once 'search.php';
echo "</div>";

include 'includes/footer.php';
exit();