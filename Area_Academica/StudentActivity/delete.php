<?php
if (isset($_GET["idStudentActivity"])) {
    $idStudentActivity = $_GET["idStudentActivity"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE studentactivity SET status = 0 WHERE idStudentActivity = $idStudentActivity";
    $connection->query($sql);
}

header("location: tableStudentActivity.php");
exit;
?>