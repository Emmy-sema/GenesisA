<?php
// ! more options for  special characters
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pwd']) && isset($_POST['pwdB']) && isset($_POST['token'])){
    $password = $_POST['pwd'];
    $passwordB = $_POST['pwdB'];
    $token =  $_POST['token'];
    $error = "Passwords should be 8 characters long with 1 uppercase 1 lower case 1 special character and 1 number and must match";
    if($password == $passwordB && preg_match('/[a-z]/',$password) && preg_match('/[A-Z]/',$password) && preg_match('/[0-9]/',$password) && preg_match('/[!@#$%^&*()?]/',$password)){
        require_once __DIR__.'/../private/dbConnect.php';
        $token_hash = hash('sha256',$_POST['token']);
        $password_hash = password_hash($password,PASSWORD_DEFAULT);

        $stm = $pdo->prepare('SELECT * FROM users WHERE reset_token=:token');
        $stm->bindValue(':token',$token_hash);
        $stm->execute();
        $user = $stm->fetch();
        // check if the current password is equal to the previous password
      
        if($user == null){
           header('Location:http://localhost:3000/password/forgotpassword.php?message=Invalid Token');
           exit();
        }else if(strtotime($user['reset_token_expires_at']) <= time()){
            header('Location:http://localhost:3000/password/forgotpassword.php?message=Token has expired');
            exit();
        }else if(strtotime($user['reset_token_expires_at']) >= time()){
            if(password_verify($password,$user['pwd'])){
                header("Location:http://localhost:3000/password/passwordResetForm.php?token=$token&message=Password cannot be same as last password");
                exit();
            }
            $statement = $pdo->prepare('UPDATE users SET pwd=:pass,reset_token=NULL,reset_token_expires_at=NULL WHERE reset_token=:token');
            $statement->bindValue(':pass',$password_hash);
            $statement->bindValue(':token',$token_hash);

            $statement->execute();

            header("Location:http://localhost:3000/password/success.php?message=Your password has successsfully Been reset!");
            exit();
        }
    }else{
        header("Location:http://localhost:3000/password/passwordResetForm.php?token=$token&message=$error");
        exit();
    }

}else{
    header('Location:http://localhost:3000/password/forgotpassword.php');
    exit();
}

?>