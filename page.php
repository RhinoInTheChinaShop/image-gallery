<?php
	/*
	 * Various functions to be included for dealing with page contents
	 */
	
	function parsePageTitle($pageName) {
		$patterns[0] = "<PAGE>";
		$replacements[0] = $pageName;
		return preg_filter($patterns, $replacements, $pageTitleTemplate);
	}