<!-- Référence au liste pokémon. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Liste des jeux de pokemon quand la personne est connecter peut acceder au modification">
    <title>Liste pokemon</title>
</head>
<body>
    <ul>
        <?php 

/* Permet de faire référence ou garder les mêmes variable (pour évité de recrée) */
    require("./conn.php");

    
    if($connexion){
        
        
        //On selectionne tout de la table pour pouvoir après l'apparaitre en liste
        $execResult = $connexion->query("SELECT * FROM pokemon_games");
        //Permettra d'afficher le tableau
        $assocResult = $execResult->fetchAll(PDO::FETCH_ASSOC);
        
        // permet d'afficher la liste de tout les pokémon étant dans la base de donnée
        foreach($assocResult as $single):
            ?>
            <li>
            <?= $single["pkmn_id"]; ?> | <?= $single["pkmn_game_name"]; ?> | <?= $single["pkmn_generation"]; ?> | <?= $single["pkmn_release_date"]; ?> | <?= $single["pkmn_support"]; ?> | <img src="<?php echo $single["pkmn_image"] ?>" alt="img">
            <a href="./update.php?pkmn_id=<?= $single["pkmn_id"] ?>">Modifier</a>
            
            <form method="POST" action="./delete.php">
                <input type="hidden" name="hiddenField" value="<?= $single["pkmn_id"] ;?>">
                <input type="submit" value="Supprimer">
                
            </form>
        </li>
        
        <?php
        endforeach;
        
    }
    
    ?>
    </ul>
    
    </body>
    </html>