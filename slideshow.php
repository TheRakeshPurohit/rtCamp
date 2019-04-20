<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Slide Show of Album</title>
<link rel="stylesheet" type="text/css" href="lib/CSS/slider.css">
</head>
<body>
<?php
  session_start();
require_once 'appconfig.php';
require_once 'fb-callback.php';

if(isset($_SESSION['fb_access_token'])){

  $accessToken = (string) $_SESSION['fb_access_token'];
}
  $graphActLink = "https://graph.facebook.com/oauth/access_token?client_id={$appId}&client_secret={$appSecret}&grant_type=client_credentials";
    // Retrieve access token
    $accessTokenJson = file_get_contents($graphActLink);
    $accessTokenObj = json_decode($accessTokenJson);
    $accessToken = $accessTokenObj->access_token;
    
    // Store access token in session
    $_SESSION['fb_access_token'] = $accessToken;

if(isset($_GET['album_id']) && isset($_GET['album_name'])){
  $album_id =  $_GET['album_id'];
  $album_name = $_GET['album_name'];

// Get photos of Facebook page album using Facebook Graph API
$graphPhoLink = "https://graph.facebook.com/v3.2/{$album_id}/photos?fields=source,images,name&access_token={$accessToken}";
$jsonData = file_get_contents($graphPhoLink);
$fbPhotoObj = json_decode($jsonData, true, 512, JSON_BIGINT_AS_STRING);

// Facebook photos content
$fbPhotoData = $fbPhotoObj['data'];

if(empty($fbPhotoData)){}else{echo "<h2>" . $album_name . "</h2>";}


echo '<div class="slideshow-container">';

// Render all photos
if (is_array($fbPhotoData) || is_object($fbPhotoData) && $fbPhotoData!=null)
    {
foreach($fbPhotoData as $data){
    $imageData = end($data['images']);
    $imgSource = isset($imageData['source'])?$imageData['source']:'';
    $name = isset($data['name'])?$data['name']:'';
    
    echo '<div class="mySlides fade">';
    echo "<img src='{$imgSource}' alt='' style='width:90%;height:80%' />";
    echo '<div class="text">' . $name . '</div>';
    echo '</div>';
}

echo '</div>';
echo '<br/>';
echo '<div style="text-align:center">';
  foreach($fbPhotoData as $data){
      echo '<span class="dot"></span>';
    }
    echo '</div>';
}else{
  echo "We care for your privacy. Only public photos will be displayed !";
}
}
//}
?>
<script type="text/javascript" src="lib/JavaScript/slider.js"></script>
</body>
</html>