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
$update = $yetii->getUpdate();
if ($update) {
	echo 'You\'re already on the latest version. Go you!<br>';
} else {
	echo 'Version ' . $update->getVersion() . ' is out! Please <a href="' . ROOTURL . ADMINFOLDER . 'upgrade.php">upgrade</a>.<br>';
}
?>
<h2>Manage</h2>
<a href="<?php echo ROOTURL . ADMINFOLDER; ?>pages.php">Pages</a><br>
<a href="<?php echo ROOTURL . ADMINFOLDER; ?>snippets.php">Snippets</a><br>
<a href="<?php echo ROOTURL . ADMINFOLDER; ?>images/">Manage Images</a><br>
<a href="<?php echo ROOTURL . ADMINFOLDER; ?>addnewtemplate.php">Add New Template</a><br>