<?php
if (isset($_GET["idEvent"])) {
    $idEvent = $_GET["idEvent"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE event SET status = 0 WHERE idEvent = $idEvent";
    $connection->query($sql);
}

header("location: tableEvent.php");
exit;
?>