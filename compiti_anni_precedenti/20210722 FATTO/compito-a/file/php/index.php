<?php
$db = new mysqli("localhost", "root", "", "lotto", 3306);
$actions = ["extract", "new", "check"];
if(isset($_GET["action"]) && in_array($_GET["action"], $actions)) {
    switch($_GET["action"]) {
        case "extract":
            $numeriEstratti = getExtractedNumbers($db);
            if(count($numeriEstratti) < 5) {
                do {
                    $numeroEstratto = random_int(1,90);
                }while(in_array($numeroEstratto, $numeriEstratti));
                addNumber($db, $numeroEstratto);
            }
            else {
                sendMessage("Errore! Sono stati gia estratti 5 numeri");
            }
            break;
        case "new":
            cancellaTutti($db);
            sendMessage("Partita avviata!");
            break;
        case "check":
            if(isset($_GET["sequence"])) {
                $numeriEstratti = getExtractedNumbers($db);
                $numeriDaControllare = explode("-",$_GET["sequence"]);
                if(count(array_diff($numeriDaControllare, $numeriEstratti)) != 0) {
                    sendMessage("Sconfitta");
                }
                else {
                    sendMessage("Vittoria");
                }
            }
            else {
                sendMessage("Errore! Variabile sequence non presente");
            }
            break;
    }
}


function getExtractedNumbers($db) {
    $stmt = $db->prepare("SELECT * FROM estrazione");
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $numeri = array();
    foreach($result as $row) {
        $numeri[] = $row["numero"];
    }
    return $numeri;
}

function addNumber($db, $numero) {
    $stmt = $db->prepare("INSERT INTO estrazione (numero) VALUES (?)");
    $stmt->bind_param("i", $numero);
    $stmt->execute();
}

function cancellaTutti($db) {
    $stmt = $db->prepare("DELETE FROM estrazione");
    $stmt->execute();
}

function sendMessage($text) {
    $message = array(
        "message" => $text
    );
    echo json_encode($message);
}
?>