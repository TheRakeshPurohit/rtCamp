# rtCamp [![Awesome](https://cdn.rawgit.com/sindresorhus/awesome/d7305f38d29fed78fa85652e3a63e154dd8e8829/media/badge.svg)](https://rakeshpurohit-rtcamp-fb-challenge.000webhostapp.com/)

# Travis- CI https://api.travis-ci.org/TheRakeshPurohit/rtCamp.svg?branch=main

<img src="https://upload.wikimedia.org/wikipedia/commons/c/cd/Facebook_logo_%28square%29.png" alt="Facebook Logo" width="50px" height="50px">

 ### [Demo Link](https://rakeshpurohit-rtcamp-fb-challenge.000webhostapp.com/)

### Introduction
This application is created using Facebook Graph SDK v5 PHP API. User can login to application to get all facebook albums as well as view and download albums from facebook account.

User Can download own Facebook albums.

### Prerequisites
```
* Server with PHP 7.3.1
```
### Create a web application

The sample is configured to use a web application that resolves to rtCamp. To make it easier to configure your app we recommend that you use rtCamp as your web application name. 

Follow this procedure to create the web application:

  Start by Cloning or Downloading this repo
```
To Clone this Repo into your server
git clone https://github.com/TheRakeshPurohit/rtCamp.git
```
### Update the configuration file

```
path to config file
 ===> rtCamp/appconfig.php
 ```
 ### Values To Be Change To Get The Application Running
   **Only To Be Changed When Not To Be Deployed Locally.**
```    
 $CallbackUrl = 'http://localhost/rtCamp/'; 
 ```
 **Values To Be Configured To Use Your Own App.**
```
    $appId = 'Enter Your Key Here';
    $appSecret = 'Enter Your Consumer Secret Here';
 ```

 ### To Create Facebook App
 
 Please Visit This [Link](https://developers.facebook.com/)

## Built With

* [Facebook Graph SDK v5 PHP API](https://github.com/facebook/php-graph-sdk) - Library Used For Facebook Graph SDK v5 PHP API

## Author

 **Rakesh Purohit** 
  * [Stackoverflow Profile](https://stackoverflow.com/users/11320820/rakesh-purohit)
