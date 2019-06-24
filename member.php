<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap and other CSSs -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="shortcut icon" type="image/jpg" href="lib/resources/img/favicon.jpg"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<link rel="stylesheet" type="text/css" href="lib/resources/css/style.css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


<title>All Albums | Facebook | Download, SlideShow & Backup to Google Drive</title>
<link rel="stylesheet" type="text/css" href="lib/CSS/slider.css">
</head>
<body>
<?php
require_once 'appconfig.php';
require_once 'functions.php';
$fb = new Facebook\Facebook([
  'app_id' => $appId, // variable with Facebook App ID
  'app_secret' => $appSecret,
  'default_graph_version' => 'v3.3',
  ]);
$helper = $fb->getRedirectLoginHelper();

if(isset($_GET['state'])){
  $helper->getPersistentDataHandler()->set('state',$_GET['state']);
}

if(isset($_SESSION['fb_access_token'])){ 
    try {
        $accessToken = $_SESSION['fb_access_token'];
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
      
      $userid = $user['id'];
      ?>
      <nav class="navbar bg-dark navbar-dark fixed-top" role="navigation">

					<div class="container">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div id="nav-menu" class="navbar-header">
							<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-menu">
								<span class="navbar-toggler-icon"></span>
							</button>
							<a class="navbar-brand" href="#" id="username">
								<img src="<?php echo 'https://graph.facebook.com/'.$userid.'/picture';?>" id="user_photo" class="img-circle" />
								<span style="margin-left: 5px;"><?php echo $user['name'];?></span>
							</a>
						</div>

      <div id="navbar-collapse-menu" class="collapse navbar-collapse menu-links">
							<hr />
									<a href="#" id="download-all-albums" class="center">
										<span class="btn btn-primary">
											Download All
										</span>
									</a>
							
									<a href="#" id="download-selected-albums" class="center">
										<span class="btn btn-warning">
											Download Selected
										</span>
									</a>
								
									<a href="#" id="move_all" class="center">
										<span class="btn btn-success">
											Move All
										</span>
									</a>
								
									<a href="#" id="move-selected-albums" class="center">
										<span class="btn btn-info">
											Move Selected
										</span>
									</a>
								
									<a href="logout.php" class="center">
										<span class="btn btn-danger">
											Logout
										</span>
									</a>
								</li>
							
						</div>
            </div>
				</nav>
        <div class="container" id="main-div">
					<div class="row">
						<span id="loader" class="navbar-fixed-top"></span>

						<div class="modal fade" id="download-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
										<h4 class="modal-title" id="myModalLabel">Album(s)</h4>
										<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">
											<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
										</button>
									</div>
									<div class="modal-body" id="display-response">
										<!-- Response is displayed over here -->
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
        
<?php
      // Get photo albums of Facebook page using Facebook Graph API
      $fields = "id,name,description,link,cover_photo,count,images";
      
      $graphAlbLink = "https://graph.facebook.com/v3.3/{$userid}/albums?fields={$fields}&access_token={$accessToken}";
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
          $photos = "https://graph.facebook.com/v3.3/{$id}/photos?access_token={$accessToken}";
          $cover_photo_id = isset($data['cover_photo']['id'])?$data['cover_photo']['id']:'';
          $count = isset($data['count'])?$data['count']:'';
          
          $pictureLink = "slideshow.php?album_id={$id}&album_name={$name}";
          echo "<div class='carding'>";
          echo "<a target='_blank' href='{$pictureLink}'>";
          $cover_photo_id = (!empty($cover_photo_id))?$cover_photo_id : 123456;
          echo "<img width=200px height=200px src='https://graph.facebook.com/v3.3/{$cover_photo_id}/picture?access_token={$accessToken}' alt=''>";
          echo "<p>{$name}</p>";
          echo "</a>";
          //echo "$images";
          
          $photoCount = ($count > 1)?$count. 'Photos':$count. 'Photo';
          
          echo "<p><span style='color:#888;'>{$photoCount} / <a href='{$link}' target='_blank'>View on Facebook</a></span></p>";
          echo "<p>{$description}</p>";
          ?>
		<div class="caption">
		  
			<button rel="<?php echo $id.','.$name;?>" class="single-download btn btn-primary pull-left" title="Download Album">
				<span class="fas fa-download" ></span>
			</button>

			<input type="checkbox" class="select-album" value="<?php echo $id.','.$name;?>" />
			<span rel="<?php echo $id.','.$name;?>" class="move-single-album btn btn-danger pull-right" title="Move to Google">
            	<span class="fas fa-file-export"></span>
			</span>
		</div>
          <?php echo "</div>";
        
      }
      ?>
      </div>
<?php }else{
  header("Location: index.php");
}
?>
<script src="lib/resources/js/spin.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript" src="functions.js"></script>
</body>
</html>