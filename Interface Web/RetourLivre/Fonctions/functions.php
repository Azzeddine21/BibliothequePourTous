<?php

function Authentification($connexion, $numeroAdherent)
{
  if(!empty($_POST['numero']))
  {
    $numeroAdherent = $_POST['numero'];
    $request = $connexion->prepare('SELECT ID_adherent FROM adherent
                                    WHERE ID_adherent = :numero');
    $request->bindParam(':numero', $numeroAdherent);
    $request->execute();
    if(!$request->fetchColumn())
    {
      echo '<p>Le numero d\'adherent saisie n\'existe pas!!</p>';
    }
    else
    {
      $request = $connexion->prepare('SELECT ID_adherent FROM emprunt
                                      WHERE ID_adherent = :numero');
      $request->bindParam(':numero', $numeroAdherent);
      $request->execute();
      if(!$request->fetchColumn())
      {
        echo '<p>Vous n\'avez emprunte encore aucun livre.</p>';
      }
      else
      {
        header('Location:QRcode.php?numero='. $numeroAdherent);
      }
    }
  }
}


function Liste_LivresEmpruntés($connexion, $numeroAdherent, &$listeLivres, &$listeExemplaires)
{
  $request = $connexion->prepare('SELECT L.titre FROM livres L
                                  INNER JOIN implementation I ON
                                  L.ID_livre = I.ID_livre
                                  INNER JOIN exemplaire EX ON
                                  I.ID_exemplaire = EX.ID_exemplaire
                                  INNER JOIN emprunt EM ON
                                  EX.ID_exemplaire = EM.ID_exemplaire
                                  INNER JOIN adherent A ON
                                  EM.ID_adherent = A.ID_adherent
                                  WHERE EM.ID_adherent = :numero');
  $request->bindParam(':numero', $numeroAdherent);
  $request->execute();
  while($content = $request->fetch())
  $listeLivres[] = $content['titre'];

  $request = $connexion->prepare('SELECT ID_exemplaire FROM emprunt
                                  WHERE ID_adherent = :numero');
  $request->bindParam(':numero', $numeroAdherent);
  $request->execute();
  while($content = $request->fetch())
  $listeExemplaires[] = $content['ID_exemplaire'];
}

function QRcode($listeLivres, $listeExemplaires)
{
  for($i = 0; $i < count($listeExemplaires); $i++)
  {
    echo "<p>QRcode du livre '", $listeLivres[$i], "'</p>";
    $content = $listeExemplaires[$i];
    $filename = "../phpqrcode/QRcode/". $i .".png";
    $errorCorrectionLevel = 'H';
    $matrixPointSize = 10;
    QRcode::png($content, $filename, $errorCorrectionLevel, $matrixPointSize); ?>
    <p><img src= <?php echo $filename; ?> alt="QRcode"></p><?php
  }
}
