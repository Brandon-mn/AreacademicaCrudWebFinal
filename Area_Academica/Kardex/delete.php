<?php
if (isset($_GET["idKardex"])) {
    $idKardex = $_GET["idKardex"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE kardex SET status = 0 WHERE idKardex = $idKardex";
    $connection->query($sql);
}

header("location: tableKardex.php");
exit;
?>
