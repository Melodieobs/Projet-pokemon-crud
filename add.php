
<?php
//fichier qui permettra d'ajouter des jeux pokemon

require("./jeuxPok/conn.php");

if($connexion){

    $pkmn_game_name= $_POST["titre-poke-jeux"];
    $pkmn_generation = $_POST["generation"];
    $pkmn_release_date = $_POST["d-de-sortie"];
    $pkmn_support = $_POST["support-sortie"];

    $execResult = $connexion->query("CREATE DATABASE IF NOT EXISTS 'pokemon-crud'");

    $execResult = $connexion->query("CREATE TABLE IF NOT EXISTS 'pokemon_games'(
        'pkmn_id' bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        'pkmn_game_name' varchar(255) DEFAULT NULL,
        'pkmn_generation' int(11) DEFAULT NULL,
        'pkmn_release_date' DATE DEFAULT NULL,
        'pkmn_support' varchar(255) DEFAULT NULL,
        'pkmn_image' varchar(255) DEFAULT NULL,
        PRIMARY KEY ('pkmn_id'),
        UNIQUE KEY 'pkmn_id' ('pkmn_id'))");

        

    // $execResult = $connexion->query("INSERT INTO pokemon_games (pkmn_game_name,pkmn_generation,pkmn_release_date,pkmn_support) VALUE ('$pkmn_game_name',$pkmn_generation,$pkmn_release_date,'$pkmn_support')");

    // var_dump($pkmn_game_name);
    // Parcours du tableau de résultats (afin d'afficher chaque utilisateur)
//     
}
?>
<a href="./jeuxPok/read.php" title="Redirection sur la page de tous les utilisateurs">Afficher tous les jeux pokémon</a>