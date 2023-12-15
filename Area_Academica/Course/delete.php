<?php
if (isset($_GET["idCourse"])) {
    $idCourse = $_GET["idCourse"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE course SET status = 0 WHERE idCourse = $idCourse";
    $connection->query($sql);
}

header("location: tableCourse.php");
exit;
?>