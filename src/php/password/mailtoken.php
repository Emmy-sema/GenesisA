<?php
require_once __DIR__.'/../private/dbConnect.php';
require_once __DIR__.'/../private/vendor/autoload.php';
use Dotenv\Dotenv;

$email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
if (!$email){
    $error = 'Email address not Valid';
    header('Location:http://localhost:3000/password/forgotpassword.php?message='.$error);
    exit();
}
$support = $_ENV['SUPPORT'];
$token = bin2hex(random_bytes(16));
$expires = date("Y-m-d H:i:s", time()+60*7);
$token_hash = hash('sha256',$token);

$user = $pdo->prepare('SELECT * FROM users WHERE email=:email');
$user->bindValue(':email',$email);
$user->execute();
$user = $user->fetch();

// * checks if user has has provider and a handler

if( !empty($user) && $user['provider'] !== NUll && $user['handler'] == NULL){
    $provider = $user['provider'];
    $message = "Looks like your account was created using $provider as your provider, you can reset your password through Google, if you have any questions contact your support for help at $support";
    header('Location:http://localhost:3000/password/forgotpassword.php?message='.$message);
    exit;
}

$lastName = $user['lastName'];

$statement = $pdo->prepare('UPDATE users SET reset_token = :reset_token,reset_token_expires_at=:reset_token_expires_at WHERE email=:email');
$statement->bindValue(':email',$email);
$statement->bindValue(':reset_token',$token_hash);
$statement->bindValue(':reset_token_expires_at',$expires);
$statement->execute();



$baseUrl = $_ENV['BASE_PATH'];
if($statement->rowCount() > 0){
    $mail = require_once __DIR__.'/../private/sendEmail.php';
    $mail->setFrom('no-reply@genesis.com', 'Genesis');       //! change this
    $mail->addAddress($email);     //! Add a recipient, change this
    
    //Content
    $mail->isHTML(true);                                     //Set email format to HTML
    $mail->Subject = 'Password Reset Request';
    $mail->Body = 
    "
    <html>
    <head>
        <title>Password Reset Request</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                color: #333;
                padding: 20px;
            }
            .container {
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #4CAF50;
            }
            p {
                line-height: 1.6;
            }
            a {
                color: #4CAF50;
                text-decoration: none;
            }
            a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <header>
                <h1>Password Reset Request</h1>
            </header>
            <p>Dear $lastName,</p>
            <p>We received a request to reset your password for your account. If you made this request, please click on the link below to reset your password:</p>
            <p><a href=\"http://$baseUrl/password/passwordResetForm.php?token=$token\">Reset Password</a> You're token will expire in 7 minutes</p>
            <p>If you did not request a password reset, please ignore this email. Your account remains secure, and no changes will be made.</p>
            <p>If you have any concerns or did not request this change, please contact our support team immediately at <a href=\"mailto:$support\">$support</a>.</p>
            <p>Thank you,<br>Genesis</p>
        </div>
    </body>
    </html>
    ";
    $mail->AltBody =
    "
    Dear $lastName,\n\nWe received a request to reset your password for your account. If you made this request, please click on the link below to reset your password:\n\n http://$baseUrl/password/passwordResetForm.php?token=$token \n\nIf you did not request a password reset, please ignore this email. Your account remains secure, and no changes will be made.\n\nIf you have any concerns or did not request this change, please contact our support team immediately at $support\n\nThank you,\nGenesis
    ";
    try{
        $mail->send();
    }catch(Exception $e){
        
        $message = 'Something went wrong please try again later, if the problem persists, contact us at'.$support;
        header('Location:http://localhost:3000/password/forgotpassword.php?message='.$message);
    }
}
$message = 'Thank you! If the email address you entered is associated with an account,
        you will receive an email with instructions on how to reset your password shortly. 
        Please check your inbox and spam/junk folders. If you do not receive an email, 
        please verify the address you provided and try again.';
$url=str_replace(PHP_EOL, '', "Location:http://$baseUrl/password/success.php?message=$message");
header($url);
exit();


