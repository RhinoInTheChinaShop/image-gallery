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
				$actionMessages = array("logoutSuccess"=>"You successfully logged out.", "loginSuccess"=>"You have successfully logged in.");
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
			<?php
				/*
				 * Opens a connection to the database, if the database is not already open.
				 */
				if(!$db) {
					if(!$db = sqlite_open($databaseLocation, 0666, $dbError)) {
						die("Error connecting to the database: $dbError");
					}
				}
				/*
				 * turns an array of roles into a regex for any of the roles or public, made for users who are logged in.
				 */
				function rolesRegexGenerator($rs) {
					$out = "";
					foreach($rs as $r) {
						$out .= ".*$r.*||";
					}
					return $out."public";
				}
				$roles = $user ? rolesRegexGenerator(unserialize($user["roles"])) : array("public");
				$tempEventLimit = ($allowUserChangeEventLimit && isset($_GET["itemLimit"])) ? sqlite_escape_string($_GET["itemLimit"]) : sqlite_escape_string($eventLimit);
				$tempOffset = (isset($_GET["page"])) ? sqlite_escape_string($tempEventLimit * $_GET["page"]) : 0;
				$query = sqlite_regex_query($db, "SELECT * FROM events WHERE regexp(allowed_types, '$roles') LIMIT $tempEventLimit OFFSET $tempOffset");
				while($event = sqlite_fetch_array($query)) {
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
	</body>
</html>