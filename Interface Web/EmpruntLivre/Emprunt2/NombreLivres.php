<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ChoixLivre</title>
  </head>
  <body>
    <section>
      <h3>Nombre de livres à emprunter</h3>
      <form action="ChoixLivre.php" method="post">
        <p><label for="N">Nombre de livres : </label><input type="number" name="nombre" id="N"></p>
        <p><input type="submit" value="Valider"></p>
      </form>
    </section>
  </body>
</html>
