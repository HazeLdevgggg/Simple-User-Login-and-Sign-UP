<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>user-page</title> 
     <link rel="stylesheet" href="assets/style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  </head>
</html>     
<?

        echo '<body>
                    <div class="container">
                    <div class="wrapper">
                        <div class="title"><span>Admin Login</span></div>
                        <form method ="post">
                        <div class="row">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="Admin Username" name="admin_name" required>
                        </div>
                        <div class="row">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Admin Password" name="admin_pass"required>
                        </div>
                        <div class="pass"><a href="#">Forgot password?</a></div>
                        <div class="row button">
                            <input type="submit" value="Login">
                        </div>
                        <div class="signup-link">Not a member? <a href="sign-up.php">Signup now</a></div>
                        </form>
                    </div>
                    </div>
                </body>
            ';


    if(isset($_POST['admin_name'], $_POST['admin_pass'])){ 
            try{
                include("config/config.php");
                $connection = new PDO("mysql:host=$serveur;dbname=sportmarludev",$login, $pass);
                $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $connection->prepare("SELECT * FROM admin  WHERE username=:admin_name");
                $stmt->bindParam(':admin_name',$_POST['admin_name']);
                $stmt->execute(); 
                $user = $stmt->fetch();
                $stmt = $connection->prepare("SELECT * FROM admin WHERE password=:admin_pass");
                $stmt->bindParam(':admin_pass',$_POST['admin_pass']);
                $stmt->execute(); 
                $pass = $stmt->fetch();
                if ($user and $pass) {
                    session_start ();
                    $_SESSION['admin_pass'] = $_POST['admin_pass'];
                    $_SESSION['admin_name'] = $_POST['admin_name'];
                    header('Location: http://dev.sport-market.shop/github/admin/admin-page.php');
                    exit(); 
                }else{
                    echo 'password or username invalid';
                } 
            }
            catch(PDOException $e){
                echo $e->getMessage();
            } 
        }

          
    
?>
</body>     
</html>