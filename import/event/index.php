<?php
	include("../../settings.php");
	include("../../auth/fetch.php");
	
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
		<title>Import Event</title>
		<script type="text/javascript" src="<?php echo $rootLocation."resources/ajax.js"; ?>"></script>
		<script type="text/javascript" src="<?php echo $rootLocation."resources/swfupload.js"; ?>></script>
		<script type="text/javascript" src="import.js"></script>
		<link rel="stylesheet" type="text/css" href="import.css" />
	</head>
	<body>
		<div id="settingsLink">
			<!-- square-ish link to settings popup -->
		</div>
		<div id="helpSection" data-hidden="false">
			<!-- help information -->
		</div>
		<div id="importedImages">
			<!-- image import form -->
			<!-- image thumbnail list -->
		</div>
		<div id="eventPlayground">
			<!-- area to mess around with images -->
		</div>
		<div id="settingsOverlay">
			<div id="newEventForm">
				<h1>Create a New Event</h1>
				<form name="newEvent" id="newEvent">
					Event Name: <input type="text" name="name" /><br />
					Photo Upload Method:
					<select name="uploadMethod">
						<!-- Hardcoded for now, later it can be changed -->
						<option value="http">Web Upload</option>
					</select>
				</form>
			</div>
		</div>
	</body>
</html>