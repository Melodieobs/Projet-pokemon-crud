<?php

require("./jeuxPok/conn.php");

$paterne = '/^[A-Za-z1-2\s&]+$/';
$paterne2 = '/^[0-9]+$/';
$tabval = [];

//$remplaceGame_Name= str_ireplace( "é","e",$pkmn_game_name);

if($connexion){   
        foreach($_POST as $fields => $value){
            array_push($tabval, $value);

            var_dump($tabval);                
            if($fields === "generation"){
                $value = trim(ucfirst($value));
                if(empty($value)){
                    echo $errGen = "Le champs génération n'est pas remplis";
                }
                elseif(preg_match("$paterne2", $value)){
                    echo $errGen = "erreur il n'y a que 8 génération";
                }
                else{
                    $generation = $value;
                }
            }
            if($fields === "titre"){
                if(empty($value)){
                    echo $errTitre = "Le champs titre n'as pas était remplis";
                }
                elseif(!preg_match("$paterne", $value)){
                    echo $errTitre = "La titre saisie n'est pas bonne.";
                    var_dump(!preg_match("$paterne", $value));
                }
                else{
                    $titre = $value;
                }
            }
            if($fields === "supportsortie"){
                if(empty($value)){
                    echo $errSuppSortie = "Le champ date de sorti n'as pas était remplis";
                }
                elseif(!preg_match("$paterne", $value)){
                    echo $errSuppSortie = "La valeur du support n'est pas bonne.";
                    var_dump(!preg_match("$paterne", $value));
                }
                else{
                    $supp = $value;
                }
            }
            if($fields === "ddesortie"){
                if($value > date("Y-m-d")){
                    echo $errDate = "La date saisie n'est pas bonne" ;
                }
                else{
                    $date = $value;
                }
            }
        }
        if($date && $supp && $titre && $generation){
            $execResult = $connexion->query("INSERT INTO pokemon_games (pkmn_game_name,pkmn_generation,pkmn_release_date,pkmn_support) VALUES ('$titre',$generation, '$date', '$supp')");          
    }
        else{
            echo "Une erreurs est survenue, il y a des erreurs dans les champs";
        }
}

?>


    <form method="POST" action="./add.php">
<div>
    <label for="titre-poke-jeux">Titre de jeux pokémon: </label>
    <input type="text" name="titre-poke-jeux" id="titre-de-jeux" <?php if(isset($execResult)){ echo ["titre-poke-jeux"];} ?>>
</div>

<div>
    <label for="generation">Génération: </label>
    <input type="number" name="generation" id="gener" <?php if(isset($execResult)){ echo $execResult[0]["generation"];} ?>>
</div>

<div>
    <label for="d-de-sortie">Date de sortie Européenne : </label>
    <input type="date" name="d-de-sortie" id="date-de-sortie" <?php if(isset($execResult)){ echo $execResult[0]["d-de-sortie"];} ?>>
</div>

<div>
    <label for="support-de-sortie">Support de sortie : </label>
    <input type="text" name="support-sortie" id="supp-sortie" <?php if(isset($execResult)){ echo $$execResult[0]["support-sortie"];} ?>>
</div>

<input type="submit" value="Ajouter">
</form>


<a href="./jeuxPok/read.php" title="Redirection sur la page de tous les utilisateurs">Afficher tous les jeux pokémon</a>
