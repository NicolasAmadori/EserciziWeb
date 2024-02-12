<?php 
if(!isset($_SESSION)) {
    session_start();
}

if(isset($_GET["data"])) {
    $data = $_GET["data"];
    if(isset($_SESSION[$data])) {
        unset($_SESSION[$data]);
    }
    else {
        echo "Errore! Data non presente!";
    }
}
?>