<?php
session_start();
require '../../Connexion_Database.php';
$tableauLivre = array();
$i = 0;

while($i < $_SESSION['nbrLivres'])
{
  $tableauLivre[] = htmlspecialchars($_POST[$i]);
  $i++;
}

VerificationSaisie($connexion, $tableauLivre, $_SESSION['nbrLivres']); //Verifier si les données utilisateurs sont prescrites.
SelectionTitres($connexion, $tableauLivre);
ListeExemplaires($connexion, $tableauLivre, $_SESSION['nbrLivres'], $_SESSION['Client']);
?>
