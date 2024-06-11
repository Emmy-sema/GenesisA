<?php
include_once('./header.php');
if(isset($_GET['message'])){
    $message = htmlspecialchars($_GET['message']);
}else{
    header("Location:Location:http://localhost:3000/passwordReset/forgotpassword.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
</head>
<style>
    *{
        box-sizing:border-box;
        padding:0rem;
        margin:0rem;
    }
    body{
        background:#0D081C;
        .success{
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
        body .success{
            width:100% !important;
            margin:5rem 0rem 0rem 0rem;
        }
        
    }
</style>
<body>
    <div class="success">
        <h1>Success !</h1>
        <div>
            <?php echo  $message;?>
        </div>
    </div>    
</body>
</html>