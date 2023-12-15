<?php
if (isset($_GET["idSubject"])) {
    $idSubject = $_GET["idSubject"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE subject SET status = 0 WHERE idSubject = $idSubject";
    $connection->query($sql);
}

header("location: tableSubject.php");
exit;
?>