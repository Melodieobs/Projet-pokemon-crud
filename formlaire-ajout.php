
    <form method="POST" action="./add.php">


<div>
    <label for="titre-poke-jeux">Titre de jeux pokémon: </label>
    <input type="text" name="titre-poke-jeux" id="titre-de-jeux" <?php if(isset($execResult)){ echo ["titre-poke-jeux"];} ?>>
</div>

<div>
    <label for="generation">Génération: </label>
    <input type="number" name="generation" id="gener" <?php if(isset($execResult)){ echo $execResult[0]["generation"];} ?>>
</div>

<div>
    <label for="d-de-sortie">Date de sortie Européenne : </label>
    <input type="date" name="d-de-sortie" id="date-de-sortie" <?php if(isset($execResult)){ echo $execResult[0]["d-de-sortie"];} ?>>
</div>

<div>
    <label for="support-de-sortie">Support de sortie : </label>
    <input type="text" name="support-sortie" id="supp-sortie" <?php if(isset($execResult)){ echo $$execResult[0]["support-sortie"];} ?>>
</div>

<input type="submit" value="Ajouter">
</form>


<a href="./jeuxPok/read.php" title="Redirection sur la page de tous les utilisateurs">Afficher tous les jeux pokémon</a>
