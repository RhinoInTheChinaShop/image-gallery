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
				if($user) {
					$realName = html_entity_decode($user["displayname"]);
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
				if(!$db) {
					if(!$db = sqlite_open($databaseLocation, 0666, $dbError)) {
						die("Error connecting to the database: $dbError");
					}
				}
				/*
				 * turns an array of roles into a regex for any of the roles or public
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
				sqlite_regex_query($db, "SELECT * FROM events WHERE regexp(allowed_types, '$roles') LIMIT $tempEventLimit OFFSET $tempOffset");
			?>
		</div>
	</body>
</html>