<?php
require '../../Connexion_Database.php';
session_start();

unset($_SESSION["Tableau"]);
unset($_SESSION['tableauLivre_Titre']);
unset($_SESSION['nbrLivres']);
session_destroy();

header('Location:../Solution.php');
