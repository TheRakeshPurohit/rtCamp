<?php
session_start();
require_once 'appconfig.php';

$fb = new Facebook\Facebook([
  'app_id' => $appId, // variable with Facebook App ID
  'app_secret' => $appSecret,
  'default_graph_version' => 'v3.2',
  ]);
 $helper = $fb->getRedirectLoginHelper();  
  $permissions = ['email','user_photos','user_videos','user_posts','user_link','user_status','user_link']; // Optional permissions
  $loginUrl = $helper->getLoginUrl($CallbackUrl,$permissions);
  
  echo "<h3> Connect Clicking Below Facebook Icon Using Your Facebook Account.<h3>";
  echo '<a href="' .htmlspecialchars($loginUrl).'"><img alt="Login With Facebook" src="images/fb_icon.png"></a>';