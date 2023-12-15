<?php
if (isset($_GET["idClass"])) {
    $idClass = $_GET["idClass"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE class SET status = 0 WHERE idClass = $idClass";
    $connection->query($sql);
}

header("location: tableClass.php");
exit;
?>
