<?php
if (isset($_GET["idDetailClass"])) {
    $idDetailClass = $_GET["idDetailClass"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE DetailClass SET status = 0 WHERE idDetailClass = $idDetailClass";
    $connection->query($sql);
}

header("location: tableDetailClass.php");
exit;
?>
