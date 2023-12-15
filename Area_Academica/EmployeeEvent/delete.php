<?php
if (isset($_GET["idEmployeeEvent"])) {
    $idEmployeeEvent = $_GET["idEmployeeEvent"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE employeeevent SET status = 0 WHERE idEmployeeEvent = $idEmployeeEvent";
    $connection->query($sql);
}

header("location: tableEmployeeEvent.php");
exit;
?>