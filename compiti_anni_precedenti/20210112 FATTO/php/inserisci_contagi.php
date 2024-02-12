<?php 
if(!isset($_SESSION)) {
    session_start();
}

if(isset($_GET["data"]) && isset($_GET["contagi"])) {
    $data = $_GET["data"];
    $contagi = $_GET["contagi"];
    if(date_create_from_format("m-d-Y", $data)) {
        $month = (int)explode("-",$data)[0];
        $day = (int)explode("-",$data)[1];
        $year = (int)explode("-",$data)[2];
        if(checkdate($month, $day, $year)) {
            $_SESSION[$data] = $contagi;
            echo "Informazioni inserite!";
        }
        else {
            echo "Errore Data non valida!";
        }
    }
    else {
        echo "Errore Formato data non valido!";
    }
}
?>