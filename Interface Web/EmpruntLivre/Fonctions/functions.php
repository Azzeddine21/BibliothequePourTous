<?php


function Auhentification($connexion, $numero, $password)
{
  $recuperation_mdp = 0;
  $request = $connexion->prepare('SELECT ID_adherent FROM adherent
                                  WHERE ID_adherent = :numero');
  $request->bindParam(':numero', $numero);
  $request->execute();

  if($request->fetchColumn())
  {
    $request = $connexion->prepare('SELECT mdp FROM adherent
                                    WHERE ID_adherent = :numero');
    $request->bindParam(':numero', $numero);
    $request->execute();

    while($display = $request->fetch())
    {
      $recuperation_mdp = $display['mdp'];
    }

    if($password == $recuperation_mdp)
    {
      header('Location:Solution.php?numeroClient='.$numero);
    }
    else
    {
      header('Location:../ListeErreurs.php?mdpIncorrect='.$password);
    }
  }
  else
  {
    header('Location:../ListeErreurs.php?numeroInconnu='.$numero);
  }
}
