<?php
if (isset($_GET["idTeacherEvaluation"])) {
    $idTeacherEvaluation = $_GET["idTeacherEvaluation"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE TeacherEvaluation SET status = 0 WHERE idTeacherEvaluation = $idTeacherEvaluation";
    $connection->query($sql);
}

header("location: /web/Area_Academica/TeacherEvaluation/tableTeacherEvaluation.php");
exit;
?>