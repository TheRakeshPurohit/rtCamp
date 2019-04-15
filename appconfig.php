<?php
    require_once 'lib\Facebook\autoload.php';
    if(!session_id()) {
      session_start();
    }
    $appId = '362540437809242'; // my facebook app id
    $appSecret = '538cd04f971479ff14dc409df2fbcf3b';
    $localurl = 'https://localhost/rtCamp/fb-callback.php';
    
?>