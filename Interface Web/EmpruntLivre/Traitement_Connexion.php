<?php
require "../Connexion_Database.php";

if(!empty($_POST["numero"]) && !empty($_POST["password"]))
{
  $numero = htmlspecialchars($_POST["numero"]);
  $password = htmlspecialchars($_POST["password"]);

  Auhentification($connexion, $numero, $password);


}
else
{
  echo "<p>Un formulaire est vide, veuillez reéssayer svp <a href=Authentification.php>ici</a></p>";
}
