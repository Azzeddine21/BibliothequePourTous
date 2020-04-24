<?php
function AjoutEmprunteur($connexion, $numero, $mdp)
{
  $request = $connexion->prepare('SELECT ID_adherent, mdp FROM adherent
                                  WHERE ID_adherent = :numero');
  $request->bindParam(':numero', $numero);
  $request->execute();

  if($request->fetchColumn())
  {
    $request->execute();
    while($content = $request->fetch())
    {
      if($mdp == $content['mdp'])
      {
        $request = $connexion->prepare('SELECT ID_adherent FROM emprunt
                                        WHERE ID_adherent = :numero');
        $request->bindParam(':numero', $numero);
        $request->execute();

        if(!$request->fetchColumn())
        {
          header('Location:NombreLivres.php?numero='. $numero);
        }
        else
        {
          echo 'Vous avez deja emprunte';
        }
      }
      else
      {
        header('Location:../ListeErreurs.php?mdpIncorrect=0');
      }
    }
  }
  else
  {
    header('Location:../ListeErreurs.php?numeroInconnu=0');
  }

}

function VerificationSaisie($connexion, &$tableauLivre, $nombreLivres)
{
  $i = 0;
  while($i < $nombreLivres)
  {
    if(empty($tableauLivre[$i]))
    {
      echo "Un formulaire est vide, veuillez recommencer
            en cliquant <a href=NombreLivres.php>ici</a>";
      break;
    }
    $i++;
  }
}

function SelectionTitres($connexion, $tableauLivre)
{
  $count = count($tableauLivre);
  for($i = 0; $i < $count; $i++)
  {
    $request = $connexion->prepare('SELECT titre FROM livres
                                    WHERE numero_livre = :numero');
    $request->bindParam(':numero', $tableauLivre[$i]);
    $request->execute();
    while($content = $request->fetch())
    {
      $_SESSION['tableauLivre_Titre'][] = $content['titre'];
    }
  }
}


function ListeExemplaires(&$connexion, $tableauLivre, $nombreLivres, $numeroAdherent)
{
  $i = 0;
  while($i < $nombreLivres)
  {
    $request = $connexion->prepare('SELECT *
                                           FROM livres, auteur, exemplaire, emprunt, implementation
                                           WHERE
                                           livres.ID_auteur = auteur.ID_auteur AND
                                           livres.ID_livre = implementation.ID_livre AND
                                           implementation.ID_exemplaire = exemplaire.ID_exemplaire AND
                                           exemplaire.ID_exemplaire = emprunt.ID_exemplaire AND
                                           livres.ID_livre = :numeroLivre AND
                                           emprunt.ID_adherent is NULL');
    $request->bindParam(':numeroLivre', $tableauLivre[$i]);
    $request->execute();

    if($request->rowCount() == 0)
    {
      header("Location:Indisponible.php");
    }
    else
    {
      echo '<h3>Exemplaires du livre ', $i+1, '</h3>';
      while($display = $request->fetch(PDO::FETCH_ASSOC))
      {
        echo '<section>';
        echo '<p>Titre du livre : ', $display['titre'], '<br>',
             'Auteur : ', $display['prenom'], ' ', $display['nom'], '<br>',
             'Numero d\'exemplaire :', $display['ID_exemplaire'], '<br>',
             'Etat de l\'exemplaire :', $display['etat'], '<br>',
             'Edition :', $display['edition'], '</p>';
      }
      Saisie($connexion, $tableauLivre, $nombreLivres, $i);
    }
    $i++;
  } ?>
  <p><input type="submit" value="Valider"></p>
</form> <?php
}


function Preparation($connexion, $nombreLivres, &$tableau_numeroExemplaire, &$tableau_titreLivre, $numeroAdherent, &$tableauLivre_Titre)
{
  $i = 0;
  $j = 0;
  $z = 0;

  while($i < $nombreLivres )
  {
    $tableau_numeroExemplaire[$i] = $_POST[$i];
    $i++;
  }

  while($j < count($_SESSION["Tableau"]))
  {
    $tableau_titreLivre[$j] = $_SESSION["Tableau"][$j];
    $j++;
  }

  while($z < count($_SESSION['tableauLivre_Titre']))
  {
    $tableauLivre_Titre[$z] = $_SESSION['tableauLivre_Titre'][$z];
    $z++;
  }


  InsertionAdherent_dansExemplaire($connexion, $tableau_numeroExemplaire, $numeroAdherent);
}

function EmpruntExemplaires($nombreLivres, $tableau_numeroExemplaire, $tableau_titreLivre, $tableauLivre_Titre)
{
  $i = 0;
  while($i < $nombreLivres)
  {
    echo "<p>QRcode de l'exemplaire du livre ", $tableauLivre_Titre[$i], " :</p> ";
    $content= $tableau_numeroExemplaire[$i];
    $filename = "../../phpqrcode/QRcode/". $i .".png";
    $errorCorrectionLevel = 'H';
    $matrixPointSize = 10;
    QRcode::png($content, $filename, $errorCorrectionLevel, $matrixPointSize); ?>
    <p><img src= <?php echo $filename; ?> alt="QRcode"></p><?php
    $i++;
  }
}


/*$prenom = '';
$nom = '';
$mail = '';

$request = $connexion->prepare('SELECT ID_adherent, prenom, nom, mail FROM adherent
                                WHERE ID_adherent = :numero');
$request->bindParam(':numero', $numero);
$request->execute();

if($request->fetchColumn())
{
  $request->execute();
  while($display = $request->fetch(PDO::FETCH_ASSOC))
  {
    $numero = $display['ID_adherent'];
    $prenom = $display['prenom'];
    $nom = $display['nom'];
    $mail = $display['mail'];
  }

  $request = $connexion->prepare('SELECT COUNT(*) FROM emprunteur
                                  WHERE ID_emprunteur = :numero');
  $request->bindParam(':numero', $numero);
  $request->execute();
  if(!$request->fetchColumn())
  {
    $request->execute();
    $request = $connexion->prepare('INSERT INTO emprunteur
                                      VALUES(:numero, :nom, :prenom, :mail)');
    $request->bindParam(':numero', $numero);
    $request->bindParam(':nom', $nom);
    $request->bindParam(':prenom', $prenom);
    $request->bindParam(':mail', $mail);
    $request->execute();
    header('Location:NombreLivres.php?numero='. $numero);
  }
  else
  {
    echo "<p>Vous avez déjà emprunté des livres!<br>
          Assurez vous de rendre ceux en votre possession avant la date limite pour emprunter de nouveau</p>";
    echo "<p>Retour menu <a href=../Menu.php>ici</a></p>";
  }
}
else
{
  echo '<p>Le numero ', $numero, " est introuvable.</p>";
  echo '<p>Veuillez contacter le service technique pour plus de renseignements <br>
        Cliquer <a href=Emprunteur.php>ici</a> pour recommencer</p>';
}*/






/*$request = $connexion->prepare('SELECT ID_adherent FROM adherent
                                WHERE ID_adherent = :numero');
$request->bindParam(':numero', $numero);
$request->execute();

if($request->fetchColumn())
{
  $request = $connexion->prepare('SELECT ID_adherent FROM emprunt
                                  WHERE ID_adherent = :numero');
  $request->bindParam(':numero', $numero);
  $request->execute();

  if(!$request->fetchColumn())
  {
    header('Location:NombreLivres.php?numero='. $numero);
  }
  else
  {
    echo 'Vous avez deja emprunte';
  }
}
else
{
  echo 'Numero inexistant';
}*/
