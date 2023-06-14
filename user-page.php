<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>user-page</title> 
     <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  </head>
</html> 
    <?
        include("admin/config/config.php");
        session_start ();
        $_SESSION['pass'];
        $_SESSION['name'];
        try{
            $stmt = $connection->prepare("SELECT * FROM user WHERE username=:username");
            $stmt->bindParam(':username', $_SESSION['name']);
            $stmt->execute(); 
            $user = $stmt->fetch();
            $stmt = $connection->prepare("SELECT * FROM user WHERE password=:password");
            $stmt->bindParam(':password', $_SESSION['pass']);
            $stmt->execute(); 
            $pass = $stmt->fetch();
            if ($user and $pass) {
                echo '
                <body>
                    <div class="container">
                    <div class="wrapper">
                        <div class="title"><span>Change Data</span></div>
                        <form method ="post">
                        <div class="row">
                        <i class="fas fa-user"></i>
                            <input type="text" placeholder="Enter new Mail" name="new_mail" required>
                        </div>
                        <div class="row">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="Enter new Username" name="new_username" required>
                        </div>
                        <div class="row">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Enter new Password" name="new_password"required>
                        </div>
                        <div class="pass"><a href="#">Forgot password?</a></div>
                        <div class="row button">
                            <input type="submit" value="Login">
                        </div>
                        <div class="signup-link">No change ?<a href="login.php"> Go to Login</a></div>
                        </form>
                    </div>
                    </div>
                </body>
                ';
                if(isset($_POST['new_mail'], $_POST['new_username'], $_POST['new_password'])){ 
                    $new_mail = $_POST['new_mail'];
                    $new_username = $_POST['new_username'];
                    $new_password = $_POST['new_password'];
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $date = date("Y-m-d H:i:s");
                    $oldname = $_SESSION['name'];
                    $oldpass = $_SESSION['pass'];
                    $stmt = $connection->prepare("SELECT * FROM user WHERE username=:username");
                    $stmt->bindParam(':username', $new_password);
                    $stmt->execute();
                    $user = $stmt->fetch();
                    $stmt = $connection->prepare("SELECT * FROM user WHERE password=:password");
                    $stmt->bindParam(':password', $password);
                    $stmt->execute();
                    $pass = $stmt->fetch();
                    if ($user || $pass) {
                        echo '<script>alert("Mail or Username Already Used");</script>';
                    } else {
                        $codesql = $connection->prepare("INSERT INTO user (mail, username, password, ip, date) VALUES (:mail, :username, :password, :ip, :date)");
                        $codesql->bindParam(':mail', $new_mail);
                        $codesql->bindParam(':username', $new_username);
                        $codesql->bindParam(':password', $new_password);
                        $codesql->bindParam(':ip', $ip);
                        $codesql->bindParam(':date', $date);
                        $codesql->execute();
                        $codesql_supp = $connection->prepare("DELETE FROM `user` WHERE `username` = :oldename");
                        $codesql_supp->bindParam(':oldename', $oldname);
                        $codesql_supp->execute(); 
                        echo '<script>alert("Data Changed !");</script>';
                    }
                }
            }else{
                echo 'Your not registered'.'</br/>';
                echo '<a href="/github/sign-up.php">create an account</a>';
            } 
        }
        catch(PDOException $e){
            echo $e->getMessage();
        } 
        
    ?>
</body>     
</html>