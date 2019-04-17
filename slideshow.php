<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Slide Show of Album</title>
<link rel="stylesheet" type="text/css" href="lib/CSS/slider.css">
<script type="text/javascript" src="lib/JavaScript/slider.js"></script>  
</head>
<body>
<?php
require_once 'appconfig.php';

//if(isset($_SESSION['fb_access_token'])){
    // Get access token from session
  //  $accessToken = (string) $_SESSION['fb_access_token'];
//}else{
    $graphActLink = "https://graph.facebook.com/oauth/access_token?client_id={$appId}&client_secret={$appSecret}&grant_type=client_credentials";
    
    // Retrieve access token
    $accessTokenJson = file_get_contents($graphActLink);
    $accessTokenObj = json_decode($accessTokenJson);
    $accessToken = $accessTokenObj->access_token;
    
    // Store access token in session
    $_SESSION['fb_access_token'] = $accessToken;

if(isset($_GET['album_id']) && isset($_GET['album_name'])){
  $album_id = $_GET['album_id'];
  $album_name = $_GET['album_name']; //isset($_GET['album_name'])?:header('Location: fb-callback.php');

// Get photos of Facebook page album using Facebook Graph API
$graphPhoLink = "https://graph.facebook.com/v3.2/{$album_id}/photos?fields=source,images,name&access_token={$accessToken}";
$jsonData = file_get_contents($graphPhoLink);
$fbPhotoObj = json_decode($jsonData, true, 512, JSON_BIGINT_AS_STRING);

// Facebook photos content
$fbPhotoData = $fbPhotoObj['data'];

echo "<h2>" . $album_name . "</h2>";

echo '<div class="slideshow-container">';

// Render all photos
foreach($fbPhotoData as $data){
    $imageData = end($data['images']);
    $imgSource = isset($imageData['source'])?$imageData['source']:'';
    $name = isset($data['name'])?$data['name']:'';
    
    echo "<div class='myslides fade'>";
    echo "<img src='{$imgSource}' alt='' style='width:100%'>";
    echo "<h3>{$name}</h3>";
    echo "</div>";
}
echo '</div> <br />';
echo '<div style="text-align:center">';
foreach($fbPhotoData as $data){
  echo '<span class="dot"></span>';
}
echo '</div>';

/* // Render all photos
if (is_array($fbPhotoData) || is_object($fbPhotoData))
    {  
    foreach($fbPhotoData as $data){
        $imageData = end($data['images']);
        $imgSource = isset($imageData['source'])?$imageData['source']:'';
        $name = isset($data['name'])?$data['name']:'';

        echo '<div class="mySlides fade">';
        echo '<img src="{$imgSource}" alt="" style="width:100%">';
        echo '<div class="text">{$name}</div>';
        echo '</div>';
      }
      echo '</div>';
    } */
}
?>
</body>
</html>