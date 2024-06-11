<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
require_once __DIR__.'/vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$usserName = $_ENV['BUSSINESS_EMAIL'];
$key = $_ENV['BUSSINESS_EMAIL_API'];
$support = $_ENV['SUPPORT'];
try{
    require_once __DIR__.'/mailer/vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //! Set the SMTP server to send through, change this
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $usserName;           //SMTP username
    $mail->Password   = $key;                  //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    return $mail;
    exit;
}catch(Exception $e){
    $error = (Object) [
        'success' => false,
        'message' => "something went wrong with our servers, contact our support at $support"
    ];
}
