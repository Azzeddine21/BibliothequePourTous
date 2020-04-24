<?php
session_start();
if(isset($_GET['numeroClient']))
{
  $_SESSION['Client'] = $_GET['numeroClient'];
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h3>Emprunt de livres</h3>
    <section>
      <p>Pour emprunter un livre en scannant le QRcode au dos du livre, cliquer <a href="Emprunt1/Scan.php">ici</a></p>
      <p>Si aucun QRcode ne s'y trouve, cliquer <a href="Emprunt2/NombreLivres.php">ici</a></p>
      <p>Pour retourner au Menu, veuillez cliquer <a href="supprSESSION.php?quitter"> ici</a></p>
    </section>


  </body>
</html>
