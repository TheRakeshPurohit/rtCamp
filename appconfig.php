<?php
require_once 'lib\Facebook\autoload.php';

require_once('lib/Facebook/GraphNodes/GraphObject.php');
require_once('lib/Facebook/GraphNodes/GraphSessionInfo.php');
require_once('lib/Facebook/Authentication/AccessToken.php');
require_once('lib/Facebook/HttpClients/FacebookCurl.php');
require_once('lib/Facebook/HttpClients/FacebookCurlHttpClient.php');
require_once('lib/Facebook/Helpers/FacebookRedirectLoginHelper.php' );
require_once('lib/Facebook/FacebookRequest.php' );
require_once('lib/Facebook/FacebookResponse.php' );
require_once('lib/Facebook/Exceptions/FacebookSDKException.php' );
require_once('lib/Facebook/Exceptions/FacebookAuthorizationException.php' );

    $appId = '359690587983062'; // Facebook App id 589129311570125 589129311570125
    $appSecret = 'ee50a6453ab0da99c80521144f8baefe'; //92f90e5dff5c6bdc2da0281631ec0446  538cd04f971479ff14dc409df2fbcf3b
    $CallbackUrl = 'https://localhost/rtCamp/fb-callback.php';
?>