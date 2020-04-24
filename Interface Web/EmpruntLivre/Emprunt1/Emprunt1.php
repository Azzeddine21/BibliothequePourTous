<?php
session_start();
require '../../Connexion_Database.php';

if(isset($_SESSION['Client']) && isset($_GET['numeroLivre']))
{
  $_SESSION['Livre'] = $_GET['numeroLivre'];

  ConfirmationEmprunt($connexion, $_SESSION['Livre'],  $_SESSION['Client']);
}
else
{
  header('Location:../ListeErreurs.php?erreurEmprunt1='. 0);
}
