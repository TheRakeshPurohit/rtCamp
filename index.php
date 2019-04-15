<?php
if(!session_id()) {
  session_start();
}

require_once 'lib\Facebook\autoload.php';

if(isset($_SESSION['fb_access_token'])){
  // Get access token from session
  $accessToken = $_SESSION['fb_access_token'];
  header('Location:fb-callback.php');
}else{
$fb = new Facebook\Facebook([
  'app_id' => '362540437809242', // my facebook app id
  'app_secret' => '538cd04f971479ff14dc409df2fbcf3b',
  'default_graph_version' => 'v3.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://localhost/rtCamp/fb-callback.php', $permissions);

echo "<h3> Connect Clicking Below Facebook Icon Using Your Facebook Account.<h3>";
echo '<a href="' .htmlspecialchars($loginUrl).'"><img alt="Login With Facebook" src="images/fb_icon.png"></a>';
}
?>