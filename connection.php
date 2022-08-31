<?php


    session_start();

    /* if (isset()) {
        header("Location: ");
    } */

    require_once("../dbLog.php");


    $mail = $password = "";
    $errMail = $errPassword = $errLogin = "";

    if ($connexion) {
        
    
        

        if (isset($_POST["connection"])) {

            $stmt=$connexion->prepare('SELECT user_email, user_password FROM users WHERE user_email LIKE ?');

        
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

                        //J'ai mis ca la car pour moi a chaque foi que l'utilisateur insert un mauvais mot
                        //de passe la sessions s'arretera.
                        $_SESSION['errors'] = $errPassword;
                        header('Location:connection.php');

                    }
                }
            }

            

            if (empty($errMail)) {
                $stmt->bindParam('1', $mail, PDO::PARAM_STR);
            }


            if (empty($errMail) && empty($errPassword)) {
                $stmt->execute();
                $stmt->store_result();
            }

            var_dump($stmt);

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id ,$usernameDB, $usermailDB, $passwordDB);

                $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else {
                $errLogin = "L'identifiant ou le mot de passe n'est pas correct";
            }

            if ($hashedPassword === $passwordDB) {
                session_start();

                $_SESSION["id"] = $id;
                $_SESSION["username"] = $usernameDB;
                $_SESSION["email"] = $usermailDB;
                $_SESSION["loggedin"]= true;

                header("Location: ./connexionReussi");
            }
            else{
                $errLogin = "L'identifiant ou le mot de passe n'est pas correct";
            }


            $stmt->close();

        }



        /* $connexion->close(); */

    
    }





session_start();

if(!isset($_SESSION['PageMembre']))
{
    header("location:./connexionReussi"); // redirection
    exit; // arrêt du script
}
//La session est ouverte on peut afficher la page

//=============================================================================
//                          Affichage de la page
//=============================================================================
?>









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

    <form action="./connection.php" method="$_POST">


        <label for="userEmail">Votre adresse mail</label>
        <input type="email" name="mail" id="userEmail" value=" <?php if(isset($mail)){ echo $mail; } ?> ">

        <br>

        <label for="mdp">Mot de passe</label>
        <input type="password" name="userPassword" id="mdp">

        <input type="submit" value="connection" name="connection">

        <p> <?php echo $errLogin ?> </p>


    </form>

    

    <p>Vous n'avez pas de compte? <a href="./inscription.php">Inscrivez vous maintenant.</a></p>


</body>
</html>