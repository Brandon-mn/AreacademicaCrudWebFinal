<?php
if (isset($_GET["idDegreeRequirements"])) {
    $idDegreeRequirements = $_GET["idDegreeRequirements"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE DegreeRequirements SET status = 0 WHERE idDegreeRequirements = $idDegreeRequirements";
    $connection->query($sql);
}

header("location: tableDegreeRequirments.php");
exit;
?>
