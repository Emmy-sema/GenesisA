<?php
include_once("./header.php");
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['message'])){
    $error = htmlspecialchars($_GET['message']);
?>
<div style="text-align:center; color:red;margin:1rem auto; width:400px;"> <?php echo $error ?></div>

<?php } ?>
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
        input[type=text]{
            width: 200px;
            height: 30px;
            margin-top:1rem;
        }
        input{
            padding-left:1rem;
            border: border-box;
        }
    }
</style>
<body>
    <div class='form'>
    <h1>Forgot password</h1>
        <form action="mailtoken.php" method="POST">
            <label for="email">Email:</label>
            <input type="text" name="email" placeholder="example@gmail.com" required>
            <button type="submit">Send</button>
        </form>
    </div>
    
</body>
</html>