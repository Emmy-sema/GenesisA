<?php

session_start();

if(isset($_GET['csrf_token']) && isset($_SESSION['csrf_token']) && $_GET['csrf_token'] == $_SESSION['csrf_token']){
    require_once __DIR__.'/../../private/dbConnect.php';
    $statement = $pdo->prepare('SELECT pin,firstName,lastName,email,number,provider,locked FROM users WHERE email=:email');
    $statement->bindValue(':email',$_SESSION['email']);
    $statement->execute();
    $user = $statement->fetch();
    $user = (object)[
        'success' => true,
        'message' => 'logged in',
        'info' => $user,
    ];
    echo json_encode($user);
    exit;
    
}else{
    $failed = (object)[
        'success' => false,
        'message' => 'Invalid',
    ];
    // $fileName = '/../../error.txt';
    // $file = fopen($filename,'a');
    // fwrite($file,'CSRF attempted');
    // fclose($file);
    echo json_encode($failed);
    exit;
}
