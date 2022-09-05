<?php

require("../conn.php");

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
        if($fields === "url"){
            if(filter_var($value, FILTER_VALIDATE_URL)){
                $url = $value;
            }
            else{
                echo $errUrl = "J'ai bien l'impression que cela n'est pas un url !";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Formulaire d'ajout des jeux de pokemon">
    <title>Formulaire d'ajout pokemon</title>
</head>
<body>
    
    <form method="POST" action="./add.php" Enctype="">
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
    <input type="text" name="supportsortie" id="supp-sortie" <?php if(isset($execResult)){ echo $execResult[0]["support-sortie"];} ?>>
</div>
<div>
    <input type="URL" name="url" <?php if(isset($execResult)){echo $execResult[0]['url'];}?>>
</div>
<input type="submit" value="Ajouter">

</body>
</html>
</form>