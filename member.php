<?php
if(!session_id()) {
  session_start();
}
require_once 'lib\Facebook\autoload.php';

if(isset($_SESSION['fb_access_token'])){
  // Get access token from session
  $accessToken = $_SESSION['fb_access_token'];
  $user = (array) $_SESSION['user'];
  
echo '<br/> User ID: ' . $user['id']; 
echo '<br/> Welcome , ' . $user['name'];
echo '<a href=""  >Logout</a>';

// Get photo albums of Facebook page using Facebook Graph API
$fields = "id,name,description,link,cover_photo,count";
$fb_page_id = $user['id'];
$graphAlbLink = "https://graph.facebook.com/v3.2/{$fb_page_id}/albums?fields={$fields}&access_token={$accessToken}";

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
//}

$album_id = isset($_GET['album_id'])?$_GET['album_id']:header("Location: fb-callback.php");
$album_name = isset($_GET['album_name'])?$_GET['album_name']:header("Location: fb-callback.php");

// Get photos of Facebook page album using Facebook Graph API
$graphPhoLink = "https://graph.facebook.com/v3.2/{$album_id}/photos?fields=source,images,name&access_token={$accessToken}";
$jsonData = file_get_contents($graphPhoLink);
$fbPhotoObj = json_decode($jsonData, true, 512, JSON_BIGINT_AS_STRING);

// Facebook photos content
$fbPhotoData = $fbPhotoObj['data'];

echo "<h2>".$album_name."</h2>";

// Render all photos   
if (is_array($fbPhotoData) || is_object($fbPhotoData))
{  
foreach($fbPhotoData as $data){
    $imageData = end($data['images']);
    $imgSource = isset($imageData['source'])?$imageData['source']:'';
    $name = isset($data['name'])?$data['name']:'';

    echo "<div class='item'>";
    echo "<img src='{$imgSource}' alt=''>";
 echo "<p>{$name}</p>";
    echo "</div>";
}
}
}
echo'</div>';

echo "<div class='slideshow-container'>";

// Render all photos 
if (is_array($fbPhotoData) || is_object($fbPhotoData))
{   
foreach($fbPhotoData as $data){
    $imageData = end($data['images']);
    $imgSource = isset($imageData['source'])?$imageData['source']:'';
    $name = isset($data['name'])?$data['name']:'';

echo "<div class='mySlides fade'>";
echo "<img src='{$imgSource}' alt='' style='width:100%'>";
echo "<div class='text'>{$name}</div>";
echo "</div>";
}
}
?>
<br>

  <div style="text-align:center">
  <?php
  if (is_array($fbPhotoData) || is_object($fbPhotoData))
  { 
    foreach($fbPhotoData as $data){
      echo "<span class='dot'></span>";
   }
  }
  ?>
  </div>

</div>


<script>
var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace("active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += "active";
  setTimeout(showSlides, 2000); // Change image every 2 seconds
}
</script>

<style>
* {box-sizing: border-box;}
body {font-family: Verdana, sans-serif;}
.mySlides {display: none;}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
</style>

}else{
    header('location:index.php');
}
?>