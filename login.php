<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Login</title> 
     <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  </head>
  <body>
    <div class="container">
      <div class="wrapper">
        <div class="title"><span>Login</span></div>
        <form method ="post">
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Username" name="login_username" required>
          </div>
          <div class="row">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="login_password"required>
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
</html>

<?
    if (isset($_POST['login_username'], $_POST['login_password'])) {
        $login_username = $_POST['login_username'];
        $login_password = $_POST['login_password'];
        try {
            include("admin/config/config.php");
            $stmt = $connection->prepare("SELECT * FROM user WHERE username=:login_username");
            $stmt->bindParam(':login_username', $login_username);
            $stmt->execute();
            $user = $stmt->fetch();
            $stmt = $connection->prepare("SELECT * FROM user WHERE password=:login_password");
            $stmt->bindParam(':login_password', $login_password);
            $stmt->execute();
            $pass_bdd = $stmt->fetch();
            if ($user && $pass_bdd) {
                session_start();
                $_SESSION['pass'] = $_POST['login_password'];
                $_SESSION['name'] = $_POST['login_username'];
                header('Location: http://dev.sport-market.shop/github/user-page.php');
                exit();
            } else {
              echo '<script>alert("bad password or username");</script>';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }    
?>