<!-- Référence au modification pokémon. -->
 
<?php 

    require("../conn.php");

    $paterne = '/^[A-Za-z1-2\s&]+$/';
    $paterne2 = '/^[0-9]+$/';
    $tabval = [];

    //$remplaceGame_Name= str_ireplace( "é","e",$pkmn_game_name)

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
                              // verifie si le champs et rempli et si il n'y a pas de caractere speciaux, ainsi que
                              // ne depasse pas le nombre de verification
                if($fields === "generation"){
                    $value = trim(ucfirst($value));
                    if(empty($value)){
                        echo $err = "Le champs génération n'est pas remplis\n\n";
                    }
                    elseif($value == 9){
                        echo $err = "Désolé pour toi cette génération sort le 18/novembre/2022 ! ";
                    }
                    elseif($value > 8){
                        echo $err = "erreur il n'y a que 8 génération\n\n";
                    }
                    else{
                        $generation = $value;
                    }
                }
                  // verifie si le champs et rempli et si il n'y a pas de caractere speciaux
                if($fields === "titre"){
                    if(empty($value)){
                        echo $err = "Le champs titre n'as pas était remplis.\n\n";
                    }
                    elseif(!preg_match("$paterne", $value)){
                        echo $err = "La titre saisie n'est pas bonne.\n\n";
                    }
                    else{
                        $titre = $value;
                    }
                }
                // verifie si le champs et rempli et si il n'y a pas de caractere speciaux
                if($fields === "supportsortie"){
                    if(empty($value)){
                        echo $err = "Le champ date de sorti n'as pas était remplis.\n\n";
                    }
                    elseif(!preg_match("$paterne", $value)){
                        echo $err = "La valeur du support n'est pas bonne.\n\n";
                    }
                    else{
                        $supp = $value;
                    }
                }
                // verifie si c'est bien une date
                // ainsi que ça ne dépasse pas la date
                if($fields === "ddesortie"){
                    if($value > date("Y-m-d")){
                        echo $err = "La date saisie n'est pas bonne.\n\n" ;
                    }
                    else{
                        $date = $value;
                    }
                }
                //verifie si cela est bien un url
                if($fields === "url"){
                    if(filter_var($value, FILTER_VALIDATE_URL)){
                        $url = $value;
                    }
                    else{
                        echo $err = "J'ai bien l'impression que cela n'est pas un url !";
                    }
            }
            // si il n'y a pas d'erreur cela va s'inserer
            if(isset($date) && isset($supp) && isset($titre) && isset($generation) && isset($url)){
                $execResult = $connexion->query("UPDATE pokemon_games SET pkmn_game_name = '$titre', pkmn_generation ='$generation' , pkmn_support = '$supp', pkmn_release_date ='$date', pkmn_image = '$url' WHERE pkmn_id = '$pkmnId'");
                
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
    <meta name="description" content="Mise à jour des pokémon en cas d'erreur">
    <title>Mise à jour pokemon</title>
</head>
<body>
    

    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
        
    

        <form method="POST" action="./update.php">
            <input type="hidden" name="pkmn_id" value="<?php if(isset($result)){ echo $_GET["pkmn_id"];} ?>">
            <div>
                <label for="titre-de-jeux">Titre de jeux pokémon : </label>
                <input type="text" name="titre" id="titre-de-jeux" value="<?php if(isset($result)){ echo $result[0]["pkmn_game_name"];} if(isset($err)){ echo $_POST['titre']; } ?>">
            </div>

            <div>
                <label for="gener">Génération : </label>
                <input type="number" name="generation" id="gener" placeholder="<?php if(isset($result)){ echo $result[0]['pkmn_generation'] ;} if(isset($err)){ echo $_POST['generation']; }?> ">
            </div>

            <div>
                <label for="supp-sortie">Support de sortie : </label>
                <input type="text" name="supportsortie" id="supp-sortie" value="<?php if(isset($result)){ echo $result[0]["pkmn_support"];} if(isset($err)){ echo $_POST['supportsortie']; }?>">
            </div>

            <div>
                <label for="date-de-sortie">Date de sortie Européenne : </label>
                <input type="date" name="ddesortie" id="date-de-sortie" value="<?php if(isset($result)){ echo $result[0]["pkmn_release_date"]; } ?>">
            </div>
            <div>
                <input type="URL" name="url" value="<?php if(isset($result)){ echo $result[0]["pkmn_image"];} if(isset($err)){ echo $_POST['url']; }?>">
                <img src="<?php if(isset($result)){ echo $result[0]["pkmn_image"]; } ?>" alt="img" >
            </div>
            <input type="submit" value="Modifier">
        </form>
        <a href="./read.php" title="Redirection vers la liste">Retourner à la liste pokemon</a> 

        <?php
    } else {
     ?>
    
        <h1>Vous n'etes pas connecter</h1>

        <a href="../auth/authLogin/connection.php" title="connexion">Connectez vous</a>

    <?php
    } ?>
    

</body>
</html>