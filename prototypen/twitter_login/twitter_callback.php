<?php
require_once("twitteroauth/twitteroauth.php");
require_once("config.php");
session_start();

// Nur, wenn diese Sachen befuellt wurden, ist der Login vollstaendig geglueckt
if(!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){
    // SESSION wurde bereits in twitter_login.php befuellt
    $twitteroauth = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

    $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
    $_SESSION['access_token'] = $access_token;

    // Alle User-Daten speichern, mit diesen waere dann der Login in unsere DB moeglich
    $user_info = $twitteroauth->get('account/verify_credentials');
    $_SESSION["twitterInfoArray"] = $user_info;

    echo "<pre>";
    print_r($user_info);

} else{
    echo "Fehler<br>";
    echo "<pre>";
    print_r($_SESSION);
    print_r($_GET);
//    header('Location: twitter_login.php');
}