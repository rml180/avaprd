<?php
require_once("twitteroauth/twitteroauth.php");
require_once("config.php");
session_start();

// Objekt fuer Twitter Autorisierung
$twitteroauth = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);
$request_token = $twitteroauth->getRequestToken(TWITTER_OAUTH_CALLBACK);

// Session befuellen, damit Callback dies auslesen kann
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

// HTTP-Code fuer "alles OK" ist 200
if($twitteroauth->http_code == 200){
    // Redirect nacht Twitter
    $url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);
    header('Location: '. $url);

} else {
    // Hier koennte man einen Switch einbauen, der versch. HTTP Codes behandelt:
    // https://dev.twitter.com/overview/api/response-codes
}