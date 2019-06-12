<?php
session_start();
    require_once 'appconfig.php';

        use Facebook\GraphNodes\GraphObject;
        use Facebook\GraphNodes\GraphSessionInfo;
        use Facebook\Authentication\AccessToken;
        use Facebook\HttpClients\FacebookHttpable;
        use Facebook\HttpClients\FacebookCurl;
        use Facebook\HttpClients\FacebookCurlHttpClient;
        use Facebook\FacebookSession;
        use Facebook\Helpers\FacebookRedirectLoginHelper;
        use Facebook\FacebookRequest;
        use Facebook\FacebookResponse;
        use Facebook\Exceptions\FacebookSDKException;
        use Facebook\Exceptions\FacebookAuthorizationException;

    $session = $_SESSION['fb_access_token'];

    $zip_folder = "";
    $album_download_directory = 'lib/resources/albums/' . uniqid() . '/';
    mkdir($album_download_directory, 0777);

    function download_album($session, $album_download_directory, $album_id, $album_name) {

        $graphPhoLink = 
$jsonData = 
$fbPhotoObj = 

        $request_album_photos = "https://graph.facebook.com/v3.3/{$album_id}/photos?fields=source,images,name&limit=100&access_token={$session}";
        $response_album_photos = file_get_contents($request_album_photos);			
        $album_photos = json_decode($response_album_photos, true, 512, JSON_BIGINT_AS_STRING);

        $album_directory = $album_download_directory . $album_name;
        if (!file_exists($album_directory)) {
            mkdir($album_directory, 0777);
        }

        $i = 1;
        foreach ($album_photos['data'] as $album_photo) {
            $album_photo = (array)$album_photo;
            file_put_contents($album_directory . '/' . $i . ".jpg", fopen($album_photo['source'], 'r'));
            $i++;
        }
    }

    //---------- For 1 album download -------------------------------------------------//
    if (isset($_GET['single_album']) && !empty ($_GET['single_album'])) {
        
        $single_album = explode(",", $_GET['single_album']);
        download_album($session, $album_download_directory, $single_album[0], $single_album[1]);
    }
	
    //---------- For Selected Albums download -----------------------------------------//
    if (isset($_GET['selected_albums']) and count($_GET['selected_albums']) > 0) {
        $selected_albums = explode("/", $_GET['selected_albums']);

        foreach ($selected_albums as $selected_album) {
            $selected_album = explode(",", $selected_album);
            download_album($session, $album_download_directory, $selected_album[0], $selected_album[1]);
        }
    }

    //---------- Download all album code -------------------------------------------------//
    if (isset($_GET['all_albums']) && !empty ($_GET['all_albums'])) {
        if ($_GET['all_albums'] == 'all_albums') {

            // graph api request for user data
			
            $request_albums = "https://graph.facebook.com/v3.3/me/albums?fields=id,name&access_token={$session}";
            $response_albums = file_get_contents($$request_albums);
			
            // get response
            $albums = json_decode($response_albums, true, 512, JSON_BIGINT_AS_STRING);

            if (!empty($albums)) {
                foreach ($albums['data'] as $album) {
                    $album = (array)$album;
                    download_album($session, $album_download_directory, $album['id'], $album['name']);
                }
            }
        }
    }

    if (isset($_GET['zip'])) {
        require_once('zipper.php');
        $zipper = new zipper();
        echo $zipper->get_zip($album_download_directory);

    } else {

        //$redirect = 'location:lib/move_to_picasa.php?album_download_directory='.$album_download_directory;
        //if ( isset( $_GET['ajax'] ) ) {
        //	$redirect = $redirect . '&ajax=1';
        //}
        //($redirect);
    }