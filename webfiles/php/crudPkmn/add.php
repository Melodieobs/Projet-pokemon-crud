
<?php
//fichier qui permettra d'ajouter des jeux pokemon

require("../conn.php");
require("./formlaire-ajout.php");

if($connexion){

    $pkmn_game_name= $_POST["titre"];
    $pkmn_generation = $_POST["generation"];
    $pkmn_release_date = $_POST["ddesortie"];
    $pkmn_support = $_POST["supportsortie"];
    $pkmn_image = $_POST["url"];

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

        
if(isset($date) && isset($supp) && isset($titre) && isset($generation) && isset($url)){
    $execResult = $connexion->query("INSERT INTO  pokemon_games (pkmn_game_name, pkmn_generation, pkmn_release_date, pkmn_support, pkmn_image) VALUES ('$pkmn_game_name', $pkmn_generation, '$pkmn_release_date', '$pkmn_support', '$pkmn_image')"); ?>

    <a href="../../../read.php" title="Redirection sur la page de tous les utilisateurs">Afficher tous les jeux pokémon</a>
<?php }
else{
    echo "Une erreurs est survenue, il y a des erreurs dans les champs !";
}
    // $execResult = $connexion->query("INSERT INTO pokemon_games (pkmn_game_name,pkmn_generation,pkmn_release_date,pkmn_support) VALUE ('$pkmn_game_name',$pkmn_generation,$pkmn_release_date,'$pkmn_support')");

    // var_dump($pkmn_game_name);
    // Parcours du tableau de résultats (afin d'afficher chaque utilisateur)
//     
}
?>