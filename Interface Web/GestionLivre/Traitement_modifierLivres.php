<?php
require '../Connexion_Database.php';

if(!empty($_POST['rechercherLivre']) && !empty($_POST['numeroExemplaire']) && !empty($_POST['etat']))
{
  $rechercherLivre = $_POST['rechercherLivre'];
  $numeroExemplaire = $_POST['numeroExemplaire'];
  $etatLivre = $_POST['etat'];

  ModificationEtatLivre($connexion, $rechercherLivre, $numeroExemplaire, $etatLivre);
}
else
{
  echo "Présence d'un ou plusieurs formulaires vides! Veuillez reéssayer!";
}
