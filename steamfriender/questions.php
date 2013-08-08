<?php
include 'includes/config.php';
include 'includes/sessions.php';
include 'includes/functions.php';
include 'includes/header.php';

$user = sql("SELECT answered FROM users WHERE steamid='$steamid'");
if (@$user['answered'] == 1)
	header("location:gamelist.php");
?>

<form action="questions.php" id="questions" method="post">
	<table align="center">
		<tr>
			<td>What type of gamer are you?</td>
		</tr>
		<tr>
			<td>			
			<select name="type">
				<option value='0'>I don't care</option>
				<option value='casual'>Casual</option>
				<option value='hardcore'>Hardcore</option>
				<option value='competitive'>Competitive</option>
			</select>
		</tr>
		<tr>
			<td><br>How many hours, on average, do you play games per week?</td>
		</tr>
		<tr>
			<td>			
			<select name="hours">
				<option value='0'>I don't care</option>
				<option value='1'>Less than 1</option>
				<option value='2'>1-5</option>
				<option value='3'>5-10</option>
				<option value='4'>10-20</option>
				<option value='5'>20-40</option>
				<option value='6'>More than 40</option>
			</select>
			</td>
		</tr>
		<tr>
			<td><br>What age group do you fit into?</td>
		</tr>
		<tr>
			<td>			
			<select name="age">
				<option value='0'>I don't care</option>
				<option value='1'>Less than 17</option>
				<option value='2'>18-24</option>
				<option value='3'>25-30</option>
				<option value='4'>30-40</option>
				<option value='5'>40-50</option>
				<option value='6'>50-60</option>
				<option value='7'>Greater than 60</option>
			</select>
			</td>
		</tr>
		<tr>
			<td><br>What genre of games do you enjoy playing?</td>
		</tr>
		<tr>
			<td>
				<input type="checkbox" name="genre[]" value="F2P"> Free to Play<br>
				<input type="checkbox" name="genre[]" value="Action"> Action<br>
				<input type="checkbox" name="genre[]" value="Adventure"> Adventure<br>
				<input type="checkbox" name="genre[]" value="Platformer"> Platformer<br>
				<input type="checkbox" name="genre[]" value="Strategy"> Strategy<br>
				<input type="checkbox" name="genre[]" value="RPG"> RPG<br>
				<input type="checkbox" name="genre[]" value="Indie"> Indie<br>
				<input type="checkbox" name="genre[]" value="MMO"> Massively Multiplayer<br>
				<input type="checkbox" name="genre[]" value="Casual"> Casual<br>
				<input type="checkbox" name="genre[]" value="Simulation"> Simulation<br>
				<input type="checkbox" name="genre[]" value="Racing"> Racing<br>
				<input type="checkbox" name="genre[]" value="Sports"> Sports<br>
			</td>
		</tr>
		<tr>
			<td><br>Does the location of people you play with matter?</td>
		</tr>
		<tr>
			<td>
				<select name="location">
					<option value='0'>No</option>
					<option value='1'>Yes</option>
			</select>
			</td>
		</tr>
		<tr>
			<td><br><input type="submit" name="submit" value="Submit" /></td>
		</tr>
	</table>
</form>

<?php

if (@$_POST['submit']){
	$type = $_POST['type'];
	$hours = $_POST['hours'];
	$age = $_POST['age'];
	$location = $_POST['location'];
	$genre = array();
	if(!empty($_POST['genre'])) {
		foreach($_POST['genre'] as $i) {
            array_push($genre,$i);
		}
	} else {
		$genre[0] = '0';
	}
	$genre = json_encode($genre);
	mysql_query("UPDATE users SET answered='1', type='$type', hours='$hours', age='$age', genre='$genre', location='$location' WHERE steamid='$steamid'") or die();
	header("location:gamelist.php");
}


include 'includes/footer.php';
exit();