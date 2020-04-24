<?php require '../Connexion_Database.php'?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <p><a href="ajouterLivres.php">Apporter des modifications dans la Bibliothéque</a></p>
    <p><a href="RechercheLivre.php">Modifier ou supprimer un livre</a></p>

  <?php
  $array = array();
  $displayRequest = $connexion->prepare('SELECT  *
                                         FROM livres, auteur, exemplaire, emprunt, implementation
                                         WHERE
                                         livres.ID_auteur = auteur.ID_auteur AND
                                         livres.ID_livre = implementation.ID_livre AND
                                         implementation.ID_exemplaire = exemplaire.ID_exemplaire AND
                                         exemplaire.ID_exemplaire = emprunt.ID_exemplaire AND
                                         emprunt.ID_adherent is NULL');

$displayRequest->execute();
echo '<section>';
echo '<h3>Livre présent dans la bibliotheque</h3>';
while($displayContent = $displayRequest->fetch(PDO::FETCH_ASSOC))
{
  echo '<p> Titre du livre :', $displayContent['titre'], '<br>Auteur : ',
  $displayContent['prenom'], ' ', $displayContent['nom'], '<br>',
  'Date de publication : ',$displayContent['date_parution'], '<br>',
  'Numero Exemplaire : ', $displayContent['ID_exemplaire'], '<br>',
  'Date d\'achat : ', $displayContent['date_achat'], '<br>',
  'Etat de l\'exemplaire : ', $displayContent['etat'], '<br>',
  'Edition : ', $displayContent['edition'], '<br>',
  'Disponibilite : ', $displayContent['Disponibilite'], '</p>';
}
echo '</section>';

$displayRequest2 = $connexion->prepare('SELECT  livres.titre, livres.date_parution, auteur.prenom as prenomAuteur, auteur.nom as nomAuteur, exemplaire.ID_exemplaire, exemplaire.etat, exemplaire.edition, exemplaire.date_achat, emprunt.Disponibilite, emprunt.Date_emprunt, emprunt.Date_retour, adherent.nom as nomEmprunteur, adherent.prenom as prenomEmprunteur, adherent.mail
                                       FROM livres, auteur, exemplaire, emprunt, implementation, adherent
                                       WHERE
                                       livres.ID_auteur = auteur.ID_auteur AND
                                       livres.ID_livre = implementation.ID_livre AND
                                       implementation.ID_exemplaire = exemplaire.ID_exemplaire AND
                                       exemplaire.ID_exemplaire = emprunt.ID_exemplaire AND
                                       emprunt.ID_adherent = adherent.ID_adherent AND
                                       emprunt.ID_adherent is NOT NULL');
$displayRequest2->execute();
echo '<section>';
echo '<h3>Livres empruntés</h3>';
while($displayContent = $displayRequest2->fetch(PDO::FETCH_ASSOC))
{
  echo '<p> Titre du livre :', $displayContent['titre'], '<br>Auteur : ',
  $displayContent['prenomAuteur'], ' ', $displayContent['nomAuteur'], '<br>',
  'Date de publication : ',$displayContent['date_parution'],
  '<br>Numero Exemplaire : ', $displayContent['ID_exemplaire'], '<br>',
  'Date d\'achat : ', $displayContent['date_achat'], '<br>',
  'Etat de l\'exemplaire : ', $displayContent['etat'], '<br>',
  'Edition : ', $displayContent['edition'], '<br>',
  'Disponibilite : ', $displayContent['Disponibilite'], '<br>',
  'Emprunteur : ', $displayContent['prenomEmprunteur'], ' ', $displayContent['nomEmprunteur'], '<br>',
  'Emprunté le ', $displayContent['Date_emprunt'], ', à rendre avant le ', $displayContent['Date_retour'], '.</p>';
}
echo '</section>';
?>
  </body>
</html>
