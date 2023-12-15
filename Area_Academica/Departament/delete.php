<?php 

include("../conexion.php");

if (isset($_GET['idExternalPayment'])) {
    $txtid=(isset($_GET['idExternalPayment'])?$_GET['idExternalPayment']:"");
    $stm=$conexion->prepare("UPDATE externalpayment SET status= 0 WHERE idExternalPayment=:txtid");
    $stm->bindparam(":txtid",$txtid);
    $stm->execute();
    $registro=$stm->fetch(PDO::FETCH_LAZY);
}
header("Location:index.php"); 

  ?>