<?php
session_start();
$_SESSION['nbrLivres'] = $_POST['nombre'];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Choix du Livre</title>
  </head>
  <body>
    <?php
    $i = 0;
    if(!empty($_POST['nombre']))
    {?>
      <form action="Traitement_ChoixLivre.php" method="post"><?php
      while($i < $_SESSION['nbrLivres'])
      { ?>
        <p><label for="Livre">Choisir le livre <?php echo $i+1; ?> en sélectionnant son numéro : </label><input type="number" name=<?php echo $i; ?>></p><?php
        $i++;
      } ?>
      <p><input type="submit" value="Valider"></p>
    </form><?php
    }
    else
    {
      echo '<p>Formulaire vide, veuillez recommencer en
      cliquant <a href=Emprunteur.php>ici</a>';
    }?>
  </body>
</html>
