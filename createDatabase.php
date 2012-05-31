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
	$password = sha1("root");
	$types = serialize(array("root"));
	
	/*
	 * Permissions for the root user type
	 */
	$rootPermissions = serialize(array("*"));
	/*
	 * Create the tables, and insert the first items
	 */
	$command = <<<EOD
CREATE TABLE users (id INTEGER PRIMARY KEY, username, password, displayname, types, profilePicture, firstName, lastName);
CREATE TABLE account_types (id INTEGER PRIMARY KEY, name, permissions);
INSERT INTO users (username, password, types, displayname) VALUES ('$user', '$password', '$types', 'Administrator');
INSERT INTO account_types (name, permissions) VALUES ('root', '$rootPermissions');
CREATE TABLE events (id INTEGER PRIMARY KEY, name, dateStart, dateEnd, allowedAccountTypes, password, people, thumbnailImage, location, tags, days);
CREATE TABLE days (id INTEGER PRIMARY KEY, name, date, people, thumbnailShot, thubnailURL, shots, location, tags);
CREATE TABLE shots (id INTEGER PRIMARY KEY, shortDescription, longDescription, thumbnailPhoto, thumbnailURL, people, photos, day, location, tags);
CREATE TABLE photos (id INTEGER PRIMARY KEY, fullsizedURL, smallURL, thumbnailURL, shortDescription, longDescription, user, shot, location, tags, people);
CREATE TABLE comments (id INTEGER PRIMARY KEY, itemType, commentTitle, commentBody, commentAuthor);
EOD;
	sqlite_exec($db, $command, $error);
	if($error) {
		echo "Error creating database contents: $error";
	}