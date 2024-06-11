<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");



$failed = (object)[
    'success' => false,
    'message' => 'Username or password is incorrect'
];
$dbError = (object)[
    'success' => false,
    'message' => 'Something went wrong please try again later'
];

$password = $_POST['password'];
$hash = password_hash($password, PASSWORD_DEFAULT);
$email =  $_POST['email'];
//* check if posted data acutally has text
if(!isset($_POST['password'])){
    echo json_encode($failed);
    exit;
}

//* validate email
if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo json_encode($failed);
    exit;
}


//* check for user in db

require_once __DIR__.'/../../private/dbConnect.php';

$statement = $pdo->prepare('SELECT * FROM users WHERE email=:email');
$statement->bindValue(':email',$email);
$statement->execute();
$user = $statement->fetch();


$passed = (object)[
    'success' => true,
    'message' => 'Your Logged In'
];

if(empty($user)){
    echo json_encode($failed);
    exit;
}

if(password_verify($password,$user['pwd'])){
    if(password_needs_rehash($user['pwd'],PASSWORD_DEFAULT)){
        $password_new_hash = password_hash($password,PASSWORD_DEFAULT);
        $newhash = $pdo->prepare("UPDATE users SET pwd=:new_password_hash WHERE password=:old_password_hash");
        $newhash->bindValue(':new_password_hash',$password_new_hash);
        $newhash->bindValue(':old_password_hash',$user['pwd']);
        $statement->execute();
    }
    try{
        require_once __DIR__.'/../../private/session_config.php';
        $_SESSION['userId'] = $user['pin'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['link'] = '/user';
        $user = (object)[
            'success' => true,
            'message' => 'you are logged in',
            'csrf_token' => $_SESSION['csrf_token'],
            'userId' => $_SESSION['userId'],
            'email' => $_SESSION['email'],
            'name' => $user['lastName'],
        ];
        echo json_encode($user);
    }catch(Exception $e){
        // session error
        echo json_encode($dbError);
        exit;
    }
    
}else{
    echo json_encode($failed);
    exit;
}
?>