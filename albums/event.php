<?php
	/*
	 * Event page display
	 * Included by index.php when the contents of an event need to be displayed.
	 * settings.php, auth/fetch.php, page.php are all included
	 * $event and create_url() have been defined
	 * The database might be open
	 */

	/*
	 * Open database if connection does not exist
	 */
	 if(!$db) {
	 	if(!$db = sqlite_open($databaseLocation, 0666, $dbError)) {
	 		die("Error opening database: $dbError");
	 	}
	 }
	 
	 /*
	  * Extract extra arguments
	  */
	 $people = $_GET["people"] ? peopleRegexGenerator("none", $_GET["people"]) : peopleRegexGenerator("all");
	 $location = $_GET["location"] ? "AND location = '".sqlite_escape_string($_GET["location"])."'" : null;
	 $tags = $_GET["tags"] ? tagsRegexGenerator("none", $_GET["tags"]) : tagsRegexGenerator("all");
	 
	 /*
	  * Run query
	  * TODO: create regexp's in page.php for peopleRegexGenerator and tagsRegexGenerator above
	  * TODO: add the permission regexp to the query
	  */
	 $query = sqlite_query($db, "SELECT * FROM days WHERE event=$event $location AND regexp(people, '$people') AND regexp(tags, '$tags')");
	 
	 /*
	  * TODO: Process and display days, along with an "all" option
	  */