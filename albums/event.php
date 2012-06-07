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
	  * TODO: add die() if user is not allowed to view the event
	  */
	 
	 /*
	  * Extract extra arguments
	  */
	 $people = $_GET["people"] ? $_GET["people"] : "";
	 $location = $_GET["location"] ? "AND location = '".sqlite_escape_string($_GET["location"])."'" : null;
	 $tags = $_GET["tags"] ? $_GET["tags"] : "";
	 
	 list ($includedPeople, $excludedPeople) = parseTags($people);
	 list ($includedTags, $excludedTags) = parseTags($tags);
	 
	 /*
	  * Run query
	  */
	 $query = sqlite_regex_query($db, "SELECT * FROM days WHERE event=$event $location AND regexp(people, '$includedPeople') AND NOT regexp(people, '$excludedPeople') AND regexp(tags, '$includedTags') AND NOT regexp(tags, '$excludedTags')");
	 
	 /*
	  * TODO: Process and display days, along with an "all" option
	  */