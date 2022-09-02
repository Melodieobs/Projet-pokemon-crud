<?php

    /* Appel a la connexion a la base de donnée */
    require_once("../dbLog.php");


    /* Initialisation de toute les variables */
    $username = $mail = $password = $confirmedPassword = $userPfp = "";
    $errUserName = $errPassword = $errConfirmedPassword = $errMail = $errPfp = $errConnexion = "";


    /* Vérification de la connexion a la BDD */
    /* Sinon affiche une erreur a l'utilisateur */
    if ($connexion) {

        /* Vérifie si le formulaire a été envoyer */
        /* Sinon n'execute rien */
        if (isset($_POST["inscription"]) && $_POST["inscription"] === "S'inscrire") {


            /* Préparation des requètes a la base de donnée */
            /* Première requète vérifie que l'username n'est pas déja existant */
            /* Seconde requète sert a insérer les données d'inscription a la base de donnée  */
            $check=$connexion->prepare('SELECT COUNT(*) FROM users WHERE user_name = :user_name');
            $stmt=$connexion->prepare('INSERT INTO users (user_name, user_email, user_password) VALUES ( ?, ? , ? )');
            

            /* Boucle qui parcours $_POST pour récupérer les informations d'inscription */
            foreach ($_POST as $fields => $values){
    

                /* vérification du nom d'utilisateur */
                if ($fields === "user_name"){
                    
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
                    
                     
                }
                
                /* vérification du mail */
                if ($fields === "user_mail") {
                    $mail = trim($values);
                    
                    /* Vérifie si le mail est remplie */ 
                    if (empty($mail)) {
                        $errMail = "Ce champ doit être rempli";
                    } 

                    /* Vérifie si le mail est conforme */
                    elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL))  {
                        $errMail = "Votre adresse email n'est pas conforme.";
                        
                    }
                    
                    
                }
                
                /* Vérification du mot de passe */
                if ($fields === "user_password") {
                    
                    /* suppression des espaces au début et a la fin de la saisie */
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
    
                /* Vérification de la confirmation mdp */
                if ($fields === "user_confirmedPassword") {
                
                    /* suppression des espaces au début et a la fin de la saisie */
                    $confirmedPassword = trim($values);

                    /* Verifie si le champ a été rempli */
                    if (empty($confirmedPassword)) {
                        $errConfirmedPassword = "Ce champ doit être rempli.";
                    } 
                    /* Vérifie si la confirmation mdp et le mdp non hashé sont les mêmes */
                    elseif ($password != $confirmedPassword) {
                        $errConfirmedPassword = "Vos mots de passes ne correspondent pas.";
                    }
                    
                }
                
            }

            /* Si aucune erreur sur le nom d'utilisateur */
            /* Vérification dans la base de donnée pour voir si le nom d'utilisateur n'existe pas déja */
            if (empty($errUserName)) {
                $check->bindParam(':user_name', $username, PDO::PARAM_STR);

                $check->execute();

                $resultCheck=($check->fetchAll());

            }

            /* Vérifie que le nom d'utilisatuer n'existe pas déja dans la BDD */
            if (isset($resultCheck[0]['COUNT(*)'])) {
                if (  $resultCheck[0]['COUNT(*)'] == 0 ) {
                   
                   /* Ajout des paramètres a la requète */
                   if (empty($errUserName)) {
                       $stmt->bindParam('1', $username, PDO::PARAM_STR);
                    } 
       
                   if (empty($errMail)) {
                       $stmt->bindParam('2', $mail, PDO::PARAM_STR);
                   }
                   
                   if (empty($errPassword) && empty($errConfirmedPassword)) {
                       $stmt->bindParam('3', $hashedPassword, PDO::PARAM_STR);  
                   }
   
   
                   /* Si aucune erreur sur la saisie des champs */
                   /* Execution de la requète et redirection sur la page de ... */
                   if (empty($errUserName) && empty($errMail) && empty($errPassword) && empty($errConfirmedPassword) && empty($errPfp)) {
                       $stmt->execute();
                       
                       header("Location: ./inscriptionReussi.php");
                    
                
                    }
               }
               else{
   
                   $errUserName ="Le nom de l'utilisateur a déja été pris.";
   
               } 
            }

           
           
        
        
        }  
        
    }
    else{
        $errConnexion = "Il y a eu une erreur avec la connexion";
    }

?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>

<body>

    <form action="./inscription.php" method="post">

        <p> <?= $errConnexion ?></p>

        <div>
    
            <label for="name">Entrez votre nom&nbsp;:</label>
            <input type="text" name="user_name" value="<?php if (isset($username)) { echo $username; } ?>" id="name">
            <p><?= $errUserName ?></p> 
    
        </div>


        <div>
            <label for="email">Entrez votre adresse mail&nbsp;:</label>
            <input type="email" name="user_mail" value="<?php if (isset($mail)) { echo $mail; } ?>"  id="email">
            <p><?php echo $errMail ?></p>
        </div>
        

        <div>
            <label for="password">Entrez votre mot de passe&nbsp;:</label>
            <input type="password" name="user_password" id="password">
            <p><?php echo $errPassword ?></p> 
        </div>


        <div>
            <label for="cconfirmedPassword">Vérifiez votre mot de passe&nbsp;:</label>
            <input type="password" name="user_confirmedPassword" id="confirmedPassword">
            <p> <?php echo $errConfirmedPassword ?> </p> 
        </div>



        
        <input type="submit" name="inscription" value="S'inscrire">




    </form>


</body>

</html>





