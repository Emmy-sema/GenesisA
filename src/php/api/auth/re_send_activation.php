<?php
$raw_data = file_get_contents('php://input');
$data = json_decode($raw_data,true);

require_once __DIR__.'/../private/vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if(!isset($data['email'])){
    $wrong = (Object)[
        'success' => false,
        'message' => "No email attached"
    ];
    echo json_encode($wrong);
    exit;
}
$email = filter_var($data['email'],FILTER_VALIDATE_EMAIL);
$baseUrl = $_ENV['BASE_PATH'];
$token = bin2hex(random_bytes(16));
$token_hash = hash('sha256',$token);
$support = $_ENV['SUPPORT'];

if(!$email){
    $invalid = (Object)[
        'success' => false,
        'message' => 'invalid Email address'
    ];
    echo json_encode($wrong);
    exit;
}
require_once __DIR__.'/../../private/dbConnect.php';
$statement = $pdo->prepare("UPDATE users SET email_confirmation_token=:token WHERE email=:email");
$statement->bindValue(':token',$token_hash);
$statement->bindValue(':email',$email);

if($statement->execute()){
        $user = $pdo->prepare("SELECT * FROM users WHERE email=:email");
        $user->bindValue(':email',$email);
        $user->execute();
        $info = $user->fetch();
        require_once __DIR__.'/../../private/sendEmail.php';
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
                <p>Dear ".$info['lastName'].",</p>
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
        Dear".$info['lastName'].",\n\n click the link to Activate your Account:\n\n http://$baseUrl/auth/activation.php?token=$token \n\n. .\n\nIf you have any concerns or did not request this change, please contact our support team immediately at $support\n\nThank you,\nGenesis
        ";
        try{
            $mail->send();
        }catch(Exception $e){
            
            $somethingWentwrong = (object)[
                'success' => false,
                'message' => 'Something went wrong, Activation Email Did not send'
            ];
            echo json_encode($somethingWentwrong);
            exit;
        }
        $newUser = (object)[
            'success' => true,
            'message' => 'Check your email for an activation link'
        ];
        echo json_encode($newUser);
        exit();
}else{
    $somethingWentwrong = (object)[
        'success' => false,
        'message' => 'email address provided is not in our records'
    ];
    echo json_encode($somethingWentwrong);
    exit();
}
?>