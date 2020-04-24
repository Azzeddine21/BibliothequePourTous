<?php
require "../Connexion_Database.php";

if(!empty($_POST['prenom']) AND !empty($_POST['nom']) AND !empty($_POST['mail']))
{
  $prenom = $_POST['prenom'];
  $nom = $_POST['nom'];
  $mdp = $_POST['password'];
  $mail = $_POST['mail'];

  InscriptionAdherent($connexion, $prenom, $nom, $mdp, $mail);
}
