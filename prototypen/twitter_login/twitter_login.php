<?php
//session_destroy();
session_start();
include_once("twitteroauth/OAuth.php");
include_once("twitteroauth/twitteroauth.php");

// Config, muss per https://apps.twitter.com/ erstellt werden
const TWITTER_CONSUMER_KEY = 'TWITTER_CONSUMER_KEY';
const TWITTER_CONSUMER_SECRET = 'TWITTER_CONSUMER_SECRET';
const TWITTER_OAUTH_CALLBACK = 'http://localhost.com/twitter_login.php';


print_r($_SESSION);

if(isset($_SESSION['name']) > 0 && isset($_SESSION['twitter_id']) > 0){
    $name = $_SESSION['name'];
    $twitter_id = $_SESSION['twitter_id'];

    echo "Erfolgreicher Twitter Login!<br>".$name." - ".$twitter_id;
}else{
    $twitter = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);
    $request_token = $twitter->getRequestToken(TWITTER_OAUTH_CALLBACK);

    if($request_token){
        switch($twitter->http_code){
            case 200:
                $token = $request_token['oauth_token'];
                $_SESSION['request_token'] = $token ;
                $_SESSION['request_token_secret'] = $request_token['oauth_token_secret'];

                $url = $twitter->getAuthorizeURL($token);
                //Twitter Redirect
                header('Location: ' . $url);
                break;
            case 401:
                echo "Ungueltige Authentifizierungsdaten.";
                break;
            default:
                echo "Verbindungsfehler: ".$twitter->http_code;
                break;
            // Hier koennen noch mehrere Errors aufgenommen werden: https://dev.twitter.com/overview/api/response-codes
        }

    }
    else{
        echo "Fehler beim Request Token Handling";
    }

}