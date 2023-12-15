<?php
if (isset($_GET["idPlan"])) {
    $idPlan = $_GET["idPlan"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE studyplan SET status = 0 WHERE idPlan = $idPlan";
    $connection->query($sql);
}

header("location: tableStudyPlan.php");
exit;
?>