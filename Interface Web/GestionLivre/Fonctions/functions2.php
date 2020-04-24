<?php

//--------------------------Fonctions d'ajout de livres--------------------------
  //Insertion des numeros dans l'implementation


function InsertionNumero($connexion, $numeroLivre, $numeroExemplaire, $vide)
{
   $titre = "";
   $insert = $connexion->prepare("INSERT INTO implementation VALUES(:numeroLivre, :numeroExemplaire)");
   $insert->bindParam(":numeroLivre", $numeroLivre);
   $insert->bindParam(":numeroExemplaire", $numeroExemplaire);
   $insert->execute();

   $request = $connexion->prepare("SELECT titre FROM livres WHERE ID_livre = :numero");
   $request->bindParam(":numero", $numeroLivre);
   $request->execute();
   while($display = $request->fetch())
   $titre = $display["titre"];

   if($vide == "true")
   header("Location:ajouterExemplaires?livre_titre=".$titre);
   else
   header("Location:ajouterExemplaires");
}

?>
