<?php
$db = new mysqli("localhost", "root", "", "settembre", 3306);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["nome"]) && isset($_POST["altezza"]) && isset($_POST["peso"])) {
        aggiugiPersonaggio($db, $_POST["nome"], $_POST["altezza"], $_POST["peso"]);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo json_encode(ottieniPersonaggi($db));
}

function aggiugiPersonaggio($db, $nome, $altezza, $peso) {
    $stmt = $db->prepare("INSERT INTO starwars (name, height, mass) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $nome, $altezza, $peso);
    $stmt->execute();
}

function ottieniPersonaggi($db) {
    $stmt = $db->prepare("SELECT name, height, mass FROM starwars");
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>