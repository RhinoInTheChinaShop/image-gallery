<?php
	/*
	 * The browser is split into different files (such as album.php, day.php, etc.),
	 * but the index.php acts as a junction between all the files; the intent is that
	 * a mod_rewrite or something similar will make urls prettier.
	 * 
	 * By default, the gallery takes arguements as albums/[?event=<id>[&day=<id|all>[&set=<id|all>[&shot=<id|all>]]]]
	 * Alternatively, we suggest using mod_rewrite parsing albums/[<event id>/[<day id|all>/[<set id|all>/[<shot id|all>/]]]]
	 * Examples that are easier to read (with values specified for all arguments):
	 * 	albums/?event=5&day=2&set=all&shot=10
	 * 	albums/5/2/all/10
	 * Other methods might include using the argument names in urls, like
	 * 	albums/events/5/days/2/sets/all/shots/5
	 * 	albums/event=5/day=2/set=all/shot=5
	 */

	include("../settings.php");
	include("../auth/fetch.php");
	include("../page.php");
	
	/*
	 * To make it easier to use URL rewriting, the create_url function can be modified or replaced to
	 * change the url format.
	 */
	function create_url($event = null, $day = null, $set = null, $shot = null) {
		$event = $event ? "?event=$event" : null;
		$day = $day ? "&day=$day" : null;
		$set = $set ? "&set=$set" : null;
		$shot = $shot ? "&shot=$shot" : null;
		return "$event$day$set$shot";
	}
	
	/*
	 * Similar in purpose to the above function, the fetch_argument function allows alternative methods
	 * to fetching arguments; the function is open for modification to suit location needs.
	 */
	function fetch_argument($argumentName) {
		return isset($_GET[$argumentName]) ? sqlite_escape_string($_GET[$argumentName]) : null;
	}
	
	$shot = fetch_argument("shot");
	$set = fetch_argument("set");
	$day = fetch_argument("day");
	$event = fetch_argument("event");
	
	if($shot) {
		include("shot.php");
	}
	else if($set) {
		include("set.php");
	}
	else if($day) {
		include("day.php");
	}
	else if($event) {
		include("event.php");
	}
	else {
		header("Location: $rootLocation?action=noevent");
	}