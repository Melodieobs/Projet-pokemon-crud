<?php

require("./jeuxPok/conn.php");

$paterne = '/^[A-Za-z1-2\s&]+$/';
$paterne2 = '/^[0-9]+$/';
$tabval = [];

//$remplaceGame_Name= str_ireplace( "é","e",$pkmn_game_name);


if($connexion){ 
      
    foreach($_POST as $fields => $value){
        array_push($tabval, $value);

        // var_dump($tabval);                
        if($fields === "generation"){
            $value = trim(ucfirst($value));
            if(empty($value)){
                echo $errGen = "Le champs génération n'est pas remplis\n\n";
            }
            elseif($value == 9){
                echo $errGen = "Désolé pour toi cette génération sort le 18/novembre/2022 ! ";
            }
            elseif($value > 8){
                echo $errGen = "erreur il n'y a que 8 génération\n\n";
            }
            else{
                $generation = $value;
            }
        }
        if($fields === "titre"){
            if(empty($value)){
                echo $errTitre = "Le champs titre n'as pas était remplis.\n\n";
            }
            elseif(!preg_match("$paterne", $value)){
                echo $errTitre = "La titre saisie n'est pas bonne.\n\n";
            }
            else{
                $titre = $value;
            }
        }
        if($fields === "supportsortie"){
            if(empty($value)){
                echo $errSuppSortie = "Le champ date de sorti n'as pas était remplis.\n\n";
            }
            elseif(!preg_match("$paterne", $value)){
                echo $errSuppSortie = "La valeur du support n'est pas bonne.\n\n";
            }
            else{
                $supp = $value;
            }
        }
        if($fields === "ddesortie"){
            if($value > date("Y-m-d")){
                echo $errDate = "La date saisie n'est pas bonne.\n\n" ;
            }
            else{
                $date = $value;
            }
        }
    }
}

?>


    <form method="POST" action="./add.php">
<div>
    <label for="titre-poke-jeux">Titre de jeux pokémon: </label>
    <input type="text" name="titre" id="titre-de-jeux" <?php if(isset($execResult)){ echo ["titre-poke-jeux"];} ?>>
</div>

<div>
    <label for="generation">Génération: </label>
    <input type="number" name="generation" id="gener" <?php if(isset($execResult)){ echo $execResult[0]["generation"];} ?>>
</div>

<div>
    <label for="d-de-sortie">Date de sortie Européenne : </label>
    <input type="date" name="ddesortie" id="ddsortie" <?php if(isset($execResult)){ echo $execResult[0]["d-de-sortie"];} ?>>
</div>

<div>
    <label for="support-de-sortie">Support de sortie : </label>
    <input type="text" name="supportsortie" id="supp-sortie" <?php if(isset($execResult)){ echo $$execResult[0]["support-sortie"];} ?>>
</div>

<input type="submit" value="Ajouter">
</form>