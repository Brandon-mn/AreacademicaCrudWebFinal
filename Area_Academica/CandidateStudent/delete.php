<?php
if (isset($_GET["idCandidateStudent"])) {
    $idCandidateStudent = $_GET["idCandidateStudent"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE candidatestudent SET status = 0 WHERE idCandidateStudent = $idCandidateStudent";
    $connection->query($sql);
}

header("location: tableCandidateStudent.php");
exit;
?>
