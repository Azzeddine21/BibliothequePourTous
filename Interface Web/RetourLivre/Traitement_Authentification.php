<?php
require '../Connexion_Database.php';

if(!empty($_POST['numero']))
{
  $numeroAdherent = $_POST['numero'];
  Authentification($connexion, $numeroAdherent);
}
?>
