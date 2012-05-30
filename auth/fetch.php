<?php
	/*
	 * Fetch authentication information about the user
	 */
	
	if(isset($_SESSION["auth"])) {
		$username = sqlite_escape_string($_SESSION["username"]);
		if(!sqlite_open($dbLocation, 0666, $dbError)) {
			die("Error with the database: ".$dbError);
		}
		$query = sqlite_query("SELECT * FROM users WHERE username = '$username' LIMIT 2");
		$user = sqlite_fetch_array($query);
		if(!$user) {
			die("User not found");
		}
		if(sqlite_fetch_array($query)) {
			die("Multiple users with the same username.");
		}
	}
	else {
		$user = false;
	}