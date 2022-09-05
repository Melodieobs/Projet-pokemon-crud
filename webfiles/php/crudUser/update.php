<!-- Référence au modification pokémon. -->
 
<?php 

    require("../conn.php");

    if($connexion){
        if($_GET && $_GET['user_id']){
            $userID = $_GET['user_id'];

            //On selection tout de la table pokemon games qui on un identifiant
            $execResult = $connexion->query("SELECT * FROM users WHERE user_id=$userID");

            //Permet de pouvoir afficher le resultat.
            $result = $execResult->fetchAll(PDO::FETCH_ASSOC);
        }

        else{
                $userID = $_POST['user_id'];
                $newName = $_POST['userName'];
                $newMail = $_POST['userMail'];
                $newPass = $_POST['pdw'];

                $execResult = $connexion->query("UPDATE users SET user_name = '$newName', user_email ='$newMail' , user_password ='$newPass' WHERE user_id = '$userID'");
                var_dump($execResult);
        }
    }

?>

<form method="POST" action="./update.php">
        <input type="hidden" name="user_id" value="<?php if(isset($result)){ echo $_GET["user_id"];} ?>">
        <div>
            <label for="name">Votre Nom : </label>
            <input type="text" name="userName" id="name" value="<?php if(isset($result)){ echo $result[0]["user_name"];}?>">
        </div>

        <div>
            <label for="mail">Votre email : </label>
            <input type="email" name="userMail" id="mail" value="<?php if(isset($result)){ echo $result[0]["user_email"];}?>">
        </div>

        <div>
            <label for="motPass">Votre mot de passe : </label>
            <input type="password" name="pdw" id="motPass" value="<?php if(isset($result)){ echo $result[0]["user_password"];}?>">
        </div>

        <input type="submit" value="Mettre à jour">
    </form>
    <a href="./read.php" title="Redirection vers des utilisateur">Retourner à la liste des utilisateur</a>
    