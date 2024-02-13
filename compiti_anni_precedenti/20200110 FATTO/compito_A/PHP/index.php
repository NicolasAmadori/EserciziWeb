<?php
$db = new mysqli("localhost", "root", "", "climate", 3306);

$città = ottieniCitta($db);

if(isset($_GET["citta"])) {
  $informazioniCitta = tempCittà($db, $_GET["citta"]);
}
function ottieniCitta($db) {
  $stmt = $db->prepare("SELECT citta FROM temperature");
  $stmt->execute();
  return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function tempCittà($db, $citta) {
  $stmt = $db->prepare("SELECT * FROM temperature WHERE citta = ?");
  $stmt->bind_param("s", $citta);
  $stmt->execute();
  return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<html lang="it">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>Città Italiane</title>
  </head>
  <body>
    <form action="index.php" method="GET">
      <label for="citta">Città</label>
      <select name="citta">
        <?php foreach($città as $c):?>
          <option value="<?php echo $c["citta"]?>"><?php echo $c["citta"]?></option>
        <?php endforeach;?>
      </select>
      <input type="submit" value="Invia" />
    </form>
    <?php if(isset($informazioniCitta)):?>
        <p><?php echo $informazioniCitta[0]["min"]?></p>
        <p><?php echo $informazioniCitta[0]["max"]?></p>
        <p><?php echo $informazioniCitta[0]["citta"]?></p>
      <?php endif;?>
  </body>
</html>
