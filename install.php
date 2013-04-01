<!DOCTYPE html>
<html>
<head>
	<title>Install Yetii CMS</title>
	<link rel="stylesheet" type="text/css" href="templates/default/css/global.css" media="all">
	<link rel="stylesheet" type="text/css" href="templates/default/css/layout.css" media="all and (min-width: 33.236em)">
	<!-- 30em + (1.618em * 2) = 33.236em / Eliminates potential of horizontal scrolling in most cases -->
	<!--[if lt IE 9]>
		<link rel="stylesheet" href="templates/default/css/layout.css" media="all">
	<![endif]-->
	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<?php
	$rootURL = str_replace('engine.php', '', $_SERVER['PHP_SELF']);
	?>
	<script src="<?php echo $rootURL; ?>includes/js/install.js"></script>
</head>
<body>
	<div id="holder">
		<header class="clearfix">
			<h1>Yetii CMS Installation</h1>
		</header>
		<div id="pageContainer" class="clearfix">
			<div id="pageContents">
				<?php
				require_once('includes/installFunctions.inc.php');
				if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					// Form has been submitted
					global $errors;
					$websiteName = $_POST['websiteName'];
					if ($_POST['websiteRoot'] == '') {
						$websiteRoot = '/';
					} else {
						$websiteRoot = $_POST['websiteRoot'];
					}
					$dbHost = (isset($_POST['dbHost']) && $_POST['dbHost'] !== '') ? $_POST['dbHost'] : 'localhost';
					$dbUsername = $_POST['dbUsername'];
					$dbPassword = $_POST['dbPassword'];
					$dbName = $_POST['dbName'];
					$config = "<?php\r\n" .
					"// Define the database constants\r\n" .
					"define('DB_HOST', '" . $dbHost . "');\r\n" .
					"define('DB_NAME', '" . $dbName . "');\r\n" .
					"define('DB_USER', '" . $dbUsername . "');\r\n" .
					"define('DB_PASS', '" . $dbPassword . "');\r\n" .
					"\r\n" .
					"// Folders are relative to the engine.php file\r\n" .
					"// URLs are relative to the website root\r\n" .
					"define('ROOTURL', '/');\r\n" .
					"define('INSTALLURL', ''); // Relative to the root URL\r\n" .
					"define('ADMINFOLDER', 'admin/');\r\n" .
					"define('ADMINURL', ROOTURL . INSTALLURL . ADMINFOLDER);\r\n" .
					"define('PAGESFOLDER', 'pages/');\r\n" .
					"define('TEMPLATESFOLDER', 'templates/');\r\n" .
					"define('TEMPLATESURL', ROOTURL . INSTALLURL . TEMPLATESFOLDER);\r\n" .
					"define('SNIPPETSFOLDER', 'snippets/');\r\n" .
					"define('SNIPPETSURL', ROOTURL . INSTALLURL . SNIPPETSFOLDER);\r\n" .
					"define('IMAGESFOLDER', 'images/');\r\n" .
					"define('IMAGESURL', ROOTURL . INSTALLURL . IMAGESFOLDER);\r\n" .
					"define('TEMPDIRECTORY', '.temp/');\r\n" .
					"?>";
					$adminEmail = $_POST['adminEmail'];
					$adminPassword = $_POST['adminPassword'];
					$adminPasswordVerification = $_POST['adminPasswordVerification'];
					$adminDisplayName = $_POST['adminDisplayName'];
					if (file_put_contents('config.inc.php', $config)) {
						echo 'File saved<br>';
						include_once('config.inc.php');
						$mapper = new Mapper();
						if ($mapper->getError() !== false) {
							echo $mapper->getError();
							unset($mapper);
						} else {
							echo 'Database connection established.<br>';
							$result = $mapper->createTables();
							if ($result === true) {
								// Tables created
								echo 'Database tables create.<br>';
								$result = User::register($adminEmail, $adminPassword, $adminPasswordVerification, $adminDisplayName, 3);
								if ($result === true) {
									echo 'Admin user registered<br>';
									if (rename('config.inc.php', 'includes/config.inc.php')) {
										?>
										Yetii installed successfully. You can now <a href="<?php echo ROOTURL; ?>" title="Your new homepage">view</a> and <a href="<?php echo ROOTURL; ?>login" title="Login to your website">login</a> to your website.<br>
										It is recommended you delete the install.php file for security reasons.<br>
										<?php
										exit();
									} else {
										$errors->add(Error::withDescription('Could not move configuration file. Please make sure you have the correct permissions'));
										$errors->show();
									}
								} else {
									echo 'Could not create admin user:<br>';
									$result->show();
								}
								unset($mapper);
							} else {
								echo 'Could not create database tables:<br>';
								$errors->show();
							}
							unset($mapper);
						}

					} else {
						echo 'Error saving config file.';
					}
				}
				?>
				This page will guide you through the installation process for Yetii CMS.<br>
				<noscript>It is recommended you enable JavaScript to make the installation process smoother and more user-friendly.<br></noscript>
				<label>Show Advanced Options: <input type="checkbox" name="toggleAdvancedOptions"></input></label><br>
				<form method="POST">
					<fieldset>
						<legend>Website Settings</legend>
						<label>Website Name: <input type="text" name="websiteName" <?php if (isset($websiteName)) echo 'value="' . $websiteName . '"'; ?>></input></label><br>
						<span class="advanced"><label>Website Root: <input type="text" name="websiteRoot" value="<?php echo isset($websiteRoot) ? $websiteRoot : $rootURL; ?>"</input></label><br></span>
					</fieldset>
					<fieldset>
						<legend>Database Settings</legend>
						<span class="advanced"><label>Database Host: <input type="text" name="dbHost" value="<?php echo isset($dbHost) ? $dbHost : 'localhost'; ?>"></input></label><br></span>
						<label>Database Username: <input type="text" name="dbUsername" <?php if (isset($dbUsername)) echo 'value="' . $dbUsername . '"'; ?>></input></label><br>
						<label>Database Password: <input type="password" name="dbPassword" <?php if (isset($dbPassword)) echo 'value="' . $dbPassword . '"'; ?>></input></label><br>
						<label>Database Name: <input type="text" name="dbName" <?php if (isset($dbName)) echo 'value="' . $dbName . '"'; ?>></input></label><br>
					</fieldset>
					<fieldset>
						<legend>Admin User</legend>
						<label>Email: <input type="email" name="adminEmail" <?php if (isset($adminEmail)) echo 'value="' . $adminEmail . '"'; ?>></input></label><br>
						<label>Password: <input type="password" name="adminPassword" <?php if (isset($adminPassword)) echo 'value="' . $adminPassword . '"'; ?>></input></label><br>
						<label>Password (again): <input type="password" name="adminPasswordVerification" <?php if (isset($adminPasswordVerification)) echo 'value="' . $adminPasswordVerification . '"'; ?>></input></label><br>
						<label>Display Name: <input type="text" name="adminDisplayName" <?php if (isset($adminDisplayName)) echo 'value="' . $adminDisplayName . '"'; ?>></input></label><br>
					</fieldset>
					<fieldset>
						<legend>Save Settings</legend>
						<input type="submit" value="Save Settings"><br>
					</fieldset>
				</form>
			</div>
		</div>
		<footer>
			Yetii CMS &copy; Joseph Duffy
		</footer>
	</div>
</body>
</html>