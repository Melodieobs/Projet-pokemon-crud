<!-- Réference au supression des users -->

<?php

require("../conn.php");

if($connexion){
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $pkmnID = $_POST['hiddenField'];

    $execResult = $connexion->query("DELETE FROM pokemon_games WHERE pkmn_id = $pkmnID");
    var_dump($execResult);
    header("Location: ../../../../read.php");
}
else { ?>
    <h2>Vous n'avez pas l'acces de suppression !</h2>
    <a href="../../../read.php">Page principal</a>
<?php }
}



?>