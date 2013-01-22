<?php
$pageName = 'Admin Area';
$requiredAuth = 3;
?>
<h1>Admin Area</h1>
<h2>Information</h2>
Version: <?php echo VERSION; ?> (<?php echo VERSIONCHANNEL; ?> channel)<br>
<?php
require_once('includes/update.class.php');
$yetii = new Yetii();
$yetii->loadSettings();
$update = $yetii->getUpdate();
if ($update == false) {
	echo 'You\'re already on the latest version. Go you!<br>';
} else {
	echo 'Version ' . $update->getVersion() . ' is out! Please <a href="upgrade.php">upgrade</a>.<br>';
}
?>
<h2>Manage</h2>
<a href="<?php echo ROOTURL . ADMINFOLDER; ?>pages.php">Pages</a><br>
<a href="<?php echo ROOTURL . ADMINFOLDER; ?>snippets.php">Snippets</a><br>
<a href="<?php echo ROOTURL . ADMINFOLDER; ?>addnewtemplate.php">Add New Template</a><br>