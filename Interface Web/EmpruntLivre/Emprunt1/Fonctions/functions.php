<?php

function ConfirmationLivre($connexion, $numeroLivre, $numeroClient)
{
  $request = $connexion->prepare('SELECT ID_exemplaire FROM exemplaire
                                  WHERE ID_exemplaire = :numero');
  $request->bindParam(':numero', $numeroLivre);
  $request->execute();

  if($request->fetchColumn())
  {
    header('Location:Emprunt1.php?numeroLivre='.$numeroLivre);
  }
  else
  {
    header('Location:../ListeErreurs.php?numeroLivreInconnu='.$numeroLivre);
  }
}

function ConfirmationEmprunt($connexion, $numeroLivre, $numeroClient)
{
  $request = $connexion->prepare('SELECT ID_exemplaire FROM emprunt
                                  WHERE Disponibilite = "Disponible" AND
                                  ID_exemplaire = :livre');
  $request->bindParam(':livre', $numeroLivre);
  $request->execute();

  if($request->fetchColumn())
  {
    $insert = $connexion->prepare('UPDATE emprunt
                                   SET Date_emprunt = NOW(), Date_retour = NOW() + INTERVAL 21 DAY, Disponibilite = "Emprunter", ID_adherent = :client
                                   WHERE ID_exemplaire = :livre');
    $insert->bindParam(':client', $numeroClient);
    $insert->bindParam(':livre', $numeroLivre);
    $insert->execute();
    header('Location:supprSESSION.php?emprunt');
  }
  else
  {
    echo '<p>Le libre a déjà était emprunté ou réservé, vous ne pouvez donc pas l\'emprunter<br>
          Cliquer <a href=../Solution.php>ici</a> pour emprunter un livre disponible';
  }
}
