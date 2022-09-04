<?php 

    // Fichier permettant d'établir la connexion à la base de données //
    // Sont éventuellement à changer la valeur des variables : $hote, $user, $pass et $dbname //

    $hote = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "pokemon-crud";

    $connexion = new PDO("mysql:host=$hote; dbname=$dbname", $user, $pass);
?>