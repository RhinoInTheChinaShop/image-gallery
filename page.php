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