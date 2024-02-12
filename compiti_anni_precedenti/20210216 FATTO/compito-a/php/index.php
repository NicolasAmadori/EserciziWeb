<?php

$db = new mysqli("localhost", "root", "", "febbraio", 3306);
$valori = array();
foreach(prendiDati($db) as $dato) {
    $valori[$dato["chiave"]] = $dato["valore"];
}

if(isset($_GET["chiave"]) && isset($_GET["valore"]) && isset($_GET["metodo"])) {
    switch($_GET["metodo"]) {
        case "cookie":
            if(isset($_COOKIE[$_GET["chiave"]])) {
                echo "Chiave già presente nei cookie";
            }
            else {
                setcookie($_GET["chiave"], $_GET["valore"]);
            }
            break;
        case "db":
            $presente = false;
            foreach($valori as $chiave=>$valore) {
                if($chiave == $_GET["chiave"]) {
                    $presente = true;
                    break;
                }
            }
            if($presente) {
                echo "Chiave già presente nel db";
            }
            else {
                aggiungiDato($db, $_GET["chiave"], $_GET["valore"]);
                $valori[$_GET["chiave"]] = $_GET["valore"];
            }
            break;
        default:
            echo "Errore! Metodo selezionato non corretto.";
            break;
    }
}


function prendiDati($db) {
    $stmt = $db->prepare("SELECT * FROM dati");
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function aggiungiDato($db, $chiave, $valore) {
    $stmt = $db->prepare("INSERT INTO dati (chiave, valore) VALUES (?, ?)");
    $stmt->bind_param("ss", $chiave, $valore);
    $stmt->execute();
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Esame</title>
    </head>
    <body>
        <h1>Db</h1>
        <ul>
            <?php if(isset($_COOKIE)):?>
                <?php foreach($_COOKIE as $chiave=>$valore):?>
                    <li><?php echo $chiave." : ".$valore ?></li>
                <?php endforeach;?>
            <?php endif;?>
        </ul>
        <h1>Cookie</h1>
        <ul>
            <?php foreach($valori as $chiave=>$valore):?>
                <li><?php echo $chiave." : ".$valore ?></li>
            <?php endforeach;?>
        </ul>
    </body>
</html>