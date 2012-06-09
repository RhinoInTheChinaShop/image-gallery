<?php
	/*
	 * Later, this file may be used to allow importing to existing albums, but right now the user is just redirected to /create/event/
	*/
	header("Location: event/");
	exit;
	
	
	include("../settings.php");
	include("../auth/fetch.php");
	/*
	 * If the user is not allowed to import events, they are redirected to the homepage with an error.
	 */
	if(!$user && !$allowAnonImports) {
		header("Location: {$rootLocation}?action=noanonimports");
		exit;
	}
	if(!$allowAnonImports && !(in_array("*", $accountPermissions) || in_array("import.*", $accountPermissions) || in_array("import.event", $accountPermissions))) {
		header("Location: {$rootLocation}?action=importeventpermerror");
		exit;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Import Photos</title>
	</head>
	<body>
		
	</body>
</html>