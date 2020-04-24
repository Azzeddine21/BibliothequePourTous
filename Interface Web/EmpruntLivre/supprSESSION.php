<?php
require '../Connexion_Database.php';

if(isset($_GET['emprunt']))
{
  unset($_SESSION['Livre']);
  header('Location:Solution.php');
}
elseif (isset($_GET['quitter']))
{
  unset($_SESSION['numeroClient']);
  session_destroy();
  header('Location:../Menu.php');
}
