<!DOCTYPE html>   
<html>   
<head>  
    <? include("assets/include/favicon.php")?>
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <title>LOGIN</title>  
</head>    
<body>    
    <h1>LOGIN</h1> 
    <form  method="post">
        <input class ="loginbutton"type="text" placeholder="Enter Username or Mail" name="login_username" required><br/>
        <input class ="loginbutton"type="password" placeholder="Enter password" name="login_password" required><br/>
        <button name="login" id ="btn" type="submit">Login</button>
        <a href="testzone.php">create an account</a>
    </form>
    <?
        if(isset($_POST['login_username'], $_POST['login_password'])){ 
            $login_username = $_POST['login_username'];
            $login_password = $_POST['login_password'];
        }
    ?>
</body>     
</html>
