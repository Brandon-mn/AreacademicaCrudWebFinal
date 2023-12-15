<?php
if (isset($_GET["idGroup"])) {
    $idGroup = $_GET["idGroup"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE groupp SET status = 0 WHERE idGroup = $idGroup";
    $connection->query($sql);
}

header("location: tableGroupp.php");
exit;
?>