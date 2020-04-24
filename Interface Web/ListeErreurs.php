<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    if(isset($_GET['numeroInconnu']))
    {
      echo '<p>Le numero saisit', $_GET['numeroInconnu'], ' n\'est pas attribué.<br>
      Veuillez recommencer en cliquant <a href=EmpruntLivre/Authentification.php>ici</a></p>';
    }

    if(isset($_GET['mdpIncorrect']))
    {
      echo '<p>Le mot de passe saisit ne correspond pas.<br>
      Veuillez recommencer en cliquant <a href=EmpruntLivre/Authentification.php>ici</a></p>';
    }

    if(isset($_GET['numeroLivreInconnu']))
    {
      echo '<p>Le numéro n\'est pa référencé dans la bibliothèque'
    }
    ?>
  </body>
</html>
