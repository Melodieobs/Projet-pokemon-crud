<?php


    session_start();

    /* if (isset()) {
        header("Location: ");
    } */

    require_once("../dbLog.php");


    $mail = $password = "";
    $errMail = $errPassword = $errLogin = "";

    if ($connexion) {
        
    
        var_dump($connexion);

        if (isset($_POST["connection"])) {

            /* var_dump($_POST);

            var_dump($_POST["connection"]); */

            $stmt=$connexion->prepare('SELECT * FROM users WHERE user_email = ?');

            /* var_dump($stmt); */
            foreach ($_POST as $fields => $values){
        
                
                if ($fields === "user_mail") {
                    $mail = trim($values);
                    
                    /* verification mail */ 
                    if (empty($mail)) {
                        $errMail = "Ce champ doit être rempli";
                    } 
                    elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL))  {
                        $errMail = "Votre adresse email n'est pas conforme.";
                        
                    }
                    else{
                        $stmt->bindParam('1', $mail, PDO::PARAM_STR);
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
                /* var_dump($errMail);
                var_dump($errPassword); */
                
            }

            

            
            


            if (empty($errMail) && empty($errPassword)) {
                
                $result=$stmt->execute();
                var_dump($result);

                $result=($stmt->fetchAll(PDO::FETCH_ASSOC));

                

                var_dump($result);
               
            }

            var_dump($result);

            if (($result)) {
                if ($hashedPassword === $result['user_password']) {
                    session_start();
    
                    $_SESSION["id"] = $result["user_id"];
                    $_SESSION["username"] = $result["user_name"];
                    $_SESSION["email"] = $result["user_email"];
                    $_SESSION["loggedin"]= true;
    
                    /* header("Location: ./connexionReussi"); */
                    echo " conenxion réussi";
                }
                else{
                    $errLogin = "L'identifiant ou le mot de passe n'est pas correct";
                }
                var_dump($result);
                /* var_dump($_SESSION); */

                
            }
            else{
                $errLogin= "Erreur de connexion";
            }

            

            /* $stmt->close(); */

        }



        /* $connexion->close(); */

    
    }


?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection</title>
</head>
<body>

    <h1>Se connecter</h1>

    <form action="" method="POST">

        <p> <?= $errMail ?> </p>
        <label for="userEmail">Votre adresse mail</label>
        <input type="email" name="mail" id="userEmail" value="<?php if(isset($_POST['mail'])){ echo $_POST['mail']; }?> ">

        <br>
        <p> <?= $errPassword ?> </p>
        <label for="mdp">Mot de passe</label>
        <input type="password" name="userPassword" id="mdp">

        <input type="submit" value="connection" name="connection">

        <p> <?php echo $errLogin ?> </p>


    </form>

    

    <p>Vous n'avez pas de compte? <a href="./inscription.php">Inscrivez vous maintenant.</a></p>


</body>
</html>