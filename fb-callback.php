<?php
if(!session_id()) {
  session_start();
}
require_once 'lib\Facebook\autoload.php';

  $appId='362540437809242';
  $appSecret='538cd04f971479ff14dc409df2fbcf3b';

$fb = new Facebook\Facebook([
  'app_id' => $appId, // variable with My Facebook App ID
  'app_secret' => $appSecret,
  'default_graph_version' => 'v3.2',
  ]);
$helper = $fb->getRedirectLoginHelper();
if(isset($_GET['state'])){
  $helper->getPersistentDataHandler()->set('state',$_GET['state']);
}
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}
// Logged in
//echo '<h3>Access Token</h3>';
//($accessToken->getValue());
// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();
// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
echo '<h3>Facebook Photos Challenge</h3>';
//var_dump($tokenMetadata);
// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('362540437809242'); // My Facebook App ID
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();
if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
    exit;
  }
  echo '<h3>Long-lived</h3>';
  var_dump($accessToken->getValue());
}

$_SESSION['fb_access_token'] = (string) $accessToken;
try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,name', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
$user = $response->getGraphUser();

echo 'ID: ' . $user['id'] ;
echo '<br/ >Welcome, ' . $user['name'];
echo '<a href="logout.php" > Logout </a>';

// Generate graph access token
$graphActLink = "https://graph.facebook.com/oauth/access_token?client_id={$appId}&client_secret={$appSecret}&grant_type=client_credentials";
    
// Retrieve access token
$accessTokenJson = file_get_contents($graphActLink);
$accessTokenObj = json_decode($accessTokenJson);
$access_token = $accessTokenObj->access_token;


// Get photo albums of Facebook page using Facebook Graph API
$fields = "id,name,description,link,cover_photo,count";
$fb_page_id = $user['id'];
$graphAlbLink = "https://graph.facebook.com/v3.2/{$fb_page_id}/albums?fields={$fields}&access_token={$access_token}";

$jsonData = file_get_contents($graphAlbLink);
$fbAlbumObj = json_decode($jsonData, true, 512, JSON_BIGINT_AS_STRING);

// Facebook albums content
$fbAlbumData = $fbAlbumObj['data'];

// Render all photo albums
echo "<br/><br/>";
foreach($fbAlbumData as $data){
    $id = isset($data['id'])?$data['id']:'';
    $name = isset($data['name'])?$data['name']:'';
    $description = isset($data['description'])?$data['description']:'';
    $link = isset($data['link'])?$data['link']:'';
    $cover_photo_id = isset($data['cover_photo']['id'])?$data['cover_photo']['id']:'';
    $count = isset($data['count'])?$data['count']:'';
    
    $pictureLink = "fb-callback.php?album_id={$id}&album_name={$name}";
    

    echo "<a href='{$pictureLink}'>";
    $cover_photo_id = (!empty($cover_photo_id ))?$cover_photo_id : 123456;
    echo "<img width=100px height=100px src='https://graph.facebook.com/v3.2/{$cover_photo_id}/picture?access_token={$accessToken}' alt=''>";
    echo "</a>";
    echo "<p>{$name}</p>";

    $photoCount = ($count > 1)?$count. 'Photos':$count. 'Photo';
    
    echo "<p><span style='color:#888;'>{$photoCount} / <a href='{$link}' target='_blank'>View on Facebook</a></span></p>";
    echo "<p>{$description}</p>";
}
?>