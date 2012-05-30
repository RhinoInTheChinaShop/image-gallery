<?php
	require("../settings.php");
	session_start();
	session_regenerate_id();
	$username = sqlite_escape_string($_POST["username"]);
	$password = sha1(sqlite_escape_string($_POST["password"]));
	if(!sqlite_open($dbLocation, 0666, $dbError)) {
		die("Error with the database: ".$dbError);
	}
	$query = sqlite_query("SELECT * FROM users WHERE username = '$username' LIMIT 2");
	$user = sqlite_fetch_array($query);
	if(!$user || $user["password"] != $password) {
		die("User not found");
	}
	if(sqlite_fetch_array($query)) {
		die("Multiple users exist with the same username.");
	}
	header("Location: $rootLocation?action=loginSuccess");
	exit;