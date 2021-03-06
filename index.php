<?php
	session_start();
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
	
	/*
	 * Fetch authorization details of the current user,
	 * and includes multiuse functions for pages.
	 */
	require("auth/fetch.php");
	require("page.php");
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo parsePageTitle("Home"); ?></title>
		<link rel="stylesheet" type="text/css" href="{$rootLocation}resources/page.css" />
		<script type="text/javascript" src="{$rootLocation}resources/home.js"></script>
	</head>
	<body>
		<h1>Image Gallery Home</h1>
		<?php
			/*
			 * If the user is redirected to the homepage due to the result of an action, a message is displayed based on the output of the action.
			 */
			if(isset($_GET["action"])) {
				$actionMessages = array("logoutSuccess"=>"You successfully logged out.", "loginSuccess"=>"You have successfully logged in.", "noevent"=>"No event was specified.  Please select an event below.","importeventpermerror"=>"Your account doesn't have permission to import events.");
				$actionMessage = $actionMessages[$_GET["action"]];
				if($actionMessage) {
					echo <<<EOD
		<div id="actionMessage">
			$actionMessage
		</div>
EOD;
				}
			}
		?>
		<?php echo $homepageDescription; ?><hr />
		<div class="left userLogin">
			<?php
				/*
				 * Displays the user's details if the user is logged in, otherwise displays a login box.
				 */
				if($user) {
					$realName = htmlentities($user["displayname"]);
					$profilePicture = (isset($user["profilePic"]) || $user["profilePic"] !== "") ? "{$rootLocation}/pictures/?picture=".$user["profilePic"] : $defaultProfilePicture;
					echo <<<EOD
			<img src="$profilePicture" class="left profilePicture" alt="$realName's profile picture" />
			Logged in as $realName.<br />
			<a href="{$rootLocation}auth/logout.php" class="right">Logout</a>
EOD;
				}
				else {
					echo <<<EOD
			<h4>Login</h4>
			You are not logged in.  Login below to see private pictures, and get access to commenting, and many other features.<br />
			<form action="{$rootLocation}auth/login.php" method="POST">
				Username: <input type="text" name="username" /><br />
				Password: <input type="password" name="password" /><br />
				<input type="submit" value="Login" />
			</form>
EOD;
				}
			?>
		</div>
		<div id="events">
			<div id="eventThumbnails">
				<?php
					/*
					 * Opens a connection to the database, if the database is not already open.
					 */
					if(!$db) {
						if(!$db = sqlite_open($databaseLocation, 0666, $dbError)) {
							die("Error connecting to the database: $dbError");
						}
					}
					$roles = $user ? rolesRegexGenerator(unserialize($user["roles"])) : array("public");
					$tempEventLimit = ($allowUserChangeEventLimit && isset($_GET["itemLimit"])) ? sqlite_escape_string($_GET["itemLimit"]) : sqlite_escape_string($eventLimit);
					$tempOffset = (isset($_GET["page"])) ? sqlite_escape_string($tempEventLimit * $_GET["page"]) : 0;
					$query = sqlite_regex_query($db, "SELECT * FROM events WHERE regexp(allowed_types, '$roles') LIMIT $tempEventLimit OFFSET $tempOffset");
					$eventCount = 0;
					while($event = sqlite_fetch_array($query)) {
						$eventCount += 1;
						$imageLink = htmlentities("{$rootLocation}albums/?album=".$event["id"]);
						$thumbnailURL = htmlentities($event["thumbnailURL"]);
						$text = htmlentities($event["name"]);
						echo <<<EOD
				<a href="$imageLink" id="albumImage">
					<img src="$thumbnailURL" alt="$text" /><br />
					$text<br />
				</a>
EOD;
					}
				?>
			</div>
			<div id="eventDisplayControls">
				<?php
					/*
					 * Add events per page control to page if the user is allowed to change the limit
					 * TODO: add javascript to submit the form after the number of items per page is selected
					 */
					$tempLimit = htmlentities($tempEventLimit);
					$pageNumber = htmlentities($_GET["page"]);
					if($allowUserChangeEventLimit) {
						echo <<<EOD
				<form name="eventLimit" method="GET">
					Elements per page:
						<select name="itemLimit">
							<option value="$tempLimit">Current option: $tempLimit</option>
							<option value="5">5</option>
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
						</select>
					<input type="hidden" name="page" value="$pageNumber" />
					<input type="submit" value="Change item limit" />
				</form>
EOD;
					}
					/*
					 * Page change links
					 * TODO: add javascript to replace links with form submission (document.getElementsByClass, form.sumbit, etc)
					 * TODO: add checks to only display links that have items on the page
					 * TODO: add last page link
					 */
					$prevPage = $pageNumber-1;
					$nextPage = $pageNumber+1;
					$firstListedPage = ($pageNumber - 5 < 0) ? 0 : $pageNumber - 5;
					echo <<<EOD
				<form name="eventPage" method="GET">
					<input type="hidden" name="itemLimit" value="$tempLimit" />
					<input type="hidden" name="page" />
					<a href="?page=0&itemLimit=$tempLimit" class="eventPageLink" data-page="0">First Page</a>
EOD;
					if($prevPage > -1) {
						echo <<<EOD
					<a href="?page={$prevPage}&itemLimit=$tempLimit" class="eventPageLink" data-page="$prevPage">Previous Page</a>
EOD;
					}
					for($i = 0; $i < 16; $i++) {
						$thisPageNumber = $firstListedPage + $i;
						echo <<<EOD
					<a href="?page={$thisPageNumber}&itemLimit=$tempLimit" class="eventPageLink" data-page="$thisPageNumber">$thisPageNumber</a>
EOD;
					}
					echo <<<EOD
					<a href="?page={$nextPage}&itemLimit=$tempLimit" class="eventPageLink" data-page="$thisPageNumber">Next Page</a>
				</form>
EOD;
				?>
			</div>
		</div>
	</body>
</html>