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
	
	/*
	 * If you want to allow anyone to register an account, set to true
	 */
	$allowPublicRegistration = false;
	
	/*
	 * Account type name of public registrations.
	 * It is suggested to set public registrations to a guest account,
	 * so guests can't upload pictures.
	 */
	$defaultAccountType = "guest";
	
	/*
	 * The location of the default picture, if the user hasn't set one
	 */
	$defaultProfilePicture = "";
	
	/*
	 * Allows the user to change the number of events per page on the homepage
	 * (The default is below)
	 */
	$allowUserChangeEventLimit = true;
	
	/*
	 * The number of events to display per page on the homepage
	 * (can be changed by the user if $allowUserChangeEventLimit is set to true above)
	 */
	$eventLimit = 20;
?>