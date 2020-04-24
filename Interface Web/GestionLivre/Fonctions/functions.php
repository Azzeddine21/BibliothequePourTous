<?php

//--------------------------Fonctions d'ajout de livres--------------------------

function AjouterLivres($connexion, $livre_Titre, $livre_DateParution, $livre_Genre, $prenomAuteur,
                       $nomAuteur)
{
  $numeroAuteur = 0;
  $numeroLivre = rand(0, 9999);
  $request = $connexion->prepare('SELECT ID_livre FROM livres WHERE ID_livre = :numero');
  $request->bindParam(":numero", $numeroLivre);
  $request->execute();

  if($request->fetchColumn()){
    header("Location:../ListeErreurs.php?numeroAleatoire_erreur");
  }
  else{
    $request = $connexion->prepare('SELECT ID_auteur FROM auteur WHERE prenom = :prenom AND nom = :nom');
    $request->bindParam(':prenom', $prenomAuteur);
    $request->bindParam(':nom', $nomAuteur);
    $request->execute();
    if($request->fetchColumn()){
      $request->execute();
      while($display = $request->fetch())
      $numeroAuteur = $display["ID_auteur"];
    }
    else{
      $insert = $connexion->prepare("INSERT INTO auteur(prenom, nom) VALUES(:prenom, :nom)");
      $insert->bindParam(":prenom", $prenomAuteur);
      $insert->bindParam(":nom", $nomAuteur);
      $insert->execute();
      $request->execute();
      while($display = $request->fetch())
      $numeroAuteur = $display["ID_auteur"];
    }
    $insert = $connexion->prepare("INSERT INTO livres(titre, date_parution, genre, ID_auteur) VALUES(:titre, :dateP, :genre, :auteur)");
    $insert->bindParam(":titre", $livre_Titre);
    $insert->bindParam(":dateP", $livre_DateParution);
    $insert->bindParam(":genre", $livre_Genre);
    $insert->bindParam(":auteur", $numeroAuteur);
    $insert->execute();
  }
}

//--------------------------Fonctions d'ajout d'exemplaires de livres--------------------------

function AjouterExemplaires($connexion, $numeroLivre, $achat, $edition, $etat, $vide)
{
  $request = $connexion->prepare("SELECT ID_livre FROM livres WHERE ID_livre = :numero");
  $request->bindParam(":numero", $numeroLivre);
  $request->execute();
  if($request->fetchColumn()){
    $numeroExemplaire = rand(0, 9999);
    $request = $connexion->prepare("SELECT ID_exemplaire FROM exemplaire WHERE ID_exemplaire = :numero");
    $request->bindParam(":numero", $numeroExemplaire);
    $request->execute();
    if($request->fetchColumn()){
        header("Location:../ListeErreurs.php?numeroAleatoire_erreur");
    }
    else{
      $insert = $connexion->prepare("INSERT INTO exemplaire VALUES(:numero, :achat, :etat, :edition)");
      $insert->bindParam(":numero", $numeroExemplaire);
      $insert->bindParam(":achat", $achat);
      $insert->bindParam(":etat", $etat);
      $insert->bindParam(":edition", $edition);
      $insert->execute();

      $insert = $connexion->prepare("INSERT INTO emprunt(Disponibilite,ID_exemplaire) VALUES('Disponible', :numero)");
      $insert->bindParam(":numero", $numeroExemplaire);
      $insert->execute();
      InsertionNumero($connexion, $numeroLivre, $numeroExemplaire, $vide);
    }
  }
  else{
    header("Location:../ListeErreurs.php?EchecNumeroLivre=". 0);
  }
}

//--------------------------Fonctions de récupération de l'ID du livre--------------------------

function Recuperation_IDLivre($connexion, $titre)
{
  $numeroLivre = 0;
  $request = $connexion->prepare("SELECT ID_livre FROM livres WHERE titre = :titre");
  $request->bindParam(":titre", $titre);
  $request->execute();
  while($display = $request->fetch())
  $numeroLivre = $display["ID_livre"];

  return $numeroLivre;
}

//--------------------------Fonctions recherche de livres--------------------------

function RechercheLivre(&$connexion, $rechercherLivre)
{

  $request = $connexion->prepare('SELECT *
                                         FROM livres, auteur, exemplaire, emprunt, implementation
                                         WHERE
                                         livres.ID_auteur = auteur.ID_auteur AND
                                         livres.ID_livre = implementation.ID_livre AND
                                         implementation.ID_exemplaire = exemplaire.ID_exemplaire AND
                                         exemplaire.ID_exemplaire = emprunt.ID_exemplaire AND
                                         livres.titre = :titre');

   $request->bindParam(':titre', $rechercherLivre);
   $request->execute();

   if($request->rowCount() == 0)
   {
     echo '<p>Le livre saisit n\'est pas référencé dans la bibliothèque.</p>';
     echo '<p>Cliquer sur le lien ci-dessous pour ressaissir un livre :</p>';
     ?>
     <p><a href="RechercheLivre.php">Saisir de nouveau un livre</a></p><?php
   }
   else
   {
     while($displayContent = $request->fetch(PDO::FETCH_ASSOC))
     {
       echo '<p>Voici tout les numéros d\'exemplaire correspondant au livre ', $rechercherLivre, '</p>';
       echo '<p>Livre : ', $displayContent['titre'], '</p>';
       echo '<p>Numero d\'exemplaire :', $displayContent['ID_exemplaire'], '</p>';
       echo '<p>Etat du livre : ', $displayContent['etat'], '</p>';
     }
   }
}

//--------------------------Fonctions modification de livres--------------------------

function ModificationEtatLivre(&$connexion, $rechercherLivre, $numeroExemplaire, $etatLivre)
{
  $update  = $connexion->prepare('UPDATE
                                  livres INNER JOIN implementation ON
                                  livres.ID_livre = implementation.ID_livre
                                  INNER JOIN exemplaire ON
                                  implementation.ID_exemplaire = exemplaire.ID_exemplaire
                                  INNER JOIN emprunt ON
                                  exemplaire.ID_exemplaire = emprunt.ID_exemplaire
                                  SET exemplaire.etat = :etat
                                  WHERE exemplaire.ID_exemplaire = :numero');
  $update->bindParam(':etat', $etatLivre);
  $update->bindParam(':numero', $numeroExemplaire);

  $request = $connexion->prepare('SELECT COUNT(*)
                                  FROM livres INNER JOIN implementation ON
                                  livres.ID_livre = implementation.ID_livre
                                  INNER JOIN exemplaire ON
                                  implementation.ID_exemplaire = exemplaire.ID_exemplaire
                                  INNER JOIN emprunt ON
                                  exemplaire.ID_exemplaire = emprunt.ID_exemplaire
                                  WHERE livres.titre = :titre AND exemplaire.ID_exemplaire = :numero');
  $request->bindParam(':titre', $rechercherLivre);
  $request->bindParam(':numero', $numeroExemplaire);
  $request->execute();
  if($request->fetchColumn())
  {
    echo 'La valeur que vous avez choisie correspond à aucun exemplaire du livre!';
  }
  else
  {
    $update->execute();
    header('Location:ApplicationWeb.php');
  }
}
?>
