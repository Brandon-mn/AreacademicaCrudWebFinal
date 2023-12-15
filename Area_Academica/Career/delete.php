<?php
if (isset($_GET["idCareer"])) {
    $idCareer = $_GET["idCareer"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE career SET status = 0 WHERE idCareer = $idCareer";
    $connection->query($sql);
}

header("location: tableCareer.php");
exit;
?>