<?php
if(isset($_GET["idPosition"])) {
    $idPosition = $_GET["idPosition"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE position SET status = 0 WHERE idPosition = $idPosition";
    $connection->query($sql);
}

header("location: tablePosition.php");

exit;
?>
