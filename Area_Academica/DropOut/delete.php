<?php
if (isset($_GET["idDropout"])) {
    $idDropout = $_GET["idDropout"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE dropout SET status = 0 WHERE idDropout = $idDropout";
    $connection->query($sql);
}

header("location: tableDropOut.php");
exit;
?>
