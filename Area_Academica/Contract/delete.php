<?php
if (isset($_GET["idApplication"])) {
    $idApplication = $_GET["idApplication"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE application SET status = 0 WHERE idApplication = $idApplication";
    $connection->query($sql);
}

header("location: tableApplication.php");
exit;
?>
