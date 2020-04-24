<?php
require 'Connexion_Database.php';

if(isset($_GET['variable']))
{
  $numero = $_GET['variable'];
  $request = $connexion->prepare('SELECT ID_exemplaire FROM exemplaire
                                 WHERE ID_exemplaire = :numero');
  $request->bindParam(':numero', $numero);
  $request->execute();
  if($request->fetchColumn())
  {
    $request = $connexion->prepare('SELECT COUNT(*) FROM emprunt
                                    WHERE ID_exemplaire = :numero AND
                                    ID_adherent is NOT NULL');
    $request->bindParam(':numero', $numero);
    $request->execute();

    if($request->fetchColumn())
    {
      $request = $connexion->prepare('SELECT Date_retour FROM emprunt
                                      WHERE ID_exemplaire = :numero AND
                                      Date_retour is NOT NULL');
      $request->bindParam(':numero', $numero);
      $request->execute();
      if(!$request->fetchColumn())
      {
        $insert = $connexion->prepare('UPDATE emprunt
                                       SET Date_emprunt = NOW(), Date_retour = NOW() + INTERVAL 21 DAY, Disponibilite = "Emprunter"
                                       WHERE ID_exemplaire = :numero');
        $insert->bindParam(':numero', $numero);
        $insert->execute();
        header('Location:qrcode.php');
      }
      else
      {
        echo "Livre deja emprunte";
        echo "<p>Retour <a href=qrcode.php>ici</a>";
      }
    }
    else
    {
      echo "<p>Impossible de scanner le QRcode tant que le livre n'a pas était emprunté via l'interface web.</p>";
      echo "<p>Retour <a href=qrcode.php>ici</a>";
    }
  }
  else
  {
    echo "QRcode inconnu, veuillez reéssayer <a href=qrcode.php>ici</a>.";
  }
}
else
{
  echo "Erreur!";
}
