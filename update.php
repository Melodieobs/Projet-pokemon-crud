<!-- Référence au modification pokémon. -->
 
<?php 

    require("./conn.php");

    $paterne = '/^[A-Za-z1-2\s&]+$/';
    $paterne2 = '/^[0-9]+$/';
    $tabval = [];

    //$remplaceGame_Name= str_ireplace( "é","e",$pkmn_game_name);

    if($connexion){
        if($_GET && $_GET["pkmn_id"]){
            
            $pkmnId = $_GET["pkmn_id"];
            //On selection tout de la table pokemon games qui on un identifiant
            $execResult = $connexion->query("SELECT * FROM pokemon_games WHERE pkmn_id=$pkmnId");

            //Permet de pouvoir afficher le resultat.
            $result = $execResult->fetchAll(PDO::FETCH_ASSOC);
        }
        // preg_match("$paterne2", $value)
        else{
            $pkmnId = $_POST["pkmn_id"];
            
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
            if(isset($date) && isset($supp) && isset($titre) && isset($generation)){
                $execResult = $connexion->query("UPDATE pokemon_games SET pkmn_game_name = '$titre', pkmn_generation ='$generation' , pkmn_support = '$supp', pkmn_release_date ='$date' WHERE pkmn_id = '$pkmnId'");
                
            }
        }
    }

?>
<form method="POST" action="./update.php">
        <input type="hidden" name="pkmn_id" value="<?php if(isset($result)){ echo $_GET["pkmn_id"];} ?>">
        <div>
            <label for="titre-de-jeux">Titre de jeux pokémon : </label>
            <input type="text" name="titre" id="titre-de-jeux" value="<?php if(isset($result)){ echo $result[0]["pkmn_game_name"];}?>">
        </div>

        <div>
            <label for="gener">Génération : </label>
            <input type="number" name="generation" id="gener" value="<?php if(isset($result)){ echo $result[0]["pkmn_generation"];}?>">
        </div>

        <div>
            <label for="supp-sortie">Support de sortie : </label>
            <input type="text" name="supportsortie" id="supp-sortie" value="<?php if(isset($result)){ echo $result[0]["pkmn_support"];}?>">
        </div>

        <div>
            <label for="date-de-sortie">Date de sortie Européenne : </label>
            <input type="date" name="ddesortie" id="date-de-sortie" value="<?php if(isset($result)){ echo $result[0]["pkmn_release_date"];}?>">
        </div>

        <input type="submit" value="Modifier">
    </form>
    <a href="./read.php" title="Redirection vers la liste">Retourner à la liste pokemon</a> 