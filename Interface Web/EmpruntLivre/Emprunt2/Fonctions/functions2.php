<?php
function Saisie($connexion, $tableauLivre, $nombreLivres, $i)
{
  $_SESSION["Tableau"][$i] = $tableauLivre[$i];

  ?>
  <form  action="AffichageQRcode.php" method="post">
  <p><label for="Saisie">Saisir un numero d'exemplaire : </label><input type="number" name=<?php echo $i; ?> id="Saisie"></p><?php
}

function InsertionAdherent_dansExemplaire(&$connexion, $tableau_numeroExemplaire, $numeroAdherent)
{
  $i = 0;
  $taille = count($tableau_numeroExemplaire);
  while($i < $taille)
  {
    $insert2 = $connexion->prepare('UPDATE emprunt SET ID_adherent = :numero
                                   WHERE ID_exemplaire = :exemplaire');
    $insert2->bindParam(':numero', $numeroAdherent);
    $insert2->bindParam(':exemplaire', $tableau_numeroExemplaire[$i]);
    $insert2->execute();
    $i++;
  }
}




?>
