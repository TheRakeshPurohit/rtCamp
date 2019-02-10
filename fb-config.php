<?php
if (!session_id()) {
    session_start();
}

require_once 'lib\Facebook\autoload.php';

$app_id = '362540437809242';
$app_secret = '538cd04f971479ff14dc409df2fbcf3b';
$permissions = ['email']; // Optional permissions
$callbackUrl = 'http://127.0.0.1/rtCamp/fb-callback.php';

$fb = new Facebook\Facebook([
    'app_id' => $app_id, // My facebook app id
    'app_secret' => $app_secret,
    'default_graph_version' => 'v3.2',
    ]);

  $helper = $fb->getRedirectLoginHelper();

  $loginUrl = $helper->getLoginUrl($callbackUrl, $permissions);

?>