<?php
if (isset($_GET["idEmployee"])) {
    $idEmployee = $_GET["idEmployee"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE employee SET status = 0 WHERE idEmployee = $idEmployee";
    $connection->query($sql);
}

header("location: tableEmployee.php");
exit;
?>
