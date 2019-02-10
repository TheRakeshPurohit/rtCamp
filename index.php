<?php
    $fb = new Facebook\Facebook([
    'app_id' => '362540437809242', // My facebook app id
    'app_secret' => '538cd04f971479ff14dc409df2fbcf3b',
    'default_graph_version' => 'v2.2',
    ]);

  $helper = $fb->getRedirectLoginHelper();

  $permissions = ['email']; // Optional permissions
  $loginUrl = $helper->getLoginUrl('fb-callback.php', $permissions);

  echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
  ?>