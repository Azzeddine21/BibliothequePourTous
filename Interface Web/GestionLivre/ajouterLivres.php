<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Modifier Bibliothéque</title>
  </head>
  <body>
    <section>
      <h3>Ajouter un livre</h3>
        <form action="Traitement_ajoutLivres.php" method="post">
          <p><label for="Titre">Titre : </label><input type="text" name="titre" id="Titre"></p>
          <p><label for="Date_Parution">Date de parution : </label><input type="date" name="dateParution" id="Date_Parution"></p>
          <p><label for="Genre"></label>Genre : </label><input type="text" name="genre" id="Genre"></p>
          <p><label for="PrenomAuteur">Prénom de l'auteur : </label><input type="text" name="prenomAuteur" id="PrenomAuteur"></p>
          <p><label for="NomAuteur">Nom de l'auteur : </label><input type="text" name="nomAuteur" id="NomAuteur"></p>
          <p><input type="submit" value="Valider"></p>
        </form>
      </section>
  </body>
</html>
