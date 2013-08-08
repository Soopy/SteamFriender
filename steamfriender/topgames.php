<?php
include 'includes/config.php';
include 'includes/sessions.php';
include 'includes/functions.php';
include 'includes/header.php';

$games = array();
//grab the most wanted game from users
$sql = "SELECT lookingtoplay FROM users";
$result=mysql_query($sql);
while($user=mysql_fetch_array($result)){
	$value = @$games[$user['lookingtoplay']];
	if (!($value)){
		$games[$user['lookingtoplay']] = 1;
	} else {
		$value++;
		$games[$user['lookingtoplay']] = $value;
	}
}
arsort($games);

$count = -1;
echo "<h1 align=center>Most Looked For Games</h1>";
echo "<table align=center style='position:relative;top:50px;'>";
foreach($games as $key => $value){
	if ($count == -1){
		$count++;
	}
	else if ($count == 10){
		break;
	} else {
		$arr = sql("SELECT * FROM games WHERE appID='$key'");
		echo "<tr>";
		echo "<td width=50>" . ($count + 1) . "</td>";
		echo "<td align=center><a href='game.php?appID=" . $key . "'><img src=" . $arr['logo'] . "></img></a></td>";
		echo "</tr>";
		echo "<tr></tr>";
		$count++;
	}
}
echo "</table>";

include 'includes/footer.php';
exit();