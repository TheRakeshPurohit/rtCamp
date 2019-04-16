<?php
if(!session_id()) {
  session_start();
}
require_once 'lib\Facebook\autoload.php';

  $appId = '362540437809242'; // my facebook app id
    $appSecret = '538cd04f971479ff14dc409df2fbcf3b';
    $CallbackUrl = 'https://localhost/rtCamp/fb-callback.php';

$fb = new Facebook\Facebook([
  'app_id' => $appId,
  'app_secret' => $appSecret,
  'default_graph_version' => 'v3.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl($CallbackUrl, $permissions);

echo "<h3> Connect Clicking Below Facebook Icon Using Your Facebook Account.<h3>";
echo '<a href="' .htmlspecialchars($loginUrl).'"><img alt="Login With Facebook" src="images/fb_icon.png"></a>';
//}
?>