<?php
if (isset($_GET["idClassroom"])) {
    $idClassroom = $_GET["idClassroom"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE classroom SET status = 0 WHERE idClassroom = $idClassroom";
    $connection->query($sql);
}

header("location: tableClassroom.php");
exit;
?>