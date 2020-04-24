<?php

function InscriptionAdherent(&$connexion, $prenom, $nom, $mdp, $mail)
{
  $numero = rand(0, 9999);
  $request = $connexion->prepare('SELECT COUNT(*) FROM adherent
                                 WHERE ID_adherent = :numero');
  $request->bindParam(':numero', $numero);
  $request->execute();
  if($request->fetchColumn())
  {
    echo 'Une erreur s\'est produite, cliquer
         <a href="Inscription.php">ici</a>
         pour recommencer';
  }
  else
  {
    $request = $connexion->prepare('SELECT COUNT(*) FROM adherent
                                    WHERE mail = :mail');
    $request->bindParam(':mail', $mail);
    $request->execute();

    if(!$request->fetchColumn())
    {
      $insert = $connexion->prepare('INSERT INTO adherent
                                     VALUES(:numero, :nom, :prenom, :mdp, :mail)');
      $insert->bindParam(':numero', $numero);
      $insert->bindParam(':nom', $nom);
      $insert->bindParam(':prenom', $prenom);
      $insert->bindParam(':mdp', $mdp);
      $insert->bindParam(':mail', $mail);
      $insert->execute();

      $request = $connexion->prepare('SELECT ID_adherent FROM adherent
                                      WHERE mail = :mail');
      $request->bindParam(':mail', $mail);
      $request->execute();

      while($display = $request->fetch(PDO::FETCH_ASSOC))
      {
        echo '<p>Votre numero d\'identifiant : ', $display['ID_adherent'], '</p>';
        echo '<p>Utilisez le pour emprunter des livres chez nous, retour <a href=../Menu.php>ici</a></p>';
      }
    }
    else
    {
      header('Location:bbb.php');
    }
  }
}

?>
