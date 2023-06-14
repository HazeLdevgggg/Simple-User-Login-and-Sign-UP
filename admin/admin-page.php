<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>admin-page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #457b9d;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            background-color: #1d3557;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #1d3557;
            color: #fff;
        }

        .delete-button {
            background-color: #f44336;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    session_start ();
    $_SESSION['admin_pass'];
    $_SESSION['admin_name'];
    $admin_verif_name = $_SESSION['admin_name'];
    $admin_verif_pass = $_SESSION['admin_pass'];
    $ip = $_SERVER['REMOTE_ADDR'];

    try{
        include("config/admin_table.php");
        $ip = $_SERVER['REMOTE_ADDR'];
        $date = date("Y-m-d H:i:s");
        $stmt = $connection->prepare('SELECT * FROM admin WHERE username=?');
        $stmt->execute([$admin_verif_name]); 
        $user = $stmt->fetch();
        $stmt = $connection->prepare('SELECT * FROM admin WHERE password=?');
        $stmt->execute([$admin_verif_pass]); 
        $pass_bdd = $stmt->fetch();
        if ($user and $pass_bdd){
            echo '<h1>Change Your Admin Password</h1>';
            echo '<form  method="post">
                    <input class ="loginbutton"type="text" placeholder="Change Admin name" name="admin_new_name" required><br/>
                    <input class ="loginbutton"type="password" placeholder="Change Admin password" name="admin_new_pass" required><br/>
                    <button name="login" id ="btn" type="submit">Change</button>
                </form>';    
        }
        else{
            header('Location: http://dev.sport-market.shop/github/login.php');
            exit(); 
        } 
        
    }
    catch(PDOException $e){
        echo $e->getMessage();
    } 
    if(isset($_POST['admin_new_name'], $_POST['admin_new_pass'])){ 
        try{
            include("config/admin_table.php");
            $ip = $_SERVER['REMOTE_ADDR'];
            $date = date("Y-m-d H:i:s");
            $admin_new_name = $_POST['admin_new_name'];
            $admin_new_pass = $_POST['admin_new_pass'];
            $connection = new PDO("mysql:host=$serveur;dbname=sportmarludev",$login, $pass);
            $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $old_admin_name = $_SESSION['admin_name'];
            $codesql = "INSERT INTO admin(username,password, ip, date) VALUES ('$admin_new_name', '$admin_new_pass', '$ip', '$date')";
            $codesql_supp = "DELETE FROM `admin` WHERE `username` = '$old_admin_name'";
            $connection -> exec($codesql_supp);
            $connection -> exec($codesql);
            echo '<script>alert("New Admin Data Saved");</script>';
        }
        catch(PDOException $e){
            echo $e->getMessage();
        } 
    }

    echo '<h1>Add an Admin</h1>';
    echo '<form  method="post">
            <input class ="loginbutton" type="text" placeholder="ADD New admin name" name="add_admin_new_name" required><br/>
            <input class ="loginbutton" type="password" placeholder="ADD New admin pass" name="add_admin_new_pass" required><br/>
            <button name="add" id="btn" type="submit">Add</button>
        </form>';

    if (isset($_POST['add'])) {
        $add_admin_new_name = $_POST['add_admin_new_name'];
        $add_admin_new_pass = $_POST['add_admin_new_pass'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $date = date("Y-m-d H:i:s");
        try {
            include("config/admin_table.php");
            $add = $connection->prepare("INSERT INTO admin (username, password) VALUES (:add_admin_new_name, :add_admin_new_pass)");
            $add->bindParam(':add_admin_new_name', $add_admin_new_name);
            $add->bindParam(':add_admin_new_pass', $add_admin_new_pass);
            $add->execute();
            echo '<script>alert("New Admin Added);</script>';
            echo 'added';
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    try{
        include("config/user_table.php");
        $connection = new PDO("mysql:host=$serveur;dbname=sportmarludev",$login, $pass);
        $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $code = $connection->prepare("SELECT username, id FROM admin");
        $code->execute();
        $info = $code->fetchAll();
        echo '<h1>All user</h1>';
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Username</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($info as $row) {
            echo '<tr>';
            echo '<td>' . $row['username'] . '</td>';
            echo '<td>';
            echo '<form method="POST">';
            echo '<input type="hidden" name="username" value="' . $row['username'] . '">';
            echo '<button type="submit" name="delete">Supprimer</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        if (isset($_POST['delete'])) {
            $username = $_POST['username'];
            try {
                $connection = new PDO("mysql:host=$serveur;dbname=sportmarludev", $login, $pass); // PDO connection
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // PDO Attribute
                $delete = $connection->prepare("DELETE FROM admin WHERE username = :username");
                $delete->bindParam(':username', $username);
                $delete->execute();
                echo '<script>alert("User Deleted");</script>';
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        }
    catch(PDOException $e){
        echo $e->getMessage();
    } 
    try{
       include("config/admin_table.php");
        $newadmin = $connection->prepare("SELECT username, id FROM admin");
        $newadmin->execute();
        $info = $newadmin->fetchAll();
        echo '<h1>All Admin</h1>';
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Username</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($info as $row) {
            echo '<tr>';
            echo '<td>' . $row['username'] . '</td>';
            echo '<td>';
            echo '<form method="POST">';
            echo '<input type="hidden" name="username" value="' . $row['username'] . '">';
            echo '<button type="submit" name="delete">Supprimer</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        if (isset($_POST['delete'])) {
            $username = $_POST['username'];
            try {
                $connection = new PDO("mysql:host=$serveur;dbname=sportmarludev", $login, $pass); // PDO connection
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // PDO Attribute
                $delete = $connection->prepare("DELETE FROM admin WHERE username = :username");
                $delete->bindParam(':username', $username);
                $delete->execute();
                echo '<script>alert("Admin Deleted");</script>';
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        }
    catch(PDOException $e){
        echo $e->getMessage();
    } 

?>
