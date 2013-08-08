<?php
require 'openid.php';
include 'includes/config.php';
include 'includes/functions.php';
include 'includes/header.php';

$steamkey = '2784DFBCF69A5FC167FE5FCC4EDC13B5';
$steam_user_url = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=2784DFBCF69A5FC167FE5FCC4EDC13B5&steamids=';
$openid = new LightOpenID($site);
$expire = time()+(60*60*24*365);

if ((@$_GET['id']) && (!(@$_SESSION['steamid'])) && (!(@$_COOKIE['steamid']))){ //user just logged in
	//user is validated by steam. set the cookies and information
	$url = $steam_user_url . $_GET['id'];
	$data = file_get_contents($url);
	$data = json_decode($data);
	$expire=time()+(60*60*24*365);
	session_start();
	$_SESSION['steamid'] = $data->response->players[0]->steamid;
	setcookie('steamid', $data->response->players[0]->steamid, $expire, '/', $steam, false, true);
	
	$steamid= $personaname= $profileurl= $avatar= $avatarmedium= $avatarfull= $personastate= $communityvisibilitystate= $profilestate= $lastlogoff= $commentpermission= $realname= $primaryclanid= $timecreated= $gameid= $gameserverip= $gameextrainfo= $loccountrycode= $locstatecode= $loccityid = "null";

	foreach($data->response->players[0] as $i => $row){
		$$i = $row;
	}

	$row = sql("SELECT steamid,answered FROM users WHERE steamid='$steamid'");
	if ($row[0] > 0){ //they are already a member, update instead of insert
		mysql_query("UPDATE users SET
		personaname='$personaname', 
		profileurl='$profileurl', 
		avatar='$avatar', 
		avatarmedium='$avatarmedium', 
		avatarfull='$avatarfull',
		personastate='$personastate', 
		communityvisibilitystate='$communityvisibilitystate', 
		profilestate='$profilestate', 
		lastlogoff='$lastlogoff',
		commentpermission='$commentpermission',
		realname='$realname',
		primaryclanid='$primaryclanid',
		timecreated='$timecreated',
		gameid='$gameid',
		gameserverip='$gameserverip',
		gameextrainfo='$gameextrainfo',
		loccountrycode='$loccountrycode',
		locstatecode='$locstatecode',
		loccityid='$loccityid' WHERE steamid='$steamid'") or die("Failed!"); 
	} else {
		mysql_query("INSERT INTO users(
		steamid, 
		personaname, 
		profileurl, 
		avatar, 
		avatarmedium, 
		avatarfull,
		personastate, 
		communityvisibilitystate, 
		profilestate, 
		lastlogoff,
		commentpermission,
		realname,
		primaryclanid,
		timecreated,
		gameid,
		gameserverip,
		gameextrainfo,
		loccountrycode,
		locstatecode,
		loccityid)VALUES(
		'$steamid', 
		'$personaname', 
		'$profileurl', 
		'$avatar', 
		'$avatarmedium', 
		'$avatarfull', 
		'$personastate', 
		'$communityvisibilitystate', 
		'$profilestate', 
		'$lastlogoff',
		'$commentpermission',
		'$realname',
		'$primaryclanid',
		'$timecreated',
		'$gameid',
		'$gameserverip',
		'$gameextrainfo',
		'$loccountrycode',
		'$locstatecode',
		'$loccityid')") or die("Failed!");
	}
	if ($answered == 1)
		header("location:gamelist.php");
	else
		header("location:questions.php");
}
else if(@$_SESSION['steamid'] || @$_COOKIE['steamid']){ //the user is logged in with steam!
	header("location:gamelist.php");
}
else if(!$openid->mode) {
	if(isset($_POST['openid_identifier'])) {
		$openid->identity = $_POST['openid_identifier'];
		# The following two lines request email, full name, and a nickname
		# from the provider. Remove them if you don't need that data.
		$openid->required = array('contact/email');
		$openid->optional = array('namePerson', 'namePerson/friendly');
		header('Location: ' . $openid->authUrl());
	}
	echo '<p align="center" href="index.php" style="position:relative;font-size:26px;font-weight:bold;margin-left:0;margin-right:0;top:80px;">Steam Friender</p>';
	echo '<form action="" id=steam_login method="post">';
	echo '<p style="position:relative;top:50px;width:600px;margin:auto;" align=center> Steam Friender shows a filtered library of your steam games by co-op, local co-op, and multiplayer. You can choose a game from your library that you want to play and it will match you up with people who play similar games as you, and is also interested in playing the game of your choice.<b><br><br>Your first login might take longer to load your game library.</b>
	</br></br>The site works by collecting user information provided by Steam using their Web API. To find more information on this, <a href="steamcommunity.com/dev/">click here</a>. To get started, click the sign in through Steam button. <br></p>';
	echo '<input type="image" src="images/steam_login.png" style="position:absolute;top:250px;margin:auto;left:280px;" align=center />';
	echo '<input type="hidden" name="openid_identifier" value="http://steamcommunity.com/openid" />';
	echo '</form>';
} else if($openid->mode == 'cancel') {
	echo 'User has canceled authentication!';
} else {
	if ($openid->validate()){
		$steamid = substr($openid->identity, -17);
		$url = "index.php?id=" . $steamid;
		header("location:" . $url);
	}
}
include 'includes/footer.php';
exit();