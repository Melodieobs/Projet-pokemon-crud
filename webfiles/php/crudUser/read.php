<!-- Référence au liste pokémon. -->
<ul>
<?php 

    /* Permet de faire référence ou garder les mêmes variable (pour évité de recrée) */
    require("../conn.php");


    if($connexion){


            //On selectionne tout de la table pour pouvoir après l'apparaitre en liste
        $execResult = $connexion->query("SELECT * FROM users");
            //Permettra d'afficher le tableau
        $assocResult = $execResult->fetchAll(PDO::FETCH_ASSOC);


        foreach($assocResult as $single):
            ?>
            <li>
            <?= $single["user_id"] ?> | <?= $single["user_name"] ?> | <?= $single["user_email"] ?> | <?= $single["user_password"]; ?> | <?= $single["user_img"]; ?>
                <a href="./update.php?user_id=<?= $single["user_id"] ?>">Modifier</a>

                <form method="POST" action="./delete.php">
                    <input type="hidden" name="hidden" value="<?= $single["user_id"] ?>">
                    <input type="submit" value="Supprimer">

                </form>
            </li>
            
            <?php
        endforeach;
        
    }
    ?>
    </ul>
    <a href="../../../read.php">Page principal</a>