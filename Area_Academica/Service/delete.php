<?php
if (isset($_GET["idService"])) {
    $idService = $_GET["idService"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE service SET status = 0 WHERE idService = $idService";
    $connection->query($sql);
}

header("location: tableService.php");
exit;
?>
