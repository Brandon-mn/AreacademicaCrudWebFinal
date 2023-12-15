<?php
if (isset($_GET["idServicePayment"])) {
    $idServicePayment = $_GET["idServicePayment"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "areaacademicabn";
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "UPDATE servicepayment SET status = 0 WHERE idServicePayment = $idServicePayment";
    $connection->query($sql);
}

header("location: tableServicePayment.php");
exit;
?>
