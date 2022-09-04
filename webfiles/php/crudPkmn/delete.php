<!-- Réference au supression des users -->

<?php

require("../conn.php");

if($connexion){
    $userID = $_POST['hidden'];

    $execResult = $connexion->query("DELETE FROM users WHERE user_id = $userID");
    var_dump($execResult);
    header("Location: ../../../../read.php");
}


?>

<a href="./read.php" title="Redirection vers la liste" >Redirection vers la liste !</a>