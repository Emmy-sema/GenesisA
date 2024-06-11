<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    html,body{
        border:border-box;
        padding:0rem;
        margin:0rem;
    }
    nav{
        background:#362B57;
        color:white;
        padding:1.5rem;
        display:flex;
        justify-content:space-around;
        text-transform:uppercase;
        div:hover{
            cursor: pointer;
        }
        .return{
            color:white;
            text-decoration:none;
        }
    }
</style>
<body>
    <nav>
        <div class="logo">Genesis</div>
        <a class="return" href='http://localhost:4200/login'>return to login</a>
    </nav>
</body>
</html>