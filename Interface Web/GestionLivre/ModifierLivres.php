<?php
require '../Connexion_Database.php';

if(!empty($_POST['rechercheLivre']))
{
  $rechercherLivre = $_POST['rechercheLivre'];
  RechercheLivre($connexion, $rechercherLivre);
}
else
{
  echo "Formulaire vide! Veuillez reéssayer!";
}
$request = $connexion->prepare('SELECT titre FROM livres WHERE titre = :titre');
$request->bindParam(':titre', $rechercherLivre);
$request->execute();
if($request->fetchColumn())
{
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <section>
      <h3>Saisir le numero de l'exemplaire pour modifier son état</h3>
    <form action="Traitement_modifierLivres.php" method="post">
      <p><input type="text" name="rechercherLivre" value= <?php echo $rechercherLivre ?> style="display: none;"></p>
      <p><label for="Numero">Saisir un numero d'exemplaire : </label><input type="number" name="numeroExemplaire" id="Numero"></p>
      <p>Etat de l'exemplaire : <br>
      <label for="Abîmé">Abîmé </label><input type="radio" name="etat" values="Abîmé" id='Abîmé'><br>
      <label for="Correct">Correct <input type="radio" name="etat" value="Correct" id="Correct"><br>
      <label for="Neuf">Neuf <input type="radio" name="etat" value="Neuf" id="Neuf"></p>
      <p><input type="submit" value="Valider"></p>
    </form>
  </body>
</html>
<?php
}
 ?>
