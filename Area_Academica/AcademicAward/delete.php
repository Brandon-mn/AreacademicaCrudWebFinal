<?php 

include("../conexion.php");

if (isset($_GET['idPosition'])) {
    $idPosition = (isset($_GET['idPosition']) ? $_GET['idPosition'] : "");

    $stm = $conexion->prepare("UPDATE Position SET status = 0 WHERE idPosition = :idPosition");
    $stm->bindParam(":idPosition", $idPosition);
    $stm->execute();
}

header("Location: index.php"); 
exit();
?>
