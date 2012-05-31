<?php
	/*
	 * Fetch authentication information about the user
	 */
	
	if(isset($_SESSION["auth"])) {
		$username = sqlite_escape_string($_SESSION["username"]);
		if(!$db) {
			if(!$db = sqlite_open($dbLocation, 0666, $dbError)) {
				die("Error with the database: ".$dbError);
			}
		}
		$query = sqlite_query($db, "SELECT * FROM users WHERE username = '$username' LIMIT 2");
		$user = sqlite_fetch_array($query);
		if(!$user) {
			die("User not found");
		}
		if(sqlite_fetch_array($query)) {
			die("Multiple users with the same username.");
		}
		$accountPermissions = array();
		foreach(unserialize($user["types"]) as $type) {
			$query = sqlite_query($db, "SELECT * FROM account_types WHERE type = '$type' LIMIT 2");
			$accountPerms = sqlite_fetch_array($query);
			$permissions = unserialize($accountPerms["permissions"]);
			array_merge($accountPermissions, $permissions);
		}
	}
	else {
		$user = false;
	}