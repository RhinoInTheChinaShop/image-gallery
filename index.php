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
		<link rel="stylesheet" type="text/css" href="{$rootLocation}resources/page.css" />
		<script type="text/javascript" src="{$rootLocation}resources/home.js"></script>
	</head>
	<body>
		<h1>Image Gallery Home</h1>
		<?php echo $homepageDescription; ?><hr />
		<div class="left userLogin">
			<?php
				if($user) {
					$realName = html_entity_decode($user["displayname"]);
					$profilePicture = $user["profilepic"];
					echo <<<EOD
			<img src="{$rootLocation}/pictures/?picture=$profilePicture" class="left profilePicture" alt="$realName's profile picture" />
			Logged in as $realName.<br />
			<a href="{$rootLocation}auth/logout/" class="right">Logout</a>
EOD;
				}
				else {
					echo <<<EOD
			<h4>Login</h4>
			You are not logged in.  Login below to see private pictures, and get access to commenting, and many other features.<br />
			<form action="{$rootLocation}auth/login/" method="POST">
				Username: <input type="text" name="username" /><br />
				Password: <input type="password" name="password" /><br />
				<input type="submit" value="Login" />
			</form>
EOD;
				}
			?>
		</div>
	</body>
</html>