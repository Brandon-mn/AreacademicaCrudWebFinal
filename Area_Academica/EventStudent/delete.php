<?php
if (isset($_GET["idEventStudent"])) {
    $idEventStudent = $_GET["idEventStudent"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE eventstudent SET status = 0 WHERE idEventStudent = $idEventStudent";
    $connection->query($sql);
}

header("location: tableEventStudent.php");
exit;
?>
