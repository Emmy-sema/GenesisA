<?php
include_once('./header.php');
if(isset($_GET['message'])){
    $message = htmlspecialchars($_GET['messsage']);
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
    <div class="error">
        <h1>Error !</h1>
        <div>
            <?php echo  $message;?>
        </div>
    </div>    
    </div>    
</body>
</html>