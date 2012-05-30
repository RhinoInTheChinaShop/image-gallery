<?php
	require("settings.php");
	/*
	 * Create database if it does not exist
	 */
	if(file_exists($databaseLocation)) {
		die("Database already exists.");
	}
	if(!$db = sqlite_open($databaseLocation, 0666, $dbError)) {
		die("Error creating database: $dbError");
	}
	
	/*
	 * Basic settings for the root user account
	 */
	$user = "root";
	$password = "root";
	$types = serialize(array("root"));
	
	/*
	 * Permissions for the root user type
	 */
	$rootPermissions = serialize(array("*"));
	/*
	 * Create the tables, and insert the first items
	 */
	$command = <<<EOD
CREATE TABLE users (id INTEGER PRIMARY KEY, username, password, types);
CREATE TABLE account_types (id INTEGER PRIMARY KEY, name, permissions);
INSERT INTO users (username, password, types) VALUES ('$user', '$password', '$types');
INSERT INTO account_types (name, permissions) VALUES ('root', '$rootPermissions');
EOD;
	sqlite_exec($db, $command, $error);
	if($error) {
		echo "Error creating database contents: $error";
	}