<?php
    include_once("./header.php");

    if(isset($_GET['token'])){
        require_once __DIR__.'/../private/dbConnect.php';
        
        $token_hash = hash('sha256',$_GET['token']);
        $stm = $pdo->prepare('SELECT * FROM users WHERE reset_token=:token');
        $stm->bindValue(':token',$token_hash);
        $stm->execute();
        $user = $stm->fetch();

        if($user == null){
           header('Location:http://localhost:3000/password/forgotpassword.php?message=Invalid Token');
           exit();
        }else if(strtotime($user['reset_token_expires_at']) <= time()){
            header('Location:http://localhost:3000/password/forgotpassword.php?message=Token has expired');
            exit();
        }
        
    }else{
        header('Location:http://localhost:3000/password/forgotpassword.php?');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>forgot password</title>
</head>
<style>
    /* *{
        box-sizing:border-box;
        padding:0rem;
        margin:0rem;
    } */
    body{
        background:#0D081C;
    }
    .form{
        display:block;
        justify-content:center;
        margin:4rem auto;
        width:fit-content;
    }
    h1{
        color:white;
    }
    form{
        color:black;
        background: white;
        padding:2rem;
        display: grid;
        grid-template: auto;
        width:fit-content;
        border-radius:7px ;
        label,input,button{
            margin-top:1rem;
        }
 
        button{
            margin-top:3rem;
            border-radius: 8px;
            width:217px;
            height: 45px;
            background-color: black;
            border:transparent;
            cursor: pointer;
            color: white;
        }
        input[type=password]{
            width: 200px;
            height: 30px;
            margin-top:1rem;
        }
        input::placeholder{
            font-size: 20px;
        }
        input{
            padding-left:1rem;
            border: border-box;

        }
    }
</style>
<body>
    <div class='form'>
    <?php
        if(isset($_GET['message'])){
            $error = htmlspecialchars($_GET['message']);
    ?>
    <div style="text-align:center; color:red;width:300px;text-align:left;"> <?php echo $error ?></div>
    <?php } ?>

    <h1>Reset Password</h1>
        <form action="processReset.php" method="POST" id="reset">
            <label for="password">passwod:</label>
            <input type="password" name="pwd" placeholder="........" required minlength = "8">
            <input type="password" name="pwdB" placeholder="........" required minlength = "8">
            <input type="hidden" name='token' value = <?php echo $_GET['token']?>>
            <button type="submit">Reset</button>
        </form>
    </div>
    
</body>

</html>