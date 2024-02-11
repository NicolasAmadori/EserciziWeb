<?php

$db = new mysqli("localhost", "root", "", "db_esami", 3306);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["codiceFiscale"]) && isset($_POST["dataDiNascita"]) && isset($_POST["sesso"])) {
        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
        $codiceFiscale = $_POST["codiceFiscale"];
        $dataDiNascita = $_POST["dataDiNascita"];
        $sesso = $_POST["sesso"];
        if(is_string($nome) && is_string($cognome) && is_string($codiceFiscale) && strlen($codiceFiscale) == 16 && date_format(date_create($dataDiNascita), "YYYY-MM-DD") && ($sesso == "M" || $sesso == "F" || $sesso == "A")) {
            $stmt = $db->prepare("INSERT INTO cittadino (nome, cognome, codicefiscale, datanascita, sesso) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nome, $cognome, $codiceFiscale, $dataDiNascita, $sesso);
            $stmt->execute();
            if(!$db->error) {
                echo "Inserimento avvenuto con successo!";
            }
        }
    }
}

$query = "SELECT * FROM cittadino";
if (isset($_GET["id"])) {
    $query = $query." WHERE cittadino.idcittadino = ?";
}
$stmt = $db->prepare($query);
if (isset($_GET["id"])) {
    $stmt->bind_param("s", $_GET["id"]);
}
$stmt->execute();
$result = $stmt->get_result();
$cittadini = $result->fetch_all(MYSQLI_ASSOC);
?>

<html>

<head>
    <title>Esame</title>
</head>

<body>
    <form action="index.php" method="POST">
        <ul>
            <li>
                <label for="nome">Nome</label>
                <input id="nome" name="nome" type="text">
            </li>
            <li>
                <label for="cognome">Cognome</label>
                <input id="cognome" name="cognome" type="text">
            </li>
            <li>
                <label for="codiceFiscale">Codice Fiscale</label>
                <input id="codiceFiscale" name="codiceFiscale" type="text" maxlength="16">
            </li>
            <li>
                <label for="dataDiNascita">Data di nascita</label>
                <input id="dataDiNascita" name="dataDiNascita" type="date">
            </li>
            <li>
                <label for="Sesso">Sesso</label>
                <select id="sesso" name="sesso">
                    <option value="M">M</option>
                    <option value="F">F</option>
                    <option value="A">A</option>
                </select>
            </li>
        </ul>
        <input type="submit" id="submit" value="Aggiungi cittadino">
    </form>
    <table>
        <tr>
            <th id="nome" scope="col">Nome</th>
            <th id="cognome" scope="col">Cognome</th>
            <th id="cf" scope="col">Codice Fiscale</th>
            <th id="data" scope="col">Data di Nascita</th>
            <th id="sesso" scope="col">Sesso</th>
        </tr>
    <?php foreach($cittadini as $cittadino): ?>
        <tr>
            <td headers="nome"><?php echo $cittadino["nome"] ?></td>
            <td headers="cognome"><?php echo $cittadino["cognome"] ?></td>
            <td headers="cf"><?php echo $cittadino["codicefiscale"] ?></td>
            <td headers="data"><?php echo $cittadino["datanascita"] ?></td>
            <td headers="sesso"><?php echo $cittadino["sesso"] ?></td>
        </tr>
    <?php endforeach;?>
    </table>
</body>

</html>