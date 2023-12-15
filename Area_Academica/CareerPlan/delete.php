<?php
if (isset($_GET["idCareerPlan"])) {
    $idCareerPlan = $_GET["idCareerPlan"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE careerplan SET status = 0 WHERE idCareerPlan = $idCareerPlan";
    $connection->query($sql);
}

header("location: tableCareerPlan.php");
exit;
?>