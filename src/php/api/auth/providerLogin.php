<?php

if(!isset($_POST['firstName'])){
    header('Location:http://localhost:4200');
    exit;
}
// check if account exist
$email = $_POST['email'];
$fName = $_POST['firstName'];
$lName = $_POST['lastName'];
$provider = $_POST['provider'];
$photoUrl = $_POST['photoUrl'];

require_once __DIR__.'/../../private/dbConnect.php';
$checkUser = $pdo->prepare('SELECT * FROM users WHERE email=:email');
$checkUser->bindValue(':email',$email);
$checkUser->execute();
$possibleUser = $checkUser->fetch();


if(empty($possibleUser)){
    // ! account does not exist
    $addUser = $pdo->prepare("INSERT INTO users (firstName,lastName,email,provider,active,handler,photoUrl) VALUES(:firstName,:lastName,:email,:provider,:active,:handler,:photoUrl)");
    $addUser->bindValue(':firstName',$fName);
    $addUser->bindValue(':lastName',$lName);
    $addUser->bindvalue(':email',$email);
    $addUser->bindValue(':provider',$provider);    
    $addUser->bindValue(':active',true);
    $addUser->bindValue(':handler',NULL);
    $addUser->bindValue(':photoUrl',$photoUrl);

    $addUser->execute();

    
    if($addUser->rowCount() > 0){
        start_session($possibleUser);
        exit;
    }else{
        $wrong = (Object) [
            'success' => false,
            'message' => 'Something went wrong, please try again later'
        ];
        echo json_encode($wrong);
        exit;
    }
}else{
    //* user exists
    if($possibleUser['provider'] == NULL){
        //* user exists without a provider
    
        $message = (Object)[
            'success' => false,
            'provider' => false,
            'message' => 'An account already exist with this email, but is not paired with the provider used'
        ];
        echo json_encode($message);
        exit;
    }else if($possibleUser['provider'] == $provider){
        //* user exists and the provider is the same as the provider presented
        start_session($possibleUser);
        exit;
    }else{
        $message = (Object)[
            'success' => false,
            'provider' => false,
            'message' => 'An account already exist with this email, but is not paired with the provider used'
        ];
        echo json_encode($message);
        exit;
    }

}


function start_session($user){
    try{
        require_once __DIR__.'/../../private/session_config.php';
        $_SESSION['userId'] = $user['pin'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['link'] = '/user';
        $info = (object)[
            'success' => true,
            'message' => 'you are logged in',
            'csrf_token' => $_SESSION['csrf_token'],
            'userId' => $_SESSION['userId'],
            'email' => $_SESSION['email'],
            'name' => $user['lastName'],
        ];
        echo json_encode($info);
        exit;
    }catch(Exception $e){
        // session error
        $db_error = (Object)[
            'success' => false,
            'message' => 'something went wrong'
        ];
        echo json_encode($dbError);
        exit;
    }
}
?>