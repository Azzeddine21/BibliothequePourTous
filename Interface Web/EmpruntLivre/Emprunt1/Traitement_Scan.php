<?php
session_start();
require '../../Connexion_Database.php';

if(isset($_GET['valeur']) && isset($_SESSION['Client']))
{
  ConfirmationLivre($connexion, $_GET['valeur'], $_SESSION['Client']);
}
?>
