<?
    $serveur = "//"; // server name for php my admin
    $login = "//";  // login name for php my admin
    $pass = "//"; // password name for php my admin
    $dbanme = "//"; // password name for php my admin
    $connection = new PDO("mysql:host=$serveur;dbname=$dbname",$login, $pass); // PDO connection
    $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // PDO Attribute
?>
