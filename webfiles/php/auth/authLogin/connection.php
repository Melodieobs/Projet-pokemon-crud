<?php
    session_start();

    /* Vérifie si une session n'existe pas déja */
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

        header("Location: Location: ../../../../read.php");

    }
    require_once("../../conn.php");
    $mail = $hashedPassword = "";
    $errMail = $errPassword = $errLogin = "";

    if ($connexion) {
        

        if (isset($_POST["connection"])) {

            $stmt=$connexion->prepare('SELECT * FROM users WHERE user_name = :user_name');

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
                
                if ($fields === "user_password") {
                    
                    $password = trim($values);

                    /* verification mdp */
                    if (empty($password)) {
                        $errPassword = "Ce champ doit être rempli.";
                    } 
                    else {

                        /* vérifie si mdp a plus de 8 charactères */
                        if (strlen($password) <= 8) {
                            $errPassword = "Votre mot de passe doit au moins faire 8 charactère de long.";
                        }

                        /* Verifie si mdp a au moins une majuscule, un chiffre et un charactère spécial */
                        if (!preg_match('/[A-Z]/', $password)  || !preg_match('/\d/', $password) || !preg_match("/[$&+,:;=?@#|'<>.-^*()%!]/", $password) ) {
                            $errPassword = "Votre mot de passe doit contenir au moins une majuscule et au moins un chiffre.";
                        }

                    
                    }

                    /* Verify s'il y a une erreur
                    Sinon transforme les entités html et hash le mdp */
                    if (empty($errPassword)) {
                        $hashedPassword = hash('sha512', htmlspecialchars($password) );
                        
                    }

                }
                
               
                
            }

            /* Si aucune erreur execute la requete */
            if (empty($errMail) && empty($errPassword)) {
                $stmt->bindParam(':user_name', $username, PDO::PARAM_STR); 
     
                $result=$stmt->execute(); 
                $result=($stmt->fetchAll());

            }
            
            /* Crée la session */
            if (($result)) {
                if ($hashedPassword === $result[0]['user_password']) {
                    session_start();
    
                    $_SESSION["id"] = $result[0]["user_id"];
                    $_SESSION["username"] = $result[0]["user_name"];
                    $_SESSION["email"] = $result[0]["user_email"];
                    $_SESSION["loggedin"]= true;

                    header("Location: ../../../../read.php");
                }
                else{
                    $errLogin = "L'identifiant ou le mot de passe n'est pas correct";
                }
                
                

                
            }
            else{
                $errLogin= "Erreur de connexion";
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
    <title>Connection</title>
</head>
<body>

    <h1>Se connecter</h1>
    
    <form action="" method="POST">

        <p> <?= $errMail ?> </p>
        <label for="userEmail">Votre nom d'utilisateur</label>
        <input type="text" name="user_name" id="userName" value="<?php if(isset($username)){ echo $username; }?> ">

        <br>
        <p> <?= $errPassword ?> </p>
        <label for="mdp">Votre mot de passe</label>
        <input type="password" name="user_password" id="mdp">

        <input type="submit" value="connection" name="connection">

        <p> <?php echo $errLogin ?> </p>


    </form>

    

    <p>Vous n'avez pas de compte? <a href="../authRegister/inscription.php">Inscrivez vous maintenant.</a></p>


</body>
</html>