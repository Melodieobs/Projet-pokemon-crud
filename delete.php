<!-- Réference au supression des pokémons. -->

<?php

require("./conn.php");

if($connexion){
    $pokmnId = $_POST['hiddenField'];

    $execResult = $connexion->query("DELETE FROM pokemon_games WHERE pkmn_id = $pokmnId");
    var_dump($execResult);
}


?>

<a href="./read.php" title="Redirection vers la liste" >Redirection vers la liste !</a>