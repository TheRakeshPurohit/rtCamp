<?php
require_once 'appconfig.php';
session_start();
$fb = new Facebook\Facebook([
    'app_id' => $appId, // variable with Facebook App ID
    'app_secret' => $appSecret,
    'default_graph_version' => 'v3.3',
    ]);
    $helper = $fb->getRedirectLoginHelper();
    $fbLogoutUrl = $helper->getLogoutUrl($_SESSION['fb_access_token'], "https://localhost/rtCamp/index.php");
    session_destroy();
    header("Location: $fbLogoutUrl");