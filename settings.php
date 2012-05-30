<?php
	/*
	 * Settings file for the image gallery
	 * Currently uses hardcoded settings,
	 * but the installer will ask the user for most of these settings later.
	 */
	
	$installed = true;
	
	/*
	 * The database location should be changed to outside the web root.
	 */
	$dbLocation = "db.sqlite";
	
	/*
	 * The homepage description is listed on the front page
	 */
	$homepageDescription = <<<EOD

EOD;
	
	/*
	 * The page title is parsed with certain replacements:
	 * <PAGE> will be replaced with the current page name
	 */
	$pageTitleTemplate = "<PAGE> | Image Gallery";
?>