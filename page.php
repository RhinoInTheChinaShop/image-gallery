<?php
	/*
	 * Various functions to be included for dealing with page contents
	 */
	
	function parsePageTitle($pageName) {
		$patterns[0] = "<PAGE>";
		$replacements[0] = $pageName;
		return preg_filter($patterns, $replacements, $pageTitleTemplate);
	}
	
	function sqlite_regex_query($database, $query, $error = null, $method = null) {
		function my_sqlite_regexp($x,$y){
			return (int)preg_match("`$y`i",$x);
		}
		sqlite_create_function($db, 'regexp', 'my_sqlite_regexp',2);
		return sqlite_query($database, $query, $method, $error);
	}
	
	/*
	 * turns an array of roles into a regex for any of the roles or public, made for users who are logged in.
	*/
	function rolesRegexGenerator($rs) {
		$out = "";
		foreach($rs as $r) {
			$out .= ".*$r.*||";
		}
		return $out."public";
	}
	
	/*
	 * Returns the included ($iTags) and excluded ($eTags) tags as a regex for the input array.
	 * Can be used for tags and people
	 */
	function parseTags($tags) {
		foreach(explode(",", $tags) as $tag) {
			if($tag[0] != "-") {
				if(!$iTags) {
					$iTags = "/$tag";
				}
				else {
					$iTags = "|$tag";
				}
			}
			else {
				if(!$eTags) {
					$iTags = "/$tag";
				}
				else {
					$eTags = "|$tag";
				}
			}
		}
		if($iTags) {
			$iTags = "/";
		}
		else {
			$iTags = ".*";
		}
		if($eTags) {
			$eTags = "/";
		}
		else {
			$eTags = ".*";
		}
		return array(sqlite_escape_string($iTags), sqlite_escape_string($eTags));
	}