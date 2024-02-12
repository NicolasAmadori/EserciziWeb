<?php 
if(!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Esame</title>
    </head>
    <body>
        <ul>
            <?php foreach($_SESSION as $key=>$value): ?>
                <li><?php echo $key." - ".$value ?></li>
            <?php endforeach; ?>
        </ul>
    </body>
</html>