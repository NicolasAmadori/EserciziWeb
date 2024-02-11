<?php 

$db = new mysqli("localhost", "root", "", "esami", 3306);
if($db->connect_error) {
    die("Errore in connessione al db: ".$db->connect_error);
}

if($_SERVER["REQUEST_METHOD"] == "GET") {
    $statoIniziale = generaStatoIniziale();
    $response = array(
        "statoIniziale" => $statoIniziale
    );
    $stmt = $db->prepare("INSERT INTO sudoku (statoIniziale) VALUES (?)");
    $stmt->bind_param("s", $statoIniziale);
    $stmt->execute();
    setcookie("idPartita", $db->insert_id);

    echo json_encode($response);
}
else if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["stato"]) && isset($_POST["idPartita"])) {
        if($_POST["idPartita"] == $_COOKIE["idPartita"]) {
            $response = array(
                "risultato" => controllaStato($_POST["stato"])
            );
            echo json_encode($response);
        }
    }
}


function generaStatoIniziale() {
    $stato = str_repeat('0', 81);
    $valori = range(1, 9);

    $indiciOccupati = array();
    while(count($valori) > 0) {
        $indice = random_int(0,80);
        if(!in_array($indice, $indiciOccupati)) {
            $stato[$indice] = array_pop($valori);
        }
    }

    return $stato;
}

function controllaStato($stato) {
    // Verifica righe e colonne
    for ($i = 0; $i < 9; $i++) {
        $riga = [];
        $colonna = [];
        for ($j = 0; $j < 9; $j++) {
            $rigaNumero = $stato[$i * 9 + $j];
            $colonnaNumero = $stato[$j * 9 + $i];
            if ($rigaNumero == '0' || $colonnaNumero == '0') {
                return false; // Se c'è uno zero, il Sudoku non è risolto
            }
            if (in_array($rigaNumero, $riga) || in_array($colonnaNumero, $colonna)) {
                return false; // Se ci sono duplicati nella riga o nella colonna, il Sudoku non è risolto
            }
            $riga[] = $rigaNumero;
            $colonna[] = $colonnaNumero;
        }
    }

    // Verifica quadrati 3x3
    for ($k = 0; $k < 9; $k += 3) {
        for ($l = 0; $l < 9; $l += 3) {
            $quadrato = [];
            for ($i = $k; $i < $k + 3; $i++) {
                for ($j = $l; $j < $l + 3; $j++) {
                    $numero = $stato[$i * 9 + $j];
                    if ($numero == '0') {
                        return false; // Se c'è uno zero, il Sudoku non è risolto
                    }
                    if (in_array($numero, $quadrato)) {
                        return false; // Se ci sono duplicati nel quadrato 3x3, il Sudoku non è risolto
                    }
                    $quadrato[] = $numero;
                }
            }
        }
    }

    return true; // Se nessuna violazione è stata trovata, il Sudoku è risolto
}
?>