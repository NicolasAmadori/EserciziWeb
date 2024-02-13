<?php
$db = new mysqli("localhost", "root", "", "febbraio", 3306);

$articoli = ottieniArticoli($db, isset($_COOKIE["categoria"]) ? $_COOKIE["categoria"] : null);
echo $_COOKIE["categoria"];
function ottieniArticoli($db, $categoria) {
  $query = "SELECT * FROM articoli";
  if(!is_null($categoria)) {
    $query.=" WHERE categoria = ?";
  }
  $stmt = $db->prepare($query);
  if(!is_null($categoria)) {
    $stmt->bind_param("s", $categoria);
  }
  $stmt->execute();
  return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<html lang="it">
  <head>
    <title>Esercizio PHP</title>
  </head>
  <body>
    <div class="header">
      <a  class="home">Esercizio PHP</a>
      <div class="products">
        <a href="index.php">Homepage</a>
        <a href="settings.php">Settings</a>
      </div>
    </div>
    <article>
      <?php foreach($articoli as $art):?>
        <div>
          <h1><?php echo $art["titolo"]?></h1>
          <p><?php echo $art["descrizione"]?></p>
        </div>
      <?php endforeach; ?>
    </article>
  </body>
</html>
