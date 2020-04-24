<?php
require '../Connexion_Database.php';
require '../phpqrcode/qrlib.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body><?php
    $listeExemplaires = array();
    $listeLivres = array();
    $numeroAdherent = $_GET['numero'];
    Liste_LivresEmpruntés($connexion, $numeroAdherent, $listeLivres, $listeExemplaires);
    QRcode($listeLivres, $listeExemplaires); ?>
  </body>
</html>
