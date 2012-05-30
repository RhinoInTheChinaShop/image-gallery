<?php
	/*
	 * index.php
	 * Bootstraps installer if the gallery is not installed, otherwise bootstraps gallery.
	 */
	
	/*
	 * Fetch all settings
	 */
	require("settings.php");
	
	/*
	 * If the gallery is not installed, redirect user to the install directory
	 */
	if(!$installed) {
		header("Location: install/");
		exit;
	}
	
?>