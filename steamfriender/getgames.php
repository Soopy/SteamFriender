<?php
$row = sql("SELECT appID FROM games WHERE appID=$games[$i]");
if ($row[0] == 0 && $games[$i] == true){ //no game was found in the database
		usleep(10000);
		$isCoop = 0;
		$isMultiplayer = 0;
		$isLocalCoop = 0;
		@$game = file_get_contents($row->storeLink[0]);
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
	}*