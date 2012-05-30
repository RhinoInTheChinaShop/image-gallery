<?php
	/*
	 * index.php
	 * Bootstraps installer if the gallery is not installed, otherwise displays the homepage of the gallery.
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
	
	require("auth/fetch.php");
	require("page.php");
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo parsePageTitle("Home"); ?></title>
		<link rel="stylesheet" type="text/css" href="resources/page.css" />
		<script type="text/javascript" src="resources/home.js"></script>
	</head>
	<body>
		<h1>Image Gallery Home</h1>
		<?php echo $homepageDescription; ?>
	</body>
</html>