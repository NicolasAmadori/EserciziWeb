<?php

$db = new mysqli("localhost", "root", "", "matematica", 3306);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if(isset($_GET["sequenza"])) {
    $sequenza = $_GET["sequenza"];
    if(validate($db, $sequenza)) {
        $numeri = getNumbers($db, $sequenza);
        $vettore = array();
        foreach($numeri as $num) {
            $vettore[] = $num["numero"];
        }
        echo controllaFibonacci($vettore);
    }
}

function validate($db, $sequenza) {
    if(is_numeric($sequenza) && $sequenza > 0) {
        $stmt = $db->prepare("SELECT * FROM numeri WHERE sequenza=?");
        $stmt->bind_param('i',$sequenza);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }
    return false;
}

function getNumbers($db, $sequenza) {
    $stmt = $db->prepare("SELECT numero FROM numeri WHERE sequenza=? ORDER BY ordine");
    $stmt->bind_param("i", $sequenza);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function controllaFibonacci($numeri) {
    $ok = true;
    $precprec = 1;
    $prec = 1;
    foreach($numeri as $i=>$numero) {
        if($ok) {
            if($i < 2 && $numero != 1) {
                $ok = false;
            }
            else if($i >= 2) {
                if($numero != $precprec + $prec) { 
                    $ok = false;
                }
                else {
                    $precprec = $prec;
                    $prec = $numero;
                }
            }
        }
    }

    $result = array(
        "risultato" => $ok ? 1 : 0,
        "sequenza" => $numeri
    );
    return json_encode($result);
}
?>