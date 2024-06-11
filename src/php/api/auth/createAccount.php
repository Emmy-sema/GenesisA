<?php
require_once __DIR__.'/../../dbConnect.php';
require_once __DIR__.'/../private/vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if(!isset($_POST['firstName'])){
    header('Location:http://localhost:4200');
    exit();
}
$password = $_POST['password'];
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$lastName = $_POST['lastName'];
$firstName = $_POST['firstName'];
$number = $_POST['number'];
$email = $_POST['email'];
$baseUrl = $_ENV['BASE_PATH'];
$invalid =(object)[
    'success'=>false,
    'message'=>'Invalid email'
];
if(!filter_var($email,FILTER_VALIDATE_EMAIL) || empty($email)){
    echo json_encode($invalid);
    exit();
}

$checkIfExist = $pdo->prepare('SELECT * FROM users WHERE email=:email');
$checkIfExist->bindValue('email',$email);
$checkIfExist->execute();
$possibleUser = $checkIfExist->fetchAll();
$token = bin2hex(random_bytes(16));
$token_hash = hash('sha256',$token);
$support = $_ENV['SUPPORT'];
if(!empty($possibleUser)){
    $taken = (object)[
        'success'=> false,
        'message' => 'This email is associated with a different account,Please chose a different email'
    ];
    echo json_encode($taken);
    exit();
}else{
    $addUser = $pdo->prepare("INSERT INTO users (firstName,lastName,pwd,email,number,email_confirmation_token) VALUES(:fName,:lName,:pwd,:email,:number,:email_confirmation_token)");
    $addUser->bindValue(':fName',$firstName);
    $addUser->bindValue(':lName',$lastName);
    $addUser->bindValue(':pwd',$password_hash);
    $addUser->bindValue(':email',$email);
    $addUser->bindValue(':number',$number);
    $addUser->bindValue(':email_confirmation_token',$token_hash);
    $addUser->execute();
    if($addUser->rowCount() > 0){
        require_once __DIR__.'/../../sendEmail.php';
        
        $mail->setFrom('no-reply@genesis.com', 'Genesis');       //! change this
        $mail->addAddress($email); 
        $mail->isHTML(true);                                     //Set email format to HTML
        $mail->Subject = 'Comfirm Your Account'; 
        $mail->Body = 
        " 
        <html>
        <head>
            <title>Comfirm Your Account</title>
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
                    <h1>Comfirm Your Account</h1>
                </header>
                <p>Dear ".$lastName.",</p>
                <p>Thank you for creating an account with Genesis!</p>
                <p><a href=\"http://$baseUrl/api/activation.php?token=$token\">Activate Account</a></p>
                <p>If you did not create an account with us, please ignore this email.</p>
                <p>If you have any concerns, please contact our support team immediately at <a href=\"mailto:$support\">$support</a>.</p>
                <p>Thank you,<br>Genesis</p>
            </div>
        </body>
        </html>";
        $mail->AltBody =
        "
        Dear $lastName,\n\n click the link to Activate your Account:\n\n http://$baseUrl/auth/activation.php?token=$token \n\n. .\n\nIf you have any concerns or did not request this change, please contact our support team immediately at $support\n\nThank you,\nGenesis
        ";
        try{
            $mail->send();
        }catch(Exception $e){
            $somethingWentwrong = (object)[
                'success' => false,
                'message' => 'Something went wrong email with confirmation did not send'
            ];
            echo json_encode($somethingWentwrong);
            exit();
        }
        $newUser = (object)[
            'success' => true,
            'message' => 'Confirm your email'
        ];
        echo json_encode($newUser);
        exit();
    }else{
        $somethingWentwrong = (object)[
            'success' => false,
            'message' => 'Something went wrong,Please try again later'
        ];
        echo json_encode($somethingWentwrong);
        exit();
    }
}
?>