<?php
include_once 'includes/config.php';
include_once 'includes/sessions.php';
include_once 'includes/functions.php';
include_once 'includes/header.php';

$appID = 0;
if (@$_GET['appID']){
	$appID = @$_GET['appID'];
	mysql_query("UPDATE users SET lookingtoplay='$appID' WHERE steamid='$steamid'") or die();
	$game = sql("SELECT name FROM games WHERE appID='$appID'");
	//echo "<h1 align=center>Matches</h1><br><p style='margin-top:-35px;' align=center>[" . $game['name'] . "]</p>";
} else {
	echo "<h1 align=center>Matches</h1>";
}

$friends = array();
$friendp = array();
$bar_width = 20;
$bar_color = "red";
$bar_title = "Poor Match";
$user = sql("SELECT * FROM users WHERE steamid='$steamid'");

$friends = getFriend($user, $friendp);


$count = 0;
echo "<table align=center id=matches>";
/*echo "<td width=50></td>";
echo "<td><b><u>Username</u></b></td>";
echo "<td width=50></td>";
echo "<td><b><u>Match Bar</u></b></td>";
echo "</tr><tr>";*/

//aasort($your_array,"relevance");
foreach ($friends as $key => $value){
	echo "<tr>";
	echo "<td width=50>" . ($count + 1) . "</td>";
	echo "<td align=center><a href=" . $friends[$count]['profileurl'] . "></br><img align=center src='" . $friends[$count]['avatar'] . "'/></a></td>";
	echo "<td width=25></td>";
	echo "<td><a href=" . $friends[$count]['profileurl'] . ">" .  $friends[$count]["personaname"] . "</a></td>";
	echo "<td width=25></td>";
	echo "<td><div id=relevance>";
	if ($friends[$count]['relevance'] == 2){
		$bar_width = 40;
		$bar_color = "yellow";
		$bar_title = "Fair Match";
	}
	else if($friends[$count]['relevance'] == 3){
		$bar_width = 60;
		$bar_color = "yellow";
		$bar_title = "Good Match";
	}
	else if($friends[$count]['relevance'] == 4){
		$bar_width = 80;
		$bar_color = "green";
		$bar_title = "Great Match";
	}
	else if($friends[$count]['relevance'] == 5){
		$bar_width = 100;
		$bar_color = "green";
		$bar_title = "Excellent Match";
	}
	echo "<div id=relevance_bar title='" . $bar_title . "' style='width:" . $bar_width . "px; background-color:" . $bar_color . ";'></div>";
	echo "</div></td>";
	$count++;
	echo "</tr>";
}
echo "</table>";

function getFriend($user, $friendp){
	if ((!(@$_GET['appID'])) && $user['location'] == 0)
		$sql="SELECT * FROM users WHERE uid!='$user[uid]'";
	else if ((!(@$_GET['appID'])) && $user['location'] == 1)
		$sql="SELECT * FROM users WHERE location='$user[location]' && uid!='$user[uid]'";
	else if ($user['location'] == 1)
		$sql="SELECT * FROM users WHERE lookingtoplay='$user[lookingtoplay]' && location='$user[location]' && uid!='$user[uid]'";
	else
		$sql="SELECT * FROM users WHERE lookingtoplay='$user[lookingtoplay]' && uid!='$user[uid]'";

	$result=mysql_query($sql);
	$num_rows = mysql_num_rows($result);
	if ($num_rows == 0){
		echo "<br><br><br><h2 align=center>Couldn't find anyone for this game. <br>You can wait for someone to find you or try again later.</h2>";
		exit();
	}
	$relevance = 0;
	$count = 0;

	while($friend=mysql_fetch_array($result)){
		$relevance = 1;
		if ($user['age'] == $friend['age'])
			$relevance++;
		if ($user['hours'] == $friend['hours'])
			$relevance++;
		if ($user['type'] == $friend['type'])
			$relevance++;

		$user_genre = json_decode($user['genre']);
		$friend_genre = json_decode($friend['genre']);
		if ($friend_genre != 0){
			$genre_relevance = 0;
			foreach($user_genre as $ugenre){
				foreach($friend_genre as $fgenre){
					if ($ugenre == $fgenre)
						$genre_relevance++;
				}
			}
		}
		if ($genre_relevance >= (count($user_genre) - 1))
			$relevance++;

		$friendp[$count] = array('steamid' => $friend['steamid'], "relevance" => $relevance, "personaname" => $friend['personaname'], "avatar" => $friend['avatarmedium'], "profileurl" => $friend['profileurl']);
		$count++;
	}
	return $friendp;
}


include 'includes/footer.php';
exit();