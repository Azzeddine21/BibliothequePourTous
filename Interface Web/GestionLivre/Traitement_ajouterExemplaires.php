<?php
require '../Connexion_Database.php';


  $numeroLivre = htmlspecialchars($_POST["numero"]);
  $achat = htmlspecialchars($_POST["achat"]);
  $editeur = htmlspecialchars($_POST["editeur"]);
  $etat = htmlspecialchars($_POST["etat"]);
  echo $numeroLivre;
  AjouterExemplaires($connexion, $numeroLivre, $achat, $editeur, $etat, $_POST["vide"]);
