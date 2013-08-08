<?php
include 'includes/config.php';
include 'includes/sessions.php';
include 'includes/functions.php';
include 'includes/header.php';
include('simple_html_dom.php');

//get list of their games
$user = sql("SELECT profileurl,uid,games FROM users WHERE steamid='$steamid'");
//if ($user['games'] == 0){ //no games are set, first time
$url = $user['profileurl'] . "games?tab=all&xml=1";
//if (!($xml = simplexml_load_file($url))){
		//echo "</br></br><p align='center'>Couldn't grab your games. Try reloading.</p>";
	//}	
//}

@$xml = simplexml_load_file($url);
echo '<div id=game_list_btn>All Games</div>';
echo '<div id=coop_list_btn>Co-op Games</div>';
echo '<div id=local_coop_list_btn>Local Co-op Games</div>';
echo '<div id=multiplayer_list_btn>Multiplayer Games</div>';

$num_games = 1;
echo "<div align=center style='position:absolute;width:500px;top:70px;font-size:16px;margin:auto;left:0;right:0;'><a href=search.php>Find someone regardless of game</a> | <a href=topgames.php>Most looked for games</a></div>";
echo "<table id=game_list width=800 cellspacing=5>";
echo "<tr>";

$games = array();
if (!($xml)){
	header("location:gamelist.php");
}

foreach (@$xml->games->game as $i => $row){ //list all games
	array_push($games,$row->appID[0]);
	if ($num_games % 5 == 1){
		echo "</tr>";
		echo "<tr>";
	}
	echo "<td width=184 height=69><a href='game.php?appID=" . $row->appID[0] . "'><img width=184 height=69 class='game_img' src=" . $row->logo[0] . " title='" . $row->name[0] . "'></img></a></td>";
	$i = $num_games - 1;
	$num_games++;
	$row2 = sql("SELECT appID FROM games WHERE appID=$games[$i]");
	if ($row2[0] == 0 && $games[$i] == true){ //no game was found in the database
		$isCoop = 0;
		$isMultiplayer = 0;
		$isLocalCoop = 0;
		//@$game = file_get_contents($row->storeLink[0]);
		
		// initialize a new curl resource
	    $ch = curl_init(); 

	    // set the url to fetch
	    curl_setopt($ch, CURLOPT_URL, $row->storeLink[0]); 

	    // don't give me the headers just the content
	    curl_setopt($ch, CURLOPT_HEADER, 0); 

	    // return the value instead of printing the response to browser
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

	    // use a user agent to mimic a browser
	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0'); 

	    $game = curl_exec($ch);
		curl_close($ch);

		//<img class="game_header_image" src="http://cdn.steampowered.com/v/gfx/apps/70/header_292x136.jpg?t=1270602383">

		//$game = file_get_html($row->storeLink[0]);
			
		if (strpos($game, '<div class="name">Co-op</div>'))
			$isCoop = 1;
		if (strpos($game, '<div class="name">Multi-player</div>'))
			$isMultiplayer = 1;
		if (strpos($game, '<div class="name">Local Co-op</div>'))
			$isLocalCoop = 1;



		$name = str_replace("'", "", $row->name); 
		mysql_query("INSERT INTO games(
		name, 
		appID, 
		logo, 
		storeLink,
		IsCoop,
		IsMultiplayer,
		isLocalCoop)VALUES(
		'$name', 
		'$row->appID', 
		'$row->logo', 
		'$row->storeLink', 
		'$isCoop', 
		'$isMultiplayer',
		'$isLocalCoop')") or die("Failed!");
	}
}
$games = json_encode($games);
mysql_query("UPDATE users SET games='$games' WHERE steamid='$steamid'") or die(); 
echo "</tr>";
echo "</table>";

echo "<table id=coop_list width=800 cellspacing=5>";
echo "<tr>";
$num_games = 1;
foreach ($xml->games->game as $i => $row){ //list all coop games
	$game = sql("SELECT logo,name,appID,isCoop FROM games WHERE appID='$row->appID'");
	if ($game['isCoop'] == 1){
		if ($num_games % 5 == 1){
			echo "</tr>";
			echo "<tr>";
		}
		echo "<td width=184 height=69><a href='game.php?appID=" . $game['appID'] . "'><img id=" . $game['appID'] . " width=184 height=69 class='game_img' src=" . $game['logo'] . " title='" . $game['name'] . "' ></img></a></td>";
		$num_games++;
	}
}
echo "</tr>";
echo "</table>";

echo "<table id=local_coop_list width=800 cellspacing=5>";
echo "<tr>";
$num_games = 1;
foreach ($xml->games->game as $i => $row){ //list all coop games
	$game = sql("SELECT logo,name,appID,isLocalCoop FROM games WHERE appID='$row->appID'");
	if ($game['isLocalCoop'] == 1){
		if ($num_games % 5 == 1){
			echo "</tr>";
			echo "<tr>";
		}
		echo "<td width=184 height=69><a href='game.php?appID=" . $game['appID'] . "'><img id=" . $game['appID'] . " width=184 height=69 class='game_img' src=" . $game['logo'] . " title='" . $game['name'] . "' /></a></td>";
		$num_games++;
	}
}
echo "</tr>";
echo "</table>";

echo "<table id=multiplayer_list width=800 cellspacing=5>";
echo "<tr>";
$num_games = 1;
foreach ($xml->games->game as $i => $row){ //list all coop games
	$game = sql("SELECT logo,name,appID,isMultiplayer FROM games WHERE appID='$row->appID'");
	if ($game['isMultiplayer'] == 1){
		if ($num_games % 5 == 1){
			echo "</tr>";
			echo "<tr>";
		}
		echo "<td width=184 height=69><a href='game.php?appID=" . $game['appID'] . "'><img id=" . $game['appID'] . " width=184 height=69 class='game_img' src=" . $game['logo'] . " title='" . $game['name'] . "' /></a></td>";
		$num_games++;
	}
}
echo "</tr>";
echo "</table>";

include 'includes/footer.php';
echo '<script type="text/javascript" src="js/gamelist.js"></script>';
exit();