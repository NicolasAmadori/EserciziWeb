<?php
$db = new mysqli("localhost", "root", "", "settembre", 3306);

$regista = (isset($_GET["regista"]) && is_numeric($_GET["regista"]) && $_GET["regista"] > 0) ? $_GET["regista"] : null;
$genere = (isset($_GET["genere"]) && is_numeric($_GET["genere"]) && $_GET["genere"] > 0) ? $_GET["genere"] : null;
$anno = (isset($_GET["anno"]) && is_numeric($_GET["anno"]) && $_GET["anno"] >= 1990 && $_GET["anno"] <= 2017) ? $_GET["anno"] : null;
$top = (isset($_GET["top"]) && is_numeric($_GET["top"]) && $_GET["top"] > 0) ? $_GET["top"] : null;
$minVoti = (isset($_GET["minVoti"]) && is_numeric($_GET["minVoti"]) && $_GET["minVoti"] > 0) ? $_GET["minVoti"] : null;

$film = getFilm($db, $regista, $genere, $anno, $top, $minVoti ? $minVoti : 100);

function getFilm($db, $regista, $genere, $anno, $top, $minVoti) {
    $parametri = [];
    $stringaParametri = "";
    $query = "SELECT *, ((numeroRecensioni / (numeroRecensioni + $minVoti)) * mediarecensioni + ($minVoti / (numeroRecensioni + $minVoti)) * (SELECT AVG(mediarecensioni) from film)) as rating FROM film";

    if($regista) {
        $query = $query." WHERE regista = ?";
        $stringaParametri = $stringaParametri."i";
        $parametri[] = $regista;
    }

    if($genere) {
        $query = $query." WHERE genere = ?";
        $stringaParametri = $stringaParametri."i";
        $parametri[] = $genere;
    }

    if($anno) {
        $query = $query." WHERE anno = ?";
        $stringaParametri = $stringaParametri."i";
        $parametri[] = $anno;
    }

    $query = $query." ORDER BY rating";

    if($top) {
        $query = $query." LIMIT ?";
        $stringaParametri = $stringaParametri."i";
        $parametri[] = $top;
    }

    $stmt = $db->prepare($query);
    if(count($parametri) > 0) {
        $stmt->bind_param($stringaParametri, ...$parametri);
    }
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE>
<html>
    <head>
        <title>Esame</title>
    </head>
    <body>
        <ol>
            <?php foreach($film as $f): ?>
                <li><?php echo $f["id"]." ".$f["titolo"]." ".$f["rating"] ?></li>
            <?php endforeach; ?>
        </ol>
    </body>
</html>