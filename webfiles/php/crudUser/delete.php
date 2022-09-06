<!-- Réference au supression des pokémons. -->

<?php

require("../conn.php");

if($connexion){
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $userID = $_POST['hidden'];
        if($userID == $_SESSION["id"]){
    

    $execResult = $connexion->query("DELETE FROM users WHERE user_id = $userID");
    header("Location: ./read.php");
         }
     else { ?>
            <p>Malin le lynx mais ce n'est pas ton compte MDRRR!!</p> 
            <p>Aller respect les autres, est supprime le tien tu n'es que honte de ton existence !! <a href="./read.php" title="Les personnes comme toi ne sont pas faites pour être ici">Supprime TON COMPTE !</a> </p> 
        <?php  }
    }
    else { ?>
        <h2>Vous n'avez pas l'acces de suppression !</h2>
        <a href="../../../read.php">Page principal</a>
    <?php }
}


?>