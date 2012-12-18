<?php
$requiredAuth = 3;
$pageTitle = 'Edit Logo Settings';
$settings = array();
// Try and load any stored settings
if (is_file(SNIPPETSFOLDER . 'Logo/settings.ini')) {
    $settings = parse_ini_file(SNIPPETSFOLDER . 'Logo/settings.ini', true);
}
// Make sure each setting has its default value if it doesn't already have on
if (!array_key_exists('showLogo', $settings)) {
    $settings['showLogo'] = true;
}
if (!array_key_exists('imageURL', $settings)) {
    $settings['imageURL'] = IMAGESURL . 'logo.png';
}
if (!array_key_exists('showText', $settings)) {
    $settings['showText'] = false;
}
if (!array_key_exists('text', $settings)) {
    $settings['text'] = WEBSITENAME;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Saving settings
    $settings['showLogo'] = (isset($_POST['showLogo']) && $_POST['showLogo'] == 'on') ? true : false;
    $settings['imageURL'] = $_POST['imageURL'];
    $settings['showText'] = (isset($_POST['showText']) && $_POST['showText'] == 'on') ? true : false;
    $settings['text'] = $_POST['text'];
    if (write_ini_file($settings, SNIPPETSFOLDER . 'Logo/settings.ini')) {
        echo 'Settings have been saved<br>';
    } else {
        echo 'There was an error saving the settings. Please try again.<br>';
    }
}
?>
<form method="POST">
    <label>Show Logo: <input type="checkbox" name="showLogo" <?php echo ($settings['showLogo']) ? 'checked="checked"' : '' ; ?>></input></label><br>
    <label>Image URL: <input type="text" name="imageURL" value="<?php echo $settings['imageURL']; ?>"></input></label><br>
    <label>Show Text: <input type="checkbox" name="showText" <?php echo ($settings['showText']) ? 'checked="checked"' : '' ; ?>></input></label><br>
    Text<br>
    <textarea name="text" cols="30" rows="10"><?php echo $settings['text']; ?></textarea><br>
    <input type="submit" value="Save Settings">
</form>
<?php
?>