<?php
require_once __DIR__.'/../password/header.php';

if(isset($_GET['token'])){
    require_once __DIR__.'/../private/dbConnect.php';

    $token = $_GET['token'];
    $token_hash= hash('sha256',$token);

    
    $stm = $pdo->prepare('SELECT * FROM users WHERE email_confirmation_token=:token');
    $stm->bindValue(':token',$token_hash);
    $stm->execute();
    $user = $stm->fetch();
    if($user == NULL){
        echo "<!DOCTYPE html>
        <head>
            <title>Error</title>
        </head>
        <style>
            *{
                box-sizing:border-box;
                padding:0rem;
                margin:0rem;
            }
            body{
                background:#0D081C;
                .error{
                    line-height:1.6;
                    color:black;
                    background: white;
                    padding:2rem;
                    display: grid;
                    width:400px;
                    margin:3rem auto;
                }
            }
            h1{
                color:red;
            }
            @media only screen and (max-width:450px){
                body .error{
                    width:100% !important;
                    margin:5rem 0rem 0rem 0rem;
                }
                
            }
        </style>
        <body>
            <div class='error'>
                <h1>Error !</h1>
                <div>
                    Could not find your account!,
                    
                    Contact Support For Help at alohsema@gmail.com
                </div>
            </div>    
            </div>    
        </body>
        </html>";
        exit();
    }
    $update = $pdo->prepare('UPDATE users SET email_confirmation_token=NULL,active=1 WHERE  email_confirmation_token=:email_confirmation_token');
    $update->bindValue(':email_confirmation_token',$token_hash);
    
    if ($update->execute()){
        echo "<!DOCTYPE html>
        <head>
            <title>Error</title>
        </head>
        <style>
            *{
                box-sizing:border-box;
                padding:0rem;
                margin:0rem;
            }
            body{
                background:#0D081C;
                .error{
                    line-height:1.6;
                    color:black;
                    background: white;
                    padding:2rem;
                    display: grid;
                    width:400px;
                    margin:3rem auto;
                }
            }
            h1{
                color:green;
            }
            @media only screen and (max-width:450px){
                body .error{
                    width:100% !important;
                    margin:5rem 0rem 0rem 0rem;
                }
                
            }
        </style>
        <body>
            <div class='error'>
                <h1>Success</h1>
                <div>
                    Your account has been Activated, Please go to <a href='http://localhost:4200/login'>Login</a> and Login
                    
                    Contact Support For Help at alohsema@gmail.com
                </div>
            </div>    
            </div>    
        </body>
        </html>";
        exit();
    }
}
header('Location:http://localhost:4200');
exit();
?>