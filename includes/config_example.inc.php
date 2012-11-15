<?php
// Define the database constants
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_name');
define('DB_USER', 'db_user');
define('DB_PASS', 'db_password');

// Folders are relative to the engine.php file
// URLs are relative to the website root
define('ROOTURL', '/');
define('INSTALLURL', '');
define('ADMINFOLDER', 'admin/');
define('ADMINURL', ROOTURL . INSTALLURL . ADMINFOLDER);
define('PAGESFOLDER', 'pages/');
define('TEMPLATESFOLDER', 'templates/');
define('TEMPLATESURL', ROOTURL . INSTALLURL . TEMPLATESFOLDER);
define('SNIPPETSFOLDER', 'snippets/');
define('SNIPPETSURL', ROOTURL . INSTALLURL . SNIPPETSFOLDER);
define('IMAGESFOLDER', 'images/');
define('IMAGESURL', ROOTURL . INSTALLURL . IMAGESFOLDER);
define('TEMPDIRECTORY', '.temp/');
define('ROOTFOLDER', ROOTURL); // Legacy Support
?>