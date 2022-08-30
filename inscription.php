<?php

    require_once("../dbLog.php");


    $username = $mail = $password = $confirmedPassword = $userPfp = "";
    $errUserName = $errPassword = $errConfirmedPassword = $errMail = $errPfp = "";


    if ($connexion) {

        
        if (isset($_POST["inscription"])) {
            
            $stmt=$connexion->prepare('INSERT INTO users (user_name, user_email, user_password) VALUES ( ?, ? , ? )');
            
            foreach ($_POST as $fields => $values){
    
                if ($fields === "user_name"){
                    
                    $username = trim($values);
        
                    /* verification username */
                    if (empty($username)) {
                        $errUserName = "Ce champ doit être rempli";
                    }

                    elseif (!preg_match('/^[a-zA-Z0-9_]/', $username)) {
                            $errUserName = "Le nom d'utilisateur peut seulement contenir des lettres, des nombres et des underscores";
                    }
                    
                     
                }
                
                if ($fields === "user_mail") {
                    $mail = trim($values);
                    
                    /* verification mail */ 
                    if (empty($mail)) {
                        $errMail = "Ce champ doit être rempli";
                    } 
                    elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL))  {
                        $errMail = "Votre adresse email n'est pas conforme.";
                        
                    }
                    
                    
                }
                
                if ($fields === "user_password") {
                    
                    $password = trim($values);

                    /* Password verification */
                    if (empty($password)) {
                        $errPassword = "Ce champ doit être rempli.";
                    } 
                    else {

                        /* Verify if password has more than 8 characters */
                        if (strlen($password) <= 8) {
                            $errPassword = "Votre mot de passe doit au moins faire 8 charactère de long.";
                        }

                        /* Verify if password has at least one uppercase letter, one number and one  */
                        if (!preg_match('/[A-Z]/', $password)  || !preg_match('/\d/', $password) || !preg_match("/[$&+,:;=?@#|'<>.-^*()%!]/", $password) ) {
                            $errPassword = "Votre mot de passe doit contenir au moins une majuscule et au moins un chiffre.";
                        }

                    
                    }
                    /* Verify if there's any error so we can hash the password for the query */
                    if (empty($errPassword)) {
                        $hashedPassword =hash('sha512', htmlspecialchars($password) );
                        
                    }
                }
    
                if ($fields === "user_confirmedPassword") {
                
                    $confirmedPassword = trim($values);

                    /* confirmed password verification */
                    if (empty($confirmedPassword)) {
                        $errConfirmedPassword = "Ce champ doit être rempli.";
                    } 
                    elseif ($password != $confirmedPassword) {
                        $errConfirmedPassword = "Vos mots de passes ne correspondent pas.";
                    }
                    
                }
                
            }

            /* Bind parameters for the query */
            if (empty($errUserName)) {
                $stmt->bindParam('1', $username, PDO::PARAM_STR);
                } 

            if (empty($errMail)) {
                $stmt->bindParam('2', $mail, PDO::PARAM_STR);
            }
            
            if (empty($errPassword) && empty($errConfirmedPassword)) {
                $stmt->bindParam('3', $hashedPassword, PDO::PARAM_STR);  
            }
           
           
           /* sending query */
           if (empty($errUserName) && empty($errMail) && empty($errPassword) && empty($errConfirmedPassword) && empty($errPfp)) {
               $stmt->execute();
               
               header("Location: ./inscriptionReussi.php");
            
        
            }
        
            $stmt->close();  
        }  
        $connexion->close();
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
        <div>
    
            <label for="name">Entrez votre nom&nbsp;:</label>
             <p><?php echo $errUserName ?></p> 
            <input type="text" name="user_name" value="<?php if (isset($username)) { echo $username; } ?>" id="name">
    
        </div>


        <div>
            <label for="email">Entrez votre adresse mail&nbsp;:</label>
             <p><?php echo $errMail ?></p>
            <input type="email" name="user_mail" value="<?php if (isset($mail)) { echo $mail; } ?>"  id="email">
        </div>
        

        <div>
            <label for="password">Entrez votre mot de passe&nbsp;:</label>
             <p><?php echo $errPassword ?></p> 
            <input type="password" name="user_password" id="password">
        </div>


        <div>
            <label for="cconfirmedPassword">Vérifiez votre mot de passe&nbsp;:</label>
             <p> <?php echo $errConfirmedPassword ?> </p> 
            <input type="password" name="user_confirmedPassword" id="confirmedPassword">
        </div>



        
        <input type="submit" name="inscription" value="S'inscrire">




    </form>


</body>

</html>





