<?php

ini_set('session.use_only_cookies',1);
ini_set('session.use_strict_mode',1);
ini_set('session.cookie_httponly',1);

//! change from 15 minutes to 30 minutes
$time = 900;
$domain = 'localhost';
session_set_cookie_params([
    'lifetime' => $time,
    'domain' => $domain,
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

session_start();

if(!isset($_SESSION['last_regeneration'])){
    regenerate_session_id();
} else{
    $interval = 60*30;
    if(time()-$_SESSION['last_regeneration'] >= $interval){
        regenerate_session_id();
    }
}

function regenerate_session_id(){
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
