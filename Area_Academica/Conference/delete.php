<?php
if (isset($_GET["idConference"])) {
    $idConference = $_GET["idConference"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE conference SET status = 0 WHERE idConference = $idConference";
    $connection->query($sql);
}

header("location: tableConference.php");
exit;
?>