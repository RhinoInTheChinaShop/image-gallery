<?php
	/*
	 * Logout currently logged in user, and redirect to the homepage.
	 */
	session_start();
	include("../settings.php");
	session_destroy();
	header("Location: {$rootLocation}?action=logoutSuccess");
	exit;