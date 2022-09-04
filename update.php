<!-- Référence au modification pokémon. -->
 
<?php 

    require("../dbLog.php");

    /* session_start(); */

    /* Initialisation des erreurs */
    $errUserName = $errPassword = $errConfirmedPassword = $errMail = $errUrl = $errUserID = "";

    if($connexion){
        if((session_start())){
            

            if($_GET && $_GET['user_id']){
                
                $userID = $_GET['user_id'];
                
                //On selection tout de la table pokemon games qui on un identifiant
                $execResult = $connexion->query("SELECT * FROM users WHERE user_id=$userID");

                //Permet de pouvoir afficher le resultat.
                $result = $execResult->fetchAll(PDO::FETCH_ASSOC);
                /* var_dump($result); */
                
            }
            else{
                
                $userID = $_POST['user_id'];
                $stmt = $connexion->prepare("UPDATE users SET user_name = :username, user_email = :usermail , user_password = :userpassword, user_img = :img WHERE user_id = $userID");
                
                foreach ($_POST as $fields => $values){
                    
                    /* Vérification du nom d'utilisateur */
                    if ($fields === "userName"){

                        $username = trim($values);

                        /* verifie si le champ est remplie */
                        if (empty($username)) {
                            $errUserName = "Ce champ doit être rempli";
                        }

                        /* Le nim d'utilisateur ne doit pas dépasser 30 charactères*/
                        if (strlen($username)>30) {
                            $errUserName= "Non d'utilisateur trop long. 30 Charactères max.";
                        }

                        /* Vérifie si le nom d'utilisateur correspond avec l'expression régulière définie*/
                        elseif (!preg_match("/^[a-zA-Z0-9àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð_'-]{1,30}$/", $username)) {
                            $errUserName = "Le nom d'utilisateur peut seulement contenir des lettres, des nombres et des underscores";
                        }

                        /* Ajout du nom d'utilisateur a la requète */
                        else {
                            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                        }

                    }

                    if ($fields === "userMail") {
                        $mail = trim($values);

                        /* Vérifie si le mail est remplie */ 
                        if (empty($mail)) {
                            $errMail = "Ce champ doit être rempli";
                        } 

                        /* Vérifie si le mail est conforme */
                        elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL))  {
                            $errMail = "Votre adresse email n'est pas conforme.";
                        }

                        /* Ajout du mail a la requète */
                        else {
                            $stmt->bindParam(':usermail', $mail, PDO::PARAM_STR);
                        }
                    }


                    if ($fields === "pdw") {

                        $password = trim($values);

                        /* Vérifie si le mdp est remplie */
                        if (empty($password)) {
                            $errPassword = "Ce champ doit être rempli.";
                        } 
                        else {

                            /* Verifie si le mdp a plus de 8 charactères */
                            if (strlen($password) <= 8) {
                                $errPassword = "Votre mot de passe doit au moins faire 8 charactère de long.";
                            }
                            /* Verifie si le mdp a moins de 30 charactères */
                            if (strlen($password) > 30) {
                                $errPassword = "Mot de passe trop long.";
                            }

                            /* Verifie si le mdp a au moins une majuscule, un chiffre, et un charactère spécial */
                            if (!preg_match('/[A-Z]/', $password)  || !preg_match('/\d/', $password) || !preg_match("/[$&+,:;=?@#|'<>.-^*()%!]/", $password) ) {
                                $errPassword = "Votre mot de passe doit contenir au moins une majuscule, un chiffre et un charactère special.";
                            }



                        }
                        /* vérifie qu'aucune erreur a été faite dans le mdp */
                        if (empty($errPassword)) {


                            /* Conversion des caractères speciaux en entités HTML */
                            /* hashage du mot de passe */
                            $hashedPassword =hash('sha512', htmlspecialchars($password) );
                        }
                    }

                    if ($fields === "cpdw") {


                        $confirmedPassword = trim($values);

                        /* Verifie si le champ a été rempli */
                        if (empty($confirmedPassword)) {
                            $errConfirmedPassword = "Ce champ doit être rempli.";
                        } 

                        /* Vérifie si la confirmation mdp et le mdp non hashé sont les mêmes */
                        elseif ($password != $confirmedPassword) {
                            $errConfirmedPassword = "Vos mots de passes ne correspondent pas.";
                        }

                        /* Ajout du mdp hashé a la requète */
                        else {
                            $stmt->bindParam(':userpassword', $hashedPassword, PDO::PARAM_STR);
                        }
                    }


                    if ($fields === 'url'){
                        $url = trim($values);

                        /* Vérifie si le mail est remplie */ 
                        if (empty($url)) {
                            $errUrl = "Ce champ doit être rempli";
                        } 

                        /* Vérifie si le mail est conforme */
                        elseif (!filter_var($url, FILTER_VALIDATE_URL))  {
                            $errUrl = "Votre URL n'est pas conforme.";

                        }

                        /* Ajout de l'url a la requète */
                        else {
                            $stmt->bindParam(':img', $url, PDO::PARAM_STR);
                        }
                    }

                    

                }
            }

            /* Vérifie qu'il n'y ait aucune erreur pour executer la requète */
            if ( isset($_POST["update"]) && empty($errUserName) && empty($errMail) && empty($errPassword) && empty($errConfirmedPassword) && empty($errUrl)) {
                $stmt->execute();
                echo "test reussi";
            }

        }   
    }
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form method="POST" action="./update.php">

        <!-- ID utilisateur -->
        <input type="hidden" name="user_id" value="<?php if(isset($result)){ echo $_GET["user_id"];}elseif (isset($userID)){ echo $userID;} ?>">
        <p> <?= $errUserID ?> </p>

        <!-- input nom utilisateur -->
        <div>
            <label for="name">Votre Nom : </label>
            <input type="text" name="userName" id="name" value="<?php if(isset($result)){ echo $result[0]["user_name"];}elseif (isset($username)){ echo $username;}?>">
            
            <p> <?= $errUserName ?> </p>
        </div>
    
        <!-- input mail utilisateur -->
        <div>
            <label for="mail">Votre email : </label>
            <input type="email" name="userMail" id="mail" value="<?php if(isset($result)){ echo $result[0]["user_email"];}elseif (isset($mail)){ echo $mail;}?>">

            <p> <?= $errMail ?> </p>
        </div>

        <!-- input mot de passe utilisateur -->
        <div>
            <label for="motPass">Votre mot de passe : </label>
            <input type="password" name="pdw" id="motPass">

            <p> <?= $errPassword ?> </p>
        </div>

        <!-- input confirmation mot de passe utilisateur -->
        <div>
            <label for="confirmationMotPass">Votre mot de passe : </label>
            <input type="password" name="cpdw" id="confirmationMotPass">

            <p> <?= $errConfirmedPassword ?> </p>
        </div>

        <!-- input url image utilisateur -->
        <div>
            <div><img src="<?php if(isset($result)){ echo $result[0]["user_img"];}elseif (isset($url)){ echo $url;}?>" alt="Image d'utilisateur"></div>
    
            <label for="url"></label>
            <input type="url" name="url" id="url" value=" <?php if(isset($result)){ echo $result[0]["user_img"];}elseif (isset($url)){ echo $url;}?> ">

            <p> <?= $errUrl ?> </p>
        </div>

        <!-- submit -->
        <input type="submit" name="update" value="Mettre à jour">
    </form>
    
    <a href="./read.php" title="Redirection vers des utilisateur">Retourner à la liste des utilisateur</a>
        
    
</body>
</html>