<!-- Réference au supression des pokémons. -->

<?php

require("../conn.php");

if($connexion){
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        // if($userID == $execResult['user_id'] ){
    $userID = $_POST['hidden'];

    $execResult = $connexion->query("DELETE FROM users WHERE user_id = $userID");
   header("Location: ./read.php");
   var_dump($execResult);
        // }
        // else { ?>
            <!-- <p>Malin le linx mais c'est pas ton compte MDRRR !!</p> -->
        <?php // }
    }
    else { ?>
        <h2>Vous n'avez pas l'acces de suppression !</h2>
        <a href="../../../read.php">Page principal</a>
    <?php }
}


?>