<?php
	/*
	 * Settings file for the image gallery
	 * Currently uses hardcoded settings,
	 * but the installer will ask the user for most of these settings later.
	 */
	
	$installed = true;
	
	/*
	 * The root location should be set to the path to the gallery directory, from the web.
	 * If it is the root folder, the root location should just be /,
	 * otherwise if the web path is something like /gallery/, the root location should be /gallery/.
	 */
	$rootLocation = "/";
	
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