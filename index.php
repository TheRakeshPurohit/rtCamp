<?php
session_start();
<<<<<<< HEAD
require_once 'appconfig.php';

$fb = new Facebook\Facebook([
  'app_id' => $appId, // variable with Facebook App ID
  'app_secret' => $appSecret,
  'default_graph_version' => 'v3.3',
  ]);
  $helper = $fb->getRedirectLoginHelper();  
  $permissions = ['email','user_photos','user_videos','user_posts','user_link','user_status','user_link']; // Optional permissions
  $loginUrl = $helper->getLoginUrl($CallbackUrl,$permissions);
=======
    require_once 'appconfig.php';

    $fb = new Facebook\Facebook([
    'app_id' => $appId,
    'app_secret' => $appSecret,
    'default_graph_version' => 'v3.2',
    ]);
  
    $helper = $fb->getRedirectLoginHelper();
  
    $permissions = ['email','user_photos','user_videos','user_posts','user_link','user_status','user_link']; // Optional permissions
    $loginUrl = $helper->getLoginUrl($CallbackUrl,$permissions);
>>>>>>> 85e358e0c342f50861ef32c55d7303292e8d8f01
  
    echo "<h3> Connect Clicking Below Facebook Icon Using Your Facebook Account.<h3>";
    echo '<a href="' .htmlspecialchars($loginUrl).'"><img alt="Login With Facebook" src="images/fb_icon.png"></a>';