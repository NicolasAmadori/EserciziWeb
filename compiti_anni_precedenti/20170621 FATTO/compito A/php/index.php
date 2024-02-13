<?php
$db = new mysqli("localhost", "root", "", "giugno", 3306);

if(isset($_GET["A"]) && isset($_GET["B"])) {//Check if exist and != from NULL
    $A = $_GET["A"];
    $B = $_GET["B"];
    $insiemi = prendiInsiemi($db);
    if(is_numeric($A) && is_numeric($B) && $A > 0 && $B > 0 && in_array($A, $insiemi) && in_array($B, $insiemi)) {
        $valoriA = leggiInsieme($db, $A);
        $valoriB = leggiInsieme($db, $B);

        $intersezione = array_intersect($valoriA, $valoriB);
        aggiungiInsieme($db, $intersezione);
    }
}

function prendiInsiemi($db) {
    $stmt = $db->prepare("SELECT insieme from insiemi");
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $insiemi = array();
    foreach($result as $r) {
        $insiemi[] = $r["insieme"];
    }
    return $insiemi;
}

function leggiInsieme($db, $insieme) {
    $stmt = $db->prepare("SELECT valore from insiemi WHERE insieme = ?");
    $stmt->bind_param("i", $insieme);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $valori = array();
    foreach($result as $r) {
        $valori[] = $r["valore"];
    }
    return $valori;
}

function aggiungiInsieme($db, $valori) {
    $newId = getMaxID($db) + 1;
    foreach($valori as $val) {
        $stmt = $db->prepare("INSERT INTO insiemi (valore, insieme) VALUES (?, ?)");
        $stmt->bind_param("ii", $val, $newId);
        $stmt->execute();
    }
}

function getMaxID($db) {
    $stmt = $db->prepare("SELECT insieme from insiemi ORDER BY insieme DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $result[0]["insieme"];
}
?>