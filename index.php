<?php
require_once 'appconfig.php';

$fb = new Facebook\Facebook([
  'app_id' => $appId,
  'app_secret' => $appSecret,
  'default_graph_version' => 'v3.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl($localurl, $permissions);

echo "<h3> Connect Clicking Below Facebook Icon Using Your Facebook Account.<h3>";
echo '<a href="' .htmlspecialchars($loginUrl).'"><img alt="Login With Facebook" src="images/fb_icon.png"></a>';
//}
?>