<?php
if (isset($_GET["idStudent"])) {
    $idStudent = $_GET["idStudent"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE student SET status = 0 WHERE idStudent = $idStudent";
    $connection->query($sql);
}

header("location: tableStudent.php");
exit;
?>