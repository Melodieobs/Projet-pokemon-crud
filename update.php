<!-- Référence au modification pokémon. -->
 
<?php 

    require("./conn.php");

    $paterne = '/^[A-Za-z1-2\s&]+$/';
    $paterne2 = '/^[0-9]+$/';
    $tabval = [];
    $err = "veuillez remplir le champs";
    $errtab =  [1 => "La valeur du titre n'est pas bonne.",
                2 => "La valeur du support n'est pas bonne.",
                3 => "La date saisie n'est pas bonne."];
    //$remplaceGame_Name= str_ireplace( "é","e",$pkmn_game_name);

    if($connexion){
        if($_GET && $_GET["pkmn_id"]){
            
            $pkmnId = $_GET["pkmn_id"];
            //On selection tout de la table pokemon games qui on un identifiant
            $execResult = $connexion->query("SELECT * FROM pokemon_games WHERE pkmn_id=$pkmnId");

            //Permet de pouvoir afficher le resultat.
            $result = $execResult->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            $pkmnId = $_POST["pkmn_id"];
            
            foreach($_POST as $fields => $value){
                array_push($tabval, $value);
                if($fields === "generation"){
                    $value = trim(ucfirst($value));
                    if(empty($value)){
                        echo $err;
                    }
                    elseif(!preg_match("$paterne2", $value)){
                        echo "erreur il n'y a que 8 génération";
                    }
                    else{
                        $generation = $value;
                    }
                }
                if($fields === "titre"){
                    if(empty($value)){
                        echo $err;
                    }
                    elseif(!preg_match("$paterne", $value)){
                        echo $errtab[1];
                        var_dump(!preg_match("$paterne", $value));
                    }
                    else{
                        $titre = $value;
                    }
                }
                if($fields === "supportsortie"){
                    if(empty($value)){
                        echo $err;
                    }
                    elseif(!preg_match("$paterne", $value)){
                        echo $errtab[2];
                        var_dump(!preg_match("$paterne", $value));
                    }
                    else{
                        $supp = $value;
                    }
                }
                if($fields === "ddesortie"){
                    if($value > date("Y-m-d")){
                        echo $errtab[3];
                    }
                    else{
                        $date = $value;
                    }
                }
            }
            if(){
                $execResult = $connexion->query("UPDATE pokemon_games SET pkmn_game_name = '$value', pkmn_generation ='$value' , pkmn_support = '$value', pkmn_release_date ='$value' WHERE pkmn_id = '$pkmnId'");            
        }}
    }
        
/*     var_dump( date("m.d.Y"));
 */        // else{
                // $pkmnId = $_POST["pkmn_id"];
                // $newName = $_POST["titre"];
                // $newGen = $_POST["generation"];
                // $newReDate = $_POST["ddesortie"];
                // $newSupp = $_POST["supportsortie"];
                // $newIm = $_POST["image"];

                // $execResult = $connexion->query("UPDATE pokemon_games SET pkmn_game_name = '$newName', pkmn_generation ='$newGen' , pkmn_support = '$newSupp', pkmn_release_date ='$newReDate' WHERE pkmn_id = '$pkmnId'");
                // var_dump($execResult);
      //  }
   

?>

<form method="POST" action="./update.php">
        <input type="hidden" name="pkmn_id" value="<?php if(isset($result)){ echo $_GET["pkmn_id"];} ?>">
        <div>
            <label for="titre-de-jeux">Titre de jeux pokémon: </label>
            <input type="text" name="titre" id="titre-de-jeux" value="<?php if(isset($result)){ echo $result[0]["pkmn_game_name"];}?>">
        </div>

        <div>
            <label for="gener">Génération: </label>
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

        <input type="submit" value="Ajouter">
    </form>
    <a href="./read.php" title="Redirection vers la liste">Retourner à la liste pokemon</a>