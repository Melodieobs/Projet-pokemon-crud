<!-- Réference au supression des users -->

<?php

require("../conn.php");

if($connexion){
    $pkmnID = $_POST['hiddenField'];

    $execResult = $connexion->query("DELETE FROM pokemon_games WHERE pkmn_id = $pkmnID");
    var_dump($execResult);
    header("Location: ../../../../read.php");
}


?>