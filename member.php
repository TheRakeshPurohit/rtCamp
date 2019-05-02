<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>All Albums | Facebook | Download, SlideShow & Backup to Google Drive</title>
<link rel="stylesheet" type="text/css" href="lib/CSS/slider.css">
</head>
<body>
<?php
require_once 'appconfig.php';
require_once 'fb-callback.php';
if(isset($_SESSION['fb_access_token'])){
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
      
        //echo 'ID: ' . $user['id'] ;
        echo '<br/ >Welcome, ' . $user['name'];
        echo '<a href="logout.php" > Logout </a>';
      
        // Get photo albums of Facebook page using Facebook Graph API
        $fields = "id,name,description,link,cover_photo,count,images";
        $userid = $user['id'];
      
        $graphAlbLink = "https://graph.facebook.com/v3.2/{$userid}/albums?fields={$fields}&access_token={$accessToken}";
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
            $photos = "https://graph.facebook.com/v3.2/{$id}/photos?access_token={$accessToken}";
            $cover_photo_id = isset($data['cover_photo']['id'])?$data['cover_photo']['id']:'';
            $count = isset($data['count'])?$data['count']:'';
          
            $pictureLink = "slideshow.php?album_id={$id}&album_name={$name}";
            echo "<div class='carding'>";
            echo "<a href='{$pictureLink}'>";
            $cover_photo_id = (!empty($cover_photo_id))?$cover_photo_id : 123456;
            echo "<img width=200px height=200px src='https://graph.facebook.com/v3.2/{$cover_photo_id}/picture?access_token={$accessToken}' alt=''>";
            echo "<p>{$name}</p>";
            echo "</a>";
            //echo "$images";
            echo "<a href='{$photos}'> <button type='button'> Download Album </Button> </a>";
      
            $photoCount = ($count > 1)?$count. 'Photos':$count. 'Photo';
          
            echo "<p><span style='color:#888;'>{$photoCount} / <a href='{$link}' target='_blank'>View on Facebook</a></span></p>";
            echo "<p>{$description}</p>";
            echo "</div>";
        }
}else{
    header('Location: index.php');
}
?>
</body>
</html>