<?php
session_start();
require '../../Connexion_Database.php';
require '../../phpqrcode/qrlib.php';


$tableau_numeroExemplaire = array();
$tableau_titreLivre = array();
$tableauLivre_Titre = array();

Preparation($connexion, $_SESSION['nbrLivres'], $tableau_numeroExemplaire, $tableau_titreLivre, $_SESSION['Client'], $tableauLivre_Titre);
EmpruntExemplaires($_SESSION['nbrLivres'], $tableau_numeroExemplaire, $tableau_titreLivre, $tableauLivre_Titre);

echo '<pre>';
print_r($tableau_numeroExemplaire);
echo '</pre>';

echo '<pre>';
print_r($tableauLivre_Titre);
echo '</pre>';



?>
<p><a href="supprSESSION.php">cliquer ici</a></p>
