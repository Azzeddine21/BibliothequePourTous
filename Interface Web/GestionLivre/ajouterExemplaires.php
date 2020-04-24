<?php require '../Connexion_Database.php'; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ajouterExemplaires</title>
  </head>
  <body>
    <h3>Ajouter un exemplaire</h3>

    <?php
    if(isset($_GET["livre_titre"])){
      echo $_GET["livre_titre"];
      $numeroLivre = Recuperation_IDLivre($connexion, $_GET["livre_titre"]);?>
      <form class="" action="Traitement_ajouterExemplaires.php" method="post">
        <p style="display:none;"><input type="text" name="vide" value=<?php echo "true";?>></p>
        <p><label for="ID">ID du livre : </label><input type="number" name="numero" value=<?php echo $numeroLivre;?> id="ID"></p>
        <p><label for="achat">Date d'achat de l'exemplaire : </label><input type="date" name="achat" id="achat"></p>
        <p><label for="editeur">Editeur du livre : </label><input type="text" name="editeur" id="editeur"></p>
        <p>Etat de l'exemplaire : <br>
        <label for="Abime">Abîmé </label><input type="radio" name="etat" values="Abime" id='Abime'><br>
        <label for="Correct">Correct <input type="radio" name="etat" value="Correct" id="Correct"><br>
        <label for="Neuf">Neuf <input type="radio" name="etat" value="Neuf" id="Neuf"></p>
        <p><input type="submit" value="Valider"></p>
      </form>
      <?php
    }
    else{?>
      <form class="" action="Traitement_ajouterExemplaires.php" method="post">
        <p><label for="ID">ID du livre : </label><input type="number" name="numero" id="ID"></p>
        <p style="display:none;"><input type="text" name="vide" value=<?php echo "false";?>></p>
        <p><label for="achat">Date d'achat de l'exemplaire : </label><input type="date" name="achat" id="achat"></p>
        <p><label for="editeur">Editeur du livre : </label><input type="text" name="editeur" id="editeur"></p>
        <p>Etat de l'exemplaire : <br>
        <label for="Abime">Abîmé </label><input type="radio" name="etat" values="Abime" id='Abime'><br>
        <label for="Correct">Correct <input type="radio" name="etat" value="Correct" id="Correct"><br>
        <label for="Neuf">Neuf <input type="radio" name="etat" value="Neuf" id="Neuf"></p>
        <p><input type="submit" value="Valider"></p>
      </form>
      <?php
    }
     ?>
     <p><a href="../Menu.php">Cliquer ici pour retourner au menu</a></p>

  </body>
</html>
