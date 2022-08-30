<!-- Réference au supression des pokémons. -->

<?php

require("./conn.php");

if($connexion){
    $userID = $_POST['hidden'];

    $execResult = $connexion->query("DELETE FROM users WHERE user_id = $userID");
    var_dump($execResult);
}


?>

<a href="./read.php" title="Redirection vers la liste" >Redirection vers la liste !</a>