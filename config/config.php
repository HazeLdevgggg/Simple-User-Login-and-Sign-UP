<?
    $serveur = "sportmarludev.mysql.db"; // server name for php my admin
    $login = "sportmarludev";  // login name for php my admin
    $pass = "DevMadein34"; // password name for php my admin
    $connection = new PDO("mysql:host=$serveur;dbname=sportmarludev",$login, $pass); // PDO connection
    $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // PDO Attribute
?>
