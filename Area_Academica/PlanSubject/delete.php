<?php
if (isset($_GET["idPlanSubject"])) {
    $idPlanSubject = $_GET["idPlanSubject"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE plansubject SET status = 0 WHERE idPlanSubject = $idPlanSubject";
    $connection->query($sql);
}

header("location: tablePlanSubject.php");
exit;
?>

