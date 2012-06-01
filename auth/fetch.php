<?php
	/*
	 * Fetch authentication information about the user
	 */
	
	/*
	 * If the session states the user is logged in, the user's information is fetched from the database.
	 * Otherwise, $user is set to false.
	 */
	if(isset($_SESSION["auth"])) {
		$username = sqlite_escape_string($_SESSION["username"]);
		/*
		 * Opens database if it is not already open
		 */
		if(!$db) {
			if(!$db = sqlite_open($dbLocation, 0666, $dbError)) {
				die("Error with the database: ".$dbError);
			}
		}
		/*
		 * Grab user information from the database, and checks if multiple users have the same name.
		 */
		$query = sqlite_query($db, "SELECT * FROM users WHERE username = '$username' LIMIT 2");
		$user = sqlite_fetch_array($query);
		if(!$user) {
			die("User not found");
		}
		if(sqlite_fetch_array($query)) {
			die("Multiple users with the same username.");
		}
		/*
		 * Creates an array of the user's permissions, fetching the permissions for each account type the user belongs to.
		*/
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