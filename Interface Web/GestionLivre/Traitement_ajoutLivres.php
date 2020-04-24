<?php
require "../Connexion_Database.php";


if (!empty($_POST['titre']) AND !empty($_POST['dateParution']) AND !empty($_POST['genre']) AND !empty($_POST['prenomAuteur']) AND
    !empty($_POST['nomAuteur']))
    {
      $livre_Titre = htmlspecialchars($_POST['titre']);
      $livre_DateParution = htmlspecialchars($_POST['dateParution']);
      $livre_Genre = htmlspecialchars($_POST['genre']);
      $prenomAuteur = htmlspecialchars($_POST['prenomAuteur']);
      $nomAuteur = htmlspecialchars($_POST['nomAuteur']);

      AjouterLivres($connexion, $livre_Titre, $livre_DateParution, $livre_Genre, $prenomAuteur,
                    $nomAuteur);
      header("Location:ajouterExemplaires.php?livre_titre=".$livre_Titre);
    }
    else
    {
      echo "Présence d'un ou plusieurs formulaires vides! Veuillez reéssayer!";
    }
    ?>
