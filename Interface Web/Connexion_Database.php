<?php
$servername = 'localhost';
$username = 'root';
$password = '';
try
{
  $connexion = new PDO("mysql:host=$servername;dbname=projet_bibliotheque", $username, $password);
  $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $connexion->beginTransaction();
  $connexion->commit();
  require 'GestionLivre/Fonctions/functions.php';
  require 'GestionLivre/Fonctions/functions2.php';
  require 'Inscription/Fonctions/functions.php';
  require 'Inscription/Fonctions/functions2.php';
  require 'EmpruntLivre/Emprunt1/Fonctions/functions.php';
  require 'EmpruntLivre/Emprunt2/Fonctions/functions.php';
  require 'EmpruntLivre/Emprunt2/Fonctions/functions2.php';
  require 'EmpruntLivre/Fonctions/functions.php';
  require 'RetourLivre/Fonctions/functions.php';
}
catch(PDOException $e)
{
  $connexion->rollback();
  echo "Erreur : " . $e->getMessage();
}

?>
