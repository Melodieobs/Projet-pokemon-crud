<!-- Réference au supression des pokémons. -->

<?php

require("../conn.php");

if($connexion){
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $userID = $_POST['hidden'];

    $execResult = $connexion->query("DELETE FROM users WHERE user_id = $userID");
    var_dump($execResult);
    header("Location: ./read.php");
    }
    else { ?>
        <h2>Vous n'avez pas l'acces de suppression !</h2>
        <a href="../../../read.php">Page principal</a>
    <?php }
}


?>